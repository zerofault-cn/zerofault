function check()
{
	if(document.form2.content.value.length<2)
	{
		alert("������������̫�̣�");
		document.form2.content.focus();
		return false;
	}
	if(document.form2.content.value=='{LASTCONTENT}')
	{
		alert("�벻Ҫ�ظ�����!");
		document.form2.content.focus();
		return false;
	}
	if(isstart=='true' && time2>0)
	{
		alert("������Ҳ̫���˰�!");
		return false;
	}
}

var time2=60;//�趨�䶳ʱ��,�ڴ�ʱ���ڲ����ύ����
var isstart='{ISSTART}';
function start()
{
	if (time2<0)
	{
		time2=0;
	//	document.form2.submit.value='�ύ';
	//	document.form2.submit.disabled=false;
	}
	else
	{
	//	document.form2.submit.value=time2+'����ύ';
	//	document.form2.submit.disabled=true;
	}
	time2--;
	setTimeout("start()",1000);
}
function startif()
{
	if(isstart=='true')
	{
		start();
	}
}