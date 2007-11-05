<?
function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
mysql_connect('localhost','dba','sql');
mysql_select_db('skype_db');
if(!isset($offset) || ''==$offset)
{
	$offset=0;
}
$pageitem=7;
$i=0;
if(!isset($type) || ''==$type)
{
	$sql1="select count(*) from user_info";
	$row_count=mysql_result(mysql_query($sql1),0,0);
	$sql2="select * from user_info order by user_id limit ".$offset.",".$pageitem;
	$result2=mysql_query($sql2);
	while($r2=mysql_fetch_array($result2))
	{
		$user_account	=$r2['user_account'];
		$user_name		=$r2['user_name'];
		if(''==$user_name)
		{
			$user_name	=$user_account;
		}
		$user_sex		=$r2['user_sex'];
		if(''==$user_sex || '0'==$user_sex)
		{
			$user_sex	='保密';
		}
		$user_from1		=$r2['user_from1'];
		$user_from2		=$r2['user_from2'];
		$user_from3		=$r2['user_from3'];
		$user_from		=$user_from1.' '.$user_from2.' '.$user_from3;
		if('  '==$user_from || '0 0 '==$user_from)
		{
			$user_from	='保密';
		}
		$user_avatar	=$r2['user_avatar'];
		if(''==$user_avatar)
		{
			$user_avatar='flower.jpg';
		}
		$user_signature	=$r2['user_signature'];
		$user_skype		=$r2['user_skype'];
		$user_status	=$r2['user_status'];
		if($user_status=='ONLINE' || $user_status=='SKYPEME')
		{
			$user_status_pic='online.png';
		}
		elseif($user_status=='BUSY')
		{
			$user_status_pic='busy.png';
		}
		elseif($user_status=='AWAY')
		{
			$user_status_pic='away.png';
		}
		elseif($user_status=='DND')
		{
			$user_status_pic='dnd.png';
		}
		else
		{
			$user_status_pic='offline.png';
		}
		$user_info_arr[$i][0]=$user_name;
		$user_info_arr[$i][1]=$user_skype;
		$user_info_arr[$i][2]=$user_status_pic;
		$user_info_arr[$i][3]='';
		$user_info_arr[$i][4]='<table border=0 width=100% height=100% cellpadding=0 cellspacing=0 id=outertable style=\"font-size:24px\">';
		$user_info_arr[$i][4].='<tr><td>EPN:'.$user_account.'</td><td rowspan=4><img src=\"../skype_online/avatars/'.$user_avatar.'\" height=128></td></tr>';
		$user_info_arr[$i][4].='<tr><td>姓名:'.$user_name.'</td></tr>';
		$user_info_arr[$i][4].='<tr><td>性别:'.$user_sex.'</td></tr>';
		$user_info_arr[$i][4].='<tr><td>来自:'.$user_from.'</td></tr>';
		$user_info_arr[$i][4].='<tr><td colspan=2>&nbsp;&nbsp;&nbsp;&nbsp;'.str_replace("\r\n","<br>",unformat($user_signature)).'</td></tr>';
		$user_info_arr[$i][4].='</table>';
		$user_info_arr[$i][5]=$user_account;
		$i++;
	}
}
else
{
	$sql1="select count(*) from group_info";
	$row_count=mysql_result(mysql_query($sql1),0,0);
	$sql2="select * from group_info order by group_id limit ".$offset.",".$pageitem;
	$result2=mysql_query($sql2);
	while($r2=mysql_fetch_array($result2))
	{
		$group_id=$r2['group_id'];
		$group_account=$r2['group_account'];
		$group_name=$r2['group_name'];
		$group_avatar=$r2['group_avatar'];
		if(''==$group_avatar)
		{
			$group_avatar='flower.jpg';
		}
		$group_desc=$r2['group_desc'];
		$sql3="select count(*) from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id and (user_status='ONLINE' or user_status='SKYPEME') and user_status2=1";
		$result3=mysql_query($sql3);
		$online_count=mysql_result($result3,0,0);
		$sql4="select count(*) from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id and (user_status='ONLINE' or user_status='SKYPEME' or user_status='BUSY') and user_status2=1";
		$result4=mysql_query($sql4);
		$all_count=mysql_result($result4,0,0);
		$sql5="select user_account,user_name,user_skype,user_status from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id and user_info.user_status2=1 order by group_member.member_id";
		$result5=mysql_query($sql5);
		$user_skype='';
		$user_status_pic='';
		while($r5=mysql_fetch_array($result5))
		{
			$group_skype=$r5['user_skype'];
			$group_status=$r5['user_status'];
			if($group_status=='ONLINE' || $group_status=='SKYPEME')
			{
				$group_status_pic='online.png';
				break;
			}
			elseif($group_status=='BUSY')
			{
				$group_status_pic='busy.png';
				continue;
			}
		}
		if(''==$group_status_pic)
		{
			$group_status_pic='offline.png';
		}
		$sql6="select user_account,user_name,user_skype,user_status,user_status2 from user_info,group_member where group_member.group_id=".$group_id." and group_member.user_id=user_info.user_id order by member_id";
		$group_user='';
		$result6=mysql_query($sql6);
		while($r6=mysql_fetch_array($result6))
		{
			$user_account	=$r6['user_account'];
			$user_name		=$r6['user_name'];
			$user_status	=$r6['user_status'];
			$user_status2	=$r6['user_status2'];
			if(''==$user_name)
			{
				$user_name=$user_account;
			}
			switch($user_status)
			{
				case "UNKNOWN":
					$user_status_str= '未知';
					break;
				case "ONLINE":
					$user_status_str= '在线';
					break;
				case "SKYPEME":
					$user_status_str= '在线';
					break;
				case "OFFLINE":
					$user_status_str= '不在线';
					break;
				case "AWAY":
					$user_status_str= '离开';
					break;
				case "NA":
					$user_status_str= '未知';
					break;
				case "DND":
					$user_status_str= '勿扰';
					break;
				case "INVISIBLE":
					$user_status_str= '隐身';
					break;
				case "LOGGEDOUT":
					$user_status_str= '已注销';
					break;
				case "SKYPEOUT":
					$user_status_str= '离线';
					break;
				default:
					$user_status_str='未知';
			}
			switch($user_status2)
			{
				case "0":
					$user_status2_str='未登录';
					break;
				case "1":
					$user_status2_str='已登录';
					break;
			}
			$group_user.=$user_name.'('.$user_status_str.'/'.$user_status2_str.')<br>';
		}

		$user_info_arr[$i][0]=$group_name;
		$user_info_arr[$i][1]=$group_skype;
		$user_info_arr[$i][2]=$group_status_pic;
		$user_info_arr[$i][3]='('.$online_count.'/'.$all_count.')';
		$user_info_arr[$i][4]='<table border=0 width=100% height=100% cellpadding=0 cellspacing=0 id=outertable style="font-size:24px">';
		$user_info_arr[$i][4].='<tr><td align=right>组名:</td><td>'.$group_name.'</td></tr>';
		$user_info_arr[$i][4].='<tr><td align=right>EPN:</td><td>'.$group_account.'</td></tr>';
		$user_info_arr[$i][4].='<tr><td align=right>成员:</td><td><blink>按【*】键查看</blink></td></tr>';
		$user_info_arr[$i][4].='<tr><td colspan=2 style="font-size:24px">&nbsp;&nbsp;&nbsp;&nbsp;'.str_replace("\r\n","<br>",unformat($group_desc)).'</td></tr>';
		$user_info_arr[$i][4].='</table>';
		$user_info_arr[$i][5]=$group_id;
		$i++;
	}
}
//print_r($user_info_arr);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta http-equiv="refresh" content="60;">
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
<body leftMargin=0 topMargin=0 background="image/ebox/skype_bg.jpg" style="background-Attachment:fixed;background-repeat:no-repeat;" onload="onfoc(0)">

