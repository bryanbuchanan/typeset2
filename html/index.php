<? include "_typset/include.php" ?>
<!doctype html>
<html>
<head>

	<meta charset="utf-8">

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
		// "truncate" => 100
	)) ?>

	<? $typset->html(array("tag" => "blog")) ?>

</body>
</html>