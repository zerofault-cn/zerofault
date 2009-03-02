<?php
$action = isset($_POST['Action']) ? $_POST['Action'] : '';

if($action=='Doit')
{
	/****************Event Log**********************/
	$LOG_ARR=array(
		"type"=>"1",
		"source"=>'Rsync Module',
		"user"=>$_SESSION['auth']['Username'].'@'.$_SERVER['REMOTE_ADDR'],
		"action"=>'Create RsyncFileList',
		"info_xml"=>"",
		"description"=>'Create success!'
	);
	include_once(PATH_Include."LogUL.php");
	/****************Event Log**********************/
	
	$Host_ID=$_POST['Host_ID'];
	if(empty($Host_ID))
	{
		echo '<script>parent.alert("No Host Specified!");</script>';
		exit;
	}
	$Host = $_POST['Host'];
	$Path = $_POST['Path'];

	//$Local_Chroot = $_POST['Local_Chroot'];
	$Local_Chroot = SYNC_FILE_FOLDER;

	$path_arr=$_POST['path_arr'];
	if(count($path_arr)==0)
	{
		echo '<script>parent.alert("Please Select Files!");</script>';
		exit;
	}
	sort($path_arr);
	//对提交的数组进行筛选，去掉冗余的路径
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

	$time = date("Y/m/d/H/i/s");
	$mail = $_SESSION['auth']['Mail'];
	$xml_filename=$_SESSION['auth']['ID'].'_'.date("YmdHis").'.xml';
	
	//先写Sync_XML表
	$oSync_XML->User_ID=$_SESSION['auth']['ID'];
	$oSync_XML->Host_ID=$Host_ID;
	$oSync_XML->Filename=$xml_filename;
	$oSync_XML->Create_Time=$oSync_XML->Modify_Time=$time;
	$oSync_XML->status=0;
	if(!$Sync_ID=$oSync_XML->Add())
	{
		echo '<script>parent.alert("insert DB error!");</script>';
		$LOG_ARR["description"]='Insert DB error!';
	}
	else
	{
		//再写Host_Info表
		$oHost_Info->Host =	$Host;
		$oHost_Info->Host_Chroot = $Path;
		$oHost_Info->Local_Chroot= $Local_Chroot;
		$oHost_Info->Time =	$time;
		$oHost_Info->Sync_ID =$Sync_ID;
		$oHost_Info->Mail = $mail;
		$Host_Info_ID=$oHost_Info->Add();
		//生成xml文件
		$xml_content = "<?xml version=\"1.0\" ?>\n";
		$xml_content.= "<Rsync>\n";
		$xml_content.= "\t<Host_Info>\n";
		$xml_content.= "\t\t<Host>".$Host."</Host>\n";
		$xml_content.= "\t\t<Host_Chroot>".$Path."</Host_Chroot>\n";
		$xml_content.= "\t\t<Local_Chroot>".$Local_Chroot."</Local_Chroot>\n";
		$xml_content.= "\t\t<Time>".$time."</Time>\n";
		$xml_content.= "\t\t<Sync_ID>".$Sync_ID."</Sync_ID>\n";
		$xml_content.= "\t\t<Mail>".$mail."</Mail>\n";
		$xml_content.= "\t</Host_Info>\n";

		$xml_content.= "\t<Sync_List>\n";
		foreach($path_arr as $path)
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
		
		//$fp=fopen(XML_FILE_FOLDER.$xml_filename,'w');
		$fp=fopen('rsync_xml/'.$xml_filename,'w');
		
		if(fwrite($fp,$xml_content))//xml文件生成成功后,继续写入Sync_Info表
		{
		//	$oSync_Info->debug=true;
			$oSync_XML->Content=$xml_content;
			$oSync_XML->update($Sync_ID);

			$oSync_Info->Sync_ID=$Sync_ID;
			foreach($path_arr as $path)
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
			echo '<script>parent.alert("Create Successfully!");parent.myLocation("?Mod='.$iModule.'&op='.$iop.'&subop=browse");</script>';
			
			$LOG_ARR["info_xml"]="rsync_xml:".$xml_filename."\n".$xml_content;
		}
		else
		{
			$oSync_XML->Del($Sync_ID);
			$oHost_Info->Del($Host_Info_ID);
			echo '<script>parent.alert("write file error!");</script>';
			$LOG_ARR["description"]='Write File error!';
		}
	}
	/****************Event Log**********************/
	$ret=LogUL($LOG_ARR);
	/****************Event Log**********************/
	exit;
}

include_once(objects_path . 'class.' . $DB . '.Rsync_Host.php');
$oRsync_Host=new Rsync_Host();
$arr=$oRsync_Host->Browse("order by Name");
for($i=0;$i<count($arr['ID']);$i++)
{
	$Rsync_Host[] = array(
		'ID'		=> $arr['ID'][$i],
		'Name'		=> $arr['Name'][$i],
		'Host'		=> $arr['Host'][$i],
		'Path'		=> $arr['Path'][$i],
		'Description'	=> $arr['Description'][$i]
	);
}
$smarty->assign('Title','Add Rsync Schedule');
$smarty->assign('Rsync_Host', $Rsync_Host);
?>