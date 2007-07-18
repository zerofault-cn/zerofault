/**
*检验用户是否已输入,输入是否合法
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
			if(ckValue=='博客链接地址' && !isBokee(fields[i].value))
			{
				alert('请正确填写您的博客地址！');
				document.form1.blogurl.focus();
				return false;
			}
			if(ckValue=='报名赛区' && fields[i].value=='')
			{
				alert('请选择八个赛区中任意一个！');
				document.form1.select_area.focus();
				return false;
			}
			if(fields[i].value=='')
			{
				alert(ckValue+'不能为空！');
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
*检验邮件地址是否合法
*/
function isEmail(mail) 
{
	return(new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail)); 
}
/**
*检查是否博客用户
*/
function isGroup(url)
{
	return (new RegExp(/^http:\/\/group.bokee.com\/[A-Za-z0-9]+$/).test(url));
}
/**
*检查是否博客用户
*/
function isBokee(url)
{
	return (new RegExp(/^http:\/\/[_A-Za-z0-9]+\.((bokee.com)|(blogchina.com)|(blogdriver.com))(\/)?$/).test(url));
}
/**
*检查是否合法电话号码
*/
function isPhone(num)
{
	return (new RegExp(/^((0(\d{2,3})[_\-－]?(\d{7,8}))|(1[35](\d{9})))$/).test(num));
	//这里要求包含区号，如果可以不包含区号，可以这样写：/^((0\d{2,3})|(0\d{2,3}-))?[1-9]\d{6,7}$/
	//后面是手机号判断,座机（含区号）必须以0开头，手机必须以13或15开头
}
var xmlhttp = createXMLHTTP();
function foc(obj)
{
	var val=obj.getAttribute('name');
	switch (val)
	{
	case 'blogname':
		tips='请填写参选博客名称！';
		break;
	case 'blogurl':
		tips='请填写博客网的个人博客地址！';
		break;
	case 'realname':
		tips='请填写您的真实姓名！';
		break;
	case 'hospital':
		tips='请填写您所在的医院名称！';
		break;
	case 'phone':
		tips='带区号的座机号或者手机号！';
		break;
	case 'email':
		tips='请填写您最常用的E-mail！';
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
			tips='您的输入太短！';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='您的输入符合要求！';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'blogurl':
		if(!isBokee(obj.value))
		{
			t(val+'_tip').className='tip_err';
			tips='您输入的不是博客网的个人博客地址！';
		}
		else
		{
			t(val+'_tip').style.display='';
			t(val+'_tip').className='tip_loading';
			t(val+'_tip').innerHTML=tips='正在验证地址是否已报名！';
			try
			{
				res=checkUrl(obj.value);
				if(res=='ok')
				{
					t(val+'_tip').className='tip_ok';
					tips='博客地址尚未报名！';
					setTimeout("hidden_tip('"+val+"')",2000);
				}
				else
				{
					t(val+'_tip').className='tip_err';
					tips='抱歉，您输入的博客地址已经报名！';
				}
			}
			catch (e)
			{
				t(val+'_tip').className='tip_err';
				tips='验证失败！';
			}
		}
		break;
	case 'realname':
		if(obj.value.length<2)
		{
			t(val+'_tip').className='tip_err';
			tips='你输入的姓名太短！';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='您的输入符合要求！';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'hospital':
		if(obj.value.length<2)
		{
			t(val+'_tip').className='tip_err';
			tips='你输入的名称太短！';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='您的输入符合要求！';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'phone':
		if(obj.value.length<10)
		{
			t(val+'_tip').className='tip_err';
			tips='您的号码太短，座机号前必须带区号！';
		}
		else if(!isPhone(obj.value))
		{
			t(val+'_tip').className='tip_err';
			tips='您输入的联系电话号码不合法！';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='您的输入符合要求！';
			setTimeout("hidden_tip('"+val+"')",2000);
		}
		break;
	case 'email':
		if(!isEmail(obj.value))
		{
			t(val+'_tip').className='tip_err';
			tips='您填写的不是E-mail地址！';
		}
		else
		{
			t(val+'_tip').className='tip_ok';
			tips='您的输入符合要求！';
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
*检查blogurl
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
function t(obj)
{
	return document.getElementById(obj);
}
String.prototype.rtrim=function()
{
	return this.replace(/(\s*$)/g,"");
}