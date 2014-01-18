var typset = new Object;

/* Parse Dates
------------------------------------- */

	typset.setDateGraphic = function(date) {
		var pieces = date.split(' ');
		var date = pieces[0];
		var time = pieces[1];
		var pieces = date.split('-');
		var months = [
			"Jan",
			"Feb",
			"Mar",
			"Apr",
			"May",
			"Jun",
			"Jul",
			"Aug",
			"Sep",
			"Oct",
			"Nov",
			"Dec"
		];
		var month = pieces[1].replace(/^0/, '');
		var day = pieces[2].replace(/^0/, '');
		$('.month').text(months[month-1]);
		$('.day').text(day);			
	};

/* Setup
------------------------------------- */

	typset.setup = function() {

		// Add stylesheet to frame
		$('iframe').contents().find('head').append('<link href="/' + admin_folder + '/styles/frame.css" rel="stylesheet">');
	
		// Define editable elements
		var editables = [
			"[data-type='blurb']",
			"[data-type='html']",
			"[data-type='blog'][data-id]",			
			"[data-type='blog'] li[data-id]",
			"[data-type='banner'] li[data-id]"
		].toString();
		$('iframe').contents().find(editables).addClass('ts-editable');
		$('iframe').contents().find(editables).prepend('<a href="#" class="ts-action edit" title="Edit this item">Edit</a>');

		// Addible elements
		var addibles = [
			"[data-type='blog']:not([data-id])",
			"[data-type='banner']"
		].toString();
		$('iframe').contents().find(addibles).addClass('ts-addible');
		$('iframe').contents().find(addibles).prepend('<a href="#" class="ts-action add" title="Add a new item">Add</a>')
		
		// Add signout button
		if ($('#signout').length < 1) {
			$('body').append('<a class="button small" id="signout" href="/' + admin_folder + '/actions/signout">Sign Out</a>');
		}
		
		// Fire actions
		typset.actions();
	
	};

