<div class="tags-area">

			<div class="radiobg">
					<div class="nextvisual" style="">
						<label>
<!-- Tags -->
							<h2 class="header-block required">Tags</h2>
							<span class="helper">Users and administrators can filter their searched results based on tags. "Page" is the default tag. Example tags: "page", "post", "project", "news"</span>
						</label>
						<select class="js-tags form-control" multiple="multiple" style="width:100%;" name="tagsDisplay[]">
							[for:tags]
							<option selected="selected" value="[tags.name]">[tags.name]</option>
							[end:tags]
						</select>
					</div>
	
					<script type="text/javascript">
					var select2 = $(".js-tags");

					select2.on("select2:open", function (e) { 
						if ($('.advancedDisplay').is(':checked')) {
							$(".triggers").parents('.nextvisual').show('drop');
						} else {
							$(".input-type").parents('.nextvisual').show('drop');
						}
					});

					$('.js-tags').select2({tags: true, tokenSeparators: [',', ' ']});
					</script>
			</div>
</div>