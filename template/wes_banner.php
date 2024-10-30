<?php
/*
 * banner display page
 *
 * @package: campaigndot
 */
$banner = get_query_var('wes_banner', 0);
$type = get_query_var('type');
$o = get_query_var('o',0);


  // On récupère les infos Corporate
  $SV = wes_getCorpValues($o);

  // Puis on va soit afficher l'image, soit rediriger vers le lien
  if ($type == 'url') {
    if ($o != 0) {
      // Ici, on va pouvoir saisir des infos concernant les stats de click des bannières
      wes_statsClick($o, 1);
    }
    // et puis faire la redirection elle-même
    // Correction Issue #121
    if ($SV['banner_link'] == "")
      $redirect_to=home_url();
    else
      $redirect_to=$SV['banner_link'];

    wp_redirect($redirect_to);
    exit;
  } elseif ($type == 'img') {
    if ($SV['banner_display'] && $SV['banner_url'] /* && function_exists('wes_check_version') && wes_check_version() */ ) {
      // Pour le moment, on est assez brutal là ...
      if ($o != 0) {
	// Ici, on va pouvoir saisir des infos concernant les stats de click des bannières
	wes_statsDisplay($o, 1);
      }
      wp_redirect($SV['banner_url']);
      exit;
    } else {
      wp_redirect(WES_URL . "img/placeholder.gif");

      // // On ne compte pas cet affichage ...
      // $fname=WES_DIR . "img/placeholder.gif" ;


      // // On commence par inclure la fonction qui gère les types mime
      // include_once (WES_DIR.'include/mime_function.php');

      // // On prépare le header qui va bien
      // header("Content-Type: " . mime_content_type($fname));
      // header("Content-Length: " . filesize($fname));

      // $fp = fopen($fname,'rb');
      // fpassthru($fp);
      exit;
    }
  } elseif ($type == 'title') {
    // Ici, il faut récupérer le titre, avant d'injecter le script
    $title = array_key_exists('banner_title', $SV)?$SV['banner_title']:__('See', 'campaigndot');
    $title = esc_attr($title);
    $title = preg_replace('/&#039;/', "\'", $title);
    $title = preg_replace('/&quot;/', "\"", $title);
    echo "var e=document.getElementById('wes_banner_link');e.setAttribute('title', '".$title."');e.setAttribute('alt', '".$title."');";
    exit;
  }

?>
