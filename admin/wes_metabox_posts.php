<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Add a new Metabox for editing posts, allowing to create a banner
 *
 * 
 */
function add_banner_meta_box( $post ) {
    add_meta_box( 
        'wes-banner-metabox',
        __( 'CampaignDot Banner', 'campaigndot' ),
        'wes_BannerMetabox',
        'post',
        'normal',
        'default'
    );
}

add_action( 'add_meta_boxes_post', 'add_banner_meta_box' );
add_action('save_post', 'wes_BannerMetaboxSave');

// The datepicker
function wes_datepicker_setup() {
?>

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('.datepicker').datepicker({
      dateFormat : '<?php 

      $currentLanguage = get_bloginfo('language');

      if ($currentLanguage == 'fr-FR'){
        $date_format_corrige = 'dd/mm/yy';
      }
      else {
        $date_format_corrige = 'mm/dd/yy';
      }




      _e($date_format_corrige, 'campaigndot');?>',
    <?php _e('firstDay: 0', 'campaigndot');?>,
    <?php _e('dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]', 'campaigndot');?>,
          <?php _e('dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ]', 'campaigndot');?>,
          <?php _e('dayNamesShort: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ]', 'campaigndot');?>,
          <?php _e('monthNames: [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]', 'campaigndot');?>,
          <?php _e('monthNamesShort: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ]', 'campaigndot');?>,
    });
  });
</script>

<?php
}

add_action('admin_footer', 'wes_datepicker_setup');

/**
 * Render the metabox
 */
function wes_BannerMetabox($post) {
  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'wes_banner_metabox', 'wes_banner_metabox_nonce' );
 
  // The created banner of the post, if any
  // $value = get_post_meta( $post->ID, 'wes_banner_image', true );

  // The uploaded banner of the post, if any
  $wes_banner_upload = get_post_meta($post->ID, 'wes_banner_upload', true );
  $wes_banner_upload_edit = get_post_meta($post->ID, 'wes_banner_upload_edit', true );

  $wes_banner_start_date = get_post_meta($post->ID, 'wes_banner_start_date', true );
  $wes_banner_end_date = get_post_meta($post->ID, 'wes_banner_end_date', true );

  // If image exists, we send, however we change
  if (!$wes_banner_upload) {
    $btn_text = __('Choose Banner', 'campaigndot');
  } else {
    $btn_text = __('Change banner', 'campaigndot');
  }
  // Display the form
  ?>
  <div id="wes_banner_uploading">
    <div class="showdiv">
    <h3><?php _e('Choose a banner', 'campaigndot');?></h3>
  </div>
       <!-- Outputs the image after save -->
       <div id="current_img" class="showdiv" >
       <?php if($wes_banner_upload): ?>
          <img src="<?php echo esc_url( $wes_banner_upload ); ?>" class="wes-current-img">
         
       <?php else : ?>
          <img src="<?php echo WES_URL . 'img/placeholder.gif'; ?>" class="wes-current-img placeholder">
       <?php endif; ?>
       </div>

       <!-- Hold the value here if this is a WPMU image -->
       <div id="wes_post_upload">
         <input type="hidden" name="wes_placeholder_meta" id="wes_placeholder_meta" value="<?php echo WES_URL . 'img/placeholder.gif'; ?>" class="hidden" />
         <input type="hidden" name="wes_upload_meta" id="wes_upload_meta" checked value="<?php echo esc_url_raw( $wes_banner_upload); ?>" class="hidden" />

         <input type="hidden" name="wes_upload_edit_meta" id="wes_upload_edit_meta" value="<?php echo esc_url_raw( $wes_banner_upload_edit ); ?>" class="hidden" />
         <div class="showdiv">
         <input type='button' class="wes_wpmu_button button-primary" value="<?php echo $btn_text; ?>" id="uploadimage"/><br />
       </div>
       </div>  

     <br> 
