<style>
.phone
{
	float:left;
}
</style>
<?
//include_once "session.php";
define('IN_MATCH', true);

$root_path="./../";
include_once($root_path."config.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/page.php");
include_once($root_path."dbtable.php");

include_once("left.php");//左边菜单

?>
<script language="javascript">
 
// global variables 
var timer;
var flag = new Array(1000);
var existingnum = new Array(1000);
var clicks = 0;
var randnum;
var cellnum =1;
var mobile = new Array();
// set data here!!
<?php
//$date_begin=mktime(14,0,0,date("m")-1,18,2007);//上月开始时间
//$date_end=mktime(0,0,0,date("m"),1,2007)-1;//上月结束时间
$date_begin=mktime(0,0,0,5,1,2007);
$date_end=mktime(14,0,0,5,16,2007);
$sql1="select feephone,addvote from poll_sms2 where status=1 and polltime>=".$date_begin." and polltime<=".$date_end;
$result1=$db->sql_query($sql1);
while($row=$db->sql_fetchrow($result1))
{
	$feephone=$row['feephone'];
	$addvote=$row['addvote'];
	$arr1[$feephone]+=$addvote;
}
arsort($arr1);
$i=0;
while(list($key,$val)=each($arr1))
{
	if($val>=25)
	{
		echo 'mobile['.$i.']=new Array();'."\r\n";
		echo 'mobile['.$i.'][0]='.$key.";\r\n";
		echo 'mobile['.$i.'][1]='.$val.";\r\n";
		$i++;
	}
}
?>
var num = mobile.length-1;
function getRandNum()
{
	GetRnd(0,num);
	if(mobile[randnum][0]!='13810004225')
	{
		if(clicks<=3)
		{
			if(mobile[randnum][1]==30)
			{
				document.getElementById("result").innerText = mobile[randnum][0];
			}
			else
			{
				getRandNum();
			}
		}
		else
		{
			document.getElementById("result").innerText = mobile[randnum][0];
		}
	}
	else
	{
		getRandNum();
	}
}

function GetRnd(min,max)
{
	randnum = parseInt(Math.random()*(max-min+1));
	return randnum;
}
function setTimer()
{
	clicks++;
	timer = setInterval("getRandNum();",10);
	document.getElementById("start").disabled = true;
	document.getElementById("end").disabled = false;
}
function clearTimer()
{
	noDupNum();
	clearInterval(timer);
	document.getElementById("start").disabled = false;
	document.getElementById("end").disabled = true;
}
function noDupNum()
{
	// to remove the selected mobile phone number
	mobile.removeEleAt(randnum);
	
	// to reorganize the mobile number array!!
	var o = 0;
	for(p=0; p<mobile.length;p++)
	{
		if(typeof mobile[p][0]!="undefined")
		{
			mobile[o][0] = mobile[p][0];
			mobile[o][1] = mobile[p][1];
			o++;
		}
	}
	num = mobile.length-1;
}
// method to remove the element in the array
Array.prototype.removeEleAt = function(dx)
{
	if(isNaN(dx)||dx>this.length)
	{
		return false;
	}
	this.splice(dx,1);
}
// set mobile phone numbers to the table cell 
function setValues()
{
	if(clicks==1)
	{
		document.getElementById(cellnum).innerText=document.getElementById("result").innerText='13810004225';
	}
	else if(clicks==2)
	{
		document.getElementById(cellnum).innerText=document.getElementById("result").innerText='13973681983';
	}
	else
	{
		document.getElementById(cellnum).innerText = document.getElementById("result").innerText;
	}
	cellnum++;
}
</script>

<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;padding:10px 0;">
<div>第二届美女博客大赛投票手机抽奖系统（5月上半月）</div>
总共有<?=$i?>个手机号供抽取
<div id="result" style="height:60px;width:400px;border:2px solid red;text-align:center;font-size:50px;line-height:50px;"></div>
<div style="padding:5px;">
<input id="start" type="button" value="开始" style="border: 1px solid; border-color: #aaa 000 #000 #aaa;width:4em; background: #fc0;" onclick="setTimer()" />
<input id="end" type="button" value="停" style="border: 1px solid; border-color: #aaa 000 #000 #aaa;width:4em; background: #fc0;"onclick="clearTimer();setValues();" disabled/>
</div>
<div>PSP奖（3名）(前两个号码是内部号码)</div>
<div style="width:630px;">
<?php
for($i=1;$i<=3;$i++)
{
	echo '<div class="phone" id="'.$i.'" style="margin:2px 4px;height:24px;width:200px;border:1px solid blue;font-size:20px;"></div>';
}
?>
</div>
<div style="padding-top:10px;">金猪奖（30名）</div>
<div style="width:630px;">
<?php
for(;$i<=33;$i++)
{
	echo '<div class="phone" id="'.$i.'" style="margin:2px 4px;height:24px;width:200px;border:1px solid blue;font-size:20px;"></div>';
}
?>
</div>
</div>
