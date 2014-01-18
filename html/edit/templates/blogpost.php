<div id="<?= $options->id ?>" class="post" <?= $this->tags($data) ?>>

	<!-- Title -->
	<? if (!empty($options->title)): ?>
		<h3><?= $options->title ?></h3>
	<? endif ?>

	<? if (isset($content) and !empty($content)): ?>
	
		<? if (isset($content->image)): ?>
			<img src="<?= $content->image ?>" alt="<?= $content->title ?>">
		<? endif ?>
		<h3><?= $content->title ?></h3>
		<span class="date"><?= date("M j, Y", strtotime($content->date)) ?></span>
		<div class="body">
			<?= $content->text ?>
		</div>

	<? else: ?>

		<!-- Empty Placeholder -->
		<strong>Nothing here</strong>

	<? endif ?>
	
</div>