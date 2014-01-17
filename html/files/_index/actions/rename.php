<?

if (!empty($_POST)):

	include "../config.php";
	include "../library/functions.php";
	
	// Get posted data
 	$old_name = $_POST['old_name'];
 	$new_name = $_POST['new_name'];
 	$current_path = $_POST['current_path'];
 	
 	// Disallowed file types
 	$pathinfo = pathinfo($new_name);
 	if (isset($pathinfo['extension'])):
 		$type = strtolower($pathinfo['extension']);
 		if (stripos($disallowed_file_types, $type)) $new_name .= ".txt";
 	endif;
 	
 	if (!empty($old_name) and !empty($new_name)):
		$old_file = "$home_folder/$current_path/$old_name";
		$new_file = "$home_folder/$current_path/$new_name";
		rename($old_file, $new_file);
		respond('success', $new_name);	
 	else:
 		respond('error', 'Not enough info');
 	endif;
	
endif;

?>