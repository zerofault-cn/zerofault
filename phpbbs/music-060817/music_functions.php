<?
function unformat($text)//����ʽ��,������html��ʽ�������ݻ�ԭ��textarea����ʾ
{
	$text=str_replace('&amp;','&',$text);
	$text=str_replace('&quot;','"',$text);
	$text=str_replace('&#039;','\'',$text);
	$text=str_replace('&lt;','<',$text);
	$text=str_replace('&gt;','>',$text);
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />','',$text);
	$text=str_replace('<br>','',$text);
	return $text;
}
function musicSearchTable()//�����������
{
	?>
<script language="javascript">
function check()
{
	if(window.document.form1.keyword.value=="")
	{
		alert("�����������ؼ���");
		document.form1.keyword.focus();
		return false;
	}
	return true;
}
</script>

<table width="100%" border=0 cellpadding=0 cellspacing=0>
<form name="form1" action='search.php' method="post" onsubmit="return check();">
<tr>
	<td colSpan=3 height=20 align=center background="../image/white_top.gif"><img src="../image/search.gif" width=16 height=16 align="absmiddle">��������</td>
</tr>
<tr>
	<td width=10 height=100% rowspan=2 align=right valign=top><img height="100%" src="../image/point2.gif" width=1></td>
	<td width=150 align=center><input name=keyword size=14>
	<td width=10 height=100% rowspan=2 valign=top><img height="100%" src="../image/point2.gif" width=1></td>
</tr>
<tr>
	<td align=center><select name="searchtype">
		<option value="multi">��������</option>
		<option value="song">����</option>
		<option value="singer">����</option>
		<option value="album">ר��</option>
		<option value="multi">ȫ��</option>
		</select>&nbsp;&nbsp;
		<input type="submit" value='��' class="button">
	</td>
</tr>
<tr>
	<td height=20 colspan=3 background="../image/white_bottom.gif"></td>
</tr>
</form>
</table>
	<?
}

function menuTable()//��߲˵����
{
	?>
<style>
a.bigger:link 
{
	color: #333333;
	font-size: 10pt; 
	text-decoration: none
}
a.bigger:visited 
{
	color: #333333;
	font-size: 10pt;
	text-decoration: none
}
a.bigger:hover 
{
	color: #ff2200; 
	font-size: 11pt;
	text-decoration: underline
}
</style>
<script>
function closebut(x, y) 
{
//	if(document.img0) document.img0.src='image/folder1.gif';
//	if(document.img1) document.img1.src='image/folder1.gif';
//	if(document.all.div0) document.all.div0.style.display='none';
//	if(document.all.div1) document.all.div1.style.display='none';
	x.style.display='block';
	y.src='image/folder2.gif';
}
function t(x, y) 
{
	if(x.style.display!='none') 
	{
		x.style.display='none';
		y.src='image/folder1.gif';
	}
	else
		closebut(x, y);
}
</script>
<table width="100%" border=0 cellPadding=0 cellSpacing=0>
<tr>
	<td background="../image/white_top.gif" colSpan=3 height=20 valign=center align=center><img src="image/icon3.gif" width=18 height=18 align="absmiddle">�����˵�</td>
</tr>
<tr>
	<td width=10 height="100%" rowSpan=4 align=right valign=top><img height="100%" src="../image/point2.gif" width=1></td>
	<td  width=150 height=20><div style="margin-left:1.6em"><img name="img0" src="image/folder1.gif" width=16 height=16 align="absmiddle"><a href="javascript: t(document.all.div0,document.img0)"><span class=red>�����б�</span></a></div>
	<div id=div0 style="display: none">
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php" class=bigger>���и���</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=16" class=bigger>��̨�и���</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=17" class=bigger>��̨Ů����</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=18" class=bigger>��̨���</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=26" class=bigger>�ڵ��и���</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=27" class=bigger>�ڵ�Ů����</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=28" class=bigger>�ڵ����</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=30" class=bigger>��������</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=59" class=bigger>������</a></div>
	</div></td>
	<td width=10 height=100% rowspan=4 valign=top><img height="100%" src="../image/point2.gif" width=1></td>
</tr>
<tr>
	<td height=20><div style="margin-left:1.6em"><img name="img1" src="image/folder1.gif" width=16 height=16 align="absmiddle"><a href="javascript: t(document.all.div1,document.img1)"><span class=red>ר���б�</span></a></div>
	<div id=div1 style="display: none">
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="album_list.php?sort_field=album_id" class=bigger>����ר��</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="album_list.php?sort_field=album_count" class=bigger>����ר��</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="album_list.php?sort_field=album_quality" class=bigger>�Ƽ�ר��</a></div>
	</div></td>
</tr>
<tr>
	<td height=20><div style="margin-left:1.6em"><img name="img2" src="image/folder1.gif" width=16 height=16 align="absmiddle"><a href="javascript: t(document.all.div2,document.img2)"><span class=red>�����б�</span></a></div>
	<div id=div2 style="display: none">
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="single_song.php" class=bigger>���е���</a></div>
	
	</div></td>
</tr>
<tr>
	<td height=20>
	<div style="margin-left:1.6em"><img src="image/link0.gif" align="absmiddle"><a href='music_upload.php' class=bigger><span class=red>�ϴ�����</span></a></div></td>
</tr>
<tr>
	<td height=20 colspan=3 background="../image/white_bottom.gif"></td>
</tr>
</table>
	<?
}

