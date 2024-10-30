<?php
/*
 * Template for signature page
 *
 * @package: woc_email_signature
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div id="signature">

  <table id="signature_wrapper" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td valign="top" style="padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 0px;">

<?php if (/* ($SV['banner_link'] != "") && */ $SV['banner_display']) {
    if ($SV['banner_link'] != "") { ?>
      <a id='wes_banner_link' href='<?php echo esc_url(home_url('?wes_banner=1&type=url&o='.$user->ID));?>' title='<?php _e('See', 'campaigndot'); ?>' alt='<?php _e('See', 'campaigndot'); ?>'><?php } ?><img width="468" height="auto" style="border: 0;" src='<?php echo esc_url(home_url('?wes_banner=1&type=img&o='.$user->ID));?>' moz-do-not-send="true" alt='<?php _e('See', 'campaigndot'); ?>'><?php if ($SV['banner_link'] != "") {?></a><?php }?>
<script src='<?php echo esc_url(home_url('?wes_banner=1&type=title'));?>'></script>
 <?php } ?>		  

   </td>
   </tr>
   </tbody>
   </table>
            
</div>
