[admin-header.tpl]

<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">

		<div class="wrapper-login cf">
			<h1>Forge</h1>
[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
		</div>
</div>

[admin-panel.tpl]

<div class="panel-container">
	<form method="post" action="" enctype="multipart/form-data">

	<p>Please select the type of content you would like to create.</p>
	
	<div class="forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/page.png" alt="Page"></div>
		<a href="/admin/create/page">Page</a>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/blog.png" alt="blog"></div>
		<a href="/admin/create/post">Blog Entry (Post)</h3>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/block.png" alt="block"></div>
		<a href="/admin/create/block">Custom Block</h3>
	</div>

	<div class="cl forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/sell.png" alt="block"></div>
		<a href="/admin/create/sale">Item to Sell</h3>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/form.png" alt="block"></div>
		<a href="/admin/create/form">Web Form</h3>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/images.png" alt="block"></div>
		<a href="/admin/create/music">Add Image(s)</h3>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/music.png" alt="block"></div>
		<a href="/admin/create/music">Add Audio</h3>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/video.png" alt="block"></div>
		<a href="/admin/create/music">Add Video</h3>
	</div>

	
	<div class="cl forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/poc.png" alt="poc"></div>
		<a href="/admin/create/poc">Build PoC (Proof of Concept)</h3>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/wp.png" alt="wp"></div>
		<a href="/admin/create/migration-wp">Migrate Wordpress to ShiftSmith</h3>
	</div>

	<div class="forge-option-block">
		<div class="ico"><img src="/admin/files/img/ico/forge/db.png" alt="Database"></div>
		<a href="/admin/create/migration-db">Migrate Database to ShiftSmith</h3>
	</div>
	
	</form>
	
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
			$(document).on('change', '#page-title', function() {
				if ($("input[name='action']:checked").val()=='page') {
					$('.forge-url-trigger[name=url]').val(cleanurl($(this).val()));
				}
			});
		});
	</script>

[admin-footer.tpl]