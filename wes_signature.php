<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}



function get_wes_banner_suboptions_banner()
{
  return array(
    'corporate_banner_link' => array(
      'name' => __('Banner URL', 'wpemailsignature'),
      'desc' => __('The URL to redirect on banner click', 'wpemailsignature'),
      'val' => '', 'type' => 'text'
    ),
    'corporate_banner_title' => array(
      'name' => __('Banner title', 'wpemailsignature'),
      'desc' => __('The title of banner', 'wpemailsignature'),
      'val' => '', 'type' => 'text'
    )
  );
}

//Gérald 28/12/2023

function display_dynamic_banner() {
  // Retrieve settings values
  $SV = wes_getCorpValues();; // Replace with actual function or global variable that provides $SV
  $SV['banner_link'] = esc_attr(get_option('corporate_banner_link'));
  $wes_banner_upload_url = get_option('wes_banner_upload_meta');
  $corporate_banner_link = get_option('corporate_banner_link');
  $corporate_banner_title = get_option('corporate_banner_title');

  // Check if the banner link is not empty
  if (!empty($SV['banner_link'])) {
      echo "<a id='wes_banner_link_dynamic' href='" . esc_url($corporate_banner_link) . "' title='" . esc_attr($corporate_banner_title) . "' alt='" . esc_attr($corporate_banner_title) . "'>";
  }

  // Display the image
  echo "<img width='468' height='60' style='border: 0;' src='" . esc_url($wes_banner_upload_url) . "' class='dontcache current_banner' moz-do-not-send='true' alt='" . esc_attr($corporate_banner_title) . "'>";

  // Close the anchor tag if banner link exists
  if (!empty($SV['banner_link'])) {
      echo "</a>";
  }
}


/*
 * Create uploads/vcards folder on plugin activation
 */

function wes_getVCardUrl() {
  $upload = wp_upload_dir();
  $upload_url = $upload['baseurl'];
  $upload_url = $upload_url . '/vcards';

  return $upload_url;
}

function wes_getVCardDir() {
  $upload = wp_upload_dir();
  $upload_dir = $upload['basedir'];
  $upload_dir = $upload_dir . '/vcards';
  return $upload_dir;
}

function wes_createVCardDir() {
  $upload_dir = wes_getVCardDir();
    
  if (! is_dir($upload_dir)) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
    $wp_fs_d = new WP_Filesystem_Direct( new StdClass() );
    if ( !$wp_fs_d->is_dir( $upload_dir ) && !$wp_fs_d->mkdir( $upload_dir, 0705 ) )
      wp_die( sprintf( __( 'Unable to create %s directory.', 'campaigndot' ), $upload_dir ) );    
  }

}


//Gérald 28/12/2023
function wes_getctabannerDir()
{
  $upload_dir = WP_CONTENT_DIR . '/wpes-cta';
    return $upload_dir;
}


//Gérald 28/12/2023 -> •••Modifier pour placer ce dossier dans wp-content•••
function wes_createctabannerDir()
{
  $upload_dir = wes_getctabannerDir();

    // Include the file system classes
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;

    // Check and create the directory if it doesn't exist
    if (!$wp_filesystem->is_dir($upload_dir)) {
        if (!$wp_filesystem->mkdir($upload_dir, 0755)) {
            wp_die(sprintf(__('Unable to create %s directory.', 'wpemailsignature'), $upload_dir));
        }
    }

    // Define the source file and the destination file
    $source_file = plugin_dir_path(__FILE__) . 'img/cta-banner.jpg';
    $destination_file = $upload_dir . '/cta-banner.jpg';

    // Copy the file from the source to the destination
    if (!$wp_filesystem->copy($source_file, $destination_file, true)) {
        wp_die(sprintf(__('Unable to copy %s to %s.', 'wpemailsignature'), $source_file, $destination_file));
    }
}

/*
 * Récupération des infos purement corporate
 */
