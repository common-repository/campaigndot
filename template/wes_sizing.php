<?php
/*
 * Signature templates sizing & font design
 *
 * @package: woc_email_signature
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// On récupère les valeurs à afficher dans la table $SV
// et on prépare l'environnement d'affichage
/*$user = new WP_User( get_query_var("user_id") );
$SV= wes_getSignatureValues($user);*/

function wes_text_style() {

// If is current user's profile (profile.php)
if ( defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE ) {
    $user_id = get_current_user_id();
// If is another user's profile page
} elseif (! empty($_GET['user_id']) && is_numeric($_GET['user_id']) ) {
    $user_id = $_GET['user_id'];
// Otherwise something is wrong.
} 

   if (get_the_author_meta('wes_text_size', $user_id)){
    $wes_text_size = get_the_author_meta('wes_text_size', $user_id);
    $wes_text_size = $wes_text_size . 'px';
   }
   else{
   $wes_text_size = '12px';
   }

   if (get_the_author_meta('wes_line_height', $user_id)){
       $wes_line_height = get_the_author_meta('wes_line_height', $user_id);
   }
    else{
   $wes_line_height = '1.3';
   }

   if($wes_text_size =='12px'){
   $wes_font_size = 'x-small';
   }
   elseif($wes_text_size =='14px'){
   $wes_font_size = 'small';
   }
   elseif($wes_text_size =='16px'){
   $wes_font_size = 'medium';
   }
   else{
    $wes_font_size = 'small';
   }

   $wes_font_style = 'font-family: Arial, Helvetica, Geneva, sans-serif; margin-bottom:0px; line-height: 1.3em; font-size:'. $wes_text_size . '; text-decoration:none; text-underline:none;' ;

   $wes_text_design = array("font-family" => $wes_font_style, "font-size" => $wes_text_size, "line-height" => $wes_line_height );

return $wes_text_design;

}


function wes_avatar_style() {

// If is current user's profile (profile.php)
if ( defined('IS_PROFILE_PAGE') && IS_PROFILE_PAGE ) {
    $user_id = get_current_user_id();
// If is another user's profile page
} elseif (! empty($_GET['user_id']) && is_numeric($_GET['user_id']) ) {
    $user_id = $_GET['user_id'];
} 
else{
    $user_id = '1';
}

$wes_avatar_url = get_user_meta($user_id,'wes_avatar_upload_meta', true );

   if ($wes_avatar_url) { 
   $avatar_attachment_id = attachment_url_to_postid( $wes_avatar_url, $user_id );
   $avatar_thumb = wp_get_attachment_image_src( $avatar_attachment_id, 'thumbnail' );
   $image_url = $avatar_thumb[0];
   }
   else {
   $wes_avatar_url = WES_URL . 'img/avatar.jpg';
   }
      
   //Calcul proportions avatar
   $avatar_width = 70;
   $avatar_height = 70;


   //Proportions logo
    $wes_logo_url = get_option('wes_logo_meta');
    $wes_logo_url = $wes_logo_url?$wes_logo_url:get_option('wes_logo_upload_meta');

   $logo_attachment_id = attachment_url_to_postid($wes_logo_url );
   $logo_thumb = wp_get_attachment_image_src( $logo_attachment_id, 'full' );
   
 

//Rounded image
     $wes_rounded_image = get_user_meta($user_id, 'wes_rounded_image', true );
        if(!empty($wes_rounded_image)) {
     $wes_rounded = '-webkit-border-radius: 90px; -moz-border-radius: 90px; border-radius: 90px;';
   }
   else{
     $wes_rounded = '-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;';
   }

$wes_avatar_design = array('avatar-url' => $wes_avatar_url, 'avatar-width' => $avatar_width, 'avatar-height' => $avatar_height, 'logo-width' => 150, 'logo-height' => 150, 'logo-url' => $wes_logo_url, 'rounded-image' => $wes_rounded, 'user_id' => $user_id);


return $wes_avatar_design;

}