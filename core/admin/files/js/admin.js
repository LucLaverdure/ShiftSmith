function adjustLeftCol() {
	if ($(".left-col").length > 0) {

		var get_top = ($(".parallax-window.sub").offset().top + $(".parallax-window.sub").outerHeight());
	
		var topla = get_top - $(document).scrollTop();
		if (topla < 0) topla = 0;
		if (topla > get_top) topla = get_top;
		$(".left-col").css('top', topla+'px');

		var h = $(window).height() - topla;
		if (h > $(window).height()) h = $(window).outerHeight();
		$(".left-col").css('height', h+'px');

	}
}

$(document).on('scroll', window, function() {
	adjustLeftCol();
});

$(document).on('resize', window, function() {
	adjustLeftCol();
});

var image_gallery_timer;
$(document).on('click', '.media-button .del', function() {
	
	var file_to_del = $(this).parents('a').attr('href');
	if (confirm("Are you sure you want to delete " + file_to_del + "?") == true) {
		window.location = '/admin/del'+file_to_del;
	} 
	
	return false;
});

$(document).on('click', '.line .del', function() {
	$.ajax({
		url: "/admin/comments/del/"+$(this).parents('.line').attr('data-id'),
		cache: false,
		context: document.body
	}).done(function(data) {
		$(this).parents('.line').fadeOut();
	});
});


$(function() {
	
	adjustLeftCol();
	
	// setup all datepickers of the page
    $( ".datepicker" ).datepicker();
  
	// select refresh rate of the chatboxes
	setTimeout(function() {$('.line').append('<span class="del"></span>'); },1000);

	var $this = $('a.media-image').not(':visible').first();
	if ($this.length > 0) {
		image_gallery_timer = setTimeout(function() {
			display_pictures();
		}, 600);
	}
	
	$('.admin-panel label a').click(function() {
		$(this).parent().find('input[type=radio]').click();
		return false;
	});
});

function display_pictures() {
	$this = $('a.media-image').not(':visible').first();
	$this.fadeIn();
	if ($this.length > 0) {
		image_gallery_timer = setTimeout(function() {
			display_pictures();
		}, 600);
	}
}


$(document).on('click', '.login-button', function() {
	$('#thisform').submit();
});

$(document).on('keypress', "#thisform input", function(e) {
	if (e.which == 13) {
		$('#thisform').submit();
		return false;
	}
});

$(document).on('click', ".fold-admin", function(e) {
	$('.admin-bar.left-bar').animate({
		left: -$('.admin-bar.left-bar').outerWidth(),
		opacity:0
	});
	$('.admin-bar.top-bar').animate({
		top: -$('.admin-bar.top-bar').outerHeight(),
		opacity:0
	});
	$('.unfold-admin').animate({
		top:0,
		left:0,
		opacity:0.8
	});
});

$(document).on('click', ".unfold-admin", function(e) {
	$('.admin-bar.left-bar').animate({
		left: 0,
		opacity:0.8
	});
	$('.admin-bar.top-bar').animate({
		top: 0,
		opacity:0.8
	});
	$('.unfold-admin').animate({
		top:'-100px',
		left:'-100px',
		opacity:0
	});
});

$(document).on('click', ".body_type label input", function(e) {
	var selected = $(this).val();

	switch (selected) {
		case 'markup':
			$('.markup-select').slideDown('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'url':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideDown('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'db':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideDown('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'drupal':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideDown('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'file':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideDown('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideUp('fast');
			break;
		case 'wp-import':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideUp('fast');
			$('.wp-select').slideDown('fast');
			break;
		case 'drupal-import':
			$('.markup-select').slideUp('fast');
			$('.url-select').slideUp('fast');
			$('.db-select').slideUp('fast');
			$('.file-select').slideUp('fast');
			$('.drupal-select').slideDown('fast');
			$('.wp-select').slideUp('fast');
			break;
	}
	
});

function cleanurl(url) {
	url = url.replace(/ /g, '+').replace(/%20/g, '+');
	url = url.replace(/\W+/g, "-");
	while (url.indexOf("--") > -1) {
		url = url.replace("--", "-");
	}
	url = url.toLowerCase();
	return '/'+url;		
}

$(document).on('change', '#forge-title', function() {
	var $this = $(this);
	$('#forge-url').val(cleanurl($this.val()));
});

function incItems() {
	var incR = 0;
	$('.menu-wrapper .item:visible').each(function() {
		$(this).find(".rad").attr('name', 'fields.opto['+incR.toString()+']');
		incR++;
	});
}

$(document).on('click', '.add-button-custom', function() {
	$('#template-placeholder').append($('#template-custom-field').html());
	$('#template-placeholder').find('.field-head').last().fadeIn();
	incItems();
	return false;
});


$(document).on('click', '.forge-option-block', function() {
	window.location = $(this).find('a').attr('href');
	return false;
});

$(function() {
	
	var select2 = $(".js-tags");

	select2.on("select2:open", function (e) { 
		if ($('.advancedDisplay').is(':checked')) {
			$(".triggers").parents('.nextvisual').show('drop');
		} else {
			$(".input-type").parents('.nextvisual').show('drop');
		}
	});

	$('.js-tags').select2({tags: true, tokenSeparators: [',', ' ']});
});

// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.
$(function() {
	if ($('#ckeditor').length > 0) {
		CKEDITOR.replace( 'ckeditor' );
		CKEDITOR.instances.ckeditor.on('contentDom', function() {
			  CKEDITOR.instances.ckeditor.document.on('keydown', function(event) {
				 var str = CKEDITOR.instances.ckeditor.getData();
				 if (str.length > 5) {
					 $('.pipeline a').show('drop');
				 }
			  });
		});
	}
});

function validateForm(form_sent) {
	var flag = true;
	form_sent.find("input.required:visible").each(function() {
		if ($.trim($(this).val()) == '') {
			flag = false;
			alert("Please fill in all required fields. ("+$(this).attr("title")+")");
			return false;
		}
	});
	if (flag != false) {
		form_sent.find("textarea.required:visible").each(function() {
			if ($.trim($(this).val()) == '') {
				flag = false;			
				alert("Please fill in all required fields. ("+$(this).attr("title")+")");
				return false;
			}
		});
	}
	if (flag != false) {
		form_sent.find("select.required:visible").each(function() {
			if ($.trim($(this).val()) == '') {
				flag = false;			
				alert("Please fill in all required fields. ("+$(this).attr("title")+")");
				return false;
			}
		});
	}
	if (flag != false) {
		if ($("#cke_ckeditor:visible").length > 0) {
			if ($.trim($("#cke_ckeditor iframe").contents().find("body").text())=="") {
				flag = false;			
				alert("Please fill in all required fields. (HTML Editor)");
				return false;
			}
		}
	}
	
	return flag;
}

$(document).on('submit', 'form', function() {
	return validateForm($(this).parents('form'));
});

$(document).on('click', '.save-button', function() {
	if (validateForm($(this).parents('form')))
		$(this).parents('form').submit();
	return false;
});

$(document).on('click', '.forged .row', function() {
	var $selItem = $(this).find('.itemSel');
	if ($selItem.is(':checked')) {
		$selItem.prop('checked', false);
	} else {
		$selItem.prop('checked', true);
	}
});

