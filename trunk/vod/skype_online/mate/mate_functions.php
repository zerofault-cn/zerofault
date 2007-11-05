<?
function getUserAgent()
{
	include "getuserinfo.php";
	$time=date("Y-m-d H:i:s");
	$add=getaddr();
	$os=getos();
	$browse=getbrowser();
//	$db_conn=mysql_connect("localhost","root","");
	mysql_select_db("phpbbs");
	$sql="insert into count1(ip,address,os,browse,time) values('$ip','$add','$os','$browse',now())";
	if($result=mysql_query($sql))
		session_register("ip");
	else
		echo "sql error!";
}

function topInfo()
{
	?>

<script language="javascript" src="../realtime.js"></script>
<table width="100%" border=0 cellspacing=0 cellpadding=0 class=outertable>
<tr>
	<td align=center width="14%" rowspan=2>
		<img src="image/home.gif" height=60>
	</td>
	<td><a href="?action="><img src="image/skype.gif" height=40 border=0></td>
	<td align=center rowspan=2 style="font-size:15px"><a href="?action=">首页</a>&nbsp;&nbsp;<a href="?action=">产品</a>&nbsp;&nbsp;<a href="?action=">下载</a>&nbsp;&nbsp;<a href="?action=">黄页</a>&nbsp;&nbsp;<a href="?action=">FAQ</a>&nbsp;&nbsp;<a href="?action=">论坛</a>&nbsp;&nbsp;
	<br>
	现在时间:<span style="font-family:Verdana;" id=realtime></span>
	</td>
</tr>
<tr>
	<td><span class=indexlogo>SkyCall欢迎您</span></td>
</tr>
<table>
<br>
	<?
}

function topBanner()
{
	global $labelTitle,$labelCaption;
	?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=innerTable>
	<tr>
		<td width="90" align=center class=labelTitle>
		<?
		echo $labelTitle;
		?>
		</td>
		<td align=center class=labelCaption>
		<?
		if(!isset($_COOKIE['cookie_user_account']) || ''==$_COOKIE['cookie_user_account'])
		{
			echo '游客,您好,请先<a href="?action=login1">登录</a>以使用更多功能!';
		}
		else
		{
			if(''==$labelCaption)
			{
				echo '您可以在这里查找已注册用户!';
			}
			else
			{
				echo $labelCaption;
			}
		}
		?>
		</td>
	</tr>
	</table>
	<?
}

function userListNavigation1()
{
	global $action,$row_count,$pageitem,$offset;
	?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=topNavigation>
<tr>
	<td colspan=2 align=center>
		<?
		$allPage=ceil($row_count/$pageitem);
		$tmp_offset=0;
		for($i=0;$i<$allPage;$i++)
		{
			if($offset==$tmp_offset)
			{
				echo '<span class=pageIndexOn>'.($i+1).'</span>';
			}
			else
			{
				?>
				<a class=pageIndex href="?action=<?=$action?>&offset=<?=$tmp_offset?>"><?=$i+1?> </a>
				<?
			}
			$tmp_offset+=$pageitem;
		}
		?>
		&nbsp;&nbsp;&nbsp;&nbsp;<span class=pageInfo><?=$offset+1?>-<?=min(($offset+$pageitem),$row_count)?> of <?=$row_count?></span>
	</td>
</tr>
</table>
	<?
}


function userListNavigation2()
{
	global $action,$row_count,$pageitem,$offset;
	?>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=bottomNavigation>
<tr>
	<td align=right>
	<?
	if($offset!=0)
	{
		$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
		?>
		<a href="?action=<?=$action?>&offset=0">【最前】</a>&nbsp;
		<a href="?action=<?=$action?>&offset=<?=$preoffset?>">【前一页】</a>&nbsp;
		<?
	}

	if(($offset+$pageitem)<$row_count)
	{
		$nextoffset=$offset+$pageitem;
		$endpage=$row_count-$pageitem;
		?>
		<a href="?action=<?=$action?>&offset=<?=$nextoffset?>">【后一页】</a>&nbsp;
		<a href="?action=<?=$action?>&offset=<?=$endpage?>">【最后】</a>&nbsp;
		<?
	}
	echo '当前:'.(ceil(($offset+1)/$pageitem)).'/'.ceil($row_count/$pageitem).',';
	echo '总共'.$row_count.'条';
	?>
	</td>
</tr>
</table>
	<?
}

function footerInfo()
{
	?>
<br>
<table width="100%" border=0 cellspacing=0 cellpadding=0 bgcolor='#E6EAF3' class=outertable>
<tr>
	<td align=center>版权所有：深圳金纬科技有限公司 <br>copyright &copy; 2004-2005 all rights reserved<br>
	</td>
</tr>
<table>
	<?
}

function errorMsg($msgStr)
{
	?>
<br>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outertable>
<tr>
	<td align=center>
	<br><br>
	<table width="70%" border=0 cellpadding=5 cellspacing=0 class=innertable>
	<caption align=left>出现错误!</caption>
	<tr>
		<td align=center><BR><?=$msgStr?><BR></td>
	</tr>
	<tr>
		<td align=center><a href="javascript:history.go(-1)">返回</a></td>
	</tr>
	</table>
	<br><br>
	</td>
</tr>
</table>
	<?
}
function okMsg($msgStr)
{
	?>
<br>
<table width="100%" border=0 cellpadding=0 cellspacing=0 class=outertable>
<tr>
	<td align=center>
	<br><br>
	<table width="70%" border=0 cellpadding=5 cellspacing=0 class=innertable>
	<caption align=left>操作成功!</caption>
	<tr>
		<td align=center><BR><?=$msgStr?><BR></td>
	</tr>
	<tr>
		<td align=center><a href="?action=">返回首页</a></td>
	</tr>
	</table>
	<br><br>
	</td>
</tr>
</table>
	<?
}

function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=addslashes($text);
	return $text;
}

?>