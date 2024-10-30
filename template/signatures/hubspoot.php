<?php

/*=================================================
=            Template name : Hoobspoot            =
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
                           <td width="150" valign="top" style="vertical-align: top; padding-left: 0px; padding-top: 6px; padding-bottom: 0px; padding-right: 40px;"  align="center">
                        
                           <img width="140" height="auto" class="dontcache" src='<?php echo $SV['logo_url'];?>' moz-do-not-send='true' alt='<?php echo $SV['corp'];?>'>
                            
                           </td>
                           <td valign="top" style="vertical-align: top; padding-left: 0px; padding-top: 10px; padding-bottom: 0px; padding-right: 0px;">
                              <table border="0" cellpadding="0" cellspacing="0" >
                                 <tbody>
                                    <tr>
                                      <!--Name, position-->
                                       <td valign="top" style="padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 0px;" size="<?php echo wes_text_style()['font-size']; ?>" >
                                          
                                          <a href="<?php echo $SV['author_url'];?>" class="wes_text_size" style="color: <?php echo $SV['color1'];?> <?php echo wes_text_style()['font-family'];?>"><span size="<?php echo wes_text_style()['font-size']; ?>" class="wes_text_size" style='color: <?php echo $SV['color1'];?>; font-weight: 600;'><?php echo $SV['first_last_name'];?></span></a>
                                         
                                         <?php if ($SV['position']) { ?><br><span class="wes_text_size" style="color: <?php echo $SV['color2'];?>; font-size: <?php echo wes_text_style()['font-size']; ?>; font-style: italic;"><?php echo $SV['position'];?></span><?php } ?>
                                          <?php if($SV['corp_address_line1']){ ?>
                                          <br>
                                          <span class="wes_text_size" style="color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>"><?php if ($SV['corp_address_line1']) { ?></span>
                                          <span class="wes_text_size" style="color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family'];?>"><?php echo $SV['corp_address_line1'];?></span>
                                          <?php } ?>
                                          <?php if ($SV['corp_address_line2']) { ?>
                                          &nbsp;<span class="wes_text_size" style="color: <?php echo $SV['color1'];?>;"><?php echo $SV['corp_address_line2'];?></span>
                                          <?php } ?>
                                          <?php if ($SV['corp_address_city']) { ?>
                                          <span style="font-size: <?php echo wes_text_style()['font-size']; ?>;" class="wes_text_size" ><?php echo $SV['corp_address_zip'];?>&nbsp;<?php echo $SV['corp_address_city'];?></span>
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
                                          <span style='color: <?php echo $SV['color2']; ?>;'>
                                             <hr>
                                          </span>
                                       </td>
                                    </tr>
                                  
                                    <tr>
                                       <td valign="top" style="padding: 0px;">
                                            
                                             <?php if ($SV['profile_phone']) { ?>
                                           <table cellpadding="6" cellspacing="0" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;">
                                               <tbody>
                                                   <tr>
                                           <td style="vertical-align: bottom;">
                                               <span color="#004457" width="11" class="contact-info__IconWrapper-sc-mmkjr6-1 bglVXe" style="display: inline-block;">
                                               <img src="<?php echo WES_URL ; ?>img/icons-hub/phone-icon-2x.webp" alt="Phone" style="display: block; background-color:<?php echo $SV['color1'];?>;" width="13">
                                               </span>
                                               </td>
                                               <td style="padding: 0px;"><a href="tel:<?php echo $SV['profile_phone'];?>" color="<?php echo $SV['color1'];?>" style="text-decoration: none; color: <?php echo $SV['color1'];?>; font-size: 12px;"><span><?php echo $SV['profile_phone'];?></span></a>
                                            </td>
                                            </tr>
                                        
                                            </tbody>
                                            </table>
                                           
                                            <?php }  ?>
                                            
                                            <?php if ($SV['gsm']) { ?>
                                           <table cellpadding="6" cellspacing="0" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;">
                                               <tbody>
                                                   <tr>
                                           <td style="vertical-align: bottom;">
                                               <span color="#004457" width="11" class="contact-info__IconWrapper-sc-mmkjr6-1 bglVXe" style="display: inline-block;">
                                               <img src="<?php echo WES_URL ; ?>img/icons-hub/phone-icon-2x.webp" alt="Phone" style="display: block; background-color:<?php echo $SV['color1'];?>;" width="13">
                                               </span>
                                               </td>
                                               <td style="padding: 0px;"><a href="tel:<?php echo $SV['gsm'];?>" color="<?php echo $SV['color1'];?>" style="text-decoration: none; color: <?php echo $SV['color1'];?>; font-size: 12px;"><span><?php echo $SV['gsm'];?></span></a>
                                            </td>
                                            </tr>
                                        
                                            </tbody>
                                            </table>
                                           
                                            <?php }  ?>
                                            
                                              <?php if ($SV['email']) { ?>
                                           <table cellpadding="6" cellspacing="0" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;">
                                               <tbody>
                                                   <tr>
                                           <td style="vertical-align: bottom;">
                                               <span color="#004457" width="11" class="contact-info__IconWrapper-sc-mmkjr6-1 bglVXe" style="display: inline-block;">
                                               <img src="<?php echo WES_URL ; ?>img/icons-hub/email-icon-2x.webp" alt="Email" style="display: block; background-color:<?php echo $SV['color1'];?>;" width="13">
                                               </span>
                                               </td>
                                               <td style="padding: 0px;"><a href="mailto:<?php echo $SV['email'];?>" color="<?php echo $SV['color1'];?>" style="text-decoration: none; color: <?php echo $SV['color1'];?>; font-size: 12px;"><span><?php echo $SV['email'];?></span></a>
                                            </td>
                                            </tr>
                                        
                                            </tbody>
                                            </table>
                                           
                                            <?php }  ?>
                                            
                                            
                                            <?php if ($SV['website']) { ?>
                                           <table cellpadding="6" cellspacing="0" style="vertical-align: -webkit-baseline-middle; font-size: medium; font-family: Arial;">
                                               <tbody>
                                                   <tr>
                                           <td style="vertical-align: bottom;">
                                               <span color="#004457" width="11" class="contact-info__IconWrapper-sc-mmkjr6-1 bglVXe" style="display: inline-block;">
                                               <img src="<?php echo WES_URL ; ?>img/icons-hub/link-icon-2x.webp" alt="Website" style="display: block; background-color:<?php echo $SV['color1'];?>;" width="13">
                                               </span>
                                               </td>
                                               <td style="padding: 0px;"><a href="<?php echo $SV['website'];?>" color="<?php echo $SV['color1'];?>" style="text-decoration: none; color: <?php echo $SV['color1'];?>; font-size: 12px;"><span><?php echo $SV['website'];?></span></a>
                                            </td>
                                            </tr>
                                        
                                            </tbody>
                                            </table>
                                           
                                            <?php }  ?>
                                            
                                            
                                            
                                       
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
            <tr>
               <td style="padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 0px;">
                  <span style='color: <?php echo $SV['color1'];?>; max-width:600px; <?php echo wes_text_style()['font-family'];?> font-size: 10px;'><?php echo $SV['legal_notice'];?></span><br>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
