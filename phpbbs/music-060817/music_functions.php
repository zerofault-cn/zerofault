<?
function unformat($text)//反格式化,将经过html格式化的内容还原到textarea中显示
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
function musicSearchTable()//音乐搜索表格
{
	?>
<script language="javascript">
function check()
{
	if(window.document.form1.keyword.value=="")
	{
		alert("请输入搜索关键字");
		document.form1.keyword.focus();
		return false;
	}
	return true;
}
</script>

<table width="100%" border=0 cellpadding=0 cellspacing=0>
<form name="form1" action='search.php' method="post" onsubmit="return check();">
<tr>
	<td colSpan=3 height=20 align=center background="../image/white_top.gif"><img src="../image/search.gif" width=16 height=16 align="absmiddle">音乐搜索</td>
</tr>
<tr>
	<td width=10 height=100% rowspan=2 align=right valign=top><img height="100%" src="../image/point2.gif" width=1></td>
	<td width=150 align=center><input name=keyword size=14>
	<td width=10 height=100% rowspan=2 valign=top><img height="100%" src="../image/point2.gif" width=1></td>
</tr>
<tr>
	<td align=center><select name="searchtype">
		<option value="multi">搜索类型</option>
		<option value="song">歌曲</option>
		<option value="singer">歌手</option>
		<option value="album">专辑</option>
		<option value="multi">全部</option>
		</select>&nbsp;&nbsp;
		<input type="submit" value='搜' class="button">
	</td>
</tr>
<tr>
	<td height=20 colspan=3 background="../image/white_bottom.gif"></td>
</tr>
</form>
</table>
	<?
}

function menuTable()//左边菜单表格
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
	<td background="../image/white_top.gif" colSpan=3 height=20 valign=center align=center><img src="image/icon3.gif" width=18 height=18 align="absmiddle">导航菜单</td>
</tr>
<tr>
	<td width=10 height="100%" rowSpan=4 align=right valign=top><img height="100%" src="../image/point2.gif" width=1></td>
	<td  width=150 height=20><div style="margin-left:1.6em"><img name="img0" src="image/folder1.gif" width=16 height=16 align="absmiddle"><a href="javascript: t(document.all.div0,document.img0)"><span class=red>歌手列表</span></a></div>
	<div id=div0 style="display: none">
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php" class=bigger>所有歌手</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=16" class=bigger>港台男歌手</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=17" class=bigger>港台女歌手</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=18" class=bigger>港台组合</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=26" class=bigger>内地男歌手</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=27" class=bigger>内地女歌手</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=28" class=bigger>内地组合</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=30" class=bigger>其他地区</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="singer_list.php?list_id=59" class=bigger>纯音乐</a></div>
	</div></td>
	<td width=10 height=100% rowspan=4 valign=top><img height="100%" src="../image/point2.gif" width=1></td>
</tr>
<tr>
	<td height=20><div style="margin-left:1.6em"><img name="img1" src="image/folder1.gif" width=16 height=16 align="absmiddle"><a href="javascript: t(document.all.div1,document.img1)"><span class=red>专辑列表</span></a></div>
	<div id=div1 style="display: none">
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="album_list.php?sort_field=album_id" class=bigger>最新专辑</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="album_list.php?sort_field=album_count" class=bigger>热门专辑</a></div>
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="album_list.php?sort_field=album_quality" class=bigger>推荐专辑</a></div>
	</div></td>
</tr>
<tr>
	<td height=20><div style="margin-left:1.6em"><img name="img2" src="image/folder1.gif" width=16 height=16 align="absmiddle"><a href="javascript: t(document.all.div2,document.img2)"><span class=red>单曲列表</span></a></div>
	<div id=div2 style="display: none">
	<div style="margin-left:1.6em"><img src="image/link.gif"><a href="single_song.php" class=bigger>所有单曲</a></div>
	
	</div></td>
