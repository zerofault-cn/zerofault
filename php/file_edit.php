<?
error_reporting(E_ALL ^ E_NOTICE);
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$thisfile_path=$_SERVER['SCRIPT_FILENAME'];//当前文件
$thisfile_dir=dirname($thisfile_path);//当前文件所在路径
$file=$_REQUEST['file'];//待修改文件
if(''==$file)
{
	echo '未指定文件名';
	exit;
}
$edit_file=$thisfile_dir."/".$file;//待修改文件的路径

//提交修改
if($_REQUEST['submit'])
{
	$content=stripslashes($_REQUEST['content']);
	@copy($edit_file,$edit_file.'.'.date("Ymdhi"));
	$fp=fopen($edit_file,"w");
	if(fwrite($fp,$content))
	{
//		unlink($file_lock);
		header("location:file_edit.php?file=".$file);
		exit;
	}
}
$content='';
$content=@file_get_contents($edit_file);

?>
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>编辑文件：<?=$file?></title>
<script>

function resize_textarea(){
	var t=document.getElementById('content');
	t.style.width=document.body.clientWidth-30;
	t.style.height=t.scrollHeight+5;
}
//window.onresize=resize_textarea();
</script>
<style>
body,form{padding:5px;margin:0;}
textarea{overflow-y:hidden!important;overflow-y:visible;}
</style>
</head>
<body onload="resize_textarea()" onresize="resize_textarea()">
<form action="" name="editform" method="post" style="margin:0;padding:0">
<textarea name="content" id="content" onKeyDown=="if(event.ctrlKey&&event.keyCode==83)document.editform.submit();">
<?=htmlspecialchars($content)?>
</textarea>
<div style="text-align:center">
<input type="hidden" name="file" value="<?=$file?>" />
<input type="submit" name="submit" value="提交" />
<input type="reset" name="reset" value="复位" />
</div>
</form>
</body>
</html>