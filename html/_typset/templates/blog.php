<div id="<?= $options->id ?>" class="blog" <?= $this->tags($data) ?>>

	<h3><?= $options->title ?></h3>

	<? if (isset($content)): ?>

		<ul>
			<? foreach ($content as $post): ?>
				<li <?= $this->tags($post) ?>>
					<h4><a href="/<?= $post->urn ?>"><?= $post->title ?></a></h4>
					<span class="date"><?= date("M j, Y", strtotime($post->date)) ?></span>
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