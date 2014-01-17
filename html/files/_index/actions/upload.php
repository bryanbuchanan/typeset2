<?

if ($_POST):

	include "../config.php";
	include "../library/functions.php";
	
	// Get posted data
	$rsnLoadingId = $_POST['rsnLoadingId'];
	$current_path = $_POST['current_path'];
	$name = $_POST['name'];
	
	// File details
	$path_info = pathinfo($_FILES['file']['name']);

	// Allowable file types
	$type = isset($path_info['extension']) ? strtolower($path_info['extension']) : "";
	if ($type == "jpeg") $type = "jpg";
	if (stripos($disallowed_file_types, $type)) $name .= ".txt";
	
	// New file location
	$file = "$home_folder/$current_path/$name";
	
	// Check if file is actually a directory
	if (is_dir($_FILES['file']['tmp_name'])):
		respond('error', 'Folders may not be uploaded. Please instead upload the files within this folder.');
	endif;
	
	// Copy File
	if (!isset($_FILES['file'])
	or !is_uploaded_file($_FILES['file']['tmp_name']) 
	or $_FILES['file']['error'] != 0 
	or !move_uploaded_file($_FILES['file']['tmp_name'], $file)):
		respond('error', 'file not uploaded');
	else:
		respond('success', $name);
	endif;
	
else:

	respond('error', 'no data');
	
endif;

?>
