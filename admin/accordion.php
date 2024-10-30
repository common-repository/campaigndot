<?php 

// Extract from wes_templates.php - Gérald 03-2022


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// On récupère les valeurs à afficher dans la table $SV
// et on prépare l'environnement d'affichage
$user = new WP_User( get_query_var("user_id") );
$SV= wes_getSignatureValues($user);

//var_dump(wes_getSignatureValues($user));

include_once WES_DIR . 'template/wes_signatures.php';

// On crée le tableau des fichiers signature
$SigFiles = wes_get_signatureFiles();

?>

<style>
html{
    background-color: #ffffff;
}
.accordion {
    width: 90%;
    max-width: 850px;
    margin: 10px auto;
    box-shadow:
        0px 0px 0px 1px rgba(155,155,155,0.3),
        0px 2px 2px rgba(0,0,0,0.1);
}
.accordion label {
    font-family: Arial, sans-serif;
    padding: 5px 20px;
    position: relative;
    display: block;
    height: 30px;
    cursor: pointer;
    color: #777;
    line-height: 20px;
    font-size: 16px;
    background: #EFEFEF;
    border: 1px solid #CCC;
    height:20px;
}
.accordion label:hover {
    background: #333333!important;
        color: #cacaca;

}
.accordion input + label {
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}
.accordion input:checked + label,
.accordion input:checked + label:hover {
    background: #333333;
    color: #cacaca;
    box-shadow:
        0px 0px 0px 1px rgba(155,155,155,0.3),
        0px 2px 2px rgba(0,0,0,0.1);
}
.accordion input {
    display: none;
}
.accordion .article {
    background: rgb(255, 255, 255);
    overflow: hidden;
    height: 0px;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.accordion .article p {
    margin: 2px;
    font-size: 14px;
}
.accordion input:checked ~ .article {
    -webkit-transition: all 0.5s ease-in-out;
    -moz-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    -ms-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
      padding: 0px;
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
  background-color:#cacaca;
        padding: 10px;

}

.accordion input:checked ~ .article.ac-small {
    height: 330px;
}
.accordion input:checked ~ .article.ac-medium {
    height: 295px;
}
.accordion input:checked ~ .article.ac-large {
    height: 345px;
}
#signature{
    padding: 10px;

}
.logo{
  margin-left:auto;
  margin-right:auto;
  text-align:center;
  margin-top:20px;
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
  background-color:#0061a7;
  -moz-border-radius:3px;
  -webkit-border-radius:3px;
  border:none;
  border-radius:3px;
  display:inline-block;
  cursor:pointer;
  color:#ffffff;
  font-size:11px;
  padding:3px 6px;
  text-decoration:none;
}
button:hover {
  background-color:#007dc1;
}
button:active {
  position:relative;
  top:1px;
}

</style>

</head>
<body>
    <div class="global_wrapper">


<div class="container">
<div class="accordion">

<?php
  // Now, looping on SigFiles
$tabID = 0;
foreach ($SigFiles as $sf) {
  $tabID += 1;
  ?>
  
      <div>
 <input type="radio" id="tab-<?php echo $tabID;?>" name="tab-group-1"<?php echo ($tabID == 1)?" checked":"";?>>
      <label for="tab-<?php echo $tabID;?>"><?php echo $sf['desc'];?></label>
<div class="article ac-small">
             	<div class="tools">
 <?php if ($sf['DL'] == true) { ?>
                <button  class="tool_btn btn" onClick="download<?php echo "_".$sf['name'];?>()"> <i class="fa fa-cloud-download"></i>&nbsp;HTML</button>
  <?php } ?>
 
 <?php if ($sf['copy'] == true) { ?>
                <button  class="tool_btn btn" id="<?php echo $sf['name']."_";?>copy-button" data-clipboard-target="#<?php echo $sf['name']."_";?>signature"><i class="fa fa-mouse-pointer
"></i>&nbsp;<?php _e('Copy', 'campaigndot');?></button>
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




                        <script>
                        (function(){
                        new Clipboard('#<?php echo $sf['name']."_";?>copy-button');
                        })();
                        </script>

                        <script>
                       function download<?php echo "_".$sf['name'];?>(){
                        var a = document.body.appendChild(
                        document.createElement("a")
                        );
                        var html = document.getElementById("<?php echo $sf['name']."_";?>signature").innerHTML;
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

              <div id="<?php echo $sf['name']."_";?>signature">
                <?php
                 include_once WES_DIR . '/template/' . $sf['file']; ?>
          	</div>
      </div><!--/content-->
      </div>
<?php } ?>
</div>
</div>