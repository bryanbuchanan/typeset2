<? include "../include.php" ?>
<? include "$site_root/$admin_folder/pages/includes/head.php" ?>
	
<iframe src="/"></iframe>

<div id="overlay"></div>
<div class="form">
	<h3>Sign In</h3>
	<form id="signin" action="#" method="post">
		<label class="email">
			<input type="text" name="email" placeholder="Email" autofocus>
		</label><br>
		<label class="password">
			<input type="password" name="password" placeholder="Password">
		</label><br>
		<input class="button" type="submit" value="Sign In">
	</form>
</div>

<? include "$site_root/$admin_folder/pages/includes/footer.php" ?>