<?
function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
include "color.inc.php";
mysql_connect('localhost','dba','sql');
mysql_select_db('skype_db');
$offset=0;
$pageitem=9;
$col=2;
$sql1="select group_account,group_name,group_desc from group_info where group_id=".$group_id;
$result1=mysql_query($sql1);
$group_account	=mysql_result($result1,0,0);
$group_name		=mysql_result($result1,0,1);
$group_desc		=mysql_result($result1,0,2);
$sql2="select user_account,user_name,user_skype,user_status,user_status2 from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id order by member_id";
$group_user='';
$result2=mysql_query($sql2);
$num=mysql_num_rows($result2);
while($r2=mysql_fetch_array($result2))
{
	$tmp_account	=$r2['user_account'];
	$tmp_name		=$r2['user_name'];
	if(''==$tmp_name)
	{
		$tmp_name=$tmp_account;
	}
	$user_account[]	=$tmp_account;
	$user_name[]	=$tmp_name;
	$user_skype		=$r2['user_skype'];
	$user_status	=$r2['user_status'];
	$user_status2	=$r2['user_status2'];
	switch($user_status)
	{
		case "UNKNOWN":
			$tmp_user_status_pic='6.gif';
			break;
		case "ONLINE":
			$tmp_user_status_pic='1.gif';
			break;
		case "SKYPEME":
			$tmp_user_status_pic='9.gif';
			break;
		case "OFFLINE":
			$tmp_user_status_pic='2.gif';
			break;
		case "AWAY":
			$tmp_user_status_pic='3.gif';
			break;
		case "NA":
			$tmp_user_status_pic='6.gif';
			break;
		case "DND":
			$tmp_user_status_pic= '3.gif';
			break;
		case "INVISIBLE":
			$tmp_user_status_pic= '2.gif';
			break;
		case "LOGGEDOUT":
			$tmp_user_status_pic= '2.gif';
			break;
		case "SKYPEOUT":
			$tmp_user_status_pic= '2.gif';
			break;
		default:
			$tmp_user_status_pic='6.gif';
	}
	switch($user_status2)
	{
		case "0":
			$tmp_user_status2_pic='stop.gif';
			break;
		case "1":
			$tmp_user_status2_pic='start.gif';
			break;
	}
	$user_status_pic[]=$tmp_user_status_pic;
	$user_status2_pic[]=$tmp_user_status2_pic;
	$group_user.='<tr><td></td></tr>';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="refresh" content="30;">
<title></title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<style>
#outerTable
{
    BORDER-RIGHT: #a5bede 1px solid;
    BORDER-TOP: #a5bede 1px solid;
    BORDER-LEFT: #a5bede 1px solid;
    BORDER-BOTTOM: #a5bede 1px solid;
	background-color:#ffffff;
}
</style>
<body leftMargin=0 topMargin=0 background="image/callcenter/skype_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">

<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760><?include "top.php";?></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width=760 height=570 cellspacing=0 cellpadding=0>
	<tr>
		<td width="80" height="138">&nbsp;</td>
		<td width="630">&nbsp;</td>
		<td width="50">&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td valign=top>
			<table border=1 width="100%"cellpadding=0 cellspacing=0 class=style24b>
			<tr valign=top>
				<td align=right width=80>组名称:</td>
				<td width=160><?=$group_name?></td>
				<td align=center>成员状态:</td>
			</tr>
			<tr valign=top>
				<td align=right>组EPN:</td>
				<td><?=$group_account?></td>
				<td valign=top rowspan=2>
					<table border=0 width="100%" cellpadding=0 cellspacing=0>
					<?
					for($i=0;$i<sizeof($user_account);$i++)
					{
						if($i%$col==0)
						{
							echo '<tr>';
						}
						?>
						<td id="<?=$i?>" height=36 onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""'><a class=style24b href='callto://<?=$user_skype[$i]?>'><img src="../skype_online/image/status_icon/<?=$user_status_pic[$i]?>" border=0><img src="../skype_online/image/status_icon/<?=$user_status2_pic[$i]?>" border=0><?=$user_name[$i]?></a></td>
						<?
						if($i%$col==($col-1))
						{
							echo '</tr>';
						}
					}
					?>
					</table></td>
			</tr>
			<tr valign=top>
				<td colspan=2 class=style24b><p style="text-indent:2em"><?=str_replace("\r\n","<br>",unformat($group_desc))?></p></td>
			</tr>
			<tr>
				<td colspan=3 class=style22b align=right>提示:<img src="../skype_online/image/status_icon/1.gif">为SKYPE状态;<img src="../skype_online/image/status_icon/start.gif">为EPN状态</td>
			</tr>
			</table>
		</td>
		<td></td>
		<td></td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center style="cursor:hand" onMouseOver='this.style.backgroundColor="<?=$vod_selectbar?>"' onMouseOut='this.style.backgroundColor=""' onclick="window.history.go(-1);">返<br>回</td>
	</tr>
	</table>
	</td>
</tr>

</table>

</body>
<script language="JavaScript" type="text/JavaScript">
<!--
var key2=0;
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<table bgcolor="<?=$vod_selectbar?>" border=0 cellpadding=0 cellspacing=0><tr><td align=center valign=center><a class=style24b style="color:white" ' + dat + '</td></tr></table>';
	document.links[n].focus();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<a class=style24b ' + dat;
}

function keyDown(e)
{
	var keycode=e.which
	var key1 = keycode -48
	var patern=/^[1-<?=$num?>]$/; 
	if (patern.exec(key1)) 
	{
		if(key1 == key2 + 1)
			onfoc(key1 - 1);
		else
		{
			losefoc(key2);
			onfoc(key1 - 1)
			key2 = key1 -1;
		}
		location = document.links[key2];
	  }
		 
	if(keycode==36)
	{
		window.history.go(-1);
	}
	
	if(keycode==37)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=<?=$num-1?>;
		onfoc(key2)
	}
	if(keycode==39)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$num-1?>) 
			key2=0;
		onfoc(key2)
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2-=2;
		if(key2<0)
		{
			if(key2%2==0)
			{
				key2=<?=$num%2==0?$num-2:$num-1?>;
			}
			else
			{
				key2=<?=$num%2==0?$num-1:$num-2?>;
			}
		}
		onfoc(key2);
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2+=2;
		if(key2><?=$num-1?>)
		{
			if(key2%2==0)
			{
				key2=0;
			}
			else
			{
				key2=1;
			}
		}
		onfoc(key2);
	}
	
}
document.onkeydown=keyDown
//-->
</script>
</html>

