<?

if (!empty($_POST)):

	include "../config.php";
	include "../library/functions.php";

	$folder = $_POST['folder'];
	$folder = "$home_folder/$folder";
	$folder = resolve_duplicate_names($folder);
	
	if (!is_dir($folder)) mkdir($folder);
	
	respond('success');
	
endif;

?>