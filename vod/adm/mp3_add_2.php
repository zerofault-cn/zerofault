<!-- ���MP3����-2 -->
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
		alert("�ⲻ��һ��MP3�ļ���������ѡ���ļ�!");
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
			alert("����MP3�Ѿ����ڣ�����������ļ�!");
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
		$singer_name_py=words(str_replace(' ','_',$singer_name));//��������ת��Ϊƴ��
		$album_name_py=words(str_replace(' ','_',$album_name));//ר����ת��
		$mp3file_name_py=words(str_replace(' ','_',$mp3file_name));//��������ת��Ϊƴ��,ֻת�������ַ�
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
					alert("��ʾ:�ļ����ϴ�����<?=$singer_dir?>��Ŀ¼���ļ���Ϊ��<?=$file_name?>��");
					if(confirm("���������?"))
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
					alert("�ļ��ϴ�ʧ��,��������!");
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
					alert("��ʾ:����Ҫ���ļ��ϴ�����<?=$song_dir?>��Ŀ¼");
					if(confirm("�ѳɹ���Ӽ�¼,���������?"))
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
					alert("��Ӽ�¼ʧ��,��������!");
					window.history.go(-1);
				</script>
				<?
			}
		}
	}
}
?>