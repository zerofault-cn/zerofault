function go_birthday()
{
	var year=window.document.date.year.value;
	var month=window.document.date.month.value;
	var day=window.document.date.day.value;
	if((month==8&&day==7)||(month==10&&day==26)||(month==12&&day==11))
	{
		alert("������˼,"+month+"��"+day+"�յ��������뻹û���ռ���!");
		document.date.day.focus();
		return false;
	}
	if((month==4||month==6||month==9||month==11)&&day==31)
	{
		alert(month+"�º���û��"+day+"��Ŷ!");
		document.date.day.focus();
		return false;
	}
	if(month==2)
	{
		if((year%4>0||(year%100==0&&year%400>0))&&day>28)
		{
			alert(year+"���2�º��������°�!");
			document.date.day.focus();
			return false;
		}
	}
	var newwindow="/astrology/birthday/"+month+"_"+day+".htm";
	window.open(newwindow,"","");
}
function go_astro()
{
	var year=window.document.date.year.value;
	var month=window.document.date.month.value;
	var day=window.document.date.day.value;
	if((month==4||month==6||month==9||month==11)&&day==31)
	{
		alert(month+"�º���û��"+day+"��Ŷ!");
		document.date.day.focus();
		return false;
	}
	if(month==2)
	{
		if((year%4>0||(year%100==0&&year%400>0))&&day>28)
		{
			alert(year+"���2�º���ֻ��28���!");
			document.date.day.focus();
			return false;
		}
	}
	
	if(day.length<2)
	{
		day="0"+day;
	}
	var birth=month+day;
	if(birth<=119)
	{
		var astro="ħ���� Capricorn (12/22 - 01/19)";
		var link="http://astro.sina.com.cn/capricorn.html";
	}
	else if(birth<=218)
	{
		var astro="ˮƿ�� Aquarius (01/20 - 02/18)";
		var link="http://astro.sina.com.cn/aquarius.html";
	}
	else if(birth<=320)
	{
		var astro="˫���� Pisces (02/19 - 03/20)";
		var link="http://astro.sina.com.cn/pisces.html";
	}
	else if(birth<=419)
	{
		var astro="������ aries (03/21 - 04/19)";
		var link="http://astro.sina.com.cn/aries.html";
	}
	else if(birth<=520)
	{
		var astro="��ţ�� Taurus (04/20 - 05/20)";
		var link="http://astro.sina.com.cn/taurus.html";
	}
	else if(birth<=621)
	{
		var astro="˫���� Gemini (05/21 - 06/21)";
		var link="http://astro.sina.com.cn/gemini.html";
	}
	else if(birth<=722)
	{
		var astro="��з�� Cancer (06/22 - 07/22)";
		var link="http://astro.sina.com.cn/cancer.html";
	}
	else if(birth<=822)
	{
		var astro="ʨ���� Leo (07/23 - 08/22)";
		var link="http://astro.sina.com.cn/leo.html";
	}
	else if(birth<=922)
	{
		var astro="��Ů�� Virgo (08/23 - 09/22)";
		var link="http://astro.sina.com.cn/virgo.html";
	}
	else if(birth<=1023)
	{
		var astro="����� Libra (09/23 - 10/23)";
		var link="http://astro.sina.com.cn/libra.html";
	}
	else if(birth<=1122)
	{
		var astro="��Ы�� Scorpio (10/24 - 11/22)";
		var link="http://astro.sina.com.cn/scorpio.html";
	}
	else if(birth<=1221)
	{
		var astro="������ Sagittarius (11/23 - 12/21)";
		var link="http://astro.sina.com.cn/sagittarius.html";
	}
	else
	{
		var astro="ħ���� Capricorn (12/22 - 01/19)";
		var link="http://astro.sina.com.cn/capricorn.html";
	}
	
	if(confirm("�鿴"+month+"/"+day+astro+"�����˳�?"))
	{
		window.open(link,"","");
	}
	else return;
}