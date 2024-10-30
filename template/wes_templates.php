<?php
/*
 * Template loader for signature page
 * The signature template file must containt only a <div></div> embedded data, and
 * can refer to $user (WP_User type) and $SV (array type) datas
 *
 * @package: woc_email_signature
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// On récupère les valeurs à afficher dans la table $SV
// et on prépare l'environnement d'affichage
$user = new WP_User( get_query_var("user_id") );
$SV= wes_getSignatureValues($user);

include_once WES_DIR . 'template/wes_signatures.php';

// On crée le tableau des fichiers signature
$SigFiles = wes_get_signatureFiles();

if (!is_plugin_active('oxygen/functions.php') ) { ?>
<head>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta content="True" name="HandheldFriendly">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="viewport" content="width=device-width">
<?php } ?>
<script type="text/javascript" src="<?php echo WES_URL;?>js/clipboard.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  
<title><?php echo $SV['first_last_name']; ?></title>
<!-- leave this for stats -->  



<script src="https://use.fontawesome.com/1ac6791ff7.js"></script>

<style>
html, body{
    background-color: #f5f5f5;
    line-height: inherit;
    padding-top: 80px;
}

.global_wrapper {
padding-bottom: 0px;
   background-color: #ffffff;
   width: 800px;
   margin-left: auto;
   margin-right: auto;
   -webkit-border-radius: 8px;
-moz-border-radius: 8px;
border-radius: 8px;
box-shadow: 0px 0px 11px 0px rgba(0,0,0,0.53);
-webkit-box-shadow: 0px 0px 11px 0px rgba(0,0,0,0.53);
-moz-box-shadow: 0px 0px 11px 0px rgba(0,0,0,0.53);
}

/* Icon */
label::after {
  position: absolute;
  right: 0;
  top: 0;
  margin-top:-8px;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  -webkit-transition: all .35s;
  -o-transition: all .35s;
  transition: all .35s;
}
input[type=radio] + label::after {
  content: "+";
}
input[type=radio]:checked + label::after {
  content: "-";
}

.tools{
  background-color:#33475b;
  padding: 20px;
  text-align: center;
  -webkit-border-top-left-radius: 8px;
-webkit-border-top-right-radius: 8px;
-moz-border-radius-topleft: 8px;
-moz-border-radius-topright: 8px;
border-top-left-radius: 8px;
border-top-right-radius: 8px;

}

#signature{
    padding: 10px;

}
.logo{
  margin-left:auto;
  margin-right:auto;
  text-align:center;
  margin-top:100px;
  margin-bottom:20px;
}

.modal {
    font-family: Arial, sans-serif;
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.3); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #1265ae;
    color:#ffffff;
    margin: auto;
    padding: 20px;
    width: 80%;
    max-width:250px;
     -moz-border-radius:3px;
  -webkit-border-radius:3px;
  border:none;
  border-radius:3px;

}

/* The Close Button */
.close {
    color: #ffffff;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

button{
  font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
  background-color:#ffffff;
  font-weight: 600;
  -moz-border-radius:3px;
  -webkit-border-radius:3px;
  border:none;
  border-radius:3px;
  display:inline-block;
  cursor:pointer;
  color:#33475b;
  font-size:14px;
  padding:10px 20px;
  text-decoration:none;
  opacity: 1;
}
button:hover {
    opacity: 0.6;
}
button:active {
    opacity: 0.6;
}
.copyright_campaignDot{
    text-align: center;
    width: 100%;
margin-top: 20px;
font-size:  12px;
color:  #ababab;
}

.signature_wrapper_template {
    font-family: Arial, Helvetica, sans-serif;
}

.first_use_container_top{
    width: 100%;
    text-align: center;
}
.first_use_container{
    width: 100%;
    text-align: center;

}
#signature{
     position: relative!important;
     width: 800px;
height: 400px;
}

#signature > table{
    margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  -ms-transform: translate(-50%,-50%);
  transform: translate(-50%,-50%);
}


</style>

<?php if (!is_plugin_active('oxygen/functions.php') ) { ?>
</head>
<?php } ?>
<body>
<div class="global_wrapper">
<div class="container">

<?php
  // Now, looping on SigFiles
