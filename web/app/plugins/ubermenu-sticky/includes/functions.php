<?php

add_filter( 'ubermenu_nav_menu_args' , 'ubermenu_sticky_nav_menu_args' , 20 , 2 );
function ubermenu_sticky_nav_menu_args( $args , $config_id ){

	if( ubermenu_op( 'sticky_permanent' , $config_id ) == 'on' ){
		
		$args['container_class'].= ' ubermenu-sticky';

		if( ubermenu_op( 'sticky_full_width' , $config_id ) == 'on' ){
			$args['container_class'].= ' ubermenu-sticky-full-width';
		}
	}
	return $args;
}

add_filter( 'ubermenu_toggle_class' , 'ubermenu_sticky_toggle_class' , 20 , 2 );
function ubermenu_sticky_toggle_class( $class , $config_id ){
	if( ubermenu_op( 'sticky_permanent' , $config_id ) == 'on' ){
		$class.= ' ubermenu-sticky';
	}
	return $class;
}

add_filter( 'ubermenu_settings_subsections' , 'ubermenu_settings_subsection_sticky' , 50 , 1 );
function ubermenu_settings_subsection_sticky( $subsections ){
	$subsections['sticky'] = array(
		'title'	=> __( 'Sticky' ),
	);
	return $subsections;
}
add_filter( 'ubermenu_general_settings_sections' , 'ubermenu_general_settings_subsection_sticky' , 50 , 1 );
function ubermenu_general_settings_subsection_sticky( $section ){
	$section['sub_sections']['sticky'] = array(
		'title'	=> __( 'Sticky' ),
	);
	return $section;
}