function hotAlbumTable()//����ר���б�
{
	global $db;
	$sql1="select * from album_info order by album_count desc limit 0,5";
	$result1=$db->sql_query($sql1);
	while($r=$db->sql_fetchrow($result1))
	{
		$album_id[]=$r['album_id'];
		$album_name[]=$r['album_name'];
		$album_count[]=$r['album_count'];
	}
	$i=0;
	?>
<table width="100%" border=0 cellPadding=0 cellSpacing=0>
<tr>
	<td height=20 colspan=3 align=center background="../image/white_top.gif"><img src="image/icon1.gif" width=16 height=16 align="absmiddle">ר������</td>
</tr>
<tr>
	<td width=10 height="100%" rowspan=2 align=right valign=top><img height="100%" src="../image/point2.gif" width=1></td>
	<td width=150 align=center>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td width=5></td>
		<td><a href="album_info.php?album_id=<?=$album_id[$i]?>" title="<?=$album_name[$i]?>"><img src="image/item4.gif" border=0 align="absmiddle"><?=substr($album_name[$i],0,14)?> </a></td>
		<td align=right><?=$album_count[$i]?></td>
		<td width=5></td>
	</tr>
	</table>
	</td>
	<td width=10 height=100% rowspan=2 valign=top><img height="100%" src="../image/point2.gif" width=1></td>
</tr>
<tr>
	<td>
	<?
	for($i=1;$i<5;$i++)
	{
		?>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td width=5></td>
		<td><a href="album_info.php?album_id=<?=$album_id[$i]?>" title="<?=$album_name[$i]?>"><img src="image/item4.gif" border=0 align="absmiddle"><?=substr($album_name[$i],0,14)?> </a></td>
		<td align=right><?=$album_count[$i]?></td>
		<td width=5></td>
	</tr>
	</table>
		<?
	}
	?>
	<td>
</tr>
<tr>
	<td height=20 colspan=3 background="../image/white_bottom.gif"></td>
</tr>
</table>
	<?
}
function hotSongTable()//���Ÿ����б�
{
	global $db;
	$sql1="select * from song_info order by song_count desc limit 0,5";
	$result1=$db->sql_query($sql1);
	while($r=$db->sql_fetchrow($result1))
	{
		$song_id[]=$r['song_id'];
		$song_name[]=$r['song_name'];
		$song_count[]=$r['song_count'];
	}
	$i=0;
	?>
<table width="100%" border=0 cellPadding=0 cellSpacing=0>
<tr>
	<td height=20 colspan=3 align=center background="../image/white_top.gif"><img src="image/icon1.gif" width=16 height=16 align="absmiddle">��������</td>
</tr>
<tr>
	<td width=10 height="100%" rowspan=2 align=right valign=top><img height="100%" src="../image/point2.gif" width=1></td>
	<td width=150 align=center>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td width=5></td>
		<td><a href="play.php?song_id=<?=$song_id[$i]?>" title="<?=$song_name[$i]?>"><img src="image/item2.gif" border=0 align="absmiddle"><?=substr($song_name[$i],0,14)?> </a></td>
		<td align=right><?=$song_count[$i]?></td>
		<td width=5></td>
	</tr>
	</table></td>
	<td width=10 height=100% rowspan=2 valign=top><img height="100%" src="../image/point2.gif" width=1></td>
</tr>
<tr>
	<td>
	<?
	for($i=1;$i<5;$i++)
	{
		?>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td width=5></td>
		<td><a href="play.php?song_id=<?=$song_id[$i]?>" title="<?=$song_name[$i]?>"><img src="image/item2.gif" border=0 align="absmiddle"><?=substr($song_name[$i],0,14)?> </a></td>
		<td align=right><?=$song_count[$i]?></td>
		<td width=5></td>
	</tr>
	</table>
		<?
	}
	?>
	<td>
</tr>
<tr>
	<td height=20 colspan=3 background="../image/white_bottom.gif"></td>
</tr>
</table>
	<?
}

