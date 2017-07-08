[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1 class="hero">Image Gallery</h1>
		</div>
</div>

[admin-panel.tpl]

<div class="content docs-list">

	<div class="breadcrumbs"><a href="/user">Administration</a> &gt; Image Gallery</div>

	<form action="/file-upload" class="dropzone">
		<div class="fallback">
			<input name="file" type="file" multiple />
		</div>
	</form>

	
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

<script src="/admin/files/lib/lightbox2/dist/js/lightbox.min.js"></script>

	<script src="/admin/files/lib/aos/aos.js"></script>
	
</body>

<script>
		$(".dropzone").dropzone({ url: "" });
		function select_all(obj) {
			$(obj).select();
			return false;
        }
</script>
<script src="/admin/files/lib/dropzonejs/dropzone.js" type="text/javascript"></script>
[admin-footer.tpl]