<!-- -->
<div class="showdiv">
  <h3><?php 
   _e('Select publication dates', 'campaigndot');?></h3>
  <div class="wpbd_date_window">
  
    <div class="cpt_date_label">
    <span class="fa fa-calendar"></span>
     <label for="wes_banner_start_date"><?php _e('Start date', 'campaigndot');?></label>
   </div>
      <div class="cpt_date_input">

     <?php $sdate = ($wes_banner_start_date) ? date(__('m/d/Y','campaigndot'), $wes_banner_start_date):"" ; ?>

     <input id="wes_banner_start_date" class="datepicker" name="wes_banner_start_date" value="<?php echo $sdate;?>"><span class="description">&nbsp;
       <?php

      $currentLanguage = get_bloginfo('language');

      if ($currentLanguage == 'fr-FR'){
        $date_format_corrige = 'dd/mm/yy';
      }
      else {
        $date_format_corrige = 'mm/dd/yy';
      }

      _e( 'Format : '.$date_format_corrige, 'campaigndot'); ?>


     </span>
     </div>

     
     <br />
    <div class="cpt_date_label">
    <span class="fa fa-calendar"></span>
     <label for="wes_banner_end_date"><?php _e('End date', 'campaigndot');?></label>
   </div>
   
   <div class="cpt_date_input">
       
     <?php $edate = ($wes_banner_end_date) ? date(__('m/d/Y','campaigndot'), $wes_banner_end_date):"" ; ?>
     
     <input id="wes_banner_end_date" class="datepicker" name="wes_banner_end_date" value="<?php echo $edate;?>"><span class="description">&nbsp;
      <?php

      $currentLanguage = get_bloginfo('language');

      if ($currentLanguage == 'fr-FR'){
        $date_format_corrige = 'dd/mm/yy';
      }
      else {
        $date_format_corrige = 'mm/dd/yy';
      }

      _e( 'Format : '.$date_format_corrige, 'campaigndot'); ?></span>
   </div>

</div>
</div>

 <div id="wes_banner_creating" class="showdiv">
    <h3><?php _e('Or choose a premade banner', 'campaigndot');?></h3>

<?php 
if(wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'campaigndot_banner' )) {
     $image_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'campaigndot_banner' );
     $image = $image_array[0]; 
     $image_array_big = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
     $image_array_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );
     $image_big = $image_array_big[0]; 
     $image_thumb = $image_array_thumb[0];
}
else{
    $image = '';
}
   ?>

 <div id="small_create_banner" class="small_create_banner" style="background-color:#f5f5f5;">
         <img src="<?php echo $image; ?>" id="small_wes_image_banner" style="height:60px; float:left; margin-right:10px;" />
<div class="small_banner_content">
        <div class="small_banner_title" style="float:left;"><?php the_title(); ?></div>
      </div>
        <img src="<?php echo WES_URL . 'img/arrow.png'; ?>" class="small_bannere_arrow" />
    </div>
 

    
    <input type='button' onclick="testScrnShot();" class="wes_wpmu_button_canvas button-primary" value="<?php _e('Generate banner', 'campaigndot');?>" id="uploadimage"/><br />

    <div id="create_banner" class="create_banner" style="background-color:#f5f5f5;visibility:collapse;">
         <img src="<?php echo $image; ?>" id="wes_image_banner" style="height:60px; float:left; margin-right:10px;" />
<div class="banner_content">
        <div class="banner_title" style="float:left;"><?php the_title(); ?></div>
      </div>
        <img src="<?php echo WES_URL . 'img/arrow.png'; ?>" class="bannere_arrow" />
    </div>

   </div>
 </div>


<script type="text/javascript">
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

  </div>

  
<?php
}

/**
 * Save the metabox content
 */
