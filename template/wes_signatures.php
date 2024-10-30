<?php
/*
 * Signatures declaration
 *
 * @package: woc_email_signature
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function wes_get_signatureFiles() {

/*========================================================
=            Generic list of Email signatures            =
========================================================*/

// On vérifie si des signatures personnalisées existent - Gérald 04/04/2022
	$path_to_template_folder = WES_DIR . 'template/signatures/';
	$path_to_thumb = WES_URL . 'template/';

$fileList = preg_grep('/^([^.])/', scandir($path_to_template_folder));

		$SigFiles[]= '';

		foreach($fileList as $files){

				$fichier['name'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $files);
				$fichier['desc'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $files);
				$fichier['file'] = $path_to_template_folder.'/' . $files;
				$fichier['thumb'] = $path_to_thumb.'img/' . preg_replace('/\\.[^.\\s]{3,4}$/', '', $files) .'.jpg';
				$fichier['kind'] = 'Free';
				$fichier['color'] = '#52b788';
				$fichier['DL'] = true;
				$fichier['copy'] = true;

				$SigFiles[] = array( 'name' => $fichier['name'] , 'desc' => $fichier['desc'] , 'file' => $fichier['file'], 'kind' => $fichier['kind'], 'color' => $fichier['color'], 'thumb' => $fichier['thumb'], 'DL' => true , 'copy' => true );
		
		}

/*=====  End of Generic list of Email signatures  ======*/

/*====================================================
=            PRO list of Email signatures            =
====================================================*/

if( function_exists( 'cdotpro_admin_scripts' ) ) { 
	$dir = WP_PLUGIN_DIR;
	$dir_pro = $dir .'/campaigndotpro';
	$dir_img = plugins_url() .'/campaigndotpro';

		$path_to_pro_template_folder = 	$dir_pro . '/template/signatures';
		$path_to_pro_thumb = $dir_img . '/template/';
		$fileList_pro = preg_grep('/^([^.])/', scandir($path_to_pro_template_folder));

		foreach($fileList_pro as $files){

					$fichier_pro['name'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $files);
					$fichier_pro['desc'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $files);
					$fichier_pro['file'] = $path_to_pro_template_folder.'/' . $files;
					$fichier['thumb'] = $path_to_pro_thumb.'img/' . preg_replace('/\\.[^.\\s]{3,4}$/', '', $files) .'.jpg';
					$fichier['kind'] = 'Pro';
					$fichier['color'] = '#fd9e02';
					$fichier_pro['DL'] = true;
					$fichier_pro['copy'] = true;

					$SigFiles[] = array('name' => $fichier_pro['name'], 'desc' => $fichier_pro['desc'], 'file' => $fichier_pro['file'], 'kind' => $fichier['kind'], 'color' => $fichier['color'], 'thumb' => $fichier['thumb'], 'DL' => true , 'copy' => true );
		}
}

/*==========================================================
=            Custom list of Email signatures               =
==========================================================*/


if(file_exists(WP_CONTENT_DIR.'/campaigndot') && function_exists( 'cdotpro_admin_scripts' )) {
		$path_to_custom_template_folder = WP_CONTENT_DIR.'/campaigndot/signatures/';
		$path_to_custom_thumb = content_url() . '/campaigndot/';

		$fileList_custom = preg_grep('/^([^.])/', scandir($path_to_custom_template_folder));


		foreach($fileList_custom as $files){

					$fileList_custom['name'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $files);
					$fileList_custom['desc'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $files);
					$fileList_custom['file'] = $path_to_custom_template_folder.'/' . $files;
					$fichier['thumb'] = $path_to_custom_thumb.'img/' . preg_replace('/\\.[^.\\s]{3,4}$/', '', $files) .'.jpg';
					$fichier['kind'] = 'Custom';
					$fichier['color'] = '#3a86ff';
					$fileList_custom['DL'] = true;
					$fileList_custom['copy'] = true;

					$SigFiles[] = array('name' => $fileList_custom['name'], 'desc' => $fileList_custom['desc'], 'file' => $fileList_custom['file'], 'kind' => $fichier['kind'], 'color' => $fichier['color'], 'thumb' => $fichier['thumb'], 'DL' => true , 'copy' => true );

		}
}


/*=====  End of PRO list of Email signatures  ======*/

			$SigFiles = array_filter($SigFiles);
			$SigFiles = array_values($SigFiles);

 return $SigFiles;

}




