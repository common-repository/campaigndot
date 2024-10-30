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
      <table id="signature_wrapper" border="0" cellpadding="10" cellspacing="0" width="500">
         <tbody>
            <tr>
               <td valign="top" style="padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 0px;">

                  <table border="0" cellpadding="0" cellspacing="0">
                     <tbody>
                        <tr>
                           <td width="200" valign="top" style="vertical-align: top; padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 20px;"  align="center">
                        
                           <img width="200" height="auto" class="dontcache" src='<?php echo $SV['logo_url'];?>' moz-do-not-send='true' alt='<?php echo $SV['corp'];?>'>
                              <table border="0" cellpadding="0" cellspacing="0" style="margin-top:5px;">
                                 <tr>
                                 <!--Social networks-->
                                    <?php foreach(wes_get_sn_list() as $sn) {  if (key_exists('corporate_sn_'.$sn['name'].'_link', $SV) && $SV['corporate_sn_'.$sn['name'].'_link']) {
                                       ?>
                                    <td width="20px" align="center" style="vertical-align: top; padding-left: 2px; padding-top: 0px; padding-bottom: 0px; padding-right: 2px; border: 0;"><?php echo $SV['corporate_sn_'.$sn['name'].'_link']; ?></td>
                                    <?php }} ?>
                                    <?php if ($SV['si_skype']) { ?>
                                    <td width="20px" align="center" style="vertical-align: top; padding-left: 2px; padding-top: 0px; padding-bottom: 0px; padding-right: 2px; border: 0;"><?php echo $SV['si_skype'];?></td>
                                    <?php } ?>
                                    <td width="20px" align="center" style="vertical-align: top; padding-left: 2px; padding-top: 0px; padding-bottom: 0px; padding-right: 2px; border: 0;"><?php echo $SV['si_vcard'];?></td>
                                 </tr>
                              </table>
                           </td>
                           <td valign="top" style="vertical-align: top; padding-left: 0px; padding-top: 10px; padding-bottom: 0px; padding-right: 0px;">
                              <table border="0" cellpadding="0" cellspacing="0" >
                                 <tbody>
                                    <tr>
                                      <!--Name, position-->
                                       <td valign="top" style="padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 0px;" size="<?php echo wes_text_style()['font-size']; ?>" >
                                          
                                          <a href="<?php echo $SV['author_url'];?>" class="wes_text_size" style="color: <?php echo $SV['color1'];?> <?php echo wes_text_style()['font-family'];?>"><span size="<?php echo wes_text_style()['font-size']; ?>" class="wes_text_size" style='color: <?php echo $SV['color1'];?>; font-weight: 600;'><?php echo $SV['first_last_name'];?></span></a>
                                         
                                         <?php if ($SV['position']) { ?>&nbsp;-&nbsp;<span class="wes_text_size" style="color: <?php echo $SV['color2'];?>; font-size: <?php echo wes_text_style()['font-size']; ?>; font-style: italic;"><?php echo $SV['position'];?></span><?php } ?>
                                          <?php if($SV['corp_address_line1']){ ?>
                                          <br>
                                          <span class="wes_text_size" style="color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>"><?php if ($SV['corp_address_line1']) { ?></span>
                                          <span class="wes_text_size" style="color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>"><?php echo $SV['corp_address_line1'];?></span>
                                          <?php } ?>
                                          <?php if ($SV['corp_address_line2']) { ?>
                                          &nbsp;<span class="wes_text_size" style="color: <?php echo $SV['color1'];?>;"><?php echo $SV['corp_address_line2'];?></span>
                                          <?php } ?>
                                          <?php if ($SV['corp_address_city']) { ?>
                                          <br><span style="font-size: <?php echo wes_text_style()['font-size']; ?>;" class="wes_text_size" ><?php echo $SV['corp_address_zip'];?>&nbsp;<?php echo $SV['corp_address_city'];?></span>
                                          <?php } ?>
                                          <?php } ?>
                                          <?php if ($SV['corporate_phone']) { ?><br><span class="wes_text_size" style='color: <?php echo $SV['color2'];?>;" <?php echo wes_text_style()['font-family'];?> '><?php _e('Phone : ', 'campaigndot');?></span>
                                         
                                          <a href='tel:<?php echo $SV['corporate_phone'];?>' style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <span class="wes_text_size" style='color:<?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <?php echo $SV['corporate_phone'];?>
                                          </span>
                                          </a>
                                          <?php } ?>
                                          </span>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td valign="top" style="padding: 0px; margin-top:0px;">
                                          <span style='color: <?php echo $SV['color2'];?>; ?>;'>
                                             <hr>
                                          </span>
                                       </td>
                                    </tr>
                                    <tr>
                                       <td valign="top" style="padding: 0px;">
                                          <?php if ($SV['profile_phone']) { ?>
                                          <span class="wes_text_size" style='color: <?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family'];?>'><?php _e('Phone : ', 'campaigndot');?></span>
                                          <span class="wes_text_size" style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?> '>
                                          <a href='tel:<?php echo $SV['profile_phone'];?>' style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <span class="wes_text_size" style='color:<?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <?php echo $SV['profile_phone'];?>
                                          </span>
                                          </a></span>
                                          <?php } 
                                             ?>
                                          <?php if ($SV['gsm']) { if ($SV['profile_phone']) { echo ' - '; } ?>
                                          <span class="wes_text_size" style='color: <?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family'];?>'><?php _e('GSM : ', 'campaigndot');?></span>
                                          <span class="wes_text_size" style='color: <?php echo $SV['color1'];?>;<?php echo wes_text_style()['font-family'];?>'>
                                          <a href='tel:<?php echo $SV['gsm'];?>' style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <span class="wes_text_size" style='color:<?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <?php echo $SV['gsm'];?>
                                          </span>
                                          </a></span><br>
                                          <?php } else { if ($SV['profile_phone']) {echo '<br>'; } }
                                             ?>
                                          <span class="wes_text_size" style='color: <?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family'];?>'><?php _e('Email : ', 'campaigndot');?></span>
                                          <span style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <a href='mailto:<?php echo $SV['email'];?>' style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <span class="wes_text_size" style='color:<?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <?php echo $SV['email'];?>
                                          </span>
                                          </a></span><br>
                                          <?php if($SV['website']) { ?> 
                                          <span class="wes_text_size" style='color: <?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family'];?>'><?php _e('Website : ', 'campaigndot');?></span>
                                          <span class="wes_text_size" style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?> '>
                                          <a href='<?php echo $SV['website'];?>' style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
                                          <span class="wes_text_size" style='color:<?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>'>
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

