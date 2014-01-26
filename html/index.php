<? include "edit/include.php" ?>
<!doctype html>
<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

			<title>Milestone MX</title>
		
		
	<meta name="author" content="Resen : resen.co" />
	<meta name="google-site-verification" content="oEMWFE5BKaib_pCENvhhF028Mbx9W0myiuoB0hcN4q8" />
	<meta name="y_key" content="3f770dca3726a9b5" />

	
		<!-- STYLESHEETS: DEVELOPMENT -->
		<link href="http://milestonemx.com/styles/precedents.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/layout.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/content.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/navigation.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/actions.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/forms.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/body.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/share.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/tabs.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/alerts.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/lightbox.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/module-text.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/module-events.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/module-comments.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/module-tags.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/module-images.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/module-videos.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/module-products.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/module-cart.css" rel="stylesheet" />
		<link href="http://milestonemx.com/styles/custom.css" rel="stylesheet" />
		
			

	<link href="http://milestonemx.com/skin/skin.css" rel="stylesheet" />
	
	<style>
		#hours .body { font-weight: normal; }
		
		#promo li {
			float: left;
			}
			
		#promo li + li {
			margin-left: 20px;
			}
			
		#news .image {
			float: left;
			height: 100%;
			margin: 0 20px 0 0;
			}
		
	</style>


	<!-- INTERNET EXPLORER 7 EXCEPTIONS -->
	<!--[if gte IE 7.]><link href="/styles/ie7.css" media="screen" rel="stylesheet" /><![endif]-->
	
	<!-- INTERNET EXPLORER 6 KILLER -->
	<!--[if lt IE 7.]>
	<link href="/styles/ie6.css" rel="stylesheet" />
	<script src="/scripts/ie.js"></script>
	<![endif]-->
	
	<!-- FEEDS -->
	<link rel="alternate" title="Milestone MX News" href="http://milestonemx.com/feeds/news" type="application/rss+xml" />

</head>
<body id="page-index" class="section-home">

<!-- GOOGLE ANALYTICS -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6281182-48");
pageTracker._trackPageview();
} catch(err) {}</script><div id="layout">

	<div id="header" class="section">
		
		<div>
	
			<h1><a href="/">Milestone MX</a></h1>
	
			<ul id="navigation">
				
				<li class="home"><a href="/">Home</a></li>
				<li class="tracks"><a href="/tracks">Tracks</a></li>
				<li class="events"><a href="/events">Events</a></li>
				<li class="membership"><a href="/membership">Membership</a></li>
				<li class="sponsors"><a href="/sponsors">Sponsors</a></li>
				<li class="photos"><a href="/photos">Photos</a></li>
				<li class="contact"><a href="/contact">Directions/Contact</a></li>
			
			</ul>
	

			<? $typeset->banner(array(
				"tag" => "billboard",
				"id" => "billboard",
				"image_width" => 918
			)) ?>
					
				<div id="billboard-top" class="frame"></div>
				<div id="billboard-right" class="frame"></div>
				<div id="billboard-bottom" class="frame"></div>
				<div id="billboard-left" class="frame"></div>
			
				<!-- NEXT EVENTS -->
				<div id="next" class="events browse featured">

<h3>Next Events</h3>

<ul class="content">

<li>
<em class="date">
<var>Jan</var>
<span class="day">26</span>
<span class="year">2014</span></em>
<h4><a href="/event/all/gold-cup" title="Gold Cup">Gold Cup</a></h4>
<span></span>
</li>

<li class="alt">
<em class="date">
<var>Mar</var>
<span class="day">2</span>
<span class="year">2014</span></em>
<h4><a href="/event/all/muscle-milk-twmxs-2" title="Muscle Milk TWMXS">Muscle Milk TWMXS</a></h4>
<span></span>
</li>

</ul>

<ul class="actions paging">
<li class="next"><a href="?events_page=2" class="action next"><span>Next Page</span></a></li>
</ul>

<ul class="pages">
<li><em>Page : </em></li>
<li><strong>1</strong></li>
<li><a href="?events_page=2">2</a></li>
</ul>

