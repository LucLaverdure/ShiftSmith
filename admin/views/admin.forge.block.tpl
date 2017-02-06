[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/admin/files/img/login-bg.png">

		<div class="wrapper-login cf">
			<h2>Forge - Block</h2>
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

	<a href="/user">Administration</a> &gt; <a href="/admin/forge">Forge</a> &gt; Block

	<form method="post" action="" enctype="multipart/form-data">
	
		<label>
			<h2 class="header-block required"><span></span>Title</h2>
			<input id="forge-title" class="forge-title" type="text" value="[page.title]" placeholder="I love cats" name="title" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>Shortcode Trigger</h2>
			<input id="forge-shortcode" class="forge-shortcode" type="text" value="[page.shortcode]" placeholder="[crazycatlady]" name="shortcode" />
		</label>

		<label>
			<h2 class="header-block required"><span></span>HTML Editor for content</h2>
			<div class="body_type">
					<textarea id="ckeditor" name="body" placeholder="Write your story here.">[page.body]</textarea>
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
	
			
		<label>
			<h2 class="header-block required"><span></span>Privacy</h2>
			<input id="forge-private" class="forge-private" type="checkbox" name="private" value="Y" [page.privatecheck] /> Make Block private
		</label>

		<label class="field-head sub-header-block required">
			<h2 class="header-block">Publish date</h2>
			<input class="datepicker" type="text" value="[page.date]" name="date" />
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


		<a href="#" class="button save-button">Save Changes</a>
	
	</form>
	
</div>

[admin-footer.tpl]