add_filter( 'ubermenu_instance_settings' , 'ubermenu_sticky_instance_settings_fields' , 50 , 2 );
function ubermenu_sticky_instance_settings_fields( $fields , $config_id ){

	$menus = ubermenu_get_menu_instances( true );

	$fields[1200] = array(
		'name'	=> 'sticky_header',
		'label'	=> __( 'Sticky Extension' , 'ubermenu' ),
		'type'	=> 'header',
		'group'	=> 'sticky',
	);

	$fields[1210] = array(
		'name'	=> 'sticky_enabled',
		'label'	=> __( 'Enable Sticky Menu' , 'ubermenu' ),
		'desc'	=> __( 'Stick this menu in place when it leaves the viewport' , 'ubermenu' ) , 
		'type'	=> 'checkbox',
		'default'	=> $config_id == 'main' ? 'on' : 'off',
		'group'	=> 'sticky'
	);

	$fields[1220] = array(
		'name'	=> 'sticky_offset',
		'label'	=> __( 'Top Offset' , 'ubermenu' ),
		'desc'	=> __( 'Pixel difference from the top of the viewport to place the fixed menu.  Should be less than or equal to the natural offset of the menu.' , 'ubermenu' ),
		'type'	=> 'text',
		'group'	=> 'sticky',
		'custom_style' => 'sticky_offset',
	);

	$fields[1230] = array(
		'name'	=> 'sticky_full_width',
		'label'	=> __( 'Full Width Sticky Menu Bar' , 'ubermenu' ),
		'desc'	=> __( 'Expand the menu bar to the full width of the viewport when in sticky mode.' , 'ubermenu' ) , 
		'type'	=> 'checkbox',
		'default'	=> 'off',
		'group'	=> 'sticky'
	);

	$fields[1240] = array(
		'name'	=> 'sticky_clearfix',
		'label'	=> __( 'Enable Clearfix' , 'ubermenu' ),
		'desc'	=> __( 'If your menu immediately gets stuck to the top of your viewport even before you scroll, the most likely issue is that your theme\'s header needs to be properly cleared, as the elements may be absolutely positioned.  Enable this option to clear the menu and keep it in place until you scroll.' , 'ubermenu' ) , 
		'type'	=> 'checkbox',
		'default'	=> 'off',
		'group'	=> 'sticky',
		'custom_style'	=> 'sticky_clearfix',
	);

	$fields[1250] = array(
		'name'	=> 'sticky_center_inner_width',
		'label'	=> __( 'Center Inner Menu Width' , 'ubermenu' ),
		'desc'	=> __( 'If you enable "Full Width Sticky Menu Bar", but want the menu items to remain centered, set the width of the inner menu bar here (usually 940-960px for an average theme)' , 'ubermenu' ),
		'type'	=> 'text',
		'group'	=> 'sticky',
		'custom_style' => 'sticky_center_inner_width',
	);

	$fields[1255] = array(
		'name'	=> 'sticky_bound_submenus',
		'label'	=> __( 'Bound Submenu to Inner Width' , 'ubermenu' ),
		'desc'	=> __( 'Enable this if you want your submenu to stay the same width as your menu bar' , 'ubermenu' ),
		'type'	=> 'checkbox',
		'default' => 'off',
		'group'	=> 'sticky',
		'custom_style' => 'sticky_bound_submenus',
	);


	$fields[1260] = array(
		'name'	=> 'sticky_background_color',
		'label'	=> __( 'Sticky Menu Bar Background' , 'ubermenu' ),
		'desc'	=> __( 'If you have a transparent menu bar, you may want to set a color for when the menu scrolls.' , 'ubermenu' ),
		'type'	=> 'color',
		'group'	=> 'sticky',
		'custom_style'	=> 'sticky_background_color',
	);


	$fields[1261] = array(
		'name'	=> 'sticky_toggle_background_color',
		'label'	=> __( 'Sticky Responsive Toggle Background' , 'ubermenu' ),
		'desc'	=> __( 'If you have a transparent toggle, you may want to set a color for when the menu scrolls.' , 'ubermenu' ),
		'type'	=> 'color',
		'group'	=> 'sticky',
		'custom_style'	=> 'sticky_toggle_color',
	);


	




	$fields[1280] = array(
		'name'	=> 'sticky_header_advanced',
		'label'	=> __( 'Advanced Sticky' , 'ubermenu' ),
		'desc'	=> __( 'Advanced Sticky Settings - use with caution', 'ubermenu' ),
		'type'	=> 'header',
		'group'	=> 'sticky',
	);

	$fields[1290] = array(
		'name'	=> 'sticky_mobile',
		'label'	=> __( 'Stick on Mobile Devices' , 'ubermenu' ),
		'desc'	=> __( 'EXPERIMENTAL.  (Tip: If you need a robust sticky mobile menu, check out <a href="http://shiftnav.io">ShiftNav</a>).  Makes the menu full height and scrollable when in sticky mode.  Tested in iOS Safari and Android Chrome & Stock browsers, this setting will make your menu sticky on mobile devices and attempt to make any hidden content accessible via overflow touch scrolling.  Note that the iOS implementation of overflow scrolling seems to be much smoother than Android\'s, which can be unreliable at times.  Overall, mobile browser support for fixed-element overflow touch scrolling is still lacking.  Therefore, <strong>use at your own risk.  This is an experimental feature and may not work with all sites.</strong>  If not working as expected on your site, simply disable.' , 'ubermenu' ),
		'type'	=> 'checkbox',
		'default'	=> 'off',
		'group'	=> 'sticky',
	);

	$fields[1300] = array(
		'name'	=> 'sticky_permanent',
		'label'	=> __( 'Always Sticky' , 'ubermenu' ),
		'desc'	=> __( 'Always stick the menu to the top of the page without scrolling.  If you use this option, you will likely want to manually add some padding/margin to your site container, and a max-width on the .ubermenu element if you are not expanding the menu full width.  Keep in mind that features like the special classes will no longer work as intended since this feature disables the javascript component of the extension.  Centering will be controlled through the core UberMenu options, not the Sticky-specific options.  Not recommended for use when <strong>Stick on Mobile Devices</strong>' , 'ubermenu' ),
		'type'	=> 'checkbox',
		'default'	=> 'off',
		'group'	=> 'sticky',
		'custom_style'	=> 'sticky_permanent',
	);

	


	$fields[1320] = array(
		'name'	=> 'sticky_apply_to',
		'label'	=> __( 'Apply Sticky To' , 'ubermenu' ),
		'desc'	=> __( 'Apply UberMenu Sticky only to this post ID (leave blank to apply to all)' , 'ubermenu' ) , 
		'type'	=> 'text',
		'group'	=> 'sticky'
	);

	return $fields;
}

