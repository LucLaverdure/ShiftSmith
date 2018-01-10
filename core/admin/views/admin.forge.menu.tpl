[admin-header.tpl]
<div class="parallax-window sub" data-parallax="scroll" data-image-src="/core/admin/files/img/login-bg.png">

		<div class="wrapper cf">
			<h1>Forge - Menu</h1>
		</div>
</div>
[admin-panel.tpl]
<div class="wrapper menu-wrapper">

	<a href="/user">Administration</a> &gt; <a href="/core/admin/forge">Forge</a> &gt; Menu

	<form method="post" action="" enctype="multipart/form-data">

		<input type="hidden" name="item.id" value="[menu.item.id]" />
		<input type="hidden" name="tags.name[]" value="menu" />
		
		<label>
			<h2 class="header-block required"><span></span>Menu Language</h2>
			<select class="lang-select chkopto" name="content.lang" data-val="[menu.content.lang]">
[for:lang.custom]
				<option value="[lang.custom.code]">[lang.custom.title]</option>
[end:lang.custom]
			</select>
		</label>

		<label>
			<h2 class="header-block required"><span></span>Menu Title</h2>
			<input id="forge-title" class="forge-title required" type="text" value="[menu.content.title]" name="content.title" title="Title" />
		</label>

		<h2 class="header-block required"><span></span>Menu Hierarchy</h2>
		<div class="items-container">
			<ul class="items" id="template-placeholder">
[for:menu.fields]
				<li class="item [menu.fields.level]"> <!-- second-level or first-level -->
					
					<input class="clevel required" type="hidden" name="fields.level[]" value="[menu.fields.level]" />
					
					<img src="/core/admin/files/img/ico/move.png" alt="Move" />
					
					Title : <input type="text" name="fields.title[]" value="[menu.fields.title]" class="menu-input required"title="Menu Link Title" />
					<label class="url-opt">
						<input type="radio" name="fields.opto[]" value="url" class="rad chktype" data-val="[menu.fields.opto]" />
						URL : <input title="Menu Link URL" type="text" name="fields.url[]" value="[menu.fields.url]" class="optclick menu-input" />
					</label>
					
					<label class="page-opt">
						<input type="radio" name="fields.opto[]" value="page" class="rad chktype" data-val="[menu.fields.opto]" /> Page :
						<select name="fields.page[]" title="Menu Link Page" class="optclick menu-input menu-pages chkopto " data-val="[menu.fields.page]">
						</select>
					</label>
					
					<a href="#" class="del-button">Delete</a>
				</li>
[end:menu.fields]
			</ul>		
		</div>
		<a href="#" class="button add-button-custom">Add Menu Item</a>

		<a href="#" class="button save-button">Save Changes</a>
		
</form>
</div>

		<ul id="template-custom-field" style="display:none;">
				<li class="item first-level"> <!-- second-level or first-level -->
					
					<input class="clevel" type="hidden" name="fields.level[]" value="first-level" />
					
					<img src="/core/admin/files/img/ico/move.png" alt="Move" />
					
					Title : <input type="text" name="fields.title[]" value="Home" class="menu-input" />
					<label class="url-opt">
						<input type="radio" name="fields.opto[]" value="url" class="rad chktype" checked="checked" />
						URL : <input type="text" name="fields.url[]" value="/" class="optclick menu-input" />
					</label>
					
					<label class="page-opt">
						<input type="radio" name="fields.opto[]" value="page" class="rad chktype" /> Page :
						<select name="fields.page[]" class="optclick menu-input menu-pages">
						</select>
					</label>
					
					<a href="#" class="del-button">Delete</a>
				</li>
		</ul>
		<script type="text/javascript">
			
			incItems();
			
			$('.menu-pages').each(function() {
				[for:pages.item]
					$(this).append('<option value="[pages.item.id]">[pages.item.title]</option>');
				[end:pages.item]
			});
			
			$('.chktype:visible').each(function() {
				$this = $(this);
				if ($this.val() == $this.attr('data-val')) {
					$this.prop('checked', true);
				};
			});
			
			$('.chkopto:visible').each(function() {
				$this = $(this);
				$this.val($this.attr('data-val'));
			});
			
		</script>
	


<script type="text/javascript">

	var tags = [ ];
	var ids = [ ];

	$(".items").sortable({
		connectWith: ".items",
		placeholder: "placeholder",
		update: function(event, ui) {
			// update
		},
		start: function(event, ui) {
			if(ui.helper.hasClass('second-level')){
				ui.placeholder.removeClass('placeholder');
				ui.placeholder.addClass('placeholder-sub');
			}
			else{ 
				ui.placeholder.removeClass('placeholder-sub');
				ui.placeholder.addClass('placeholder');
			}
		},
		sort: function(event, ui) {
			var pos;
			if(ui.helper.hasClass('second-level')){
				pos = ui.position.left+20; 
				$('#cursor').text(ui.position.left+20);
			}
			else{
				pos = ui.position.left; 
				$('#cursor').text(ui.position.left);    
			}
			if(pos >= 32 && !ui.helper.hasClass('second-level')){
				ui.placeholder.removeClass('placeholder');
				ui.placeholder.addClass('placeholder-sub');
				ui.helper.addClass('second-level');
				// sub item
				ui.helper.find('.clevel').val('second-level');
			}
			else if(pos < 25 && ui.helper.hasClass('second-level')){
				ui.placeholder.removeClass('placeholder-sub');
				ui.placeholder.addClass('placeholder');
				ui.helper.removeClass('second-level');
				// main item
				ui.helper.find('.clevel').val('first-level');
			}
		}
	});
	$(".item").droppable({
		accept: ".item",
		hoverClass: "dragHover",
		drop: function( event, ui ) {
			// drop
		},
		over: function( event, ui ) {
			// over
		},
		activate: function( event, ui ) {
			// activate
		}
	});
		
	$(document).on('click', '.del-button', function() {
		if ($(".items .item").length <= 1) {
			alert("Menu must have a minimum of 1 item.");
			return false; // minimum of one item
		}
		$(this).parent('li').first().remove();
		return false;
	});
	
	$(document).on('click', '.optclick', function() {
		$(this).parents('label').find(".rad").prop("checked", true);
		return false;
	});

</script>

[admin-footer.tpl]