</tr>
<tr>
	<td height=20>
	<div style="margin-left:1.6em"><img src="image/link0.gif" align="absmiddle"><a href='music_upload.php' class=bigger><span class=red>上传歌曲</span></a></div></td>
</tr>
<tr>
	<td height=20 colspan=3 background="../image/white_bottom.gif"></td>
</tr>
</table>
	<?
}

function hotAlbumTable()//热门专辑列表
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
	<td height=20 colspan=3 align=center background="../image/white_top.gif"><img src="image/icon1.gif" width=16 height=16 align="absmiddle">专辑排行</td>
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
function hotSongTable()//热门歌曲列表
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
	<td height=20 colspan=3 align=center background="../image/white_top.gif"><img src="image/icon1.gif" width=16 height=16 align="absmiddle">歌曲排行</td>
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

function downloadTable()//工具下载表格
{
	?>
<table width="100%" border=0 cellPadding=0 cellSpacing=0>
<tr>
	<td height=20 colspan=3 align=center background="../image/white_top.gif"><img src="image/icon2.gif" width=16 height=16 align="absmiddle">推荐软件</td>
</tr>
<tr>
	<td width=10 height="100%" rowspan=2 align=right valign=top><img height="100%" src="../image/point2.gif" width=1></td>
	<td width=150 align=center><a href="image/winamp.exe"><img src="image/winamp.gif" width=90 border=0></a><br>Winamp2.81中文版</td>
	<td width=10 height=100% rowspan=2 valign=top><img height="100%" src="../image/point2.gif" width=1></td>
</tr>
<tr>
	<td align=center><a href="minilyrics.zip"><img src="image/minilyrics.gif" width=120 border=0></a><br>迷你歌词3.3.1378<td>
</tr>
<tr>
	<td height=20 colspan=3 background="../image/white_bottom.gif"></td>
</tr>
</table>
	<?
}

