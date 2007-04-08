<!-- mp3搜索-1 -->

<center>
<form action="index.php?content=mp3_list" method=post name=mp3_query>
<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
<caption>mp3搜索</caption>
<tr bgcolor=white>
	<td align=right>歌曲或专辑名称：</td>
	<td><input type=text name="key_mp3_name"> (输入关键字即可)</td>
</tr>
<tr bgcolor=white>
	<td align=right>歌手名称：</td>
	<td><select name=singer_id>
		<option value="">请选择</option>
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
		</select><span class=small></span></td>
</tr>
<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value="开始搜索"></td>
</tr>
</table>
</form>
</center>