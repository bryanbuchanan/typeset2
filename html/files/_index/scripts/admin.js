/* RESEN */
/* Javascript
----------------------------------------------------------------------------- */
	
	var admin = new Object();

/* New Folder
----------------------------------------------------------------------------- */

	admin.newFolder = function() {

		$.post(home_uri + '/' + index_folder + '/actions/folder.php', { 
			folder: current_path + '/untitled_folder'
		}, function(data) {
			location.reload(true);
		});
				
		return false;
	
	};

/* Right Click
----------------------------------------------------------------------------- */

	admin.rightClick = function() {
	
		$('body').click(function() {
			$('.content .selected').removeClass('selected');
			$('#menu').remove();
		});
	
		$('body').bind('contextmenu', function(event) {
			$('.content .selected').removeClass('selected');
			$('#menu').remove();
		});
	
		$('.content > li').bind('contextmenu', function(event) {

			// Disable menu (doesn't work)
			// event.preventDefault(); 

			// Remove existing menus
			$('#menu').remove();
			
			// Set classes
			$('.content .selected').removeClass('selected');
			$(this).addClass('selected');
			
			// Get target
			var target = $(this).children('a').attr('href');
			
			// Menu
			var $menu = $('<ul id="menu" data-target="' + target + '">\
				<li><a class="rename" href="#rename">Change Name</a></li>\
				<li><a class="delete" href="' + home_uri + '/' + index_folder + '/actions/delete.php">Delete</a></li>\
				</ul>');
						 		 
		 	var offsetX = 0;
		 	var offsetY = -8;
		 	var windowWidth = $(window).width();
		 	var windowHeight = $(window).height();

			$menu.css({
				top: (event.pageY + offsetY) + "px",
				left: (event.pageX + offsetX) + "px"
			});
			
			$('body').append($menu);
			
			// Disable menu
			return false;
				
		});
	
	};
    
/* Websafe names
----------------------------------------------------------------------------- */
  
 	admin.safeName = function(name) {
		var name = name.toLowerCase();
		var name = name.replace(/\&/ig, "and");
		var name = name.replace(/[^a-z0-9\-\s._]/ig, "");
		var name = name.replace(/(^\s+|\s+$)/g, "");
		var name = name.replace(/\s+/ig, "-");
		return name;
 	};
 	 
/* Rename
----------------------------------------------------------------------------- */

	admin.rename = new Object();

/* Show renaming fields */

 	admin.rename.initiate = function() {
 	
 		// Get properties/elements
		var $listItem = $('.content a[href="' + $(this).closest('#menu').data('target') + '"]').parent();
 		var action = home_uri + "/" + index_folder + "/actions/rename.php";
 		var name = $listItem.find('strong').text();
 		
 		// Add class
 		$listItem.addClass('renaming');
 		
 		// Create form
 		var $form = $('<form action="' + action + '" method="post" id="rename"><input type="text" name="name" value="' + name + '" autocomplete="off"></form>');
 		$listItem.append($form);
 		
 		// Autofocus
 		$form.find('input').focus();
 		
 		// Close context menu
 		$('#menu').remove();

		$('#rename').submit(admin.rename.submit);
		$('#rename input').blur(admin.rename.submit);

 		return false;

 	};
 	
/* Submit new name */
 
 	admin.rename.submit = function() {
 	
 		log('submit');
 		
 		if ($(this).is('input')) {
 			var $this = $(this).closest('form');
 		} else {
 			var $this = $(this);
 		}
 	
 		var $listItem = $this.closest('li');
 		var action = $this.attr('action');
 		var old_name = $listItem.find('strong').text();
 		var new_name = $this.find('input').val();
 		
 		// Make sure new name is web safe
 		var new_name = admin.safeName(new_name);
 		
 		$.post(action, {
 			old_name: old_name,
 			new_name: new_name,
 			current_path: current_path
 		}, function(data) {
 			log(data); 		
 			var name = data.message;
 			$listItem.find('strong').text(name);
 			$listItem.find('a').attr('href', name);
 			$listItem.find('form').remove();
 			$listItem.removeClass('renaming');
 		}, 'json');
 		
 		return false;
 	
 	};
 
