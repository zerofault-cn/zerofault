//弹出式菜单功能
var h;
var w;
var l;
var t;
var topMar = 1;
var leftMar = -2;
var space = 1;
var isvisible;
var MENU_SHADOW_COLOR='#ffffff';//定义下拉菜单阴影色
var global = window.document
global.fo_currentMenu = null
global.fo_shadows = new Array
function HideMenu() 
{
	var mX;
	var mY;
	var vDiv;
	var mDiv;
	if (isvisible == true)
	{
		vDiv = document.all("menuDiv");
		mX = window.event.clientX + document.body.scrollLeft;
		mY = window.event.clientY + document.body.scrollTop;
		if((mX < parseInt(vDiv.style.left))||(mX >parseInt(vDiv.style.left)+vDiv.offsetWidth)||(mY < parseInt(vDiv.style.top)-h) || (mY > parseInt(vDiv.style.top)+vDiv.offsetHeight))
		{
			vDiv.style.visibility = "hidden";
			isvisible = false;
		}
	}
}

function ShowMenu(vMnuCode,tWidth)//下弹菜单
{
	vSrc = window.event.srcElement;
	vMnuCode = "<table id='submenu' cellspacing=1 cellpadding=1 style='width:"+tWidth+"' onmouseout='HideMenu()'><tr><td nowrap align=left>" + vMnuCode + "</td></tr></table>";

	h = vSrc.offsetHeight;
	w = vSrc.offsetWidth;
	l = vSrc.offsetLeft + leftMar;
	t = vSrc.offsetTop + topMar + h + space-2;
	vParent = vSrc.offsetParent;
	while (vParent.tagName.toUpperCase() != "BODY")
	{
		l += vParent.offsetLeft;
		t += vParent.offsetTop;
		vParent = vParent.offsetParent;
	}

	menuDiv.innerHTML = vMnuCode;
	menuDiv.style.top = t;
	menuDiv.style.left = l;
	menuDiv.style.visibility = "visible";
	isvisible = true;
    makeRectangularDropShadow(submenu, MENU_SHADOW_COLOR, 4)
}

function ShowSubMenu(vMnuCode,tWidth)//右弹菜单
{
	vSrc = window.event.srcElement;
	vMnuCode = "<table id='submenu' cellspacing=0 cellpadding=0 style='width:"+tWidth+"' onmouseout='HideMenu()'><tr><td nowrap align=left>" + vMnuCode + "</td></tr></table>";

	h = vSrc.offsetHeight;
	w = vSrc.offsetWidth;
	l = vSrc.offsetLeft + leftMar+30;
	t = vSrc.offsetTop + topMar + space-2;
	vParent = vSrc.offsetParent;
	while (vParent.tagName.toUpperCase() != "BODY")
	{
		l += vParent.offsetLeft;
		t += vParent.offsetTop;
		vParent = vParent.offsetParent;
	}

	menuDiv.innerHTML = vMnuCode;
	menuDiv.style.top = t;
	menuDiv.style.left = l;
	menuDiv.style.visibility = "visible";
	isvisible = true;
    makeRectangularDropShadow(submenu, MENU_SHADOW_COLOR, 4)
}

function makeRectangularDropShadow(el, color, size)
{
	var i;
	for (i=size; i>0; i--)
	{
		var rect = document.createElement('div');
		var rs = rect.style
		rs.position = 'absolute';
		rs.left = (el.style.posLeft + i) + 'px';
		rs.top = (el.style.posTop + i) + 'px';
		rs.width = el.offsetWidth + 'px';
		rs.height = el.offsetHeight + 'px';
		rs.zIndex = el.style.zIndex - i;
		rs.backgroundColor = color;
		var opacity = 1 - i / (i + 1);
		rs.filter = 'alpha(opacity=' + (100 * opacity) + ')';
		el.insertAdjacentElement('afterEnd', rect);
		global.fo_shadows[global.fo_shadows.length] = rect;
	}
}



function _FindObj(n,d)
	{ 
	var p,i,x;  
	if(!d) d=document; 
	if((p=n.indexOf("?"))>0&&parent.frames.length) 
		{
		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);
		}
	if(!(x=d[n])&&d.all) x=d.all[n]; 
	for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
	for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=_FindObj(n,d.layers[i].document);
	if(!x && document.getElementById) x=document.getElementById(n); return x;
	}
