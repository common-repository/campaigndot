<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * Suppression de l'Avatar standard
 */

add_action( 'load-profile.php', function()
{
   add_filter( 'option_show_avatars', '__return_false' );
} );

/*
 * Suppression des méthodes de contact standard
 */
function wes_remove_contactmethod( $contactmethods ) {
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  return $contactmethods;
}
add_filter('user_contactmethods','wes_remove_contactmethod',10,1);

/*
 * Code repris de l'ancien plugin, je ne sais pas comment il marche
 */
function remove_website_row_wpse_94963_css()
{
    echo '<style>tr.user-url-wrap{ display: none; }</style>';
}
add_action( 'admin_head-user-edit.php', 'remove_website_row_wpse_94963_css' );
add_action( 'admin_head-profile.php',   'remove_website_row_wpse_94963_css' );

/*
 * L'avatar, fonction d'insertion dans la page profil
 */

function wes_profile_image($user) {
  // Only allowed for uploaders
  if (!current_user_can('upload_files')) return false;

  // Variables
  $wes_avatar_url = get_the_author_meta('wes_avatar_meta', $user->ID);
  $wes_avatar_upload_url = get_the_author_meta('wes_avatar_upload_meta', $user->ID);
  $wes_avatar_upload_edit_url = get_the_author_meta('wes_avatar_upload_edit_meta', $user->ID);
  $wes_rounded_image = get_the_author_meta('wes_rounded_image', $user->ID);
  $wes_text_size = get_the_author_meta('wes_text_size', $user->ID);
 $big_wes_text_size = get_the_author_meta('big_wes_text_size', $user->ID);


  // Selon l'existance ou non d'une URL
  if (!$wes_avatar_upload_url) {
    $btn_text = __('Send picture', 'campaigndot');
  } else {
    $wes_avatar_upload_edit_url = /* get_home_url().*/ get_the_author_meta('wes_avatar_upload_edit_meta', $user->ID);
    $btn_text = __('Change picture', 'campaigndot');
  }




   if(!empty($wes_rounded_image)) {
     $wes_rounded = '-webkit-border-radius: 90px; -moz-border-radius: 90px; border-radius: 90px;';
   }
   else{
     $wes_rounded = '-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;';
   }


  ?>        
<div id="campaigndot_interface" class="campaigndot_wrapper">
  <div class="campaigndot_head">CampaignDot | <span style="font-size:16px;"><?php echo _e('Signature builder', 'campaigndot'); ?></span></div>


  <table class="global_table" style="background-color: #eef3f8;">
    <tr>
        <td class="wes_tabs_global">

    <div id="wes_container"> 

<input class="wes_nav_tabs" type="radio" name="tabs" id="tab1" checked/>
<label for="tab1"><img src="<?php echo WES_URL . 'img/tabs//image-tab.png'; ?>" /></label>
<input class="wes_nav_tabs" type="radio" name="tabs" id="tab2" />
<label for="tab2"><img src="<?php echo WES_URL . 'img/tabs/form-tab.png'; ?>" /></label>
<input class="wes_nav_tabs" type="radio" name="tabs" id="tab3" />
<label for="tab3"><img src="<?php echo WES_URL . 'img/tabs/template-tab.png'; ?>" /></label>



 <div class="tab content1">

    <h3><?php echo _e('User profile', 'campaigndot'); ?></h3>
    <span class="description"><?php _e( 'Your user profile should be 200px X 200px.', 'campaigndot'); ?></span>


    <table class="wes_avatar">
        <tr>
           
            <td>
                <!-- Outputs the image after save -->
                <div id="current_img">
                    <?php if($wes_avatar_upload_url): ?>
                        <img src="<?php echo esc_url( $wes_avatar_upload_url ); ?>" class="wes-current-img" style="<?php echo $wes_rounded; ?>" />
                      
                    <?php elseif($wes_avatar_url) : ?>
                        <img src="<?php echo esc_url( $wes_avatar_url ); ?>" class="wes-current-avatar" style="<?php echo $wes_rounded; ?>" />
                      
                    <?php else : ?>
                        <img src="<?php echo WES_URL . 'img/placeholder.gif'; ?>" class="wes-current-avatar placeholder" style="<?php echo $wes_rounded; ?>" />
                    <?php endif; ?>
                </div>             

                <!-- Hold the value here if this is a WPMU image -->
                <div id="wes_upload">
                    <input type="hidden" name="wes_placeholder_meta" id="wes_placeholder_meta" value="<?php echo WES_URL . 'img/placeholder.gif'; ?>" class="hidden" />
                    <input type="hidden" name="wes_avatar_upload_meta" id="wes_upload_meta" value="<?php echo esc_url_raw( $wes_avatar_upload_url ); ?>" class="hidden" />
                    <input type="hidden" name="wes_avatar_upload_edit_meta" id="wes_upload_edit_meta" value="<?php echo esc_url_raw( $wes_avatar_upload_edit_url ); ?>" class="hidden" />
                    <input type='button' class="wes_wpmu_button button-primary" value="<?php echo $btn_text; ?>" id="uploadimage"/><br /><br />
                </div>  
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <div id="wes_external">
                    <input type="text" name="wes_avatar_meta" id="wes_meta" value="<?php echo esc_url_raw( $wes_avatar_url ); ?>" class="regular-text" />
                </div>
                <!-- Outputs the save button -->
                 <input type="checkbox" name="wes_rounded_image" id="wes_rounded_image" value="wes_rounded_image" <?php if($wes_rounded_image) {echo 'checked';} ?> />

                <label for="wes_rounded_image" ><?php echo _e('Rounded', 'campaigndot'); ?></label><br>

               
                <h3><?php echo _e('Text-size', 'campaigndot'); ?></h3>
                 <input type="radio" name="wes_text_size" value="12" <?php if($wes_text_size == '12') {echo 'checked'; $wes_line_height='16'; } ?> > 
                <label for="wes_text_size">X-small</label>
                <input type="radio" name="wes_text_size" value="14" <?php if($wes_text_size == '14') {echo 'checked';$wes_line_height='18'; } ?> > 
                <label for="wes_text_size">Small</label>
                <input type="radio" name="wes_text_size" value="16" <?php if($wes_text_size == '16') {echo 'checked';$wes_line_height='20'; } ?> > 
                <label for="wes_text_size">Medium</label>
                <input type="hidden" id="big_wes_text_size" name="big_wes_text_size" value="14" >

            </td>
        </tr>
        <tr>
            <td><br><br>

          <script>

jQuery(function($){
      jQuery('#wes_rounded_image').on('click',function(){
       if($(this).is(':checked')) {
       jQuery('.wes-current-avatar').css('border-radius', '100px')}
       else{jQuery('.wes-current-avatar').css('border-radius', '4px')}
        });
    })

</script>

<script>
jQuery(function($){
    jQuery('input[name="wes_text_size"]').on('click',function(){
    var inputValue_base = $(this).attr("value");
    var inputValue = $(this).attr("value")+'px';
    var big_wes_text_size=(+inputValue_base)+(+2);

    jQuery('.wes_text_size').css('font-size', inputValue);
    jQuery('.big_wes_text_size').css('font-size', big_wes_text_size);
    });
});
</script>


 <h3><?php echo _e('Quick links', 'campaigndot'); ?></h3>


<a class="wes_button" href="<?php echo home_url(wes_oxygen_compatibility_profile() .'/?wes_profile='.$user->ID.'&user_id='.$user->ID); ?>" target="_blank"><?php echo __('Profile page', 'campaigndot'); ?></a><a class="wes_button" href="<?php echo home_url(wes_oxygen_compatibility_template() .'/?wes_template='.$user->ID.'&user_id='.$user->ID); ?>" target="_blank" ><?php echo __('Template page', 'campaigndot'); ?></a>
            </td>
        </tr>
 
    </table><!-- end form-table wes_avatar -->

    </div><!-- End tab content1-->

    <?php wp_enqueue_media(); // Enqueue the WordPress Media Uploader ?>

<?php

  
}

