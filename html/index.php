<? include "edit/include.php" ?>
<!doctype html>
<html">
<head>
	
	<meta charset="utf-8">
	<title>Typeset2 - A simple open-source content management system</title>
	<link rel="stylesheet" href="/styles.css">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/styles/railscasts.min.css">

</head>
<body>

<section id="billboard">

	<div>
	
		<h1>Typeset2</h2>
		<? $typeset->blurb(array(
			"tag" => "intro",
			"id" => "intro"
		)) ?>
			
<!--
Typeset2 is a simple open-source content management system that can be added to most any PHP website. It's ideal for small custom hand-made sites that need to allow the client to update small bits of content themselves.
-->
		
		<p><a class="button" href="/edit">Try editing this page now</a><br>
		
		<small>(Don't worry about messing anything up. This page resets every 10 minutes.)</small>
		
	</div>

	<a href="https://github.com/resenco/typeset2.resen.co" class="github">View on GitHub &rarr;</a>

</section>
		
<section>

	<h2 class="title">Features</h2>

	<? $typeset->banner(array(
		"tag" => "features",
		"id" => "features"
	)) ?>

<!--

Non-intrusive
You add it to your website, vs. having to adjust your workflow and build your website around the CMS.

Design-independent</strong> Widgets spit out compliant HTML without any styles, and all content's HTML can be edited.

Crazy simple to use
Have a stupid client that can't be trusted with a WordPress site? Perfect.

Almost-inline editing
Rather than a separate admin area, users can click on the content they'd like to edit and do so right on the page.

Markdown text formatting
Markdown text formatting to give users enough control to format their text, but not enough to make it ugly.

Client-side image resizing
Images are resized client-side before they're uploaded, so large images can be used without having to worry about resource limits.

-->
			
</section>

<section>

	<h2 class="title">Installation</h2>
	<? $typeset->blurb(array(
		"tag" => "installation",
		"id" => "installation",
	)) ?>
	
<!--	
1. Upload just the `html/edit` folder to the root level of the website.
2. Create a new MySQL database by importing the `database_template.sql` file.
3. Open "edit/_settings.php" and change the settings appropriately.
4. Insert `<? include "/edit/include.php" ?>` at the top of any pages that should display managed content.
5. Insert the appropriate "widget" in the pages where necessary.
6. The admin area is accessible via `yourwebsite.com/edit`
-->
		
</section>

<section id="examples" class="tabs_container">

	<h2 class="title">Content Types</h2>
	
	<ul class="tabs">
		<li><a href="#blogs">Blogs</a></li>
		<li><a href="#banners">Banners</a></li>
		<li><a href="#blurbs">Blurbs</a></li>
		<li><a href="#html">HTML</a></li>
	</ul>

	<div id="blogs">
		<div class="intro">
			<h3>Blogs</h3>
			<p>Sequencial posts with dates, titles, an image, and a body of text, best for things like news articles, press releases, blogs, events, or any kind of content that needs to be organized by date.</p>
			<p>Posts given a date in the future will be saved for later and published on that date, so posts can be created in advanced and automatically published at a specific date.</p>		
		</div>
<pre><code>&lt;? $typeset->blog(array(
	# Required Properties
	"tag" => "blog", 		# A unique name given to the content
	"page" => "post.php?topic=", 	# URN to link the full article to
	# Optional
	"title" => "My Blog", 		# Adds heading to the top of content
	"id" => "my-blog", 		# Adds id selector to content
	"items" => 10, 			# Limits the number of items returned
	"scope" => "past", 		# past/future/all
	"sort" => "date", 		# date/id/title/tag - Property to sort by
	"order" => "desc", 		# desc/asc
	"skip" => 0 			# Skip a designated number of items
	"image_width" => 1000, 		# Max image width
	"image_height" => 1000, 	# Max image height
	"thumb_width" => 200,		# Max thumbnail width
	"thumb_height" => 200,		# Max thumbnail height
	"truncate" => 0, 		# Truncates the posts to short blurbs of x characters
	"format" => "html" 		# html/json/raw
)) ?>
</code></pre>
		
		<div class="example">
			<? $typeset->blog(array(
				# Required Properties
				"tag" => "blog", 		# A unique name given to the content
				"page" => "post.php?topic=", 	# URN to link the full article to
				# Optional
				"title" => "My Blog" 		# Adds heading to the top of content
			)) ?>
		</div>
		
	</div>
	<div id="banners">
		<div class="intro">
			<h3>Banners</h3>
			<p>Banners are similar to blogs, but don't have a concept of dates. They're best for things like banners (obviously), ads, rotating image sliders, or any other group of image and/or text content.</p>
		</div>
<pre><code>$typeset->banner(array(
	# Required
	"tag" => "",		# A unique name given to the content
	# Optional
	"title" => "Banners",	# Adds heading to the top of content
	"id" => "my-banners",	# Adds id selector to content
	"items" => 50,		# Limits the number of items returned
	"sort" => "id",		# id/title/tag - date/id/title/tag - Property to sort by
	"order" => "desc",	# desc/asc
	"image_width" => 1000, 	# Max image width
	"image_height" => 1000, # Max image height
	"format" => "html"	# html/json/raw
));</code></pre>		
		<div class="example">
			<? $typeset->banner(array(
				"tag" => "billboard"
			)) ?>
		</div>
	</div>
	<div id="blurbs">
		<div class="intro">
			<h3>Blurbs</h3>
			<p>A blurb is a bit of image/text content that doesn't appear in a group or sequence, ideal for things like an "about us" section or any bit of text.</p>
		</div>
		<div class="example">
			<? $typeset->blurb(array(
				"tag" => "again",
				"image_height" => 600,
				"image_width" => 600
			)) ?>
		</div>
	</div>
	<div id="html">
		<div class="intro">
			<h3>HTML</h3>
			<p>asdf</p>
		</div>
		<div class="example">
			<? $typeset->html(array(
				"title" => "asdf",
				"tag" => "html_example"
			)) ?>
		</div>

	</div>

</section>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<script>
	$(document).ready(function() {
		// Reusable function
		function chooseTab($selected) {
			var $container = $('.tabs_container');
			$selected.siblings().removeClass('selected');
			$selected.addClass('selected');
			var id = $selected.children('a').prop('href').split('#').pop();
			$container.children('div').hide();
			$container.children('#' + id).show();
		};
			
		// Initial Page Load
		var $selected = $('.tabs_container .tabs > li:first-child');
		if ($selected.length > 0) chooseTab($selected);
	
		// Clicks
		$('.tabs_container .tabs a').click(function() {
			var $selected = $(this).parent();
			chooseTab($selected);
			return false;
		});
	
	});
</script>

</body>
</html>