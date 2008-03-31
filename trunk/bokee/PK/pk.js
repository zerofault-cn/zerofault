function createXMLHTTP() {
	var XMLHTTP=null;
	try {
		XMLHTTP=new ActiveXObject("Msxml2.XMLHTTP");//适用IE
	}
	catch(e) {
		try {
			XMLHTTP=new ActiveXObject("Microsoft.XMLHTTP");//适用IE
		}
		catch(oc) {
			XMLHTTP=null;
		}
	}
	if ( !XMLHTTP && typeof XMLHttpRequest != "undefined" ) {
		XMLHTTP=new XMLHttpRequest();//适用Firefox
	}
	return XMLHTTP;
}

var xmlhttp = createXMLHTTP();
var page=1;
function getData(f)
{
	xmlhttp.open("get","export.php?sid="+sid+"&field="+f+"&getall="+getall+"&page="+page+"&pageitem="+pageitem+"&"+Math.random(),false);
	xmlhttp.send(null);
//	alert(xmlhttp.responseText);
	document.getElementById(f).innerHTML = xmlhttp.responseText.rtrim();
}
function poll(f)
{
	xmlhttp.open("get","poll.php?sid="+sid+"&field="+f+"&"+Math.random(),false);
	xmlhttp.send(null);
	document.getElementById(f).innerHTML = xmlhttp.responseText;
}
function mysubmit(formId)
{
	if(eval('document.'+formId).content.value.length<2)
	{
		alert('评论内容太短了！');
		eval('document.'+formId).content.focus();
		return false;
	}
	eval('document.'+formId).action='export.php?sid='+sid+"&"+Math.random();
	eval('document.'+formId).submit();
}
function clearForm()
{
	for(i=0;i<document.forms.length;i++)
	{
		if(document.forms[i].name=='pkForm_l' || document.forms[i].name=='pkForm_r' || document.forms[i].name=='pkForm_c')
		{
			document.forms[i].title.value="";
			document.forms[i].content.value="";
		}
	}
}
function getAllData()
{
	if(document.getElementById('l_vote')!=null)
	{
		getData('l_vote');
	}
	if(document.getElementById('r_vote')!=null)
	{
		getData('r_vote');
	}
	if(document.getElementById('l_comm')!=null)
	{
		getData('l_comm');
	}
	if(document.getElementById('r_comm')!=null)
	{
		getData('r_comm');
	}
	if(document.getElementById('c_comm')!=null)
	{
		getData('c_comm');
	}
	if(document.getElementById('l_comment')!=null)
	{
		getData('l_comment');
	}
	if(document.getElementById('r_comment')!=null)
	{
		getData('r_comment');
	}
	if(document.getElementById('c_comment')!=null)
	{
		getData('c_comment');
	}
}
function getMiniData()
{
	getData('l_vote');
	getData('r_vote');
}
String.prototype.rtrim=function()
{
	return this.replace(/(\s*$)/g,"");
}
//getAllData();
function load()
{
	if(document.all){//IE使用
		window.attachEvent('onload',getAllData)
	}
	else{//FF使用
		window.addEventListener('load',getAllData,false);
	}
}
