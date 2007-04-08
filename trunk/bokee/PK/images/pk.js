var xmlhttp=null;
function createXMLHTTP() {
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
xmlhttp = createXMLHTTP();
var rand=0;//一个附加到url后的变量，让读取的url每次都不同以避免缓存
function getData(sid,field,pageitem)//参数分别为：项目id，放置数据的id，读取数据行数
{
	rand++;
	xmlhttp.open("get","pkExport/export.php?rand="+rand+"&sid="+sid+"&field="+filed+"&pageitem="+pageitem, false);
	xmlhttp.send(null);
	xmlhttp.onreadystatechange = function() 
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById(field).innerHTML=xmlhttp.responseText;
		}
	}
}
function clearForm(field)
{
	eval('document.pkForm_'.field).title.value="";
	eval('document.pkForm_'.field).content.value="";
}
function alertOK(side)
{
//	alert('提交成功');
	clearForm(field);
	getData(field);
}
