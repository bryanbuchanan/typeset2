<? include "_typset/include.php" ?>
<!doctype html>
<html>
<head>

	<meta charset="utf-8">

</head>
<body>
		
	<h1>This is a website!</h1>

	<? $typset->blurb(array("tag" => "test-thing")) ?>
	
	<? $typset->blurb(array("tag" => "somethingelse")) ?>
	
	<? $typset->blurb(array("tag" => "again")) ?>
	
	<? $typset->blog(array("tag" => "blog")) ?>

	<? $typset->html(array("tag" => "blog")) ?>

</body>
</html>