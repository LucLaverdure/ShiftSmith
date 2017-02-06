[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">

		<div class="wrapper-login cf">
			<h2>Forge - Page</h2>
[if:'[prompt.message]' != '']
			<div class="message">[prompt.message]</div>
[endif]

[if:'[prompt.error]' != '']
			<div class="error">[prompt.error]</div>
[endif]
		</div>
</div>
<!-- [admin-panel.tpl] -->
<div class="wrapper cf">

	<a href="/user">Administration</a> &gt; <a href="/admin/forge">Forge</a> &gt; Sale

	<form method="post" action="" enctype="multipart/form-data">
	
		<label>
			<h2 class="header-block required"><span></span>Title</h2>
			<input id="forge-title" class="forge-title" type="text" value="[page.title]" placeholder="A giant rock!" name="title" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>URL of item</h2>
			<input id="forge-url" class="forge-url" type="text" value="[page.url]" placeholder="/giants" name="url" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>HTML Editor for content</h2>
			<div class="body_type">
					<textarea id="ckeditor" name="body" placeholder="Write the most details you can about the item for sale here.">[page.body]</textarea>
			</div>
		</label>
		

		<label>
			<h2 class="header-block required"><span></span>Tags</h2>
			<select class="js-tags form-control" multiple="multiple" style="width:100%;" name="tagsDisplay[]">
				[for:tags]
				<option selected="selected" value="[tags.name]">[tags.name]</option>
				[end:tags]
			</select>
		</label>

		<div class="input-col">
			<label class="field-head sub-header-block required">
				<h2 class="header-block">Publish date</h2>
				<input class="datepicker" type="text" value="[page.date]" name="date" />
			</label>

			<label class="field-head sub-header-block required">
				<h2 class="header-block">On Sale Until</h2>
				<input class="datepicker" type="text" value="[page.onsaleuntil]" name="onsaleuntil" />
			</label>
				

			<label class="field-head sub-header-block required">
				<h2 class="header-block">Inventory Count</h2>
				<input class="inventory" type="text" value="[page.inventory]" name="inventory" />
			</label>
		</div>
		
		<div class="input-col2">
			<label class="field-head sub-header-block required">
				<h2 class="header-block">Regular Price</h2>
				<input class="price" type="text" value="[page.price]" name="price" />
			</label>

			<label class="field-head sub-header-block required">
				<h2 class="header-block">On Sale Price</h2>
				<input class="saleprice" type="text" value="[page.saleprice]" name="saleprice" />
			</label>
			
			<script type="text/javascript">
				$(".price").maskMoney();
				$(".saleprice").maskMoney();
			</script>		

			<label class="field-head sub-header-block required">
				<h2 class="header-block">Currency</h2>
				<select class="currency" name="currency">
					<option value="CA$" selected="selected">CA$</option>
					<option value="US$">US$</option>
				</select>
			</label>

		</div>

		<div class="input-col">
			<label>
				<h2 class="header-block required"><span></span>Privacy</h2>
				<input id="forge-private" class="forge-private" type="checkbox" name="private" value="Y" [page.privatecheck] /> Make item private
			</label>
		</div>
		
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


		<a href="#" class="button save-button">Save Changes</a>
	
	</form>
	
</div>

[admin-footer.tpl]