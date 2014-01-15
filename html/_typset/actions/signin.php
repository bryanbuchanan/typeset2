<?
include "../include.php";

$referrer = $_SERVER['HTTP_REFERER'];

// Return if info is incorrect
if (!isset($_POST['email']) or !isset($_POST['password'])):
	header("Location: $referrer");
	exit;
endif;

// Get data
$email = $_POST['email'];
$password = md5($_POST['password']);

// Iterate through admin accounts
foreach ($typset_settings->admins as $user):
	if ($email === $user->email and $password === $user->password):
		setcookie($typset_settings->cookie, true, time() + 7200, '/');
		header("Location: /$admin_folder");
		exit;	
	endif;
endforeach;

// Return if no match is found
header("Location: $referrer");

?>