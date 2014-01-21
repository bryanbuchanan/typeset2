<?
if (isset($_POST['payload'])):
	exec('git pull', $output);
	$output = print_r($output, true);
	mail("bryan@resen.co", "typset demo push", $output);
else:
	$output = print_r($_POST, true);
	mail("bryan@resen.co", "typset demo didn't push", $output);
endif;
?>