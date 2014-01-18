<?
include "../include.php";
include "$site_root/$admin_folder/pages/includes/security.php";

if (!isset($_POST)):
	$typset->respond(array(
		"status" => "error",
		"message" => "no info set to delete action"
	));
endif;

// Gather data
$data = (object) array(
	"type" => $_POST['type'],
	"id" => $_POST['id']
);

// Check for images and delete files
$statement = $db->run("DESCRIBE $data->type");
$fields = $statement->fetchAll(PDO::FETCH_COLUMN);
if (array_search("image", $fields)):
	$query = "SELECT image FROM $data->type WHERE id=:id LIMIT 1";
	$query_data = array("id" => $data->id);
	$response = $db->run($query, $query_data);
	$image = "$site_root/$typset_settings->content_folder/" . $response->fetch()->image;
	$thumb = "$site_root/$typset_settings->content_folder/" . $typset->thumb($image);
	if (is_file($image)) unlink($image);
	if (is_file($thumb)) unlink($thumb);
endif;

// Erase from database
$query = "DELETE FROM $data->type WHERE id=:id";
$query_data = array("id" => $data->id);

if (!$db->run($query, $query_data)):
	$typset->respond(array(
		"status" => "error",
		"message" => "Error deleting item"
	));
else:
	$typset->respond(array(
		"status" => "success",
		"message" => "Item successfully deleted"
	));
endif;

?>