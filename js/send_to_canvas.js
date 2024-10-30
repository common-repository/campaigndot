    var $ = jQuery.noConflict();
    function testScrnShot() {
      html2canvas(document.getElementById("create_banner"), {
  
        onrendered: function (canvas) {
        var dataUrl = document.createElement('a');
           // document.body.appendChild(canvas);  

        dataUrl = canvas.toDataURL('image/jpeg').replace('image/jpeg', 'image/octet-stream');

      $.ajax({
            method: 'post',
            url: ajaxurl,
            data:{
              image: dataUrl,
              action: 'send_to_canvas',
              
                  }

      })
       alert('Success! You can now select the new banner in the media library.');
      }
    });   
    
  }

