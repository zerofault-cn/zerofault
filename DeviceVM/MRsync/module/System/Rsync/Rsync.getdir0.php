<?php

function myReadDir($dir)//�ݹ���ã��Ա���Ŀ¼��
{
	global $Host_Path;
	$handle=opendir($dir);
	while($file=readdir($handle))
	{
		if(is_dir($subdir=$dir.'/'.$file) && $file!='.' && $file!='..')//Ŀ¼
		{
			$treeXML.= "\t<TreeNode text='".$file."' value='".$subdir."' radio='true'";
			if(!empty($Host_Path) && $subdir==$Host_Path)
			{
				$treeXML.= " checked=\"true\"";
			}
			$treeXML.= ">\n";
			$treeXML.= myReadDir($subdir);
			$treeXML.= "\t</TreeNode>\n";
		}
		else//������ͨ�ļ�
		{
			continue;
		}
	}
	return $treeXML;
}

$ID=$_GET['id'];

if(!empty($ID))
{
	$oHost_Info->key='Sync_ID';
	$arr=$oHost_Info->view($ID);
	if(!empty($arr))
	{
		$Host_Path=$arr['Path'];
	}
}
header("content-type: text/xml");
$treeXML = "<?xml version=\"1.0\" ?>\n";
$treeXML.= "<TreeNode>\n";
//$treeXML.= "\t<TreeNode text='".SYNC_FILE_FOLDER."'>\n";
$treeXML.= myReadDir(SYNC_FILE_FOLDER);
//$treeXML.= "\t</TreeNode>\n";
$treeXML.= "</TreeNode>\n";

echo $treeXML;

exit;
?>