/**
 * @namespace WPGMZA
 * @module GoogleProInfoWindow
 * @requires WPGMZA.GoogleInfoWindow
 */
jQuery(function($) {

	WPGMZA.GoogleProInfoWindow = function(mapObject)
	{
		WPGMZA.GoogleInfoWindow.call(this, mapObject);
	}
	
	WPGMZA.GoogleProInfoWindow.prototype = Object.create(WPGMZA.GoogleInfoWindow.prototype);
	WPGMZA.GoogleProInfoWindow.prototype.constructor = WPGMZA.GoogleProInfoWindow;

	WPGMZA.GoogleProInfoWindow.prototype.open = function(map, mapObject)
	{
		this.mapObject = mapObject;
		
		var style = this.getSelectedStyle();
		
		switch(String(style))
		{
			case WPGMZA.ProInfoWindow.STYLE_MODERN:
			case WPGMZA.ProInfoWindow.STYLE_MODERN_PLUS:
			case WPGMZA.ProInfoWindow.STYLE_MODERN_CIRCULAR:
			case WPGMZA.ProInfoWindow.STYLE_TEMPLATE:
				return WPGMZA.ProInfoWindow.prototype.open.call(this);
				break;
			
			default:
				return WPGMZA.GoogleInfoWindow.prototype.open.call(this, map, mapObject);
				break;
		}
	}
		
});