// Show the new image field in the user profile page.
add_action( 'show_user_profile', 'wes_profile_image' );
add_action( 'edit_user_profile', 'wes_profile_image' );


/*
 * L'avatar, téléchargement de l'image
 */
function wes_save_profile_image( $user_id ) {

    if ( !current_user_can( 'upload_files', $user_id ) )
        return false;

    // If the current user can edit Users, allow this.
    if($_POST){
    update_user_meta( $user_id, 'wes_avatar_meta', esc_url($_POST['wes_avatar_meta'] ));
    update_user_meta( $user_id, 'wes_avatar_upload_meta', esc_url($_POST['wes_avatar_upload_meta']));
    update_user_meta( $user_id, 'wes_avatar_upload_edit_meta', esc_url($_POST['wes_avatar_upload_edit_meta']));
 
  if (isset($_POST['wes_rounded_image'])) {
    update_user_meta( $user_id, 'wes_rounded_image', $_POST['wes_rounded_image']);
  }
  else{
     update_user_meta( $user_id, 'wes_rounded_image', '');
  }
    if (isset($_POST['wes_text_size'])) {
    update_user_meta( $user_id, 'wes_text_size', $_POST['wes_text_size']);
    }

    if (isset($_POST['big_wes_text_size'])) {
    update_user_meta( $user_id, 'big_wes_text_size', $_POST['big_wes_text_size']);
    }
    }

}


