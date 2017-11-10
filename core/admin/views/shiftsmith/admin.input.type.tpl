<div class="display-options">
	<div class="header-block">Input type</div>
		<div class="radiobg">
		<label>
			<input type="radio" name="action" [page.pagecheck] value="page" /> Create a Page.
			<span class="helper">&mdash; Will be accessible at the url defined below.</span>
		</label>
		</div>

		<div class="radiobg">
		<label>
			<input type="radio" name="action" [page.blogcheck] value="blog" /> Post blog entry.
			<span class="helper">&mdash; Will appear in the newsfeed</span>
		</label>
		</div>

		<div class="radiobg">
		<label>
			<input type="radio" name="action" [page.blockcheck] value="block" /> Create a block to display within a page.
			<span class="helper">&mdash; Content area within one or multiple pages.</span>
		</label>
		</div>

		<div class="radiobg">
		<label>
			<input type="radio" name="action" [page.downloadcheck] value="download" /> Add static downloadable files
			<span class="helper">&mdash; Files to index for search</span>
		</label>
		</div>
		<div class="adv-settings">
			<div class="radiobg">
			<label>
				<input type="radio" name="action" [page.fetchurlcheck] value="fetchurl" /> Fetch URL
			<span class="helper">&mdash; Download a page from the web and ouput the whole or part of it.</span>
			</label>
			</div>
			
			<div class="radiobg">
			<label>
				<input type="radio" name="action" [page.fetchurlcheck] value="crawl" /> Web Crawler
			<span class="helper">&mdash; Use a url crawler that will fetch all urls and import them into your site. </span>
			</label>
			</div>

			<div class="radiobg">
			<label>
				<input type="radio" name="action" [page.databasecheck] value="database" /> Migrate custom database to ShiftSmith.
			<span class="helper">&mdash; Import your database into ShiftSmith</span>
			</label>
			</div>
			
			<div class="radiobg">
			<label>
				<input type="radio" name="action" [page.wordpresscheck] value="wordpress" /> Migrate from Wordpress.
			<span class="helper">&mdash; Import your wordpress site into ShiftSmith</span>
			</label>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on('change', "[name='action']:checked", function() {
		var selected = $(this).val();
		switch (selected) {
			case 'blog':
					$('.title-area').slideDown();
					$('.date-area').slideDown();
					$('.description-area').slideDown();
					$('.tags-area').slideDown();
					$('.markup-select').slideDown();
					$('.js-tags').html('<option value="post" selected="selected">post</option>')
					$('.files-import').slideUp();
					$('.wp-select').slideUp();
					$('.trigers-area').slideDown();
					$('.db-select').slideUp();
					$('.trigers-area').slideDown();
					$('.url-fetch').slideUp();
					$('.output-type').slideDown();
					$('.forge-url-trigger[name=url]').val('*');
				break;
			case 'page':
					$('.title-area').slideDown();
					$('.date-area').slideDown();
					$('.description-area').slideDown();
					$('.tags-area').slideDown();
					$('.js-tags').html('<option value="page" selected="selected">page</option>')
					$('.markup-select').slideDown();
					$('.files-import').slideUp();
					$('.wp-select').slideUp();
					$('.trigers-area').slideDown();
					$('.db-select').slideUp();
					$('.trigers-area').slideDown();
					$('.url-fetch').slideUp();
					$('.output-type').slideDown();
				break;
			case 'block':
					$('.title-area').slideDown();
					$('.description-area').slideDown();
					$('.date-area').slideDown();
					$('.tags-area').slideDown();
					$('.js-tags').html('<option value="block" selected="selected">block</option>')
					$('.markup-select').slideDown();
					$('.files-import').slideUp();
					$('.wp-select').slideUp();
					$('.trigers-area').slideDown();
					$('.db-select').slideUp();
					$('.trigers-area').slideDown();
					$('.url-fetch').slideUp();
					$('.output-type').slideDown();
				break;
			case 'download':
					$('.title-area').slideUp();
					$('.description-area').slideUp();
					$('.date-area').slideUp();
					$('.tags-area').slideUp();
					$('.markup-select').slideUp();
					$('.files-import').slideDown();
					$('.wp-select').slideUp();
					$('.trigers-area').slideDown();
					$('.db-select').slideUp();
					$('.trigers-area').slideUp();
					$('.url-fetch').slideUp();
					$('.output-type').slideUp();
				break;
			case 'wordpress':
					$('.title-area').slideUp();
					$('.description-area').slideUp();
					$('.date-area').slideUp();
					$('.tags-area').slideUp();
					$('.markup-select').slideUp();
					$('.files-import').slideUp();
					$('.wp-select').slideDown();
					$('.trigers-area').slideUp();
					$('.db-select').slideUp();
					$('.trigers-area').slideUp();
					$('.url-fetch').slideUp();
					$('.output-type').slideDown();
				break;
			case 'database':
					$('.title-area').slideUp();
					$('.description-area').slideUp();
					$('.date-area').slideUp();
					$('.tags-area').slideUp();
					$('.markup-select').slideUp();
					$('.files-import').slideUp();
					$('.wp-select').slideUp();
					$('.trigers-area').slideUp();
					$('.db-select').slideDown();
					$('.trigers-area').slideUp();
					$('.url-fetch').slideUp();
					$('.output-type').slideDown();
				break;
			case 'fetchurl':
					$('.title-area').slideDown();
					$('.description-area').slideDown();
					$('.date-area').slideDown();
					$('.tags-area').slideDown();
					$('.markup-select').slideUp();
					$('.files-import').slideUp();
					$('.wp-select').slideUp();
					$('.trigers-area').slideUp();
					$('.db-select').slideUp();
					$('.trigers-area').slideUp();
					$('.url-fetch').slideDown();
					$('.output-type').slideDown();
				break;
			case 'crawl':
					$('.title-area').slideUp();
					$('.description-area').slideUp();
					$('.date-area').slideUp();
					$('.tags-area').slideUp();
					$('.markup-select').slideUp();
					$('.files-import').slideUp();
					$('.wp-select').slideUp();
					$('.trigers-area').slideUp();
					$('.db-select').slideUp();
					$('.trigers-area').slideUp();
					$('.url-fetch').slideDown();
					$('.output-type').slideDown();
				break;
		}
	});
</script>