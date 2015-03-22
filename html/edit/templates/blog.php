<div id="<?= $options->id ?>" class="blog" <?= $this->tags($data) ?>>

	<!-- Title -->
	<? if (!empty($options->title)): ?>
		<h3><?= $options->title ?></h3>
	<? endif ?>

	<? if (isset($content)): ?>

		<!-- Content -->
		<ul class="content">
			<? foreach ($content as $post): ?>
				<? $link = "/$options->page/$post->urn" ?>
				<li <?= $this->tags($post) ?>>
					<? if (isset($post->image)): ?>
						<a class="image" href="<?= $link ?>">
							<img src="<?= $post->thumb ?>" alt="<?= $post->title ?>">
						</a>
					<? endif ?>
					<h4><a href="<?= $link ?>"><?= $post->title ?></a></h4>
					<span class="date"><?= date("M j, Y", strtotime($post->date)) ?></span>
					<div class="body">
						<?= $post->text ?>
					</div>
				</li>
			<? endforeach ?>
		</ul>

		<!-- Paging -->
		<ul class="paging">
			<? if (isset($options->prev_page)): ?>
				<li class="prev"><a href="<?= $options->prev_page ?>">&larr; Previous Page</a></li>
			<? endif ?>
		
			<? if (isset($options->next_page)): ?>
				<li class="next"><a href="<?= $options->next_page ?>">Next Page &rarr;</a></li>
			<? endif ?>
		</ul>

	<? else: ?>

		<!-- Empty Placeholder -->
		<strong>Nothing here</strong>

	<? endif ?>
	
</div>
