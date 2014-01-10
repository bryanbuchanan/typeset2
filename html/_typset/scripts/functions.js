
var typset = new Object;

/* Setup
------------------------------------- */

	typset.setup = function() {

		// Add stylesheet to frame
		$('iframe').contents().find('head').append('<link href="/_typset/styles/frame.css" rel="stylesheet">');
	
		// Define editable elements
		var editables = [
			"[data-type='blurb']",
			"[data-type='html']",
			"[data-type='blog'] li[data-id]"
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
			$form = $('#form form');
		
			// Clear form
			$form.empty();
		
			// Add cancel button
			$form.append('<a class="close" href="#">Close</a>');
			$form.find('.close').click(function(e) {
				e.preventDefault();
				$('#overlay, #form').removeClass('show');
			});		
				
			$('#overlay, #form').addClass('show');
		
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
		
			$.getJSON('/_typset/actions/retrieve', data, function(data) {
			
				console.log('retrieved data:');
				console.log(data);
			
				$.each(data, function(key, value) {
			
					// Add input
					if (key === "title") {
						$form.append('<label class="' + key + '"><input type="text" placeholder="' + key + '" name="' + key + '" value="' + value + '"></label><br>');
					} else if (key === "text" && data.type === "html") {
						$form.append('<label class="html"><textarea placeholder="' + key + '" name="' + key + '">' + value + '</textarea></label><br>');
					} else if (key === "text") {
						$form.append('<label class="text"><textarea placeholder="' + key + '" name="' + key + '">' + value + '</textarea></label><br>');
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
	
						$.post('/_typset/actions/delete', data, function(data) {
		
							console.log(data);
	
							if (data.status === "success") {
								// Refresh Site
								$('iframe')[0].contentDocument.location.reload(true);
								// Close Overlay
								$('#overlay, #form').removeClass('show');
							} else {
								// Error
								alert(data.message);
							}
		
						});
							
					}
		
				});

				// Text Editor
				typset.editor();
				
			});
		
		});

	/* Save */

		$('form').unbind().submit(function(e) {
		
			e.preventDefault();

			console.log("forms: " + $('form').length);

			$.each(editors, function() {
				$(this)[0].save();
			});
		
			var data = $(this).serialize();
		
			console.log('saving');
			console.log(data);
				
			$.post('/_typset/actions/save', data, function(data) {

				console.log(data);
		
				if (data.status === "success") {
					// Refresh Site
					$('iframe')[0].contentDocument.location.reload(true);
					// Close Overlay
					$('#overlay, #form').removeClass('show');
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