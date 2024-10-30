<?php
/*
 * Template for signature page
 *
 * @package: woc_email_signature
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 

?>

<div id="signature" class="wes_text_size" style="font-size:<?php echo wes_text_style()['font-size']; ?>;">
  <table id="signature_wrapper" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td valign="top" style="<?php echo  wes_text_style()['font-family']; ?> padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 0px;">

  
<a href='<?php echo $SV['author_url'];?>' style='color: <?php echo $SV['color1'];?><?php echo wes_text_style()['font-family']; ?>'><span class="wes_text_size" style='color: <?php echo $SV['color1'];?>; font-weight: bold; <?php echo wes_text_style()['font-family']; ?>'><?php echo $SV['first_last_name'];?></span></a>&nbsp;-
<span class="wes_text_size"><?php echo $SV['position'];?></span><br>

  <?php if ($SV['corp_address_line1']) { ?>
<span class="wes_text_size" style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family']; ?> '><?php echo $SV['corp_address_line1'];?></span><br>
 <?php } ?>
 
<?php if ($SV['corp_address_line2']) { ?>
    <span class="wes_text_size" style =' color: <?php echo $SV['color1'];?>;<?php echo wes_text_style()['font-family']; ?>'><?php echo $SV['corp_address_line2'];?></span><br>
 <?php } ?>

  <?php if ($SV['corp_address_zip']) { ?>
<span class="wes_text_size" style ='lcolor: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family']; ?>'><?php echo $SV['corp_address_zip'];?>&nbsp;<?php echo $SV['corp_address_city'];?></span><br>
  <?php } ?>

   <?php if ($SV['corporate_phone']) { ?>
  <span class="wes_text_size" style ='color: <?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family']; ?> '><?php _e('T. : ', 'campaigndot');?></span>
    <a  class="wes_text_size" href='tel:<?php echo $SV['corporate_phone'];?>' style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family']; ?>'>
<?php echo $SV['corporate_phone'];?></a><br>
 <?php } ?>

 <?php if ($SV['profile_phone']) { ?>
    
  <span class="wes_text_size" style ='color: <?php echo $SV['color2'];?>;<?php echo wes_text_style()['font-family']; ?>'><?php _e('T. : ', 'campaigndot');?></span>
<a  class="wes_text_size" href='tel:<?php echo $SV['profile_phone'];?>' style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family']; ?>'>
  <?php echo $SV['profile_phone'];?></a><br>
  <?php } ?>

   <?php if ($SV['gsm']) { ?>

<span class="wes_text_size" style ='color: <?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family']; ?> '><?php _e('Mobile : ', 'campaigndot');?></span>
<a  class="wes_text_size" href='tel:<?php echo $SV['gsm'];?>' style='color:<?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family']; ?>'><?php echo $SV['gsm'];?></a><br>
<?php } ?>

<span class="wes_text_size" style ='color: <?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family']; ?> '><?php _e('Email : ', 'campaigndot');?></span>
<a  class="wes_text_size" href='mailto:<?php echo $SV['email'];?>' style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family']; ?>'><?php echo $SV['email'];?></a>
 <?php if ($SV['website']) { ?>
  <br>
<span class="wes_text_size" style ='color: <?php echo $SV['color2'];?>; <?php echo wes_text_style()['font-family']; ?> '><?php _e('Website : ', 'campaigndot');?></span>
<a  class="wes_text_size" href='<?php echo $SV['website'];?>' style='color: <?php echo $SV['color1'];?>; <?php echo wes_text_style()['font-family']; ?>'><?php echo $SV['website'];?></a>
<?php } ?>

   </td>
   </tr>
   </tbody>
   </table>

</div>