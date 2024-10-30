<?php
/*
Plugin Name: campaignDot
Plugin URI: http://campaigndot.com
Description: The CampaignDot plugin allow automatic creation of email signatures and a QRCode (Pro version) from the Wordpress user profile page. Corporate datas are also included in the email signature. A stats page allow you to check the relevance of your marketing campaign (Pro version).
Version: 2.5.4
Author: CampaignDot
Author URI: http://www.campaigndot.com/
Text Domain: campaigndot
Domain Path: /languages
License: GPLv2
*/

// Exit if accessed directly
defined( 'ABSPATH' ) OR exit;

define('WES_URL', plugin_dir_url( __FILE__ ));
define('WES_DIR', plugin_dir_path( __FILE__ ));
define('WES_FILE', __FILE__);
//define('WES_DEBUG', true);
define('WES_VERSION', trim(preg_replace('/^Version: /', '', implode('',preg_grep('/^Version: .*/', file(__FILE__))))));

/*
 * Traductions
 */

// Je ne sais pas (encore) comment dire à poedit d'aller chercher un texte en commentaire, donc voilà...
define('DUMMY_TRANS', __('The CampaignDot plugin allow automatic creation of email signatures and a QRCode (Pro version) from the Wordpress user profile page. Corporate datas are also included in the email signature. A stats page allow you to check the relevance of your marketing campaign (Pro version).', 'campaigndot'));

function cdot_language_load() {
  load_plugin_textdomain('campaigndot', FALSE, basename(WES_DIR) . '/languages');
}
add_action('init', 'cdot_language_load');



/*
 * Les styles et scripts
 */

function wes_scripts() {
  wp_enqueue_style( 'wes-style', WES_URL . 'css/styles.css');
  wp_enqueue_style( 'wp-color-picker' );
  wp_register_script( 'wes-script', WES_URL . 'js/scripts.js', array( 'jquery' ), '1.0.0', true );
 // wp_register_script( 'wes-script4', WES_URL . 'js/scripts-content4.js', array( 'jquery' ), '1.0.0', true );

  wp_enqueue_script( 'wes-script', WES_URL . 'js/scripts.js');
 // wp_enqueue_script( 'wes-script4', WES_URL . 'js/scripts-content4.js');

  global $pagenow;

  if ($pagenow == 'profile.php') {
      wp_register_script( 'scripts-banner-show-hide', WES_URL . 'js/scripts-banner-show-hide.js', array( 'jquery' ), '1.0.0', true );
      wp_enqueue_script( 'scripts-banner-show-hide', WES_URL . 'js/scripts-banner-show-hide.js');
    }

  wp_enqueue_script( 'wes-colorpicker', WES_URL . 'js/colorpicker.js', array( 'wp-color-picker' ), false, true );
  wp_enqueue_script( 'wes-clipboard', WES_URL . 'js/clipboard.min.js', array( 'wp-clipboard' ), false, true );

}


function wes_admin_scripts() {
  wp_enqueue_style('jquery-dp-style',"//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
  // wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
  wp_enqueue_style( 'wes-help-style', WES_URL . 'css/help-style.css');
  wp_enqueue_script( 'jquery');
  wp_enqueue_script( 'jquery-ui-core');
  wp_enqueue_script( 'jquery-ui-resizable');
  wp_enqueue_script( 'jquery-ui-datepicker');

  // These are banner designers styles and scripts
  wp_enqueue_style( 'wpbd-style', WES_URL . 'css/banner.css');

  wp_enqueue_script('wp-color-picker');

  wp_enqueue_script( 'wpbd-html2canvas-js', WES_URL . 'js/html2canvas.js', array('jquery'), 1.1, true);
 
  //Send to Canvas
  wp_enqueue_script  ( 'wpbd-send_to_canvas-js', WES_URL . 'js/send_to_canvas.js', array('jquery'), 1.1, false);
  wp_localize_script ( 'wpbd-send_to_canvas-js', 'send_to_canvas', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));  
}
         
add_action('wp_enqueue_scripts', 'wes_scripts');
add_action('admin_enqueue_scripts', 'wes_scripts');
add_action('admin_enqueue_scripts', 'wes_admin_scripts');

/*
 * Puis on va inclure les fichiers du plugin
 */

include_once (WES_DIR.'admin/wes_avatar.php');
include_once (WES_DIR.'admin/wes_extrafields.php');
include_once (WES_DIR.'admin/wes_menu.php');
include_once (WES_DIR.'template/wes_sizing.php');


if(get_option("cdotpro_active", false)) {
include_once (WES_DIR.'admin/wes_metabox_posts.php');
}

