/**
 * @namespace WPGMZA
 * @module ProMarker
 * @requires WPGMZA.Marker
 */
jQuery(function($) {
	
	WPGMZA.ProMarker = function(row)
	{
		var self = this;
		
		this.title = "";
		this.description = "";
		this.categories = [];
		this.approved = 1;
		
		if(row && row.category && row.category.length)
		{
			var m = row.category.match(/\d+/g);
			
			if(m)
				this.categories = m;
		}
		
		WPGMZA.Marker.call(this, row);
	}
	
	WPGMZA.ProMarker.prototype = Object.create(WPGMZA.Marker.prototype);
	WPGMZA.ProMarker.prototype.constructor = WPGMZA.ProMarker;
	
	WPGMZA.ProMarker.prototype.onAdded = function(event)
	{
		WPGMZA.Marker.prototype.onAdded.call(this, event);
		
		this.updateIcon();
	}
	
	WPGMZA.ProMarker.prototype.getIcon = function()
	{
		if(this.icon && this.icon.length || (window.google && this.icon instanceof google.maps.MarkerImage))
			return this.icon;
		
		var categoryIcon = this.getIconFromCategory();
		if(categoryIcon)
			return categoryIcon;
		
		var defaultIcon = this.map.settings.upload_default_marker;
		if(defaultIcon && defaultIcon.length)
			return defaultIcon;
		
		return WPGMZA.Marker.prototype.getIcon.call(this);
	}
	
	WPGMZA.ProMarker.prototype.getIconFromCategory = function()
	{
		if(!this.categories.length)
			return;
		
		var self = this;
		var categoryIDs = this.categories.slice();
		
		// TODO: This could be taken from the category table now that it's cached. Would take some load off the client
		categoryIDs.sort(function(a, b) {
			var categoryA = self.map.getCategoryByID(a);
			var categoryB = self.map.getCategoryByID(b);
			
			if(!categoryA || !categoryB)
				return null;	// One of the category IDs is invalid
			
			return (categoryA.depth < categoryB.depth ? -1 : 1);
		});
		
		for(var i = 0; i < categoryIDs.length; i++)
		{
			var category = this.map.getCategoryByID(categoryIDs[i]);
			if(!category)
				continue;	// Invalid category ID
			
			var icon = category.icon;
			if(icon && icon.length)
				return icon;
		}
	}
	
	WPGMZA.ProMarker.prototype.setIcon = function(icon)
	{
		this.icon = icon;
		this.updateIcon();
	}
	
	WPGMZA.ProMarker.prototype.toJSON = function()
	{
		var result = WPGMZA.Marker.prototype.toJSON.call(this);
		
		// This block will only set the categories in if the user hasn't selected all. If they have, no categories are sent as no selection means bypass category logic
		if(this.categories.length != this.map.categories.length)
			result.categories = this.categories.slice();
		
		return result;
	}
	
});