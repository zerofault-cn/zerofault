function createXMLHTTP() {
	var XMLHTTP=null;
	try {
		XMLHTTP=new ActiveXObject("Msxml2.XMLHTTP");//  ”√IE
	}
	catch(e) {
		try {
			XMLHTTP=new ActiveXObject("Microsoft.XMLHTTP");//  ”√IE
		}
		catch(oc) {
			XMLHTTP=null;
		}
	}
	if ( !XMLHTTP && typeof XMLHttpRequest != "undefined" ) { 
		XMLHTTP=new XMLHttpRequest();//  ”√Firefox
	} 
	return XMLHTTP;
}
var xmlhttp = createXMLHTTP();
var i=0;
var page=1;
function getData(f)
{
	i++;
	xmlhttp.open("get","/pkexport/export.php?i="+i+"&sid="+sid+"&field="+f+"&getall="+getall+"&page="+page+"&pageitem="+pageitem,false);
	xmlhttp.send(null);
	document.getElementById(f).innerHTML = xmlhttp.responseText.rtrim();
}
function poll(f)
{
	i++;
	xmlhttp.open("get","/pkexport/poll.php?i="+i+"&sid="+sid+"&field="+f,false);
	xmlhttp.send(null);
	document.getElementById(f).innerHTML = xmlhttp.responseText;
}
function mysubmit(formId)
{
	i++;
	eval('document.'+formId).action='/pkexport/export.php?i='+i+'&sid='+sid;
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