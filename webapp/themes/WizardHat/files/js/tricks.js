
	$(function() {
		$("#fluff").click(function() {
			for (var i=0;i<100;++i) {
				$(".bubble-wrap").append("<div class='bubble'></div>");
			}
			$(this).hide();
			$("#stop-fluff").show();
		});
		$("#stop-fluff").click(function() {
			$(".bubble").remove();
			$(this).hide();
			$("#fluff").show();
		});

	});

