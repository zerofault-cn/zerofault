<!-- 修改prog_info表信息,电影和音乐公用 -->
<?
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=addslashes($text);
	return $text;
}
include_once "admin_limit.php";
include_once "../include/mysql_connect.php";
//需要addslash的变量
//$prog_name=AddSlashes($prog_name);
//$prog_path=AddSlashes($prog_path);
//$publisher=Addslashes($publisher);
if($prog_kindsec==1026)
{
	$ext1="publisher='".$publisher."',";
}
else
{
	$ext1="";
}
//$director=AddSlashes($director);
//$prog_acot=AddSlashes($prog_acot);
//$prog_describe=AddSlashes($prog_describe);
$sql1="update prog_info set depre_id=".$depre_id.",prog_name='".$prog_name."',prog_stype=".$prog_stype.",prog_format=".$prog_format.",prog_kindfir=".$prog_kindfir.",prog_kindsec=".$prog_kindsec.",prog_kindthr=".$prog_kindthr.",prog_kindfor=".$prog_kindfor.",prog_path='".$prog_path."',prog_size=".$prog_size.",prog_timespan=".$prog_timespan.",".$ext1."pubdate='".$pubdate."',director='".$director."',prog_acot='".$prog_acot."',prog_describe='".format($prog_describe)."',del_flag=".$del_flag.",zoom_flag=".$zoom_flag.",operator='".$goldsoft_admin."',operdate=CURDATE(),opertime=CURTIME(),prog_limit=".$prog_limit.",quality=".$quality." where prog_id=".$prog_id;
if(mysql_query($sql1))
{
	?>
	<script>
		alert("修改成功!");
		window.opener.location.reload();
		window.close();
	</script>
	<?
}
else
{
	?>
	<script>
		alert("修改失败,请检查重试");
		window.history.go(-1);
	</script>
	<?
}
?>