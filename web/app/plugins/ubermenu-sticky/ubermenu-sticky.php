<?php
/*
Plugin Name: UberMenu - Sticky Menu Extension
Plugin URI: http://wpmegamenu.com/sticky
Description: Get your UberMenu stuck.
Version: 3.1.2
Author: Chris Mavricos, SevenSpark
Author URI: http://sevenspark.com
License: http://codecanyon.net/licenses/regular
*/

/*
Copyright 2012-2015  Chris Mavricos, SevenSpark http://sevenspark.com
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'UberMenu_Sticky' ) ) :

final class UberMenu_Sticky {
	/** Singleton *************************************************************/

	private static $instance;
	private static $sticky_apply = array();
	private static $sticky_apply_global = -1;

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new UberMenu_Sticky;
			self::$instance->setup_constants();
			self::$instance->includes();
		}
		return self::$instance;
	}

	/**
	 * Setup plugin constants
	 *
	 * @since 1.0
	 * @access private
	 * @uses plugin_dir_path() To generate plugin path
	 * @uses plugin_dir_url() To generate plugin url
	 */
	private function setup_constants() {
		// Plugin version

		if( ! defined( 'UM_STICKY_VERSION' ) )
			define( 'UM_STICKY_VERSION', '3.1.2' );

		// Plugin Folder URL
		if( ! defined( 'UM_STICKY_PLUGIN_URL' ) )
			define( 'UM_STICKY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Folder Path
		if( ! defined( 'UM_STICKY_PLUGIN_DIR' ) )
			define( 'UM_STICKY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Root File
		if( ! defined( 'UM_STICKY_PLUGIN_FILE' ) )
			define( 'UM_STICKY_PLUGIN_FILE', __FILE__ );
	}

	private function includes() {
		
		require_once UM_STICKY_PLUGIN_DIR . 'includes/functions.php';

		require_once UM_STICKY_PLUGIN_DIR . 'includes/custom-styles.php';

		if( is_admin() ){
			//require_once UM_STICKY_PLUGIN_DIR . 'admin/settings.control-panel.php';
		}
		
	}

	static function sticky_apply( $config_id = false ){

		//global $uberMenu, $post, $ubermenusticky_apply;
		

		if( $config_id == false ){

			//Figure it out it not already determined
			if( self::$sticky_apply_global == -1 ){
				$menus = ubermenu_get_menu_instances( true );

				foreach( $menus as $config_id ){
					self::$sticky_apply_global = 
						self::$sticky_apply_global ||
						self::sticky_apply( $config_id );
				}
			}

			return self::$sticky_apply_global;
			
		}
		else{

			//Not yet determined
			if( !isset( self::$sticky_apply[$config_id] ) ){
				
				$apply = false;

				if( ubermenu_op( 'sticky_enabled' , $config_id ) == 'on' ){

					$apply_to = ubermenu_op( 'sticky_apply_to' , $config_id );
					if( $apply_to === '' ){
						$apply = true;
					}
					else{
						$apply_to = explode( ',' , $apply_to );
						$apply = false;
						global $post;
						foreach( $apply_to as $post_id ){
							//echo $post_id . ' :: ' .$post->ID;
							if( ( $post_id == $post->ID ) ||
								( $post_id == 'front' && is_front_page() ) ){
								$apply = true;
								break;
							}
						}
					}
				}

				$apply = apply_filters( 'ubermenu_sticky_apply' , $apply , $config_id );

				self::$sticky_apply[$config_id] = $apply;
			}

			return self::$sticky_apply[$config_id];
		
		}
		return self::$sticky_apply;
	}
}

endif; // End if class_exists check



function UM_STICKY() {
	return UberMenu_Sticky::instance();
}

UM_STICKY();

//Let the user know they need to install UberMenu if they haven't already
add_action( 'plugins_loaded' , 'ubermenu_sticky_ubercheck' , 20 );
function ubermenu_sticky_ubercheck(){
	if( !function_exists( 'ubermenu' ) ) add_action( 'admin_notices', 'ubermenu_sticky_admin_notice' );
}
function ubermenu_sticky_admin_notice() {
    ?><div class="error">
        <p><?php _e( '<strong>UberMenu Sticky</strong> is an Extension and requires the UberMenu 3 plugin to function.  Please install and activate <a href="http://wpmegamenu.com">UberMenu 3</a> to use this extension.', 'ubermenu' ); ?></p>
    </div><?php
}



function ubermenu_sticky_install() {
	if( function_exists( 'ubermenu_reset_generated_styles' ) ){
		ubermenu_reset_generated_styles();
	}
}
register_activation_hook( __FILE__, 'ubermenu_sticky_install' );

function ubermenu_sticky_uninstall() {
	if( function_exists( 'ubermenu_reset_generated_styles' ) ){
		ubermenu_reset_generated_styles();
	}
}
register_deactivation_hook( __FILE__, 'ubermenu_sticky_uninstall' );