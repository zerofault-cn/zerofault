function myAlert(msg) {
	jQuery.prompt(msg);
}
function myOK(intval) {
	if(intval=='') {
		intval = 2000;
	}
	setTimeout(function() {
		jQuery("#cleanbluebox").remove();
	}, intval);
}
function myLocation(loc,intval) {
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
		buttons: {Yes:true, Cancel:false}
	});
	return true;
}