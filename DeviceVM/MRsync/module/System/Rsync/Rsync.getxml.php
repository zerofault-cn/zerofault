<?php
//old
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
function myReadDir($dir)//�ݹ���ã��Ա���Ŀ¼��
{
	global $filepath_arr,$dirpath_arr,$ID,$t;
	global $path_include,$path_exclude;
	//$handle=opendir($dir);
	//while($file=readdir($handle))
	$file_arr=array_filter(scandir($dir),"filter");//���������ļ�;
	foreach($file_arr as $file)
	{
		if(is_dir($subdir=$dir.'/'.$file))//Ŀ¼
		{
			if(count($path_include)>0 && !array_match($path_include,$subdir))
			{
				continue;
			}
			elseif(count($path_exclude)>0 && array_match($path_exclude,$subdir))
			{
				continue;
			}
			$tmp_arr=array_filter(scandir($subdir),"filter");//���������ļ�
			if(count($dirpath_arr)>0 && in_array($subdir.'/',$dirpath_arr))//�༭״̬��,�жϵ�ǰĿ¼�Ƿ��ѱ�ѡ�й�
			{
				
				$treeXML.= $t."<TreeNode text='".str_replace('&','&amp;',$file)."' value='".str_replace('&','&amp;',$subdir)."/' checkbox='true' checked='true'>\n";
				if(count($tmp_arr)>0)
				{
					$t.="\t";
					$treeXML.= myReadDir($subdir);
					$t=substr($t,0,-1);
				}
			}
			else
			{
				$treeXML.= $t."<TreeNode text='".str_replace('&','&amp;',$file)."' value='".str_replace('&','&amp;',$subdir)."/' checkbox='true' ";
				if(count($tmp_arr)>0)
				{
					$treeXML.= "src='?Mod=System&amp;op=Rsync&amp;subop=getxml&amp;dir=".str_replace('&','%26',str_replace(' ','%20',$subdir))."&amp;id=".$ID."'";
				}
				$treeXML.= ">\n";
			}
			$treeXML.= $t."</TreeNode>\n";
		}
		elseif(is_file($filepath=$dir.'/'.$file))//�ļ�,�ҷ�����
		{
			$treeXML.= $t."<TreeNode text='".str_replace('&','&amp;',$file)."' value='".str_replace('&','&amp;',$filepath)."' checkbox='true'";
			if(count($filepath_arr)>0 && (in_array($dir.'/',$filepath_arr) || in_array($filepath,$filepath_arr)) )//���Ա༭״̬���жϵ�ǰ�ļ��Ƿ��ѱ�ѡ��
			{
				$treeXML.= ' checked="true"';
			}
			$treeXML.= "/>\n";
		}
	}
	return $treeXML;
}

$ID=$_GET['id'];
$dir=$_GET['dir'];
//$fp=fopen('rsync_xml/debug.log','a');
//fwrite($fp,$dir."\n");
if(empty($dir))
{
	$dir=SYNC_FILE_FOLDER;
}
$filepath_arr=array();
$dirpath_arr=array();
if(!empty($ID))
{
	$arr=$oSync_Info->Browse("where XID=".$ID);
	for($i=0;$i<count($arr['ID']);$i++)
	{
		$filepath_arr[]=$arr['Path'][$i].$arr['Filename'][$i];
		$tmp_path=$arr['Path'][$i];
		while(SYNC_FILE_FOLDER != $tmp_path)
		{
			$dirpath_arr[]= (substr($tmp_path,-1)=='/')?$tmp_path:($tmp_path.'/');
			$tmp_path=substr($tmp_path,0,strrpos($tmp_path,'/'));
		}
	}
	$dirpath_arr=array_unique($dirpath_arr);
}
//filelog('rsync_xml/debug.log',print_r($dirpath_arr,true));
//filelog('rsync_xml/debug.log',print_r($filepath_arr,true));
static $t="\t";
header("content-type: text/xml");
$treeXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$treeXML.= "<TreeNode>\n";
$treeXML.= myReadDir($dir);
$treeXML.= "</TreeNode>\n";

echo $treeXML;

//$fp=fopen('rsync_xml/debug.xml','w');
//fwrite($fp,$treeXML);

exit;
?>