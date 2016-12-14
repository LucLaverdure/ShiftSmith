[admin-header.tpl]
<body class="shiftsmith">

	<div style="" class="cf">
	
		<div style="max-width:1024px;width:100%;margin:100px auto;" class="cf">
		
		<form method="post" action="">
<div class="admin-panel">

	<h1 class="create" style="font-weight:800;"><img src="/admin/files/img/ico/forge.png" title="Forge" />
	<span class="title-left">Shift</span><span class="title-right">Smith</span>
	</h1>

	<label><input type="checkbox" class="helpio" name="helpio" checked="checked" />Display Help</label>
	<label><input type="checkbox" class="advancedDisplay" name="advancedDisplay" />Advanced Settings</label>
	
	<p>
	<label>
		<h2 class="header-block required">Title</h2>
		<span class="helper">Input the title of this item. For example: "My first page". Minimum of three characters</span>
		<input class="forge-title" type="text" value="" placeholder="My first page" name="title" />
	</label>
	</p>
	
	<div class="nextvisual" style="display:none;">
	<label>
		<h2 class="header-block required">Short Description</h2>
		<span class="helper">Input the short description of this item. For example: "Wicked page about animals".</span>
		<input class="forge-title" type="text" value="" placeholder="Wicked page about animals" name="description" />
	</label>
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
			$(document).on('change', 'input.forge-title[name=title]', function() {
				$('.forge-url-trigger[name=url]').val(cleanurl($(this).val()));
			});
		});
	</script>

	<div class="nextvisual" style="display:none;">
	<label>
		<h2 class="header-block required">Tags</h2>
		<span class="helper">Users and administrators can filter their searched results based on tags. "Page" is the default tag. Example tags: "page", "post", "project", "news"</span>
	</label>
	<select class="js-tags form-control" multiple="multiple" style="width:100%;" name="tagsDisplay">
		<option selected="selected" value="page">page</option>
	</select>
	</div>
	
<script type="text/javascript">
var select2 = $(".js-tags");

select2.on("select2:open", function (e) { 
	if ($('.advancedDisplay').is(':checked')) {
		$(".triggers").parents('.nextvisual').show('drop');
	} else {
		$(".input-type").parents('.nextvisual').show('drop');
	}
});

$('.js-tags').select2({tags: true, tokenSeparators: [',', ' ']});
</script>

<div class="adv-settings" style="display:none;">

<div class="nextvisual" style="display:none;">
	<h2 class="header-block triggers">Triggers</h2>
	<span class="helper">For the item to display/execute, the following triggers must validate.</span>

	<p>
	<label class="field-head sub-header-block required">Publish date </label>
	<span class="helper">You can set a future date for the content to display. By default, the post will be published as soon as the entry is saved.</span>
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
	<span class="helper">Input a url or url pattern, "/" for homepage, "/project-x*" for all pages starting with "/project-x"</span>
	<input class="forge-url-trigger" type="text" value="" placeholder="/" name="url" />
	</p>

	<p>
	<label class="sub-header-block">Private page</label>
	<span class="helper">By checking the box below, only administrators will be able to view the content. You can use this attribute to preview pages before they get published.</span>
	<input type="checkbox" name="loggedasadmin" />Require admin to be logged in.
	</p>
</div>
</div>

<div class="nextvisual" style="display:none;">
	<h2 class="required input-type">Input Type</h2>
	<span class="helper">Time to define the content.</span>
	<div class="body_type">
		<span class="helper">Provide HTML, for a page. A toolbar will help you create images, font styles and much more. For example: "Hello world!"</span>
		<label><input type="radio" value="markup" name="body_type" checked="checked" /><a href="#">Provide HTML (HTML Editor)</a></label>
		<div class="markup-select">
			<textarea id="ckeditor" name="ckeditor" placeholder=""></textarea>
			
<script type="text/javascript">

// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.
$(function() {
CKEDITOR.replace( 'ckeditor' );
CKEDITOR.instances.ckeditor.on('contentDom', function() {
          CKEDITOR.instances.ckeditor.document.on('keydown', function(event) {
			 var str = CKEDITOR.instances.ckeditor.getData();
			 if (str.length > 5) {
				 $('.pipeline a').show('drop');
			 }
			  
		  });
});
});
</script>			
		</div>
