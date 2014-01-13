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


	
/* Loading Placeholders
----------------------------------------------------------------------------- */
	
	
	upload.placeholder = function(file) {
	
		// Placeholder Templates
		var placeholders = {
			slides: '<li id="loading-' + file.rsnLoadingId + '" class="loading"><form action="#" method="post"><input type="hidden" name="id" value=""><input type="hidden" name="type" value=""><input type="hidden" name="content" value="slides"><input type="hidden" name="content" value=""><div class="image"><canvas width="45" height="45"></canvas></div></form></li>',
			images: '<li id="loading-' + file.rsnLoadingId + '" class="loading"><form action="/actions/image" method="post" class="autosave"><input type="hidden" name="id" value=""><input type="hidden" name="type" value=""><input type="hidden" name="content" value="images"><input type="hidden" name="container" value=""><div class="image"><canvas width="45" height="45"></canvas><a class="action sort" href="#">Drag</a></div><input type="text" name="title" placeholder="Title"><textarea rows="1" cols="10" name="text" placeholder="Description"></textarea></form></li>'
		};

		// Get type of content
		var content = $('input[type="file"]').data('content');

		// Remove content placeholder if present
		$('div.tip').remove();
		
		// Create list item
		log(upload_placement);
		if (upload_placement == "beginning") {
			$(placeholders[content]).prependTo('ul.grid').hide().fadeIn('fast');
		} else {
			$(placeholders[content]).appendTo('ul.grid').hide().fadeIn('fast');
		}

		// Setup Canvas
		var canvas = $('#loading-' + file.rsnLoadingId + ' canvas')[0];
		var loadingIndicator = canvas.getContext('2d');
		
		// Draw Loading Path
		loadingIndicator.beginPath();
		loadingIndicator.arc(23, 23, 20, 0, Math.PI * 2);
		loadingIndicator.lineWidth = 3;
		loadingIndicator.lineCap = 'square';
		loadingIndicator.strokeStyle = 'rgba(255,255,255, .2)';
		loadingIndicator.stroke();
	
	};
	
	
/* Upload File
----------------------------------------------------------------------------- */


	upload.uploadFile = function(file) {
	
		// Get type of content to be uploaded
		var content = $('input[type="file"]').data('content');
		var tag = $('input[type="file"]').data('tag');
	
		// Add 'active' class
		$('#loading-' + file.rsnLoadingId).addClass('active');

		// Get sort position		
		var sort = $('#loading-' + file.rsnLoadingId).prevAll().length + 1;		

		// Get data to send to server
		var fd = new FormData();	
		fd.append('content', content);
		fd.append('tag', tag);
		fd.append('sort', sort);
		fd.append('rsnLoadingId', file.rsnLoadingId);
		fd.append('upload_file', file);
					
		// Send Data
		var xhr = new XMLHttpRequest();        
		xhr.upload.addEventListener('progress', upload.progress, false);
		xhr.addEventListener('load', upload.complete, false);
		xhr.addEventListener('error', upload.failed, false);
		xhr.addEventListener('abort', upload.canceled, false);
		xhr.open('POST', '/actions/upload_' + content);
		xhr.send(fd);	
	
	}
	
	
/* Progress Indicator
----------------------------------------------------------------------------- */

	
	upload.progress = function(e) {
				
		if (e.lengthComputable) {
	
			// Get percentage
			var percentage = Math.round(e.loaded * 100 / e.total);

			// Define canvas element
			var canvas = $('.active canvas')[0];
			var loadingIndicator = canvas.getContext('2d');
			
			// Refresh/Erase Canvas
			loadingIndicator.clearRect(0, 0, canvas.width, canvas.height);
			
			// Draw Path
			loadingIndicator.beginPath();
			loadingIndicator.arc(23, 23, 20, 0, Math.PI * 2);
			loadingIndicator.lineWidth = 3;
			loadingIndicator.lineCap = 'square';
			loadingIndicator.strokeStyle = 'rgba(255,255,255, .2)';
			loadingIndicator.stroke();
			
			// Progress Bar
			loadingIndicator.beginPath();
			loadingIndicator.arc(23, 23, 20, 0 - 1.5, Math.PI * ((percentage / 100) * 2) - 1.5);
			loadingIndicator.lineWidth = 3;
			loadingIndicator.lineCap = 'butt';
			loadingIndicator.strokeStyle = 'rgba(255,255,255, 1)';
			loadingIndicator.stroke();

			// Show "Resizing" Label			
			if (percentage == 100) {
				var imageObj = new Image();
				imageObj.onload = function() { loadingIndicator.drawImage(this, 0, 0); };
				imageObj.src = "/cp/_images/resizing.png";
			}
	
		}  
	
	};
	
	
