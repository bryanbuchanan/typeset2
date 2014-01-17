<?

$search_engine_indexing = false; // allow search engines to index your folders/files
$sort = "name"; // name or date
$order = "asc"; // asc or desc
$index_folder = "_index"; // Name of the index folder
$disallowed_file_types = "php,sh,pl,rb";
$local_password_file = "_password.txt";
$thumbnail_default_size = 175;
$admin_cookie_name = "typset_h9889390J0kjr"; // Manually define admin cookie name, if you'd like to share login credentials across multiple websites

// Admin Accounts
$admins = array(
	(object) array(
		"name" => "name",
		"password" => "password"
	),
	(object) array(
		"name" => "admin",
		"password" => "password"
	)
);
	
?>