<?

if (!empty($_POST)):

	include "../config.php";
	include "../library/functions.php";
	
	// Get posted data
	$old_location = $_POST['old_location'];
	$new_location = $_POST['new_location'];
	
	// Prepend absolute path
	$old_location = realpath("$home_folder/$old_location");
	$new_location = "$home_folder/$new_location";
	
 	// Move
 	if (!empty($old_location) and !empty($new_location)):
		rename($old_location, $new_location);
		respond('success');	
 	else:
 		respond('error', 'Not enough info');
 	endif;
	
endif;

?>