<div class="adv-settings" style="display:none;">
	
		<span class="helper">This will download the contents of the web file from a specific URL.</span>
		<label class="header-block"><input type="radio" value="url" name="body_type" /><a href="#">Fetch Markup From Web URL</a></label>
		
		<div class="url-select" style="display:none;">
			<label class="sub-header-block required">Input URL</label>
			<span class="helper">Input a url, for example http://luclaverdure.com</span>
			<p><input type="text" value="" placeholder="http://luclaverdure.com" class="forge-url-trigger" /></p>
			
			<label class="sub-header-block required">Selector</label>
			<span class="helper">Input a css selector. For example "html body" to fetch the entire body of the page. <a href="http://www.w3schools.com/cssref/css_selectors.asp">click here</a> to learn about selectors</span>
			<p><input type="text" value="" placeholder="html body" class="forge-url-trigger" /></p>
		</div>

		<span class="helper">Fetch information from a database. This content is to either import data from a database to ShiftSmith or to select data from ShiftSmith's database.</span>
		<label><input type="radio" value="db" name="body_type" /><a href="#">Database</a></label>
		<div class="db-select" style="display:none;">
			<div>
				<h3 class="sub-header-block">Database Hostname:</h3>
				<span class="helper">Provide the hostname of the database, for example: "localhost". Leave the field blank to select the database in use by shiftsmith.</span>
				<input type="text" value="" placeholder="localhost" class="forge-url-trigger" />
				<h3 class="sub-header-block">Database User:</h3>
				<span class="helper">Provide the user connecting to the database, for example: "admin". Leave the field blank to select the user connected to shiftsmith's database.</span>
				<input type="text" value="" placeholder="user" class="forge-url-trigger" />
				<h3 class="sub-header-block">Database Password:</h3>
				<span class="helper">Provide the password of the database, for example: "admin123". Leave the field blank to select the password connected to shiftsmith's database.</span>
				<input type="password" value="" placeholder="password" class="forge-url-trigger" />
				<h3 class="sub-header-block">Database Name:</h3>
				<span class="helper">Make an SQL query to get input data.</span>
				<span class="error">(SQL Builder for business users coming soon!)</span>
				<input type="text" value="" placeholder="db_data" class="forge-url-trigger" />
				<h3 class="sub-header-block">Database SQL:</h3>
				<input type="text" value="" placeholder="SELECT * FROM users" class="forge-url-trigger" />
			</div>
		</div>

		<label><input type="radio" value="file" name="body_type" /><a href="#">Upload File(s) (*.csv, *.pdf, *.txt, *.doc, *.docx)</a></label>
		<span class="helper">Index the uploaded file(s) as a searchable document.</span>
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
		<span class="helper">Migrate a Drupal Project to ShiftSmith (Coming soon!)</span>
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

		<span class="helper">Migrate a Wordpress Project to ShiftSmith (Coming soon!)</span>
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
	</div>
</div>
	<div class="adv-settings" style="display:none;">
		<div class="nextvisual" style="display:none;">
			<span class="helper">If content is fetched from a third party (By URL, by database or by migration from Drupal or Wordpress</span>
			<h2 class="required">Fetch Method</h2>
			<div class="body_type">
				<label><input type="radio" value="html" name="fetch_type" checked="checked" /><a href="#">Fetch once and cache data (faster, but requires maintenance)</a></label>
				<label><input type="radio" value="admin" name="fetch_type" /><a href="#">Fetch live data (slower, but requires no maintenance)</a></label>
			</div>
		</div>
	</div>
	
	<div class="adv-settings" style="display:none;">

		<div class="nextvisual" style="display:none;">
			<span class="helper">Parse document for admin shortcodes with admin input or deny shortcodes as they come from a third party.</span>
			<h2 class="required">Parse Type</h2>
			<div class="body_type">
				<label><input type="radio" value="admin" name="parse_type" checked="checked" /><a href="#">Admin Input (Allow shortcodes)</a></label>
				<label><input type="radio" value="html" name="parse_type" checked="checked" /><a href="#">Third Party Input (Disable Shortcodes)</a></label>
		</div>
	</div>

	</div>

	<div class="adv-settings" style="display:none;">

	<div class="nextvisual" style="display:none;">
		<span class="helper">Define access entry.</span>
		<h2 class="required">Output type</h2>
		<div class="body_type">
			<span class="helper">A generic admin controller will verify the triggers from the database and if content validates, content will render.</span>
			<label><input type="radio" value="download" name="output_type" checked="checked" /><a href="#">Database Entry (useful for tabled data)</a></label>
			<span class="helper">A generated custom admin controller will verify the triggers from files and if content validates, content will render.</span>
			<label><input type="radio" value="download" name="output_type" /><a href="#">Files: Generated Model, View, Controller files (useful for developers on design)</a></label>
			<span class="helper">By accessing this content, a forced download of results will be executed if content validates.</span>
			<label><input type="radio" value="html" name="parse_type" /><a href="#">Download (Useful for reporting and exports)</a></label>
		</div>

	</div>
</div>	
	<p class="pipeline">
		<a href="#" onclick="$(this).parents('form').submit();" class="process-button download-button hvr-grow" style="display:none;">
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

	<script type="text/javascript">
		$('.helpio').change(function() {
			if ($(this).is(':checked'))
				$('.helper').slideDown();
			else
				$('.helper').slideUp();
		});
		
		$('.advancedDisplay').change(function() {
			if ($(this).is(':checked'))
				$('.adv-settings').slideDown();
			else
				$('.adv-settings').slideUp();
		});
		
		var index_slider = 1;
		$(document).on('click mouseup keyup cut paste copy', ".forge-title[name='title']", function(evt) {			
			if ($(this).val().length >= 3 && index_slider == 1) {
				$(".forge-title[name='description']").parents('.nextvisual').show('drop');
				index_slider++;
			}
		});

		$(document).on('click mouseup keyup cut paste copy', ".forge-title[name='description']", function(evt) {			
			if ($(this).val().length >= 3 && index_slider == 2) {
				$(".js-tags").parents('.nextvisual').show('drop');
				index_slider++;
			}
		});



		
	</script>


[admin-footer.tpl]