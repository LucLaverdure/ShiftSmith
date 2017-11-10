
<!-- File(s) -->						
						<div class="header-block">Upload File(s) (*.csv, *.pdf, *.txt, *.doc, *.docx)</div>
						<div class="radiobg">
							<span class="helper">Index the uploaded file(s) as a searchable document.</span>
							<div class="file-select" style="">
								<input type="file" name="file[]" multiple="multiple" class="files-upload"
								accept=".gif,.jpg,.jpeg,.png,.doc,.docx,.pdf" />
								<div class="files-selected"></div>
							</div>
						</div>
<script type="text/javascript">
	$(".files-upload").change(function(e) {

		var f = e.target.files,
            len = f.length,
			files = '';
        for (var i=0;i<len;i++) {
			if (typeof(f[i].name) != 'undefined') {
				files += f[i].name + '<br/>';
			} else if (typeof(f[i].filename) != 'undefined') {
				files += f[i].filename + '<br/>';
			}
        }

		$('.files-selected').html(files);
	});
</script>