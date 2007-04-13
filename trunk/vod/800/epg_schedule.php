<?
include "../include/db_connect.php";
$weekday=array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
$sql1="select station_name from epg_station where station_id='".$station_id."'";
$result1=$db->sql_query($sql1);
$station=$db->sql_fetchfield(0,0,$result1);
$today=date("Ymd");
$nowyear=date("Y");
$nowmonth=date("m");
$nowday=date("d");
$nowweek=date("w");
if(!isset($week)||$week=="")
{
	$week=$nowweek;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>节目单</title>
<link rel="stylesheet" href="style.css" type="text/css">

<script language="JavaScript" type="text/JavaScript">
function onfoc(n)
{
	t1 = document.getElementById(n);
	dat = t1.innerHTML;
	dat = dat.substring(0,dat.indexOf("</td>"));
	dat = dat.substring(dat.lastIndexOf(">") + 1);
	t1.innerHTML = '<td height=53 align=center class=style30b bgcolor=#3366FF style="color:#feef00">' + dat + '</td>';
	
}

var week=<?=$week?>;
function keyDown(e)
{
	var keycode=e.which;
	var key1=keycode-48;
	if(keycode==70)//播放键"F"
	{
		location="<?=$path?>";
	}
	if(keycode==38)
	{
		week=week-1;
		if(week<0)
			week=6;
		location = "?type=<?=$type?>&staOffset=<?=$staOffset?>&station_id=<?=$station_id?>&week="+week;
	}
	if(keycode==40)
	{
		week=week+1;
		if(week>6)
			week=0;
		location = "?type=<?=$type?>&staOffset=<?=$staOffset?>&station_id=<?=$station_id?>&week="+week;
	}
	var patern=/^[0-6]$/; 
	if(patern.exec(key1)) 
	{
		location = "?type=<?=$type?>&staOffset=<?=$staOffset?>&station_id=<?=$station_id?>&week="+key1;
	}
	if(keycode==36)
	{
		location ="epg_station.php?type=<?=$type?>&offset=<?=$staOffset?>&station_id=<?=$station_id?>";
	}
}    

document.onkeydown=keyDown
</script>

</head>

<body leftMargin=0 topMargin=0 background="image/epg/tv_schedule.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(<?=$week?>)">
<table width="800" height="590" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width=20 height=15></td>
	<td width=760><?include "top.php";?></td>
	<td width=20></td>
</tr>

<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="37" height="162">&nbsp;</td>
		<td width="160">&nbsp;</td>
		<td width="10">&nbsp;</td>
		<td width="448">&nbsp;</td>
		<td width="105">&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td valign="top">
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr id=0>
			<td height=53 align=center class=style30b>星期日</td>
		</tr>
		<tr id=1>
			<td height=53 align=center class=style30b>星期一</td>
		</tr>
		<tr id=2>
			<td height=53 align=center class=style30b>星期二</td>
		</tr>
		<tr id=3>
			<td height=53 align=center class=style30b>星期三</td>
		</tr>
		<tr id=4>
			<td height=53 align=center class=style30b>星期四</td>
		</tr>
		<tr id=5>
			<td height=53 align=center class=style30b>星期五</td>
		</tr>
		<tr id=6>
			<td height=53 align=center class=style30b>星期六</td>
		</tr>
		</table></td>
        <td></td>
        <td align=center class=30w>
		<?
		$r="";
		$tmpday=$nowday-($nowweek-$week);
		if(strlen($tmpday)<2)
		{
			$tmpday='0'.$tmpday;
		}
		$newdate=$nowyear.$nowmonth.$tmpday;//初始值不考虑跨月份得情况
		if($tmpday<1)//考虑昨天可能是上个月或者去年
		{
			$newmonth=$nowmonth-1;
			if(strlen($newmonth)<2)
			{
				$newmonth='0'.$newmonth;
			}
			if($newmonth==1||$newmonth==3||$newmonth==5||$newmonth==7||$newmonth==8||$newmonth==10)
			{
				$newdate=$nowyear.$newmonth.(31+$nowday-($nowweek-$week));
			}
			if($newmonth==4||$newmonth==6||$newmonth==9||$newmonth==11)
			{
				$newdate=$nowyear.$newmonth.(30+$nowday-($nowweek-$week));
			}
			if($newmonth==2)
			{
				if($nowyear%4!=0||($nowyear%100==0&&$nowyear%400!=0))
				{
					$newdate=$nowyear.$newmonth.(28+$nowday-($nowweek-$week));
				}
				else
				{
					$newdate=$nowyear.$newmonth.(29+$nowday-($nowweek-$week));
				}
			}
			if($newmonth==0)
			{
				$newdate=($nowyear-1).'12'.(31+$nowday-($nowweek-$week));
			}
		}
		if($nowmonth==2)//除此之外考虑今天的明天是否跨月或者跨年
		{
			if($nowyear%4!=0||($nowyear%100==0&&$nowyear%400!=0))
			{
				if($tmpday>28)
				{
					$newdate=$nowyear.'030'.($nowday-28-($nowweek-$week));
				}
			}
			elseif($tmpday>29)
			{
				$newdate=$nowyear.'030'.($nowday-29-($nowweek-$week));
			}
		}
		elseif($nowmonth==1||$nowmonth==3||$nowmonth==5||$nowmonth==7||$nowmonth==8||$nowmonth==10)
		{
			if($tmpday>31)
			{
				$newmonth=$nowmonth+1;
				if(strlen($newmonth)<2)
				{
					$newmonth='0'.$newmonth;
				}
				$newdate=$nowyear.$newmonth.'0'.($nowday-31-($nowweek-$week));
			}
		}
		elseif($nowmonth==12)
		{
			if($tmpday>31)
			{
				$newdate=($nowyear+1).'010'.($nowday-31-($nowweek-$week));
			}
		}
		elseif($tmpday>30)
		{
			$newmonth=$nowmonth+1;
			if(strlen($newmonth)<2)
			{
				$newmonth='0'.$newmonth;
			}
			$newdate=$nowyear.$newmonth.'0'.($nowday-30-($nowweek-$week));
		}
		$sql2="select program,date from epg_schedule where station_id='".$station_id."' and date='".$newdate."'";
		$result2=$db->sql_query($sql2);
		if($row=$db->sql_fetchrow($result2))
		{
			?>
			<marquee direction="up" loop=-1 behavior="scroll" dataformatas="html" width="440" height="370" scrolldelay="0" scrollamount="1" border="1">
			<table width="100%" border=0 class="style30w" >
			<caption class="style30w" style="color:#ffffff">《<?=$station?>》<?=$weekday[$week]?>节目单&nbsp;</caption>
			<tr>
				<td colspan=2><hr size="0.5" width="80%"></td>
			</tr>
			<tr>
				<td style="line-height:1.5em"><?=$row[1]?></td>
			</tr>
			<tr>
				<td style="line-height:1.5em"><?=$row[0]?></td>
			</tr>
			<tr>
				<td colspan=2><hr size="0.5" width="80%"></td>
			</tr>
			</table>
			</marquee>
			<?
		}
		else
		{
			echo "暂时没有节目单";
		}
		?>
		</td>
        <td></td>
      </tr>
    </table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td>&nbsp;</td>
</tr>
</table>
</body>
</html>
