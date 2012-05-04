function show_msg(id, msg) {
	$("#"+id).html(msg);
}
function hide_msg(id, intval) {
	if(intval=='') {
		intval = 2000;
	}
	setTimeout(function() {
		$("#"+id).html("");
	}, intval);
}
function myLocation(loc, intval) {
	if(intval=='') {
		intval = 2000;
	}
	setTimeout(function() {
		window.location.href= (loc==''? window.location.href : loc);
		},intval);
}
