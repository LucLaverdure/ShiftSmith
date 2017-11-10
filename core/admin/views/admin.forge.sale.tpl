[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1>Forge - Sale</h1>
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

	<a href="/user">Administration</a> &gt; <a href="/core/admin/forge">Forge</a> &gt; Sale

	<form method="post" action="" enctype="multipart/form-data">
	
		<input type="hidden" name="item.id" value="[sale.item.id]" />
	
		<label>
			<h2 class="header-block required"><span></span>Title</h2>
			<input id="forge-title" class="forge-title required" type="text" value="[sale.content.title]" name="content.title" title="Title" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>URL of sale</h2>
			<input id="forge-url" class="forge-url required" type="text" value="[sale.trigger.url]" name="trigger.url" title="Url"/>
		</label>
	
		<label>
			<h2 class="header-block required"><span></span>HTML Editor for content</h2>
			<div class="body_type">
					<textarea id="ckeditor" name="content.body" >[sale.content.body]</textarea>
			</div>
		</label>
		

		<label>
			<h2 class="header-block required"><span></span>Tags</h2>
			<select class="js-tags form-control required" multiple="multiple" style="width:100%;" name="tags.name[ ]" title="Tags">
			</select>
			<div class="sale-tags" style="display:none;">
			[for:sale.tags]
				<div>[sale.tags.name]</div>
			[end:sale.tags]
			</div>
		</label>
			
		<label>
			<h2 class="header-block"><span></span>Privacy</h2>
			<input id="forge-private" class="chktype forge-private" type="checkbox" name="trigger.private" value="Y" data-val="[sale.trigger.private]" /> Make sale private
		</label>
		<script type="text/javascript">
			$('.chktype:visible').each(function() {
				$this = $(this);
				if ($this.val() == $this.attr('data-val')) {
					$this.prop('checked', true);
				};
			});
		</script>

	<div class="cf">
		<div class="input-col">
			<label class="field-head sub-header-block required">
				<h2 class="header-block">Publish date</h2>
				<input class="datepicker" type="text" value="[sale.item.date]" name="item.date" />
			</label>

			<label class="field-head sub-header-block required">
				<h2 class="header-block">On Sale Until</h2>
				<input class="datepicker" type="text" value="[sale.item.onsaleuntil]" name="item.onsaleuntil" />
			</label>
				

			<label class="field-head sub-header-block required">
				<h2 class="header-block">Inventory Count</h2>
				<input class="inventory required" type="text" value="[sale.item.inventory]" name="item.inventory" title="Inventory Count" />
			</label>
		</div>
		
		<div class="input-col2">
			<label class="field-head sub-header-block required">
				<h2 class="header-block">Regular Price</h2>
				<input class="price required" type="text" value="[sale.item.price]" name="item.price" title="Price" />
			</label>

			<label class="field-head sub-header-block required">
				<h2 class="header-block">On Sale Price</h2>
				<input class="saleprice" type="text" value="[sale.item.saleprice]" name="item.saleprice" />
			</label>
			
			<script type="text/javascript">
				$(".price").maskMoney();
				$(".saleprice").maskMoney();
			</script>		

			<label class="field-head sub-header-block required">
				<h2 class="header-block">Currency</h2>
				<select class="currency" name="item.currency">
					<option value="CA$" selected="selected">CA$</option>
					<option value="US$">US$</option>
				</select>
			</label>

		</div>
	</div>
							
		<h2 class="header-block">Custom Fields</h2>
[for:sale.custom]
		<label class="field-head sub-header-block">
			<input class="custom head" type="text" value="[sale.custom.header]" name="custom.header[ ]" />
			<a href="#" class="del-button">Delete</a>
			<input class="custom value" type="text" value="[sale.custom.value]" name="custom.value[ ]" />
		</label>
[end:sale.custom]

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

	$('.sale-tags div').each(function() {
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