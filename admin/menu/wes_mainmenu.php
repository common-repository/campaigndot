<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Afin d'éviter (pour le moment) de faire une classe...
 */
function get_wes_options() {

  $options= array(
	      
	       'corporate_name' => array(
                'name' => __('Name','campaigndot'),
                'desc' => __('Your company name', 'campaigndot'),
                'val' => 'My corp',
                'type' => 'text' ,
                'group'         => 'details' )
            ,'corporate_address_line1' => array(
                'name' => __('Address (line 1)','campaigndot'),
                'val' => 'corp address', 
                'type' => 'text',
                'group'         => 'details'  )
	       ,'corporate_address_line2' => array(
                'name' => __('Address (line 2)','campaigndot'),
                'val' => 'corp address', 
                'type' => 'text' ,
                'group'         => 'details' )
	       ,'corporate_address_zip' => array(
                'name' => __('Zip code','campaigndot'),
                'val' => '02350', 
                'type' => 'text', 
                'size' => 6 ,
                'group'         => 'details' )
	       ,'corporate_address_city' => array(
                'name' => __('City','campaigndot'),
                'desc' => __('Your company address', 'campaigndot'),
                'val' => 'Saint machin', 
                'type' => 'text' ,
                'group'         => 'details' )
	       ,'corporate_phone' => array(
                'name' => __('Phone','campaigndot'),
                'desc' => __('Your company standard phone', 'campaigndot'),
                'val' => '+33 (0) 5 00 00 00 00', 
                'type' => 'text' ,
                'group'         => 'details' )
	       ,'corporate_site_url' => array(
                'name' => __('Web site','campaigndot'),
                'desc' => __('Your company web site', 'campaigndot'),
                'val' => 'https://www.campaigndot.com/', 
                'type' => 'text' ,
                'group'         => 'details' )
	       ,'corporate_email' => array(
                'name' => __('eMail','campaigndot'),
                'desc' => __('The generic email of your company', 'campaigndot'),
                'val' => '', 
                'type' => 'text' ,
                'group'         => 'details' )
	       ,'corporate_legal_notice' => array(
                'name' => __('Legal Notice','campaigndot'),
                'desc' => __('The text of the legal notice attached to emails', 'campaigndot'),
                'val' => '', 'type' => 'textarea' ,
                'group'         => 'details' )

            ,'corporate_color1'  =>  array(
                'name'           =>   __('Primary color','campaigndot'),
                'desc'           =>   __('Your company primary color', 'campaigndot'),
                'val'            =>   '#000000', 'type' => 'text',
                'class'          =>   'wes-color-field',
                'group'         => 'colors' )

            ,'corporate_color2'  =>   array(
                'name'           => __('Secondary color','campaigndot'),
                'desc'           =>   __('Your company secondary color', 'campaigndot'),
                'val'            =>   '#ffffff', 
                'type' => 'text',
                'class'          =>   'wes-color-field',
                'group'         => 'colors' )

            ,'corporate_icon_option' => array(
                'name'      =>       __('Icon option','campaigndot'),
                'desc'      =>       __('Choose a design for your social icons.', 'campaigndot'),
                'val'       =>       'small', 
                'type'      =>       'radio',
                'group'         => 'social_icon')
	       );

    $sn = wes_get_sn_list();
  foreach ($sn as $net) {
    $desc = sprintf(__('The %s URL of your company', 'campaigndot'), $net['name']);
    $options['corporate_sn_'.$net['name']] = array(
        'name' => $net['name'], 
        'desc' => $desc, 
        'val' => '', 
        'type' => 'text',
        'group' => 'social_network'
    );
  }

  return $options;
}


/*=====================================
=            Register settings            =
=====================================*/

function wes_register_settings() {

  /*
   * Les nouvelles options déclarées
   */
  $wes_options = get_wes_options();
  foreach($wes_options as $opt => $val) {
    register_setting('wes_options', $opt);
  }

  // Et le logo, qui a un traitement spécial
  register_setting('wes_options', 'wes_logo_meta'); // L'URL externe (éventuellement)
  register_setting('wes_options', 'wes_logo_upload_meta'); // L'URL de l'image uploadée
  register_setting('wes_options', 'wes_logo_upload_edit_meta'); // L'URL de l'image uploadée, pour édition

}

//Et la désactivation de l'encoding Base64
  register_setting('wes_options', 'bannere_type'); // L'URL de l'image uploadée


/*=====  End of Save settings  ======*/


/*=============================================================
=            Show the page in the CampaignDot Menu            =
=============================================================*/

