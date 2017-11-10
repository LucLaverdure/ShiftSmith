<div class="adv-settings">
	<div class="display-options output-type radiobg">
		<div class="header-block">Output type</div>
		<div class="nextvisual">
			<div class="body_type">
				<div class="radiobg">
					<label><input type="radio" value="database" name="output_type" [page.outputDBCheck] />Database Entry (useful for tabled data), pick this option if you aren't sure.</label>
				</div>
				<div class="radiobg">
					<label><input type="radio" value="download" name="output_type" [page.outputFileCheck] />Files: Generated Model, View, Controller files (useful for developers on design)</label>
				</div>
				<div class="radiobg">
					<label><input type="radio" value="html" name="output_type" [page.outputDownloadCheck] />Download (Useful for reporting and exports)</label>
				</div>
				<div class="radiobg">
					<label><input type="radio" value="inject" name="output_type" [page.injectionCheck] />HTML Injection</label>
				</div>
			</div>
		</div>
	</div>
</div>