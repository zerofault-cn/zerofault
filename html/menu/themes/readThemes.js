var _theme = "default"
var _THEME_styles;
var _THEME_styleCount;
var _imgDir;

//д�������Cookieֵ��
function _changeThemes(a){
		if(a==null||a==""||a=="null"){
			_theme = "default"
		}else{
			_theme = a;
		}
		_imgDir = "themes/" + _theme + "/";	
		try{
			for(var i=0;i<_THEME_styleCount;i++){
				var tempStyle = _THEME_styles[i];
				if(tempStyle.indexOf("|")!=0){
					continue;
				}else{
					tempStyle = tempStyle.substring(1);
				}
				var pstr = "";
				
				while(tempStyle.indexOf("../")==0){
					pstr+="../";
					tempStyle = tempStyle.substring(tempStyle.indexOf("../")+3);					
				}
			
				var tempStr = pstr+_imgDir +tempStyle;
				try{
					window.document.styleSheets.item(i).href = tempStr;
				}catch(e){
					document.getElementById("style"+i).href=tempStr;
				}
			}
			var expdate = new Date();
			expdate.setTime (expdate.getTime() + 10*365 * (24 * 60 * 60 * 1000));
			_SetCookie ("_SYS_THEMES", a, expdate, "/");
			_imgDir=pstr+_imgDir;
		}catch(e){
				alert("->"+e);
				return;
		}
}

//�����ĵ�����ʽ��initΪ�Ƿ���Ҫ��ʼ��
function _setThemes(init){
	var argc = _setThemes.arguments.length;
	if(argc>0&&_setThemes.arguments[0]==true){
		_initThemes();
	}
	var a = _GetCookie("_SYS_THEMES");
	_changeThemes(a);
}

//��ʼ������ֵ
function _initThemes(){
	var _styleSheets = window.document.styleSheets;	
	_THEME_styleCount = _styleSheets.length;
	_THEME_styles = new Array(_THEME_styleCount);
	for(var i=0;i<_THEME_styleCount;i++){
		var tempHref = _styleSheets.item(i).href;
		if(tempHref.indexOf("|")>=0){
			_THEME_styles[i] = tempHref.substring(tempHref.indexOf("|"));
		}else{
			_THEME_styles[i] = _styleSheets.item(i).href;
		}
	}	
}

function _getCookieVal (offset){
	  var endstr = document.cookie.indexOf (";", offset);
	  if (endstr == -1)
		endstr = document.cookie.length;
	  return unescape(document.cookie.substring(offset, endstr));
}

function _GetCookie (name){
	  var arg = name + "=";
	  var alen = arg.length;
	  var clen = document.cookie.length;
	  var i = 0;
	  while (i < clen) {
		var j = i + alen;
		if (document.cookie.substring(i, j) == arg)
		  return _getCookieVal (j);
		i = document.cookie.indexOf(" ", i) + 1;
		if (i == 0) break; 
	  }
	  return null;
}
function _SetCookie (name, value){
	  var argv = _SetCookie.arguments;
	  var argc = _SetCookie.arguments.length;
	  var expires = (argc > 2) ? argv[2] : null;
	  var path = (argc > 3) ? argv[3] : null;
	  var domain = (argc > 4) ? argv[4] : null;
	  var secure = (argc > 5) ? argv[5] : false;
	  document.cookie = name + "=" + escape (value) +
		((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
		((path == null) ? "" : ("; path=" + path)) +
		((domain == null) ? "" : ("; domain=" + domain)) +
		((secure == true) ? "; secure" : "");
}


//���¼������е���ʽ��
function _loadTheme(){
	_changeAll(window.top);	
}

function _changeAll(farg){
	try{
		var subframe=farg.document.frames;
		if(typeof(farg._setThemes)=="function"){
			farg._setThemes();
		}
		for(var i = 0;i<subframe.length;i++){
			if(typeof(subframe[i]._setThemes)=="function"){
				subframe[i]._setThemes();
			}
			_changeAll(subframe[i]);
		}
	}catch(e){
		//farg.reload();
	}
}
//�ĵ��������ʱ����ʽ����д�����Ҫ���г�ʼ����
document.onLoad += _setThemes(true);

