<?
function serverInfoTable()
{
	?>
<table width="100%" border=0 cellPadding=0 cellSpacing=0>
<tr>
	<td height=20 colspan=3 align=center background="image/white_top.gif"><img src="image/info.gif" width=16 height=16 align="absmiddle">ϵͳͳ��</td>
</tr>
<tr>
	<td width=10 height="100%" rowspan=2 align=right valign=top><img height="100%" src="image/point2.gif" width=1></td>
	<td width=150 align="center">�ѱ�����</td>
	<td width=10 height="100%" rowspan=2 valign=top><img height="100%" src="image/point2.gif" width=1></td>
</tr>
<tr>
	<td>&nbsp;<td>
</tr>
<tr>
	<td height=20 colspan=3 background="image/white_bottom.gif"></td>
</tr>
</table>
	<?
}
function msgTable($msg_type,$itemnum)
{
	global $db;
	$title=array('message'=>'������Ϣ','tech'=>'��������','feeling'=>'�������','joke'=>'����Ц��');
	?>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr bgcolor="#6E94B7">
		<td height=16>
		<table height="100%" border=0 cellPadding=0 cellSpacing=0>
		<tr>
			<td><a href='board/index.php?infotype=<?=$msg_type?>'><IMG border=0 height=16 src="image/<?=$msg_type?>.gif" width=16></a></td>
			<td style="filter:glow(color=#4400ff,Strength=2)"><a href='board/index.php?infotype=<?=$msg_type?>'><?=$title[$msg_type]?></a></td>
			<td></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td valign=top>
		<?
		if($msg_type=='message')
		{	
		//	echo '<li><a href=http://www.itscu.com/shop/index.asp target=_blank title=http://www.itscu.com><span class=red>��ӭ����ITУ԰���ɹ��ͼ۵������</span></a>&nbsp;&nbsp;<a href="http://211.83.118.100:800/listen.pls"><span class=red>�������ֵ�̨</span></a>';
		//	include "utilities/testShoutCast.php";
		}
		$query="select id,time,title from board where type='".$msg_type."' order by id desc limit ".$itemnum;
		$result=$db->sql_query($query);
		while($r=$db->sql_fetchrow($result))
		{
			$fid=$id=$r["id"];
			$ftitle=$r["title"];
			$ftime=$r["time"];
			echo "<li><a href='board/info.php?fid=".$fid."&id=".$id."' title='".$ftitle."'>";
			if(strlen($ftitle)>34&&($msg_type=='message'||$msg_type=='tech'))
				echo substr($ftitle,0,32).'...';
			elseif(strlen($ftitle)>20&&$msg_type=='feeling')
				echo substr($ftitle,0,20).'...';
			elseif(strlen($ftitle)>16&&$msg_type=='joke')
				echo substr($ftitle,0,16).'...';
			else
				echo $ftitle;
			echo '</a><span class=small>('.$ftime.')</span>';
		}
		?>
		</td>
	</tr>
	<tr>
		<td height=10 align=right><a href='board/index.php?infotype=<?=$msg_type?>'>more...</a></td>
	</tr>
	</table>
	<?
}
	
function loginTable()
{
	?>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<form name="frmLogin" action="/yabbcn1101/index.php?board=;action=login2" method="post">
	<tr>
		<td background="image/leftop.gif" colSpan=4 height=20 vAlign=center align=center>
		<table height="100%" border=0 cellPadding=0 cellSpacing=0>
		<tr>
			<td><img height=16 src="/yabbcn1101/YaBBImages/login_sm.gif" width=16></td>
			<td style="filter:glow(color=#FF6984,Strength=2)">��̳��¼</td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align=right height="100%" rowSpan=5 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
		<td align="right">�û���:</td>
		<td><input type=text name="user" size=10></td>
		<td height=100% rowSpan=5 valign=top width=10><img height="100%" src="image/point.gif" width=1></td>
	</tr>
	<tr>
		<td align="right">����:</td>
		<td><input type=password name="passwrd" size=10></td>
	</tr>
	<tr>
		<td align="right">�Ự�ڼ�:</td>
		<td><input type=text name="cookielength" size=4 maxlength="4" value="60">[����]</td>
	</tr>
	<tr>
		<td align="right">���ֵ�¼:</td>
		<td><input type=checkbox name="cookieneverexp">&nbsp;&nbsp;<button onclick="javascript:window.location='/yabbcn1101/index.php'">����</button></td>
	</tr>
	<tr>
		<td align=center><input type=submit value="��¼"></td>
		<td align=left><button onclick="javascript:window.location='/yabbcn1101/Reminder.php?action=input_user;s=';">��������</button></td>
	</tr>
	<tr>
		<td background="image/rightbottom.gif" colSpan=4 height=20>&nbsp;</td>
	</tr>
	</form>
	</table>
	<?
}

