var timerID = null;
var timerRunning = false;

function stopclock ()
{
	if(timerRunning)
		clearTimeout(timerID);
	timerRunning = false;
}
function startclock () 
{
	stopclock();
	showtime();
}

function showtime () 
{
	var now = new Date();
	var years = now.getYear();
	if(navigator.appName=='Netscape')
	{
		years=years+1900;
	}
	var months = now.getMonth();
	var dates = now.getDate();
	var hours = now.getHours();//调整时区
	var minutes = now.getMinutes();
	var seconds=now.getSeconds();
	var timeValue = years;
	timeValue += ((months+1 < 10) ? "-0" : "-") + (months+1);
	timeValue += ((dates < 10) ? "-0" : "-") + dates;
	timeValue += ((hours < 10) ? " 0" : " ") + hours;
	timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
	timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
	realtimespan=document.getElementById('realtime');
	realtimespan.innerHTML=timeValue;
	timerID = setTimeout("showtime()",1000);
	timerRunning = true;
}
 //startclock();