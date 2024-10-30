<?php

// Exit if accessed directly
defined( 'ABSPATH' ) OR exit;
?>
<div class="campaigndot_wrapper">
  <div class="campaigndot_head">CampaignDot Help</div>

    <div id="wes_container" class="wes_help">

  <?php 
  if (is_plugin_active('oxygen/functions.php') ) {
  $oxy_active_profile = 'campaigndot-profile';
  $oxy_active_templates = 'campaigndot-templates';
}
else {
$oxy_active_profile = '';
$oxy_active_templates = '';
}
?>  
<div style="width:100%; text-align:center;">
<img src="<?php echo WES_URL ?>/img/generic-signature.png" alt="CampaignDot Email signature" style="margin-left:auto; margin-right:auto; margin-top:80px;"/>
</div>

<p>You installed CampaignDot, here is a quick description for setting up your dynamic email signatures. </p>
<p class="more_help">For more information, thank you to consult the <a href="https://www.campaigndot.com/documentation/" target="_blank">online help page</a> .</p>
<h2>First settings</h2>
<p><strong>1) Fill the company fields</strong></p>
<p>Ideal size for the logo: 200 pixels wide.<br>
Main Color : used for text of your signature<br>
Secondary color: used for lines, social icons and Phone, Mobile, Email, Web icons.</p>
<br>
<p><strong>2) Banner</strong></p>
<p>Create a banner in an image editing software. Ideally 468px x 60px size (size is free, but these dimensions are optimal).</p>
<p>Go to the "<a href="/admin.php?page=corporate_banner_page">Banner</a>" tab and send your banner.<br>
Enter the link to which it will point when a corresponding clicks on it.</p>
<p>Check the box <em>"Check to display the banner in the email signatures"</em> if you want to show the banner under the signatures. Note that when this box is not checked, no banner will appear under the signatures.</p>
<br>
<p><strong>3) The user's profile</strong></p>
<p>Go to your <a href="<?php echo esc_url(home_url('/wp-admin/profile.php/#campaigndot_interface'));?>">profile page</a> (or a user profile you want to modify) and fill in the fields First name, name, and the additional fields added by CampaignDot: Function, Mobile Phone, Skype. </p>
<p>A field "Photo" allows to to load a profile photo that will appear on the user's front-end profile page.</p>
<p>At the bottom of each back-end profile page, the email signature appears with the banner. To use the  Email signature, check the box <em>"Send email signature"</em> and save the profile.
<br>
</p>
<p><strong>4) Integration of the Email signature</strong></p>
<p>On receipt of this email, please copy and paste the signature in the signature preference in <a href="https://www.campaigndot.com/documentation/">Mail, Outlook or Thunderbird.</a></p>
<p>This email also includes a button that gives access to <a href="<?php echo esc_url(home_url($oxy_active_templates . '?wes_template=1&user_id='.get_current_user_id()));?>">the template page</a> allowing you to copy it and download its HTML code.</p>

<p>This step must be done identically for each user profile.</p>
<p><strong>Save time for user creation</strong></p>
<p>If you have a large list of users to integrate, we recommend using the plugin <a href="https://fr.wordpress.org/plugins/import-users-from-csv-with-meta/" target="_blank">Import users from CSV with meta</a> . Use <a href="https://dl.dropboxusercontent.com/u/1745399/CampaignDot-CSV-model.csv">this CSV file</a> as a template.</p>
<p>When the import is done, desactivate the plugin Import users from CSV with meta to avoid any clonflict.</p>
<p class="more_help">For more information, thank you to consult the <a href="https://www.campaigndot.com/documentation/" target="_blank">online help page</a> .</p>
<br>
<h2> CampaignDot usage</h2>
<p><strong>Update Banner</strong></p>
<p>Once the user's Email signature is embedded, you can  change banners in <a href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=corporate_banner_page'));?>">CampaignDot interface</a>, it will automatically change in email signatures.</p>
<p><strong>The profile icon</strong></p>
<p>The email signature includes an icon that points to the profile page of each user. It is then possible for a visitor to download contact informations directly into their address book.</p>

</div>
</div>
