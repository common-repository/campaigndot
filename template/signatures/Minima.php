<?php
/*=================================================
=             Template-name : Minima              =
=================================================*/

   
   // Exit if accessed directly
   if ( ! defined( 'ABSPATH' ) ) {
     exit;
   } 
   ?>

   <div id="signature" class="wes_text_size big_line_height" style="font-size:<?php echo wes_text_style()['font-size']; ?>; ">
      <table cellpadding="0" cellspacing="0" width="468">
         <tbody>
            <tr>
               <td>
                  <table id="signature_wrapper" border="0" cellpadding="0" cellspacing="0" width=624 style="width:468px; padding:0px;" >
                     <tbody>
                        <tr>
                           <td align="center" valign="center">
                                       <img width = "<?php echo wes_avatar_style()['avatar-width']; ?>" height="<?php echo wes_avatar_style()['avatar-height']; ?>" src="<?php echo wes_avatar_style()['avatar-url']; ?>" width="<?php echo wes_avatar_style()['avatar-width']; ?>px" height="<?php echo wes_avatar_style()['avatar-height']; ?>px" alt="" style="<?php echo wes_avatar_style()['rounded-image']; ?> margin-bottom:8px; width:<?php echo wes_avatar_style()['avatar-width']; ?>px; height:<?php echo wes_avatar_style()['avatar-height']; ?>px;" class="wes-current-avatar dontcache" moz-do-not-send='true' />
                           </td>
                           <td>&nbsp;</td>
                           <td valign="center">
                             
                                          <a href="<?php echo $SV['author_url'];?>" class="big_wes_text_size big_line_height" style="font-family:arial, Helvetica, sans-serif; font-size:<?php echo wes_text_style()['font-size']; ?>; line-height:1.8; font-weight: 600; color: <?php echo $SV['color1'];?>!important; text-decoration:none!important; text-underline:none!important;">
                                          <span class="big_wes_text_size big_line_height" style='text-transform: uppercase; line-height:1.8; font-family:arial, Helvetica, sans-serif; font-size:<?php echo wes_text_style()['font-size']; ?>;color:<?php echo $SV['color1'];?>; text-decoration:none; font-weight: 600; text-underline:none; '><?php echo $SV['first_last_name'];?></span></a> | <span class="big_wes_text_size big_line_height" style="line-height:1.8; font-family:arial, Helvetica, sans-serif; font-size:<?php echo wes_text_style()['font-size']; ?>; font-style: italic; font-weight: 400; color: <?php echo $SV['color2'];?>; "><?php echo $SV['position'];?><br></span>
                                 
                              <!--Company details-->
                              <?php 
                                 if ($SV['gsm']) { ?><img src="<?php echo WES_URL; ?>/img/icons-grey/004-mobile-phone.png"width="12"  height="auto" />
                              <a href='tel:<?php echo $SV['gsm'];?>' class="wes_text_size big_line_height" style='color:<?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family']; ?>'>
                              <span class="wes_text_size big_line_height" style='color:<<?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family']; ?>'><?php echo $SV['gsm'];?></span></a>
                              <?php } ?>
                              <?php if($SV['website']) { ?> 
                             &nbsp;&nbsp;<img src="<?php echo WES_URL; ?>/img/icons-grey/001-link.png" width="12"  height="auto"/>
                              <a href='<?php echo $SV['website'];?>' class="wes_text_size big_line_height" style='color:<?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family']; ?>'>
                              <span class="wes_text_size big_line_height" style='color:<?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family']; ?>'><?php 
                               $user_query_uri = $SV['website'];
                               $user_query_uri = preg_replace( "#^[^:/.]*[:/]+#i", "", $user_query_uri );
                              echo $user_query_uri;
                              ?>
                              </span>
                              </a></span>
                              <?php } ?>
                               <!--END Company details-->
                                 </td>
                        </tr>
                        <tr>
                           <td align="center" valign="middle">
                             
                               <!--Social networks-->
                                          <table border="0" cellpadding="0" cellspacing="0" >
                                             <tr>
                                                <?php foreach(wes_get_sn_list() as $sn) {  if (key_exists('corporate_sn_'.$sn['name'].'_link', $SV) && $SV['corporate_sn_'.$sn['name'].'_link']) {
                                                   ?>
                                                <td width="20px" valign="bottom" align="center" style="text-align: center; vertical-align: bottom; padding-left: 2px; padding-top: 0px; padding-bottom: 0px; padding-right: 2px; border: 0;"><?php echo $SV['corporate_sn_'.$sn['name'].'_link']; ?></td>
                                                <?php }} ?>
                                                <?php if ($SV['si_skype']) { ?>
                                                <td width="20px" align="right" valign="top" style="vertical-align: top; padding-left: 2px; padding-top: 0px; padding-bottom: 0px; padding-right: 2px; border: 0;"><?php echo $SV['si_skype'];?></td>
                                                <?php } ?>
                                                <td width="20px" align="center" valign="top" style="vertical-align: top; padding-left: 2px; padding-top: 0px; padding-bottom: 0px; padding-right: 2px; border: 0;"><?php echo $SV['si_vcard'];?></td>
                                             </tr>
                                          </table>
                                           <!--END Social networks-->
                           </td>
                           <td>&nbsp;</td>
                           <td valign="bottom">
                           </td>
                        </tr>

                  </table>
               </td>
            </tr>
            <tr> <td style="line-height:1;">&nbsp;</td></tr>
            <tr>
               <td align="center" >
               <?php

/* The banner!! */

 $banniere = file_get_contents(home_url('?wes_banner=1&type=img'));
 $banniere_base64 = base64_encode($banniere);
if ($SV['banner_display']) {
  
if (get_option('deactivate_base64_encoding') != '1') {
if ($SV['banner_link'] != "") { ?><a id='wes_banner_link_base64' href='<?php echo esc_url(home_url('?wes_banner=1&type=url'));?>' title='<?php echo esc_attr(get_option('corporate_banner_title')); ?>' alt='<?php echo esc_attr(get_option('corporate_banner_title')); ?>'><?php }?>
 <img width="468" height="60" style="border: 0;" src='data:image/png;base64, <?php echo $banniere_base64; ?>' class="dontcache current_banner" moz-do-not-send="true" alt='<?php _e('See', 'wp-email-signature'); ?>'>
<?php } 
else 
{ //if base64 is desactivated - by default
if ($SV['banner_link'] != "") { ?><a id='wes_banner_link_dynamic' href='<?php echo esc_url(get_option('corporate_banner_link'));?>' title='<?php echo esc_attr(get_option('corporate_banner_title')); ?>' alt='<?php echo esc_attr(get_option('corporate_banner_title')); ?>'><?php }?>
<img width="468" height="60" style="border: 0;" src='<?php echo esc_url(home_url('?wes_banner=1&type=img'));?>' class="dontcache current_banner" moz-do-not-send="true" alt='<?php echo esc_attr(get_option('corporate_banner_title')); ?>'>
<?php } ?>
<?php if ($SV['banner_link'] != "") { ?></a><?php } ?>
<?php } 

/* END banner!! */
?>

               </td>
            </tr>
         </tbody>
      </table>
   </div>