<html>
<head>
<title>修改音乐节目</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";
include_once "../include/toPinyin.php";
$sql1="select * from prog_info,singer_info where prog_id='".$prog_id."'";
$result1=mysql_query($sql1);
//取得各列数据
$depre_id		=mysql_result($result1,0,"depre_id");//折旧编号,(新片,旧片)对应depreciate表depre_id
$prog_name		=mysql_result($result1,0,"prog_name");
$prog_stype		=mysql_result($result1,0,"prog_stype");//服务类型(bod),对应dict_entry表dtype_id=20
$prog_format	=mysql_result($result1,0,"prog_format");//文件格式(mp4,mp3),对应dict_entry表dtype_id=10
$prog_kindfir	=mysql_result($result1,0,"prog_kindfir");//播放方式,(广播,多播,单播),对应dtype_id=30
$prog_kindsec	=mysql_result($result1,0,"prog_kindsec");//节目种类,对应dtype_id=40,且dentry_id>1000
$prog_kindthr	=mysql_result($result1,0,"prog_kindthr");//内容分类,对应dict_entry表dtype_id=50
$prog_kindfor	=mysql_result($result1,0,"prog_kindfor");//节目类别,对应dict_entry表dtype_id=60
$prog_path		=mysql_result($result1,0,"prog_path");
$prog_size		=mysql_result($result1,0,"prog_size");
$prog_timespan	=mysql_result($result1,0,"prog_timespan");
$publisher		=mysql_result($result1,0,"publisher");//歌手ID
$pubdate		=mysql_result($result1,0,"pubdate");
$director		=mysql_result($result1,0,"director");
$prog_acot		=mysql_result($result1,0,"prog_acot");
$prog_describe	=mysql_result($result1,0,"prog_describe");//未用
$del_flag		=mysql_result($result1,0,"del_flag");//删除标志
$zoom_flag		=mysql_result($result1,0,"zoom_flag");//缩放标志
$prog_limit		=mysql_result($result1,0,"prog_limit");//影片级别,对应dtype_id=90,即用户级别(user_limit)
$quality		=mysql_result($result1,0,"quality");
?>
<form action="prog_modify.php?page_grom=music_prog" method=post name=modify><p>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>修改节目信息:<?=$prog_id?><span class=small>(<span style="color:red">*</span>项不要随意修改)</span></caption>
<tr bgcolor=white>
	<td align=right>节目新旧:</td>
	<td><select name=depre_id>
		<?
		$sql2="select depre_id,depre_name from depreciate where del_flag=1 order by depre_id";
		$result2=mysql_query($sql2);
		while($r=mysql_fetch_array($result2))
		{
			?>
			<option value="<?echo $tmp_depre_id=$r[0];?>" 
			<?
			if($depre_id==$tmp_depre_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right>节目名称:</td>
	<td><input type=text name=prog_name value="<?=$prog_name?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>服务类型:</td>
	<td><select name=prog_stype>
		<?
		$sql3="select dentry_id,dentry_name from dict_entry where dtype_id=20 and del_flag=1 order by dentry_id";
		$result3=mysql_query($sql3);
		while($r=mysql_fetch_array($result3))
		{
			?>
			<option value="<?echo $tmp_dentry_id=$r[0];?>" 
			<?
			if($prog_stype==$tmp_dentry_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>文件格式:</td>
	<td><select name=prog_format>
		<?
		$sql4="select dentry_id,dentry_name from dict_entry where dtype_id=10 and del_flag=1 order by dentry_id";
		$result4=mysql_query($sql4);
		while($r=mysql_fetch_array($result4))
		{
			?>
			<option value="<?echo $tmp_dentry_id=$r[0];?>" 
			<?
			if($prog_format==$tmp_dentry_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>播放方式:</td>
	<td><select name=prog_kindfir>
		<?
		$sql5="select dentry_id,dentry_name from dict_entry where dtype_id=30 and del_flag=1 order by dentry_id";
		$result5=mysql_query($sql5);
		while($r=mysql_fetch_array($result5))
		{
			?>
			<option value="<?echo $tmp_dentry_id=$r[0];?>" 
			<?
			if($prog_kindfir==$tmp_dentry_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>节目种类:</td>
	<td><select name=prog_kindsec>
		<option value="1026">MTV</option>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>内容分类:</td>
	<td><select name=prog_kindthr>
		<option value="1026">MTV</option>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>节目类别:</td>
	<td><select name=prog_kindfor>
		<?
		$sql8="select dentry_id,dentry_name from dict_entry where dtype_id=60 and del_flag=1 order by dentry_id";
		$result8=mysql_query($sql8);
		if($r=mysql_fetch_array($result8))
		{
			do
			{
				?>
				<option value="<?echo $tmp_dentry_id=$r[0];?>" 
				<?
				if($prog_kindfor==$tmp_dentry_id)
					echo " selected";
				?>
				><?=$r[1]?></option>
				<?
			}while($r=mysql_fetch_array($result8));
		}
		else
		{
			?>
			<option value="<?=$prog_kindfor?>">尚未配置</option>
			<?
		}
		?>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right>播放路径</td>
	<td><input type=text name=prog_path size=40 value="<?=$prog_path?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>文件大小:</td>
	<td><input type=text name=prog_size value=<?=$prog_size?> size=3>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>歌名字数:</td>
	<td><input type=text name=prog_timespan value="<?=$prog_timespan?>" size=4><input type=button value="<< 请点击生成字数" onclick="javascript:this.form.prog_timespan.value=this.form.prog_name.value.length;"></td>
</tr>
<tr bgcolor=white>
	<td align=right>歌手:</td>
	<td><select name=publisher>
		<?
		$sql9="select singer_id,singer_name from singer_info order by type_other_id desc,binary singer_name";
		$result9=mysql_query($sql9);
		while($r=mysql_fetch_array($result9))
		{
			?>
			<option value="<?echo $singer_id=$r[0];?>"
			<?
			if($publisher==$singer_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right>出版日期:</td>
	<td><input type=text name=pubdate value=<?=$pubdate?>></td>
</tr>
<tr bgcolor=white>
	<td align=right><!-- 主要演员 -->歌名拼音:</td>
	<td><input type=text name=prog_acot value=<?=words($prog_name)?>></td>
</tr>
<tr bgcolor=white>
	<td align=right>有效标志:</td>
	<td><select name=del_flag>
		<option value="1" 
		<?
		if($del_flag==1)
			echo " selected";
		?>
		>有效</option>
		<option value="-1" 
		<?
		if($del_flag==-1)
			echo " selected";
		?>
		>无效</option></select><span class=small>(只有设置为有效用户才能看到)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>缩放标志:</td>
	<td><select name=zoom_flag>
		<option value="1" 
		<?
		if($zoom_flag==1)
			echo " selected";
		?>
		>缩放</option>
		<option value="0" 
		<?
		if($zoom_flag==0)
			echo " selected";
		?>
		>不缩放</option></select><span class=small>(除视频分辨率为640*480时不需要缩放外,其他都需要)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>影片级别:</td>
	<td><select name=prog_limit>
		<?
		$sql10="select dentry_id,dentry_name from dict_entry where dtype_id=90 and del_flag=1 order by dentry_id";
		$result10=mysql_query($sql10);
		while($r=mysql_fetch_array($result10))
		{
			?>
			<option value="<?echo $tmp_dentry_id=$r[0];?>" 
			<?
			if($prog_limit==$tmp_dentry_id)
				echo " selected";
			?>
			><?=$r[1]?></option>
			<?
		}
		?>
		</select>
	</td>
</tr>


<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
<input type=hidden name=prog_id value="<?=$prog_id?>">
<input type=hidden name=director value="<?=$director?>">
<input type=hidden name=prog_describe value="noneed">
<input type=hidden name=quality value="3">
</form>
</body>
</html>
