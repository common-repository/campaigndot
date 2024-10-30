<?php
/*
 * Template for user page
 *
 * @package: woc_email_signature
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<head>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta content="True" name="HandheldFriendly">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="viewport" content="width=device-width">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


<?php

$user = new WP_User( get_query_var("user_id") );
$SV= wes_getSignatureValues($user);


?>

<title><?php echo $SV['first_last_name']; ?></title>

<!-- leave this for stats -->  

		<?php 

		if ($SV['avatar_url']) { 
			$woc_image_entete = 'portrait';
		}
		else{
			$woc_image_entete = 'logo';
		}

		//Get the size of the logo

   $avatar_attachment_id = attachment_url_to_postid( $SV['avatar_url'] );
   $avatar_thumb = wp_get_attachment_image_src( $avatar_attachment_id, 'thumbnail' );
   //$image_url = $avatar_thumb[0];
      
   //Calcul proportions avatar
   $avatar_width = 90;
   //$avatar_prop = $avatar_width/$avatar_thumb[1];
   $avatar_height = 90;

   
   //Proportions logo
   $logo_attachment_id = attachment_url_to_postid( $SV['logo_url'] );
   $logo_thumb = wp_get_attachment_image_src( $logo_attachment_id, 'full' );
   
   $logo_width = 200;
   
   
   if (is_array($logo_thumb) && isset($logo_thumb[1], $logo_thumb[2])) {
    $prop = $logo_width / $logo_thumb[1];
    $logo_height = $logo_thumb[2] * $prop;
    $logo_small_width = 150;
    $prop_small = $logo_small_width / $logo_thumb[1];
    $logo_small_height = $logo_thumb[2] * $prop_small;
} else {
    $logo_height = '';
}

		?>


		<style>

			body {
				font-size: 15px!important;
				line-height: 1.2em!important;
				font-family: Arial, Helvetica, sans-serif;
				background-color: #f5f5f5;
				color: #444444;
			}


			a:link { text-decoration: none; }

a:visited { text-decoration: none; }

a:hover { text-decoration: none; }

a:active { text-decoration: none; }


		#primary{
			margin-top: 5%;
			margin-right: auto;
			margin-left: auto;
			text-align: left;
			padding-top: 30px;
			width: 300px;
			background-color: #ffffff;
			position: relative;
			z-index: 1000;
			-webkit-border-top-left-radius: 4px;
-webkit-border-top-right-radius: 4px;
-moz-border-radius-topleft: 4px;
-moz-border-radius-topright: 4px;
border-top-left-radius: 4px;
border-top-right-radius: 4px;
-webkit-box-shadow: 0px 0px 20px 8px rgba(202,202,202,0.42); 
box-shadow: 0px 0px 20px 8px rgba(202,202,202,0.42);
		}

		.portrait {
			width: <?php echo $avatar_width . 'px'; ?>; 
		  height: <?php echo $avatar_height . 'px'; ?>; 
			-webkit-border-radius: <?php echo $avatar_width . 'px'; ?>;
			-moz-border-radius: <?php echo $avatar_width . 'px'; ?>;
			border-radius: <?php echo $avatar_width . 'px'; ?>;
			background-image: url(<?php echo $SV['avatar_url']; ?>);
			background-size: auto <?php echo $avatar_width . 'px'; ?>;
		  background-repeat: no-repeat;
			margin-bottom: 15px;
			background-position: center; 
			background-repeat: no-repeat;
			background-size: contain;
			background-position: center center;
					margin-left: auto;
			margin-right: auto;
		}

		.logo {
			width: <?php echo $logo_width . 'px'; ?>; 
		  height: <?php echo $logo_height . 'px'; ?>; 
			margin-bottom: 20px;
			background-image: url(<?php echo $SV['logo_url']; ?>);
		  background-repeat: no-repeat;
			background-position: middle; 
			background-repeat: no-repeat;
			background-size: contain;
			background-position: center center;
			margin-left: auto;
			margin-right: auto;

		}		

		.portrait li, .logo li{
			
		}

		.button{
			padding: 18px;
			background-color:<?php echo $SV['color2']; ?>;
			margin-right: auto;
			margin-left: auto;	
			text-align: center;
			z-index: 1000;

			/*	position: absolute;
				width: 100%;*/
			color: #FFF;
			-webkit-border-bottom-right-radius: 4px;
