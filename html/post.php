<? include "edit/include.php" ?>
<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	
	<title><?= $typset->post_title("blog", $_GET['topic']) ?> - <?= $typset_settings->site_title ?></title>

</head>
<body>
			
	<? $typset->blogpost(array(
		"tag" => "blog"
	)) ?>

</body>
</html>