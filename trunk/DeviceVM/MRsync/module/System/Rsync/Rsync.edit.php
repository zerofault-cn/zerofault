<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';
$ID=$_GET['id'];
if($action=='Doit')
{
	$Host = $_POST['Host'];
	$Path = $_POST['Path'];
	$time = date("Y-m-d H:i:s");
	$file_arr=explode(',',$_POST['file_str']);
	$xml_content = "<?xml version=\"1.0\" ?>\n";
	$xml_content.= "<Rsync>\n";
	$xml_content.= "\t<Host_Info>\n";
	$xml_content.= "\t\t<Host>".$Host."</Host>\n";
	$xml_content.= "\t\t<Path>".$Path."</Path>\n";
	$xml_content.= "\t\t<Time>".$time."</Time>\n";
	$xml_content.= "\t\t<Sync_ID>".$ID."</Sync_ID>\n";
	$xml_content.= "\t</Host_Info>\n";

	$xml_content.= "\t<Sync_List>\n";
	foreach($file_arr as $file)
	{
		if(substr($file,-1)=='/')
		{
			continue;
		}
		$dirname = dirname($file);
		$basename= basename($file);
		
		$dir_info_arr[$dirname.'/']['total']=count(array_filter(scandir($dirname),"filter"));
		$dir_info_arr[$dirname.'/']['count']+=1;
		$dir_info_arr[$dirname.'/']['files'][]=$basename;
	}

//	filelog('rsync_xml/debug.log',print_r($dir_info_arr,true));

	foreach($dir_info_arr as $dirname=>$dir_info)
	{
		if($dir_info['total']==$dir_info['count'])//全选目录
		{
			$xml_content.= "\t<Sync_Info>\n";
			$xml_content.= "\t\t<Path>".str_replace('&','&amp;',$dirname)."</Path>\n";
			$xml_content.= "\t\t<FileName></FileName>\n";
			$xml_content.= "\t</Sync_Info>\n";
		}
		else
		{
			foreach($dir_info['files'] as $basename)
			{
				$xml_content.= "\t<Sync_Info>\n";
				$xml_content.= "\t\t<Path>".str_replace('&','&amp;',$dirname)."</Path>\n";
				$xml_content.= "\t\t<FileName>".str_replace('&','&amp;',$basename)."</FileName>\n";
				$xml_content.= "\t</Sync_Info>\n";
			}
		}
	}
	$xml_content.= "\t</Sync_List>\n";
	$xml_content.= "</Rsync>\n";
	//从数据库中获取当前编辑的xml文件路径
	$arr=$oSync_XML->view($ID);
	$xml_filename=$arr['Filename'];
	$fp=fopen(XML_FILE_FOLDER.$xml_filename,'w');

	/****************Event Log**********************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'Rsync Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'edit rsync_xml',
		"info_xml"=>"rsync_xml:".$xml_filename."\n".$xml_content,
		"description"=>'update success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log**********************/

	if(fwrite($fp,$xml_content))
	{
		//更新Sync_XML表
		$oSync_XML->Modify_time=$time;
		//更新Host_Info表
		$oHost_Info->key="Sync_ID";
		$oHost_Info->Host=$Host;
		$oHost_Info->Path=$Path;

		if($oSync_XML->update($ID) && $oHost_Info->update($ID))
		{
			//删除原有xml对应的file记录
			$oSync_Info->DelOpt("XID=".$ID);

			//重新插入新的记录
			$oSync_Info->UID=$_SESSION['auth']['ID'];
			$oSync_Info->XID=$ID;
			foreach($dir_info_arr as $dirname=>$dir_info)
			{
				if($dir_info['total']==$dir_info['count'])//全选目录
				{
					$oSync_Info->Path = $dirname;
					$oSync_Info->Filename = '';
					$oSync_Info->status=0;
					$oSync_Info->Add();
				}
				else
				{
					foreach($dir_info['files'] as $basename)
					{
						$oSync_Info->Path = $dirname;
						$oSync_Info->Filename = $basename;
						$oSync_Info->status=0;
						$oSync_Info->Add();
					}
				}
			}
			echo '<script>parent.alert("Update Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';
		}
		else
		{
			echo '<script>parent.alert("Update DB error!");</script>';
			$POST_ARR["description"]='Update DB error!';
		}
	}
	else
	{
		echo '<script>parent.alert("write file error!");</script>';
		$LOG_ARR["description"]='write file error!';
	}
	/****************Event Log**********************/
	$ret=LogUL($LOG_ARR);
	/****************Event Log**********************/
	exit;
}

include_once(objects_path . 'class.' . $DB . '.Rsync_Host.php');
$oRsync_Host=new Rsync_Host();
$arr=$oRsync_Host->Browse("order by ID");
for($i=0;$i<count($arr['ID']);$i++)
{
	$Rsync_Host[] = array(
		'ID'		=> $arr['ID'][$i],
		'Host'		=> $arr['Host'][$i],
		'Path'		=> $arr['Path'][$i],
		'Description'	=> $arr['Description'][$i]
	);
}
$smarty->assign('Rsync_Host', $Rsync_Host);

$arr=$oHost_Info->view($ID);
if(!empty($arr))
{
	$Host_Info = array(
		'ID'=>$arr['ID'],
		'Host'=>$arr['Host'],
		'Path'=>$arr['Path']
		);
}

$smarty->assign('Host_Info', $Host_Info);

$smarty->assign("ID",$ID);
?>