function downloadTable()//�������ر��
{
	?>
<table width="100%" border=0 cellPadding=0 cellSpacing=0>
<tr>
	<td height=20 colspan=3 align=center background="../image/white_top.gif"><img src="image/icon2.gif" width=16 height=16 align="absmiddle">�Ƽ����</td>
</tr>
<tr>
	<td width=10 height="100%" rowspan=2 align=right valign=top><img height="100%" src="../image/point2.gif" width=1></td>
	<td width=150 align=center><a href="image/winamp.exe"><img src="image/winamp.gif" width=90 border=0></a><br>Winamp2.81���İ�</td>
	<td width=10 height=100% rowspan=2 valign=top><img height="100%" src="../image/point2.gif" width=1></td>
</tr>
<tr>
	<td align=center><a href="minilyrics.zip"><img src="image/minilyrics.gif" width=120 border=0></a><br>������3.3.1378<td>
</tr>
<tr>
	<td height=20 colspan=3 background="../image/white_bottom.gif"></td>
</tr>
</table>
	<?
}

function newAlbum5()//��ҳ���岿����ʾ5������ר��
{
	global $db;
	$sql1="select * from album_info order by album_id desc limit 0,5";
	$result1=$db->sql_query($sql1);
	while($r=$db->sql_fetchrow($result1))
	{
		$album_id[]=$r['album_id'];
		$singer_id[]=$r['singer_id'];
		$album_name[]=$r['album_name'];
		$album_pubdate[]=$r['album_pubdate'];
		$album_photo[]=$r['album_photo'];
	}
	?>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=28 colspan=5><img src="image/newalbum.gif"></td>
	</tr>
	<tr>
	<?
	for($i=0;$i<sizeof($album_id);$i++)
	{
		?>
		<td valign=bottom><a href="album_info.php?album_id=<?=$album_id[$i]?>"><img src="get_photo.php?photo_type=album&photo_id=<?=$album_id[$i]?>" width=96 border=0></a></td>
		<?
	}
	?>
	</tr>
	<tr>
	<?
	for($i=0;$i<sizeof($album_id);$i++)
	{
		?>
		<td><a href="album_info.php?album_id=<?=$album_id[$i]?>"><?=substr($album_name[$i],0,14)?> </a></td>
		<?
	}
	?>
	</tr>
	<tr>
	<?
	for($i=0;$i<sizeof($album_id);$i++)
	{
		?>
		<td><a href="singer_info.php?singer_id=<?=$singer_id[$i]?>"><?=getSingerName($singer_id[$i])?></a></td>
		<?
	}
	?>
	</tr>
	<tr>
	<?
	for($i=0;$i<sizeof($album_id);$i++)
	{
		?>
		<td><?=$album_pubdate[$i]?></td>
		<?
	}
	?>
	</tr>
	<tr>
		<td align=right colspan=5><a style="color:#ff0000" href="album_list.php">More...</a></td>
	</tr>
	</table>
	<?
}
function singleSong($song_ltype,$offset=0,$offpage=0,$allpage=0)//�����б�,��ҳ�͵����б�ҳ�涼�õ�
{
	global $db;
	?>
	<table width="100%" border=1 cellpadding=0 cellspacing=0 bordercolor="#ffffff">
	<tr>
		<td colspan=7>
	<?
	if($song_ltype=='new10')
	{
		echo '<img src="image/newsong.gif">';
	}
	else
	{
		echo '<img src="image/allsong.gif">';
	}
	?>
		</td>
	</tr>
	<tr bgcolor=#3399CC>
		<td height="20">������</td>
		<td>����</td>
		<td>����ʱ��</td>
		<td align=center>����</td>
		<td align=center>����</td>
		<td align=center>����</td>
		<td align=center>���</td>
	</tr>
	<?
	$pageitem=20;
	if(!$offset)
	{
		$offset=0;
	}
	if($offpage&&$allpage)
	{
		$offset=($allpage-$offpage)*$pageitem;
	}
	if($song_ltype=='all')
	{
		$sql1="select * from song_info where album_id=0 order by song_id desc limit ".$offset.",".$pageitem;
		$sql2="select count(*) from song_info where album_id=0";
	}
	elseif($song_ltype=='new10')
	{
		$sql1="select * from song_info where album_id=0 order by song_id desc limit 10";
		$sql2="select count(*) from song_info where album_id=0 order by song_id desc limit 10";
	}
	$result1=$db->sql_query($sql1);
	$row=$db->sql_numrows($result1);
	$result2=$db->sql_query($sql2);
	$rowCount=$db->sql_fetchfield(0,0,$result2);
	if($row==0)
	{
		echo '<tr><td height=30 colspan=7 align=center>��ʱû�и���</td></tr>';
		echo '<tr><td height=1 colspan=7><img src="../image/point1.gif" height=1 width=100%></td></tr>';
	}
	else
	{
		listTable1($result1);
		if($song_ltype=='new10')
		{
			?>
	<tr>
		<td align=right colspan=7><a style="color:#ff0000" href="single_song.php">More...</a></td>
	</tr>
			<?
		}
		if($song_ltype=='all')
		{
			?>
	<tr>
		<td align=right valign=top colspan=7>
		<table border=0 cellpadding=0 cellspacing=0>
		<form action='<?=$_SERVER['PHP_SELF']?>' method=post>
		<tr>
			<td valign=top>
		<?
		if($offset!=0)
		{
			echo "<a href='?offset=0&songlist=all'>��ҳ</a>&nbsp;&nbsp;";
			$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
			echo "<a href='?offset=$preoffset&songlist=all'>��һҳ</a>&nbsp;&nbsp;";
		}
		if(($offset+$pageitem)<$rowCount)
		{
			$newoffset=$offset+$pageitem;
			$endpage=$rowCount-$pageitem;
			echo "<a href='?offset=$newoffset&songlist=all'>��һҳ</a>&nbsp;&nbsp;";
			echo "<a href='?offset=$endpage&songlist=all'>βҳ</a>&nbsp;&nbsp;";
		}
		?>
			</td>
			<td>ҳ��:<input onmouseover="this.select()" onmouseout="this.blur()" type=text name=offpage value='<?=ceil(($offset+1)/$pageitem)?>' size=2 style="height:18px;font-size:13px;color:red">
			/<span class=red><?=ceil($rowCount/$pageitem)?></span>,ÿҳ<span class=red><?=$pageitem?></span>��,��<span class=red><?=$rowCount?></span>��</td>
		</tr>
		<input type="hidden" name="allpage" value='<?=$allpage?>'>
		<input type="hidden" name="song_ltype" value="all">
		</form>
		</table>
		<?
	}
	?>
		</td>
	</tr>
	</table>
	<?
	}
}
function listTable1($result)//�����б�ҳ���õ�
{
	global $db;
	while($r=$db->sql_fetchrow($result))
	{
		$song_id=$r["song_id"];
		$singer_id=$r["singer_id"];
		$singer_name=getSingerName($singer_id);
		$song_name=$r["song_name"];
		$song_count=$r["song_count"];
		$song_addtime=$r["song_addtime"];
		$song_lyric=$r["song_lyric"];
		?>
	<tr>
		<td><?=$song_name?></td>
		<td><a href="singer_info.php?singer_id=<?=$singer_id?>"><?=$singer_name?></a></td>
		<td><?=$song_addtime?></td>
		<td align=center><?=$song_count?></td>
		<td align=center><a href="play.php?song_id=<?=$song_id?>"><img src='image/play1.gif' border=0></a></td>
		<td align=center><a href="download.php?song_id=<?=$song_id?>"><img src='image/download1.gif' border=0></a></td>
		<td align=center>
		<?
		if($song_lyric)
		{
			echo '<a href="http://'.$_SERVER["HTTP_HOST"].'/'.str_replace(' ','%20',$song_lyric).'" title="���ط���:������Ҽ�->Ŀ�����Ϊ..."><img src="image/lyric.gif" border=0></a>';
		}
		else
		{
			echo '<a href="music_upload.php?upflag=lyrics&song_id='.$song_id.'">��</a>';
		}
		?>
		</td>
	</tr>
	<tr>
		<td height=1 colspan=7><img src='../image/point1.gif' height=1 width=100%></td>
	</tr>
	<?
	}
}
function listTable2($result)//ר����ϸ��Ϣҳ���õ�
{
	global $db;
	while($r=$db->sql_fetchrow($result))
	{
		$i++;
		$song_id=$r["song_id"];
		$song_name=$r["song_name"];
		$song_count=$r["song_count"];
		$song_addtime=$r["song_addtime"];
		$song_lyric=$r["song_lyric"];
		?>
	<tr>
		<td><?=$i?></td>
		<td><?=$song_name?></td>
		<td><?=$song_addtime?></td>
		<td align=center><?=$song_count?></td>
		<td align=center><a href="play.php?song_id=<?=$song_id?>"><img src='image/play1.gif' border=0></a></td>
		<td align=center><a href="download.php?song_id=<?=$song_id?>"><img src='image/download1.gif' border=0></a></td>
		<td align=center>
		<?
		if($song_lyric)
		{
			echo '<a href="http://'.$_SERVER["HTTP_HOST"].'/'.str_replace(' ','%20',$song_lyric).'" title="���ط���:������Ҽ�->Ŀ�����Ϊ..."><img src="image/lyric.gif" border=0></a>';
		}
		else
		{
			echo '��';
		}
		?>
		</td>
	</tr>
	<tr>
		<td height=1 colspan=7><img src='../image/point1.gif' height=1 width=100%></td>
	</tr>
	<?
	}
}
function listTable3($result)//�������ҳ��
{
	global $db,$searchtype,$keyword;
	$i=0;
	while($r=$db->sql_fetchrow($result))
	{
		$i++;
		$song_id=$r["song_id"];
		$song_name=$r["song_name"];
		$singer_id=$r["singer_id"];
		$singer_name=getSingerName($singer_id);
		$album_id=$r["album_id"];
		$album_name=getAlbumName($album_id);
		$song_count=$r["song_count"];
		$song_addtime=$r["song_addtime"];
		$song_lyric=$r["song_lyric"];
		?>
	<tr>
		<td><?=$i?></td>
		<td><acronym title="<?=$song_name?>">
		<?
		if($searchtype=='multi'||$searchtype=='song')
		{	
			if(strlen($song_name)<=24)
			{
				echo str_replace($keyword,'<span style="color:#ff0000">'.$keyword.'</span>',$song_name);
			}
			else
			{
				echo str_replace($keyword,'<span style="color:#ff0000">'.$keyword.'</span>',substr($song_name,0,22)).'...';
			}
		}
		else
		{
			if(strlen($song_name)<=24)
			{
				echo $song_name;
			}
			else
			{
				echo substr($song_name,0,22).'...';
			}
		}
		?>
		</acronym></td>
		<td>
		<?
		if($album_id!=0)
		{
			?>
			<a href="album_info.php?album_id=<?=$album_id?>" title="<?=$album_name?>">
			<?
			if($searchtype=='multi'||$searchtype=='album')
			{	
				if(strlen($album_name)<=16)
				{
					echo str_replace($keyword,'<span style="color:#ff0000">'.$keyword.'</span>',$album_name);
				}
				else
				{
					echo str_replace($keyword,'<span style="color:#ff0000">'.$keyword.'</span>',substr($album_name,0,14)).'...';
				}
			}
			else
			{
				if(strlen($album_name)<=16)
				{
					echo $album_name;
				}
				else
				{
					echo substr($album_name,0,14).'...';
				}
			}
			?>
			</a>
			<?
		}
		else
		{
			?>
			����</td>
			<?
		}
		?>
		<td><a href="singer_info.php?singer_id=<?=$singer_id?>">
		<?
		if($searchtype=='multi'||$searchtype=='singer')
		{
			echo str_replace($keyword,'<span style="color:#ff0000">'.$keyword.'</span>',$singer_name);
		}
		else
		{
			echo $singer_name;
		}
		?></a></td>
		<td><?=$song_addtime?></td>
		<td align=center><?=$song_count?></td>
		<td align=center><a href="play.php?song_id=<?=$song_id?>"><img src='image/play1.gif' border=0></a></td>
		<td align=center><a href="download.php?song_id=<?=$song_id?>"><img src='image/download1.gif' border=0></a></td>
		<td align=center>
		<?
		if($song_lyric)
		{
			echo '<a href="http://'.$_SERVER["HTTP_HOST"].'/'.str_replace(' ','%20',$song_lyric).'" title="���ط���:������Ҽ�->Ŀ�����Ϊ..."><img src="image/lyric.gif" border=0></a>';
		}
		else
		{
			echo '��';
		}
		?>
		</td>
	</tr>
	<tr>
		<td height=1 colspan=9><img src='../image/point1.gif' height=1 width=100%></td>
	</tr>
	<?
	}
}