-webkit-border-bottom-left-radius: 4px;
-moz-border-radius-bottomright: 4px;
-moz-border-radius-bottomleft: 4px;
border-bottom-right-radius: 4px;
border-bottom-left-radius: 4px;
			transition:opacity 1s;
-webkit-box-shadow: 0px 9px 15px 5px rgba(202,202,202,0.42); 
box-shadow: 0px 9px 15px 5px rgba(202,202,202,0.42);
		}

		.button:hover,
		.social_icons img:hover,
		a:hover{
			opacity: 0.7;
			transition:opacity 0.5s;
		}

		a.button {
			color: #FFF;
			text-decoration: none!important;

		}

		.author-info {
			max-width: 400px;
			margin-left: auto;
			margin-right: auto;
			text-align: left;
		}
		ul{
			padding-inline-start: 0px;
		}

		li {
			list-style: none;
		}
		hr{
border: none;
border-bottom:1px dotted <?php echo $SV['color2'];?>;		}

.qrcode_toggle{
	margin-left: auto;
	margin-right: auto;
	text-align: center;
	z-index:0;
}

.visible_div_qrcode{
		height: 100vh;
}


		</style>

</head>
<body>
<div class="qrcode_toggle">
<div id="primary" class="author-info visible_div_signature">
<table cellpadding="2" cellspacing="0" border="0" style="margin-left:auto; margin-right:auto;">
	<tr>
		<td colspan="2">
			<div class="<?php echo $woc_image_entete; ?>" >&nbsp;</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center" >
<strong><?php echo $SV['first_last_name']; ?></strong>
<?php if ($SV['position']) { ?>
	<br /><span style='font-style: italic; color: <?php echo $SV['color2'];?>;'><?php echo $SV['position']; ?></span>
<?php } ?>
<?php if ($avatar_attachment_id) { ?>
<br><hr>
<img style="margin-top:6px;" src="<?php echo $logo_thumb[0]; ?>" width="<?php echo $logo_small_width; ?>" height="<?php echo $logo_small_height; ?>">
 <?php } ?>
  <?php if ($SV['corp_address_line1'] || $SV['corp_address_line2'] || $SV['corp_address_zip'] || $SV['corp_address_city']) { ?>
 <hr>
  <?php } ?>
 </td>
 </tr>

<?php if ($SV['corp_address_line1']) { ?>
<tr>
	<td align="left" valign="middle"><img src="<?php echo WES_URL; ?>/img/icons/003-maps-and-flags.png" width="12px" height="auto"/>&nbsp;</td>
	<td valign="middle">
<span style='color: <?php echo $SV['color1'];?>;'><?php echo $SV['corp_address_line1']; ?>&nbsp;</span>
 </td>
 </tr>
 <?php } ?>

<?php if ($SV['corp_address_line2']) { ?>
	<tr>
	<td  align="left" valign="middle"><img src="<?php echo WES_URL; ?>/img/icons/003-maps-and-flags.png" width="12px" height="auto"/>&nbsp;</td>
	<td valign="middle">
<?php echo $SV['corp_address_line2']; ?>
 </td>
 </tr>
 <?php } ?>

<?php if ($SV['corp_address_zip'] || $SV['corp_address_city']) { ?>
 
 	<tr>
 			<td>&nbsp;</td>
		<td>
<?php } ?>	

 <?php if ($SV['corp_address_zip']) { ?>
<?php echo $SV['corp_address_zip']; ?>&nbsp;
 <?php } ?>
<?php if ($SV['corp_address_city']) { ?>

<?php echo $SV['corp_address_city']; ?>
 	 <?php } ?>

 <?php if ($SV['corp_address_zip'] || $SV['corp_address_city']) { ?>

 </td>
 </tr>

 <?php } ?>	

 <tr><td colspan="2"><hr></td></tr>

