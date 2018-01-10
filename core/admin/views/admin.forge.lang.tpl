[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1>Forge - Languages</h1>
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

	<a href="/user">Administration</a> &gt; <a href="/core/admin/forge">Forge</a> &gt; Languages

	<form method="post" action="" enctype="multipart/form-data">

		<div class="descr">
			<p>Please enter language <strong>code</strong>, <strong>title</strong> and <strong>home url</strong>.</p>
		</div>
	
		<input type="hidden" value="true" name="posting" />
	
		<h2 class="header-block"></h2>
[for:lang.custom]
		<label class="field-head sub-header-block lang">
			<input class="custom head" type="text" value="[lang.custom.code]" name="lang.code[ ]" />
			<input class="custom mid" type="text" value="[lang.custom.title]" name="lang.title[ ]" />
			<a href="#" class="del-button">Delete</a>
			<input class="custom value" type="text" value="[lang.custom.url]" name="lang.url[ ]" />
		</label>
[end:lang.custom]

		<div id="template-custom-field" style="display:none;">
		<label class="field-head sub-header-block lang">
			<input class="custom head" type="text" value="" name="lang.code[ ]" />
			<input class="custom mid" type="text" value="" name="lang.title[ ]" />
			<a href="#" class="del-button">Delete</a>
			<input class="custom value" type="text" value="" name="lang.url[ ]" />
		</label>
		</div>

		<div id="template-placeholder">
		</div>

		<a href="#" class="button add-button-custom">Add Language</a>

		<a href="#" class="button save-button">Save Changes</a>
	
	</form>
	
</div>

<script type="text/javascript">

	var tags = [ ];
	var ids = [ ];

	$(document).on('click', '.del-button', function() {
		if ($(".lang:visible").length <= 1) {
			alert("Menu must have a minimum of 1 language.");
			return false; // minimum of one item
		}
		$(this).parent().remove();
		return false;
	});

	$('.page-tags div').each(function() {
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