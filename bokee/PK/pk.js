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