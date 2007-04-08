function ResetBrowser()
{
	function Xb(a,b,c)
	{
		this.type=a;
		this.version=b;
		this.os=c
	};
	browser=new Xb(0,0,null);
	var ha=navigator.userAgent.toLowerCase();
	if(ha.indexOf("opera")!=-1)
	{
		browser.type=4;
		if(ha.indexOf("opera/7")!=-1||ha.indexOf("opera 7")!=-1)
		{
		browser.version=7
		}
		else if(ha.indexOf("opera/8")!=-1||ha.indexOf("opera 8")!=-1)
		{
			browser.version=8
		}
	}
	else if(ha.indexOf("msie")!=-1&&document.all)
	{
		browser.type=1;
		if(ha.indexOf("msie 5"))
		{
			browser.version=5
		}
	}
	else if(ha.indexOf("safari")!=-1)
	{
		browser.type=3
	}
	else if(ha.indexOf("mozilla")!=-1)
	{
		browser.type=2
	}
	if(ha.indexOf("x11;")!=-1)
	{
		browser.os=1
	}
	else if(ha.indexOf("macintosh")!=-1)
	{
		browser.os=2
	};
}
function _script(src,handle)
{
	var ret='<'+'script charset="GB2312" src="'+src+'"'+' type="text/javascript" id="Stat51Yes"><'+'/script>';
	document.write(ret);
	if(handle)
		document.getElementById("Stat51Yes").onreadystatechange=handle;
}
function send
_script("http://count17.51yes.com/click.aspx?id=174911790&logo=12",ResetBrowser);
_uacct = "UA-303112-1";
_script("http://www.google-analytics.com/urchin.js",urchinTracker);