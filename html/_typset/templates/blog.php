<div id="<?= $options->id ?>" class="blog" <?= $this->datatags($data) ?>>

	<h3><?= $options->title ?></h3>

	<? if (isset($content)): ?>

		<ul>
			<? foreach ($content as $post): ?>
				<li <?= $this->datatags($post) ?>>
					<h4><?= $post->title ?></h4>
					<span class="date"><?= $post->date ?></span>
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