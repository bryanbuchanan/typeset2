<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<title>Encrypt Password</title>

</head>
<body>

	<form action="" method="post">
		<input type="text" name="ppp">
		<input type="submit">
	</form>

	<?
	if (isset($_POST['ppp'])):
		$password = $_POST['ppp'];
		$password = password_hash($password, PASSWORD_DEFAULT);
		echo $password;
	endif;
	?>

</body>
</html>