add_filter( 'ubermenu_settings_panel_fields' , 'ubermenu_sticky_settings_fields' , 50 );
function ubermenu_sticky_settings_fields( $fields ){

	$fields[UBERMENU_PREFIX.'general'][400] = array(
		'name'	=> 'sticky_toolbar_footer',
		'label'	=> __( 'Sticky Footer Admin Toolbar' , 'ubermenu' ),
		'desc'	=> __( 'If your menu is stuck at the top of the window, it may get blocked by the WP Admin Bar.  Swap it to the bottom.' , 'ubermenu' ) , 
		'type'	=> 'checkbox',
		'default'	=> 'off',
		'group'	=> 'sticky'
	);

	$fields[UBERMENU_PREFIX.'general'][410] = array(
			'name'	=> 'sticky_disable_css',
			'label'	=> __( 'Disable CSS' , 'ubermenu' ),
			'desc'	=> __( 'Enable this option to prevent UberMenu Sticky from inserting CSS in your site head.  If you do this, you\'ll need to include this CSS elsewhere in order for UberMenu Sticky to function' , 'ubermenu' ) , 
			'type'	=> 'checkbox',
			'default'	=> 'off',
			'group'	=> 'sticky'
		);

	return $fields;
}


	/*


	$settings->addTextInput( $sticky_ops,
			'ubersticky-scroll-context',
			'Scroll Context',
			'For 99% of themes you will leave this blank, however, if your scroll pane is an HTML '.
				'element rather than the window, set its selector here - for example "#content"',
			''
			);

*/



add_action( 'wp' , 'ubermenu_sticky_load_assets' );
function ubermenu_sticky_load_assets(){

	if( UM_STICKY()->sticky_apply() ){

		if( SCRIPT_DEBUG ){
			wp_enqueue_script( 'ubermenu-sticky-js' , UM_STICKY_PLUGIN_URL.'assets/ubermenu.sticky.js', array( 'jquery' , 'ubermenu' ), UM_STICKY_VERSION, true );
		}
		else{
			wp_enqueue_script( 'ubermenu-sticky-js' , UM_STICKY_PLUGIN_URL.'assets/ubermenu.sticky.min.js', array( 'jquery' , 'ubermenu' ), UM_STICKY_VERSION, true );
		}

		$menus = ubermenu_get_menu_instances( true );
		$settings = array();

		foreach( $menus as $config_id ){

			if( UM_STICKY()->sticky_apply( $config_id ) ){

				$is_sticky = 1;
				if( wp_is_mobile() && ubermenu_op( 'sticky_mobile' , $config_id ) != 'on' ){
					$is_sticky = 0;
				}

				$is_permanent = ubermenu_op( 'sticky_permanent' , $config_id ) == 'on' ? 1 : 0;
				if( $is_permanent == 1 ){
					$is_sticky = 1;
				}

				//$mid = UBERMENU_PREFIX.$config_id;
				$settings[$config_id] = array(
						'full_width_menu_bar'	=> ubermenu_op( 'sticky_full_width' , $config_id ),
						'center_inner_width'	=> ubermenu_op( 'sticky_center_inner_width' , $config_id ),
						'offset'				=> ubermenu_op( 'sticky_offset' , $config_id ),
						'mobile'				=> ubermenu_op( 'sticky_mobile' , $config_id ),
						'sticky_offset'			=> ubermenu_op( 'sticky_offset' , $config_id ),
						'is_sticky'				=> $is_sticky,
						'permanent'				=> $is_permanent,
						'is_mobile'				=> wp_is_mobile() ? 1 : 0,
						//'sticky_clearfix'		=> ubermenu_op( 'sticky_clearfix' , $config_id ),
						//'scroll_context' 	=> $settings->op( 'ubersticky-scroll-context' )
					);


					

				//}	
			}
		}

		wp_localize_script( 'ubermenu-sticky-js', 'ubermenu_sticky_settings', $settings );
	}
}

