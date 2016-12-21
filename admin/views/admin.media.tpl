[admin-header.tpl]
<body class="shiftsmith">

	<div style="" class="cf">
	
		<div style="max-width:1024px;width:100%;margin:0 auto;" class="cf">
		

<div class="media-gallery">

	<h1>Media Gallery</h1>

	<ul id="gallery">
	[for:media]
		<li class="box">
			<a href="/files/upload/[media.file]" data-lightbox="image-1" data-title="[web.url]/files/upload/[media.file]" class="hvr-grow"><img src="/files/upload/[media.file]" alt="[media.file]" /></a>
			<div class="link">[web.url]/files/upload/[media.file]</div>
		</li>
	[end:media]
	</ul>
</div>
</div></div>
<script src="/admin/files/lib/lightbox2/dist/js/lightbox.min.js"></script>
</body>
[admin-footer.tpl]