/* Delete
----------------------------------------------------------------------------- */
	
	admin.delete = function() {
	
		// Get properties
		var target = current_path + "/" + $(this).closest('#menu').data('target');
		var target = target.replace(/^\//, '');
		var action = $(this).attr('href');
		var $listItem = $('.content a[href="' + $(this).closest('#menu').data('target') + '"]').parent();

		// Remove menu
		$('#menu').remove();
								
		// Delete
		if (admin.deleteConfirm(target, $listItem)) {
			$.post(action, { target: target }, function(data) {
				log(data);
				if (data.status == "success") $listItem.remove();
			}, 'json');	
		}
		
		return false;
		
	};
	
	admin.deleteConfirm = function(target, $listItem) {
	
		admin.deleteConfirm.confirmed = "error";
	
		// Confirm
		if (!confirm("Are you sure you want to delete this?")) {
		
			admin.deleteConfirm.confirmed = false;
			
		} else {
		
			// Confirm deletion of folder contents too
			if ($listItem.hasClass('folder')) {
			
				$.ajax({
					type: "post",
					url: home_uri + '/' + index_folder + '/actions/empty.php',
					data: { target: target },
					async: false,
					dataType: "json",
					success: function(data) {
					
						if (data.message > 0) {
											
							var language = ( data.message < 2 ? "There is " + data.message + " file " : "There are " + data.message + " files ");
				
							if (confirm(language + "inside this folder that will also be permanently erased. Would you like to delete anyway?")) {
								admin.deleteConfirm.confirmed = true;
							} else {
								admin.deleteConfirm.confirmed = false;
							}

						} else {

							admin.deleteConfirm.confirmed = true;
				
						}
						
					}

				});

			} else {
		
				admin.deleteConfirm.confirmed = true;
		
			}
			
		}
		
		return admin.deleteConfirm.confirmed;
				
	};
	
/* Move
----------------------------------------------------------------------------- */
	
	admin.move = function() {

		// Draggable
		$('.content > li').draggable({
			revert: true,
			revertDuration: 100
		});
		
		// Droppable
		$('.content > li.folder, #back:not(.inactive)').droppable({
			tolerance: 'intersect',
			hoverClass: 'over',
			drop: function(event, ui) {
				
				log(event);
				log(ui);
				
				var $dropped = $(ui.draggable.context);
				var $target = $(event.target);
				
				// Get file locations
				var file = $dropped.find('a').attr('href');
				var old_location = current_path + "/" + file;
				var new_location = current_path + "/" + $target.find('a').attr('href') + "/" + file;
				
				log(file);
						
				// Remove moved item
				$dropped.remove();
				
				// Move item
				var action = home_uri + '/' + index_folder + '/actions/move.php';
				$.post(action, {
					old_location: old_location,
					new_location: new_location
				}, function(data) {
				
					log(data);
				
				}, 'json');
				
			}
			
		});
	
	};
		
/* Timeline
----------------------------------------------------------------------------- */
	
	$(document).ready(function() {
		
		// New folder
		$('#folder a').click(admin.newFolder);
		
		// Right click
		admin.rightClick();
		
		// Delete
		$('body').on('click', 'a.delete', admin.delete);
		
		// Rename
		$('body').on('click', 'a[href="#rename"]', admin.rename.initiate);
		
		// Upload
		$('input[type="file"]').change(upload.selectFile);
		/* DnD
		$(window).bind('dragenter', upload.dragenter);
		$(window).bind('dragover', upload.cancelAction);			
		$('#dragging').live('dragleave', upload.dragleave);
		$(window).bind('drop', upload.drop);
		*/
		
		// Move
		admin.move();

	});	