<table width="800" border="0" cellpadding="0" cellspacing="0" height="590">
<tr>
	<td width=20 height=10></td>
	<td width=760></td>
	<td width=20>&nbsp;</td>
</tr>
<tr>
	<td height=570>&nbsp;</td>
	<td valign=top>
	<!--************************************ 可视面积:嵌入内容 *************************************************-->
	<table border=0 width=760 height=570 cellspacing=0 cellpadding=0>
	<tr>
		<td width="80" height="80">&nbsp;</td>
		<td width="350"></td>
		<td width="300">&nbsp;</td>
		<td width="30">&nbsp;</td>
	</tr>
	<tr>
		<td height="58" colspan=3>
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width=180></td>
			<td valign=bottom style='font-size:30px;color:#c5f300'>第<?=$offset/$pageitem+1?>页&nbsp;&nbsp;&nbsp;&nbsp;共<?=ceil($row_count/$pageitem)?>页&nbsp;&nbsp;&nbsp;</td>
		</tr>
		</table>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td valign=top>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<?
			for($i=0;$i<sizeof($user_info_arr);$i++)
			{
	  			?>
			<tr id="<?=$i?>">
				<td height=48 valign=center><a style="font-size:30px;color:#ffffff" href=
				<?
				if(''!=$user_info_arr[$i][1])
				{
					echo '"callto://'.$user_info_arr[$i][1].'"';
				}
				else
				{
					echo "#";
				}
				?>
				><img src="../skype_online/image/status/<?=$user_info_arr[$i][2]?>" border=0><?=$user_info_arr[$i][0]?></a><?=$user_info_arr[$i][3]?></td>
			</tr>
				<?
			}
			?>
			</table></td>
		<td align=center valign=top>
		<table border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td><img src="image/ebox/11.png" valign=bottom></td>
			<td background="image/ebox/top.png"></td>
			<td><img src="image/ebox/22.png" valign=bottom></td>
		</tr>
		<tr>
			<td align=right valign=top background="image/ebox/left.png"></td>
			<td valign=top id=card></td>
			<td align=left valign=top background="image/ebox/right.png"></td>
		</tr>
		<tr>
			<td><img src="image/ebox/44.png" valign=bottom</td>
			<td background="image/ebox/bottom.png"></td>
			<td><img src="image/ebox/33.png" valign=top></td>
		</tr>
		</table>
			</td>
		<td>&nbsp;</td>
	</tr>
    <tr>
		<td colspan=3></td>
		<td>&nbsp;</td>
	</tr>
	</table>
	<!--********************************************* 可视面积 ***********************************************-->
	</td>
	<td valign=bottom>
	<table width="100%" height="180" border=0 cellpadding=0 cellspacing=0 class=style22w>
	<tr>
		<td height="33%" align=center 
		<?
		if($offset!=0)//表示不是第一页
		{
			?>
			style="cursor:hand"  onclick="window.location=('?type=<?=$type?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>');">上<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	<tr>
		<td height="33%" align=center style="cursor:hand"  onclick="window.location=('menu_1.php');">返<br>回</td>
	</tr>
	<tr>
		<td height="34%" align=center 
		<?
		if(($offset+$pageitem) < $row_count)//表示还有下页
		{
			?>
			style="cursor:hand" onclick="window.location=('?type=<?=$type?>&offset=<?=$offset+$pageitem?>');">下<br>页</a>
			<?
		}
		else
		{
			echo '>';
		}
		?>
		</td>
	</tr>
	</table>
	</td>
</tr>

</table>

</body>
<script language="JavaScript" type="text/JavaScript">
<!--
var user_info_arr=new Array(
<?
for($i=0;$i<sizeof($user_info_arr)-1;$i++)
{
	?>
	new Array(
	<?
	for($j=0;$j<sizeof($user_info_arr[$i])-1;$j++)
	{
		echo '"'.$user_info_arr[$i][$j].'",';
	}
	echo '"'.$user_info_arr[$i][$j].'"';
	?>
	),
	<?
}
?>
	new Array(
	<?
	for($j=0;$j<sizeof($user_info_arr[$i])-1;$j++)
	{
		echo '"'.$user_info_arr[$i][$j].'",';
	}
	echo '"'.$user_info_arr[$i][$j].'"';
	?>
	)
)

var key2=0;
var t1=document.getElementById('card');
function onfoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height=48 bgcolor=#2b4971><a style="font-size:30px;color:#20e3f4" ' + dat;
	document.links[n].focus();
	show_card();
}

