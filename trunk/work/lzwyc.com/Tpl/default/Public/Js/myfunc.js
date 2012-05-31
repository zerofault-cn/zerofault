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
function myAlert(msg) {
	$.prompt(msg);
}
function myOK(intval) {
	if(intval=='') {
		intval = 2000;
	}
	setTimeout(function() {
		$("#cleanbluebox").remove();
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
function myConfirm(str, url) {
	$.prompt(str, {
		submit: function(v, m) {
			if (v) {
				$("#_iframe").attr("src", url);
			}
			return true;
		},
		buttons: {'确定':true, '取消':false}
	});
	return true;
}