add_filter( 'ubermenu_custom_styles' , 'ubermenu_sticky_custom_styles' );
function ubermenu_sticky_custom_styles( $styles ){

	if( ubermenu_op( 'sticky_disable_css' , 'general' ) == 'on' ){
		return $styles;
	}

	if( UM_STICKY()->sticky_apply() ){


		$css = '';

		$css.= "\n/** UberMenu Sticky CSS **/\n";

		$css.= ".ubermenu.ubermenu-sticky, .ubermenu-responsive-toggle.ubermenu-sticky{ z-index:1000; margin-top:0; }";

		$css.= ".ubermenu-sticky.ubermenu-sticky-full-width{ left:0; width:100%; max-width:100%; }\n";
		$css.= ".ubermenu-sticky-full-width.ubermenu-sticky .ubermenu-nav{ padding-left:1px; }\n";

		$breakpoint = ubermenu_op( 'responsive_breakpoint' , 'general' );
		if( $breakpoint === '' ) $breakpoint = 959;
		if( is_numeric( $breakpoint ) ) $breakpoint.= 'px';

		//Responsive Sticky Styles
		$css.= "@media screen and (max-width: $breakpoint){ \n".
				"  .ubermenu-responsive-toggle.ubermenu-sticky{ height:43px; left:0; width:100% !important; } \n".
				"  .ubermenu.ubermenu-responsive.ubermenu-sticky{ margin-top:43px; left:0; width:100% !important; } \n";
				//"  .ubermenu-sticky-wrapper{ max-height:0; min-height:0 !important; } \n".
				
			$css.= "  /* Mobile Sticky */\n";
			$css.= "  .ubermenu.ubermenu-is-mobile.ubermenu-sticky { min-height:400px; max-height:600px; overflow-y:auto !important; -webkit-overflow-scrolling:touch; }\n";
			$css.= "  .ubermenu.ubermenu-is-mobile.ubermenu-sticky > .ubermenu-nav{ height:100%; }\n";
			$css.= "  .ubermenu.ubermenu-is-mobile.ubermenu-sticky .ubermenu-active > .ubermenu-submenu-drop{ max-height:none; }\n";

		$css.= "}\n"; //End media query

		//Special Sticky Classes
		$css.= "/* Special Classes */ ";
		$css.= ".ubermenu .ubermenu-item.um-sticky-only{ display:none !important; } ";
		$css.= ".ubermenu.ubermenu-sticky .ubermenu-item-level-0.um-sticky-only{ display:inline-block !important; } ";
		$css.= ".ubermenu.ubermenu-sticky .ubermenu-submenu .ubermenu-item.um-sticky-only{ display:block !important; } ";
		$css.= ".ubermenu .ubermenu-item-level-0.um-unsticky-only{ display:inline-block !important; } ";
		$css.= ".ubermenu .ubermenu-submenu .ubermenu-item.um-unsticky-only{ display:block !important; } ";
		$css.= ".ubermenu.ubermenu-sticky .ubermenu-item.um-unsticky-only{ display:none !important; }\n";

/*
		// The actual sticky CSS
		$css.= "{$stickyMegaMenu}{ margin: 0 !important; z-index:1000; position:fixed !important; top: {$offset}px; bottom: auto !important; -webkit-transition:none; -moz-transition:none; transition:none; }\n";
		
		if( !$alwaysSticky ){
			//Special Sticky Classes
			$css.= "#megaMenu ul.megaMenu li.um-sticky-only{ display: none !important; }";
			$css.= "#megaMenu-sticky-wrapper #megaMenu.ubermenu-sticky li.um-sticky-only{ display: block !important; }";
			$css.= "#megaMenu ul.megaMenu li.um-unsticky-only{ display: block !important; }";
			$css.= "#megaMenu-sticky-wrapper #megaMenu.ubermenu-sticky li.um-unsticky-only{ display: none !important; }";

		}

		if( $settings->op( 'ubersticky-mobile' ) ){
			$css.= "\n/* Mobile Sticky */ /*\n";
			$stickyWrapper = '#megaMenu-sticky-wrapper.uber-sticky-mobile '; //trailing space is important
			if( $alwaysSticky ) $stickyWrapper = ''; //Apply if we're not using
			$css.= "{$stickyWrapper}#megaMenu ul.megaMenu.megaMenuToggleOpen{ overflow-y:scroll !important; -webkit-overflow-scrolling: touch; }";	//  overflow-scrolling: touch;
		}

		//At smaller sizes, make align left, full width!
		if( $settings->op( 'ubersticky-expand-menu-bar' ) ){
			$css.= "\n/* Expand Menu Bar */ /*\n";
			$css.= "{$stickyMegaMenu}{ left: 0; right:auto; width: 100%; border-radius: 0; }\n";
			
			if( is_numeric( $settings->op( 'ubersticky-center-inner' ) ) ){
				$css.= "/* Center Inner Menu */ /*\n";
				$css.= "#megaMenu.ubermenu-sticky ul.megaMenu{ padding-left:2px; margin: 0 auto; float:none; max-width: {$settings->op( 'ubersticky-center-inner' )}px; }\n"; //leave selectors as is, use core UM settings instead
				$css.= "#megaMenu.megaMenuHorizontal ul.megaMenu > li:first-child > a{ box-shadow:none; }\n";
			}
		}


		//If UberMenu was supposed to be centered
		if( $settings->op( 'center-menubar' ) ){
			$css.= "/* Center Menubar */ /*\n";
			$css.= "#megaMenu-sticky-wrapper{ margin:0 auto; max-width: 100%; width: {$settings->op( 'wpmega-container-w' )}px; }\n";
		}

		if( ( $bkg_color = $settings->op( 'ubersticky-background-color' ) ) != '' ){
			$css.= "/* Menu Bar Background */ /*\n";
			$css.= "#megaMenu-sticky-wrapper #megaMenu.ubermenu-sticky{ background: #$bkg_color; }\n";
		}
		*/

		if( ubermenu_op( 'sticky_toolbar_footer' , 'general' ) == 'on' ){
			$css.= "/* Move Admin Bar to bottom */
@media screen and (min-width:783px){
  * html body { margin-top: 0 !important; }
  body.admin-bar { margin-top: -28px; padding-bottom: 28px; }
  body.wp-admin #footer { padding-bottom: 28px; }
  #wpadminbar { top: auto !important; bottom: 0; }
  #wpadminbar .quicklinks .ab-sub-wrapper { bottom: 28px; }
  #wpadminbar .quicklinks .ab-sub-wrapper ul .ab-sub-wrapper { bottom: -7px; } }\n";
		}
		else{
			$breakpoint = ubermenu_op( 'responsive_breakpoint' , 'general' );
			if( is_numeric( $breakpoint ) ) $breakpoint.= 'px';
			$css.= "@media screen and (min-width:783px){ .admin-bar .ubermenu.ubermenu-sticky, .admin-bar .ubermenu-responsive-toggle.ubermenu-sticky{ margin-top:32px; } }\n";
			$css.= "@media screen and (min-width:783px) and (max-width:$breakpoint){ .admin-bar .ubermenu.ubermenu-sticky{ margin-top:78px; } }\n";
			$css.= "@media screen and (min-width:600px) and (max-width:782px){ .admin-bar .ubermenu.ubermenu-sticky, .admin-bar .ubermenu-responsive-toggle.ubermenu-sticky{ margin-top:46px; } .admin-bar .ubermenu.ubermenu-sticky{ margin-top:89px; } }\n";
		}

		$styles[70] = $css;
		//uberp( $styles );
	}

	return $styles;
}
