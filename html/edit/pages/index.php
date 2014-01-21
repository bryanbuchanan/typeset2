<? include "../include.php" ?>
<? include "$site_root/$admin_folder/pages/includes/security.php" ?>
<? include "$site_root/$admin_folder/pages/includes/head.php" ?>

<iframe src="/"></iframe>

<div id="overlay"></div>

<!-- Form -->
<div class="form">
	<form id="content" action="#" method="post" autocomplete="off">
		Loading...
	</form>
</div>

<!-- Loading Indicator -->
<div id="uploading" class="prompt">
	<canvas></canvas>
	<strong>Uploading...</strong>
</div>

<? include "$site_root/$admin_folder/pages/includes/footer.php" ?>