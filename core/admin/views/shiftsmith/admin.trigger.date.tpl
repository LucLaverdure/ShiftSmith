<div class="date-area">
<!-- Date -->
<label class="field-head sub-header-block required">Publish date
	<span class="helper" style="background:transparent;color:#fff;font-size:0.9em;">You can set a future date for the content to display. By default, the post will be published as soon as the entry is saved.</span>
	<input class="forge-url-trigger datepicker" type="text" value="[page.date]" placeholder="/" name="date" />
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

</div>