<?
include "../include.php";
include "$site_root/$admin_folder/pages/includes/security.php";

if (empty($_FILES)):
	$typset->respond(array(
		"status" => "error",
		"message" => "No image data to upload"
	));
endif;

// Get posted data
$image_width = $_POST['image_width'];
$image_height = $_POST['image_height'];
if (isset($_POST['thumb_width'])) $thumb_width = $_POST['thumb_width'];
if (isset($_POST['thumb_height'])) $thumb_height = $_POST['thumb_height'];
if (isset($_POST['thumb'])) $thumb = $_POST['thumb'];
if (isset($_POST['old_file'])) $old_file = $_POST['old_file'];

// Validate File Type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['upload']['tmp_name']);
if (!preg_match('/image\/(jpeg|png|gif)|octet\-stream/', $mime)):
	unlink($_FILES['upload']['tmp_name']);
	$typset->respond(array(
		"status" => "error",
		"message" => "Incorrect file type"
	));
endif;

// Validate file size
if ($_FILES['upload']['size'] > $typset_settings->upload_file_size):
	unlink($_FILES['upload']['tmp_name']);
	$typset->respond(array(
		"status" => "error",
		"message" => "File is too large. It must be under " . $typset_settings->upload_file_size / 1000000 . "MB"
	));
endif;

// Get file name info
$file_info = pathinfo($_FILES['upload']['name']);
$filename = $file_info['filename'];
$extension = strtolower($file_info['extension']);
if ($extension === "jpeg") $extension = "jpg";

// Assign new filename
$random = rand(10,99);
$filename = $typset->urn($filename) . "-$random";

// Get file destination
$target_path = "$site_root/$typset_settings->content_folder/$filename.$extension";

// Upload File
if (!isset($_FILES['upload'])
or !is_uploaded_file($_FILES['upload']['tmp_name'])
or $_FILES['upload']['error'] != 0
or !move_uploaded_file($_FILES['upload']['tmp_name'], $target_path)):		
	$typset->respond(array(
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

// Make sure image isn't too big
if ($original_pixels > $typset_settings->upload_image_resolution):
	unlink($image);
	$typset->respond(array(
		"status" => "error",
		"message" => "too many pixels"
	));
endif;

// Resize
if ($original_width > $image_width or $original_height > $image_width):
	$typset->resize_image(array(
		"original" => $image,
		"destination" => $image, 
		"width" => $image_width,
		"height" => $image_height
	));
endif;

// Create thumbnail
if (isset($thumb)):
	$target_path_thumb = "$site_root/$typset_settings->content_folder/$filename-thumb.$extension";
	$typset->resize_image(array(
		"original" => $image,
		"destination" => $target_path_thumb, 
		"width" => $thumb_width,
		"height" => $thumb_height
	));
endif;

// Erase old files
if (isset($old_file)):
	$old_image = "$site_root/$typset_settings->content_folder/$old_file";
	if (is_file($old_image)) unlink($old_image);
	$old_thumb = "$site_root/$typset_settings->content_folder/" . $typset->thumb($old_file);
	if (is_file($old_thumb)) unlink($old_thumb);
endif;
	
// Return Success Message
$typset->respond(array(
	"status" => "success",
	"image" => "$filename.$extension"
));

?>
