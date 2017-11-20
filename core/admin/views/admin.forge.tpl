[admin-header.tpl]

<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1 class="hero">Forge</h1>
[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]
			<div class="message upload-success" style="display:none;"></div>
[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
		</div>
</div>

[admin-panel.tpl]

<div class="content docs-list panel-container">

	<p>Please select the type of content you would like to create.</p>
	
	<form action="/core/admin/wizard/upload" class="forge-page-drop">
		<div class="fallback">
			<input name="file" type="file" multiple />
		</div>
	</form>
	
	<div class="forge-option-block">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/lang.png" alt="Page"></div>
		<a href="/admin/create/lang">Languages</a>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/menu.png" alt="Page"></div>
		<a href="/admin/create/menu">Navigation Menu</a>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/page.png" alt="Page"></div>
		<a href="/admin/create/page">Page</a>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/blog.png" alt="blog"></div>
		<a href="/admin/create/post">Blog Entry (Post)</h3>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/block.png" alt="block"></div>
		<a href="/admin/create/block">Custom Block</h3>
	</div>

	<div class="cl forge-option-block">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/sell.png" alt="block"></div>
		<a href="/admin/create/sale">Item to Sell</h3>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/form.png" alt="block"></div>
		<a href="/admin/create/form">Web Form</h3>
	</div>

	<div class="forge-option-block wiz">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/images.png" alt="block"></div>
		<a href="/admin/images">Add Image(s)</h3>
	</div>

	<div class="forge-option-block wiz">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/music.png" alt="block"></div>
		<a href="/admin/audio">Add Audio</h3>
	</div>

	<div class="forge-option-block wiz">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/video.png" alt="block"></div>
		<a href="/admin/videos">Add Video</h3>
	</div>

	
	<div class="cl forge-option-block">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/poc.png" alt="poc"></div>
		<a href="/admin/create/poc">Build PoC (Proof of Concept)</h3>
	</div>

	<div class="forge-option-block wiz">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/db.png" alt="Database"></div>
		<a href="/admin/create/import-db">Import Database (SQL)</h3>
	</div>

	<div class="forge-option-block csv">
		<div class="ico"><img src="/core/admin/files/img/ico/forge/csv.png" alt="Database"></div>
		<a href="/admin/create/import-csv">Import Delimited File (CSV)</h3>
	</div>
	
	<script type="text/javascript">
		function cleanurl(url) {
			url = url.replace(/ /g, '+').replace(/%20/g, '+');
			url = url.replace(/\W+/g, "-");
			while (url.indexOf("--") > -1) {
				url = url.replace("--", "-");
			}
			url = url.toLowerCase();
			return '/'+url;		
		}

		// url generator
		$(function() {
			
			$('.forge-option-block.wiz, .forge-option-block.wiz a').click(function() {
				$('.forge-page-drop').click();
				return false;
			});
			
			$(document).on('change', '#page-title', function() {
				if ($("input[name='action']:checked").val()=='page') {
					$('.forge-url-trigger[name=url]').val(cleanurl($(this).val()));
				}
			});
		});
	</script>
<script src="/core/admin/files/lib/dropzonejs/dropzone.js" type="text/javascript"></script>
<script type="text/javascript">
	var myDropzone = new Dropzone(".forge-page-drop", {
		url: "/core/admin/wizard/upload",
		uploadMultiple: "yes",
		parallelUploads: 2,
		autoProcessQueue: "on",
		method: "post"
	});
	
	myDropzone.on("complete", function(file) {
		myDropzone.removeFile(file);
		$('.upload-success').html("Wizard Import Process Complete.");
		$('.upload-success').fadeIn();
	});

	function select_all(obj) {
		$(obj).select();
		return false;
	}
</script>
[admin-footer.tpl]