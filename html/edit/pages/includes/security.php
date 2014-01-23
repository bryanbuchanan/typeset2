<?

if (!isset($_COOKIE[$typeset_settings->cookie])):

	// Forward to signin page
	header("Location: /$admin_folder/signin");
	exit;

else:
	
	$typeset->signedin = true;

endif;

?>