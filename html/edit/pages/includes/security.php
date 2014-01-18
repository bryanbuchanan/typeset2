<?

if (!isset($_COOKIE[$typset_settings->cookie])):

	// Forward to signin page
	header("Location: /$admin_folder/signin");
	exit;

else:
	
	$typset->signedin = true;

endif;

?>