</div>

			<? $typeset->banner(array(
				"tag" => "promo",
				"id" => "promo",
				"image_width" => 293
			)) ?>
						
				
		</div>
		
	</div>
	<div class="section">
	
		<div class="content">
			
			<h2>Home</h2>
<div id="main">

	<? $typeset->blog(array(
		"tag" => "news",
		"id" => "news",
		"title" => "What's New?",
		"thumb_width" => 100,
		"thumb_height" => 100,
		"truncate" => 250
	)) ?>
	
</div>
<div id="sidebar">

	<!-- HOURS -->
	<? $typeset->blurb(array("tag" => "hours", "id" => "hours")) ?>
	
	<!-- WEATHER WIDGET -->
	<div id="weather">

	<div class="image"></div>

	<dl>
	
		<dt class="temperature">...&deg;</dt>
		
		<dt class="conditions">Loading...</dt>
		
		<dt class="wind">Wind:</dt>
		<dd class="wind">...</dd>
		
		<dt class="humidity"><em>/</em> Humidity:</dt>
		<dd class="humidity">...</dd>
	
	</dl>

	<div class="links">

		<a href="http://weather.yahoo.com/united-states/california/riverside-2482250/" target="_blank">Full Forecast</a>
		<a href="http://www.dirtlink.net/track.php?track_id=30" target="_blank">Live Camera</a>
		<a href="/contact">Map/Directions</a>

	</div>

</div>
	<!-- PHONE -->
	<!--
<div id="phone">
	
	<h3>Get Track Updates</h3>
	<p>Get track updates sent straight to your mobile phone.</p>

	<script type="text/javascript" language="javascript" src="https://secure.txtpkg.com/members/contactwidget.php?key=97b7c1e096d81331199730e98bd9a48980cb351edd7adcbb314b6c3637aca2178960be8fb283fac59cc125ea1c81ffdd&tc=000000&bg=FFFFFF&bt=1&bc=000000"></script>

</div>
-->
	<!-- MAILING LIST OPT-IN -->
	<div id="mailinglist">

	<form name="ccoptin" action="http://visitor.constantcontact.com/d.jsp" target="_blank" method="post">
	
		<input type="hidden" name="m" value="1102608159559" />
		<input type="hidden" name="p" value="oi" />
		
		<h3>Join The Mailing List</h3>
		
		<p>Get coupons and other deals sent straight to your inbox!</p>
		
		<label>
		<input type="text" name="ea" size="20" placeholder="Enter Your Email Address" />
		</label>
		
		<ul class="actions">
		<li><input type="submit" name="go" value="Join" class="submit" /></li>
		</ul>
	
	</form>

</div>
	


		</div>
		
	</div>
	<div class="section">
	
		<ul id="footer">
	
			<li class="milestone">Milestone MX</li>
			<li class="contact">
				<em>951-686-GOMX (951-686-4669)</em><br />
				12685 Holly Street, Riverside, CA 92509
			</li>
			<li class="copyright">&copy; 2014 Milestone Ranch MX Park, Inc . All Rights Reserved.</li>
			<li class="resen"><a href="http://resen.co/" target="_blank">Resen</a></li>
		
		</ul>
			
	</div>

</div>

<!-- JAVASCRIPTS -->
<script>
	var page = "1";
	var section = "home";
</script>


	<!-- DEVELOPMENT -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="http://milestonemx.com/scripts/swfobject.js"></script>
	<script src="http://milestonemx.com/scripts/cufon.js"></script>
	<script src="http://milestonemx.com/fonts/leaguegothic.js"></script>
	<script src="http://milestonemx.com/scripts/lightbox.js"></script>
	<script src="http://milestonemx.com/scripts/jquery-tabs.js"></script>
	<script src="http://milestonemx.com/scripts/jquery-cycle.js"></script>
	<script src="http://milestonemx.com/scripts/jquery-tweet.js"></script>
	<script src="http://milestonemx.com/scripts/functions.js"></script>
	<script src="http://milestonemx.com/scripts/custom.js"></script>

	
	<script>
	
		var replace = [
			'#promo h4',
		];
		Cufon.replace(replace.toString(), { hover: true });

	
		
	</script>
	

</body>
</html>

