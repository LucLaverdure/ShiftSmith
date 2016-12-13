[admin-header.tpl]
<body class="shiftsmith">

	<div style="" class="cf">
	
		<div style="max-width:1024px;width:100%;margin:0 auto;" class="cf">
		

<div class="media-gallery">

	<h1>Media Gallery</h1>

	[for:media]
		<a target="_blank" href="/files/upload/[media.file]" class="media-image" style="display:none;" >
			<img src="/files/upload/[media.file]" title="[media.file]" alt="[media.file]" />
		</a>
	[end:media]


</div>
</div></div></body>
[admin-footer.tpl]