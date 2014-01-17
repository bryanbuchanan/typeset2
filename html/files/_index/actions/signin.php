<?

if (!empty($_POST)):

	include "../config.php";
	include "../library/functions.php";

	// Admin login
	if (isset($admins)):
		foreach ($admins as $account):
			if (strtolower($_POST['name']) == strtolower($account->name)
			and $_POST['password'] == $account->password):
				setcookie($admin_key, true, time() + 7200, '/');
				header('Location: ' . $_SERVER['REQUEST_URI']);
				exit;
			endif;
		endforeach;
	endif;
	
	// Local folder login
	if (isset($_POST['local_password'])):
		// Get password values
		$current_folder = "$home_folder/" . $_POST['local_password'];		
		$local_restriction = find_password($current_folder, $_POST['nest_depth']);
		// Compare credentials
		if (strtolower($_POST['name']) == strtolower($local_restriction['name'])
		and $_POST['password'] == $local_restriction['password']):
			setcookie("junkbox-" . $local_restriction['key'], true, time() + 7200, '/');
			header('Location: ' . $_SERVER['REQUEST_URI']);
			exit;
		endif;
	endif;
	
endif;

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>