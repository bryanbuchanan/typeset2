	<!-- Scripts -->
	<script>
		var admin_folder = "<?= $admin_folder ?>";
		var content_folder = "<?= $typeset_settings->content_folder ?>";
		<? if (isset($typeset->signedin)): ?>
			var signed_in = true;
		<? endif ?>
	</script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="library/pickadate.js-3.3.2/lib/picker.js"></script>
	<script src="library/pickadate.js-3.3.2/lib/picker.date.js"></script>	

	<script src="scripts/codemirror-compressed.js"></script>
	<script src="library/codemirror/codemirror-placeholder.js"></script>
	<script src="scripts/upload.js"></script>	
	<script src="scripts/functions.js"></script>
	
</body>
</html>