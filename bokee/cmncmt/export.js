function createXMLHTTP() { 
	var xmlhttp=null; 
	try { 
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	} 
	catch(e) { 
		try { 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch(oc) { 
			xmlhttp=null;
		} 
	} 

	if ( !xmlhttp && typeof XMLHttpRequest != "undefined" ) { 
		xmlhttp=new XMLHttpRequest();
	} 
	return xmlhttp;
} 
var xmlhttp = createXMLHTTP();
var i=0;
var page=1;
function getData()
{
	i++;
	//sid,pageitem,gatall����������htmlҳ���г�ʼ��
	//page��url��ֵ
	xmlhttp.open("get","/cmncmt/export.php?sid="+sid+"&page="+page+"&pageitem="+pageitem+"&getall="+getall+"&i="+i, false);
	xmlhttp.send(null);
//	xmlhttp.onreadystatechange = function() 
	{
//		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById('comment').innerHTML=xmlhttp.responseText;
		}
	}
}
function mysubmit()
{
	document.commentForm.action="/cmncmt/export.php?sid="+sid;
	document.commentForm.submit();
}
function clearForm()
{
	document.commentForm.content.value="";
}
function alertOK()
{
//	alert('�ύ�ɹ�');
	clearForm();
	getData();
}
getData();
