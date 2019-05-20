/**
 * @namespace WPGMZA
 * @module ProMap
 * @requires WPGMZA.Map
 */
jQuery(function($) {
	
	WPGMZA.ProMap = function(element, options)
	{
		var self = this;
		
		// Some objects created in the parent constructor use the category data, so load that first
		this.element = element;
		
		// Call the parent constructor
		WPGMZA.Map.call(this, element, options);
		
		this.heatmaps = [];
	}
	
	WPGMZA.ProMap.prototype = Object.create(WPGMZA.Map.prototype);
	WPGMZA.ProMap.prototype.constructor = WPGMZA.ProMap;
	
	WPGMZA.ProMap.prototype.getMapObjectArrays = function()
	{
		var arrays = WPGMZA.Map.prototype.getMapObjectArrays.call(this);
		
		arrays.heatmaps = this.heatmaps;
		
		return arrays;
	}
	
	/**
	 * Adds the specified heatmap to the map
	 * @return void
	 */
	WPGMZA.ProMap.prototype.addHeatmap = function(heatmap)
	{
		if(!(heatmap instanceof WPGMZA.Heatmap))
			throw new Error("Argument must be an instance of WPGMZA.Heatmap");
		
		heatmap.map = this;
		
		this.heatmaps.push(heatmap);
		this.dispatchEvent({type: "heatmapadded", heatmap: heatmap});
	}
	
	/**
	 * Gets a heatmap by ID
	 * @return void
	 */
	WPGMZA.ProMap.prototype.getHeatmapByID = function(id)
	{
		for(var i = 0; i < this.heatmaps.length; i++)
			if(this.heatmaps[i].id == id)
				return this.heatmaps[i];
			
		return null;
	}
	
	/**
	 * Removes the specified heatmap and fires an event
	 * @return void
	 */
	WPGMZA.ProMap.prototype.removeHeatmap = function(heatmap)
	{
		if(!(heatmap instanceof WPGMZA.Heatmap))
			throw new Error("Argument must be an instance of WPGMZA.Heatmap");
		
		if(heatmap.map != this)
			throw new Error("Wrong map error");
		
		heatmap.map = null;
		
		// TODO: This shoud not be here in the generic class
		heatmap.googleHeatmap.setMap(null);
		
		this.heatmaps.splice(this.heatmaps.indexOf(heatmap), 1);
		this.dispatchEvent({type: "heatmapremoved", heatmap: heatmap});
	}
	
	/**
	 * Removes the specified heatmap and fires an event
	 * @return void
	 */
	WPGMZA.ProMap.prototype.removeHeatmapByID = function(id)
	{
		var heatmap = this.getHeatmapByID(id);
		
		if(!heatmap)
			return;
		
		this.removeHeatmap(heatmap);
	}
	
	WPGMZA.ProMap.prototype.getInfoWindowStyle = function()
	{
		if(!this.settings.other_settings)
			return WPGMZA.ProInfoWindow.STYLE_NATIVE_GOOGLE;
		
		var local = this.settings.other_settings.wpgmza_iw_type;
		var global = WPGMZA.settings.wpgmza_iw_type;
		
		if(local == "-1" && global == "-1")
			return WPGMZA.ProInfoWindow.STYLE_NATIVE_GOOGLE;
		
		if(local == "-1")
			return global;
		
		if(local)
			return local;
		
		return WPGMZA.ProInfoWindow.STYLE_NATIVE_GOOGLE;
	}
	
});