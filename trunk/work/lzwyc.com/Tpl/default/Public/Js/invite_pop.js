var site = "lzwyc";
var is_show = 1;

$(document).ready(function() {
	var pop_tip = $("<div />").attr("id", "invite_pop_tip");

	$("body").append(pop_tip);
	var pop_box = $("<div />").attr("id", "invite_pop");
	var form = '<form method="post" action="'+_APP_+'/Invite/submit" target="_iframe"><input type="hidden" name="submit" value="1" /><input type="hidden" name="quick_form" value="1" /><input type="hidden" name="pop_form" value="1" /><table width="100%" cellspacing="1" cellpadding="0"><tr><td nowrap="nowrap">姓 名：</td><td><input type="text" class="text" name="name" size="20"/></td></tr><tr><td>区 域：</td><td><select name="district"><option value="0">请选择所在区域</option><option value="3">夷陵区</option><option value="4">西陵区</option><option value="5">伍家岗区</option><option value="6">点军区</option><option value="7">猇亭区</option><option value="8">宜都市</option><option value="9">当阳市</option><option value="10">枝江市</option><option value="11">远安县</option><option value="12">兴山县</option><option value="13">秭归县</option><option value="14">长阳土家族自治县</option><option value="15">五峰土家族自治县</option></select></td></tr><tr><td>电 话：</td><td><input type="text" class="text" name="phone" size="20"/></td></tr><tr><td>面 积：</td><td><input type="text" class="text area" name="area" size="6"/> m<sup>2<sup></td></tr><tr><td>预 算：</td><td><select name="budget"><option value="0">请选择装修预算</option><option value="1">一万以下</option><option value="2">二万</option><option value="3">三万</option><option value="4">四万</option><option value="5">五万</option><option value="6">六万</option><option value="7">七万至十万</option><option value="10">十万以上</option></select></td></tr><tr><td valign="top">说 明：</td><td><textarea name="demand" onfocus="this.value=\'\'\;">请简单描述您对装修设计的要求</textarea></td></tr><tr><td colspan="2"><span id="invite_message_box" class="message_box"></span></td></tr><tr><td></td><td><input type="submit" value="提交" />&nbsp;<input type="button" value="关闭" id="pop_close"/></td></tr></table></form>';
	pop_box.append(form);
	$("body").append(pop_box);
	pop_tip.mouseover(function() {
		$(this).hide();
		pop_box.css("right", 0);
		is_show = 1;
		$.cookie('_pop_'+site, is_show, {path: '/'});
	});
	if (null != $.cookie('_pop_'+site)) {
		is_show = $.cookie('_pop_'+site);
	}
	if ('1'==is_show) {
		pop_box.css("right", 0);
		pop_tip.hide();
	}
	else {
		pop_box.css("right", "-267px");
		pop_tip.show();
	}
	$("#pop_close").click(function() {
		pop_box.css("right", "-267px");
		pop_tip.show();
		is_show = 0;
		$.cookie('_pop_'+site, is_show, {path: '/'});
	});
	
});
