[admin-header.tpl]
<body class="shiftsmith">

	<div style="" class="cf">
	
		<div style="max-width:1024px;width:100%;margin:100px auto;" class="cf">
		
		<form method="post" action="">
<div class="admin-panel">

	<h1 class="create" style="font-weight:800;"><img src="/admin/files/img/ico/forge.png" title="Forge" />
	<span class="title-left">Shift</span><span class="title-right">Smith</span>
	</h1>

	<p>
	<label>
		<h2 class="header-block required">Title</h2>
		<input class="forge-title" type="text" value="" placeholder="Page title / Block title / Script title" name="title" />
	</label>
	</p>
	
	<p>
	<label>
		<h2 class="header-block required">Description</h2>
		<input class="forge-title" type="text" value="" placeholder="Page Description / Block Description / Script Description" name="description" />
	</label>
	</p>
	
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
			$(document).on('change', 'input.forge-title[name=title]', function() {
				$('.forge-url-trigger[name=url]').val(cleanurl($(this).val()));
			});
		});
	</script>

	<p>
	<label>
		<h2 class="header-block required">Tags</h2>
	</label>
	<select class="js-tags form-control" multiple="multiple" style="width:100%;" name="tagsDisplay">
		<option selected="selected" value="page">page</option>
	</select>
	</p>
	
<script type="text/javascript">
$(function() {
	$(".js-tags").select2({
	  tags: true,
	  tokenSeparators: [',', ' ']
	});
});
</script>

	
	<h2 class="header-block">Triggers</h2>
	<p>
	<label class="field-head sub-header-block required">Publish date </label>
	<input class="forge-url-trigger datepicker" type="text" value="" placeholder="/" name="date" />
	</p>
	
	<script type="text/javascript">
		var today = new Date();
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();

		if(dd<10) {
			dd='0'+dd
		} 

		if(mm<10) {
			mm='0'+mm
		} 

		today = mm+'/'+dd+'/'+yyyy;
		$('.datepicker').val(today);
	</script>

	<p>
	<label class="field-head sub-header-block required">URL Pattern:</label>
	<input class="forge-url-trigger" type="text" value="" placeholder="/" name="url" />
	</p>
	
	<p>
	<label class="sub-header-block"><input type="checkbox" name="loggedasadmin" />Require admin to be logged in.</label>
	</p>
	
	<h2 class="required">Input Type</h2>
	<div class="body_type">
		<label><input type="radio" value="markup" name="body_type" /><a href="#">Provide HTML (HTML Editor)</a></label>
		<div class="markup-select" style="display:none;">
			<textarea id="ckeditor" name="ckeditor" placeholder=""></textarea>
		</div>
	
		<label class="header-block"><input type="radio" value="url" name="body_type" /><a href="#">Fetch Markup From Web URL</a></label>
		
		<div class="url-select" style="display:none;">
			<label class="sub-header-block required">Input URL</label>
			<p><input type="text" value="" placeholder="http://perdu.com" class="forge-url-trigger" /></p>
			
			<label class="sub-header-block required">Selector</label>
			<p><input type="text" value="" placeholder="html body" class="forge-url-trigger" /></p>
		</div>

		<label><input type="radio" value="db" name="body_type" /><a href="#">Database</a></label>
		<div class="db-select" style="display:none;">
			<div>
				<h3 class="sub-header-block">Database Hostname:</h3>
				<input type="text" value="" placeholder="localhost" class="forge-url-trigger" />
				<h3 class="sub-header-block">Database User:</h3>
				<input type="text" value="" placeholder="user" class="forge-url-trigger" />
				<h3 class="sub-header-block">Database Password:</h3>
				<input type="password" value="" placeholder="password" class="forge-url-trigger" />
				<h3 class="sub-header-block">Database Name:</h3>
				<input type="text" value="" placeholder="db_data" class="forge-url-trigger" />
				<h3 class="sub-header-block">Database SQL:</h3>
				<input type="text" value="" placeholder="SELECT * FROM users" class="forge-url-trigger" />
			</div>
		</div>

		<label><input type="radio" value="file" name="body_type" /><a href="#">Upload File(s) (*.csv, *.pdf, *.txt, *.doc, *.docx)</a></label>
		<div class="file-select" style="display:none;">
			<input type="file" name="file[]" multiple="multiple" class="files-upload"
			accept=".gif,.jpg,.jpeg,.png,.doc,.docx,.pdf" />
			<div class="files-selected"></div>
		</div>
