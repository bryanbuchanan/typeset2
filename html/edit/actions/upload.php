<?
include "../include.php";
include "$site_root/$admin_folder/pages/includes/security.php";

// Make sure content folder exists
$check_folder = "$site_root/$typeset_settings->content_folder";
if (!is_dir($check_folder)) mkdir($check_folder);

// Image data
$image_data = $_POST['image_data'];
$p = strpos($image_data, ',');
$image_data = substr($image_data, $p + 1);
$image_data = base64_decode($image_data);

// Get other posted data
$image_name = $_POST['image_name'];
$image_width = $_POST['image_width'];
$image_height = $_POST['image_height'];
if (isset($_POST['thumb_width'])) $thumb_width = $_POST['thumb_width'];
if (isset($_POST['thumb_height'])) $thumb_height = $_POST['thumb_height'];
if (isset($_POST['thumb'])) $thumb = $_POST['thumb'];
if (isset($_POST['old_file'])) $old_file = $_POST['old_file'];

// Get file name info
$file_info = pathinfo($image_name);
$filename = $file_info['filename'];
$extension = strtolower($file_info['extension']);
if ($extension === "jpeg") $extension = "jpg";

// Assign new filename
$random = rand(10,99);
$filename = $typeset->urn($filename) . "-$random";

// Get file destination
$target_path = "$site_root/$typeset_settings->content_folder/$filename.$extension";

// Upload File
if (!file_put_contents($target_path, $image_data)):
	$typeset->respond(array(
		"status" => "error",
		"message" => "Error: File couldn\'t be uploaded. Error # " . $_FILES['upload']['error']
	));
endif;
	
// Get original image size
$image = $target_path;
$image_stats = GetImageSize($image); 
$original_width = $image_stats[0]; 
$original_height = $image_stats[1];
$original_pixels = $original_width * $original_height;

// Convert back to actual file format
$destination_image = imagecreatefrompng($image);
if ($extension === "jpg"):
	imagejpeg($destination_image, $image, $typeset_settings->image_quality);
elseif ($extension === "gif"):
	imagegif($destination_image, $image);
elseif ($extension === "png"):
	imagepng($destination_image, $image);
endif;
imagedestroy($destination_image);

// Create thumbnail
if (isset($thumb)):
	$target_path_thumb = "$site_root/$typeset_settings->content_folder/$filename-thumb.$extension";
	$typeset->resize_image(array(
		"original" => $image,
		"destination" => $target_path_thumb, 
		"width" => $thumb_width,
		"height" => $thumb_height
	));
endif;

// Erase old files
if (isset($old_file)):
	$old_image = "$site_root/$typeset_settings->content_folder/$old_file";
	if (is_file($old_image)) unlink($old_image);
	$old_thumb = "$site_root/$typeset_settings->content_folder/" . $typeset->thumb($old_file);
	if (is_file($old_thumb)) unlink($old_thumb);
endif;
	
// Return Success Message
$typeset->respond(array(
	"status" => "success",
	"image" => "$filename.$extension"
));

?>
