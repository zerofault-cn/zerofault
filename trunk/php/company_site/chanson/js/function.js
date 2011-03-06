function init() {
	$("#navigation li").each(function() {
		$(this).removeClass('focus');
	});
	$("#navigation #li_"+module).addClass('focus');

	$("#navigation a").each(function() {
		var href = $(this).attr('href');
		var m = href.substring(1);
		$(this).click(function() {
				$("#navigation li").each(function() {
					$(this).removeClass('focus');
				});
				$(this).parent().addClass('focus');
				load(m);
				return false;
			});
	});
	slider();
	stylist_init();
}
function load(module) {
	$.get(module+'.inc',
		function(html) {
			$("#right_wrapper").html(html);
			slider();
			stylist_init();
		});
}
function slider() {
	if ($('#slider').length>0) {
		$('#slider').coinslider({
			width: 455,
			height: 353
		});
	}
}
function stylist_init() {
	if ($("#stylist_list").length>0) {
		$("#stylist_list a").each(function() {
			var href = $(this).attr('href');
			var m = 'stylist';
			var s = href.substring(href.indexOf('?')+9);
			$(this).click(function() {
					load(m+'_'+s);
					return false;
				});
		});
	}
}
