<?

// Get home folder
$home_folder = preg_replace("#/$index_folder.*$#", "", dirname(__FILE__));

// Create admin key out of first admin account's password
if (!isset($admin_cookie_name)):
	$admin_key = "junkbox-" . md5($admins[0]->password);
else:
	$admin_key = $admin_cookie_name;
endif;

// Parse disallowed file type list
$disallowed_file_types = "test," . $disallowed_file_types;

// Resolve duplicate names
function resolve_duplicate_names($location) {
	if (is_dir($location) or is_file($location)):
		$exploded = explode("-", $location);
		$suffix = array_pop($exploded);
		$name = str_replace("-$suffix", "", $location);	
		$new_suffix = (is_numeric($suffix) ? $suffix + 1 : "1" );
		return resolve_duplicate_names("$name-$new_suffix");			
	else:
		return $location;
	endif;
}

// Server Response
function respond($status, $message="") {
	echo json_encode(array(
		"status" => $status,
		"message" => $message
	));
	die();
}

// Find local passwords
function find_password($current_folder, $nest_depth) {
	// Get password file name
	global $local_password_file;
	// Loop through each parent directory, up until application home dir
	for ($i=0; $i<=$nest_depth; $i++):
		// Get path to look in
		$look_backwards = str_repeat("../", $i);
		$look_for = realpath("$current_folder/$look_backwards$local_password_file");
		// If found
		if (is_file($look_for)):
			// Get password info
			$local_account_data = file_get_contents($look_for, true);
			preg_match("#^name:\s*(.+?)$#im", $local_account_data, $local_name);
			preg_match("#^password:\s*(.+?)$#im", $local_account_data, $local_password);
			// Return
			return array(
				"key" => md5($look_for),
				"name" => $local_name[1],
				"password" => $local_password[1]
				);
			// Stop loop
			break;
		endif;
	endfor;
	return false;
}

?>