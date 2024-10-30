jQuery(document).ready(function ($) {
	
	$(".frmUpload").on('submit',(function(e) {
		e.preventDefault();
		$(".upload-msg").text(wes_UploadBanner.Loading);

		var href = wes_UploadBanner.pluginsUrl;

		$.ajax({
			url: wes_UploadBanner.pluginsUrl, // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				$(".upload-msg").html(data);
			}
		});
	}
));

// Function to preview image after validation

$("#userImage").change(function() {
	$(".upload-msg").empty(); 
	var file = this.files[0];
	var imagefile = file.type;
	var imageTypes= ["image/jpeg","image/png","image/jpg"];
		if(imageTypes.indexOf(imagefile) == -1)
		{
			$(".upload-msg").html("<span class='msg-error'>" + wes_UploadBanner.PleaseSelect + "</span><br /><span>" + wes_UploadBanner.OnlyAllowed + "</span>");
			return false;
		}
		else
		{
			var reader = new FileReader();
			reader.onload = function(e){
				$(".img-preview").html('<img src="' + e.target.result + '" />');				
			};
			reader.readAsDataURL(this.files[0]);
		}
	});	
});
