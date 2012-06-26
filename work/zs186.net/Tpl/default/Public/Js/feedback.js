document.write('<div id="feedback_div" class="feedback_div"><form method="post" action="'+_APP_+'/feedback" target="_iframe"><table cellpadding="3"><tr><td nowrap="nowrap">您的称呼：</td><td><input type="text" name="name" size="28"/></td></tr><tr><td>联系方式：</td><td><input type="text" name="phone" size="28"/></td></tr><tr><td valign="top">留言内容：</td><td><textarea name="content" cols="26" rows="4"></textarea></tr><tr><td valign="top"></td><td><span id="message_box" class="message_box"></span></td></tr><tr><td colspan="2" align="center"><input type="submit" name="post" class="submit" value="提 交" /></td></tr></table></form></div>');
var default_top_ps = 50;
var tips,
theTop = 145,
old = default_top_ps;
function getID() {
	var str=window.location.href; 

    var es=/clid=/; 

    

    es.exec(str);

     

    var right=RegExp.rightContext; 
}
function initFloatTips() {
	tips = document.getElementById("kfoutbox");
	document.getElementById("kfboxmenu").onmouseover = function() {
		document.getElementById("kfboxmenu").style.display = "none";
		document.getElementById("kfinbox").style.display = "block"
	};
	var boxout = function() {
		document.getElementById("kfboxmenu").style.display = "block";
		document.getElementById("kfinbox").style.display = "none"
	};
	var browser = navigator.userAgent;
	if (browser.indexOf("MSIE") > 0) {
		document.getElementById("kfinbox").onmouseleave = boxout
	} else {
		document.getElementById("kfinbox").onmouseout = function(e) {
			try {
				var p = (this.compareDocumentPosition(e.relatedTarget) == 20)
			} catch(ex) {
				var p = false
			} ! (this === e.relatedTarget || (this.contains ? this.contains(e.relatedTarget) : p)) && boxout.call(this)
		}
	}
	moveTips()
};
function moveTips() {
	var tt = 50;
	if (window.innerHeight) {
		pos = window.pageYOffset
	} else if (document.documentElement && document.documentElement.scrollTop) {
		pos = document.documentElement.scrollTop
	} else if (document.body) {
		pos = document.body.scrollTop
	}
	pos = pos - tips.offsetTop + default_top_ps;
	pos = tips.offsetTop + pos / 10;
	if (pos < default_top_ps) pos = default_top_ps;
	if (pos != old) {
		tips.style.top = pos + "px";
		tt = 10
	}
	old = pos;
	setTimeout(moveTips, tt)
}
initFloatTips();