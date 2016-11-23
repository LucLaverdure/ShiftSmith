[admin-header.tpl]
<div class="media-gallery">

	<h1>Media Gallery</h1>

	[for:media]
		<a target="_blank" href="/files/upload/[media.file]" class="hvr-grow hvr-fade media-button">
			<img src="/files/upload/[media.file]" />
			<span class="info">
				http://dreamforgery.com/files/upload/[media.file]<br>
				height: [media.height], width: [media.width],<br>
				size: [media.size]
			</span>
			<strong>Click to download</strong>
			<span class="del"></span>
		</a>
	[end:media]
</div>
[admin-footer.tpl]