/* Upload Complete
----------------------------------------------------------------------------- */

	upload.complete = function(e) {

		log("upload.complete");
		log(e.target.responseText);

		// Parse response from server
		var response = $.parseJSON(e.target.responseText);
		log(response);
		
		if (response.status === "success") {
		
			// Find placeholder element
			var $item = $('#loading-' + response.rsnLoadingId);
		
			// Convert placeholder to content
			$item.removeClass('loading active');
			$item.find('input[name="id"]').val(response.id);
			$item.find('input[name="type"]').val(response.fileType);
			$item.find('input[name="container"]').val(response.container);
			$item.find('canvas').remove();
			$item.find('.image').prepend('<img src="' + response.preview + '">');
			$item.removeAttr('id');			
			
			// Remove file from queue list after it's uploaded
			log(upload.files);
			removeItem(upload.files, 0);
			
			if (upload.files.length > 0) {
				// Upload next file
				upload.uploadFile(upload.files[0]);
			} else {
				// Uploading done
				upload.queueComplete();
			}

		} else {
		
			// Stop work
			resen.done();
			upload.uploading = false;
		
			// Error messages
			if (response.message.match('limit')) { window.location = "?message=image_limit"; }
			else if (response.message.match('file type')) { window.location = "?message=image_type"; }
			else if (response.message.match('memory')) { window.location = "?message=large_image"; }
			else if (response.message.match('too many pixels')) { window.location = "?message=large_image"; }
			else if (response.message.match('Error')) { window.location = "?message=error"; }
		
		}
	
	}
	

/* Queue Complete
----------------------------------------------------------------------------- */
	
	upload.queueComplete = function() {

		log('all uploads done');
	
		resen.done();
		upload.uploading = false;
				
		// Save sort order
		$('.sortable').each(resen.saveOrder);
	
	}
		
	
/* Errors
----------------------------------------------------------------------------- */

	upload.failed = function(e) {
		alert("An error occurred while uploading the file.");  
	}  
	
	upload.canceled = function(e) {
		alert("The upload has been canceled by the user or the browser dropped the connection.");  
	}
	
	
/* Text Page Images
----------------------------------------------------------------------------- */

	upload.text = new Object();

	upload.text.selectFile = function() {

		var file = $(this)[0].files[0];

		if (upload.fileType(file)) {
			$('label.image .button.select').text(file.name).data('upload', true);
		}

	};

	upload.text.uploadFile = function() {
	
		if ($('.image .button').data('upload')) {

			var file = $('input[name="upload"]')[0].files[0];
			
			console.log('file:');
			console.log(file);
			
			// Get data to send to server
			var fd = new FormData();
			fd.append('upload', file);
			fd.append('image_width', $('input[name="image_width"]').val())
			fd.append('image_height', $('input[name="image_height"]').val());
			
			if ($('input[name="thumb_width"]').length > 0) {
				fd.append('thumb', 'true');
				fd.append('thumb_width', $('input[name="thumb_width"]').val());
				fd.append('thumb_height', $('input[name="thumb_height"]').val());
			}
						
			// Send Data
			var xhr = new XMLHttpRequest();
			// xhr.upload.addEventListener('progress', upload.progress, false);
			xhr.addEventListener('load', upload.text.complete, false);
			xhr.open('POST', '/' + admin_folder + '/actions/upload');
			xhr.send(fd);	
			
			// Stop form submit
			return false;
		
		}
		
	};
	
	upload.text.complete = function(e) {

		console.log(e.target.responseText);

		// Parse response from server
		var response = $.parseJSON(e.target.responseText);

		$('form input[name="image"]').val(response.image);

		$('.image .button').removeData('upload');

		$('form').submit();
	
	};