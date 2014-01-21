/* Upload Script
----------------------------------------------------------------------------- */

	var upload = new Object();


/* Validators
----------------------------------------------------------------------------- */
	
	// File size
	upload.fileSize = function(file) {
		var mb = file.size / 1024 / 1024;
		log('This file: ' + mb + ', limit: ' + max_file_size);
		if (mb > max_file_size) {
			resen.done();
			upload.uploading = false;
			alert("The file '" + file.name + "' is too large to upload. It's " + Math.round(mb) + "MB, while the upload limit is " + max_file_size + "MB. Please resize the image and try again.");
			return false;
		}
		return true;
	};
	
	// File type
	upload.fileType = function(file) {
		if (!file.type.match(/image\/(jpeg|png|gif)/)) {
			return false;
		}
		return true;
	};	

/* Progress Indicator
----------------------------------------------------------------------------- */

	upload.progress = function(e) {
				
		if (e.lengthComputable) {
		
			// Style
			var lineWidth = 10;
	
			// Get percentage
			var percentage = Math.round(e.loaded * 100 / e.total);

			// Define canvas element
			var $canvas_element = $('#uploading canvas');
			var canvas = $canvas_element[0];
			var loadingIndicator = canvas.getContext('2d');
			
			// Get dimensions
			var width = parseInt($('#uploading canvas').width());
			var height = parseInt($('#uploading canvas').height());
			$canvas_element.prop({
				width: width,
				height: height
			});
			var center = {
				x: width / 2,
				y: height / 2
			};
			if (width >= height) {
				var radius = center.y - lineWidth / 2;			
			} else {
				var radius = center.x - lineWidth / 2;
			}

			// Refresh/Erase Canvas
			loadingIndicator.clearRect(0, 0, width, height);
			
			// Draw Path
			loadingIndicator.beginPath();
			loadingIndicator.arc(center.x, center.y, radius, 0, Math.PI * 2);
			loadingIndicator.lineWidth = lineWidth;
			loadingIndicator.lineCap = 'square';
			loadingIndicator.strokeStyle = 'rgba(0,0,0, .2)';
			loadingIndicator.stroke();
			
			// Progress Bar
			loadingIndicator.beginPath();
			loadingIndicator.arc(center.x, center.y, radius, 0 - 1.5, Math.PI * ((percentage / 100) * 2) - 1.5);
			loadingIndicator.lineWidth = lineWidth;
			loadingIndicator.lineCap = 'butt';
			loadingIndicator.strokeStyle = 'rgba(0,0,0, 1)';
			loadingIndicator.stroke();
	
		}  
	
	};
	
/* Errors
----------------------------------------------------------------------------- */

	upload.failed = function(e) {
		alert("An error occurred while uploading the file.");  
	};
	
	upload.canceled = function(e) {
		alert("The upload has been canceled by the user or the browser dropped the connection.");  
	};
	
/* Select File
----------------------------------------------------------------------------- */

	upload.selectFile = function() {

		var file = $(this)[0].files[0];

		if (upload.fileType(file)) {
			$('label.image .button.select').text(file.name).data('upload', true);
		}

	};

/* Upload File
----------------------------------------------------------------------------- */

	upload.uploadFile = function() {
	
		if ($('.image .button').data('upload')) {
		
			// Show loading indicator
			$('.form').removeClass('show');
			$('#uploading').show();
			
			// Get file info
			var file = $('input[name="upload"]')[0].files[0];
			var old_file = $('input[name="image"]').val();
			
			// Get data to send to server
			var fd = new FormData();
			fd.append('upload', file);
			fd.append('old_file', old_file); 
			fd.append('image_width', $('input[name="image_width"]').val());
			fd.append('image_height', $('input[name="image_height"]').val());
			
			if ($('input[name="thumb_width"]').length > 0) {
				fd.append('thumb', 'true');
				fd.append('thumb_width', $('input[name="thumb_width"]').val());
				fd.append('thumb_height', $('input[name="thumb_height"]').val());
			}
						
			// Send Data
			var xhr = new XMLHttpRequest();
			xhr.upload.addEventListener('progress', upload.progress, false);
			xhr.addEventListener('load', upload.complete, false);
			xhr.addEventListener('error', upload.failed, false);
			xhr.addEventListener('abort', upload.canceled, false);			
			xhr.open('POST', '/' + admin_folder + '/actions/upload');
			xhr.send(fd);
			
			// Stop form submit
			return false;
		
		}
		
	};
	
/* Complete
----------------------------------------------------------------------------- */
	
	upload.complete = function(e) {
	
		// Hide loading indicator
		$('#uploading').hide();
	
		// Parse response from server
		var response = $.parseJSON(e.target.responseText);
		$('form input[name="image"]').val(response.image);
		$('.image .button').removeData('upload');
		$('form').submit();

	};