<script type="text/javascript">
	$(".files-upload").change(function(e) {

		var f = e.target.files,
            len = f.length,
			files = '';
        for (var i=0;i<len;i++) {
			if (typeof(f[i].name) != 'undefined') {
				files += f[i].name + '<br/>';
			} else if (typeof(f[i].filename) != 'undefined') {
				files += f[i].filename + '<br/>';
			}
        }

		$('.files-selected').html(files);
	});
</script>
		<label><input type="radio" value="drupal-import" name="body_type" /><a href="#">Migrate Drupal data to ShiftSmith</a></label>
		<div class="drupal-select" style="display:none;">
			<div>
				<h3 class="sub-header-block">Drupal Database Hostname:</h3>
				<input type="text" value="" placeholder="localhost" class="forge-url-trigger" />
				<h3 class="sub-header-block">Drupal Database User:</h3>
				<input type="text" value="" placeholder="user" class="forge-url-trigger" />
				<h3 class="sub-header-block">Drupal Database Password:</h3>
				<input type="password" value="" placeholder="password" class="forge-url-trigger" />
				<h3 class="sub-header-block">Drupal Database Name:</h3>
				<input type="text" value="" placeholder="db_data" class="forge-url-trigger" />
			</div>
		</div>

		<label><input type="radio" value="wp-import" name="body_type" /><a href="#">Migrate Wordpress data to ShiftSmith</a></label>
		<div class="wp-select" style="display:none;">
			<div>
				<h3 class="sub-header-block">Wordpress Database Hostname:</h3>
				<input type="text" value="" placeholder="localhost" class="forge-url-trigger" />
				<h3 class="sub-header-block">Wordpress Database User:</h3>
				<input type="text" value="" placeholder="user" class="forge-url-trigger" />
				<h3 class="sub-header-block">Wordpress Database Password:</h3>
				<input type="password" value="" placeholder="password" class="forge-url-trigger" />
				<h3 class="sub-header-block">Wordpress Database Name:</h3>
				<input type="text" value="" placeholder="db_data" class="forge-url-trigger" />
			</div>
		</div>
		
	</div>

	<h2 class="required">Fetch Method</h2>
	<div class="body_type">
		<label><input type="radio" value="html" name="fetch_type" /><a href="#">Fetch once and cache data (faster, but requires maintenance)</a></label>
		<label><input type="radio" value="admin" name="fetch_type" /><a href="#">Fetch live data (slower, but requires no maintenance)</a></label>
	</div>

	
	<h2 class="required">Parse Type</h2>
	<div class="body_type">
		<label><input type="radio" value="admin" name="parse_type" /><a href="#">Admin Input (Allow shortcodes)</a></label>
		<label><input type="radio" value="html" name="parse_type" checked="checked" /><a href="#">Third Party Input (Disable Shortcodes)</a></label>
	</div>

	<h2 class="required">Output type</h2>
	<div class="body_type">
		<label><input type="radio" value="download" name="output_type" /><a href="#">Databse Entry (useful for tabled data)</a></label>
		<label><input type="radio" value="download" name="output_type" /><a href="#">Files: Generated Model, View, Controller files (useful for developers on design)</a></label>
		<label><input type="radio" value="html" name="parse_type" checked="checked" /><a href="#">Download (Useful for reporting and exports)</a></label>
	</div>

		
	<script type="text/javascript">
		// Replace the <textarea id="editor1"> with a CKEditor
		// instance, using default configuration.
		CKEDITOR.replace( 'ckeditor' );
	</script>
	
	<p class="pipeline">
		<a href="#" onclick="$(this).parents('form').submit();" class="process-button download-button hvr-grow">
			<span class="title-jux">Process</span>
			<span class="title-left">Shift</span><span class="title-right">Smith</span>
			<span class="title-jux">Pipeline</span>
		</a>
	</p>
</div>
</form>
</div>
</div>
</body>
[admin-footer.tpl]