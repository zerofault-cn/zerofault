<?php
/**
* FlashPicDoAddNewAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
midify by zhangfang 2005/11/22
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/FTP.cls.php');
require_once('com/Log.cls.php');
require_once('com/UploadImg.cls.php');
require_once('mod/Gallery.cls.php');
require_once('mod/Subject.cls.php');
class FlashPicDoAddNewAction extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中
        // 给forward增加参数(在进行页面跳转时使用)
        // $actionMap->addForwardParam('key_test','value_test','name_test');
        // 返回的forward是一个数组
        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError');   
        

        //接受并处理传递变量
		if( $_FILES['flash_pic']['size'] == 0 )
		{
			die("参数错误!");
		}

		$channel_name = $form['channel_name'];
		$flash_id = intval($form['flash_id']);
		$db = "cms_" . $channel_name;
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $sql = "select * from flash where id=$flash_id";
        $row = $dao->GetRow($sql);            		
		$xml_path = $form['flash_path'] . $row['xml_name'];
		//$pic_path = $form['flash_path'] . "pictures";
		$pic_path = $row['pic_dir'];
		
		//处理上传文件
		if( $_FILES['flash_pic']['size']>0 )
		{
			//为上传文件建立一个新名称
			$new_pic_name = "";
			for( $i=0;$i<10;$i++ )
			{
				$new_pic_name .= rand(0,10);
			}
			switch( $_FILES['flash_pic']['type'] )
			{
				case "image/jpeg":
					$new_pic_name .= ".jpg";
					break;
				case "image/gif":
					$new_pic_name .= ".gif";
					break;
				case "image/png":
					$new_pic_name .= ".png";
					break;
				default:
					$new_pic_name .= ".jpg";
					break;
			}
			//建立新名称结束
			
			//上传图片
			$new_img_path =$pic_path . "/" . $new_pic_name;
			copy($_FILES['flash_pic']['tmp_name'], $new_img_path);
			
			$path_remote = "/html" . str_replace(PATH_HTML_ROOT, "", $new_img_path);
			$ftp = new FTP($channel_name);
			if(!$ftp->Put($new_img_path, $path_remote)) 
			{
				echo asdfsa;
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传文件 出错。remote_path:$path_remote, local_path: $path_local");
				return false;
			}
			$sql="SELECT * FROM `subject` WHERE name='flash图片管理'";  
			if (!$sort = $dao->GetCol($sql))
			{
			$subject = new Subject($db);
			$subject->SetName("flash图片管理");
			$subject->SetDirName("flashpic");
			$subject->SetParentId("0"); 
			$subject->SetCategory("0");
			$subject->SetSort(1);
			$subjectid=$subject->Insert();
			}else{
				$subjectid=$sort[0];

			}
	        $upload = new UploadImg();
	        $path="/".$db."/"."flashpic_small";
			$upload->setPath($path);
			$upload->setSmallPath($path);
	        $upfile = $upload->upload($_FILES['flash_pic']);
	        $gallery = new Gallery($db);
	        $gallery->SetName("flashpic");
	        $gallery->SetSubjectId($subjectid);
			$gallery->SetPath("http://images." . DOMAIN . "/" . $channel_name . "/flashpic_small/" . $upfile['new_name']);
			$gallery->SetUrl("www.sohu.com");
			$gallery->Insert();
		}
	
		//读取原xml文件内容
/*		$xml  = file_get_contents( $xml_path );
		$count_pics = preg_match_all( "/<pic>(.*?)<\/pic>/i", $xml, $pics, PREG_PATTERN_ORDER );
        $count_names = preg_match_all( "/<name>(.*?)<\/name>/i", $xml, $names, PREG_PATTERN_ORDER );
        $count_urls = preg_match_all( "/<url>(.*?)<\/url>/i", $xml, $urls, PREG_PATTERN_ORDER );

		//重建xml内容
		$new_content = '<?xml version="1.0" encoding="utf-8"?>';
		
		$new_content .= '<pictures>	<picturesName>';
		for( $i=0;$i<$count_pics;$i++)
    	{
			$new_content .= $pics[0][$i];
		}
		$new_content .= "<pic>" . "pictures/" . $new_pic_name . "</pic>";
		$new_content .= "</picturesName><newsName>";

		for( $i=0;$i<$count_names;$i++)
		{
			$new_content .= $names[0][$i];
		}
		$new_content .= "<name>" . $form['pic_name'] . "</name>";
		$new_content .= "</newsName><newsURL>";
		for( $i=0;$i<$count_urls;$i++ )
		{
			$new_content .= $urls[0][$i];
		}
		$new_content .= "<url>" . $form['pic_url'] . "</url>";
		$new_content .= "</newsURL></pictures>";

		$fp = fopen( $xml_path,"w" );
		fwrite( $fp,$new_content );
		fclose( $fp );

		$ftp = new FTP($channel_name);
		$path_remote = str_replace(PATH_HTML_ROOT, "/html", $xml_path);
		Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传文件 remote_path:$path_remote, local_path: $path");
		$ftp->Put($xml_path, $path_remote);
		$ftp->Close();
*/		
		echo "<font color=red>添加成功！</font>";
	    echo "<script language='javascript'>window.opener.location.reload(); </script>";
    }
}
?>