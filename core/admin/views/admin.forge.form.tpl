[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1>Forge - Form</h1>
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

	<a href="/user">Administration</a> &gt; <a href="/core/admin/forge">Forge</a> &gt; Form

	<form method="post" action="" enctype="multipart/form-data">
	
		<input type="hidden" name="item.id" value="[form.item.id]" />
	
		<label>
			<h2 class="header-block required"><span></span>Title</h2>
			<input id="forge-title" class="forge-title required" type="text" value="[form.content.title]" name="content.title" title="Title"/>
		</label>

		<label>
			<h2 class="header-block required"><span></span>URL of form</h2>
			<input id="forge-url" class="forge-url required" type="text" value="[form.trigger.url]" name="trigger.url" title="Url" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>Shortcode Trigger</h2>
			<input id="forge-url" class="forge-url required" type="text" value="[form.trigger.shortcode]" name="trigger.shortcode" title="Shortcode" />
		</label>
		
		<label>
			<h2 class="header-block required"><span></span>HTML Editor for content</h2>
			<div class="body_type">
					<textarea id="ckeditor" name="content.body" >[form.content.body]</textarea>
			</div>
		</label>
		

		<label>
			<h2 class="header-block required"><span></span>Tags</h2>
			<select class="js-tags required form-control" multiple="multiple" style="width:100%;" name="tags.name[ ]" title="Tags">
			</select>
			<div class="form-tags" style="display:none;">
			[for:form.tags]
				<div>[form.tags.name]</div>
			[end:form.tags]
			</div>
		</label>
			
		<label>
			<h2 class="header-block"><span></span>Privacy</h2>
			<input id="forge-private" class="chktype forge-private" type="checkbox" name="trigger.private" value="Y" data-val="[form.trigger.private]" /> Make form private
		</label>
		<script type="text/javascript">
			$('.chktype:visible').each(function() {
				$this = $(this);
				if ($this.val() == $this.attr('data-val')) {
					$this.prop('checked', true);
				};
			});
		</script>


		<label class="field-head sub-header-block required">
			<h2 class="header-block">Publish date</h2>
			<input class="datepicker" type="text" value="[form.trigger.date]" name="trigger.date" />
		</label>

<!-- FORM STARTS HERE -->
		<h2 class="header-block">Form Fields</h2>
[for:form.fields]
		<label class="field-head sub-header-block">
			<input class="frmhead value required" type="text" value="[form.fields.head]" name="fields.head[ ]" title="Form Fields" />

			<select name="fields.ctype[ ]" class="frmtype custom head field-type" data-val="[form.fields.ctype]">
				<option value="label">label</option>
				<option value="textbox">textbox</option>
				<option value="textarea">textarea</option>
				<option value="checkbox">checkbox</option>
			</select>

			<a href="#" class="del-button">Delete</a>
			<input class="frmval custom value required" type="text" value="[form.fields.value]" name="fields.value[ ]" title="Form Fields" />
		</label>
[end:form.fields]

		<div id="template-placeholder-form">
		</div>

		<script type="text/javascript">
			$('.frmtype:visible').each(function() {
				$this = $(this);
				$this.val($this.attr('data-val'));
			});
		</script>
		<div class="add-button-wrapper">
			<a href="#" class="button add-button-form">Add Form Field</a>
		</div>
		
<!-- FORM ENDS HERE -->
		
<!-- CUSTOM STARTS HERE -->
		<h2 class="header-block">Custom Fields</h2>
[for:form.custom]
		<label class="field-head sub-header-block">
			<input class="custom head" type="text" value="[form.custom.header]" name="custom.header[ ]" />
			<a href="#" class="del-button">Delete</a>
			<input class="custom value" type="text" value="[form.custom.value]" name="custom.value[ ]" />
		</label>
[end:form.custom]

	
		<div id="template-placeholder-custom">
		</div>

		<a href="#" class="button add-button-custom">Add Custom Field</a>

<!-- CUSTOM ENDS HERE -->

		<a href="#" class="button save-button">Save Changes</a>
	
	</form>
	

		<div id="template-form-field">
			<label class="field-head sub-header-block" style="display:none;">
				<input class="frmhead value required" type="text" value="" name="fields.head[ ]" title="Form Fields" />

				<select name="fields.ctype[ ]" class="frmtype custom head field-type">
					<option value="label">label</option>
					<option value="textbox">textbox</option>
					<option value="textarea">textarea</option>
					<option value="checkbox">checkbox</option>
				</select>

				<a href="#" class="del-button">Delete</a>
				<input class="frmval custom value required" type="text" value="" name="fields.value[ ]" title="Form Fields" />
			</label>

		</div>

		<div id="template-custom-field">
			<label class="field-head sub-header-block" style="display:none;">
				<input class="custom head" type="text" value="" name="custom.header[ ]" />
				<a href="#" class="del-button">Delete</a>
				<input class="custom value" type="text" value="" name="custom.value[ ]" />
			</label>
		</div>

</div>

<script type="text/javascript">

	$(document).on('click', '.add-button-custom', function() {
		$('#template-placeholder-custom').append($('#template-custom-field label').clone().fadeIn());
		return false;
	});

	$(document).on('click', '.add-button-form', function() {
		$('#template-placeholder-form').append($('#template-form-field label').clone().fadeIn());
		return false;
	});
	
	var tags = [ ];
	var ids = [ ];

	$(document).on('click', '.del-button', function() {
		$(this).parent().remove();
		return false;
	});

	$('.form-tags div').each(function() {
		var $this = $(this);
		tags.push({id: $this.html(), text: $this.html()});
		ids.push($this.html());
	});

	$('.js-tags').select2({
		tags: true,
		tokenSeparators: [',', ' ', ';'],
		data: tags
	});

	$('.js-tags').val(ids);
	
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
	if ($('.datepicker').val()=='') {
		$('.datepicker').val(today);
	}
</script>

[admin-footer.tpl]