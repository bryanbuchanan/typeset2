<? include "../include.php";

// Build request
$request = (object) array(
	"type" => $_GET['type'],
	"tag" => $_GET['tag']
);

// Use ID, if available
if (isset($_GET['id'])):
	$request->id = $_GET['id'];
endif;

// Get content from database
$query = "SELECT * FROM $request->type WHERE tag=:tag LIMIT 1";
$query_data = array("tag" => $request->tag);
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

endif;

header('Content-type: application/json');
echo json_encode($content);

?>