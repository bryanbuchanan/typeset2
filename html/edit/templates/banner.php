<div id="<?= $options->id ?>" class="banner" <?= $this->tags($data) ?>>

	<!-- Title -->
	<? if (!empty($options->title)): ?>
		<h3><?= $options->title ?></h3>
	<? endif ?>
	
	<? if (isset($content)): ?>

		<ul class="content">
			<? foreach ($content as $post): ?>
				<li <?= $this->tags($post) ?>>
					<? if (isset($post->image)): ?>
						<a class="image" href="<?= $post->url ?>">
							<img src="<?= $post->image ?>" alt="<?= $post->title ?>">
						</a>
					<? endif ?>
					<? if (isset($post->url)): ?>
						<h4><a href="<?= $post->url ?>"><?= $post->title ?></a></h4>
					<? else: ?>
						<h4><?= $post->title ?></h4>
					<? endif ?>
					<div class="body">
						<?= $post->text ?>
					</div>
				</li>
			<? endforeach ?>
		</ul>

	<? else: ?>

		<strong>Nothing here</strong>

	<? endif ?>
	
</div>