<meta http-equiv="refresh" content="300;">
<table width="100%" border=1 cellpadding=0 cellspacing=0 bordercolor=#d0dce0 >
<caption>����ͨ�����û�</caption>
<tr bgcolor=#3399CC>
	<td align=center>���</td>
	<td align=center>�û�IP</td>
	<td align=center>�����ʱ��</td>
	<td align=center>������URI</td>
	<td align=center>�Ʋ⶯��</td>
</tr>
<?php
function has_str($haystack,$needle,$offset=0)
{ 
	//Ѱ���ַ���haystack��needle���ȳ��ֵ�λ�� 
	//�÷���strpos��ͬ��myStrPos(string haystack��string needle��int [offset]); 
	$lenSource=strlen($haystack); 
	$lenKey=strlen($needle); 
	$find=0; 
	for($i=$offset;$i<($lenSource-$lenKey+1);$i++) 
	{
		if(substr($haystack,$i,$lenKey)==$needle)
		{ 
			$find=1;//�ҵ��˳�ѭ�� 
			break; 
		} 
	}
	if($find)
		return 1; //�ҵ��򷵻�1
	else 
		return 0;//û�ҵ��ͷ���0 
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
			return '����Ӱ';
		}
		else
		{
			return '����Ӱ���';
		}
	}
	elseif(has_str($uri,'/epg_station'))
	{
		if(($now-$tmp)>10*60)
		{
			return '������';
		}
		if(($now-$tmp)<10)
		{
			return 'Ѱ��Ƶ��';
		}
	}
	elseif(has_str($uri,'/epg_schedule'))
	{
		if(($now-$tmp)<2*60)
		{
			return '�鿴���ӽ�Ŀ��';
		}
		else
		{
			return 'һֱ�ڿ���Ŀ��';
		}
	}
	elseif(has_str($uri,'/music_singer_song')||has_str($uri,'/music_other_song'))
	{
		if(($now-$tmp)>10*60)
		{
			return '����MTV';
		}
		if(($now-$tmp)<10)
		{
			return '����MTV';
		}
	}
	elseif(has_str($uri,'/music_mp3_song'))
	{
		if(($now-$tmp)>5*60)
		{
			return '���һ���MP3';
		}
	}
	elseif(has_str($uri,'/adm'))
	{
		if(($now-$tmp)<5*60)
		{
			return '������';
		}
		else
		{
			return '����Ա����';
		}
	}
	elseif(has_str($uri,'/bbs'))
	{
		if(($now-$tmp)<5*60)
		{
			return '����̳';
		}
		else
		{
			return '��̳�з���';
		}
	}
	elseif(has_str($uri,'/menu_1'))
	{
		if(($now-$tmp)<5*60)
		{
			return '���˵�';
		}
		else
		{
			return '�ѹػ����뿪';
		}
	}
	elseif(has_str($uri,'/news_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '���ʵʱ����';
		}
		else
		{
			return 'ͣ����ʵʱ����';
		}
	}
	elseif(has_str($uri,'/daily_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '�����������';
		}
		else
		{
			return 'ͣ������������';
		}
	}
	elseif(has_str($uri,'/vod_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '����ӰƬ';
		}
		else
		{
			return 'ͣ����VODҳ��';
		}
	}
	elseif(has_str($uri,'/music_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '������ֵ���';
		}
		else
		{
			return 'ͣ�������ֵ���';
		}
	}
	elseif(has_str($uri,'/news_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '���ʵʱ����';
		}
		else
		{
			return 'ͣ����ʵʱ����';
		}
	}
	elseif(has_str($uri,'/bm_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '�����������';
		}
		else
		{
			return 'ͣ���ڱ������';
		}
	}
	elseif(has_str($uri,'/zw_'))
	{
		if(($now-$tmp)<5*60)
		{
			return '�����������';
		}
		else
		{
			return 'ͣ���ڵ�������';
		}
	}
	else
	{
		return '����';
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
		<td colspan=5>����<span class=blue><?=$i?></span>���û�����,����<span class=red><?=$j?></span>������ͨ,<span class=blue><?=$k?></span>������Ա.ҳ��ÿ��5�����Զ�ˢ��</td>
	</tr>
	<?
}
else
{
	?>
	<tr>
	<td colspan=5 align=center>û���û�����</td>
	</tr>
	<?
}
?>
</table>