<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Les champs supplémentaires
 */

function wes_profile_extrafields($user) {

  // Variables
  $wes_position = get_the_author_meta('wes_position_meta', $user->ID);
  $wes_gsm = get_the_author_meta('wes_gsm_meta', $user->ID);
  $wes_phone = get_the_author_meta('wes_phone_meta', $user->ID);
  $wes_skype = get_the_author_meta('wes_skype_meta', $user->ID);
  $wes_category_mode = get_the_author_meta('wes_category_mode', $user->ID);
  $wes_banner_categories = get_the_author_meta('wes_banner_categories', $user->ID);
  ?>



<div class="tab content2">
        <h3><?php echo _e('User Detail', 'campaigndot'); ?></h3>

  <table class="wes_user_additional_data">
    <tr>
      <td>
        <label for="wes_position"><?php _e('Position', 'campaigndot'); ?></label><br>
        <input type="text" name="wes_position" id="wes_position" value="<?php echo esc_attr($wes_position); ?>" class="regular-text" /><br />
        <span class="description"><?php _e('Your corporate position' , 'campaigndot'); ?></span>
      </td>
    </tr>
    <tr>
     
      <td>
       <label for="wes_gsm"><?php _e('GSM', 'campaigndot'); ?></label><br>
        <input type="text" name="wes_gsm" id="wes_gsm" value="<?php echo esc_attr( $wes_gsm ); ?>" class="regular-text" /><br />
        <span class="description"><?php _e('Format: +33 (0) 6 00 00 00 00','campaigndot'); ?></span>
      </td>
    </tr>
    <tr>
      <td>
           <label for="wes_phone"><?php _e('Phone', 'campaigndot'); ?></label><br>
        <input type="text" name="wes_phone" id="wes_phone" value="<?php echo esc_attr( $wes_phone ); ?>" class="regular-text" /><br />
        <span class="description"><?php _e('Format: +33 (0) 1 00 00 00','campaigndot'); ?></span>
      </td>
    </tr>
    <tr>
  
      <td>
            <label for="wes_skype"><?php _e('Skype', 'campaigndot'); ?></label><br>
        <input type="text" name="wes_skype" id="wes_skype" value="<?php echo esc_attr( $wes_skype ); ?>" class="regular-text" /><br />
        <span class="description"><?php _e('Your Skype ID','campaigndot'); ?></span>
      </td>
    </tr>
    <?php   if( function_exists( 'cdotpro_admin_scripts' ) ) {  ?>
    <tr>
     
      <td class="wes_categories">
        <label for="wes_category_mode"><?php _e('Select banner categories','campaigndot');?></label><br>
      <input type="radio" id="wes_category_mode_include" name="wes_category_mode" value="include" <?php echo ($wes_category_mode == "include")?"checked":"";?>>
      <label for="wes_category_mode_include"><?php _e('Include only following categories', 'campaigndot'); ?></label><br>
      <input type="radio" id="wes_category_mode_exclude" name="wes_category_mode" value="exclude" <?php echo ($wes_category_mode != "include")?"checked":"";?>>
      <label for="wes_category_mode_exclude"><?php _e('Exclude following categories', 'campaigndot'); ?></label><br>
      <hr>
<?php wp_category_checklist( 0, 0, explode(",",$wes_banner_categories)); ?>			

      </td>
    </tr>
  <?php } ?>

  </table><!-- End wes_user_additional_data -->

  </div><!-- End tab content2-->

<?php
}

// Show the new image field in the user profile page.
add_action( 'show_user_profile', 'wes_profile_extrafields' );
add_action( 'edit_user_profile', 'wes_profile_extrafields' );


// save extra fields
function wes_save_profile_extrafields( $user_id ) {

  if ( !current_user_can( 'edit_user', $user_id ) )
    return false;

  /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
  update_user_meta( $user_id, 'wes_position_meta', sanitize_text_field($_POST['wes_position']) );
  update_user_meta( $user_id, 'wes_phone_meta', sanitize_text_field($_POST['wes_phone']) );
  update_user_meta( $user_id, 'wes_gsm_meta', sanitize_text_field($_POST['wes_gsm']) );
  update_user_meta( $user_id, 'wes_skype_meta', sanitize_text_field($_POST['wes_skype']) );
  update_user_meta( $user_id, 'wes_signature_type', sanitize_text_field($_POST['signature_type']) );
    if( function_exists( 'cdotpro_admin_scripts' ) ) { 

  update_user_meta( $user_id, 'wes_category_mode', sanitize_text_field($_POST['wes_category_mode']) );
}
  
// et le tableau des catégories

    if( function_exists( 'cdotpro_admin_scripts' ) ) { 
      $args = array('get' => 'all', 'hide_empty' => 0 );
      $categories = get_categories( $args );

if(empty($_POST['post_category'])) {
   $wes_banner_categories = '';
}
else{
    $wes_banner_categories = $_POST['post_category'];
}

    
        if (!empty($_POST['post_category'])){ // Make sure a change was done.
        $banner_cats = implode(",", $wes_banner_categories);
        }
        else {
       $banner_cats = $args;
       }
      update_user_meta( $user_id, 'wes_banner_categories', sanitize_text_field($banner_cats) ); 
      
    }
    

}

add_action( 'personal_options_update', 'wes_save_profile_extrafields' );
add_action( 'edit_user_profile_update', 'wes_save_profile_extrafields' );

?>
