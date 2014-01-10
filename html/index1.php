<? include "_typset/include.php" ?>
<!doctype html>
<html>
<head>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<title>resen</title>
	<meta name="description" content="resen is a premium design, web development and photography firm based in Southern California.">

	<meta name="verify-v1" content="mhlyLy4aYo/duI0Zjow2KO00sUKbbGomtT3m0kZ4EcQ=">
	<meta name="google-site-verification" content="V7bLNAjU9jWp64mxiyC-nYSKkVEs2HjVeCyFKdCke2Q">
		
		
		<!-- Production Stylesheets -->
		<link href="http://resen.co/styles/styles.css" rel="stylesheet">
		<link href="http://resen.co/patterns/network/network.css" rel="stylesheet">

		
	<!-- Images -->
	<link rel="icon" type="image/png" href="/favicon.ico">
    
	<!-- Internet Exploder Exceptions -->
	<!--[if lt IE 7]><script>window.location="http://usestandards.com/upgrade?url="+document.location.href;</script><![endif]-->	
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->	

</head>
<body>

	<div id="network">
	
		<ul>
		
			<li class="resen selected"><a href="http://resen.co/">Resen</a></li>
			<li class="typeset"><a href="http://typeset.resen.co/">Typeset</a></li>
			<li class="slides"><a href="http://22slides.com/">22Slides - Easy online portfolios</a></li>
			<li class="curator"><a href="http://curator.resen.co/">Curator</a></li>
			<li class="dashnote"><a href="http://dashnote.resen.co/">DashNote</a></li>
			<li class="social facebook"><a onClick="javascript:_gaq.push(['_trackPageview', 'network/facebook'])" href="http://facebook.com/resenmedia">Facebook</a></li>
			<li class="social twitter"><a onClick="javascript:_gaq.push(['_trackPageview', 'network/twitter'])" href="http://twitter.com/resenco">Twitter</a></li>
	
		</ul>
	
	</div>

	<header>
	
		<h1><strong>resen</strong></h1>

		<p class="products"><strong>we make:</strong><br>
		<a class="slides" href="http://22slides.com/">22Slides</a>, <a class="typeset" href="http://typeset.resen.co/">TypeSet</a>,
		<a class="curator" href="http://curator.resen.co/">Curator</a> &amp; <a class="dashnote" href="http://dashnote.resen.co/">DashNote</a>.</p>
				
		<p><strong>we do:</strong><br>
		graphic design,<br>
		web development<br>
		&amp; <a href="http://photo.resen.co/">photography</a>.</p>
				
		<div class="contact">
	
			<? $typset->blurb(array("tag" => "contact")) ?>

		</div>
	
	</header>
	
	<div class="content" id="home">
	
		<h1>
			<? $typset->blurb(array("tag" => "tagline", "template" => "plain")) ?>
		</h1>
			
		<strong><? $typset->blurb(array("tag" => "clients", "template" => "plain")) ?></strong>
	
	</div>
	
		<!-- Production Scripts -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="http://resen.co/scripts/scripts.js"></script>
	
</body>
</html>
