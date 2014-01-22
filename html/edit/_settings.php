<?

$typset_settings = new StdClass;

// Basic info
$typset_settings->site_title = "My Website";
$typset_settings->content_folder = "content";
$typset_settings->cookie = "typset_h9889390J0kjr";
$typset_settings->image_quality = 80;
$typset_settings->upload_file_size = 10 * 1000000; // Convert megs to bytes
$typset_settings->upload_image_resolution = 4800 * 4800;
$typset_settings->timezone = "America/Los_Angeles";

// Database
$typset_settings->database = new StdClass;
if (strstr($_SERVER['HTTP_HOST'],'8888')):
	// Development
	$typset_settings->database->host = "localhost";
	$typset_settings->database->database = "typset";
	$typset_settings->database->user = "root";
	$typset_settings->database->password = "root";
else:
	// Production
	$typset_settings->database->host = "internal-db.s54409.gridserver.com";
	$typset_settings->database->database = "db54409_typset";
	$typset_settings->database->user = "db54409";
	$typset_settings->database->password = "rese73344545";
endif;

// Admin accounts (passwords must be encrypted: http://resen.co/pw)
$typset_settings->admins = array(
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