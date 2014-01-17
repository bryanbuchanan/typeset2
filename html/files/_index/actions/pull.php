<?
if (!empty($_POST['payload'])):
	exec('git pull', $output);
	$output = print_r($output, true);
	mail("bryan@resen.co", "junkbox.resen.co push", $output);
endif;
?>