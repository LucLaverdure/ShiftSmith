[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
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

	<a href="/user">Administration</a> &gt; <a href="/core/admin/forge">Forge</a> &gt; CSV Import

	<form method="post" action="" enctype="multipart/form-data">
	
		<input type="hidden" name="item.posted" value="Y" />
	
		<label>
			<h2 class="header-block required"><span></span>CSV File to Import</h2>
			<input type="file" name="csvfile" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>Row delimiter</h2>
			<input class="forge-url required" type="text" value="[csv.params.rowdelimiter]" name="params.rowdelimiter" title="Row Delimiter"/>
		</label>

		<label>
			<h2 class="header-block required"><span></span>Column Delimiter</h2>
			<input class="forge-url required" type="text" value="[csv.params.coldelimiter]" name="params.coldelimiter" title="Column Delimiter"/>
		</label>

		<label>
			<h2 class="header-block required"><span></span>Array Delimiter</h2>
			<input class="forge-url required" type="text" value="[csv.params.arraydelimiter]" name="params.arraydelimiter" title="Array Delimiter"/>
		</label>

			<h2 class="header-block required"><span></span>Data Mode</h2>
		<p>
		<label>
			<input type="radio" name="params.datamode" value="append" class="chktype" data-val="[csv.params.datamode]"> Add all data in addition to existing data
		</label>
		</p>
		<p>
		<label>
			<input type="radio" name="params.datamode" value="update" class="chktype" data-val="[csv.params.datamode]"> When data already exists, replace it
		</label>
		</p>
		<p>
		<label>
			<input type="radio" name="params.datamode" value="skip" class="chktype" data-val="[csv.params.datamode]"> When data already exists, skip it
		</label>
		</p>

		<a href="#" class="button save-button">Import CSV</a>
	
	</form>
	
</div>
<script type="text/javascript">
	$('.chktype:visible').each(function() {
		$this = $(this);
		if ($this.attr('value') == $this.attr('data-val')) {
			$this.prop('checked', true);
		};
	});
</script>
<script type="text/javascript">

	var tags = [ ];
	var ids = [ ];

	$(document).on('click', '.del-button', function() {
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