$bannere_type = get_option('bannere_type');


if ($SV['banner_display']) {
if ($SV['banner_link'] != "") { ?><a id='wes_banner_link_base64' href='<?php echo esc_url(home_url('?wes_banner=1&type=url'));?>' title='<?php echo esc_attr(get_option('corporate_banner_title')); ?>' alt='<?php echo esc_attr(get_option('corporate_banner_title')); ?>'>
<?php }

if ($bannere_type == 'base64_banner') { ?>
<img width="468" id="base64_banner" height="60" style="border: 0;" src='data:image/png;base64, <?php echo $banniere_base64; ?>' class="dontcache current_banner" moz-do-not-send="true" alt='<?php _e('See', 'wp-email-signature'); ?>'>
<?php } 

else if ($bannere_type == 'dynamic_banner') { ?>
<img width="468" id ="dynamic_banner" height="60" style="border: 0;" src='<?php echo esc_url(home_url('?wes_banner=1&type=img'));?>' class="dontcache current_banner" moz-do-not-send="true" alt='<?php echo esc_attr(get_option('corporate_banner_title')); ?>'>
<?php }

else if ($bannere_type== 'static_banner') {  ?>
   <img id = "static_banner" width="468" height="60" style="border: 0;" src='<?php echo esc_url(home_url('/wp-content/wpes-cta/cta-banner.jpg?1234'));?>' class="dontcache current_banner" nosend="1" moz-do-not-send="true" alt='<?php echo esc_attr(get_option('corporate_banner_title')); ?>'>
  
   <?php }  if ($SV['banner_link'] != "") { ?></a><?php } } //end link ?>

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
