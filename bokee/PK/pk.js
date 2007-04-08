var is_IE;
if(window.navigator.userAgent.indexOf("MSIE")>=1)
{
	is_IE=1;
}
else
{
	is_IE=0;
}
function createXMLHTTP() {
	var xmlhttp=null;
	try {
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");//适用IE
	}
	catch(e) {
		try {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");//适用IE
		}
		catch(oc) {
			xmlhttp=null;
		}
	}
	if ( !xmlhttp && typeof XMLHttpRequest != "undefined" ) { 
		xmlhttp=new XMLHttpRequest();//适用Firefox
	} 
	return xmlhttp;
}
var xmlhttp = createXMLHTTP();
var rand=0;//一个附加到url后的变量，让读取的url每次都不同以避免缓存
function getData(field)//参数分别为：项目id，放置数据的id，读取数据行数
{
	rand++;
	xmlhttp.open("get","export.php?rand="+rand+"&sid="+sid+"&field="+field+"&pageitem="+pageitem,false);
	xmlhttp.send(null);
//	xmlhttp.onreadystatechange = function() 
	{
//		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById(field).innerHTML=xmlhttp.responseText.rtrim();
		}
	}
}
function poll(field)
{
	if(is_IE)
	{
		document.frames('pkIframe').location='poll.php?sid='+sid+'&field='+field;
		getData(field);
	}
	else
	{
		document.getElementById('pkIframe').src='poll.php?sid='+sid+'&field='+field;
	}
	
}
function mysubmit(formId)
{
	eval('document.'+formId).action="export.php?sid="+sid;
	eval('document.'+formId).submit();
}
function clearForm()
{
	document.pkForm_l.title.value="";
	document.pkForm_r.title.value="";
	document.pkForm_c.title.value="";
	document.pkForm_l.content.value="";
	document.pkForm_r.content.value="";
	document.pkForm_c.content.value="";
}
function getAllData()
{
	getData('l_vote');
	getData('r_vote');
	getData('l_comm');
	getData('r_comm');
	getData('c_comm');
	getData('l_comment');
	getData('r_comment');
	getData('c_comment');
}
String.prototype.trim=function(){
return this.replace(/(^\s*)|(\s*$)/g, "");
}
String.prototype.ltrim=function(){
return this.replace(/(^\s*)/g,"");
}
String.prototype.rtrim=function(){
return this.replace(/(\s*$)/g,"");
}