<?
define('IN_MATCH', true);
header("Expires:  " . gmdate("D, d M Y H:i:s") . "GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

$thisfile_path=$_SERVER['SCRIPT_FILENAME'];//当前文件
$thisfile_dir=dirname($thisfile_path);//当前文件所在路径
$file=$_REQUEST['file'];//待修改文件
$htm_file=$thisfile_dir."/../templates/".$file.".htm";//待修改文件的路径
$file_lock=$thisfile_dir."/../templates/".$file.".htm.lock";//文件锁，暂时没用

//提交修改
if($_REQUEST['submit'])
{
	$content=stripslashes($_REQUEST['content']);
	copy($htm_file,$htm_file.'.'.date("Y-m-d_h-i-s"));
	$fp=fopen($htm_file,"w");
	if(fwrite($fp,$content))
	{
//		unlink($file_lock);
		header("location:file_edit.php?file=".$file);
		exit;
	}
}
$root_path ="./../";
include_once($root_path."includes/template.php");
$content='';
$content=file_get_contents($htm_file);

include_once("left.php");//左边菜单
?>

<div style="width:800px;margin-top:10px;margin-left:150px;text-align:center;border:1px solid #000;">
编辑模板文件：<?=$file?>.htm
<form action="" name="formedit" method="post" style="margin:0;padding:0">
<textarea name="content" cols="110" rows="34">
<?=htmlspecialchars($content)?>
</textarea>
<input type="hidden" name="file" value="<?=$file?>" />
<input type="submit" name="submit" value="提交" />
<input type="reset" name="reset" value="复位" />
</form>

</div>
