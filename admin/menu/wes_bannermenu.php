<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function get_wes_suboptions_banner() {

  return array(
	       'corporate_banner_link' => array('name' => __('Banner URL','campaigndot'),
						'desc' => __('The URL to redirect on banner click', 'campaigndot'),
						'val' => '', 'type' => 'text')
	       ,'corporate_banner_title' => array('name' => __('Banner title','campaigndot'),
						  'desc' => __('The title of banner', 'campaigndot'),
						  'val' => '', 'type' => 'text')
	       // ,'corporate_banner_display' => array('name' => __('Banner display','campaigndot'),
	       // 					    'desc' => __('Check for displaying banner on emails', 'campaigndot'),
	       // 					    'val' => 'checked', 'type' => 'checkbox' )
	       );
}

/*
 * Les pages des sous-options, et leurs menu associés
 */
function wes_register_subsettings_banner() {
  /*
   * La page des options, et son menu associé
   */
  $wes_suboptions_banner = get_wes_suboptions_banner();
  foreach($wes_suboptions_banner as $opt => $val) {
    register_setting('wes_suboptions_banner', $opt);
  }

  // Ainsi que la bannière, qui a un traitement spécial
  register_setting('wes_suboptions_banner', 'wes_banner_meta'); // L'URL externe (éventuellement)
  register_setting('wes_suboptions_banner', 'wes_banner_upload_meta'); // L'URL de l'image uploadée
  register_setting('wes_suboptions_banner', 'wes_banner_upload_edit_meta'); // L'URL de l'image uploadée, pour édition

  // Les boutons radio de mode de bannière, et les infos de catégories
  register_setting('wes_suboptions_banner', 'wes_banner_mode');
  register_setting('wes_suboptions_banner', 'wes_banner_category');
  register_setting('wes_suboptions_banner', 'corporate_banner_display');
  //register_setting('wes_suboptions_banner', 'wes_use_static_if_needed');
  register_setting('wes_suboptions_banner', 'wes_what_to_do');


}

//Gérald 28/12/2023
add_action('wp_ajax_replace_cta_banner', 'replace_cta_banner');

function replace_cta_banner() {
  // Enable error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  if (isset($_POST['image_url'])) {
      $image_url = $_POST['image_url'];

      // Log the image URL

      $upload_dir = wp_upload_dir();
      $base_dir = $upload_dir['basedir'];
      $uploaded_file_path = str_replace($upload_dir['baseurl'], $base_dir, $image_url);

      // Log the file path

      if (!file_exists($uploaded_file_path)) {
          wp_send_json_error("Uploaded file path does not exist: $uploaded_file_path");
          return;
      }

      // Use WP_CONTENT_DIR to target the wp-content directory
      $destination_dir = WP_CONTENT_DIR . '/wpes-cta';
      $destination_file_path = $destination_dir . '/cta-banner.jpg';

      // Log the destination path

      if (!file_exists($destination_dir) && !wp_mkdir_p($destination_dir)) {
          wp_send_json_error("Failed to create destination directory: $destination_dir");
          return;
      }

      if (!copy($uploaded_file_path, $destination_file_path)) {
          wp_send_json_error("Failed to copy the file from $uploaded_file_path to $destination_file_path");
          return;
      }

      wp_send_json_success('Banner replaced successfully.');
  } else {
      wp_send_json_error('No image URL provided.');
  }
}



/*
 * La page affichée dans le sous-menu bannière
 */
function wes_plugin_banner_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

//	cdotpro_depend_notice();

	?>
<div class="wrap">
  <h2><?php _e('Banner management', 'campaigndot'); ?></h2>

  <form method="post" action="options.php">
<?php
 // Ici, la sélection du mode de la bannière, puis les différentes valeurs
 
 settings_fields( 'wes_suboptions_banner' );
 do_settings_sections( 'wes_suboptions_banner' );


 $wes_banner_mode = get_option('wes_banner_mode', 'static');

 // Si la version pro n'est pas active (ou bien qu'elle est désactivée)
 if (get_option("cdotpro_active", false) == false) {
   update_option('wes_banner_mode', 'static');
   $wes_banner_mode = 'static';
 }
?>

   <div id="wes_global_infos" class="">
    <table class="form-table">
      <tr>
        <th><label for="wes_meta"><?php _e( 'Banner display', 'campaigndot'); ?></label></th>
        <td>
          <input type="checkbox" name="corporate_banner_display" <?php if (get_option("corporate_banner_display")) { echo "checked='checked' value='".get_option("corporate_banner_display")."'";}; ?> />
  	  <span class="description"><?php _e('Check for displaying banner on emails', 'campaigndot'); ?></span>
        </td>
      </tr>
    </table>
   </div>
      
   <div id="wes_banner_option" class="iphone-toggle-buttons">
    <ul>
      <li>
      <input type="radio" id="static_banner_mode" name="wes_banner_mode" value="static" class="tog"<?php echo ($wes_banner_mode == "static")?" checked":"";?>> 
      <label for="static_banner_mode"><?php _e('Static banner mode', 'campaigndot'); ?></label>
    </li>
    <?php if( function_exists( 'cdotpro_scripts' ) ) { ?>

    <li>
	<input type="radio" id="dynamic_banner_mode" name="wes_banner_mode" value="dynamic" class="tog"<?php echo ($wes_banner_mode == "dynamic")?" checked":"";?><?php get_option("cdotpro_active", false)?"":" disabled=\"disabled\""; ?>>
	<label for="dynamic_banner_mode"><?php _e('Dynamic banner mode', 'campaigndot'); ?><?php get_option("cdotpro_active", false)?"":(_e(' (Pro version only)', 'campaigndot'));?></label>
    </li>

         <?php  } ?>


  </ul>
  </div>


  <div id="wes_statmode">
