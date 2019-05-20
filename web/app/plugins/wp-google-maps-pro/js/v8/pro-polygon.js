/**
 * @namespace WPGMZA
 * @module ProPolygon
 * @requires WPGMZA.Polygon
 */
jQuery(function($) {
	
	WPGMZA.ProPolygon = function(row, googlePolygon)
	{
		WPGMZA.Polygon.call(this, row, googlePolygon);
	}
	
	WPGMZA.ProPolygon.prototype = Object.create(WPGMZA.Polygon.prototype);
	WPGMZA.ProPolygon.prototype.constructor = WPGMZA.ProPolygon;	
	
});