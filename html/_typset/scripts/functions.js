
var typset = new Object;

typset.setup = function() {

	// Add stylesheet to frame
	$('iframe').contents().find('head').append('<link href="/_typset/styles/frame.css" rel="stylesheet">');
	
	var editables = [
		"[data-type='blurb']",
		"[data-type='html']",
		"[data-type='blog'] li[data-id]"
	].toString();
		
	$('iframe').contents().find(editables).addClass('ts-editable');
	
	typset.actions();
	
};

typset.actions = function() {

/* Element Click */

	$('iframe').contents().find('.ts-editable').click(function(event) {
	
		event.preventDefault();
		
		$widget = $(this);
		$form = $('#overlay form');
		
		// Clear form
		$form.empty();
		
		// Add cancel button
		$form.append('<a class="close" href="#">Close</a>');
		$form.find('.close').click(function(e) {
			e.preventDefault();
			$('#overlay').removeClass('show');
		});		
				
		$('#overlay').addClass('show');
		
		var data = {
			type: $widget.data('type'),
			tag: $widget.data('tag')
		};
		
		$.getJSON('/_typset/actions/retrieve', data, function(data) {
			
			console.log('retrieved data:');
			console.log(data);
			
			$.each(data, function(key, value) {
			
				// Add input
				if (key === "id" || key === "tag" || key === "type" || key === "new") {
					$form.prepend('<input type="hidden" name="' + key + '" value="' + value + '">');
				} else if (key === "title") {
					$form.append('<label><em>' + key + '</em><input type="text" name="' + key + '" value="' + value + '"></label><br>');
				} else if (key === "text") {
					$form.append('<label class="text"><em>' + key + '</em><textarea name="' + key + '">' + value + '</textarea></label><br>');
				}
				
			});
		
			// Add submit button
			$form.append('<input type="submit" value="Save">');
		
		});
		
	
	});

/* Save */

	$('form').submit(function(e) {
		
		e.preventDefault();
		
		var data = $(this).serialize();
		
		console.log('saving');
		console.log(data);
				
		$.post('/_typset/actions/save', data, function(data) {

			console.log(data);
		
			if (data.status === "success") {
				// Refresh Site
				$('iframe')[0].contentDocument.location.reload(true);
				// Close Overlay
				$('#overlay').removeClass('show');
			} else {
				// Error
				alert(data.message);
			}
		
		});
	
	});

};

$(document).ready(function() {

	$('iframe').prop('src', '/');

});

$('iframe').load(function() {

	console.log('iframe loaded');
	
	typset.setup();
	
});