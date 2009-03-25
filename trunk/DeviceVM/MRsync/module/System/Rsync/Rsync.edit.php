<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';
$ID=$_GET['id'];
if($action=='Doit')
{
	/****************Event Log**********************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'Rsync Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Edit rsync_xml',
		"info_xml"=>"",
		"description"=>'Update success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log**********************/

	$Host = trim($_POST['Host']);
	$Host_Chroot = trim($_POST['Host_Chroot']);
	$time = date("Y/m/d/H/i/s");
	$mail = $_SESSION['auth']['Mail'];

	$path_arr=$_POST['path_arr'];
	if(count($path_arr)==0)
	{
		echo '<script>parent.alert("Please Select Files!");</script>';
		exit;
	}
	sort($path_arr);
	//对提交的数组进行筛选，去掉重复的路径以及重复选择的文件
	$tmp_path_arr=array();
	foreach($path_arr as $path)
	{
		$exist=0;
		foreach($tmp_path_arr as $tmp_path)
		{
			if(strstr($path,$tmp_path))
			{
				$exist=1;
				break;
			}
		}
		if(!$exist)
		{
			$tmp_path_arr[]=$path;
		}
	}
	$path_arr=$tmp_path_arr;

	//重新生成xml
	$xml_content = "<?xml version=\"1.0\" ?>\n";
	$xml_content.= "<Rsync>\n";
	$xml_content.= "\t<Host_Info>\n";
	$xml_content.= "\t\t<Host>".$Host."</Host>\n";
	$xml_content.= "\t\t<Host_Chroot>".$Host_Chroot."</Host_Chroot>\n";
	$xml_content.= "\t\t<Local_Chroot>".SYNC_FILE_FOLDER."</Local_Chroot>\n";
	$xml_content.= "\t\t<Time>".$time."</Time>\n";
	$xml_content.= "\t\t<Sync_ID>".$ID."</Sync_ID>\n";
	$xml_content.= "\t\t<Mail>".$mail."</Mail>\n";
	$xml_content.= "\t</Host_Info>\n";

	$xml_content.= "\t<Sync_List>\n";
	foreach($path_arr as $key=>$path)
	{
		if(substr($path,-1)=='/')
		{
			$xml_content.= "\t<Sync_Info>\n";
			$xml_content.= "\t\t<Path>".str_replace('&','&amp;',$path)."</Path>\n";
			$xml_content.= "\t\t<FileName></FileName>\n";
			$xml_content.= "\t</Sync_Info>\n";
		}
		else
		{
			$xml_content.= "\t<Sync_Info>\n";
			$xml_content.= "\t\t<Path>".str_replace('&','&amp;',dirname($path))."/</Path>\n";
			$xml_content.= "\t\t<FileName>".str_replace('&','&amp;',basename($path))."</FileName>\n";
			$xml_content.= "\t</Sync_Info>\n";
		}
	}
	$xml_content.= "\t</Sync_List>\n";
	$xml_content.= "</Rsync>\n";

	//从数据库中获取当前编辑的xml文件路径
	$arr=$oSync_XML->view($ID);
	$xml_filename=$arr['Filename'];
	//$fp=fopen(XML_FILE_FOLDER.$xml_filename,'w');
	$fp=fopen('rsync_xml/'.$xml_filename,'w');

	if(fwrite($fp,$xml_content))
	{
		//更新Sync_XML表
		$oSync_XML->Modify_Time=$time;
		$oSync_XML->Content=$xml_content;
		//更新Host_Info表

		if($oSync_XML->update($ID))
		{
			//删除原有对应的Sync_Info记录
			$oSync_Info->DelOpt("Sync_ID=".$ID);

			//重新插入新的记录
			$oSync_Info->Sync_ID=$ID;
			foreach($path_arr as $key=>$path)
			{
				if(substr($path,-1)=='/')
				{
					$oSync_Info->Path = $path;
					$oSync_Info->Filename = '';
					$oSync_Info->Add();
				}
				else
				{
					$oSync_Info->Path = dirname($path).'/';
					$oSync_Info->Filename = basename($path);
					$oSync_Info->Add();
				}
			}
			echo '<script>parent.alert("Update Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';

			$LOG_ARR["info_xml"]="rsync_xml:".$xml_filename."\n".$xml_content;
		}
		else
		{
			echo '<script>parent.alert("Update DB error!");</script>';
			$LOG_ARR["description"]='Update DB error!';
		}
	}
	else
	{
		echo '<script>parent.alert("write file error!");</script>';
		$LOG_ARR["description"]='Write file error!';
	}
	/****************Event Log**********************/
	$ret=LogUL($LOG_ARR);
	/****************Event Log**********************/
	exit;
}

$smarty->assign("ID",$ID);

//Editting Host
$arr=$oHost_Info->view($ID);
if(!empty($arr))
{
	$Host_Info = array(
		'Host' => $arr['Host'],
		'Host_Chroot' => $arr['Host_Chroot'],
		'Local_Chroot' => $arr['Local_Chroot']
		);
}
$smarty->assign('Host_Info', $Host_Info);

//Editting Path
$arr=$oSync_Info->Browse("where Sync_ID=".$ID." order by ID");
for($i=0;$i<count($arr['ID']);$i++)
{
	if(''==$arr['Filename'][$i])
	{
		$icon='folder';
	}
	else
	{
		$icon='file';
	}
	$Sync_Info[] = array(
		'Path' => $arr['Path'][$i].$arr['Filename'][$i],
		'Icon' => $icon
	);
}
$smarty->assign('Sync_Info', $Sync_Info);

$smarty->assign('Title','Edit Rsync Schedule');
?>