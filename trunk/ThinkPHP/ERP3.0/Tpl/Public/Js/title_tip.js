var title = "";
var offset_left = 0;
var offset_top = 0;
function showTitle(obj, event) {
	var e = event || window.event;
	title = $(obj).attr("title");
	if ($.trim(title) != "") {
		$(obj).attr("title", "");
		offset_left = 0;
		offset_top = 12;
		if ($(obj).is('a')) {
			offset_top += 10;
		}
		$("#title_layer").html(title.replace(/\n/ig, "<br />")).css({
			"left" : offset_left+e.clientX+$(document).scrollLeft(),
			"top" : offset_top+e.clientY+$(document).scrollTop()
		}).show();
	}
}
function hideTitle(obj) {
	$(obj).attr("title", title);
	$("#title_layer").html("").hide();
}
function moveTitle(event) {
	var e = event || window.event;
	$("#title_layer").css({
		"left" : offset_left+e.clientX+$(document).scrollLeft(),
		"top" : offset_top+e.clientY+$(document).scrollTop()
	});
}
