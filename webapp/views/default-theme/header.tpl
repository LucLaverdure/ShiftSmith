<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

<title>ShiftSmith MVC Platform</title>

<link href="https://fonts.googleapis.com/css?family=Sarpanch" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Source+Code+Pro" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="/admin/files/lib/jquery-ui/jquery-ui.structure.min.css" />
<link rel="stylesheet" type="text/css" href="/admin/files/lib/jquery-ui/jquery-ui.theme.min.css" />

<link rel="stylesheet" type="text/css" href="/admin/files/lib/prism/prism.css" />
<link rel="stylesheet" type="text/css" href="/admin/files/lib/unslider/unslider.css" />
<link rel="stylesheet" type="text/css" href="/admin/files/lib/unslider/unslider-dots.css" />
<link rel="stylesheet" type="text/css" href="/admin/files/lib/awesome/awesome.min.css" />
<link rel="stylesheet" type="text/css" href="/admin/files/lib/hover/hover-min.css" />
<link rel="stylesheet" type="text/css" href="/files/css/common.css" />

<script src="/admin/files/lib/jquery/jquery-1.12.3.min.js" type="text/javascript"></script>
<script src="/admin/files/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/admin/files/lib/unslider/unslider-min.js" type="text/javascript"></script>
<script src="/admin/files/lib/parallax/parallax.min.js" type="text/javascript"></script>
<script src="/admin/files/lib/prism/prism.js" type="text/javascript"></script>
<script src="/files/js/main.js" type="text/javascript"></script>

<meta property="og:image" content="http://www.ShiftSmith.com/files/img/logo-black.gif" />
<meta property="og:title" content="ShiftSmith" />
<meta property="og:site_name" content="ShiftSmith"/>

</head>

<body>
			<div id="wrapper">
			<div class="highlight cf">
				<div class="inner-wrapper cf">
					<div class="header cf">
						<div class="head-left">
							<span class="logo"><a href="/"></a></span>
							<a href="/">
								<h1><span class="title-left">Shift</span><span class="title-right">Smith</span></h1>
								<h2>Web Software Suite</h2>
							</a>
						</div>
						<ul id="nav" class="cf">
							<li><a href="#docs" id="docslink">Documentation</a></li>							
							<li><a href="#tutorials" id="tutorialslink">Tutorials</a></li>
							<li><a href="#downloads" id="downloadslink">Downloads</a></li>
						</ul>
<script>						
		$('#docslink,#tutorialslink,#downloadslink').click(function() {
			$this = $(this);
			$('html, body').animate({
					scrollTop: $($this.attr('href')).offset().top
			}, 200);
			return false;
		});
</script>
						
					</div>
				</div>
			</div>
