<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load files for menu creation
 */

include_once (WES_DIR.'admin/menu/wes_defs.php');
include_once (WES_DIR.'admin/menu/wes_mainmenu.php');
include_once (WES_DIR.'admin/menu/wes_bannermenu.php');
include_once (WES_DIR.'admin/menu/wes_othermenu.php');

/**
 * Define the menu
 */
function wes_menu() {
  add_menu_page( __('CampaignDot Help', 'campaigndot')
		 , __('CampaignDot', 'campaigndot')
		 , 'manage_options'
		 , 'corporate-info-page'
		 , 'wes_plugin_help_page'
		 , 'dashicons-email'
		 , '3' /* Avant le menu utilisateurs */
		 );

  add_submenu_page('corporate-info-page'
		   , __('CampaignDot Help', 'campaigndot')
		   , __('Help', 'campaigndot')
		   , 'manage_options'
		   , 'corporate-info-page'
		   , 'wes_plugin_help_page'
		   );

  add_submenu_page('corporate-info-page'
		   , __('Corporate infos', 'campaigndot')
		   , __('Corporate infos', 'campaigndot')
		   , 'manage_options'
		   , 'corporate-main-page'
		   , 'wes_plugin_menu_page'
		   );

  add_submenu_page( 'corporate-info-page'
		    , __('Campain banner', 'campaigndot')
		    , __('Banner', 'campaigndot')
		    , 'manage_options'
		    , 'corporate_banner_page'
		    , 'wes_plugin_banner_page'
		    );
  

  if (defined('WES_DEBUG'))
  add_submenu_page( 'corporate-info-page'
		    , __('Debug info page', 'campaigndot')
		    , __('Debug info', 'campaigndot')
		    , 'manage_options'
		    , 'debug_info_page'
		    , 'wes_plugin_debug_info_page'
		    );

  add_action('admin_init', 'wes_register_settings');
  add_action('admin_init', 'wes_register_subsettings_banner');
   // add_action('admin_init', 'wes_banner_register_subsettings_banner');
}

add_action( 'admin_menu', 'wes_menu' );
