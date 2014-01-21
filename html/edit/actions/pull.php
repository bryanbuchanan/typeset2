<?
if (!empty($_POST['payload'])):
	exec('git pull', $output);
	$output = print_r($output, true);
	mail("bryan@resen.co", "typset demo push", $output);
endif;
?>