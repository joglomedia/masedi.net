;(function($){
	$(document).ready(function(){
		window.onload = createUploader;
	});
	 function createUploader(){            
        var uploader = new qq.FileUploader({
            element: document.getElementById('file-uploader-demo1'),
            action: popup_domination_admin_ajax,
            debug: false,
            params: {
		        action: 'popup_domination_upload_theme'
		    },
		    onComplete: function(id, fileName, responseJSON) {
		    	console.log(responseJSON);
		    	$('.qq-upload-success .qq-upload-success-text').remove();
		    	$('.qq-upload-success').append('<div class="qq-upload-success-text">Complete</div>');
		    }
        });           
      }
})(jQuery);