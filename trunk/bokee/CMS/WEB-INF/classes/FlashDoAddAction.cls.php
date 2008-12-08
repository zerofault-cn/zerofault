<?php
/**
* FlashDoAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Flash.cls.php');
require_once('com/Lwgupload.cls.php');


class FlashDoAddAction extends Action {
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

//        $channel_name = $form['channel_name'];
//        $db = "cms_" . $channel_name;
//        $dao = DAO::CreateInstance();
//        $dao->SetCurrentSchema($db);
//        $name = $form['name'];
//        $path = trim($form['path'], '/');
//        $sql = "insert into flash_images set name='$name', path='$path'";
//        $dao->Insert($sql);
//        return "main.php?do=flash_list&channel_name=".$request['channel_name']."&channel_id=".$request['channel_id'];
   

        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            $response['form'] = $form;
            return $actionMap->findForward('failure');
        }
		
        $channel_name = $request['channel_name'];
	    $db = "cms_" . $channel_name;
		//$response['channel_name'] = $channel_name;	
	    $subject_id = $request['select_subject']; 
		$flash = new Flash($db);
	    $uploadpath = $flash->GetLocalPath($subject_id);
	    $uploadpathdb = str_replace($db."/","",substr( $uploadpath,strpos($uploadpath,$db),strrpos( $uploadpath,"/" ) ));
       
	    	    $flash->SetName($_REQUEST['name']);   	
        $flash->SetUploadPath($uploadpath);   	    
        $flash->SetFlashName($_FILES['flash_file']['name']);
        $flash->SetXmlName($_FILES['xml_file']['name']);
        $flash->SetCssName($_FILES['css_file']['name']); 
        //$pic_dir = $uploadpath."picture/"; 
        $pic_dir = $uploadpath."pictures"; 
        $picture_path = $flash->SetPicDir($pic_dir);  
      
        if($_FILES['css_file']['size']==0) 
           $upload_file = array($_FILES['flash_file'],$_FILES['xml_file']);   
        else				    
           $upload_file = array($_FILES['flash_file'],$_FILES['xml_file'],$_FILES['css_file']);      
              
        //print_r($upload_file);                     
        $upload = new Lwgupload();      
        $upload->Lwgupload($upload_file,$uploadpath,5242880000,"all");
        if ($upload->test())
           $upload->upload();
        
        $flah_path = $uploadpath.$_FILES['flash_file']['name'];
		$flash_path_remote = "/html" . str_replace(PATH_HTML_ROOT, "", $flah_path);			
		$ftp = new FTP($channel_name);
		if(!$ftp->Put($flah_path, $flash_path_remote)) 
		{
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传文件 出错。remote_path:$path_remote, local_path: $path_local");
				return false;
		}

        $xml_path = $uploadpath.$_FILES['xml_file']['name'];
		$xml_path_remote = "/html" . str_replace(PATH_HTML_ROOT, "", $xml_path);			
		$ftp = new FTP($channel_name);
		if(!$ftp->Put($xml_path, $xml_path_remote)) 
		{
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传文件 出错。remote_path:$path_remote, local_path: $path_local");
				return false;
		}		
		
		if($_FILES['css_file']['size']!=0)
		{
			$css_path = $uploadpath.$_FILES['css_file']['name'];
		    $css_path_remote = "/html" . str_replace(PATH_HTML_ROOT, "", $css_path);			
		    $ftp = new FTP($channel_name);
		    if(!$ftp->Put($css_path, $css_path_remote)) 
		    {
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传文件 出错。remote_path:$path_remote, local_path: $path_local");
				return false;
		    }
		}   
		               
        $response['data']['upload_path'] = $header->_upload_path;
        $response['data']['flash_name'] = $header->_flash_name;
        $response['data']['xml_file'] = $header->_xml_name;
        $response['data']['css_file'] = $header->_css_name;   
        $response['data']['pic_dir'] = $header->_pic_dir;   
        //$flash->Insert();   
        //    return "main.php?do=flash_list_new&channel_name=".$request['channel_name']."&$channel_id=".$request['subject_id'];             	        
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        //$name = $form['name'];
        //$path = trim($form['path'], '/');
        $path =  $uploadpathdb."Pictures.xml";
        $sql = "insert into flash_images set name='$flash->_name', path='$path'";
        $dao->Insert($sql);
            return "main.php?do=flash_list&channel_name=".$request['channel_name']."&channel_id=".$request['channel_id'];    
    }
}
?>    
