function setCookie(name,value)
{
	var Days=30;
	var exp=new Date();
	exp.setTime(exp.getTime()+ Days*24*60*60*1000);
	document.cookie=name + "="+ escape(value)+ ";expires=" + exp.toGMTString();
}
function getCookie(name)
{
	var arr,reg=new RegExp("(^|)"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	{
		return unescape(arr[2]);
	}
	else
	{
		return null;
	}
}
function delCookie(name)
{
	var exp=new Date();
	exp.setTime(exp.getTime()- 1);
	var cval=getCookie(name);
	if(cval!=null)document.cookie=name + "="+cval+";expires="+exp.toGMTString();
}
var EnBase64Chars="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var DeBase64Chars=new Array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,62,-1,-1,-1,63,52,53,54,55,56,57,58,59,60,61,-1,-1,-1,-1,-1,-1,-1,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,-1,-1,-1,-1,-1,-1,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,-1,-1,-1,-1,-1);
function EnBase64(str)
{
	var out,i,len;
	var c1,c2,c3;
	len=str.length;
	i=0;
	out="";
	while(i<len)
	{
		c1=str.charCodeAt(i++)&0xff;
		if(i==len)
		{
			out+=EnBase64Chars.charAt(c1>>2);
			out+=EnBase64Chars.charAt((c1&0x3)<<4);
			out+="==";
			break;
		}
		c2=str.charCodeAt(i++);
		if(i==len)
		{
			out+=EnBase64Chars.charAt(c1>>2);
			out+=EnBase64Chars.charAt(((c1&0x3)<<4)|((c2&0xF0)>>4));
			out+=EnBase64Chars.charAt((c2&0xF)<<2);
			out+="=";
			break;
		}
		c3=str.charCodeAt(i++);
		out+=EnBase64Chars.charAt(c1>>2);
		out+=EnBase64Chars.charAt(((c1&0x3)<<4)|((c2&0xF0)>>4));
		out+=EnBase64Chars.charAt(((c2&0xF)<<2)|((c3&0xC0)>>6));
		out+=EnBase64Chars.charAt(c3&0x3F);
	}
	return out;
}
function DeBase64(str)
{
	var out,i,len;
	var c1,c2,c3;
	len=str.length;
	i=0;
	out="";
	tmp="";
	while(i<len)
	{
		c1=str.charCodeAt(i++)&0xff;
		if(c1=='=')
		{
			return out;
		}
		c2=str.charCodeAt(i++)&0xff;
		if(c2=='=')
		{
			return out;
		}
		c3=str.charCodeAt(i++)&0xff;
		if(c3==61)
		{
			t1=DeBase64Chars[c1];
			t2=DeBase64Chars[c2];
			k1=((t1&0x3F)<<2)|((t2&0x30)>>4);
			out+=String.fromCharCode(k1);
			return out;
		}
		c4=str.charCodeAt(i++)&0xff;
		if(c4==61)
		{
			t1=DeBase64Chars[c1];
			t2=DeBase64Chars[c2];
			t3=DeBase64Chars[c3];
			k1=((t1&0x3F)<<2)|((t2&0x30)>>4);
			k2=((t2&0x0F)<<4)|((t3&0x3D)>>2);
			out+=String.fromCharCode(k1,k2);
			return out;
		}
		t1=DeBase64Chars[c1];
		t2=DeBase64Chars[c2];
		t3=DeBase64Chars[c3];
		t4=DeBase64Chars[c4];
		k1=((t1&0x3F)<<2)|((t2&0x30)>>4);
		k2=((t2&0x0F)<<4)|((t3&0x3D)>>2);
		k3=((t3&0x03)<<6)|(t4&0x3F);
		out+=String.fromCharCode(k1,k2,k3);
	}
	return out;
}
function utf16to8(str)
{
	var out,i,len,c;
	out="";
	len=str.length;
	for(i=0;i<len;i++)
	{
		c=str.charCodeAt(i);
		if((c>=0x0001)&&(c<=0x007F))
		{
			out+=str.charAt(i);
		}
		else if(c>0x07FF)
		{
			out+=String.fromCharCode(0xE0|((c>>12)&0x0F));
			out+=String.fromCharCode(0x80|((c>>6)&0x3F));
			out+=String.fromCharCode(0x80|((c>>0)&0x3F));
		}
		else
		{
			out+=String.fromCharCode(0xC0|((c>>6)&0x1F));
			out+=String.fromCharCode(0x80|((c>>0)&0x3F));
		}
	}
	return out;
}
function getBlogID()
{
	if(b==null||b=='')
	{
		return null;
	}
	else
	{
		var tmp=str[1];
		return tmp.substring(0,tmp.indexOf('.'));
	}
}
function getGroupID()
{
	
	if(b==null||b=='')
	{
		return null;
	}
	else
	{
		return str[4];
	}
}
var b=getCookie("bokie");
if(b!=null && b!='')
{
	var str=DeBase64(b).split(",");
}
var blogID = getBlogID();
var groupID= getGroupID();