function astroTable()
{
	?>
	<script language=javascript src="astro.js"></script>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<form name=date action='' method="post">
	<tr>
		<td height=20 colspan=3 align=center background="image/white_top.gif"><img height=16 src="" width=16><span style="filter:glow(color=#FF6984,Strength=3)">������Ը</span></td>
	</tr>
	<tr>
		<td width=10 height="100%" rowspan=5 align=right valign=top><img height="100%" src="image/point2.gif" width=1></td>
		<td width=150 align=center>ֻ��ѡ���������գ�</td>
		<td width=10 height="100%" rowspan=5 valign=top><img height="100%" src="image/point2.gif" width=1></td>
	</tr>
	<tr>
		<td align="center">
		<select name=year>
	<?
	for($i=1970;$i<=2004;$i++)
	{
		echo '<option value='.$i;
		if($i==1981)
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
		</select>
		<select name=month>
	<?
	for($i=1;$i<=12;$i++)
	{
		echo '<option value='.$i;
		if($i==12)
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
		</select>
		<select name=day>
	<?
	for($i=1;$i<=31;$i++)
	{
		echo '<option value='.$i;
		if($i==17)
			echo ' selected';
		echo '>'.$i.'</option>';
	}
	?>
		</select>
		</td>
	</tr>
	<tr>
		<td align="center"><input name="submit" type="submit" value='�鿴��Ф' disabled></td>
	</tr>
	<tr>
		<td align="center"><input type=button onclick="go_astro();" value='�鿴�����˳�'></td>
	</tr>
	<tr>
		<td align="center"><input type=button onclick="go_birthday();" value='�鿴��������'></td>
	</tr>
	<tr>
		<td height=20 colspan=3 background="image/white_bottom.gif"></td>
	</tr>
	</form>
	</table>
	<?
}

function searchTable()
{
	?>
	<script language="javascript">
	function check()
	{
		if(window.document.search.type.value=="")
		{
			alert("������ѡ������");
			document.search.type.focus();
			return false;
		}
		return true;
	}
	</script>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<form name='search' action='multi_search.php' method=post onsubmit='return check();'>
	<tr>
		<td height=20 colspan=3 align=center background="image/white_top.gif"><img height=16 src="image/search.gif" width=16>ȫվ����</td>
	</tr>
	<tr>
		<td width=10 height="100%" rowspan=2 align=right valign=top><img height="100%" src="image/point2.gif" width=1></td>
		<td width=150 align=center><input maxlength=100 name=keyword size=14></td>
		<td width=10 height="100%" rowspan=2 valign=top><img height="100%" src="image/point2.gif" width=1></td>
	</tr>
	<tr>
		<td align=middle height=20>
		<select name=type>
		<option selected>ѡ������</option>
		<option value=music>����</option>
		<option value=soft>���</option>
		<option value=board>����</option>
		</select>&nbsp;&nbsp;
		<input type=submit value='go' class=button></td>
	</tr>
	<tr>
		<td height=20 colspan=3 background="image/white_bottom.gif"></td>
	</tr>
	</form>
	</table>
	<?
}
	
function jokeDailyTable()
{
	?>
	<script language="JavaScript">
	<!--
	function sbar (st,col) { st.style.border = col; }
	function cbar (st) { st.style.border = 0; }
	function mov(a){
			scrollx=new_date.document.body.scrollLeft
			scrolly=new_date.document.body.scrollTop
			scrolly=scrolly+a
			new_date.window.scroll(scrollx,scrolly)
			}
	function movstar(a,time){
			movx=setInterval("mov("+a+")",time)
			}
	function movover(){
			clearInterval(movx)
			}
	//-->
	</script>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td height=20 colspan=3 align=center background="image/white_top.gif"><img height=16 src="image/user.gif" width=16><span style="filter:glow(color=#FF6984,Strength=3)">ÿ��һЦ</span></td>
	</tr>
	<tr>
		<td width=10 height="100%" rowspan=2 align=right valign=top><img height="100%" src="image/point2.gif" width=1></td>
		<td width=150 align=center><img height=20 width=16 src="image/up.gif" border="0" alt="���Ϲ���...��ס�������ø���" onMouseUp="movover();movstar(-1,20)" onMouseDown="movover();movstar(-3,2)" onMouseOver="movstar(-1,20);" onMouseOut="movover()">&nbsp;&nbsp;
		<img height=20 width=16 src="image/down.gif" border="0" alt="���¹���...��ס�������ø���" onMouseUp="movover();movstar(1,20)" onMouseDown="movover();movstar(3,2)" onMouseOver="movstar(1,20)" onMouseOut="movover()"></td>
		<td width=10 height="100%" rowspan=2 valign=top><img height="100%" src="image/point2.gif" width=1></td>
	</tr>
	<tr>
		<td width=150>
		<iframe border=0 name="new_date" marginwidth=0 framespacing=0 marginheight=0 src="jokedaily.php" frameborder=0 noResize width="100%" scrolling=no height=240 vspale="0"></iframe></td>
	</tr>
	<tr>
		<td height=20 colspan=3 background="image/white_bottom.gif"></td>
	</tr>
	</table>
<?
}

function newMusicTable()
{
	global $db;
	include_once 'music/music_class.php';
	$sql1="select * from song_info order by song_count desc limit 0,5";
	$result1=$db->sql_query($sql1);
	while($r=$db->sql_fetchrow($result1))
	{
		$song_id[]=$r['song_id'];
		$singer_id[]=$tmp=$r['singer_id'];
		$song_name[]=$r['song_name'];
		$singer_name[]=getSingerName($tmp);
	}
	$i=0;
	?>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td height=20 colspan=3 align=center background="image/white_top.gif"><a href='music/index.php'><img src="image/winamp.ico" height=16 width=16 border=0><span style="filter:glow(color=#ff6984,strength=3)">���¸���</span></a></td>
	</tr>
	<tr>
		<td width=10 height="100%" rowspan=6 align=right valign=top><img height="100%" src="image/point2.gif" width=1></td>
		<td width=150></td>
		<td width=10 height="100%" rowspan=6 valign=top><img height="100%" src="image/point2.gif" width=1></td>
	</tr>
	
	<?
	for($i=0;$i<5;$i++)
	{
		?>
	<tr>
		<td>&nbsp;<a href="play.php?song_id=<?=$song_id[$i]?>" title="<?=$song_name[$i]?>"><?=substr($song_name[$i],0,10)?></a>|<a href="music/singer_info.php?singer_id=<?=$singer_id[$i]?>"><?=$singer_name[$i]?></a></td>
	</tr>
		<?
	}
	?>
	<tr>
		<td height=20 colspan=3 background="image/white_bottom.gif"></td>
	</tr>
	</table>
	<?
}

function newDownTable()
{
	?>
	<table width="100%" border=0 cellPadding=0 cellSpacing=0>
	<tr>
		<td height=20 colspan=3 align=center background="image/white_top.gif"><a href='/phpbbs/download/index.php'><img src="image/download.gif" height=16 width=16 border=0><span style="filter:glow(color=#FF6984,Strength=3)">�������</a></span></td>
	</tr>
	<?
	$query1="select * from software order by id desc limit 9";
	$result1=mysql_query($query1);
	while($r=mysql_fetch_array($result1))
	{
		$id=$r["id"];
		$name=$r["name"];
		$type=$r["type"];
		?>
	<tr>
		<td align=right height=100% valign=top width=10><img height="100%" src="image/point2.gif" width=1></td>
		<td width=150>&nbsp;<a href='download/download.php?id=<?=$id?>' title='<?=$name?>'>
					<?
					if(strlen($name)>8)
						echo substr($name,0,8).'...';
					else
						echo $name;
					?></a>|<a href='download/index.php?searchtype=<?=$type?>'><?=$type?></a></td>
		<td align=left height=100% valign=top width=10><img height="100%" src="image/point2.gif" width=1></td>
	</tr>
		<?
	}
	?>
	<tr>
		<td height=20 colspan=3 background="image/white_bottom.gif"></td>
	</tr>
	</table>
	<?
}
?>
