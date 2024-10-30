<?php

// Exit if accessed directly
defined( 'ABSPATH' ) OR exit;

global $wes_update;
?>

<div class="wrap">
   <h2><?php _e('Some debug infos', 'campaigndot'); ?></h2>
   <p><?php _e('Essentially developped for EDD debugging ...', 'campaigndot'); ?></p>
<table border="1">
   <tr>
     <td valign="top"><b>EDD Instance</b></td>
     <td><pre><?php var_dump($wes_update); ?></pre></td>
   </tr>
   <tr>
     <td valign="top"><b>Version infos (on EDD cache)</b></td>
     <td><pre><?php $vi = $wes_update->get_cached_version_info(); var_dump($vi);?></pre></td>
   </tr>
   <tr>
     <?php $cache_key = 'wes_api_request_' . md5( serialize( $wes_update->slug . $wes_update->api_data['license'] ) );?>
     <td valign="top"><b>Other EDD cached on key=<?php echo $cache_key;?></b></td>
     <td><pre><?php $vi = $wes_update->get_cached_version_info($cache_key); var_dump($vi);?></pre></td>
   </tr>
   <tr>
     <?php $cache_key    = md5( 'wes_plugin_' . sanitize_key( 'campaigndot' ) . '_version_info' );?>
     <td valign="top"><b>Other EDD cached on key=<?php echo $cache_key;?></b></td>
     <td><pre><?php $vi = $wes_update->get_cached_version_info($cache_key); var_dump($vi);?></pre></td>
   </tr>
   <tr>
     <td valign="top"><b>transient: update_plugins</b></td>
     <td><pre><?php $update_cache = get_site_transient( 'update_plugins' ); var_dump($update_cache);?></pre></td>
   </tr>
   <tr>
     <td valign="top"><b>Last check calling</b></td>
     <td><pre><?php $var = get_site_transient( 'wes_edd_calling' ); var_dump($var);?></pre></td>
   </tr>
   <tr>
     <td valign="top"><b>Last check return</b></td>
     <td><pre><?php $var = get_site_transient( 'wes_edd_return' ); var_dump($var);?></pre></td>
   </tr>
</table>
</div>
