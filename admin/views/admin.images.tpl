[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1 class="hero">Image Gallery</h1>
		</div>
</div>

[admin-panel.tpl]

<div class="content docs-list">

	<div class="breadcrumbs"><a href="/user">Administration</a> &gt; Image Gallery</div>
	
	<div id="media-gallery">
	[for:media]
		<figure class="imghvr-fade">
			<img class="media" src="/files/upload/[media.file]" alt="Some image" />
			<figcaption>
				URL:<br/>
				<input type="text" value="[web.url]/files/upload/[media.file]" onclick="select_all(this);" />
				<a class="open-media"data-lightbox="gallery" href="[web.url]/files/upload/[media.file]"><img src="/admin/files/img/open-ico.png" alt="open" title="open"></a>
				<a class="del-media" href="/admin/del/files?f=[media.file]"><img src="/admin/files/img/trash.png" alt="delete" title="delete"></a>
			</figcaption>
		</figure>
	[end:media]
	</div>
</div>

<script src="/admin/files/lib/lightbox2/dist/js/lightbox.min.js"></script>

<script>
		function select_all(obj) {
			$(obj).select();
			return false;
        }
</script>
</body>
[admin-footer.tpl]