/**
 * Retrieve the appropriate image size
 *
 * @param $user_id    Default: $post->post_author. Will accept any valid user ID passed into this parameter.
 * @param $size       Default: 'thumbnail'. Accepts all default WordPress sizes and any custom sizes made by the add_image_size() function.
 * @return {url}      Use this inside the src attribute of an image tag or where you need to call the image url.
 */
function get_wes_meta( $user_id, $size ) {
    global $post;

    //allow the user to specify the image size
    if (!$size){
        $size = 'thumbnail'; // Default image size if not specified.
    }
    if(!$user_id || !is_numeric( $user_id ) ){
        // Here we're assuming that the avatar being called is the author of the post. 
        // The theory is that when a number is not supplied, this function is being used to 
        // get the avatar of a post author using get_avatar() and an email address is supplied 
        // for the $id_or_email parameter. We need an integer to get the custom image so we force that here.
        // Also, many themes use get_avatar on the single post pages and pass it the author email address so this
        // acts as a fall back.
      is_object($post) ? $user_id = $post->post_author : $user_id = wp_get_current_user()->ID;
    }
    
    // get the custom uploaded image
    $attachment_upload_url = esc_url( get_the_author_meta( 'wes_avatar_upload_meta', $user_id ) );
    
    // get the external image
    $attachment_ext_url = esc_url( get_the_author_meta( 'wes_avatar_meta', $user_id ) );
    $attachment_url = '';
    $image_url = '';
    if($attachment_upload_url){
        $attachment_url = $attachment_upload_url;
        
        // grabs the id from the URL using the WordPress function attachment_url_to_postid @since 4.0.0
        $attachment_id = attachment_url_to_postid( $attachment_url );
     
        // retrieve the thumbnail size of our image
        $image_thumb = wp_get_attachment_image_src( $attachment_id, $size );
        $image_url = $image_thumb[0];

    } elseif($attachment_ext_url) {
        $image_url = $attachment_ext_url;
    }

    if ( empty($image_url) )
        return;

    // return the image thumbnail
    return $image_url;
}

/**
 * WordPress Avatar Filter
 *
 * Replaces the WordPress avatar with your custom photo using the get_avatar hook.
 */
add_filter( 'get_avatar', 'wes_avatar' , 1 , 5 );

function wes_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;
    $id = false;

    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        // $id = (int) $id_or_email;
        $user = get_user_by( 'email', $id_or_email );   
    }

    if ( $user && is_object( $user ) ) {

        $custom_avatar = get_wes_meta($id, 'thumbnail');

        if (isset($custom_avatar) && !empty($custom_avatar)) {
            $avatar = "<img alt='{$alt}' src='{$custom_avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }

    }

    return $avatar;
}

add_action( 'personal_options_update', 'wes_save_profile_image' );
add_action( 'edit_user_profile_update', 'wes_save_profile_image' );

?>