function wes_getCorpValues($userID = 0) {
  $SV = array();

  // Le logo
  $t = get_option('wes_logo_meta');
  $t = $t?$t:get_option('wes_logo_upload_meta');
  $SV['logo_url'] = esc_url($t?$t:WES_URL . 'img/placeholder.gif');

  // La banniere. Statique ou dynamique ?
  if (get_option('wes_banner_mode') == 'static' || ! get_option("cdotpro_active", false)) {
    $t = get_option('wes_banner_meta');
    $t = $t?$t:get_option('wes_banner_upload_meta');
    $SV['banner_url'] = esc_url($t?$t:WES_URL . 'img/dummy-banner.jpg');
    $SV['banner_link'] = esc_attr(get_option('corporate_banner_link'));
    $SV['banner_title'] = esc_attr(get_option('corporate_banner_title'));
  } 
  else {
    // On recherche le post qui va servir de bannière
    $pid = cdotpro_get_banner_postID($userID);
  //  $pid_random = cdotpro_get_random($userID);


    $use_static_or_shuffle = get_option('wes_what_to_do');
    
    if ($use_static_or_shuffle == 'wes_use_static' && $pid ) {
      // Là, on va pouvoir récupérer les infos du post
      $SV['banner_url'] = get_post_meta( $pid, 'wes_banner_upload', true );
      $SV['banner_link'] = get_post_permalink($pid);
      $SV['banner_title'] = get_the_title($pid);
    }
/*===========================================================
=            Use static banner if none available            =
===========================================================*/

     elseif ($use_static_or_shuffle=='wes_use_static') {
      // Sinon, on se rabat sur la bannière statique
      $t = get_option('wes_banner_meta');
      $t = $t?$t:get_option('wes_banner_upload_meta');
      $SV['banner_url'] = esc_url($t?$t:WES_URL . 'img/dummy-banner.jpg');
      $SV['banner_link'] = esc_attr(get_option('corporate_banner_link'));
      $SV['banner_title'] = esc_attr(get_option('corporate_banner_title'));



/*=====  End of Use static banner if none available  ======*/



/*=======================================
=            Shuffle banners            =
=======================================*/

  }
    

    else {
      $SV['banner_url'] = ""; 
      $SV['banner_link'] = "";
      $SV['banner_title'] = "";
    }
  }




  // Ici, il va falloir calculer la bonne bannière

  $SV['corp'] = esc_attr(get_option('corporate_name'));
  $SV['corp_address_line1'] = esc_attr(get_option('corporate_address_line1'));
  $SV['corp_address_line2'] = esc_attr(get_option('corporate_address_line2'));
  $SV['corp_address_zip'] = esc_attr(get_option('corporate_address_zip'));
  $SV['corp_address_city'] = esc_attr(get_option('corporate_address_city'));

  foreach (wes_get_sn_list() as $sn) {
    $SV['corporate_sn_'.$sn['name']] = get_option('corporate_sn_'.$sn['name']);
  }

  $SV['corporate_phone'] = esc_attr(get_option('corporate_phone'));
  $SV['website'] = esc_url(get_option('corporate_site_url'));
  $SV['corp_email'] = esc_attr(get_option('corporate_email'));
  $SV['legal_notice'] = esc_attr(get_option('corporate_legal_notice'));
  $SV['color1'] = esc_attr(get_option('corporate_color1'));
  $SV['color2'] = esc_attr(get_option('corporate_color2'));

  $SV['free_field'] = esc_attr(get_option('corporate_free_option'));

  $SV['icon_option'] = esc_attr(get_option('icon_option'));
  $SV['banner_display'] = esc_attr(get_option('corporate_banner_display'));

  $SV['corporate_icon_option'] = esc_attr(get_option('corporate_icon_option'));

if($SV['corporate_icon_option'] ==''){
 $SV['corporate_icon_option'] = 'round-color'; 
}


  if ($SV['corporate_icon_option'] == 'small') {
    $icon_size='16';
    $rounded= '';
  }
    elseif ($SV['corporate_icon_option'] == 'minimal') {
    $icon_size='16';
    $rounded= '';
  }


  else {
    $icon_size='24';
    $rounded= ' -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px;';

  }

  // Les réseaux sociaux
  foreach(wes_get_sn_list() as $sn) {
    // Création des URL et Liens pour les réseaux sociaux
    if ($SV['corporate_sn_'.$sn['name']]) {
      $SV['corporate_sn_'.$sn['name'].'_url'] = esc_url($SV['corporate_sn_'.$sn['name']]);
      $SV['corporate_sn_'.$sn['name'].'_link'] = $SV['corporate_sn_'.$sn['name'].'_url']?"<span><a href='".$SV['corporate_sn_'.$sn['name'].'_url']."'><img moz-do-not-send='true' width=".$icon_size." height=".$icon_size." class='dontcache' src='".WES_URL."img/social-icons/". $SV['corporate_icon_option']."/".$sn['icon']."' alt='".$sn['name']."' style='border: 0;".$rounded ."' moz-do-not-send='false'></a>":"";
    }
  }

  return $SV;

}

