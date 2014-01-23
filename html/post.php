<? include "edit/include.php" ?>
<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	
	<title><?= $typeset->post_title("blog", $_GET['topic']) ?> - <?= $typeset_settings->site_title ?></title>

</head>
<body>
			
	<? $typeset->blogpost(array(
		"tag" => "blog"
	)) ?>

</body>
</html>