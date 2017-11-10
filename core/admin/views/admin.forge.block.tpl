[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1>Forge - Block</h1>
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

	<a href="/user">Administration</a> &gt; <a href="/core/admin/forge">Forge</a> &gt; Block

	<form method="post" action="" enctype="multipart/form-data">
	
		<input type="hidden" name="item.id" value="[block.item.id]" />
	
		<label>
			<h2 class="header-block required"><span></span>Title</h2>
			<input id="forge-title" class="forge-title required" type="text" value="[block.content.title]" name="content.title" title="Title" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>URL of block</h2>
			<input id="forge-url" class="forge-url required" type="text" value="[block.trigger.url]" name="trigger.url" title="URL" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>Shortcode Trigger</h2>
			<input id="forge-url" class="forge-url required" type="text" value="[block.trigger.shortcode]" name="trigger.shortcode" title="Shortcode" />
		</label>
		
		<label>
			<h2 class="header-block required"><span></span>HTML Editor for content</h2>
			<div class="body_type">
					<textarea id="ckeditor" name="content.body" >[block.content.body]</textarea>
			</div>
		</label>
		

		<label>
			<h2 class="header-block required"><span></span>Tags</h2>
			<select class="js-tags form-control required" multiple="multiple" style="width:100%;" name="tags.name[ ]" title="Tags">
			</select>
			<div class="block-tags" style="display:none;">
			[for:block.tags]
				<div>[block.tags.name]</div>
			[end:block.tags]
			</div>
		</label>
			
		<label>
			<h2 class="header-block"><span></span>Privacy</h2>
			<input id="forge-private" class="chktype forge-private" type="checkbox" name="trigger.private" value="Y" data-val="[block.trigger.private]" /> Make block private
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
			<input class="datepicker" type="text" value="[block.trigger.date]" name="trigger.date" />
		</label>
							
		<h2 class="header-block">Custom Fields</h2>
[for:block.custom]
		<label class="field-head sub-header-block">
			<input class="custom head" type="text" value="[block.custom.header]" name="custom.header[ ]" />
			<a href="#" class="del-button">Delete</a>
			<input class="custom value" type="text" value="[block.custom.value]" name="custom.value[ ]" />
		</label>
[end:block.custom]

		<div id="template-custom-field">
			<label class="field-head sub-header-block" style="display:none;">
				<input class="custom head" type="text" value="" name="custom.header[ ]" />
				<a href="#" class="del-button">Delete</a>
				<input class="custom value" type="text" value="" name="custom.value[ ]" />
			</label>
		</div>

		<div id="template-placeholder">
		</div>

		<a href="#" class="button add-button-custom">Add Custom Field</a>

		<a href="#" class="button save-button">Save Changes</a>
	
	</form>
	
</div>

<script type="text/javascript">

	var tags = [ ];
	var ids = [ ];

	$(document).on('click', '.del-button', function() {
		$(this).parent().remove();
		return false;
	});

	$('.block-tags div').each(function() {
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