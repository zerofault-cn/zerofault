var xmlhttp=null;
function createXMLHTTP() {
	try {
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");//����IE
	}
	catch(e) {
		try {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");//����IE
		}
		catch(oc) {
			xmlhttp=null;
		}
	}
	if ( !xmlhttp && typeof XMLHttpRequest != "undefined" ) { 
		xmlhttp=new XMLHttpRequest();//����Firefox
	} 
	return xmlhttp;
}
xmlhttp = createXMLHTTP();
var rand=0;//һ�����ӵ�url��ı������ö�ȡ��urlÿ�ζ���ͬ�Ա��⻺��
function getData(sid,field,pageitem)//�����ֱ�Ϊ����Ŀid���������ݵ�id����ȡ��������
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
//	alert('�ύ�ɹ�');
	clearForm(field);
	getData(field);
}
