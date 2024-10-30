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

<p>Vous avez installé CampaignDot, voici la marche à suivre pour la mise en place de vos signatures email dynamiques. </p>
<p class="more_help">Pour plus d'informations, merci de consulter la <a href="http://campaigndot.com/aide/" target="_blank">page d'aide en ligne</a>.</p>
<h2>Premiers paramétrages</h2>
<p><strong>1) Remplir les champs entreprise</strong></p>
<p>Taille du logo optimale : 200 pixels de large.<br />
Couleur principale : utilisée pour les textes de votre signature<br />
Couleur secondaire : utilisée pour les filets, les éléments indicatifs (T., M., E., W. pour Téléphone, Mobile, Email, Web).</p>
<br />
<p><strong>2) La bannière</strong></p>
<p>Créez une bannière dans un logiciel d’édition d'image de type Photoshop - idéalement au format 468px x 60 px (la taille est libre, mais ces dimensions sont optimales).</p>
<p>Allez sur l’onglet « Bannière » et envoyer votre bannière.<br />
Renseignez  le lien vers lequel celle-ci pointera lorsqu’un correspondant cliquera dessus.</p>
<p>Cocher la case &quot;<em>Cocher pour afficher la bannière dans les signatures mail</em>&quot; si vous souhaitez que la bannière s'affiche sous les signatures. Lorsque cette case n'est pas cochée, aucune bannière n'apparaitra sous les signatures.</p>
<br />
<p><strong>3) Les profils</strong></p>
<p>Allez sur votre <a href="<?php echo esc_url(home_url('/wp-admin/profile.php'));?>">page profil</a> (ou celle de l'utilisateur que vous voulez modifier) et complétez  les champs prénom,  nom, ainsi que les champs additionnels CampaignDot : Fonction, Téléphone mobile, Skype. En bas de chaque page profil, la signature Email s'affiche avec la bannière. Pour récupérer la signature Email, cocher la case : "<em>Envoyer la signature par email</em>&quot;, sauvegarder le profil.</p>
<p>Un champ &quot;Photo&quot; permet de charger une photo de profil qui apparaitra sur la page profil de l'utilisateur.</p>
<br />
<p><strong>4) Intégration de la signature Email</strong></p>
<p>A la réception de cet Email, il suffit de copier la signature et la coller comme signature dans <a href="http://campaigndot.com/aide/">Mail, outlook ou thunderbird.</a></p>
<p>Cet Email inclut un bouton qui permet d'accéder à <a href="<?php echo esc_url(home_url('?wes_template=1&user_id='.get_current_user_id()));?>">une page de modèles</a> permettant de choisir un gabarit différent de mise en page pour la signature. Une ou deux colonne, version simplifiée pour Androïd, bannière seule.</p>

<p>Cette opération doit être faite à l'identique pour chaque profil utilisateur.</p>
<p><strong>Gagner du temps pour la création des utilisateurs</strong></p>
<p>Si vous avez une liste importante d'utilisateurs à intégrer, nous vous conseillons d'utiliser le plugin <a href="https://fr.wordpress.org/plugins/import-users-from-csv-with-meta/" target="_blank">Import users from CSV with meta</a>. Utilisez <a href="https://dl.dropboxusercontent.com/u/1745399/CampaignDot-CSV-model.csv">le fichier CSV</a> comme modèle.</p>
<p>Une fois l'importation terminée, il est important de désactiver le plugin Import users from CSV with meta.</p>
<p class="more_help">Pour plus d'informations, merci de consulter la <a href="http://campaigndot.com/aide/" target="_blank">page d'aide en ligne</a>.</p>
<br />
<h2>Utilisation de CampaignDot</h2>
<p><strong>Mettre à jour la bannière</strong></p>
<p>Une fois les signatures Email intégrées par les utilisateurs, vous pouvez à tout moment changer de bannière dans l'<a href="<?php echo esc_url(home_url('/wp-admin/admin.php?page=corporate_banner_page'));?>">interface CampaignDot</a>, celle-ci changera automatiquement dans les signatures emails.</p>
<p><strong>L'icône Profil</strong></p>
<p>La signature Email inclut une icône  qui dirige vers la page profil de chaque utilisateur. Il est alors possible, pour le visiteur, de télécharger ses coordonnées directement dans son carnet d'adresse.</p>
</div>
</div>
