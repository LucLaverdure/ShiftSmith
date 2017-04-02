[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">

		<div class="wrapper-login cf">
			<h1>Forge - Form</h1>
[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
		</div>
</div>
<!-- [admin-panel.tpl] -->
<div class="wrapper">

	<a href="/user">Administration</a> &gt; <a href="/admin/forge">Forge</a> &gt; Form

	<form method="post" action="" enctype="multipart/form-data">
	
		<label>
			<h2 class="header-block required"><span></span>URL of item</h2>
			<input id="forge-url" class="forge-url" type="text" value="[page.url]" placeholder="/giants" name="url" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>Tags</h2>
			<select class="js-tags form-control" multiple="multiple" style="width:100%;" name="tagsDisplay[]">
				[for:tags]
				<option selected="selected" value="[tags.name]">[tags.name]</option>
				[end:tags]
			</select>
		</label>
	
		<label class="privacy-wrap">
			<h2 class="header-block required"><span></span>Privacy</h2>
			<input id="forge-private" class="forge-private" type="checkbox" name="private" value="Y" [page.privatecheck] /> Make form private
		</label>

		<label class="field-head sub-header-block required">
			<h2 class="header-block">Publish date</h2>
			<input class="datepicker" type="text" value="[page.date]" name="date" />
		</label>
	
		<div class="field-sample" style="display:none;">
			<div class="input-col">
				<div class="field-head">
					<label class="field-head sub-header-block required">
						<h2 class="header-block">Field Name</h2>
						<input class="fieldname" type="text" value="[page.fieldname]" name="fieldname[]" />
					</label>
				</div>
			</div>
			<div class="input-col2">
				<div class="field-val">
					<label class="field-head sub-header-block required">
						<h2 class="header-block">Value Type</h2>
						<select name="field_type[]" class="field_type">
							<option value="textbox">textbox</option>
							<option value="textarea">textarea</option>
							<option value="checkbox">checkbox</option>
						</select>
					</label>
				</div>
			</div>
		</div>
		
		<div class="rowoutput">
		</div>
		
		<a href="#" class="button add-new">Add new Form Field</a>
		
<script type="text/javascript">

$(document).on('click', '.add-new', function() {
	$('.rowoutput').append($('.field-sample').clone().fadeIn().attr('class',''));
	return false;
});

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


		<a href="#" class="button save-button">Save Changes</a>
	
	</form>
	
</div>

[admin-footer.tpl]