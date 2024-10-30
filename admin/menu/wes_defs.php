<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Social Network list
 */
function wes_get_sn_list() {
  return array(array('name' => 'Facebook', 'icon' => 'facebook.png')
	       ,array('name' => 'Instagram', 'icon' => 'instagram.png')
	       ,array('name' => 'LinkedIN', 'icon' => 'linkedin.png')
	       ,array('name' => 'Twitter', 'icon' => 'twitter.png')
	       ,array('name' => 'WhatsApp', 'icon' => 'whatsapp.png')
	       ,array('name' => 'YouTube', 'icon' => 'youtube.png')
	       );
}

/**
 * Load media files needed for Uploader
 */
function load_wp_media_files() {
  wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );
