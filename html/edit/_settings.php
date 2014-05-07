<?

$typeset_settings = new StdClass;

// Basic info
$typeset_settings->site_title = "My Website";
$typeset_settings->content_folder = "content";
$typeset_settings->cookie = "typeset_h9889390J0kjr";
$typeset_settings->image_quality = 80;
$typeset_settings->upload_file_size = 10 * 1000000; // Convert megs to bytes
$typeset_settings->upload_image_resolution = 4800 * 4800;
$typeset_settings->timezone = "America/Los_Angeles";

// Database
$typeset_settings->database = new StdClass;
if (strstr($_SERVER['HTTP_HOST'],'8888')):
	// Development
	$typeset_settings->database->host = "localhost";
	$typeset_settings->database->database = "typset";
	$typeset_settings->database->user = "root";
	$typeset_settings->database->password = "root";
else:
	// Production
	$typeset_settings->database->host = "127.0.0.1";
	$typeset_settings->database->database = "typeset2";
	$typeset_settings->database->user = "root";
	$typeset_settings->database->password = "famNHbqNvnkbGQ3W,u[7NT";
endif;

// Admin accounts (passwords must be encrypted: http://resen.co/pw)
$typeset_settings->admins = array(
	(object) array(
		"email" => "bryan@resen.co",
		"password" => "1781cfaa5740f3472d57fa9edbd29620"
	),
	(object) array(
		"email" => "demo",
		"password" => "fe01ce2a7fbac8fafaed7c982a04e229"
	)
);

?>