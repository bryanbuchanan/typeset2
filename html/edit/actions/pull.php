<?
if (isset($_POST)):
	exec('git pull', $output);
	// $output = print_r($output, true);
	mail("bryan@resen.co", "typeset demo pushed", $output);
else:
	echo "no data";
endif;
?>