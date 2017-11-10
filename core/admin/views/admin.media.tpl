[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1 class="hero">Media Gallery</h1>
		</div>
</div>

[admin-panel.tpl]

<div class="content docs-list">

	<div class="breadcrumbs"><a href="/user">Administration</a> &gt; Media Gallery</div>

	<div id="media-gallery">
	[for:media]
		<figure class="imghvr-fade">
			<img class="media" src="/files/upload/[media.file]" alt="Some image" />
			<figcaption>
				URL:<br/>
				<input type="text" value="[web.url]/files/upload/[media.file]" onclick="select_all(this);" />
			</figcaption>
		</figure>
	[end:media]
	</div>
</div>

<script src="/core/admin/files/lib/lightbox2/dist/js/lightbox.min.js"></script>

	<script src="/core/admin/files/lib/aos/aos.js"></script>
    <script>
      AOS.init({
        easing: 'swing'
      });
    </script>
	
</body>

<script>
		function select_all(obj) {
			$(obj).select();
			return false;
        }
</script>

[admin-footer.tpl]