include_once (WES_DIR.'wes_signature.php');
include_once (WES_DIR.'wes_bannerstats.php');

// On créer les répertoires lors de l'activation... Ils ne sont pas détruits lors de la désactivation pour
// conserver leur contenu en cas d'évolution du plugin
register_activation_hook( __FILE__ , 'wes_createVCardDir' );
register_activation_hook( __FILE__ , 'wes_createDBTables' );
register_activation_hook( __FILE__ , 'wes_createctabannerDir' );

// La fonction de mise en place du désinstalleur
function wes_uninstall_hook() {
  register_uninstall_hook( __FILE__ , 'wes_deleteDBTables' );
  register_uninstall_hook( __FILE__ , 'wes_cleanTransient' );
}
register_activation_hook( __FILE__ , 'wes_uninstall_hook' );

// Ensuite on vérifie l'installation de PRO, on en fait la pub le cas échéant ...
function cdotpro_depend_notice() {
    $class="notice notice-info is-dismissible";
    $message=__("CampaignDotPro add more capabilities to CampaignDot plugin ! Visit <a href='http://campaigndot.com/'>the plugin site</a> for more infos.",'campaigndot');

    if (get_option("cdotpro_active", false) == false)
      printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
  }

// On peut de temps en temps activer cette notice sur les pages admin...
// add_action('admin_notices', 'cdotpro_depend_notice');

/**
 * Check if cdotpro is active or not
 */
function check_cdotpro_active() {
  if(is_plugin_active("campaigndotpro/campaigndotpro.php")) {
    update_option("cdotpro_active", true);
  } else {
    delete_option("cdotpro_active");
  }
}

add_action('admin_init', 'check_cdotpro_active');

/*
 * La page wes_author.php, normalement dans un thème
 */
function wes_load_template($Tmpl) {
  global $wp_query;

  $ret = $Tmpl;
  
  // Si il est fait référence à l'auteur...
  if( array_key_exists('author', $wp_query->query_vars) && !empty($wp_query->query_vars['author']) ) {
    global $member;
    $member = new WP_User( $wp_query->query_vars["author"] );
    if( $member ) {
      $ret = WES_DIR . "template/wes_author.php";
    }
  }
  return $ret;
}

add_filter('template_include', 'wes_load_template');

/*
 * La page wes_author.php, mais appelée depuis 
 */
function wes_load_profile($Tmpl) {
  global $wp_query;

  $ret = $Tmpl;
  
  // Si il est fait référence à l'auteur...
  if( array_key_exists('wes_profile', $wp_query->query_vars) && !empty($wp_query->query_vars['wes_profile']) ) {
    global $member;
    $member = new WP_User( $wp_query->query_vars["wes_profile"] );
    if( $member ) {
      $ret = WES_DIR . "template/wes_author.php";
    }
  }
  return $ret;
}

add_filter('template_include', 'wes_load_profile');

/*
 * Vérification de l'appel aux modèles
 */
function wes_check_template_call($Tmpl) {
  $ret = $Tmpl;
  
  if ((intval(get_query_var('wes_template')) != 0) && (intval(get_query_var('user_id')) != 0)) {
    global $member;
    $member = new WP_User( intval(get_query_var('user_id')) );
    if( $member ) {
      $ret = WES_DIR . "template/wes_templates.php";
    }
  }
  return $ret;
}

add_action('template_include', 'wes_check_template_call');


/*
 * Vérification de l'appel à la bannière
 */
function wes_check_banner_call() {
  if (intval(get_query_var('wes_banner')) != 0) {
    include_once WES_DIR . "template/wes_banner.php";
  }
}
add_action('template_redirect', 'wes_check_banner_call');

/*
 * Ajout de query_vars particulières (au traitement des bannières, et à la page des templates)
 */
function wes_add_banner_call($vars) {
  // For the banner
  $vars[] = 'wes_banner';
  $vars[] = 'type';
  $vars[] = 'o';

  // For the template page
  $vars[] = 'wes_template';
  $vars[] = 'user_id';

  // For the "future" profile page
  $vars[] = 'wes_profile';
  
  return $vars;
}
add_filter('query_vars', 'wes_add_banner_call');

/*
 * Diverses fonctions ajoutées à la barre admin ou dans la liste des utilisateurs

 */

// Fonction Compatibilité Oxygen Builder

