<html>
<head>
<title>�޸����ֽ�Ŀ</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<?
include_once "../include/mysql_connect.php";
include_once "../include/toPinyin.php";
$sql1="select * from prog_info,singer_info where prog_id='".$prog_id."'";
$result1=mysql_query($sql1);
//ȡ�ø�������
$depre_id		=mysql_result($result1,0,"depre_id");//�۾ɱ��,(��Ƭ,��Ƭ)��Ӧdepreciate��depre_id
$prog_name		=mysql_result($result1,0,"prog_name");
$prog_stype		=mysql_result($result1,0,"prog_stype");//��������(bod),��Ӧdict_entry��dtype_id=20
$prog_format	=mysql_result($result1,0,"prog_format");//�ļ���ʽ(mp4,mp3),��Ӧdict_entry��dtype_id=10
$prog_kindfir	=mysql_result($result1,0,"prog_kindfir");//���ŷ�ʽ,(�㲥,�ಥ,����),��Ӧdtype_id=30
$prog_kindsec	=mysql_result($result1,0,"prog_kindsec");//��Ŀ����,��Ӧdtype_id=40,��dentry_id>1000
$prog_kindthr	=mysql_result($result1,0,"prog_kindthr");//���ݷ���,��Ӧdict_entry��dtype_id=50
$prog_kindfor	=mysql_result($result1,0,"prog_kindfor");//��Ŀ���,��Ӧdict_entry��dtype_id=60
$prog_path		=mysql_result($result1,0,"prog_path");
$prog_size		=mysql_result($result1,0,"prog_size");
$prog_timespan	=mysql_result($result1,0,"prog_timespan");
$publisher		=mysql_result($result1,0,"publisher");//����ID
$pubdate		=mysql_result($result1,0,"pubdate");
$director		=mysql_result($result1,0,"director");
$prog_acot		=mysql_result($result1,0,"prog_acot");
$prog_describe	=mysql_result($result1,0,"prog_describe");//δ��
$del_flag		=mysql_result($result1,0,"del_flag");//ɾ����־
$zoom_flag		=mysql_result($result1,0,"zoom_flag");//���ű�־
$prog_limit		=mysql_result($result1,0,"prog_limit");//ӰƬ����,��Ӧdtype_id=90,���û�����(user_limit)
$quality		=mysql_result($result1,0,"quality");
?>
<form action="prog_modify.php?page_grom=music_prog" method=post name=modify><p>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>�޸Ľ�Ŀ��Ϣ:<?=$prog_id?><span class=small>(<span style="color:red">*</span>�Ҫ�����޸�)</span></caption>
<tr bgcolor=white>
	<td align=right>��Ŀ�¾�:</td>
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
	<td align=right>��Ŀ����:</td>
	<td><input type=text name=prog_name value="<?=$prog_name?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��������:</td>
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
	<td align=right><span style="color:red">*</span>�ļ���ʽ:</td>
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
	<td align=right><span style="color:red">*</span>���ŷ�ʽ:</td>
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
	<td align=right><span style="color:red">*</span>��Ŀ����:</td>
	<td><select name=prog_kindsec>
		<option value="1026">MTV</option>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>���ݷ���:</td>
	<td><select name=prog_kindthr>
		<option value="1026">MTV</option>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��Ŀ���:</td>
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
			<option value="<?=$prog_kindfor?>">��δ����</option>
			<?
		}
		?>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right>����·��</td>
	<td><input type=text name=prog_path size=40 value="<?=$prog_path?>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>�ļ���С:</td>
	<td><input type=text name=prog_size value=<?=$prog_size?> size=3>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>��������:</td>
	<td><input type=text name=prog_timespan value="<?=$prog_timespan?>" size=4><input type=button value="<< ������������" onclick="javascript:this.form.prog_timespan.value=this.form.prog_name.value.length;"></td>
</tr>
<tr bgcolor=white>
	<td align=right>����:</td>
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
	<td align=right>��������:</td>
	<td><input type=text name=pubdate value=<?=$pubdate?>></td>
</tr>
<tr bgcolor=white>
	<td align=right><!-- ��Ҫ��Ա -->����ƴ��:</td>
	<td><input type=text name=prog_acot value=<?=words($prog_name)?>></td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ч��־:</td>
	<td><select name=del_flag>
		<option value="1" 
		<?
		if($del_flag==1)
			echo " selected";
		?>
		>��Ч</option>
		<option value="-1" 
		<?
		if($del_flag==-1)
			echo " selected";
		?>
		>��Ч</option></select><span class=small>(ֻ������Ϊ��Ч�û����ܿ���)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>���ű�־:</td>
	<td><select name=zoom_flag>
		<option value="1" 
		<?
		if($zoom_flag==1)
			echo " selected";
		?>
		>����</option>
		<option value="0" 
		<?
		if($zoom_flag==0)
			echo " selected";
		?>
		>������</option></select><span class=small>(����Ƶ�ֱ���Ϊ640*480ʱ����Ҫ������,��������Ҫ)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>ӰƬ����:</td>
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
	<td colspan=2 align=center><input type=submit value=�ύ�޸�>&nbsp;&nbsp;<input type=reset value="����">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
<input type=hidden name=prog_id value="<?=$prog_id?>">
<input type=hidden name=director value="<?=$director?>">
<input type=hidden name=prog_describe value="noneed">
<input type=hidden name=quality value="3">
</form>
</body>
</html>
