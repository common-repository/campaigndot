<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * La page affichée dans le sous-menu Help
 */
function wes_plugin_help_page() {
  include_once (WES_DIR.'admin/template/wes_help.php');
}

/*
 * La page affichée dans le sous-menu Debug
 */
function wes_plugin_debug_info_page() {
  include_once (WES_DIR.'admin/template/wes_debug.php');
}

/*
 * La page affichée dans le sous-menu PRO!
 */
function wes_plugin_pro_page() {
  include_once (WES_DIR.'admin/template/wes_pro.php');
}
