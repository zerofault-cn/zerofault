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
	
	$Host = trim($_POST['Host']);
	if(empty($Host))
	{
		echo '<script>parent.alert("No Host Specified!");</script>';
		exit;
	}
	$Path = $_POST['Path'];
	if(empty($Path))
	{
		echo '<script>parent.alert("Please Select Host Path!");</script>';
		exit;
	}
	$file_str=$_POST['file_str'];
	if(strlen($file_str)==0)
	{
		echo '<script>parent.alert("Please Select Files!");</script>';
		exit;
	}
	$file_arr=explode(',',$file_str);

	$time = date("Y-m-d H:i:s");
	$xml_filename=$_SESSION['auth']['ID'].'_'.date("YmdHis").'.xml';
	
	//先写Sync_XML表
	$oSync_XML->UID=$_SESSION['auth']['ID'];
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
		$oHost_Info->Host=$Host;
		$oHost_Info->Path=$Path;
		$oHost_Info->Sync_ID=$Sync_ID;
		$Host_Info_ID=$oHost_Info->Add();
		//生成xml文件
		$xml_content = "<?xml version=\"1.0\" ?>\n";
		$xml_content.= "<Rsync>\n";
		$xml_content.= "\t<Host_Info>\n";
		$xml_content.= "\t\t<Host>".$Host."</Host>\n";
		$xml_content.= "\t\t<Path>".$Path."</Path>\n";
		$xml_content.= "\t\t<Time>".$time."</Time>\n";
		$xml_content.= "\t\t<Sync_ID>".$Sync_ID."</Sync_ID>\n";
		$xml_content.= "\t</Host_Info>\n";

		$xml_content.= "\t<Sync_List>\n";
		foreach($file_arr as $file)
		{
			if(substr($file,-1)=='/')
			{
				continue;
			}
			$dirname = dirname($file).'/';
			$basename= basename($file);
			
			$dir_info_arr[$dirname]['total']=count(array_filter(scandir($dirname),"filter"));
			$dir_info_arr[$dirname]['count']+=1;
			$dir_info_arr[$dirname]['files'][]=$basename;
		}
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
		
		$fp=fopen(XML_FILE_FOLDER.$xml_filename,'w');
		
		if(fwrite($fp,$xml_content))//xml文件生成成功后,继续写入Sync_Info表
		{
			$oSync_Info->UID=$_SESSION['auth']['ID'];
			$oSync_Info->XID=$Sync_ID;
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
$arr=$oRsync_Host->Browse("order by ID");
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
$smarty->assign('Rsync_Host', $Rsync_Host);
?>