/*
 * Récupération du tableau des valeurs de signature
 * Toutes les valeurs sont échappées...
 */
function wes_getSignatureValues($user) {

     // On inclus les données Corp
  $SV = wes_getCorpValues();

  $t = get_the_author_meta('wes_avatar_upload_meta', $user->ID);
  $t = $t?$t:get_the_author_meta('wes_avatar_meta', $user->ID);
  $SV['avatar_url'] = esc_url($t?$t:"");

  $SV['first_name'] = esc_attr(get_the_author_meta('first_name', $user->ID));
  $SV['last_name'] = esc_attr(get_the_author_meta('last_name', $user->ID));
  $SV['first_last_name'] = $SV['first_name']." ".$SV['last_name'];
  $SV['position'] = esc_attr(get_the_author_meta('wes_position_meta', $user->ID));
  $SV['gsm'] = esc_attr(get_the_author_meta('wes_gsm_meta', $user->ID));
  $SV['profile_phone'] = esc_attr(get_the_author_meta('wes_phone_meta', $user->ID));

  $SV['skype'] = esc_attr(get_the_author_meta('wes_skype_meta', $user->ID));
  $SV['twitter'] = esc_attr(get_the_author_meta('wes_twitter_meta', $user->ID));
  // $SV['corporate_phone'] = esc_attr(get_option('corporate_phone'));
  $SV['email'] = esc_attr(get_the_author_meta('user_email', $user->ID));

  // Les divers moyen de communiquer
  $SV['skype_url'] = $SV['skype']?esc_attr("skype:".$SV['skype']):"";
  $SV['twitter_url'] = $SV['twitter']?esc_attr("twitter:".$SV['twitter']):"";

   if ($SV['corporate_icon_option'] == 'small') {
    $icon_size ='16';
    $rounded = '';
    }
    elseif ($SV['corporate_icon_option'] == 'minimal') {
    $icon_size ='16';
    $rounded = '';
    }
    else {
    $icon_size ='24';
    $rounded = ' -webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; ';
    }


  // Création des liens si ils existent
  $SV['si_twitter'] = $SV['twitter_url']?"<a href='".$SV['twitter_url']."'><img width=".$icon_size." height=".$icon_size." moz-do-not-send='true' style='dontcache ".$rounded  .";' width:".$icon_size."px; height:".$icon_size."px;' src='".WES_URL."img/social-icons/". $SV['corporate_icon_option']."/twitter.png' moz-do-not-send='false' alt='Twitter'></a>":"";
  $SV['si_skype']=$SV['skype_url']?"<span><a href='".$SV['skype_url']."'><img width=".$icon_size." height=".$icon_size." moz-do-not-send='true' style='dontcache ".$rounded  ."; width:".$icon_size."px; height:".$icon_size."px;' src='".WES_URL."img/social-icons/". $SV['corporate_icon_option']. "/skype.png' moz-do-not-send='false' alt='Skype'></a>":"";
  


  //Lien QrCode !!!
  $SV['author_url'] = home_url(wes_oxygen_compatibility_profile() . '/?wes_profile=' . $user->ID . '&user_id='.$user->ID);
  $SV['author_url'] = esc_url($SV['author_url']);
  $SV['author_url_qrcode'] = home_url(wes_oxygen_compatibility_profile() . '/?wes_profile=' . $user->ID . '&user_id='.$user->ID);


  $SV['qrcode_url'] = esc_url(WES_URL.'Qrcode.php'."?wes_qrurl=".$SV['author_url_qrcode']);
  $SV['vcard_url'] = esc_url(wes_getVCardUrl().'/'.get_the_author_meta('user_login', $user->ID).'.vcf');
  $SV['si_vcard']="<a href='".$SV['author_url']."' target='_blank'><img width=".$icon_size." height=".$icon_size." moz-do-not-send='true' style='".$rounded ." width:".$icon_size."px; height:".$icon_size."px;' src='".WES_URL."img/social-icons/". $SV['corporate_icon_option']."/vCard.png' moz-do-not-send='false' alt='Vcard'></a>";

  return $SV;
}

