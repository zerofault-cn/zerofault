<!-- �޸�mp3��¼-1 -->
<html>
<head>
<title>�޸�MP3</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<?
function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
include_once "../include/mysql_connect.php";
$sql1="select * from song_info where id=".$mp3_id;
$result1=mysql_query($sql1);

$tmp=mysql_fetch_array($result1);
$song_name=$tmp[1];
$singer_id=$tmp[2];
$album_name=$tmp[3];
$path=$tmp[4];
$lyric=$tmp[5];
$time=$tmp[6];
$del=$tmp[8];
?>

<form action="mp3_amend_2.php" method=post name=amend >
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black align=center>
<caption>�޸�mp3����</caption>
<tr bgcolor=white>
	<td width="25%" bgcolor=#d0d0d0 align=right>����ID</td>
	<td><?=$mp3_id?></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>��������</td>
	<td><input type=text name=song_name value="<?=$song_name?>"></td>
</tr>
<tr bgcolor=white>
  <td align=right bgcolor=#d0d0d0>��������</td>
  <td><select name=singer_id>
		<?
		include_once "../include/mysql_connect.php";
		$sql2="select singer_id,singer_name,singer_name_fc from singer_info order by singer_name_fc,type_other_id desc,binary singer_name";
		$result2=mysql_query($sql2);
		$i=0;
		while($r2=mysql_fetch_array($result2))
		{
			$singer_name_fc[]=$r2[2];
			if($singer_name_fc[$i]!=$singer_name_fc[$i-1])
			{
				?>
				<option value=""><?=$singer_name_fc[$i]?>-------</option>
				<?
			}
			?>
			<option value="<?echo $r2[0];?>"
			<?
			if($singer_id==$r2[0])
			{
				$singer_name=$r2[1];
				echo " selected";
			}
			?>
			><?=$r2[1]?></option>
			<?
			$i++;
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>ר������</td>
	<td><input type=text size=20 name=album_name value="<?=$album_name?>"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>����·��</td>
	<td><input type=text size=50 name=path value="<?=$path?>"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>�ļ���С</td>
	<td><?
	if(file_exists("/dpfs/".$path))
	{
		echo printf("%.3f",filesize("/dpfs/".$path)/(1024*1024)). 'MB';
	}
	else
	{
		echo '�ļ�������!';
	}
	?><input type=button onclick="window.open('mp3_upload_1.php?singer_name=<?=$singer_name?>&song_name=<?=$song_name?>&album_name=<?=$album_name?>&mp3_id=<?=$mp3_id?>','','width=450,height=250,toolbar=no,status=no,scrollbars=auto,resizable=yes');" value="�����ϴ��ļ�"></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>�������</td>
	<td><textarea rows=10 cols=48 name=lyric><?=unformat($lyric)?></textarea></td>
</tr>
<tr bgcolor=white>
	<td bgcolor=#d0d0d0 align=right>���ʱ��</td>
	<td><?=$time?></td>
</tr>
<tr bgcolor=white>
  <td align=right bgcolor=#d0d0d0>�Ƿ���Ч</td>
  <td><select name=mp3_del>
	<option value="-1" <? if($del==-1) echo "selected";?> >��Ч</option>
	<option value="1" <? if($del!=-1) echo "selected";?> >��Ч</option>	
	</select></td>
</tr>
<tr bgcolor=white>
        <td colspan=2 align=center><input type=submit value=�ύ�޸�>&nbsp;&nbsp;&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
<input type=hidden name=mp3_id value="<?=$mp3_id?>">
</form>

</body>
</html>