/* Actions
------------------------------------- */

	typset.actions = function() {
	
	/* Element Click */

		$('iframe').contents().find('.ts-action').click(function(event) {
	
			event.preventDefault();
		
			$widget = $(this).closest('.ts-editable, .ts-addible');
			$form = $('.form form');
		
			// Clear form
			$form.empty();
		
			// Add cancel button
			$form.append('<a class="close" href="#">Close</a>');
			$form.find('.close').click(function(e) {
				e.preventDefault();
				$('#overlay, .form').removeClass('show');
			});		
				
			$('#overlay, .form').addClass('show');
		
			if ($widget.data('type')) {
				// Get data for static content
				var deletable = false;
				var data = {
					type: $widget.data('type'),
					tag: $widget.data('tag'),
					id: $widget.data('id')
				};
			} else {
				// Get data for sequential content
				var deletable = true;
				var data = {
					type: $widget.closest('[data-type]').data('type'),
					tag: $widget.closest('[data-tag]').data('tag'),
					id: $widget.data('id')
				};
			}
		
			console.log('data being sent to retriever:');
			console.log(data);
		
			$.getJSON('/' + admin_folder + '/actions/retrieve', data, function(data) {
			
				console.log('retrieved data:');
				console.log(data);
			
				$.each(data, function(key, value) {
					
					// console.log($widget);
					
					// Add input
					if (key === "title") {
						$form.append('<label class="' + key + '"><input type="text" placeholder="Title" name="' + key + '" value="' + value + '"></label><br>');
					} else if (key === "image") {
						if (data.image) {
							$form.append('<label class="image">\
								<img src="/' + content_folder + '/' + data.image + '">\
								<a class="button small select" href="#">Replace Image</a>\
								<a class="button small del" data-type="' + data.type + '" data-id="' + data.id + '" data-file="' + data.image + '" href="#">Delete Image</a>\
								<input type="file" name="upload" accept="image/jpeg, image/gif, image/png">\
								<input type="hidden" name="image" value="' + data.image + '">\
								<input type="hidden" name="image_width" value="' + $widget.closest('[data-image_width]').data('image_width') + '">\
								<input type="hidden" name="image_height" value="' + $widget.closest('[data-image_height]').data('image_height') + '">\
								</label>');
							if ($widget.closest('[data-thumb_width]').length > 0 || $widget.closest('[data-thumb_height]').length > 0) {
								$form.append('<input type="hidden" name="thumb_height" value="' + $widget.closest('[data-thumb_height]').data('thumb_height') + '">\
									<input type="hidden" name="thumb_width" value="' + $widget.closest('[data-thumb_width]').data('thumb_width') + '">');
							}
						} else {
							$form.append('<label class="image">\
								<a class="button small select" href="#">Upload an Image</a>\
								<input type="file" name="upload" accept="image/jpeg, image/gif, image/png">\
								<input type="hidden" name="image" value="' + data.image + '">\
								<input type="hidden" name="image_width" value="' + $widget.closest('[data-image_width]').data('image_width') + '">\
								<input type="hidden" name="image_height" value="' + $widget.closest('[data-image_height]').data('image_height') + '">\
								</label>');
							if ($widget.closest('[data-thumb_width]').length > 0 || $widget.closest('[data-thumb_height]').length > 0) {
								console.log('image size data found');
								$form.append('<input type="hidden" name="thumb_height" value="' + $widget.closest('[data-thumb_height]').data('thumb_height') + '">\
									<input type="hidden" name="thumb_width" value="' + $widget.closest('[data-thumb_width]').data('thumb_width') + '">');
							} else {
								console.log('no image size data found');
							}		
						}
					} else if (key === "date") {
						$form.append('<div class="date">\
								<span class="month"></span>\
								<span class="day"></span>\
								<input type="text" name="date" value="' + data.date + '" gldp-id="date">\
							</div>');
							typset.setDateGraphic(data.date);
					} else if (key === "text" && data.type === "html") {
						$form.append('<label class="html"><textarea placeholder="HTML" name="' + key + '">' + value + '</textarea></label><br>');
					} else if (key === "text") {
						$form.append('<label class="text">\
							<textarea placeholder="Content" name="' + key + '">' + value + '</textarea>\
							<!-- <small>(<a href="http://daringfireball.net/projects/markdown/dingus" target="_blank">Markdown</a> and HTML formatting are enabled)</small>-->\
							</label><br>');
					} else if (key === "url") {
						$form.append('<label class="url"><input type="text" placeholder="URL" name="' + key + '" value="' + value + '"></label><br>');
					} else {
						$form.prepend('<input type="hidden" name="' + key + '" value="' + value + '">');
					}
				
				});
		
				// Add submit button
				$form.append('<input class="button submit" type="submit" value="Save">');
			
				// Delete button
				if (deletable && $form.find('input[name="new"]').length < 1) $form.append('<a href="#" class="button delete">Delete</a>');
				$('.button.delete').click(function(e) {
					e.preventDefault();
					if (confirm("Are you sure you want to delete this?")) {
						var data = {
							type: $widget.closest('[data-type]').data('type'),
							id: $widget.data('id')
						};
						$.post('/' + admin_folder + '/actions/delete', data, function(data) {
							console.log(data);
							if (data.status === "success") {
								// Refresh Site
								$('iframe')[0].contentDocument.location.reload(true);
								// Close Overlay
								$('#overlay, .form').removeClass('show');
							} else {
								// Error
								alert(data.message);
							}
						});	
					}
				});
				
				// Image uploader
				$('input[type="file"]').change(upload.text.selectFile);
				
				// Delete image
				$('.image .button.del').click(function(e) {
					e.preventDefault();
					$(this).remove();
					$('.image img').remove();
					$('input[name="image"]').val('');
					var data = {
						file: $(this).data('file'),
						type: $(this).data('type'),
						id: $(this).data('id')
					};
					$.post('/' + admin_folder + '/actions/delete_image', data, function(response) {
						console.log(response);
					});
				});
				
				// Date selector
				$('.date input').pickadate({
					today: '',
					clear: '',
					format: 'yyyy-mm-dd',
					onSet: function(event) {
						var newDate = $('.date input').val();
						typset.setDateGraphic(newDate);
					}
				});
				
				
				// Text editor
				typset.editor();
				
			});
		
		});

	/* Save */

		$('#content').unbind().submit(function(e) {
		
			e.preventDefault();

			// Hijack form submittion to upload file, if needed
			if ($('.image .button').data('upload')) {
				console.log('Hijacking form to upload file');
				upload.text.uploadFile();
				return false;
			}

			// Save text editor content
			$.each(editors, function() {
				$(this)[0].save();
			});
		
			// Get form data
			var data = $(this).serialize();
		
			console.log('saving');
			console.log(data);
				
			$.post('/' + admin_folder + '/actions/save', data, function(data) {

				console.log(data);
		
				if (data.status === "success") {
					// Refresh Site
					$('iframe')[0].contentDocument.location.reload(true);
					// Close Overlay
					$('#overlay, .form').removeClass('show');
				} else {
					// Error
					alert(data.message);
				}
		
			});
	
		});

	};

/* Text Editor
------------------------------------- */

	typset.editor = function() {
	
		editors = {};
			
		$('textarea').each(function() {
			
			var $this = $(this);
			
			var name = $this.prop('name');
			
			if ($this.closest('label').hasClass('html')) {
				var mode = "htmlmixed";
			} else {
				var mode = "markdown";
			}
						
			var options = {
				indentWithTabs: true,
				lineNumbers: false,
				viewportMargin: Infinity,
				theme: 'neat',
				smartIndent: false,
				lineWrapping: true,
				mode: mode,
				tabSize: 8
			};
		
			editors[name] = CodeMirror.fromTextArea($this[0], options);
		
		});
		
	};
	
/* Signin
------------------------------------- */

	typset.signin = function() {
		$('#signin').prop('action', '/' + admin_folder + '/actions/signin');
	};

/* Timeline
------------------------------------- */

	$(document).ready(function() {
		typset.signin();
		$('iframe').prop('src', '/');
	});
	
	$(window).load(function() {
	});

	$('iframe').load(function() {
		console.log('iframe loaded');
		if (typeof signed_in != "undefined") typset.setup();
	});