/**
*�����û������Ƿ�Ϸ�
*/
var blogurl_err='';
function check()
{
	if(document.form1.realname.value=="")
	{
		alert("����д���Ƽ����������˵����֣�");
		document.form1.realname.focus();
		return false;
	}
	if(document.form1.cate_select.value=="")
	{
		alert("��ѡ���ʵ��ķ��࣡");
		return false;
	}
	if(document.form1.blogurl.value.length<8)
	{
		alert("����д���Ƽ��Ĳ��͵�ַ��");
		document.form1.blogurl.focus();
		return false;
	}
	if(document.form1.blogurl.value.length>7 && !isbokee(document.form1.blogurl.value))
	{
		alert("���Ƽ�����վ�Ĳ��͵�ַ��");
		document.form1.blogurl.focus();
		return false;
	}
	if(blogurl_err.length>0)
	{
		alert(blogurl_err);
		document.form1.blogurl.focus();
		return false;
	}
	if(document.form1.groupurl.value.length<=23)
	{
		alert("����д���Ƽ��Ĳ��͵�ַ��");
		document.form1.blogurl.focus();
		return false;
	}
	if(document.form1.photo.value=="")
	{
		alert("�������ύ��Ƭ��");
		document.form1.photo.focus();
		return false;
	}
	if(document.form1.photo.value!="")
	{
		var filename=document.form1.photo.value;
		var ext=filename.substring(filename.lastIndexOf('.')+1);
		if(ext!='jpg' && ext!='JPG' && ext!='jpeg' && ext!='JPEG' && ext!='gif' && ext!='GIF' && ext!='png' && ext!='PNG' && ext!='bmp' && ext!='BMP')
		{
			alert("���ύ����Ƭ��ʽ����!������jpg|jpeg|gif|png|bmp��ʽ��");
			document.form1.photo.focus();
			return false;
		}
	}
	return true;
}
/**
*����Ƿ񲩿��û�
*/
function isbokee(url)
{
	return (new RegExp(/^http:\/\/[_A-Za-z0-9]+\.((bokee.com)|(blogchina.com)|(blogdriver.com))(\/)?$/).test(url));
}
/**
*���blogurl
*/
function checkurl(field,url)
{
	if(field=='blogurl')
	{
		if(url.length>17 && isbokee(url))//��̵�������http://a.bokee.com�����ַ�������18
		{
			document.getElementById('iframe1').src='checkurl.php?blogurl='+url;
		}
		else
		{
			showMsg('blogurl_msg','<b style="color:#F33;">�������ַ���ǲ������ĸ��˲��ͣ�</b>');
		}
	}
	if(field=='groupurl')
	{
		if(url.length>23 && url!='http://group.bokee.com/?')
		{
			document.getElementById('iframe1').src='checkurl.php?groupurl='+url;
		}
		else
		{
			showMsg('groupurl_msg','<b style="color:#F33;">������Ⱥ���ַ��ʽ����ȷ��</b>');
		}
	}
}
/**
*��ʾ��ʾ��Ϣ
*/
function showMsg(id,code)
{
	switch (code)
	{
	case 0:
		str='<b style="color:#96F;">���˲��͵�ַ���Ա��Ƽ���</b>';
		break;
	case 1:
		str='<b style="color:#F33;">���˲��͵�ַ�Ѿ����Ƽ���</b>';
		break;
	case 2:
		str='<b style="color:#96F;">����Ⱥ���ַ���Ա��Ƽ���</b>';
		break;
	case 3:
		str='<b style="color:#F33;">����Ⱥ���ַ�Ѿ����Ƽ���</b>';
		break;
	default:
		str=code;
	}
	document.getElementById(id).innerHTML=str;
	return;
}
function setErr(code)//������ύ��ťʱ��Ҫ����˱���
{
	switch (code)
	{
	case 0:
		form_err='';
		break;
	case 1:
		form_err='����д�Ĳ��͵�ַ�Ѿ����Ƽ���,�����ظ��Ƽ���';
		break;
	case 2:
		form_err='����д��Ⱥ���ַ�Ѿ����Ƽ��ˣ������ظ��Ƽ���';
	}
	
}