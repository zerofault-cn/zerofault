<!-- ���MP3����-1 -->
<?
$remote_ip=$_SERVER["REMOTE_ADDR"];
$server_ip=$_SERVER["SERVER_ADDR"];
$remote_ip=substr($remote_ip,0,strrpos($remote_ip,'.'));
$server_ip=substr($server_ip,0,strrpos($server_ip,'.'));
if($remote_ip=='172.18.145'||$remote_ip=='221.10.222'||$server_ip==$remote_ip)
{
	?>
	<script>
		location='index.php?content=mp3_add_1_upload';
	</script>
	<?
}
?>
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
	if(window.document.form1.singer_id.value=='')
	{
		alert("������ѡ�����");
		return false;
	}
	if(window.document.form1.album_name.value=="")
	{
		alert("����������ר����");
		document.form1.album_name.focus();
		return false;
	}
	full_path=window.document.form1.mp3file.value;
	file_name=full_path.substring(full_path.lastIndexOf('\\')+1);
	if(/[^\x00-\xff]/g.test(file_name))
	{
		alert("�ļ������ܺ��к����ַ�");
		document.form1.mp3file.focus();
		return false;
	}
	if(/[\x20]/g.test(file_name))
	{
		alert("�ļ������ܺ��пո�");
		document.form1.mp3file.focus();
		return false;
	}
	if(/[\x27]/g.test(full_path))
	{
		alert("�ļ������ܺ��е�����");
		document.form1.mp3file.focus();
		return false;
	}
	return true;
}
function update_info()
{
	str=window.document.form1.mp3file.value;//E:\mp3\Music�����\һ����....������.mp3
	album_name=str.substring(0,str.lastIndexOf('\\'));
	album_name=album_name.substring(album_name.lastIndexOf('\\')+1);
	song_name=str.substring(str.lastIndexOf('\\')+1);
	song_name=song_name.substring(0,song_name.lastIndexOf('.'));
	document.form1.album_name.value=album_name;
	document.form1.song_name.value=song_name;
}
</script>

</head>
<form method=post name=form1 action="mp3_add_2.php" onsubmit="return check()">
<table align=center width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>���MP3����(<span class=blue>ֻ��Ӽ�¼</span>)</caption>
<tr bgcolor=white>
	<td align=right width="21%"><span style="color:red">*</span>ѡ��MP3�ļ���</td>
	<td><input type=file name="mp3file_name" size=38></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>�������ƣ�</td>
	<td><select name=singer_id onchange="document.addmp3.select_flag.value=this.options[this.selectedIndex].value">
		<option value="">��ѡ��</option>
		<?
		include_once "../include/mysql_connect.php";
		$sql1="select singer_id,singer_name,singer_name_fc from singer_info order by singer_name_fc,type_other_id desc,binary singer_name";
		$result1=mysql_query($sql1);
		$i=0;
		while($r=mysql_fetch_array($result1))
		{
			$singer_name_fc[]=$r[2];
			if($singer_name_fc[$i]!=$singer_name_fc[$i-1])
			{
				?>
				<option value=""><?=$singer_name_fc[$i]?>-------</option>
				<?
			}
			?>
			<option value="<?=$r[0]?>"><?=$r[1]?></option>
			<?
			$i++;
		}
		?>
		</select><span class=small>(���û�����������,��<a href="index.php?content=music_add_singer_1">��Ӹ���</a>)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>�������ƣ�</td>
	<td><input type=text name=song_name size=48></td>
</tr>
<tr bgcolor=white>
	<td align=right>ר�����ƣ�</td><td><input type=text name=album_name size=48 value=unknown></td>
</tr>
<tr bgcolor=white>
	<td align=right>��ʣ�</td>
	<td><textarea name=song_lyric rows=10 cols=48>����</textarea></td>
</tr>
<tr bgcolor=white>
	<td align=center colspan=2><input type=hidden name=select_flag><input type=submit value="&nbsp;��&nbsp&nbsp��&nbsp;"></td>
</tr>
<tr bgcolor=white>
	<td align=right colspan=2><input type=checkbox name=up_flag value=1 disabled>�����ϴ�&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
</tr>
<tr bgcolor=white>
	<td colspan=2>
	ע��:<br>
	1.�����Զ��ж���������,��ȷ���Ƿ�ʹ���Զ��ϴ������ֶ��ϴ�.<br>
	2.������Զ��ϴ�,��������MP3�ļ���Ӳ���д�ŵĸ�ʽΪ:<u>������\ר����\������.mp3</u>,������Щ�����в�Ҫʹ��<u>������(')</u>,Ҳ����ʹ��<u>������</u>.<br>
	3.������������ϴ�,�������MP3ǰ�Ƚ�<u>�ļ���</u>�ĳ�<u>ƴ��</u>(�����ܰ��������ַ�),�����ļ����в��ܰ���<u>�ո�</u>,Ҳ���ܰ���<u>������(')</u>.<br>
	</td>
</tr>
</table>
</form>