/*
 * Affichage de la signature du profil
 * Cette fonction va devoir "catcher" le résultat d'un template afin de préserver
 * la cohérence du contenu des fichiers de template !
 */
function wes_getEmailSignature($user) {

  /*
   * Création de la valeur de retour
   */
  ob_start();

  // On récupère les valeurs de l'utilisateur
  $SV = wes_getSignatureValues($user);

  // On va récupérer la liste des templates
  include_once WES_DIR . 'template/wes_signatures.php';

  // Puis localiser celui de l'utilisateur
  $sigFiles = wes_get_signatureFiles();
  $selected_sig = get_the_author_meta('wes_signature_type', $user->ID);
  $selected_sig = $selected_sig ?$selected_sig : $sigFiles[0]['name'];

  foreach ($sigFiles as $sig) {
    if ($sig['desc']==$selected_sig) $selected_file = $sig['file'];
  }

// Et on utilise le template que l'utilisateur a sélectionné.

//include_once $selected_file;

// Puis, le bouton pour aller voir les autres signatures

// Compatibility Oxygen // Gérald 04/04/2022

?>

<br />
<body bgcolor = '#f5f5f5'>
<div style="background-color:#ffffff; width:600px; margin-left:auto; margin-right:auto; border:1px solid #cacaca; padding:30px;">
   
    <div style=" font-weight:200; text-align:center; font-size: 24px; font-family: Arial, Helvetica, sans-serif; margin-bottom:20px; width:600px colr:#666666;">
     <?php _e('Your Email signature', 'campaigndot');?>
    </div>
  
    <div style=" font-weight:200; text-align:center; font-size: 14px; font-family: Arial, Helvetica, sans-serif; margin-bottom:30px; width:600px colr:#666666;">
    <?php _e('Simply copy the signature and paste it in your preferences/signatures/ panel', 'campaigndot');?>
    </div>
    
    <div style="margin-left:auto; margin-right:auto; margin-bottom:30px;">
        <?php include_once $selected_file; ?>
    </div>

    <div style="background-color:#006494; padding-top: 10px; padding-right: 20px; padding-bottom: 10px; padding-left: 20px; margin-left:auto; margin-right:auto; width:200px; text-align:center; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px;">
    <a id="i5" style="font-family: Arial, Helvetica, sans-serif; font-size:14px; text-align:center; text-decoration:none; font-weight:600; letter-spacing:0.02em; color:#fff;" href="<?php echo esc_url(home_url(wes_oxygen_compatibility_template().'/?wes_template=1&user_id='.$user->ID));?>"><?php _e('View online', 'campaigndot');?></a>
    </div>

</div>


<?php

  // On récupère le contenu
  $val = ob_get_clean();
  
  /*
   * Et on retourne la valeur à qui de droit...
   */
  return $val;
}

/*
 * Sauvegarde des options de signature
 */