function losefoc(n) {
	t2 = document.getElementById(n);
	dat = t2.innerHTML;
	dat = dat.substring(dat.indexOf("href="));
	t2.innerHTML = '<td height=48><a style="font-size:30px;color:#ffffff" ' + dat;
}
function show_card()
{
	dat=user_info_arr[key2][4];
	t1.innerHTML=dat;
}

function keyDown(e)
{
	var keycode=e.which
	var key1 = keycode -48
	var patern=/^[1-<?=$i?>]$/; 
	if (patern.exec(key1)) 
	{
		if(key1 == key2 + 1)
		{
			onfoc(key1 - 1);
		}
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
		location="menu_1.php";
	}
	if(keycode==59)//蓝键转到按组显示方式
	{
		location="?type=group";
	}
	if(keycode==221)//绿键转到按人显示方式
	{
		location="?type=";
	}
	if(keycode==56)//星号查看组员信息
	{
		location="skype_group_info.php?group_id="+user_info_arr[key2][5];
	}

	if(keycode==33 && <?=$offset?>!=0)//表示不是第一页
	{
		location="?type=<?=$type?>&offset=<?=($offset-$pageitem)>0?($offset-$pageitem):0?>";
	}
	if(keycode==34 && <?=$offset+$pageitem?> < <?=$row_count?>)
	{
		location="?type=<?=$type?>&offset=<?=$offset+$pageitem?>";
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
			key2=<?=$i?>;
		onfoc(key2);
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$i?>) 
			key2=0;
		onfoc(key2);
	}
	
}
document.onkeydown=keyDown
//onfoc(0);
//-->
</script>
</html>