function wes_BannerMetaboxSave($post_id) {

  /*
   * We need to verify this came from our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */
 
  // Check if our nonce is set.
  if ( ! isset( $_POST['wes_banner_metabox_nonce'] ) ) {
    return $post_id;
  }
 
  $nonce = $_POST['wes_banner_metabox_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'wes_banner_metabox' ) ) {
    return $post_id;
  }
 
  /*
   * If this is an autosave, our form has not been submitted,
   * so we don't want to do anything.
   */
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return $post_id;
  }
 
  // Check the user's permissions.
  if ( 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return $post_id;
    }
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return $post_id;
    }
  }
 
  /* OK, it's safe for us to save the data now. */
  // Get the date in __(m/d/Y) format
  $sdate = sanitize_text_field( $_POST['wes_banner_start_date'] ) ;
  $edate = sanitize_text_field( $_POST['wes_banner_end_date'] ) ;
  // , and convert into timestamp
  if ($sdate) {
    $sdate = strptime($sdate, __('%m/%d/%Y', 'campaigndot'));
  }
  if (is_array($sdate)) {
    $stimestamp = mktime(0, 0, 0, $sdate['tm_mon']+1, $sdate['tm_mday'], $sdate['tm_year']+1900);
    // Update the meta fields.
    update_post_meta( $post_id, 'wes_banner_start_date', $stimestamp);
  } else delete_post_meta($post_id, 'wes_banner_start_date');

  // , and convert into timestamp
  if ($edate) {
    $edate = strptime($edate, __('%m/%d/%Y', 'campaigndot'));
  }
  if (is_array($edate)) {
    $stimestamp = mktime(0, 0, 0, $edate['tm_mon']+1, $edate['tm_mday'], $edate['tm_year']+1900);
    // Update the meta fields.
    update_post_meta( $post_id, 'wes_banner_end_date', $stimestamp);
  } else delete_post_meta($post_id, 'wes_banner_end_date');


    update_post_meta($post_id, 'wes_banner_upload', $_POST['wes_upload_meta']);

  update_post_meta($post_id, 'wes_banner_upload_edit', $_POST['wes_upload_edit_meta']);
}

function send_to_canvas($post_id) {

//require( 'wp-load.php' );

  //HANDLE UPLOADED FILE
    $upload_dir = wp_upload_dir();
    $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;
    $upload_fichier_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['url'] ) . DIRECTORY_SEPARATOR;
    $image_parts = explode(";base64,",$_POST['image']);
    $decoded = base64_decode($image_parts[1]);
    $filename = 'campaigndot.jpg';

   $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;
    $image_upload = file_put_contents( $upload_path . $hashed_filename, $decoded ); 
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');

    // Without that I'm getting a debug error!?

        $file             = array();
        $file['error']    = '';
        $file['tmp_name'] = $upload_path . $hashed_filename;
        $file['name']     = $hashed_filename;
        $file['type']     = 'image/jpg';
        $file['size']     = filesize( $upload_path . $hashed_filename );
        // upload file to server

        // use $file instead of $image_upload
        $file_return = wp_handle_sideload( $file, array( 'test_form' => false ) );
        $filename = $file_return['file'];
        $lien_fichier = $upload_fichier_path . basename($filename);
        $attachment = array(
                                             'post_mime_type' => $file_return['type'],
                                             'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                                             'post_content' => $post_id,
                                             'post_status' => 'inherit',
                                             'guid' => $upload_dir['url'] . '/' . basename($filename)
                                             );

        $attach_id = wp_insert_attachment( $attachment, $filename );
        /// generate thumbnails of newly uploaded image
        $attachment_meta = wp_generate_attachment_metadata($attach_id, $filename );
       
        update_post_meta( $post_id, 'wes_banner_upload', $lien_fichier);

       // $lien_edit_fichier = '/wp-admin/upload.php?item=' . $attach_id . '&action=edit&mode=edit';
       // update_post_meta( $post_id, 'wes_banner_upload_edit', $lien_edit_fichier);
      
        wp_update_attachment_metadata($attach_id,$attachment_meta);
       // set_post_thumbnail($post_id,$attach_id);

        ?>
    <script>
  jQuery(window).ready(function($){
  jQuery('.wes_wpmu_button_canvas').on('click', function( event ){
 
    event.preventDefault();
 
    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }
 
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( 'uploader_title' ),
      button: {
        text: jQuery( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
 
      // Do something with attachment.id and/or attachment.url here
      // write the selected image url to the value of the #wes_meta text field
      jQuery('#wes_meta').val('');
      jQuery('#wes_upload_meta').val(attachment.url);
      jQuery('#wes_upload_edit_meta').val('/wp-admin/post.php?post='+attachment.id+'&action=edit&image-editor');
      jQuery('.wes-current-img').attr('src', attachment.url).removeClass('placeholder');
    });
 
    // Finally, open the modal
    file_frame.open();
  });

            });
          

        </script>

        <?php 

     }

add_action ('wp_ajax_send_to_canvas', 'send_to_canvas') ;
add_action ('wp_ajax_nopriv_send_to_canvas', 'send_to_canvas');

