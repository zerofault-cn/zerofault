function go_birthday()
{
	var year=window.document.date.year.value;
	var month=window.document.date.month.value;
	var day=window.document.date.day.value;
	if((month==8&&day==7)||(month==10&&day==26)||(month==12&&day==11))
	{
		alert("不好意思,"+month+"月"+day+"日的生日密码还没有收集到!");
		document.date.day.focus();
		return false;
	}
	if((month==4||month==6||month==9||month==11)&&day==31)
	{
		alert(month+"月好像没有"+day+"号哦!");
		document.date.day.focus();
		return false;
	}
	if(month==2)
	{
		if((year%4>0||(year%100==0&&year%400>0))&&day>28)
		{
			alert(year+"年的2月好像不是闰月吧!");
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
		alert(month+"月好像没有"+day+"号哦!");
		document.date.day.focus();
		return false;
	}
	if(month==2)
	{
		if((year%4>0||(year%100==0&&year%400>0))&&day>28)
		{
			alert(year+"年的2月好像只有28天吧!");
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
		var astro="魔羯座 Capricorn (12/22 - 01/19)";
		var link="http://astro.sina.com.cn/capricorn.html";
	}
	else if(birth<=218)
	{
		var astro="水瓶座 Aquarius (01/20 - 02/18)";
		var link="http://astro.sina.com.cn/aquarius.html";
	}
	else if(birth<=320)
	{
		var astro="双鱼座 Pisces (02/19 - 03/20)";
		var link="http://astro.sina.com.cn/pisces.html";
	}
	else if(birth<=419)
	{
		var astro="白羊座 aries (03/21 - 04/19)";
		var link="http://astro.sina.com.cn/aries.html";
	}
	else if(birth<=520)
	{
		var astro="金牛座 Taurus (04/20 - 05/20)";
		var link="http://astro.sina.com.cn/taurus.html";
	}
	else if(birth<=621)
	{
		var astro="双子座 Gemini (05/21 - 06/21)";
		var link="http://astro.sina.com.cn/gemini.html";
	}
	else if(birth<=722)
	{
		var astro="巨蟹座 Cancer (06/22 - 07/22)";
		var link="http://astro.sina.com.cn/cancer.html";
	}
	else if(birth<=822)
	{
		var astro="狮子座 Leo (07/23 - 08/22)";
		var link="http://astro.sina.com.cn/leo.html";
	}
	else if(birth<=922)
	{
		var astro="处女座 Virgo (08/23 - 09/22)";
		var link="http://astro.sina.com.cn/virgo.html";
	}
	else if(birth<=1023)
	{
		var astro="天秤座 Libra (09/23 - 10/23)";
		var link="http://astro.sina.com.cn/libra.html";
	}
	else if(birth<=1122)
	{
		var astro="天蝎座 Scorpio (10/24 - 11/22)";
		var link="http://astro.sina.com.cn/scorpio.html";
	}
	else if(birth<=1221)
	{
		var astro="射手座 Sagittarius (11/23 - 12/21)";
		var link="http://astro.sina.com.cn/sagittarius.html";
	}
	else
	{
		var astro="魔羯座 Capricorn (12/22 - 01/19)";
		var link="http://astro.sina.com.cn/capricorn.html";
	}
	
	if(confirm("查看"+month+"/"+day+astro+"今日运程?"))
	{
		window.open(link,"","");
	}
	else return;
}