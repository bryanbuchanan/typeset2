<?

$typset_settings = new StdClass;

// Basic info
$typset_settings->site_title = "My Website";
$typset_settings->content_folder = "content";
$typset_settings->cookie = "typset_h9889390J0kjr";
$typset_settings->image_quality = 80;
$typset_settings->upload_file_size = 10 * 1000000; // bytes
$typset_settings->upload_image_resolution = 4800 * 4800;

// Database
$typset_settings->database = (object) array(
	"host" => "localhost",
	"database" => "typset",
	"user" => "root",
	"password" => "root"
);

// Admin accounts (passwords must be encrypted: http://resen.co/pw)
$typset_settings->admins = array(
	(object) array(
		"email" => "bryan@resen.co",
		"password" => "1781cfaa5740f3472d57fa9edbd29620"
	),
	(object) array(
		"email" => "brad@advertwebdesign.com",
		"password" => "94c3df3404c1f41dedd43e8c8f53b100"
	)
);

?>