<?php if ($SV['corporate_phone']) { ?>
	<tr>
	<td  align="left" valign="middle"><img src="<?php echo WES_URL; ?>/img/icons/005-phone.png" width="12px" height="auto"/>&nbsp;</td>
	<td valign="middle">
<a href='tel:<?php echo $SV['corporate_phone'];?>' style='color:<?php echo $SV['color1'];?>; text-decoration: none;'><?php echo $SV['corporate_phone'];?></a>
 </td>
 </tr>
 <?php } ?>


<?php if ($SV['profile_phone']) { ?>
		<tr>
	<td  align="left" valign="middle"><img src="<?php echo WES_URL; ?>/img/icons/004-mobile-phone.png"width="12px" height="auto" /></td>
	<td valign="middle">
<a href='tel:<?php echo $SV['profile_phone']; ?>' style='color:<?php echo $SV['color1']; ?>; text-decoration: none;'><?php echo $SV['profile_phone']; ?></a></li>
 <?php } ?>
 
 <?php if ($SV['gsm']) { ?>
 		<tr>
	<td  align="left" valign="middle"><img src="<?php echo WES_URL; ?>/img/icons/004-mobile-phone.png" width="12px" height="auto"/></td>
	<td valign="middle">
<a href='tel:<?php echo $SV['gsm'];?>' style='color:<?php echo $SV['color1'];?>; text-decoration: none;'><?php echo $SV['gsm'];?></a>
  </td>
 </tr>
 <?php } ?>
  <tr><td colspan="2"><hr></td></tr>

 		<tr>
	<td  align="left" valign="middle"><img src="<?php echo WES_URL; ?>/img/icons/002-email.png" width="12px" height="auto"/></td>
	<td valign="middle">
<a href='mailto:<?php echo $SV['email'];?>' style='color:<?php echo $SV['color1'];?>; text-decoration: none;'><?php echo $SV['email'];?></a>
  </td>
 </tr>

		<tr>
	<td  align="left" valign="middle"><img src="<?php echo WES_URL; ?>/img/icons/001-link.png" width="12px" height="auto"/></td>
	<td valign="middle">

<a href='<?php echo $SV['website'];?>' style='color: <?php echo $SV['color1'];?>; text-decoration: none;'><?php echo $SV['website'];?></a></li><br />
		<tr>
	<td colspan="2">
<ul>
<li class="social_icons" style='text-align: center;'>
	<br>
<?php foreach (wes_get_sn_list() as $sn) {
  if (key_exists('corporate_sn_'.$sn['name'].'_link', $SV) && $SV['corporate_sn_'.$sn['name'].'_link']) echo $SV['corporate_sn_'.$sn['name'].'_link']."&nbsp;";
}
?>
<?php echo $SV['si_skype']?$SV['si_skype']."&nbsp;":"";?>
</li>
</ul>
</td>
</tr>

</table>
<a href="<?php echo $SV['vcard_url'];?>"><div class="button"><?php _e('Download the vCard', 'campaigndot'); ?></div></a>

           


</body>
</div>

<div class="visible_div_qrcode" style="display:none;">
	<img src="<?php echo $SV['qrcode_url'];?>" style="margin-top:5%;width:80%; max-width:350px;">
<div style="width:250px; margin-top:30px; margin-left:auto; margin-right:auto;"></div>
<?php _e('Flash this Qrcode to display this virtual business card on your screen.', 'campaigndot'); ?>
</div>
</div>


<?php if(is_plugin_active("campaigndotpro/campaigndotpro.php")) { ?>

<script>
jQuery(function($){
    jQuery('.qrcode_toggle').on('click',function(){
    var content = $(this).html();
    $('.visible_div_signature').slideToggle( "slow");
    $('.visible_div_qrcode').slideToggle( "slow");
        });

    jQuery('.button').on('click',function($){
        $.stopPropagation();
   });


});
</script>

<?php } ?>


</html>
