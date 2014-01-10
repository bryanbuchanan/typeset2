<div id="<?= $options->id ?>" class="blurb" <?= $this->tags($data) ?>>
	
	<? if (!empty($content->title)): ?>
		<h3><?= $content->title ?></h3>
	<? endif ?>
	
	<div class="body">
		<?= $content->text ?>
	</div>

</div>