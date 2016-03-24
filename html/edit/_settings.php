<?

$typeset_settings = new StdClass;

// Basic Info
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
	$typeset_settings->database->database = "typeset2";
	$typeset_settings->database->user = "root";
	$typeset_settings->database->password = "root";
else:
	// Production
	$typeset_settings->database->host = "127.0.0.1";
	$typeset_settings->database->database = "typeset2";
	$typeset_settings->database->user = "typeset2_user";
	$typeset_settings->database->password = "typeset2_password";
endif;

/* Admin Accounts
Use yoursite.com/edit/actions/pw to encrypt your password,
or use PHP's "password_hash" function yourself.
*/
$typeset_settings->admins = array(
	(object) array(
		'email' => 'bryan@resen.co',
		'password' => '$2y$10$BCbv/.drHpVBx0I2eC1PY.FdGTDBcBUgxKSBQRQwbrQjfjisvB7f.'
	),
	(object) array(
		'email' => 'demo@demo.com',
		'password' => '$2y$10$OZJiY4/Zdxb3Ifn2.kLERO4aCH6wlwMo/5sYOqEKfPehCpnbCRzbu'
	)
);

?>