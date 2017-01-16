[admin-header.tpl]
<body class="shiftsmith">

	<form method="post" action="" enctype="multipart/form-data">
	
	<div style="" class="cf">
	
		<div style="max-width:1024px;width:100%;margin:100px auto;" class="cf">
		
				<div class="admin-panel">

					<!-- Title Of Page (Not input)-->
					<h1 class="create" style="font-weight:800;">
						<img src="/admin/files/img/ico/forge.png" title="Forge" />
						<span class="title-left">Shift</span><span class="title-right">Smith</span>
						
						Forge
					</h1>

					[shiftsmith/admin.display.options.tpl]

					[shiftsmith/admin.input.type.tpl]
					[shiftsmith/admin.output.type.tpl]
					
					[shiftsmith/admin.fetch-url.tpl]
					
					[shiftsmith/admin.title.tpl]
					[shiftsmith/admin.description.tpl]
					[shiftsmith/admin.tags.tpl]

					<div class="files-import" style="display:none;">
						[shiftsmith/admin.files.import.tpl]
					</div>

					<div class="adv-settings">
						<div class="trigers-area">
							<div class="header-block">Triggers</div>
							[shiftsmith/admin.trigger.url.tpl]
							[shiftsmith/admin.trigger.date.tpl]
							[shiftsmith/admin.trigger.require.admin.tpl]
						</div>
					</div>

					[shiftsmith/admin.CKEditor.tpl]
					
					[shiftsmith/admin.db.import.tpl]
					[shiftsmith/admin.wordpress.import.tpl]
					
					
					<!-- Submit -->
					
				</div>
			</div>
			<div class="save-wrapper">
				<div style="max-width:1024px;width:100%;margin:0px auto;" class="cf">
				
						<p class="pipeline">
							<a href="#" onclick="$(this).parents('form').submit();" class="process-button download-button hvr-grow">
								<img src="/admin/files/img/save.png" alt="Submit &amp; Save" />
								<span class="title-left">Save</span> <span class="title-right">It!</span>
							</a>
						</p>
				</div>		
			</div>
	</form>
	<script type="text/javascript">

		function cleanurl(url) {
			url = url.replace(/ /g, '+').replace(/%20/g, '+');
			url = url.replace(/\W+/g, "-");
			while (url.indexOf("--") > -1) {
				url = url.replace("--", "-");
			}
			url = url.toLowerCase();
			return '/'+url;		
		}

		// url generator
		$(function() {
			$(document).on('change', '#page-title', function() {
				if ($("input[name='action']:checked").val()=='page') {
					$('.forge-url-trigger[name=url]').val(cleanurl($(this).val()));
				}
			});
		});
		
		$("[name='action']").change(function() {
			if ($(this).is(':checked'))
				$('.url-fetch').slideDown();
			else
				$('.url-fetch').slideUp();
		});
	
		$('.helpio').change(function() {
			if ($(this).is(':checked'))
				$('.helper').slideDown();
			else
				$('.helper').slideUp();
		});
		
		$('.advancedDisplay').change(function() {
			if ($(this).is(':checked'))
				$('.adv-settings').slideDown();
			else
				$('.adv-settings').slideUp();
		});
		
		var index_slider = 1;
		$(document).on('click mouseup keyup cut paste copy', ".forge-title[name='title']", function(evt) {
			if ($(this).val().length >= 3 && index_slider == 1) {
				$(".forge-title[name='description']").parents('.nextvisual').show('drop');
				index_slider++;
			}
		});

		$(document).on('click mouseup keyup cut paste copy', ".forge-title[name='description']", function(evt) {			
			if ($(this).val().length >= 3 && index_slider == 2) {
				$(".js-tags").parents('.nextvisual').show('drop');
				index_slider++;
			}
		});
		
	</script>

</body>

[admin-footer.tpl]