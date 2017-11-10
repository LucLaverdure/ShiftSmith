[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1 class="hero">Misc Uploads</h1>
		</div>
</div>

[admin-panel.tpl]

<div class="content docs-list">

	<div class="breadcrumbs"><a href="/user">Administration</a> &gt; Misc Uploads</div>

	<p>The following downloadable files were found:</p>
	
	<div id="video-gallery">
	[for:misc]
		<div class="wrap-shadow cf">
			<div class="title">
				<p><input type="text" value="[web.url]/files/upload/[misc.file]" onclick="select_all(this);"/></p>
				<p><a target="_blank" href="[web.url]/files/upload/[misc.file]">Download</a></p>
			</div>
		</div>
	[end:misc]
	</div>
	
</div>
	
</body>

<script>
		function select_all(obj) {
			$(obj).select();
			return false;
        }
</script>

[admin-footer.tpl]