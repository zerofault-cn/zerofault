<script language="javascript">
function check()
{
	if(window.document.form1.mp3file.value=="")
	{
		alert("������·��");
		document.form1.mp3file.focus();
		return false;
	}
	if(window.document.form1.song_name.value=="")
	{
		alert("���������");
		document.form1.song_name.focus();
		return false;
	}
	return true;
}
function autoInsert()
{
	str=window.document.form1.mp3file.value;//E:\mp3\Music�����\һ����....������.mp3
	album_name=str.substring(0,str.lastIndexOf('\\'));
	album_name=album_name.substring(album_name.lastIndexOf('\\')+1);
	song_name=str.substring(str.lastIndexOf('\\')+1);
	song_name=song_name.substring(0,song_name.lastIndexOf('.'));
//	document.form1.album_name.value=album_name;
	document.form1.song_name.value=song_name;
}
</script>

<form method="post" action="song_add_2.php" name="form1" onsubmit="return check();">
ѡ��MP3�ļ�:<input type=file name="mp3file" size=50 value=".mp3" onchange="autoInsert()"><br>
ѡ��LRC�ļ�:<input type=file name="lrcfile" size=50 value='.lrc'><br>
��������:<input type=text name="song_name" size=20>
<input type="hidden" name="singer_id" value="<?=$_REQUEST['singer_id']?>">
<input type="hidden" name="album_id" value="<?=$_REQUEST['album_id']?>">
<input type="submit" value="�ύ">
</form>

