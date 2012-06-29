document.write('<div id="feedback_pop"><h3><i></i><b></b></h3><form method="post" action="'+_APP_+'/Feedback" target="_iframe"><table cellpadding="0"><tr><td nowrap="nowrap">您的称呼：</td><td><input type="text" class="text" name="name" size="20"/></td></tr><tr><td>联系方式：</td><td><input type="text" class="text" name="phone" size="20"/></td></tr><tr><td valign="top">留言内容：</td><td><textarea name="content" cols="15" rows="3"></textarea></tr><tr><td valign="top"></td><td><span id="feedback_message_box" class="message_box"></span></td></tr><tr><td></td><td><input type="image" class="submit" src="'+IMAGE_FOLDER+'btn_post.jpg" /></td></tr></table></form></div>');

var header_height = 38;
var box_height = 242;
var is_show = 1;

$(document).ready(function() {
	if (null != $.cookie('feedback_pop_zs186')) {
		is_show = $.cookie('feedback_pop_zs186');
	}
	if ('1'==is_show) {
		$("#feedback_pop").css("bottom", 0);
	}
	else {
		$("#feedback_pop").css("bottom", header_height-box_height);
	}
	$("#feedback_pop h3 i").click(function() {
		if (is_show) {
			$("#feedback_pop").css("bottom", header_height-box_height);
			is_show = 0;
		}
		else {
			$("#feedback_pop").css("bottom", 0);
			is_show = 1;
		}
		$.cookie('feedback_pop_zs186', is_show, {path: '/'});
	});
	$("#feedback_pop h3 b").click(function() {
		$("#feedback_pop").css("bottom", header_height-box_height);
		is_show = 0;
		$.cookie('feedback_pop_zs186', is_show, {path: '/'});
	});
});
