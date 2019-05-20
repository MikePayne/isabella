/**
 * @namespace WPGMZA
 * @module ProInfoWindow
 * @requires WPGMZA.InfoWindow
 */
jQuery(function($) {
	
	WPGMZA.ProInfoWindow = function(mapObject)
	{
		WPGMZA.InfoWindow.call(this, mapObject);
	}
	
	WPGMZA.ProInfoWindow.prototype = Object.create(WPGMZA.InfoWindow.prototype);
	WPGMZA.ProInfoWindow.prototype.constructor = WPGMZA.ProInfoWindow;
	
	WPGMZA.ProInfoWindow.STYLE_INHERIT			= "-1";
	WPGMZA.ProInfoWindow.STYLE_NATIVE_GOOGLE	= "0";
	WPGMZA.ProInfoWindow.STYLE_MODERN			= "1";
	WPGMZA.ProInfoWindow.STYLE_MODERN_PLUS		= "2";
	WPGMZA.ProInfoWindow.STYLE_MODERN_CIRCULAR	= "3";
	WPGMZA.ProInfoWindow.STYLE_TEMPLATE			= "template";
	
	WPGMZA.ProInfoWindow.prototype.getSelectedStyle = function()
	{
		var globalTypeSetting = WPGMZA.settings.wpgmza_iw_type;
		var localTypeSetting = this.mapObject.map.settings.wpgmza_iw_type;
		var type = localTypeSetting;
		
		if(localTypeSetting == WPGMZA.ProInfoWindow.STYLE_INHERIT ||
			typeof localTypeSetting == "undefined")
			type = globalTypeSetting;
			
		return type;
	}
	
	WPGMZA.ProInfoWindow.prototype.open = function(map, mapObject)
	{
		var self = this;
		
		if(!WPGMZA.InfoWindow.prototype.open.call(this, map, mapObject))
			return false;
		
		/*var style = map.getInfoWindowStyle();
		
		if(style != WPGMZA.ProInfoWindow.STYLE_NATIVE_GOOGLE)
			return;
		
		if(!WPGMZA.InfoWindow.prototype.open.call(this, map, mapObject))
			return false;
		
		var style = this.getSelectedStyle();*/
		
		/*switch(String(style))
		{
			case WPGMZA.ProInfoWindow.STYLE_MODERN:
			case WPGMZA.ProInfoWindow.STYLE_MODERN_PLUS:
			case WPGMZA.ProInfoWindow.STYLE_MODERN_CIRCULAR:
			case WPGMZA.ProInfoWindow.STYLE_TEMPLATE:
				var mapContainer = $(this.mapObject.map.element).find(".wpgmza-engine-map");
				var container;
				
				if(!mapContainer.find(".wpgmza-pro-info-window-container").length)
				{
					container = $("<div class='wpgmza-pro-info-window-container'/>");
					mapContainer.append(container);
				}
				else
					container = mapContainer.find(".wpgmza-pro-info-window-container");
				
				this.getContent(function(html) {
					$(container).html(html);
					
					self.dispatchEvent("infowindowopen");
					$(container).trigger("infowindowopen");
				});
				
				break;
			
			default:
				WPGMZA.InfoWindow.prototype.open.call(this, event);
				break;
		}*/
		
		return true;
	}
	
	// TODO: This doesn't appear to do anything, nor does it call the parent method
	WPGMZA.ProInfoWindow.prototype.close = function()
	{
		$(this.mapObject.map.element).find(".wpgmza-pro-info-window-container").html();
	}
	
	// TODO: This should be taken care of already in core.js
	$(document).ready(function(event) {
		$(document.body).on("click", ".wpgmza-close-info-window", function(event) {
			$(event.target).closest(".wpgmza-info-window").remove();
		});
	});
	
});