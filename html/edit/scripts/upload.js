/* Typeset 2 */

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
		
			// Disable submit button
			$('input[type="submit"]').addClass('disabled');
			
			// Add file name to button
			$('label.image .button.select').text(file.name).data('upload', true);
			
			// Get image data
			var img = document.createElement('img');
			var reader = new FileReader();
			reader.onload = function(e) {

				console.log('loaded');
			
				// Get image data
				img.src = e.target.result;
				
				// Show thumbnail
				$('label.image').find('img').remove();
				$('label.image').prepend(img);
				
				// Resize
				upload.resize(img);

			};
			reader.readAsDataURL(file);
	
		}

	};
	
	upload.resize = function(img) {

		console.log('resizing');
		
		// Remove old resizer canvas
		$('#resizer').remove();

		// Load Image
		imgLoader = new Image();				
		imgLoader.onload = function(data) {
		
			console.log('image loaded into resizer');
			
			// Get image dimensions
			var max_width = $('input[name="image_width"]').val();
			var max_height = $('input[name="image_height"]').val();
			var original_width = imgLoader.width;
			var original_height = imgLoader.height;
			
			log('Fitting from ' + original_width + 'x' + original_height + ' image to ' + max_width + 'x' + max_height);
		
			// Calculate dimensions
			if (original_width > original_height) {
				if (original_width > max_width) {
					var ratio = max_width / original_width;
					var new_height = original_height * ratio;
					var new_width = max_width;
				} else {
					var new_height = original_height;
					var new_width = original_width;
				}
			} else {
				if (original_height > max_height) {
					var ratio = max_height / original_height;
					var new_width = original_width * ratio;
					var new_height = max_height;
				} else {
					var new_height = original_height;
					var new_width = original_width;
				}
			}
			
			log('Resizing from ' + original_width + 'x' + original_height + ' to ' + new_width + 'x' + new_height);

			// Create resizer canvas
			var $canvas_element = $('<canvas id="resizer"></canvas>');
			$('body').append($canvas_element);
			var canvas = $canvas_element[0];
			
			// Set canvas size
			canvas.width = new_width;
			canvas.height = new_height;
			
			// Resize image
			var ctx = canvas.getContext('2d');
			ctx.drawImage(imgLoader, 0, 0, new_width, new_height);
			
			// Enable submit button
			$('input[type="submit"]').removeClass('disabled');

		};

		// Has to be after onload function for IE		
		imgLoader.src = img.src;
	
	};

/* Upload File
----------------------------------------------------------------------------- */

	upload.uploadFile = function() {
	
		if ($('.image .button').data('upload')) {
		
			// Show loading indicator
			$('.form').removeClass('show');
			$('#uploading').show();
						
			// Get data
			var canvas = $('#resizer')[0];
			var dataurl = canvas.toDataURL('image/png');
			var old_file = $('input[name="image"]').val();
			var image_name = $('input[type="file"]')[0].files[0].name;

			// Get data to send to server
			var fd = new FormData();
			fd.append('image_data', dataurl);
			fd.append('image_name', image_name);
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
	
		console.log(e.target.responseText);
	
		// Hide loading indicator
		$('#uploading').hide();
	
		// Parse response from server
		var response = $.parseJSON(e.target.responseText);
		$('form input[name="image"]').val(response.image);
		$('.image .button').removeData('upload');
		$('form').submit();

	};