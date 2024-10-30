<?php
  // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
 }

function wes_getTableName() {
  global $wpdb, $charset_collate;

  // Le nom de la table
  return $wpdb->prefix . "wes_banner_stats";
}

function wes_getMonthsTableName() {
  global $wpdb, $charset_collate;

  // Le nom de la table
  return $wpdb->prefix . "wes_months";
}

/*
 * Destruction des tables en cas de désinstallation
 */
function wes_deleteDBTables() {
  global $wpdb, $charset_collate;

  // Ne pas tenir compte des erreurs
  $se = $wpdb->suppress_errors(true);
  
  // Pour le moment, on ne va plus faire de drop des tables
  // $wpdb->query("drop table ".wes_getTableName());
  // $wpdb->query("drop table ".wes_getMonthsTableName());

  // Puis on restore le mode d'erreur
  $wpdb->suppress_errors($se);
}

/*
 * Création des tables lors de l'activation
 */
function wes_createDBTables() {
  global $wpdb, $charset_collate;

  // Le nom de la table
  $t_name = wes_getTableName();
  $t_months_name = wes_getMonthsTableName();
  
  $t_structure = array();

  // La table des statistiques ...
  $t_structure[] = "create table if not exists ".$t_name." (id int auto_increment, primary key(id)) ".$charset_collate;
  $t_structure[] = "alter table ".$t_name." add column date timestamp not null default current_timestamp";
  $t_structure[] = "alter table ".$t_name." add column mailid int"; // Dans la requête (le user qui a la signature)
  $t_structure[] = "alter table ".$t_name." add column bannerid int"; // Dans la requête
  $t_structure[] = "alter table ".$t_name." add column userclick int"; // 0=affichage, 1=click
  $t_structure[] = "alter table ".$t_name." add column useragent text"; // HTTP_USER_AGENT
  $t_structure[] = "alter table ".$t_name." add column ip text"; // REMOTE_ADDR

  // Et la table des mois, pour faire un left-join au cas où des stats seraient absentes
  $t_structure[] = "drop table if exists ".$t_months_name; 
  $t_structure[] = "create table if not exists ".$t_months_name." (id int auto_increment, primary key(id)) ".$charset_collate;
  $t_structure[] = "alter table ".$t_months_name." add column ref text";
  $t_structure[] = "alter table ".$t_months_name." add column name text";
  $t_structure[] = "insert into ".$t_months_name." (ref, name) values ('01','Janvier'),('02', 'Fevrier'),('03', 'Mars'),('04', 'Avril'),('05', 'Mai'),('06', 'Juin'),('07', 'Juillet'),('08', 'Aout'), ('09', 'Septembre'), ('10', 'Octobre'), ('11', 'Novembre'), ('12', 'Decembre')";
  
  // Ne pas tenir compte des erreurs
  $se = $wpdb->suppress_errors(true);

  foreach ($t_structure as $q) {
    $wpdb->query($q);
  }

  // Puis on restore le mode d'erreur
  $wpdb->suppress_errors($se);
  
}

/*
 * Un affichage de la bannière
 */
function wes_statsDisplay($mailid, $bannerid) {
    global $wpdb;

    // Check if HTTP_USER_AGENT is set and assign a default value if not
    $userAgent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : 'Unknown';

    // Prepare the query
    $q = "INSERT INTO " . wes_getTableName() . " (mailid, bannerid, userclick, useragent, ip) VALUES (" . $mailid . ", " . $bannerid . ", 0, '" . $userAgent . "', '" . $_SERVER["REMOTE_ADDR"] . "')";

    // Execute the query
    $wpdb->query($q);
}

/*
 * Un click de la bannière
 */
function wes_statsClick($mailid, $bannerid) {
  global $wpdb;

  $q="insert into ".wes_getTableName() . "(mailid, bannerid, userclick, useragent, ip) values (".$mailid.", ".$bannerid.", 1, '".$_SERVER["HTTP_USER_AGENT"]."', '".$_SERVER["REMOTE_ADDR"]."' )";
  $wpdb->query($q);
}

// Delete entries from DB when deleting user

function wes_delete_stats_with_user( $user_id ) {

  global $wpdb, $charset_collate;

  // Le nom de la table
  $wes_database_table_name = $wpdb->prefix . "wes_banner_stats";

    $user_obj = get_userdata( $user_id );

    $id_user = $user_obj->ID;
    $idsss = $user_obj->user_id;


    /*Delete Data from friend table*/  
    $query_friend= $wpdb->query("DELETE FROM $wes_database_table_name where `mailid` = ".$user_obj->ID."");

}
add_action( 'delete_user', 'wes_delete_stats_with_user' );

?>
