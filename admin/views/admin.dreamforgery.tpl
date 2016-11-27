[admin-header.tpl]
<div class="admin-panel">

	<h1><img src="/admin/files/img/ico/forge.png" title="Forge" />Forge Item</h1>

	<label>
		<h2>Title</h2>
		<input class="forge-title" type="text" value="" placeholder="Title" name="title" />
	</label>
	
		<h2>Triggers</h2>
		
		<label>Publish date</label>
		<input class="forge-url-trigger" type="text" value="" placeholder="/" name="date" />
		
		<label>URL Pattern:</label>
		<input class="forge-url-trigger" type="text" value="" placeholder="/" name="url" />

	<label><input type="checkbox" name="loggedasadmin" />Logged in as administrator</label>
	
	<h2>Body Type</h2>
	<div class="body_type">
		<label><input class="datepicker" type="radio" value="content" name="body_type" />Provide Markup</label>
		<label><input type="radio" value="cache" name="body_type" />Fetch Markup and cache copy locally</label>
		<label><input type="radio" value="live" name="body_type" />Fetch Markup as live content</label>
	</div>
	<textarea id="ckeditor" name="body" placeholder=""></textarea>

	<script>
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace( 'ckeditor' );
	</script>

</div>

[admin-footer.tpl]