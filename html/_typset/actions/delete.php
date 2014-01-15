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

// From query
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