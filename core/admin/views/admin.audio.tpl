[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1 class="hero">Audio Gallery</h1>
		</div>
</div>

[admin-panel.tpl]

<div class="content docs-list">

	<div class="breadcrumbs"><a href="/user">Administration</a> &gt; Audio Gallery</div>

	<div id="audio-gallery">
	[for:audio]
		<div class="wrap-shadow cf">
			<div class="title">
				<input type="text" value="[web.url]/files/upload/[audio.file]" onclick="select_all(this);"/>
			</div>
			<audio controls>
			  <source src="/files/upload/[audio.file]" type="audio/[audio.type]">
			</audio>
		</div>
	[end:audio]
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