[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1 class="hero">Video Gallery</h1>
		</div>
</div>

[admin-panel.tpl]

<div class="content docs-list">

	<div class="breadcrumbs"><a href="/user">Administration</a> &gt; Video Gallery</div>

	<p>The following video files were found:</p>
	
	<div id="video-gallery">
	[for:video]
		<div class="wrap-shadow cf">
			<div class="title">
				<input type="text" value="[web.url]/files/upload/[video.file]" onclick="select_all(this);"/>
			</div>
		</div>
	[end:video]
	</div>
	
	<p>We recommend uploading them to a video server such as:</p>
	
	<ul class="video-host">
		<li><a target="_blank" href="https://www.youtube.com/upload"><img src="/core/admin/files/img/youtube.png" alt="YouTube" /></a></li>
		<li><a target="_blank" href="https://vimeo.com/upload"><img src="/core/admin/files/img/vimeo.png" alt="Vimeo" /></a></li>
	</ul>
</div>
	
</body>

<script>
		function select_all(obj) {
			$(obj).select();
			return false;
        }
</script>

[admin-footer.tpl]