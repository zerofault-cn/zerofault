<?
class Music
{
	var $offset;
	var $pageitem=20;
	var $label=Array(1,1,1,1,1,1,1,1,1);
	
	function getOffset()
	{
		return $this->offset;
	}
	function setOffset($offset)
	{
		$this->offset=$offset;
	}
	function getPageitem()
	{
		return $this->pageitem;
	}
	function setPageitem($pageitem)
	{
		$this->pageitem=$pageitem;
	}
	function setLabel($label)
	{
		$this->label=$label;
	}
	
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
	<form id="form1" name="form1" action='search.php' method="post" onsubmit="return checkform1();">
	<fieldset id="field1">
	<legend><img src="../images/search.gif" width="16" height="16" align="absmiddle">音乐搜索</legend>
	<div style="margin-left:10px;margin-top:5px"><input type="text" name="keyword" size="16"></div>
	<div style="margin-left:10px;margin-top:5px"><select name="searchtype">
		<option value="multi">搜索类型</option>
		<option value="song">歌曲</option>
		<option value="singer">歌手</option>
		<option value="album">专辑</option>
		<option value="multi">全部</option>
		</select><span style="margin-left:12px"><input type="submit" value='搜索' class="button"></span></div>
	</fieldset>
	</form>
		<?
	}

	function menuTable()//左边菜单表格
	{
		?>
	<fieldset id="field1">
	<legend><img src="images/icon3.gif" width="16" height="16" align="absmiddle">导航菜单</legend>
	<div id="treeMenu1"><img name="img0" src="images/folder1.gif" width="16" height="16" align="absmiddle"><a href="javascript:t(document.all.div0,document.img0)"><span class="red">歌手列表</span></a></div>
		<div id="div0" style="display:none">
		<div id="treeMenu2"><img src="images/link.gif"><a href="singer_list.php">所有歌手</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="singer_list.php?list_id=16">港台男歌手</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="singer_list.php?list_id=17">港台女歌手</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="singer_list.php?list_id=18">港台组合</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="singer_list.php?list_id=26">内地男歌手</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="singer_list.php?list_id=27">内地女歌手</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="singer_list.php?list_id=28">内地组合</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="singer_list.php?list_id=30">其他地区</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="singer_list.php?list_id=59">纯音乐</a></div>
		</div>
	<div id="treeMenu1"><img name="img1" src="images/folder1.gif" width="16" height="16" align="absmiddle"><a href="javascript: t(document.all.div1,document.img1)"><span class="red">专辑列表</span></a></div>
		<div id="div1" style="display:none">
		<div id="treeMenu2"><img src="images/link.gif"><a href="album_list.php?sort_field=album_id">最新专辑</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="album_list.php?sort_field=album_count">热门专辑</a></div>
		<div id="treeMenu2"><img src="images/link.gif"><a href="album_list.php?sort_field=album_quality">推荐专辑</a></div>
		</div>
	<div id="treeMenu1"><img name="img2" src="images/folder1.gif" width=16 height=16 align="absmiddle"><a href="javascript: t(document.all.div2,document.img2)"><span class=red>单曲列表</span></a></div>
		<div id="div2" style="display:none">
		<div id="treeMenu2"><img src="images/link.gif"><a href="single_song.php">所有单曲</a></div>
		</div>
	<div id="treeMenu1"><img src="images/link0.gif" align="absmiddle"><a href='music_upload.php'><span class="red">上传歌曲</span></a></div>
	</fieldset>
		<?
	}

	function hotAlbum5()//热门专辑列表
	{
		global $db;
		$sql1="select * from album_info order by album_count desc limit 0,5";
		$result1=$db->sql_query($sql1);
		?>
	<fieldset id="field1">
	<legend><img src="images/icon1.gif" width="16" height="16" align="absmiddle">专辑排行</legend>
		<?
		while($r=$db->sql_fetchrow($result1))
		{
			?>
	<div id="list1"><span><a href="album_info.php?album_id=<?=$r['album_id']?>" title="<?=$r['album_name']?>"><img src="images/item4.gif" border=0 align="absmiddle"><?=substr($r['album_name'],0,14)?> </a></span><?=$r['album_count']?></div>
			<?
		}
		?>
	</fieldset>
		<?
	}
	function hotSong5()//热门歌曲列表
	{
		global $db;
		$sql1="select * from song_info order by song_count desc limit 0,5";
		$result1=$db->sql_query($sql1);
		?>
	<fieldset id="field1">
	<legend><img src="images/icon1.gif" width="16" height="16" align="absmiddle">歌曲排行</legend>
		<?
		while($r=$db->sql_fetchrow($result1))
		{
			?>
	<div id="list1"><span><a href="play.php?song_id=<?=$r['song_id']?>" title="<?=$r['song_name']?>"><img src="images/item2.gif" border=0 align="absmiddle"><?=substr($r['song_name'],0,14)?> </a></span><?=$r['song_count']?></div>
			<?
		}
		?>
	</fieldset>
		<?
	}

	function downloadTools()//工具下载表格
	{
		?>
	<fieldset id="field1" style="text-align:center">
	<legend><img src="images/icon2.gif" width="16" height="16" align="absmiddle">推荐软件</legend>
	<div><a href="images/winamp.exe"><img src="images/winamp.gif" width="90" border="0"><br>Winamp2.81中文版</a></div>
	<div><a href="minilyrics.zip"><img src="images/minilyrics.gif" width="100" border=0><br>迷你歌词3.3.1378</a></div>
	</fieldset>
		<?
	}

	function newAlbum5()//首页主体部分显示5个最新专辑
	{
		global $db;
		$sql1="select * from album_info order by album_id desc limit 0,5";
		$result1=$db->sql_query($sql1);
		?>
		<img src="images/newalbum.gif">
		<div>
		<?
		while($r=$db->sql_fetchrow($result1))
		{
			?>
		<div id="newAlbum1">
		<div id="newAlbum1Photo"><a href="album_info.php?album_id=<?=$r['album_id']?>"><img src="albums/<?=$r['album_id']?>.jpg" onerror="this.src='images/no_photo.jpg';" width="96" border="0" id="albumPhoto"></a></div>
		<div><a href="album_info.php?album_id=<?=$r['album_id']?>"><?=substr($r['album_name'],0,14)?> </a></div>
		<div><a href="singer_info.php?singer_id=<?=$r['singer_id']?>"><?=getSingerName($r['singer_id'])?></a></div>
		<?=$r['album_pubdate']?>
		</div>
			<?
		}
		?>
		</div>
		<div id="more"><a style="color:#ff0000" href="album_list.php">More...</a></div>
		<?
	}

	function singleSong($song_ltype,$offset=0,$offpage=0,$allpage=0)//单曲列表,首页和单曲列表页面都用到
	{
		global $db;
		if($song_ltype=='new10')
		{
			echo '<img src="images/newsong.gif">';
			$this->label=Array(1,1,0,1,1,1,1,1,1);
		}
		else
		{
			echo '<img src="images/allsong.gif">';
			$this->label=Array(1,1,0,1,1,1,1,1,1);
		}
		$this->songListLabel();
		
		if(!$offset)
		{
			$this->offset=0;
		}
		else
		{
			$this->offset=$offset;
		}
		if($offpage&&$allpage)
		{
			$this->offset=($allpage-$offpage)*$this->pageitem;
		}
		if($song_ltype=='all')
		{
			$sql1="select * from song_info where album_id=0 order by song_id desc limit ".$this->offset.",".$this->pageitem;
			$sql2="select count(*) from song_info where album_id=0";
		}
		elseif($song_ltype=='new10')
		{
			$sql1="select * from song_info where album_id=0 order by song_id desc limit 10";
			$sql2="select count(*) from song_info where album_id=0 order by song_id desc limit 10";
		}
		$result1=$db->sql_query($sql1);
		$result2=$db->sql_query($sql2);
		$rowCount=$db->sql_fetchfield(0,0,$result2);
		if($rowCount==0)
		{
			?>
		<div id="songList" style="text-align:center">暂时没有歌曲</div>
			<?
		}
		else
		{
			$this->songList($result1);
			if($song_ltype=='new10')
			{
				?>
		<div id="more"><a style="color:#ff0000" href="single_song.php">More...</a></div>
				<?
			}
			if($song_ltype=='all')
			{
				$this->pageNavi($rowCount);
			}
		}
	}
	function pageNavi($rowCount)
	{
		?>
		<div id="pageNavi">
		<form action='<?=$_SERVER['PHP_SELF']?>' method="post" style="margin:0">
		<?
		if($this->offset!=0)
		{
			echo '<a href="?offset=0">首页</a>&nbsp;&nbsp;';
			$preoffset=($this->offset-$this->pageitem)>0?($this->offset-$this->pageitem):0;
			echo '<a href="?offset='.$preoffset.'">上一页</a>&nbsp;&nbsp;';
		}
		else
		{
			echo '首页&nbsp;&nbsp;';
			echo '上一页&nbsp;&nbsp;';
		}
		if(($this->offset+$this->pageitem)<$rowCount)
		{
			$newoffset=$this->offset+$this->pageitem;
			$endpage=$rowCount-$this->pageitem;
			echo '<a href="?offset='.$newoffset.'">下一页</a>&nbsp;&nbsp;';
			echo '<a href="?offset='.$endpage.'">尾页</a>&nbsp;&nbsp;';
		}
		else
		{
			echo '下一页&nbsp;&nbsp;';
			echo '尾页&nbsp;&nbsp;';
		}
		?>
		页码:<input onmouseover="this.select()" onmouseout="this.blur()" type="text" name="offpage" value="<?=ceil(($this->offset+1)/$this->pageitem)?>" size="1" style="height:18px;font-size:13px;color:red">/<span class="red"><?=ceil($rowCount/$this->pageitem)?></span>,每页<span class="red"><?=$this->pageitem?></span>首,共<span class="red"><?=$rowCount?></span>首
		<input type="hidden" name="allpage" value='<?=$allpage?>'>
		<input type="hidden" name="song_ltype" value="<?=$song_ltype?>">
		</form>
		</div>
		<?
	}

	function songListLabel()
	{
		$labels=Array('<span id="f0">序号</span>','<span id="f1">歌曲名</span>','<span id="f2">专辑</span>','<span id="f3">歌手</span>','<span id="f4">加入时间</span>','<span id="f5">人气</span>','<span id="f6">播放</span>','<span id="f7">下载</span>','<span id="f8">歌词</span>');
		?>
		<div id="songList" style="background-color:#3399CC;">
		<?
		for($i=0;$i<9;$i++)
		{
			if($this->label[$i])
			{
				echo $labels[$i];
			}
		}
		?>
		</div>
		<?
	}
	function songList($result)//歌曲列表页面用到
	{
		global $db,$searchtype,$keyword;
		$i=0;
		while($r=$db->sql_fetchrow($result))
		{
			$i++;
			$song_id=$r["song_id"];
			$song_name=$r["song_name"];
			$album_id=$r['album_id'];
			$album_name=getAlbumName($album_id);
			$singer_id=$r["singer_id"];
			$singer_name=getSingerName($singer_id);
			$song_count=$r["song_count"];
			$song_addtime=$r["song_addtime"];
			$song_lyric=$r["song_lyric"];
			?>
		<div id="songList">
			<?
			if($this->label[0])
			{
				echo '<span id="f0">'.($this->offset+$i).'</span>';
			}
			if($this->label[1])
			{
				echo '<acronym title="'.$song_name.'"><span id="f1">'.$this->convert($song_name,'song').' </span></acronym>';
			}
			if($this->label[2])
			{
				echo '<acronym title="'.$album_name.'"><span id="f2"><a href="album_info.php?album_id='.$album_id.'" title="'.$album_name.'">'.$this->convert($album_name,'album').' </a></span></acronym>';
			}
			else
			{
				?>
				<style>
				div#songList span#f0
				{
					width:40px;
				}
				div#songList span#f1
				{
					width:180px;
				}
				div#songList span#f3
				{
					width:100px;
				}
				div#songList span#f4
				{
					width:100px;
				}
				</style>
				<?
			}
			if($this->label[3])
			{
				echo '<acronym title="'.$singer_name.'"><span id="f3"><a href="singer_info.php?singer_id='.$singer_id.'" title="'.$singer_name.'">'.$this->convert($singer_name,'singer').' </a></span></acronym>';
			}
			else
			{
				?>
				<style>
				div#songList span#f1
				{
					width:240px;
				}
				div#songList span#f4
				{
					width:120px;
				}
				div#songList span#f5
				{
					width:60px;
				}
				</style>
				<?
			}
			if($this->label[4])
			{
				echo '<span id="f4">'.$song_addtime.'</span>';
			}
			if($this->label[5])
			{
				echo '<span id="f5">'.$song_count.'</span>';
			}
			if($this->label[6])
			{
				echo '<span id="f6"><a href="play.php?song_id='.$song_id.'"><img src="images/play1.gif" border="0"></a></span>';
			}
			if($this->label[7])
			{
				echo '<span id="f7"><a href="download.php?song_id='.$song_id.'"><img src="images/download1.gif" border="0"></a></span>';
			}
			if($this->label[8])
			{
				if($song_lyric)
				{
					echo '<span id="f8"><a href="http://'.$_SERVER["HTTP_HOST"].'/'.str_replace(' ','%20',$song_lyric).'" title="下载方法:点鼠标右键->目标另存为..."><img src="images/lyric.gif" border=0></a></span>';
				}
				else
				{
					echo '<span id="f8"><a href="music_upload.php?upflag=lyrics&song_id='.$song_id.'">无</a></span>';
				}
			}
			?>
		</div>
		<?
		}
	}
	function convert($name,$type)//截取限定长度的名称，以及搜索结果加亮
	{
		global $searchtype,$keyword;
		$maxsongNameLen=24;
		$maxalbumNameLen=24;
		$maxsingerNameLen=10;
		if(strlen($name)>${'max'.$type.'NameLen'})
		{
		//	echo 'cut';
			$tmp_name=substr($name,0,${'max'.$type.'NameLen'}).'...';
		}
		else
		{
		//	echo 'nocut';
			$tmp_name=$name;
		}
		if($searchtype=='multi'||$searchtype==$type)
		{
			$t_name=str_replace($keyword,'<span style="color:#ff0000">'.$keyword.'</span>',$name);
			$tt_name=str_replace('<span','span',$t_name);
			$n=strlen($t_name)-strlen($tt_name);
			$s1=strpos($t_name,'<');
			$s2=strpos($t_name,'>');
			if($s2>0)//表示在此列中有关键字替换
			{
			//	echo 'replace';
				if(strlen($t_name)>30)
				{
					$s4=strpos($t_name,'>',30);
				}
				else
				{
					$s4=strpos($t_name,'>');
				}
				if($s1>=${'max'.$type.'NameLen'})
				{
				//	echo 'case3';
					$tmp_name=substr($t_name,0,${'max'.$type.'NameLen'}).'...';
				}
				elseif($s1<${'max'.$type.'NameLen'} && ($s1+strlen($keyword)) >${'max'.$type.'NameLen'})
				{
				//	echo 'case2';
					$tmp_name=substr($t_name,0,$s1).'<span style="color:#ff0000">'.substr($t_name,strpos($t_name,'>')+1,${'max'.$type.'NameLen'}-$s1).'...</span>';
				}
				else
				{
					
					if(strlen($t_name)>(${'max'.$type.'NameLen'}+35*$n))
					{
				//		echo $t_name;
				//		echo strlen($t_name);
						$tmp_name=substr($t_name,0,${'max'.$type.'NameLen'}+35*$n).'...';
					}
					else
					{
				//		echo 'case0';
						$tmp_name=$t_name;
					}
				}
			}
		}
		return $tmp_name;
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
		<img src="images/comment.gif"><a name="comment"></a>
		<?
		if($comment_num>0)
		{
			?>
		共<span style="color:#FF9933;font-weight:bold"><?=$comment_num?></span>条评论
		<div id="commentList" style="background-color:#0099CC">
		<span id="f0"></span><span id="f1">评论人</span><span id="f2">评论内容</span><span id="f3">发表时间</span>
		</div>
			<?
			$i=0;
			while($r=$db->sql_fetchrow($result1))
			{
				?>
		<div id="commentList">
			<span id="f0"><span style="color:#ff0000"><?=$comment_num-$i?></span> 楼</span><span id="f1"><?=$r["name"]?></span><span id="f2"><?=preg_replace('/\[face\](.*?)\[\/face\]/is','<img src="images/face/\\1.gif" valign="absmiddle">',nl2br(htmlspecialchars($r["content"])));?> </span><span id="f3"><?=$r["posttime"]?></span>
		</div>
				<?
				$i++;
			}
		}
		?>
		<form name="form3" method="post" action="comment_do.php">
		<input type="hidden" name="project" value="<?=$project?>">
		<input type="hidden" name="prid1" value="<?=$prid1?>">
		<input type="hidden" name="prid2" value="<?=$prid2?>">
		<fieldset>
			<legend>发表评论</legend>
			<div><span id="commentLabel">名字:</span><input type="text" name="name" value=""/>(必填)</div>
			<div><span id="commentLabel">E-mail:</span><input type="text" name="email" value=""/></div>
			<div><span id="commentLabel">主页:</span><input type="text" name="homepage" value=""/></div>
			<div><span id="commentLabel">评论:</span><textarea name="content" cols="50" rows="6" onKeyUp="wordCount()" onKeyDown="wordCount()"></textarea>最多1000字，当前<span id="wordCount" style="color:#ff0000">0</span>字</div>
			<div><span id="commentLabel">表情:</span>
				<input type="radio" name="face" value="0" checked>无 
				<input type="radio" name="face" value="01" onclick="addface(this.value)"><img src="images/face/01.gif" width="20" height="20">
				<input type="radio" name="face" value="02" onclick="addface(this.value)"><img src="images/face/02.gif" width="20" height="20">
				<input type="radio" name="face" value="03" onclick="addface(this.value)"><img src="images/face/03.gif" width="20" height="20">
				<input type="radio" name="face" value="04" onclick="addface(this.value)"><img src="images/face/04.gif" width="20" height="20">
				<input type="radio" name="face" value="05" onclick="addface(this.value)"><img src="images/face/05.gif" width="20" height="20">
				<input type="radio" name="face" value="06" onclick="addface(this.value)"><img src="images/face/06.gif" width="20" height="20">
				<input type="radio" name="face" value="07" onclick="addface(this.value)"><img src="images/face/07.gif" width="20" height="20">
				<input type="radio" name="face" value="08" onclick="addface(this.value)"><img src="images/face/08.gif" width="20" height="20">
			</div>
			<div><span style="margin-left:60px;"><input type="submit" name="submit4" value="发表评论"></span></div>
		</fieldset>
		</form>
		<?
	}

}//Class End


function getSingerName($singer_id)//根据歌手id返回歌手名
{
	global $db;
	$sql1="select singer_name from singer_info where singer_id=".$singer_id;
	if($result1=$db->sql_query($sql1))
	{
		if($db->sql_numrows($result1))
		{
			return $db->sql_fetchfield(0,0,$result1);
		}
	}
	return '无';
}
function getAlbumName($album_id)//根据专辑id返回专辑名
{
	global $db;
	$sql1="select album_name from album_info where album_id=".$album_id;
	if($result1=$db->sql_query($sql1))
	{
		if($db->sql_numrows($result1))
		{
			return $db->sql_fetchfield(0,0,$result1);
		}
	}
	return '无';
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

?>
