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

function changeImg(a, imgUrl) {
	$(a).find("img").attr("src",imgUrl);
}
$(document).ready(function() {
	if ($(".kf54kefuqqbottom").length > 0) {
	//	$(".kf54kefuqqbottom").html($(".kf54kefuqqbottom a").html());
	}
	var index_top = 630;
	var main_top = 400;
	$(window).scroll(function() {
		var offsetTop = $(window).scrollTop();
		if (offsetTop < 630) {
			index_top = '630px';
		}
		else {
			index_top = offsetTop+5 + 'px';
		}
		if ($("#index #service").length > 0) {
			$("#index #service").animate({"top": index_top}, 0);
		}
		if (offsetTop < 400) {
			main_top = '400px';
		}
		else {
			main_top = offsetTop+5 + 'px';
		}
		if ($("#content #service").length > 0) {
			$("#content #service").animate({"top": main_top}, 0);
		}
	}); 

	$("#nav .menu img").each(function () {
		var src = $(this).attr("src");
		var alt = $(this).attr("alt");
		$(this).hover(
			function () {
				$(this).attr("src", alt);
			},
			function () {
				$(this).attr("src", src);
			}
		);
	});
});


