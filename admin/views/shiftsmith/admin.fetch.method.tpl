	<div class="adv-settings" style="">
		<div class="nextvisual" style="">
			<span class="helper">If content is fetched from a third party (By URL, by database or by migration from Drupal or Wordpress</span>
			<h2 class="required">Fetch Method</h2>
			<div class="body_type">
				<label><input type="radio" value="html" name="fetch_type" [page.fetchOnceCheck] /><a href="#">Fetch once and cache data (faster, but requires maintenance)</a></label>
				<label><input type="radio" value="admin" name="fetch_type" [page.fetchLiveCheck] /><a href="#">Fetch live data (slower, but requires no maintenance)</a></label>
			</div>
		</div>
	</div>