<?php 

 $wes_banner_url = get_option('wes_banner_meta');
 $wes_banner_upload_url = get_option('wes_banner_upload_meta');
 $wes_banner_upload_edit_url = get_option('wes_banner_upload_edit_meta');

 // Selon l'existance ou non d'une URL
 if (!$wes_banner_upload_url) {
   $btn_text = __('Send Banner', 'campaigndot');
 } else {
   $wes_upload_edit_url = /* get_home_url().*/ get_option('wes_banner_upload_edit_meta');
   $btn_text = __('Change banner', 'campaigndot');
 }


?>
  <h3><?php _e('Static banner', 'campaigndot'); ?></h3>
  <table class="form-table">
        <tr>
	  <th><label for="wes_meta"><?php _e( 'Banner', 'campaigndot'); ?></label></th>
            <td>
                <!-- Outputs the image after save -->
                <div id="current_img">
                    <?php if($wes_banner_upload_url): ?>
                        <img src="<?php echo esc_url( $wes_banner_upload_url ); ?>" class="wes-current-img">
                      
                    <?php elseif($wes_banner_url) : ?>
                        <img src="<?php echo esc_url( $wes_banner_url ); ?>" class="wes-current-img">
                       
                    <?php else : ?>
                        <img src="<?php echo WES_URL . 'img/placeholder.gif'; ?>" class="wes-current-img placeholder">
                    <?php endif; ?>
                </div>
                <!-- Hold the value here if this is a WPMU image -->
                <div id="wes_upload">
                    <input type="hidden" name="wes_placeholder_meta" id="wes_placeholder_meta" value="<?php echo WES_URL . 'img/placeholder.gif'; ?>" class="hidden" />
                    <input type="hidden" name="wes_banner_upload_meta" id="wes_upload_meta" value="<?php echo esc_url_raw( $wes_banner_upload_url ); ?>" class="hidden" />
                    <input type="hidden" name="wes_banner_upload_edit_meta" id="wes_upload_edit_meta" value="<?php echo esc_url_raw( $wes_banner_upload_edit_url ); ?>" class="hidden" />
                    <input type='button' class="wes_wpmu_button button-primary" value="<?php echo $btn_text; ?>" id="uploadimage"/><br />
	                  
                  </div>  
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <div id="wes_external">
                    <input type="text" name="wes_banner_meta" id="wes_meta" value="<?php echo esc_url_raw( $wes_banner_url ); ?>" class="regular-text" />
                </div>
                <!-- Outputs the save button -->
		<span class="description"><?php _e( 'Upload a custom image as a Banner or use a URL to a pre-existing image.', 'campaigndot'); ?></span>
                <p class="description"><?php _e('Update to save your changes.', 'campaigndot'); ?></p>

	  </td>
	</tr>
	
	<?php $wes_options = get_wes_suboptions_banner();
	foreach ($wes_options as $opt => $val) { ?>
        <tr valign="top">
	  <th scope="row"><label for="<?php echo $opt;?>"><?php echo $val['name']; ?></label></th>
          <td>
<?php
 if ($val['type'] == 'text') : ?>
   <input size="60" type="<?php echo $val['type']; ?>" name="<?php echo $opt; ?>" value="<?php echo esc_attr( get_option($opt) ); ?>" <?php echo ((array_key_exists('class', $val) && $val['class'])?(" class='".$val['class']."'"):""); ?> /><br />
   <?php elseif($val['type'] == 'textarea') : ?>
       <textarea name="<?php echo $opt; ?>" id="<?php echo $opt; ?>" rows="5" cols="60"><?php echo esc_attr( get_option($opt) ); ?></textarea><br />
   <?php elseif($val['type'] == 'file') : ?>
           <input type="<?php echo $val['type']; ?>" name="<?php echo $opt; ?>" value="<?php echo esc_attr( get_option($opt) ); ?>" /><br />
   <?php elseif($val['type'] == 'checkbox') : ?>
	   <input type="<?php echo $val['type']; ?>" name="<?php echo $opt; ?>" <?php if (get_option($opt)) { echo "checked='checked' value='".get_option($opt)."'";}; ?> />
   <?php else : ?>
           <input type="<?php echo $val['type']; ?>" name="<?php echo $opt; ?>" value="<?php echo esc_attr( get_option($opt) ); ?>" /><br />
   <?php endif ;
	  if (array_key_exists('desc', $val)) { ?>
	   <span class="description"><?php echo $val['desc']; ?></span>
    <?php } ?>
	  </td>
        </tr>
						 <?php } ?>
    </table>
    </div>

	<?php
	 if( function_exists( 'cdotpro_scripts' ) ) {
	   cdotpro_banner_page();
	 } else {  ?>
<!-- Dynamic mode banners -->
   <div id="wes_dynamode">
   <h3><?php _e('Dynamic banner', 'campaigndot'); ?></h3>
	 <?php _e('Dynamic banners are only allowed on Pro version of CampaignDot.', 'campaigndot');?>
    </div>
    <?php
     }
	submit_button(); ?>

</form>
    
<?php
}