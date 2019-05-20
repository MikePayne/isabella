<?php

/* 
 * ALWAYS STICKY
 */
function ubermenu_get_menu_style_sticky_permanent( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val == 'on' ){
		$top = ubermenu_op( 'sticky_offset' , $menu_id );

		if( $top == '' ) $top = 0;
		else if( is_numeric( $top ) ) $top.='px';

		$selector = ".ubermenu-$menu_id, .ubermenu-responsive-toggle-$menu_id";		
		$menu_styles[$selector]['position'] = 'fixed';
		$menu_styles[$selector]['top'] = $top;

	}
}

/* 
 * STICKY OFFSET
 */
function ubermenu_get_menu_style_sticky_offset( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){
		if( is_numeric( $val ) ){
			$val = $val.='px';
		}
		$selector = ".ubermenu-$menu_id.ubermenu-sticky";		
		$menu_styles[$selector]['top'] = $val;
		//$menu_styles[$selector]['margin-top'] = $val;
	}
}

/* 
 * STICKY INNER CENTER
 */
function ubermenu_get_menu_style_sticky_center_inner_width( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){
		if( is_numeric( $val ) ){
			$val = $val.='px';
		}
		$selector = ".ubermenu-$menu_id.ubermenu-sticky .ubermenu-nav";		
		$menu_styles[$selector]['width'] = $val;
		$menu_styles[$selector]['max-width'] = '100%';
		$menu_styles[$selector]['margin'] = '0 auto';
		$menu_styles[$selector]['float'] = 'none';
		//$menu_styles[$selector]['margin-top'] = $val;
	}
}

/* 
 * STICKY BOUND SUBMENUS
 */
function ubermenu_get_menu_style_sticky_bound_submenus( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val == 'on' ){
		$selector = ".ubermenu-$menu_id.ubermenu-sticky .ubermenu-nav";		
		$menu_styles[$selector]['position'] = 'relative';
		//$menu_styles[$selector]['margin-top'] = $val;
	}
}

/* 
 * STICKY CLEARFIX
 */
function ubermenu_get_menu_style_sticky_clearfix( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val == 'on' ){
		$selector = ".ubermenu-$menu_id";		
		$menu_styles[$selector]['clear'] = 'both';
	}
}

/* 
 * STICKY BACKGROUND COLOR
 */
function ubermenu_get_menu_style_sticky_background_color( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){
		$selector = ".ubermenu-$menu_id.ubermenu-sticky";		
		$menu_styles[$selector]['background'] = $val;
		//$menu_styles[$selector]['margin-top'] = $val;
	}
}

/* 
 * STICKY TOGGLE COLOR
 */
function ubermenu_get_menu_style_sticky_toggle_color( $field , $menu_id , &$menu_styles ){

	$val = ubermenu_op( $field['name'] , $menu_id );
	if( $val ){
		$selector = ".ubermenu-responsive-toggle-$menu_id.ubermenu-sticky";		
		$menu_styles[$selector]['background'] = $val;
		//$menu_styles[$selector]['margin-top'] = $val;
	}
}