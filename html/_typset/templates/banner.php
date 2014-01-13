<div id="<?= $options->id ?>" class="banner" <?= $this->tags($data) ?>>

	<h3><?= $options->title ?></h3>

	<? if (isset($content)): ?>

		<ul>
			<? foreach ($content as $post): ?>
				<li <?= $this->tags($post) ?>>
					<? if (isset($post->image)): ?>
						<a class="image" href="<?= $post->url ?>">
							<img src="<?= $post->image ?>" alt="<?= $post->title ?>">
						</a>
					<? endif ?>
					<h4><a href="<?= $post->url ?>"><?= $post->title ?></a></h4>
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