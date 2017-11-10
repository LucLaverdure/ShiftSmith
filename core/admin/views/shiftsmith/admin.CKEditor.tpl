<div class="markup-select">

	<div class="nextvisual" style="">
		<span class="header-block">HTML Editor content</span>
		<div class="body_type">
				<textarea id="ckeditor" name="body" placeholder="Write your story here.">[page.body]</textarea>
		</div>
	</div>

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
