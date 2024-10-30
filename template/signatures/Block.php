<?php

/*=================================================
=            Template name : 2columns            =
=================================================*/

   
   // Exit if accessed directly
   if ( ! defined( 'ABSPATH' ) ) {
   exit;
   }
   
   ?>

   <div id="signature" class="wes_text_size" style="font-size-adjust: none; font-size:<?php echo wes_text_style()['font-size']; ?>;">
      <table id="signature_wrapper" border="0" cellpadding="0" cellspacing="0" width="500">
         <tbody>
            <tr>
               <td valign="top" style="padding: 0px;">
                  <table border="1" width="468" bordercolor="#ededed" cellpadding="0" cellspacing="0" style="border-collapse: collapse;" >
                     <tbody>
                        <tr>
                           <td width="130" valign="middle" style="vertical-align: center; text-align: center; padding: 20px;"  align="center">
                              <img width="130" height="auto" class="dontcache" src='<?php echo $SV['logo_url'];?>' moz-do-not-send='true' alt='<?php echo $SV['corp'];?>'>
                           </td>
                           <td valign="middle" style="padding: 10px; background-color:<?php echo $SV['color2'];?>; " size="<?php echo wes_text_style()['font-size']; ?>" >
                                          
                                          <a href="<?php echo $SV['author_url'];?>" class="wes_text_size" style="color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>"><span size="<?php echo wes_text_style()['font-size']; ?>" class="wes_text_size" style='color: white; font-weight: 600;'><?php echo $SV['first_name'];?> <span style="text-transform:uppercase;"><?php echo $SV['last_name'];?></span></span></a>
                                         
                                         <?php if ($SV['position']) { ?> <span class="wes_text_size" style="color: white; font-size: <?php echo wes_text_style()['font-size']; ?>; font-style: italic;"><?php echo $SV['position'];?></span><?php } ?>
                                          
                                          <?php if ($SV['corporate_phone']) { ?><br>
                                          <a href='tel:<?php echo $SV['corporate_phone'];?>' style='color: white; <?php echo wes_text_style()['font-family'];?>'>
                                          <span class="wes_text_size" style='color:<white; <?php echo wes_text_style()['font-family'];?>'>
                                          <?php echo $SV['corporate_phone'];?>
                                          </span>
                                          </a>
                                          <?php } ?>
                                          </span>
                                
                                          <?php if ($SV['profile_phone']) { ?><br>
                                          <span class="wes_text_size" style='fcolor: white; <?php echo wes_text_style()['font-family'];?> '>
                                          <a href='tel:<?php echo $SV['profile_phone'];?>' style='color: white; <?php echo wes_text_style()['font-family'];?>'>
                                          <span class="wes_text_size" style='color:white; <?php echo wes_text_style()['font-family'];?>'>
                                          <?php echo $SV['profile_phone'];?>
                                          </span>
                                          </a></span>
                                          <?php } 
                                             ?>
                                          <?php if ($SV['gsm']) { if ($SV['profile_phone']) { ?>
                                          <span class="wes_text_size" style='color: white;<?php echo wes_text_style()['font-family'];?>'>                                             
                                           <?php echo ' - '; } ?>
                                          </span>
                                          <span class="wes_text_size" style='color: white;<?php echo wes_text_style()['font-family'];?>'>
                                          <a href='tel:<?php echo $SV['gsm'];?>' style='color: white; <?php echo wes_text_style()['font-family'];?>'>
                                          <span class="wes_text_size" style='color:white; <?php echo wes_text_style()['font-family'];?>'>
                                          <?php echo $SV['gsm'];?>
                                          </span>
                                          </a></span><br>
                                          <?php } else { if ($SV['profile_phone']) {echo '<br>'; } }
                                             ?>
                                          
                                          <?php if($SV['website']) { ?> 
                                          <span class="wes_text_size" style='color: white; <?php echo wes_text_style()['font-family'];?> '>
                                          <a href='<?php echo $SV['website'];?>' style='color: white; <?php echo wes_text_style()['font-family'];?>'>
                                          <span class="wes_text_size" style='color:white; <?php echo wes_text_style()['font-family'];?>'>
                                          <?php echo $SV['website'];?>
                                          </span>
                                          </a></span>
                                          <?php } ?>
                                       
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
            <tr>
               <td align="left" style="padding-left: 0px; padding-top: 20px; padding-bottom: 10px; padding-right: 0px; text-align:left;">
               <?php

/* The banner!! */

 $banniere = file_get_contents(home_url('?wes_banner=1&type=img'));
 $banniere_base64 = base64_encode($banniere);
if ($SV['banner_display']) {
  
if (get_option('deactivate_base64_encoding') != '1') {
if ($SV['banner_link'] != "") { ?><a id='wes_banner_link_base64' href='<?php echo esc_url(home_url('?wes_banner=1&type=url'));?>' title='<?php echo esc_attr(get_option('corporate_banner_title')); ?>' alt='<?php echo esc_attr(get_option('corporate_banner_title')); ?>'><?php }?>
 <img width="468" height="60" style="border: 0;" src='data:image/png;base64, <?php echo $banniere_base64; ?>' class="dontcache current_banner" moz-do-not-send="true" alt='<?php _e('See', 'campaigndot'); ?>'>
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
            <tr>
               <td style="padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 0px;">
                  <span style='color: <?php echo $SV['color1'];?>; max-width:600px; <?php echo wes_text_style()['font-family'];?> font-size: 10px;'><?php echo $SV['legal_notice'];?></span><br>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
