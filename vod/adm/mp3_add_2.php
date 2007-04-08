<!-- 添加MP3音乐-2 -->
<?
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=addslashes($text);
	return $text;
}
if(strpos($mp3file_name,"\\"))
{
	$mp3file_name=substr(strrchr($mp3file_name,"\\"),1);
}
echo $mp3file_name;
$file_ext=substr($mp3file_name,-4);
if($file_ext!=".mp3"&&$file_ext!=".MP3")
{
	?>
	<script>
		alert("这不是一个MP3文件，请重新选择文件!");
		window.history.go(-1);
	</script>
	<?
}
else
{
	include_once "admin_limit.php";
	include_once "../include/mysql_connect.php";
	$sql1="select id from song_info where song_name='".$song_name."' and singer_id='".$singer_id."'";	
	$result1=mysql_query($sql1);
	if(mysql_fetch_array($result1))
	{
		?>
		<script>
			alert("这首MP3已经存在，请添加其他文件!");
			window.history.go(-1);
		</script>
		<?
	}
	else
	{
		$pub_dir='bod/server14_4/mp3_2/';
		include_once "toPinyin.php";
		$sql2="select singer_name from singer_info where singer_id='".$singer_id."'";
		$result2=mysql_query($sql2);
		$singer_name=mysql_result($result2,0,0);
		$singer_name_py=words(str_replace(' ','_',$singer_name));//将歌手名转换为拼音
		$album_name_py=words(str_replace(' ','_',$album_name));//专辑名转换
		$mp3file_name_py=words(str_replace(' ','_',$mp3file_name));//将歌曲名转换为拼音,只转换中文字符
		$file_name=$album_name_py.'-'.$mp3file_name_py;
		$singer_dir='/dpfs/'.$pub_dir.$singer_name_py;
		if(!file_exists($singer_dir))
		{
			umask(000);
			mkdir($singer_dir,0777);
		}
		$path=$pub_dir.$singer_name_py.'/'.$file_name;
		$upflag=-1;
		if(isset($up_flag)&&$up_flag!='')
		{
			echo 'upload:'.$upflag=copy($mp3file,$singer_dir.'/'.$file_name);
		}
		$sql3="insert into song_info(song_name,singer_id,album_name,path,lyric,time,del_flag) values('".$song_name."','".$singer_id."','".$album_name."','".$path."','".format($song_lyric)."',now(),'".$upflag."')";
		if(isset($up_flag)&&$up_flag!='')
		{
			if($upflag==1&&mysql_query($sql3))
			{
				?>
				<script>
					alert("提示:文件已上传到‘<?=$singer_dir?>’目录，文件名为‘<?=$file_name?>’");
					if(confirm("继续添加吗?"))
						window.history.go(-1);
					else
						window.location="index.php?content=mp3_list&listtype=new";
				</script>
				<?
			}
			else
			{
				?>
				<script>
					alert("文件上传失败,请检查重试!");
					window.history.go(-1);
				</script>
				<?
			}
		}
		else
		{
			if(mysql_query($sql3))
			{
				?>
				<script>
					alert("提示:您需要将文件上传到‘<?=$song_dir?>’目录");
					if(confirm("已成功添加记录,继续添加吗?"))
						window.history.go(-1);
					else
						window.location="index.php?content=mp3_list&listtype=new";
				</script>
				<?
			}
			else
			{
				?>
				<script>
					alert("添加记录失败,请检查重试!");
					window.history.go(-1);
				</script>
				<?
			}
		}
	}
}
?>