function wes_oxygen_compatibility_profile() {
   if( !function_exists('is_plugin_active') ) {
      include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

if (is_plugin_active('oxygen/functions.php') ) {
  $oxy_active_profile = 'campaigndot-profile';
}
else {
$oxy_active_profile = '';
}

return $oxy_active_profile;

}

function wes_oxygen_compatibility_template() {
   if( !function_exists('is_plugin_active') ) {
      include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

if (is_plugin_active('oxygen/functions.php') ) {
  $oxy_active_templates = 'campaigndot-templates';
}
else {
$oxy_active_templates = '';
}

return $oxy_active_templates;

}

function wes_user_row_action_link($actions, $user) {
 
  $actions['view_profile']="<a class='wes_view_profile' href='".home_url(wes_oxygen_compatibility_profile() .'/?wes_profile='.$user->ID.'&user_id='.$user->ID) ."'> ".__('Profile page', 'campaigndot')."</a>";
  $actions['view_signature_templates']="<a class='wes_signature_templates' href='".home_url(wes_oxygen_compatibility_template() .'/?wes_template=1&user_id='.$user->ID)."'> ".__('Template page', 'campaigndot')."</a>";

   return $actions;
}

// Filtre dans la liste des utilisateurs
add_filter('user_row_actions', 'wes_user_row_action_link', 10,2);

// Rajout de deux actions dans la liste des utilisateurs

function wes_admin_bar_link($wp_admin_bar) {
  // L'appel à la page profil
  $wp_admin_bar->add_node(array(
        'parent' => 'user-actions',
        'id' => 'wes-page-profil',
        'title' => __('Profile page', 'campaigndot'),
        'href' => home_url(wes_oxygen_compatibility_profile().'/?wes_profile='.wp_get_current_user()->ID .'&user_id='.wp_get_current_user()->ID),
        'meta' => false));

  // L'appel à la page template
  $wp_admin_bar->add_node(array(
        'parent' => 'user-actions',
        'id' => 'wes-page-templates',
        'title' => __('Template page', 'campaigndot'),
        'href' => home_url(wes_oxygen_compatibility_template().'/?wes_template=1&user_id='.wp_get_current_user()->ID),
        'meta' => false));

}

add_action('admin_bar_menu', 'wes_admin_bar_link', 999);

/*====================================================================================
=            Add campaigndot_profile and campaigndot_templates shortcodes            =
====================================================================================*/

function wes_shortcode_profile(){
    ob_start();
    require WES_DIR . 'template/wes_author.php';
    $return_string = ob_get_flush();
}
add_shortcode('campaigndot_profile', 'wes_shortcode_profile');

function wes_shortcode_templates(){
    ob_start();
    require WES_DIR . 'template/wes_templates.php';
    $return_string = ob_get_flush();
}
add_shortcode('campaigndot_templates', 'wes_shortcode_templates');

/*=====  End of Add campaigndot_profile and _template shortcodes  ======*/

//Debug
function vc_remove_wp_ver_css_js( $src ) {
if ( strpos( $src, 'ver=' . get_bloginfo( 'version' ) ) )
    $src = remove_query_arg( 'ver', $src );
return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );

// Users Bulk action // Gérald 04/04/2022

add_filter('bulk_actions-users', function($bulk_actions) {
    if( function_exists( 'cdotpro_admin_scripts' ) ) { 
  $bulk_actions['send-signatures-by-email'] = __('Send signatures by Email', 'campaigndot');
}
  return $bulk_actions;

});


add_filter('handle_bulk_actions-users', function($redirect_url, $action, $post_ids) {

  if ($action == 'send-signatures-by-email') {
    foreach ($post_ids as $post_id) {

  $User = new WP_User($post_id);
  $SV = wes_getSignatureValues($User);


    // Envoi du mail
    // $SV = wes_getCorpValues();
    if ($SV['corp_email']) add_filter('wp_mail_from', 'wes_FromEmail');
    if ($SV['corp']) add_filter('wp_mail_from_name', 'wes_FromEmailName');
    add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
    wp_mail($SV['email'], __('Your email signature', 'campaigndot'),wes_getEmailSignature($User) ) or wp_die('Unable to send mail to '.$SV['email'].' using wp_mail');
    remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
    if ($SV['corp']) remove_filter('wp_mail_from_name', 'wes_FromEmailName');
    if ($SV['corp_email']) remove_filter('wp_mail_from', 'wes_FromEmail');
    }
    
    $redirect_url = add_query_arg('send-signatures-by-email', count($post_ids), $redirect_url);
  }
  return $redirect_url;
}, 10, 3);

add_action('admin_notices', function() {
  if (!empty($_REQUEST['send-signatures-by-email'])) {
    $num_changed = (int) $_REQUEST['send-signatures-by-email'];
    printf('<div id="message" class="updated notice is-dismissable"><p>' . __('%d Email signatures were sent.', 'campaigndot') . '</p></div>', $num_changed);
  }
});

/*=============================================================
=            Désactiver cache sur certaines images            =
=============================================================*/

add_filter( 'jetpack_lazy_images_blacklisted_classes', 'bbloomer_exclude_custom_logo_class_from_lazy_load', 999, 1 );
               
function bbloomer_exclude_custom_logo_class_from_lazy_load( $classes ) {
    $classes[] = 'dontcache';
    return $classes;
}  
/*=====  End of Désactiver cache sur certaines images  ======*/ 


/*=============================
=            Debug            =
=============================*/

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

/*=====  End of Debug  ======*/

function wpemailsignature_activate_alert() {
    // Set a transient to show the admin notice on the next admin page load
    set_transient('wpemailsignature_activation_notice', true, 5 * 60);
}

register_activation_hook(__FILE__, 'wpemailsignature_activate_alert');

function wpemailsignature_admin_notices() {
    // Include the file for is_plugin_active function
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    // Check if the transient is set and if Oxygen Builder is active
    if (get_transient('wpemailsignature_activation_notice') && is_plugin_active('oxygen/functions.php')) {
        $xml_file = 'https://www.wpemailsignature.com/documentation/#_rich_text-158-71';
        echo '<div class="notice notice-success">';
        //debug
        echo '<p>' . __('WP Email Signature plugin activated. You use Oxygen builder, two necessary pages (campaigndot-profile and campaigndot-templates) have been created for a better experience.', 'campaigndot') . '</p>';
        echo '</div>';

        // Delete the transient so the message won't be shown again
        delete_transient('wpemailsignature_activation_notice');
    }
}

add_action('admin_notices', 'wpemailsignature_admin_notices');

/*
 * On activate : Import 2 pages using xml file include/campaigndot-oxygen-compatibility.xml
 * Not working : json in Oxygen metabox is not set. Waiting for OXygen dev answer…
 */


 function wpemailsignature_perform_import() {
    // Only run this in the admin area to avoid header issues
    if (!is_admin()) {
        return;
    }

    // Check if our transient is set; if not, return early
    if (!get_transient('wpemailsignature_trigger_import')) {
        return;
    }

    // Path to the XML file in the plugin's '/include' subdirectory
    $xml_file = plugin_dir_path(__FILE__) . 'include/campaigndot-oxygen-compatibility.xml';

    // Suppress errors while loading the XML file
    $xml = @simplexml_load_file($xml_file);

    // Check if the XML file was loaded successfully
    if ($xml === false) {
        error_log('Failed to load XML file in wpemailsignature_perform_import.');
        delete_transient('wpemailsignature_trigger_import');
        return;
    }

    // Process the XML file
    foreach ($xml->page as $page_data) {
        $title = (string) $page_data->Title;

        // Use WP_Query to check if a page with the same title already exists
        $page_query = new WP_Query(array(
            'post_type' => 'page',
            'post_status' => 'any',
            'title' => $title,
            'posts_per_page' => 1
        ));

        if ($page_query->have_posts()) {
            continue; // Skip if the page already exists
        }

        // Create an array for the page
        $page = array(
            'post_title'    => $title,
            'post_content'  => (string) $page_data->Content,
            'post_status'   => 'publish', // Set page visibility to private
            'post_author'   => 1, // Assuming user ID 1
            'post_type'     => 'page',
        );

        // Insert the page into the database
        $post_id = wp_insert_post($page);

        // Add post meta from XML
        if ($post_id != 0) {
            foreach ($page_data->{'wp:postmeta'} as $meta) {
                add_post_meta($post_id, (string) $meta->{'wp:meta_key'}, (string) $meta->{'wp:meta_value'}, true);
                add_post_meta($post_id, 'wpemailsignature_page', 'yes', true);

            }
        }
    }

    // Delete the transient after successful import
    delete_transient('wpemailsignature_trigger_import');
}

add_action('admin_init', 'wpemailsignature_perform_import');

function wpemailsignature_activate() {
    set_transient('wpemailsignature_trigger_import', true, 60);
}

register_activation_hook(__FILE__, 'wpemailsignature_activate');

/*
 * On Deactivate : Remove pages
 */
 function wpemailsignature_deactivate() {
    $args = array(
        'post_type' => 'page',
        'meta_query' => array(
            array(
                'key' => 'wpemailsignature_page',
                'value' => 'yes',
            )
        ),
        'posts_per_page' => -1
    );

    $pages = get_posts($args);

    foreach ($pages as $page) {
        wp_delete_post($page->ID, true);
    }
}

register_deactivation_hook(__FILE__, 'wpemailsignature_deactivate');

