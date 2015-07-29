<?
if (isset($_POST)):
	exec('git pull', $output);
	// $output = print_r($output, true);
	mail("bryan@resen.co", "typeset demo pushed", $output, "From: Typeset2 Repo <info@resen.co>");
else:
	echo "no data";
endif;
?>