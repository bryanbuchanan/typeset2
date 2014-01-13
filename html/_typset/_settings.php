<?

$typset_settings = new StdClass;

// Database info
	$typset_settings->database = (object) array(
		"host" => "localhost",
		"database" => "typset",
		"user" => "root",
		"password" => "root"
	);
	
	$typset_settings->content_folder = "content";
	$typset_settings->site_key = "iuhweyfgg62g7g72";
	$typset_settings->image_quality = 80;
	
// Limits
	$typset_settings->limits = (object) array(
		"upload_file_size" => 10 * 1000000, // bytes
		"upload_image_resolution" => 4800 * 4800
	);	

// Admin accounts
// Passwords must be encrypted: http://resen.co/pw
	$typset_settings->admins = array(
		array(
			"email" => "info@resen.co",
			"password" => "8b011705e8fa30c3cc3182517e3e589e"
		),
		array(
			"email" => "brad@advertwebdesign.com",
			"password" => "94c3df3404c1f41dedd43e8c8f53b100"
		)
	);

?>