function getSingerName($singer_id)//���ݸ���id���ظ�����
{
	global $db;
	$sql1="select singer_name from singer_info where singer_id=".$singer_id;
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function getAlbumName($album_id)//����ר��id����ר����
{
	global $db;
	$sql1="select album_name from album_info where album_id=".$album_id;
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function getSongName($song_id)//���ݸ���id���ظ�����
{
	global $db;
	$sql1="select song_name from song_info where song_id=".$song_id;
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function getSingerNameBySong($song_id)//���ݸ���id���ظ�����
{
	global $db;
	$sql1="select singer_info.singer_name from singer_info,song_info where song_info.song_id=".$song_id." and singer_info.singer_id=song_info.singer_id";
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function getAlbumNameBySong($song_id)//���ݸ���id����ר����
{
	global $db;
	$sql1="select album_info.album_name from album_info,song_info where song_info.song_id=".$song_id." and album_info.album_id=song_info.album_id";
	if($result1=$db->sql_query($sql1) && $db->sql_numrows($result1))
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return '��';
	}
}
function getSingerNameByAlbum($album_id)
{
	global $db;
	$sql1="select singer_info.singer_name from singer_info,album_info where album_info.album_id=".$album_id." and singer_info.singer_id=album_info.singer_id";
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}

function getSongPath($song_id)//���ݸ���id���ز���·��
{
	global $db;
	$sql1="select song_path from song_info where song_id=".$song_id;
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function comment($project,$prid1,$prid2)//�û�����ģ��
{
	global $db;
	if(strrpos($_SERVER["REQUEST_URI"],'#'))
	{
		$_SESSION['comment_url']=substr($_SERVER["REQUEST_URI"],0,-8);
	}
	else
	{
		$_SESSION['comment_url']=$_SERVER["REQUEST_URI"];
	}
	$sql1="select * from comments where project='".$project."' and prid1='".$prid1."' and prid2='".$prid2."' order by id desc";
	$result1=$db->sql_query($sql1);
	$comment_num=$db->sql_numrows($result1);
	?>
	<img src="image/comment.gif"><a name="comment"></a>
	<?
	if($comment_num>0)
	{
		?>
	��<span style="color:#FF9933;font-weight:bold"><?=$comment_num?></span>������
	<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#e0e0e0">
	<tr bgcolor="#3399CC">
		<td height="26">&nbsp;</td>
		<td align="center" nowrap>������</td>
		<td align="center">��������</td>
		<td align="center">����ʱ��</td>
	</tr>
		<?
		$i=0;
		while($r=$db->sql_fetchrow($result1))
		{
			?>
	<tr>
		<td nowrap style="padding:0 2px"> <span style="color:#ff0000"><?=$comment_num-$i?></span> ¥</td>
		<td align="center" style="padding:0 2px"><?=$r["name"]?></td>
		<td><?=preg_replace('/\[face\](.*?)\[\/face\]/is','<img src="image/face/\\1.gif" valign="absmiddle">',nl2br(htmlspecialchars($r["content"])));?> </td>
		<td nowrap><?=$r["posttime"]?></td>
	</tr>
			<?
			$i++;
		}
		?>
	</table>
		<?
	}
	?>
	<script type="text/JavaScript" language="javascript">
	function wordCount()
	{
		var maxLen=1024;
		if (document.form3.content.value.length > maxLen)
		{
			document.form3.content.value = document.form3.content.value.substring(0,maxLen);
		}
		else
		{
			document.getElementById('wordCount').innerHTML=document.form3.content.value.length;
		}
	}
	function addface(id)
	{
		document.form3.content.value+='[face]'+id+'[/face]';
	}
	</script>
	<form name="form3" method="post" action="comment_do.php">
	<input type="hidden" name="project" value="<?=$project?>">
	<input type="hidden" name="prid1" value="<?=$prid1?>">
	<input type="hidden" name="prid2" value="<?=$prid2?>">
	<fieldset>
		<legend>��������</legend>
		<table cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				���֣�
			</td>
			<td>
				<input type="text" name="name" value=""/>(����<span style="color:#ff0000">*</span>)
			</td>
		</tr>
		<tr>
			<td>
				E-mail��
			</td>
			<td>
				<input type="text" name="email" value=""/>
			</td>
		</tr>
		<tr>
			<td>
				��ҳ��
			</td>
			<td>
				<input type="text" name="homepage" value=""/>
			</td>
		</tr>
		<tr>
			<td>
				���ۣ�
			</td>
			<td>
				<textarea name="content" cols="50" rows="6" onKeyUp="wordCount()" onKeyDown="wordCount()"></textarea><br />���1024�֣���ǰ����:<span id="wordCount" style="color:#ff0000">0</span>
			</td>
		</tr>
		<tr>
			<td>���飺</td>
			<td><input type="radio" name="face" value="0" checked>�� 
				<input type="radio" name="face" value="01" onclick="addface(this.value)"><img src="image/face/01.gif" width="20" height="20">
				<input type="radio" name="face" value="02" onclick="addface(this.value)"><img src="image/face/02.gif" width="20" height="20">
				<input type="radio" name="face" value="03" onclick="addface(this.value)"><img src="image/face/03.gif" width="20" height="20">
				<input type="radio" name="face" value="04" onclick="addface(this.value)"><img src="image/face/04.gif" width="20" height="20">
				<input type="radio" name="face" value="05" onclick="addface(this.value)"><img src="image/face/05.gif" width="20" height="20">
				<input type="radio" name="face" value="06" onclick="addface(this.value)"><img src="image/face/06.gif" width="20" height="20">
				<input type="radio" name="face" value="07" onclick="addface(this.value)"><img src="image/face/07.gif" width="20" height="20">
				<input type="radio" name="face" value="08" onclick="addface(this.value)"><img src="image/face/08.gif" width="20" height="20">
			</td>
		</tr>
		<tr>
			<td colspan=2><input type="submit" name="submit4" value="��������"></td>
		</tr>
		</table>
	</fieldset>
	</form>
	<?
}
?>
