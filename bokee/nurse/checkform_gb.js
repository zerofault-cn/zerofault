/**
*�����û��Ƿ�������,�����Ƿ�Ϸ�
*/
function check()
{
	fields=document.getElementsByTagName("input");
	for(i=0;i<fields.length;i++)
	{
		val=fields[i].getAttribute('name');
		ckValue=fields[i].getAttribute('ckName');
		if(ckValue!=null)
		{
			if(ckValue=='�������ӵ�ַ' && !isBokee(fields[i].value))
			{
				alert('����ȷ��д���Ĳ��͵�ַ��');
				document.form1.blogurl.focus();
				return false;
			}
			if(ckValue=='��������' && fields[i].value=='')
			{
				alert('��ѡ��˸�����������һ����');
				document.form1.select_area.focus();
				return false;
			}
			if(fields[i].value=='')
			{
				alert(ckValue+'����Ϊ�գ�');
				eval('document.form1.'+val).focus();
				return false;
			}
			else if(t(val+'_tip').className=='tip_err')
			{
				alert(t(val+'_tip').innerHTML);
				return false;
			}
		}
		else
		{
			continue;
		}
	}
	return true;
}

/**
*�����ʼ���ַ�Ƿ�Ϸ�
*/
function isEmail(mail) 
{
	return(new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail)); 
}
/**
*����Ƿ񲩿��û�
*/
function isGroup(url)
{
	return (new RegExp(/^http:\/\/group.bokee.com\/[A-Za-z0-9]+$/).test(url));
}
/**
*����Ƿ񲩿��û�
*/
function isBokee(url)
{
	return (new RegExp(/^http:\/\/[_A-Za-z0-9]+\.((bokee.com)|(blogchina.com)|(blogdriver.com))(\/)?$/).test(url));
}
/**
*����Ƿ�Ϸ��绰����
*/
function isPhone(num)
{
	return (new RegExp(/^((0(\d{2,3})[_\-��]?(\d{7,8}))|(1[35](\d{9})))$/).test(num));
	//����Ҫ��������ţ�������Բ��������ţ���������д��/^((0\d{2,3})|(0\d{2,3}-))?[1-9]\d{6,7}$/
	//�������ֻ����ж�,�����������ţ�������0��ͷ���ֻ�������13��15��ͷ
}
var xmlhttp = createXMLHTTP();
function foc(obj)
{
	var val=obj.getAttribute('name');
	switch (val)
	{
	case 'blogname':
		tips='����д��ѡ�������ƣ�';
		break;
	case 'blogurl':
		tips='����д�������ĸ��˲��͵�ַ��';
		break;
	case 'realname':
		tips='����д������ʵ������';
		break;
	case 'hospital':
		tips='����д�����ڵ�ҽԺ���ƣ�';
		break;
	case 'phone':
		tips='�����ŵ������Ż����ֻ��ţ�';
		break;
	case 'email':
		tips='����д����õ�E-mail��';
		break;
	}
	t(val+'_tip').style.display='';
	t(val+'_tip').className='tip';
	t(val+'_tip').innerHTML=tips;
}
function blu(obj)
{
	var val=obj.getAttribute('name');
	if(obj.value=='')
	{
	//	foc(obj);
		t(val+'_tip').style.display='none';
		return;
	}
	switch (val)
	{
	case 'blogname':
		if(obj.value.length<2)
		{
			t(val+'_tip').className='tip_err';
			tips='��������̫�̣�';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='�����������Ҫ��';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'blogurl':
		if(!isBokee(obj.value))
		{
			t(val+'_tip').className='tip_err';
			tips='������Ĳ��ǲ������ĸ��˲��͵�ַ��';
		}
		else
		{
			t(val+'_tip').style.display='';
			t(val+'_tip').className='tip_loading';
			t(val+'_tip').innerHTML=tips='������֤��ַ�Ƿ��ѱ�����';
			try
			{
				res=checkUrl(obj.value);
				if(res=='ok')
				{
					t(val+'_tip').className='tip_ok';
					tips='���͵�ַ��δ������';
					setTimeout("hidden_tip('"+val+"')",2000);
				}
				else
				{
					t(val+'_tip').className='tip_err';
					tips='��Ǹ��������Ĳ��͵�ַ�Ѿ�������';
				}
			}
			catch (e)
			{
				t(val+'_tip').className='tip_err';
				tips='��֤ʧ�ܣ�';
			}
		}
		break;
	case 'realname':
		if(obj.value.length<2)
		{
			t(val+'_tip').className='tip_err';
			tips='�����������̫�̣�';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='�����������Ҫ��';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'hospital':
		if(obj.value.length<2)
		{
			t(val+'_tip').className='tip_err';
			tips='�����������̫�̣�';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='�����������Ҫ��';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'phone':
		if(obj.value.length<10)
		{
			t(val+'_tip').className='tip_err';
			tips='���ĺ���̫�̣�������ǰ��������ţ�';
		}
		else if(!isPhone(obj.value))
		{
			t(val+'_tip').className='tip_err';
			tips='���������ϵ�绰���벻�Ϸ���';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='�����������Ҫ��';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'email':
		if(!isEmail(obj.value))
		{
			t(val+'_tip').className='tip_err';
			tips='����д�Ĳ���E-mail��ַ��';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='�����������Ҫ��';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	}
	t(val+'_tip').style.display='';
	t(val+'_tip').innerHTML=tips;
}
function hidden_tip(val)
{
	t(val+'_tip').style.display='none';
}
/**
*���blogurl
*/
function checkUrl(url)
{
	xmlhttp.open("get","signup.php?action=checkUrl&url="+url+"&"+Math.random(),false);
	xmlhttp.send(null);
//	alert(xmlhttp.responseText.rtrim());
	return str=xmlhttp.responseText.rtrim();
}
function createXMLHTTP() {
	var XMLHTTP=null;
	try {
		XMLHTTP=new ActiveXObject("Msxml2.XMLHTTP");//����IE
	}
	catch(e) {
		try {
			XMLHTTP=new ActiveXObject("Microsoft.XMLHTTP");//����IE
		}
		catch(oc) {
			XMLHTTP=null;
		}
	}
	if ( !XMLHTTP && typeof XMLHttpRequest != "undefined" ) { 
		XMLHTTP=new XMLHttpRequest();//����Firefox
	} 
	return XMLHTTP;
}
function t(obj)
{
	return document.getElementById(obj);
}
String.prototype.rtrim=function()
{
	return this.replace(/(\s*$)/g,"");
}