function newAlbum5()//首页主体部分显示5个最新专辑
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
function singleSong($song_ltype,$offset=0,$offpage=0,$allpage=0)//单曲列表,首页和单曲列表页面都用到
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
		<td height="20">歌曲名</td>
		<td>歌手</td>
		<td>加入时间</td>
		<td align=center>人气</td>
		<td align=center>播放</td>
		<td align=center>下载</td>
		<td align=center>歌词</td>
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
		echo '<tr><td height=30 colspan=7 align=center>暂时没有歌曲</td></tr>';
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
			echo "<a href='?offset=0&songlist=all'>首页</a>&nbsp;&nbsp;";
			$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
			echo "<a href='?offset=$preoffset&songlist=all'>上一页</a>&nbsp;&nbsp;";
		}
		if(($offset+$pageitem)<$rowCount)
		{
			$newoffset=$offset+$pageitem;
			$endpage=$rowCount-$pageitem;
			echo "<a href='?offset=$newoffset&songlist=all'>下一页</a>&nbsp;&nbsp;";
			echo "<a href='?offset=$endpage&songlist=all'>尾页</a>&nbsp;&nbsp;";
		}
		?>
			</td>
			<td>页码:<input onmouseover="this.select()" onmouseout="this.blur()" type=text name=offpage value='<?=ceil(($offset+1)/$pageitem)?>' size=2 style="height:18px;font-size:13px;color:red">
			/<span class=red><?=ceil($rowCount/$pageitem)?></span>,每页<span class=red><?=$pageitem?></span>首,共<span class=red><?=$rowCount?></span>首</td>
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
function listTable1($result)//单曲列表页面用到
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
			echo '<a href="http://'.$_SERVER["HTTP_HOST"].'/'.str_replace(' ','%20',$song_lyric).'" title="下载方法:点鼠标右键->目标另存为..."><img src="image/lyric.gif" border=0></a>';
		}
		else
		{
			echo '<a href="music_upload.php?upflag=lyrics&song_id='.$song_id.'">无</a>';
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
function listTable2($result)//专辑详细信息页面用到
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
			echo '<a href="http://'.$_SERVER["HTTP_HOST"].'/'.str_replace(' ','%20',$song_lyric).'" title="下载方法:点鼠标右键->目标另存为..."><img src="image/lyric.gif" border=0></a>';
		}
		else
		{
			echo '无';
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
function listTable3($result)//搜索结果页面
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
			单曲</td>
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
			echo '<a href="http://'.$_SERVER["HTTP_HOST"].'/'.str_replace(' ','%20',$song_lyric).'" title="下载方法:点鼠标右键->目标另存为..."><img src="image/lyric.gif" border=0></a>';
		}
		else
		{
			echo '无';
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

function getSingerName($singer_id)//根据歌手id返回歌手名
{
	global $db;
	$sql1="select singer_name from singer_info where singer_id=".$singer_id;
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function getAlbumName($album_id)//根据专辑id返回专辑名
{
	global $db;
	$sql1="select album_name from album_info where album_id=".$album_id;
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function getSongName($song_id)//根据歌曲id返回歌曲名
{
	global $db;
	$sql1="select song_name from song_info where song_id=".$song_id;
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function getSingerNameBySong($song_id)//根据歌曲id返回歌手名
{
	global $db;
	$sql1="select singer_info.singer_name from singer_info,song_info where song_info.song_id=".$song_id." and singer_info.singer_id=song_info.singer_id";
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function getAlbumNameBySong($song_id)//根据歌曲id返回专辑名
{
	global $db;
	$sql1="select album_info.album_name from album_info,song_info where song_info.song_id=".$song_id." and album_info.album_id=song_info.album_id";
	if($result1=$db->sql_query($sql1) && $db->sql_numrows($result1))
	{
		return $db->sql_fetchfield(0,0,$result1);
	}
	else
	{
		return '无';
	}
}
function getSingerNameByAlbum($album_id)
{
	global $db;
	$sql1="select singer_info.singer_name from singer_info,album_info where album_info.album_id=".$album_id." and singer_info.singer_id=album_info.singer_id";
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}

function getSongPath($song_id)//根据歌曲id返回播放路进
{
	global $db;
	$sql1="select song_path from song_info where song_id=".$song_id;
	return $db->sql_fetchfield(0,0,$db->sql_query($sql1));
}
function comment($project,$prid1,$prid2)//用户评论模块
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
	共<span style="color:#FF9933;font-weight:bold"><?=$comment_num?></span>条评论
	<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#e0e0e0">
	<tr bgcolor="#3399CC">
		<td height="26">&nbsp;</td>
		<td align="center" nowrap>评论人</td>
		<td align="center">评论内容</td>
		<td align="center">发表时间</td>
	</tr>
		<?
		$i=0;
		while($r=$db->sql_fetchrow($result1))
		{
			?>
	<tr>
		<td nowrap style="padding:0 2px"> <span style="color:#ff0000"><?=$comment_num-$i?></span> 楼</td>
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
		<legend>发表评论</legend>
		<table cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td>
				名字：
			</td>
			<td>
				<input type="text" name="name" value=""/>(必填<span style="color:#ff0000">*</span>)
			</td>
		</tr>
		<tr>
			<td>
				E-mail：
			</td>
			<td>
				<input type="text" name="email" value=""/>
			</td>
		</tr>
		<tr>
			<td>
				主页：
			</td>
			<td>
				<input type="text" name="homepage" value=""/>
			</td>
		</tr>
		<tr>
			<td>
				评论：
			</td>
			<td>
				<textarea name="content" cols="50" rows="6" onKeyUp="wordCount()" onKeyDown="wordCount()"></textarea><br />最多1024字，当前字数:<span id="wordCount" style="color:#ff0000">0</span>
			</td>
		</tr>
		<tr>
			<td>表情：</td>
			<td><input type="radio" name="face" value="0" checked>无 
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
			<td colspan=2><input type="submit" name="submit4" value="发表评论"></td>
		</tr>
		</table>
	</fieldset>
	</form>
	<?
}
?>
