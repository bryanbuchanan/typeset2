<? include "edit/include.php" ?>
<!doctype html>
<html>
<head>

	<meta charset="utf-8">

	<link href="/styles.css" rel="stylesheet">

</head>
<body>
		
	<h1>This is a website!</h1>

	<? $typset->banner(array(
		"tag" => "billboard"
	)) ?>
	
	<? $typset->blurb(array(
		"tag" => "again"
	)) ?>
	
	<? $typset->blog(array(
		"tag" => "blog",
		"items" => 10,
		"id" => "fruits",
		"title" => "Blog",
		"scope" => "past",
		"order" => "desc",
		"page" => "post.php"
		// "format" => "raw"
		// "truncate" => 100
	)) ?>

	<? $typset->html(array("tag" => "blog")) ?>

</body>
</html>