<meta http-equiv="refresh" content="300;">
<table width="100%" border=1 cellpadding=0 cellspacing=0 bordercolor=#d0dce0 >
<caption>家易通在线用户</caption>
<tr bgcolor=#3399CC>
	<td align=center>序号</td>
	<td align=center>用户IP</td>
	<td align=center>最后动作时间</td>
	<td align=center>最后访问URI</td>
	<td align=center>推测动作</td>
</tr>
<?php
function has_str($haystack,$needle,$offset=0)
{ 
	//寻找字符串haystack中needle最先出现的位置 
	//用法和strpos相同即myStrPos(string haystack，string needle，int [offset]); 
	$lenSource=strlen($haystack); 
	$lenKey=strlen($needle); 
	$find=0; 
	for($i=$offset;$i<($lenSource-$lenKey+1);$i++) 
	{
		if(substr($haystack,$i,$lenKey)==$needle)
		{ 
			$find=1;//找到退出循环 
			break; 
		} 
	}
	if($find)
		return 1; //找到则返回1
	else 
		return 0;//没找到就返回0 
}
function check_action($uri,$time)
{
	$now=time();
	$tmp=mktime(substr($time,11,2),substr($time,14,2),substr($time,17,2),substr($time,5,2),substr($time,8,2),substr($time,0,4));
	//$time='2004-11-30 17:06:33'
	//int hour, int minute, int second, int month, int day, int year
	if(substr($uri,0,4)=='/800')
	{
		$uri=substr($uri,4);
	}
	if(has_str($uri,'/vod_introduce'))
	{
		if(($now-$tmp)>10*60)
		{
			return '看电影';
		}
		else
		{
			return '看电影简介';
		}
	}
	elseif(has_str($uri,'/epg_station'))
	{
		if(($now-$tmp)>10*60)
		{
			return '看电视';
		}
		if(($now-$tmp)<10)
		{
			return '寻找频道';
		}
	}
	elseif(has_str($uri,'/epg_schedule'))
	{
		if(($now-$tmp)<2*60)
		{
			return '查看电视节目单';
		}
		else
		{
			return '一直在看节目单';
		}
	}
	elseif(has_str($uri,'/music_singer_song')||has_str($uri,'/music_other_song'))
	{
		if(($now-$tmp)>10*60)
		{
			return '欣赏MTV';
		}
		if(($now-$tmp)<10)
		{
			return '查找MTV';
		}
	}
	elseif(has_str($uri,'/music_mp3_song'))
	{
		if(($now-$tmp)>5*60)
		{
			return '查找或听MP3';
		}
	}
	elseif(has_str($uri,'/adm'))
	{
		if(($now-$tmp)<5*60)
		{
			return '管理中';
		}
		else
		{
			return '管理员发呆';
		}
	}
	elseif(has_str($uri,'/bbs'))
	{
		if(($now-$tmp)<5*60)
		{
			return '逛论坛';
		}
		else
		{
			return '论坛中发呆';
		}
	}
	elseif(has_str($uri,'/menu_1'))
	{
		if(($now-$tmp)<5*60)
		{
			return '主菜单';
		}
		else
		{
			return '已关机或离开';
		}
	}
	elseif(has_str($uri,'/news_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '浏览实时新闻';
		}
		else
		{
			return '停留在实时新闻';
		}
	}
	elseif(has_str($uri,'/daily_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '浏览天天在线';
		}
		else
		{
			return '停留在天天在线';
		}
	}
	elseif(has_str($uri,'/vod_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '查找影片';
		}
		else
		{
			return '停留在VOD页面';
		}
	}
	elseif(has_str($uri,'/music_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '浏览音乐殿堂';
		}
		else
		{
			return '停留在音乐殿堂';
		}
	}
	elseif(has_str($uri,'/news_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '浏览实时新闻';
		}
		else
		{
			return '停留在实时新闻';
		}
	}
	elseif(has_str($uri,'/bm_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '浏览便民内容';
		}
		else
		{
			return '停留在便民服务';
		}
	}
	elseif(has_str($uri,'/zw_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '浏览政务内容';
		}
		else
		{
			return '停留在电子政务';
		}
	}
	else
	{
		return '其他';
	}
}
$duration=1.5*60*60;
if($offset=="")
{
	$offset=0;
}
$pageitem=40;
mysql_connect('localhost','dba','sql');
mysql_select_db('BOD_WIN');
$sql1="select count(*) from user_online where (unix_timestamp(now())-unix_timestamp(lastActTime))<=".$duration;
$sql2="select * from user_online where (unix_timestamp(now())-unix_timestamp(lastActTime))<=".$duration." order by lastActTime desc limit ".$offset.",".$pageitem;
$result1=mysql_query($sql1);
$rowCount=mysql_result($result1,0,0);
$result2=mysql_query($sql2);
if($rowCount>0)
{
	$i=0;
	$j=0;
	$k=0;
	while($r=mysql_fetch_array($result2))
	{
		$i++;
		$ip=$r['ip'];
		$time=$r['lastActTime'];
		$uri=$r['lastURI'];
		$action=check_action($uri,$time);
		if(substr($ip,0,3)=='172')
		{
			$j++;
		}
		if(substr($uri,0,5)=='/adm/')
		{
			$k++;
		}
		?>
		<tr>
			<td><?=$i?></td>
			<td><?
			if(substr($ip,0,3)=='172')
			{
				echo '<span class=red>'.$ip.'</span>';
			}
			else
			{
				echo $ip;
			}
			?></td>
			<td><?=$time?></td>
			<td><a href="<?=$uri?>" target="_blank"><?=substr($uri,0,22)?></a></td>
			<td><?=$action?></td>
		</tr>
		<?
	}
	?>
	<tr>
		<td colspan=5>共有<span class=blue><?=$i?></span>个用户在线,其中<span class=red><?=$j?></span>个家易通,<span class=blue><?=$k?></span>个管理员.页面每隔5分钟自动刷新</td>
	</tr>
	<?
}
else
{
	?>
	<tr>
	<td colspan=5 align=center>没有用户在线</td>
	</tr>
	<?
}
?>
</table>