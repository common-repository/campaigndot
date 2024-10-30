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

   <table id="signature_wrapper" border="0" cellpadding="8" cellspacing="0">
<tbody>
<tr>
<td valign="top"  align="center" style="padding-left: 0px; padding-top: 0px; padding-bottom: 0px; padding-right: 0px;">
<img src='<?php echo $SV['qrcode_url'];?>'>

  </td>
   </tr>
   </tbody>
   </table>
</div>
