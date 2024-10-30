/*
 * Readapted from 3five cupp
 * Adapted from: http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
 * Further modified from PippinsPlugins https://gist.github.com/pippinsplugins/29bebb740e09e395dc06
 */
jQuery(document).ready(function($){
  // Uploading files
  var file_frame;

  jQuery('.wes_wpmu_button').on('click', function( event ){
     
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
          var attachment = file_frame.state().get('selection').first().toJSON();

          // Update UI elements
          jQuery('#wes_meta').val('');
          jQuery('#wes_upload_meta').val(attachment.url);
          jQuery('#wes_upload_edit_meta').val('/wp-admin/post.php?post='+attachment.id+'&action=edit&image-editor');
          jQuery('.wes-current-img').attr('src', attachment.url).removeClass('placeholder');
          jQuery('.wes-current-avatar').attr('src', attachment.url).removeClass('placeholder');

          // Send AJAX request to server to handle the file copy and replace
          jQuery.ajax({
              url: ajaxurl, // WordPress AJAX
              type: 'POST',
              data: {
                  action: 'replace_cta_banner', // The action hook name in PHP
                  image_url: attachment.url // Pass the image URL to server
              },
              success: function(response) {
                  // Handle success - You can update the UI or notify the user

              },
              error: function() {
                  // Handle error - Notify the user
                  alert('AJAX error - Failed to communicate with the server.');
              }

          });

          file_frame.close(); // Close the modal explicitly

      // Finally, open the modal
      file_frame.close();
  });
});


// Toggle Image Type
  jQuery('input[name=img_option]').on('click', function( event ){
    var imgOption = jQuery(this).val();

    if (imgOption == 'external'){
      jQuery('#wes_upload').hide();
      jQuery('#wes_external').show();
    } else if (imgOption == 'upload'){
      jQuery('#wes_external').hide();
      jQuery('#wes_upload').show();
    }

  });

    // Toggle banner mode selection
    jQuery('input[name=wes_banner_mode]').on('click', function(event) {
	var bannerMode = jQuery(this).val();

	if (bannerMode == 'static') {
	    jQuery('#wes_dynamode').hide();
	    jQuery('#wes_statmode').show();
	} else if (bannerMode == 'dynamic') {
	    jQuery('#wes_dynamode').show();
	    jQuery('#wes_statmode').hide();
	}
    });

    // And setup on initial value
    if ('static' == jQuery('input[name=wes_banner_mode]:checked').val()) {
	    jQuery('#wes_dynamode').hide();
	    jQuery('#wes_statmode').show();
    } else {
	    jQuery('#wes_dynamode').show();
	    jQuery('#wes_statmode').hide();
    }
    
  if ( '' !== jQuery('#wes_meta').val() ) {
    jQuery('#external_option').attr('checked', 'checked');
    jQuery('#wes_external').show();
    jQuery('#wes_upload').hide();
  } else {
    jQuery('#upload_option').attr('checked', 'checked');
  }

  // Update hidden field meta when external option url is entered
  jQuery('#wes_meta').blur(function(event) {
    if( '' !== $(this).val() ) {
      jQuery('#wes_upload_meta').val('');
      jQuery('.wes-current-img').attr('src', $(this).val()).removeClass('placeholder');
      jQuery('.wes-current-avatar').attr('src', $(this).val()).removeClass('placeholder');

    }
  });

// Remove Image Function
  jQuery('.edit_options').hover(function(){
    jQuery(this).stop(true, true).animate({opacity: 1}, 100);
  }, function(){
    jQuery(this).stop(true, true).animate({opacity: 0}, 100);
  });

  jQuery('.remove_img').on('click', function( event ){
    var placeholder = jQuery('#wes_placeholder_meta').val();

    jQuery(this).parent().fadeOut('fast', function(){
      jQuery(this).remove();
      jQuery('.wes-current-img').addClass('placeholder').attr('src', placeholder);
      jQuery('.wes-current-avatar').addClass('placeholder').attr('src', placeholder);
    });
    jQuery('#wes_upload_meta, #wes_upload_edit_meta, #wes_meta').val('');
  });

});