function wes_save_signature( $user_id ) {

  if ( !current_user_can( 'edit_user', $user_id ) )
    return false;

  // Création de la VCard
  $wes_vcard_file = wes_getVCardDir()."/".get_the_author_meta('user_login', $user_id).'.vcf';
  include_once (WES_DIR.'include/vCard.class.php');

  $vCard = new vCard();
  
  // On récupère les infos utilisateur
  $User = new WP_User($user_id);
  $SV = wes_getSignatureValues($User);

//Get the avatar as base64. Amendment Gérald 03/2022

// error_log($SV['avatar_url']);

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 

if(!empty($SV['avatar_url'])){
$wes_profile_image = file_get_contents($SV['avatar_url'],false, stream_context_create($arrContextOptions));
$finfo = new finfo(FILEINFO_MIME_TYPE);
$type  = $finfo->buffer($wes_profile_image);
$wes_photo = base64_encode($wes_profile_image);
}
else{
  $wes_photo = '';
  $type = '';
}

//END Get the avatar as base64. Amendment Gérald 03/2022


  // Les infos utilisateur
  $vcardValues = array(
           'display_name' => $SV['first_last_name'],
           'first_name' => $SV['first_name'],
           'last_name' => $SV['last_name'],
           'title' => $SV['position'],
           'photo' => $wes_photo, //Get the avatar as base64. Amendment Gérald 03/2022
           'imagetype' => $type, //Get the avatar as base64. Amendment Gérald 03/2022
           'company' => $SV['corp'],
           'office_tel' => $SV['profile_phone']?$SV['profile_phone']:$SV['corporate_phone'],
           'cell_tel' => $SV['gsm'],
           'email1' => $SV['email'],
           'work_address' => $SV['corp_address_line2'],
           'work_extended_address' => $SV['corp_address_line1'],
           'work_postal_code' => $SV['corp_address_zip'],
           'work_city' => $SV['corp_address_city'],
           'url' => $SV['website'],
           );

  $vCard->set('data', $vcardValues);

  $vcardfile = fopen($wes_vcard_file, "w");
  fwrite($vcardfile, $vCard->show());
  fclose($vcardfile);

  // Puis, on l'envoie par mail si besoin
  if (array_key_exists('send_by_mail', $_POST) && $_POST['send_by_mail'] ) {
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
}

// Et les fonctions "magique" ;-)
function wpdocs_set_html_mail_content_type() {
    return 'text/html';
}

function wes_FromEmail() {
  $SV = wes_getCorpValues();
  return $SV['corp_email'];
}
function wes_FromEmailName() {
  $SV = wes_getCorpValues();
  return $SV['corp'];
}

// Il faut maintenant créer et sauvegarder la VCard
add_action( 'personal_options_update', 'wes_save_signature' );
add_action( 'edit_user_profile_update', 'wes_save_signature' );

/**
 * Affichage de la signature dans la page modification de l'utilisateur
 *
 */
function wes_signature($user) { ?> 

<div class="tab content3">
    <h3><?php echo _e('Signatures templates', 'campaigndot'); ?></h3>

<?php
include_once WES_DIR . 'template/wes_signatures.php';

$sigFiles = wes_get_signatureFiles();
$selected_sig = get_the_author_meta('wes_signature_type', $user->ID);

if($selected_sig == '' ){

$selected_sig = '2columns';
}

$selected_sig = $selected_sig ?$selected_sig : $sigFiles[0]['name'];
// echo "<p>".$selected_sig."</p>";
?>
<!-- onchange="this.form.submit.click()" -->
<div class="wes_template_img">


<?php

// print_r($sigFiles);


foreach ($sigFiles as $sig) { 
if($sig['desc']) {
  ?>
<input type="radio" id="<?php echo $sig['desc'];?>" name="signature_type" value="<?php echo $sig['desc'];?>"<?php if($sig['desc']==$selected_sig) {echo 'checked';} ?>>
<label for="<?php echo $sig['desc'];?>"><img src="<?php echo $sig['thumb'];?>" style="z-index: 100; " /><div class="kind_label" style="background-color: <?php echo $sig['color']; ?>;"><?php echo $sig['kind']; ?></div></label>
<br>
<?php } ?>
<?php
 if ($sig['desc']==$selected_sig) $selected_file = $sig['file'];
 } 
if(! function_exists( 'cdotpro_admin_scripts' ) ) { ?>

<a href="https://www.campaigndot.com" target="_blank"><img src="<?php echo WES_URL .'img/More.jpg'; ?>" width="300" height="160" style="margin-top:20px;" />

<?php } ?>


<script>
jQuery(function($){
    $('input[name="signature_type"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = "." + inputValue;
        if( typeof inputValue !== 'undefined'  && targetBox) {
        $(".signature_template").not(targetBox).fadeOut(0);
        $(".signature_template")+ $(targetBox).fadeIn(550);
      }
    });
});
</script>

</div><!--End wes_template_img -->
</div><!-- End tab content3-->

  </td>
  <!--END TD Additional data-->

<!--TD Email signature-->
  <td valign="top" style="width:100%;">

  <table style="width:100%; margin-left:auto; margin-right:auto;">
    <tr>
      <td></td>
      <td>

<!--signature_general_wrapper-->
<table id="signature_general_wrapper" >
  <tbody>
  <tr>
<td valign="top" style="padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 20px;"> 


<?php

  // Le logo
  $t = get_option('wes_logo_meta');
  $t = $t?$t:get_option('wes_logo_upload_meta');
  $SV['logo_url'] = esc_url($t?$t:WES_URL . 'img/placeholder.gif');


 // Avant d'inclure le modèle, on récupère les données utilisateur (et corp)
$SV = wes_getSignatureValues($user);

// Puis on va afficher tous les divs
 foreach ($sigFiles as $sig) { ?>

   <div id='<?php echo $sig['desc']?>' class='signature_template <?php echo $sig['desc']?>' style='<?php echo ($sig['desc']==$selected_sig)?"":"display: none;"; ?>'>
<div class="wes_signature_title_wrapper">
        <div class="kind_label_small" style="background-color: <?php echo $sig['color']; ?>;"><?php echo $sig['kind']; ?></div>
       <div class="wes_signature_title"> <?php  echo $sig['name'] ; ?></div>
     </div>


  <?php if( !empty($SV['first_name']) && !empty($SV['last_name']) && !empty($SV['logo_url']) ) {
  include_once $sig['file'];   
  }
  else { 
      echo '<div class="first_use_container_top" style="margin-bottom:30px; opacity:0.6;"><img src="' . WES_URL . 'img/tabs/alert.png" width:"50px" height="auto" /></div>';

  echo '<div class="first_use_container"><a href="#top" style="color:#333;">'.__('Please fill the first name and last name fields for this user').'</a></div>';
  if( empty($t) ) {
  echo '<div class="first_use_container"><a href="admin.php?page=corporate-main-page" style="color:#333;">'.__('Set the company information: logo, website address, phone number.').'</a></div>';
  }
}


  ?> 
   </div>
 <?php } ?>

      </td>

        </tr>
      </tbody>

    </table>

<!--END signature_general_wrapper-->

      </td>
    </tr>
    <tr>
       <th></th>
       <td style="padding-top:50px; text-align:center;">
        <div class="checkbox_style">
         <label class="switch" for="send_by_mail">
             <input type="checkbox" id="send_by_mail" name="send_by_mail" value="false"> 
               <span class="slider round"></span>
         </label>
         <?php _e('Send this signature by email', 'campaigndot'); ?>
       </div>
       </td>
    </tr>
  </table>
</td><!--END TD Email signature-->
</tr><!--END TD Email signature-->

</table><!--END global_table-->
</div><!--END wes_container-->
</div><!--END campaignDot_wrapper-->

<?php
}

// Show the new signature in the user profile page.
add_action( 'show_user_profile', 'wes_signature' );
add_action( 'edit_user_profile', 'wes_signature' );

?>