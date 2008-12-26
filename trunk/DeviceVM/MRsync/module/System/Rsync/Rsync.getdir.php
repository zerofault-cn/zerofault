<?php
include_once("config/path_filter.inc.php");

function array_match($arr,$str) {
	foreach($arr as $val)
	{
		if(strlen($val)>0 && stristr($str,trim($val)))
		{
			return true;
		}
	}
	return false;
}

function myReadDir($dir)
{
	global $path_include,$path_exclude;
	$file_arr=array_filter(scandir($dir),"filter");
	foreach($file_arr as $file)
	{
		if(is_dir($subdir=$dir.$file))//目录
		{
			if(count($path_include)>0 && !array_match($path_include,$subdir))
			{
				continue;
			}
			elseif(count($path_exclude)>0 && array_match($path_exclude,$subdir))
			{
				continue;
			}
			echo '<input type="checkbox" name="selCheckBox" value="'.str_replace(SYNC_FILE_FOLDER,'',$subdir).'/" /><img src="images/folder.gif" align="absmiddle" /> <a class="thickbox" href="?Mod=System&op=Rsync&subop=getdir&dir='.str_replace('&','%26',str_replace(' ','%20',$subdir)).'/">'.$file.'</a><br />';
		}
		elseif(is_file($filepath=$dir.$file))//普通文件,且非隐藏文件
		{
			echo '<input type="checkbox" name="selCheckBox" value="'.str_replace(SYNC_FILE_FOLDER,'',$subdir).'" /><img src="images/file.gif" align="absmiddle" /> '.$file."<br />";
		}
	}
	
}
$dir=$_GET['dir'];
if(empty($dir))
{
	if(!empty($_SESSION['dir']))
	{
		$dir=$_SESSION['dir'];
	}
	else
	{
		$dir=SYNC_FILE_FOLDER;
	}
}
$_SESSION['dir']=$dir;
$rel_dir=str_replace(SYNC_FILE_FOLDER,'',$dir);
if(strlen($rel_dir)>0)
{
	$dir_arr=explode('/',$rel_dir);
}
else
{
	$dir_arr=array();
}
?>
<div id="modal">
	<div id="path_navi">
<?php
echo '<a class="thickbox" href="?Mod=System&op=Rsync&subop=getdir&dir='.SYNC_FILE_FOLDER.'">ROOT</a>';
for($i=0;$i<count($dir_arr)-2;$i++)
{
	$tmpdir.=$dir_arr[$i].'/';
echo '/<a class="thickbox" href="?Mod=System&op=Rsync&subop=getdir&dir='.SYNC_FILE_FOLDER.$tmpdir.'">';
	if( strlen($rel_dir)>50 && $i>0 && $i<(count($dir_arr)-3) )
	{
		echo '...';
	}
	else
	{
		echo $dir_arr[$i];
	}
	echo '</a>';
		
}
!empty($dir_arr[$i]) && print('/'.$dir_arr[$i]);
echo '/&nbsp;&nbsp;<a class="thickbox" href="?Mod=System&op=Rsync&subop=getdir&dir='.SYNC_FILE_FOLDER.$tmpdir.'"><img src="images/updir.gif" height="18" align="absmiddle" /></a>';
?>

	</div>
	<div id="path_list">
<?php
myReadDir($dir);
?>
	</div>
	<div class="a_right">
		<span class="f_left"><input type="checkbox" id="checkall" name="checkall" value="<?=$rel_dir?>" onClick="checkAll()" /><b>Select All</b></span>
		<input type="button" value=" OK " onclick="doSelect(),tb_remove();" /> <input type="button" value="Cancel" onclick="tb_remove();" />
	</div>
	<script type="text/javascript">
	var checked_count=0;
	$(function() {
		$("input:checkbox[name=selCheckBox]").each(function(i){
			$(this).click(function(){
				if($(this).attr('checked')==true)
				{
					checked_count++;
				}
				else
				{
					checked_count--;
				}
				if(checked_count==$("input:checkbox[name=selCheckBox]").size())
				{
					$("#checkall").attr('checked',true);
				}
				else
				{
					$("#checkall").attr('checked',false);
				}
			});
		});
	});
	</script>
</div>

<?php
exit;
?>