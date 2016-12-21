
	<div class="adv-settings">
		<div class="nextvisual" style="">
			<span class="helper">Parse document for admin shortcodes with admin input or deny shortcodes as they come from a third party.</span>
			<h2 class="required">Parse Type</h2>
			<div class="body_type">
				<label><input type="radio" value="admin" name="parse_type" [page.adminInputCheck] /><a href="#">Admin Input (Allow shortcodes)</a></label>
				<label><input type="radio" value="html" name="parse_type" [page.thirdPartyCheck] /><a href="#">Third Party Input (Disable Shortcodes)</a></label>
			</div>
		</div>

	</div>
