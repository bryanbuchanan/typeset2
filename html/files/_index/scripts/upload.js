/* Javascript Functions
----------------------------------------------------------------------------- */

	var upload = new Object();
	upload.limit = 100;
	upload.uploading = false;

/* Remove Item from Object
----------------------------------------------------------------------------- */

	function removeItem(object, key) {
		if (!object.hasOwnProperty(key)) return;
		if (isNaN(parseInt(key)) || !(object instanceof Array)) {
			delete object[key];
		} else { 
			object.splice(key, 1);
		}
	};	

/* Unique ID Generator
----------------------------------------------------------------------------- */

	function uniqueId() {
		var newDate = new Date;
		var partOne = newDate.getTime();
		var partTwo = 1 + Math.floor((Math.random() * 10000));
		var id = partOne + partTwo;
		return id;
	}

/* Limit number of files
----------------------------------------------------------------------------- */

	upload.underLimit = function() {
		if (upload.files.length <= upload.limit) {
			return true;
		} else {
			resen.done();
			upload.uploading = false;
			alert('Too many files selected. \nPlease upload ' + upload.limit + ' or fewer at a time.');		
			return false;
		}
	};

/* Select File
----------------------------------------------------------------------------- */

	upload.selectFile = function() {
		
		// Get selected files
		var selectedFiles = $('input[type="file"]')[0].files;
	
		// Make sure upload isn't already in progress
		if (upload.uploading) {
			alert('Please wait for the current group of files to finish before adding more.');
			return false;
		}
				
		// Freeze new uploads while current batch is processed
		upload.uploading = true;
		
		// Create list of files to be uploaded
		upload.files = [];	
		$(selectedFiles).each(function() {
			// Assign unique ID
			this.rsnLoadingId = uniqueId();		
			// Add file to list
			upload.files.push(this);							
		});
		
		// Check file limit
		if (upload.underLimit() && upload.files.length > 0) {

			// Create upload queue
			$('body').append('<div id="overlay"><div class="files"><ul></ul></div></div>');
		
			// Create placeholder elements
			$(upload.files).each(function() {
							
				$('#overlay .files ul').append('<li id="' + this.rsnLoadingId + '"><strong>' + this.name + '</strong><var></var></li>');
								
			});

			// Upload first file
			upload.uploadFile(upload.files[0]);
			
		} else {
		
			resen.done();
		
		}

	};
	
/* Upload File
----------------------------------------------------------------------------- */

	upload.uploadFile = function(file) {
	
		// Set selected file
		$('.files').find('#' + file.rsnLoadingId).addClass('active');
	
		// Get data to send to server
		var fd = new FormData();	
		fd.append('rsnLoadingId', file.rsnLoadingId);
		fd.append('current_path', current_path);
		fd.append('name', admin.safeName(file.name));
		fd.append('file', file);
					
		// Send data and add listeners
		var xhr = new XMLHttpRequest();        
		xhr.upload.addEventListener('progress', upload.progress, false);
		xhr.addEventListener('load', upload.complete, false);
		xhr.addEventListener('error', upload.failed, false);
		xhr.addEventListener('abort', upload.canceled, false);
		xhr.open('POST', home_uri + '/' + index_folder + '/actions/upload.php');
		xhr.send(fd);
	
	};
	
/* Progress Indicator
----------------------------------------------------------------------------- */
	
	upload.progress = function(e) {
	
		log(e);
					
		if (e.lengthComputable) {
	
			var percentage = Math.round(e.loaded * 100 / e.total);
			$('.files .active var').css('width', percentage + '%');
		
			if (percentage == 100) { }
	
		}  
	
	};
	
/* Drag/Drop
----------------------------------------------------------------------------- */

	/*
	
	upload.dragenter = function(e) {
		
		// Prevent default function
		e.preventDefault();
		e.stopPropagation();

		// Add drop zone
		if ($('#dragging').length < 1) $('body').append('<div id="dragging"></div>');
		
	};
	
	upload.dragleave = function(e) {
		
		// Prevent default function
		e.preventDefault();
		e.stopPropagation();
		
		// Remove drop zone
		$('#dragging').remove();

	};

	upload.drop = function(e) {
		
		// Prevent default function
		e.originalEvent.stopPropagation();
		e.originalEvent.preventDefault();
		
		// Remove drop zone
		$('#dragging').remove();
		
		// Make sure file wasn't dropped from within the browser window
		if (e.originalEvent.dataTransfer.files.length > 0) {
		
			// Make sure upload isn't already in progress
			if (!upload.uploading) {
			
				// Freeze new uploads while current batch is processed
				upload.uploading = true;
				
				// Create new list
				upload.files = [];
									
				$(e.originalEvent.dataTransfer.files).each(function() {
	
					if (this.type.match(/image\/(jpeg|png|gif)/)) {
	
						// Add unique ID to reference later
						this.rsnLoadingId = uniqueId();
						
						// Add file to list
						upload.files.push(this);
	
						log('Keep:' + this.type);
	
					} else {
					
						log('Ditch:' + this.type);
	
					}
								
				});
	
				log(upload.files);
	
				// Check file limit
				if (upload.underLimit() && upload.files.length > 0) {
	
					// Create placeholder elements
					$(upload.files).each(function() { upload.placeholder(this); });
	
					// Scroll to new content			
					var position = $('li.loading:first').offset().top - 100;
					var target = ($.browser.mozilla ? "html" : "body");
					$(target).animate({ scrollTop: position }, 1000, function() {
					
						// Upload first file
						upload.uploadFile(upload.files[0]);
					
					});
				
				}
			
			} else {
			
				alert('Please wait for the current group of files to finish before adding more.');

			}
			
		}
				
	};
	
	upload.cancelAction = function(e) {
	
		e.preventDefault();
		e.stopPropagation();
	
	};
	
	*/
	
/* Upload Complete
----------------------------------------------------------------------------- */
	
	upload.complete = function(e) {

		log("upload.complete");
		log(e.target.responseText);

		// Parse response from server
		var response = $.parseJSON(e.target.responseText);
		
		if (response.status === "success") {
		
			// Classes
			$('.active').removeClass('active');
			
			// Remove file from queue list after it's uploaded
			removeItem(upload.files, 0);
			
			if (upload.files.length > 0) {
				
				// Upload next file
				upload.uploadFile(upload.files[0]);
				
			} else {
			
				// Uploading done
				upload.queueComplete();
			
			}

		} else {
		

		
		}
	
	}
	
/* Queue Complete
----------------------------------------------------------------------------- */
	
	upload.queueComplete = function() {
	
		location.reload(true);
		
	}
		
/* Errors
----------------------------------------------------------------------------- */

	upload.failed = function(e) {
	
		alert("An error occurred while uploading the file.");  
	
	}  
	
	upload.canceled = function(e) {

		alert("The upload has been canceled by the user or the browser dropped the connection.");  
	
	}