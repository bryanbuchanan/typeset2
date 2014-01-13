
var typset = new Object;

/* Confirm (can't reproduce native confirm :(
------------------------------------- */

	typset.confirm = function(data) {
	
		$('.form').removeClass('show');
		
		$('#overlay').after('<div class="prompt show"><h3>' + data.heading + '</h3><p>' + data.text + '</p><a href="#" class="button delete">' + data.action + '</a><button class="button cancel">Cancel</button></div>');
	
		$('.prompt .cancel').click(function(e) {
			e.preventDefault();
			return false;
		});
		
		$('.prompt .delete').click(function(e) {
			e.preventDefault();
			return true;
		});
	
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
			"[data-type='blog'] li[data-id]",
			"[data-type='banner'] li[data-id]"
		].toString();
		$('iframe').contents().find(editables).addClass('ts-editable');
		$('iframe').contents().find(editables).prepend('<a href="#" class="ts-action edit" title="Edit this item">Edit</a>');

		// Addible elements
		var addibles = [
			"[data-type='blog']",
			"[data-type='banner']"
		].toString();
		$('iframe').contents().find(addibles).addClass('ts-addible');
		$('iframe').contents().find(addibles).prepend('<a href="#" class="ts-action add" title="Add a new item">Add</a>')
		
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
					
					console.log('width: ' + $widget.data('max_image_width'));
					console.log($widget);
					
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
								<input type="hidden" name="image_width" value="' + $widget.data('image_width') + '">\
								<input type="hidden" name="image_height" value="' + $widget.data('image_height') + '">\
								</label>');
							if ($widget.closest('[data-thumb_width]').length > 0 || $widget.closest('[data-thumb_height]').length > 0) {
								$form.append('<input type="hidden" name="thumb_height" value="' + $widget.closest('[data-thumb_height]').data('thumb_height') + '">\
									<input type="hidden" name="thumb_width" value="' + $widget.closest('[data-thumb_width]').data('thumb_width') + '">');
							}			
						}
					} else if (key === "text" && data.type === "html") {
						$form.append('<label class="html"><textarea placeholder="HTML goes here" name="' + key + '">' + value + '</textarea></label><br>');
					} else if (key === "text") {
						$form.append('<label class="text">\
							<textarea placeholder="Content goes here" name="' + key + '">' + value + '</textarea>\
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

				// Text Editor
				typset.editor();
				
			});
		
		});

	/* Save */

		$('form').unbind().submit(function(e) {
		
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
		
	}

$(document).ready(function() {

	$('iframe').prop('src', '/');

});

$('iframe').load(function() {

	console.log('iframe loaded');
	
	typset.setup();
	
});