function wes_plugin_menu_page() {
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  cdotpro_depend_notice();

/*=====  End of Show the page in the CampaignDot Menu  ======*/

 ?>

    <div class="wrap">
  <div class="campaigndot_head">CampaignDot | <span style="font-size:16px;"><?php echo _e('Corporate infos', 'campaigndot'); ?></span></div>

<form method="post" action="options.php">
    <?php settings_fields( 'wes_options' );
    do_settings_sections( 'wes_options' );

    $wes_logo_url = get_option('wes_logo_meta');
    $wes_logo_upload_url = get_option('wes_logo_upload_meta');
    $wes_logo_upload_edit_url = get_option('wes_logo_upload_edit_meta');

    if (get_option('bannere_type') !=='null'){
         $bannere_type = 'static_banner';
       }
       else{
         $$banner_type = get_option('bannere_type');
       }

    // Selon l'existence ou non d'une URL
    if (!$wes_logo_upload_url) {
    $btn_text = __('Send Logo', 'campaigndot');
    } else {
    $wes_upload_edit_url = /* get_home_url().*/ get_option('wes_logo_upload_edit_meta');
    $btn_text = __('Change Logo', 'campaigndot');
    }

   
	?>

    

<div class="tab-content" style="background-color: #ffffff;">

 <div class="campaigndot_settings_details_odd">
    <h2><?php echo _e('Design preferences', 'campaigndot'); ?></h2>

    <table class="form-table">
        <tr>
	  <th><label for="wes_meta"><?php _e( 'Logo', 'campaigndot'); ?></label></th>
            <td>
                <!-- Outputs the image after save -->
                <div id="current_img">
                    <?php if($wes_logo_upload_url): ?>
                        <img src="<?php echo esc_url( $wes_logo_upload_url ); ?>" class="wes-current-img" style="max-width:250px;">
                      
                    <?php elseif($wes_logo_url) : ?>
                        <img src="<?php echo esc_url( $wes_logo_url ); ?>" class="wes-current-img">
                        
                    <?php else : ?>
                        <img src="<?php echo WES_URL . 'img/placeholder.gif'; ?>" class="wes-current-img placeholder">
                    <?php endif; ?>
                </div>

                <!-- Hold the value here if this is a WPMU image -->
                <div id="wes_upload">
                    <input type="hidden" name="wes_placeholder_meta" id="wes_placeholder_meta" value="<?php echo WES_URL . 'img/placeholder.gif'; ?>" class="hidden" />
                    <input type="hidden" name="wes_logo_upload_meta" id="wes_upload_meta" value="<?php echo esc_url_raw( $wes_logo_upload_url ); ?>" class="hidden" />
                    <input type="hidden" name="wes_logo_upload_edit_meta" id="wes_upload_edit_meta" value="<?php echo esc_url_raw( $wes_logo_upload_edit_url ); ?>" class="hidden" />
                    <input type='button' class="wes_wpmu_button button-primary" value="<?php echo $btn_text; ?>" id="uploadimage"/><br />
	        </div>  
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <div id="wes_external">
                    <input type="text" name="wes_logo_meta" id="wes_meta" value="<?php echo esc_url_raw( $wes_logo_url ); ?>" class="regular-text" />
                </div>
                <!-- Outputs the save button -->
		<span class="description"><?php _e( 'Upload a custom image as a Logo or use a URL to a pre-existing image.', 'campaigndot'); ?></span>
                <p class="description"><?php _e('Update to save your changes.', 'campaigndot'); ?></p>

	  </td>
	</tr>
</table>

   <table class="form-table" id="social-icons">
     <?php $wes_options_social_icons = get_wes_options();
            foreach ($wes_options_social_icons as $opt_social_icons => $val) { 
             if ($val['group'] == 'social_icon') { ?>
        <tr>
            <th valign="middle"><label for="corporate_icon_option"><?php _e( 'Social icons design', 'campaigndot'); ?></label></th>

            <td>

            <div class="icon_option">        
            <label class="cpdt_social_icon">
            <input type="radio" id="small" name="corporate_icon_option" value="small"<?php checked( 'small' == get_option($opt_social_icons) ); ?> />
            <img src="<?php echo WES_URL . 'img/icon-style/small.png'; ?>">
            <div>Small (16px)</div>
            </label>

            <label class="cpdt_social_icon">
            <input type="radio" id = "round-color" name="corporate_icon_option" value="round-color"<?php checked( 'round-color' == get_option($opt_social_icons) ); ?> />
            <img src="<?php echo WES_URL . 'img/icon-style/round-color.png'; ?>">
            <div>Color (24px)</div>
            </label>

            <label class="cpdt_social_icon">
            <input type="radio" id = "round-grey" name="corporate_icon_option" value="round-grey"<?php checked( 'round-grey' == get_option($opt_social_icons)); ?> />
            <img src="<?php echo WES_URL . 'img/icon-style/round-grey.png'; ?>">
            <div>Grey (24px)</div>
            </label>

             <label class="cpdt_social_icon">
            <input type="radio" id = "minimal" name="corporate_icon_option" value="minimal"<?php checked( 'minimal' == get_option($opt_social_icons)); ?> />
            <img src="<?php echo WES_URL . 'img/icon-style/minimal.png'; ?>">
            <div>Minimal (16px)</div>
            </label>
            <br>
             </div>   
          </td>
            </tr>
            <?php } }// End foreach   ?>
           
            </table>




   <table class="form-table">
        <?php $wes_options_colors = get_wes_options();
         foreach ($wes_options_colors as $opt_colors => $val) { 
         if ($val['group'] == 'colors') { ?>

    <tr>
        <th scope="row"><label for="<?php echo $opt_colors;?>"><?php echo $val['name']; ?></label></th>
        <td>
           <input size="60" type="<?php echo $val['type']; ?>" name="<?php echo $opt_colors; ?>" value="<?php echo esc_attr( get_option($opt_colors) ); ?>" <?php echo ((array_key_exists('class', $val) && $val['class'])?(" class='".$val['class']."'"):""); ?> /><br />
        </td>
  </tr>
  <?php }} ?>
</table>

<?php
// Retrieve the value from the database or configuration
$banner_type = get_option('bannere_type');

// If $banner_type is empty, default to 'static_banner'
if (empty($banner_type)) {
    $banner_type = 'static_banner';
}
?>
<h3>Banner type</h3>

<input type="radio" id="dynamic_banner" name="bannere_type" value="dynamic_banner" <?php echo ($banner_type == 'dynamic_banner') ? 'checked' : ''; ?>>
<label for="dynamic_banner"><?php echo _e('Dynamic : the banner can change anytime - but this is not working all the time', 'campaigndot'); ?></label><br>

<input type="radio" id="static_banner" name="bannere_type" value="static_banner" <?php echo ($banner_type == 'static_banner') ? 'checked' : ''; ?>>
<label for="static_banner"><?php echo _e('Static : the banner can change anytime - but the email app cache can keep older images several days', 'campaigndot'); ?></label><br>

<input type="radio" id="base64_banner" name="bannere_type" value="base64_banner" <?php echo ($banner_type == 'base64_banner') ? 'checked' : ''; ?>>
<label for="base64_banner"><?php echo _e('Base64 : very stable, but signature has to be changed manually in the email app each time there is a new banner.', 'campaigndot'); ?></label>

</div>


<div class="campaigndot_settings_details_even">

        <h2><?php echo _e('Company details', 'campaigndot'); ?></h2>

   <table class="form-table">
    <?php $wes_options_details = get_wes_options();
     foreach ($wes_options_details as $opt_details => $val) { 
     if ($val['group'] == 'details') { ?>
        <tr valign="top">
      <th scope="row"><label for="<?php echo $opt_details;?>"><?php echo $val['name']; ?></label></th>
          <td>
    <?php if ($val['type'] == 'text') { ?>
        <input size="60" type="<?php echo $val['type']; ?>" name="<?php echo $opt_details ?>" value="<?php echo esc_attr( get_option($opt_details) ); ?>" <?php echo ((array_key_exists('class', $val) && $val['class'])?(" class='".$val['class']."'"):""); ?> /><br />
        <?php } elseif($val['type'] == 'textarea') { ?>
        <textarea name="<?php echo $opt_details; ?>" id="<?php echo $opt_details; ?>" rows="5" cols="60"><?php echo esc_attr( get_option($opt_details) ); ?></textarea><br />
        <?php } elseif($val['type'] == 'file') { ?>
        <input type="<?php echo $val['type']; ?>" name="<?php echo $opt_details; ?>" value="<?php echo esc_attr( get_option($opt_details) ); ?>" /><br />
        <?php } elseif($val['type'] == 'checkbox') { ?>
       <input type="<?php echo $val['type']; ?>" name="<?php echo $opt_details; ?>" <?php if (get_option($opt_details)) { echo "checked='checked' value='".get_option($opt_details)."'";}; ?> />
        </span>
        <?php } ?>
        </td>
        </tr>
        <?php }} ?>
        </table>
</div>


 <div class="campaigndot_settings_details_odd">

    <h2><?php echo _e('Social networks', 'campaigndot'); ?></h2>

   <table class="form-table">
    <?php $wes_options_social_networks = get_wes_options();
     foreach ($wes_options_social_networks as $opt_social_networks => $val) { 
        if ($val['group'] == 'social_network') { ?>

    <tr>
        <th scope="row"><label for="cpdt_social_network"><?php echo $val['name']; ?></label></th>
        <td>
        <input size="60" type="<?php echo $val['type']; ?>" name="<?php echo $opt_social_networks; ?>" value="<?php echo esc_attr( get_option($opt_social_networks) ); ?>" <?php echo ((array_key_exists('class', $val) && $val['class'])?(" class='".$val['class']."'"):""); ?> /><br />


       <?php  } ?>
      
        </td>
</tr>
  <?php } ?>

</table>

</div>

</div><!--tab-content-->


  <?php submit_button(); ?>

</form>

</div><!--wrap-->
<?php } ?>