function _ShowHideLayers()
	{ 
	var i,p,v,obj,args=_ShowHideLayers.arguments;
	for (i=0; i<(args.length-2); i+=3) 
	if ((obj=_FindObj(args[i]))!=null) 
		{ v=args[i+2];
		if (obj.style) 
			{
			obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; 
			}
		obj.visibility=v; 
		}
	}
function _MouseOverMenu(ObjName,ObjSubMenuName)
	{ 
	if (!ObjName.contains(event.fromElement)) 
		{ 
		ObjName.style.cursor = 'hand'; 
		ObjName.background = 'images/menu_bg_up.jpg'; 
		_ShowHideLayers(ObjSubMenuName,'','show')
		}
	}
function _MouseOutMenu(ObjName,ObjSubMenuName)
	{
	if (!ObjName.contains(event.toElement))
		{ 
		ObjName.style.cursor = 'default'; 
		ObjName.background = 'images/menu_bg_down.jpg'; 
		_ShowHideLayers(ObjSubMenuName,'','hide')
		}
	} 


var tips="<a href='/phpbbs/utilities/calendar.htm' target=_blank>超酷日历</a><br><a target=_blank href='/phpbbs/utilities/block.html'>俄罗斯方块</a><br><a href='/phpbbs/utilities/eatapple.html'>吃苹果</a><br><a href='/phpbbs/utilities/brick.html'>弹砖块游戏</a><br><a href='/phpbbs/utilities/earthquake.html' target=_blank>地震</a><br><a href='/javascripttest/magic_painting.htm'>魔力着色</a><br><a href='/javascripttest/turningover.htm'>翻图游戏</a><br><a href='/phpbbs/utilities/pic_game.htm'>拼图游戏</a><br><a href='/javascripttest/hit_the_dot.htm'>鼠标灵活度</a><br><a href='/javascripttest/runner.htm'>螃蟹赛跑</a><br><a href='/javascripttest/calculator.htm'>计算器</a><br><a href='/javascripttest/checkall.htm'>另类扫雷</a><br><a href='/phpbbs/utilities/ipsearch.php'>IP地址查询</a><br><a href='/phpbbs/utilities/mobilesearch.php'>手机归属地查询</a>";

var link="<a href='http://202.115.32.24' target=_blank>川大望江楼</a><br><a href='http://202.115.48.148' target=_blank>川大蓝色星空</a><br><a href='http://bbs.uestc.edu.cn' target=_blank>电子科大一网情深</a><br><a href='http://bbs.pku.edu.cn' target=_blank>北大未名BBS</a><br><a href='http://bbs3w.tsinghua.edu.cn' target=_blank>水木清华</a><br><a href='http://bbs.nju.edu.cn' target=_blank>南京大学小百合</a><br><a href=# onmouseover=ShowMenu(music,60)>Music</a>";

var bbs="<a href='http://202.115.32.24' target=_blank>川大望江楼</a><br><a href='http://202.115.48.148' target=_blank>川大蓝色星空</a><br><a href='http://bbs.uestc.edu.cn' target=_blank'>电子科大一网情深</a><br><a href='http://bbs.pku.edu.cn' target=_blank>北大未名BBS</a><br><a href='http://bbs3w.tsinghua.edu.cn' target=_blank>水木清华</a><br><a href='http://bbs.nju.edu.cn' target=_blank>南京大学小百合</a>";

var computer="<a href='http://www.buynow.com.cn' target=_blank>百脑会</a><br><a href='http://www.westd.net' target=_blank>西域IT网</a><br><a href='http://www.oakpc.com' target=_blank>橡树网</a><br><a href='http://www.pconline.com.cn' target=_blank>太平洋电脑网</a><br><a href='http://www.zol.com.cn' target=_blank>中关村在线</a><br><a href='http://www.mydrivers.com' target=_blank>驱动之家</a>";

var music="<a href='http://music.popv.net' target=_blank>博维音乐站</a><br><a href='http://51music.dhs.org' target=_blank>我要MUSIC</a><br><a href='http://www.51lrc.com' target=_blank>我要歌词</a><br><a href='http://popmusic.dhs.org' target=_blank>流行音乐在线(暂停)</a><br><a href='http://music.ahnan.com' target=_blank>十一度</a><br><a href=# onmouseover=ShowMenu(computer,60)>Computer</a>";

