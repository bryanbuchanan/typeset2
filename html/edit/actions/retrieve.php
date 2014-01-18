<?
include "../include.php";
include "$site_root/$admin_folder/pages/includes/security.php";

// Build request
$request = (object) array(
	"type" => $_GET['type'],
	"tag" => $_GET['tag']
);

// Use ID, if available
if (isset($_GET['id'])):
	$request->id = $_GET['id'];
else:
	$request->id = 0;
endif;

// Get content from database
$query = "SELECT * FROM $request->type WHERE tag=:tag AND id=:id LIMIT 1";
$query_data = array(
	"tag" => $request->tag,
	"id" => $request->id
);
$statement = $db->run($query, $query_data);
$results = $statement->rowCount();

if ($results > 0):

	// Existing items
	$content = $statement->fetch();
	$content->type = $request->type;

else:
	
	// Items that don't exist yet
	$statement = $db->run("DESCRIBE $request->type");
	$fields = $statement->fetchAll(PDO::FETCH_COLUMN);
	
	$content = array("new" => "true");
	foreach ($fields as $field) $content[$field] = "";
	$content = (object) $content;
	$content->type = $request->type;
	$content->tag = $request->tag;
	
	if (isset($content->date)):
		date_default_timezone_set('America/Los_Angeles');
		$content->date = date("Y-m-d", time());
	endif;

endif;

// Avoid null results
foreach ($content as $key => $value):
	if (is_null($value)) $content->$key = "";
endforeach;

header('Content-type: application/json');
echo json_encode($content);

?>