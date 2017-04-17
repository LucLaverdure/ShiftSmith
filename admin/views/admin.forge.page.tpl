[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">

		<div class="wrapper-login cf">
			<h1>Forge - Page</h1>
[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
		</div>
</div>
[admin-panel.tpl]
<div class="wrapper">

	<a href="/user">Administration</a> &gt; <a href="/admin/forge">Forge</a> &gt; Page

	<form method="post" action="" enctype="multipart/form-data">
	
		<input type="hidden" name="item.id" value="[page.item.id]" />
	
		<label>
			<h2 class="header-block required"><span></span>Title</h2>
			<input id="forge-title" class="forge-title" type="text" value="[page.content.title]" name="content.title" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>URL of page</h2>
			<input id="forge-url" class="forge-url" type="text" value="[page.trigger.url]" name="trigger.url" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>HTML Editor for content</h2>
			<div class="body_type">
					<textarea id="ckeditor" name="content.body" >[page.content.body]</textarea>
			</div>
		</label>
		

		<label>
			<h2 class="header-block required"><span></span>Tags</h2>
			<select class="js-tags form-control" multiple="multiple" style="width:100%;" name="page.tags.name[]">
				[for:page.tags]
				<option selected="selected" value="[page.tags.name]">[page.tags.name]</option>
				[end:page.tags]
			</select>
		</label>
	
			
		<label>
			<h2 class="header-block"><span></span>Privacy</h2>
			<input id="forge-private" class="forge-private" type="checkbox" name="trigger.admin_only" value="Y" [page.trigger.admin_only] /> Make page private
		</label>

		<label class="field-head sub-header-block required">
			<h2 class="header-block">Publish date</h2>
			<input class="datepicker" type="text" value="[page.trigger.date]" name="trigger.date" />
		</label>
							
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


		<h2 class="header-block">Custom Fields</h2>
[for:page.custom]
		<label class="field-head sub-header-block">
			<input class="custom head" type="text" value="[page.custom.header]" name="custom.header[]" />
			<input class="custom value" type="text" value="[page.custom.value]" name="custom.value[]" />
		</label>
[end:page.custom]

		<div id="template-custom-field">
			<label class="field-head sub-header-block" style="display:none;">
				<input class="custom head" type="text" value="" name="custom.header[]" placeholder="Example: Notes" />
				<input class="custom value" type="text" value="" name="custom.value[]" placeholder="Example: Kittens everywhere!" />
			</label>
		</div>

		<div id="template-placeholder">
		</div>

		<a href="#" class="button add-button-custom">Add Custom Field</a>

		<a href="#" class="button save-button">Save Changes</a>
	
	</form>
	
</div>

[admin-footer.tpl]