$tabID = 0;
foreach ($SigFiles as $sf) {
  $tabID += 1;

    $selected_sig = get_the_author_meta('wes_signature_type', $user->ID);
    if($sf['name'] == $selected_sig) {
 
  ?>
  
<div>

<div class="article ac-small">
             	<div class="tools">
 <?php 

   if( !function_exists('is_plugin_active') ) {
      include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }
    
if (is_plugin_active('oxygen/functions.php') ) {
  $oxy_active_profile = 'campaigndot-profile';
  $oxy_active_templates = 'campaigndot-templates';
}
else {
$oxy_active_profile = '';
$oxy_active_templates = '';
}


/*=================================================================
=            Check browser to disable button if safari            =
=================================================================*/

function wes_get_browser_name($user_agent){
    $t = strtolower($user_agent);
    $t = " " . $t;
    if (strpos($t, 'safari'     ) ) return 'safari';   
}

/*=====  End of Check browser to disable button if safari  ======*/


        // Download as HTML
        if ($sf['DL'] == true) { ?>
        <button  class="tool_btn btn" onClick="download<?php echo "_".$sf['name'];?>()"> <i class="fa fa-cloud-download"></i>&nbsp;HTML</button>
        <?php } 


        //disable button if safari      
 //       if (wes_get_browser_name($_SERVER['HTTP_USER_AGENT']) !== 'safari') {
    //    if ($sf['copy'] == true) { ?>
            <button  class="tool_btn btn copyButton" id="<?php echo $sf['name']."_";?>copy-button" data-clipboard-target="#signature_wrapper"><i class="fa fa-mouse-pointer
        "></i>&nbsp;<?php _e('Copy', 'campaigndot');?></button>

        <button class="profile_btn"><a style="color:#33475b; text-decoration:none;" href="<?php echo home_url($oxy_active_profile.'/?wes_profile='.wp_get_current_user()->ID .'&user_id='.wp_get_current_user()->ID); ?>" target="_blank"> <i class="fa fa-user"></i>&nbsp;Profile</a></button>



<?php if( function_exists( 'cdotpro_admin_scripts' ) ) { ?>

    <button class="profile_btn qrcode"><i class="fa fa-qrcode"></i>&nbsp;QrCode</button>
 
  <?php } ?>

                        
 <div id="myModal" class="modal">
                  <!-- Modal content -->
                  <div class="modal-content">
                  <span class="close">&times;</span>
                  <p>Votre signature a été copiée.</p>
                  </div>
                  </div>

                   <script>
                    // Get the modal
                    var modal = document.getElementById('myModal');

                    // Get the button that opens the modal
                    var btn = document.getElementById("<?php echo $sf['name']."_";?>copy-button");

                    // Get the <span> element that closes the modal
                    var span = document.getElementsByClassName("close")[0];

                    // When the user clicks the button, open the modal 
                    btn.onclick = function() {
                        modal.style.display = "block";
                    }

                    // When the user clicks on <span> (x), close the modal
                    span.onclick = function() {
                        modal.style.display = "none";
                    }

                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                      }
                  </script>

         <?php 
            if (get_the_author_meta('wes_text_size', $user->ID)){
            $wes_text_size = get_the_author_meta('wes_text_size', $user->ID);
            $wes_text_size = $wes_text_size . 'pt'; 
            } 
        ?>

<script>
var clipboard = new Clipboard('.copyButton');
clipboard.on('success', function(e) {
    console.log(e);
});
clipboard.on('error', function(e) {
    console.log(e);
});
</script>



<script>
jQuery(function($){
    jQuery('.qrcode').on('click',function(){
    var content = $(this).html();
    $('.visible_div_signature').toggle( "slow");
    $('.visible_div_qrcode').toggle( "slow");
    

    });
});
</script>



                <script>
                       function download<?php echo "_".$sf['name'];?>(){
                        var a = document.body.appendChild(
                        document.createElement("a")
                        );
                        var html = document.getElementById("signature").innerHTML;
                        html = html.replace(/\s{2,}/g, ' ')   // <-- Replace all consecutive spaces, 2+
                        .replace(/%/g, '%25')     // <-- Escape %
                        .replace(/&/g, '%26')     // <-- Escape &
                        .replace(/#/g, '%23')     // <-- Escape #
                        .replace(/"/g, '%22')     // <-- Escape "
                        .replace(/'/g, '%27');    // <-- Escape ' (to be 100% safe)
      				      
      		  a.download = "<?php echo $sf['name']."_";?>signature.html";
      		  a.href = "data:text/html;charset=UTF-8," + html;
                        a.click();
                        }

                        </script>
            	</div><!--/Tools-->

              <div class="visible_div_signature">
                <?php include_once $sf['file']; ?>
          	</div>

            <div class="visible_div_qrcode" style="display:none;">
                <?php include_once WES_DIR . 'include/Qrcode.php'; ?>
               </div>
                
      </div><!--/content-->
      </div>


<?php } }?>

</div><!--global_wrapper-->
</div><!--container-->
<div class="copyright_campaignDot">
    <?php echo _e('Email signature kindly generated by <a href="https://www.campaigndot.com" target="_blank">CampaignDot</a>', 'campaigndot'); ?>
    </div>
<?php if (!is_plugin_active('oxygen/functions.php') ) { ?>
</body>
<?php } ?>
</html>
