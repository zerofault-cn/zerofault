<?
function unformat($text)
{
	$text=str_replace('&nbsp;',' ',$text);
	$text=str_replace('<br />',"",$text);
	$text=str_replace('<br>',"",$text);
	return $text;
}
include_once "../include/mysql_connect.php";
$sql1="select * from flash_source where id=".$id;
$result1=mysql_query($sql1);
$type=mysql_result($result1,0,1);
$flash_name=mysql_result($result1,0,2);
$flash_path=mysql_result($result1,0,3);
$intro=mysql_result($result1,0,4);
$time=mysql_result($result1,0,7);
?>
<html>
<head>
<title>�޸�flash</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<form method=post action="flash_modify_source_2.php" name="modify">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>�޸�"Flash"���������</caption>
<tr bgcolor=white>
	<td align=right>�޸ķ���</td>
	<td><select name=type>
		<?
		$sql2="select id,type_name from flash_type where del_flag=1 order by id";
		$result2=mysql_query($sql2);
		while($r=mysql_fetch_array($result2))
		{
			?>
			<option value="<?echo $tmp_id=$r[0];?>" 
			<?
			if($type==$tmp_id)
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
	<td align=right><span class=red>*</span>Flash����:</td>
	<td align=left><INPUT TYPE="text" NAME="flash_name" size=30 value='<?=$flash_name?>'></td>
</tr>
<tr bgcolor=white>
	<td align=right><span class=red>*</span>���ֽ���:</td>
	<td><textarea name=intro rows=8 cols=40><?=unformat($intro)?></textarea></td>
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
	<td colspan=2 align=center><input type=hidden name=id value='<?=$id?>'><input type=hidden name=select_flag><input type="submit" value="�ύ�޸�">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="reset" value="&nbsp;����&nbsp;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="ȡ���޸�"></td>
</tr>
</table>
</form>
</body>
</html>