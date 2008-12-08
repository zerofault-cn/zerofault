<?php
/**
* PhotoDoAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Gallery.cls.php');
require_once('com/UploadImg.cls.php');
require_once('com/Log.cls.php');
require_once('com/FTP.cls.php');

class PhotoDoAddAction extends Action {
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
		$channel_name = $form['channel_name'];
		$db = "cms_" . $channel_name;
        $subject_id = $form['select_subject'];
        $file = $_FILES['file'];
        $name = $form['name'];
        $url = $form['url'];
		$description=$form['description'];
		if($file['size']>0)
		{
	        $upload = new UploadImg();
	        $date = date('Y-m-d');
	        $path = "/" . $db . "/cphoto/".$date;
			$upload->setPath($path);
	        $upfile = $upload->upload($file);
	        $gallery = new Gallery($db);
	        $gallery->SetName($name);
	        $gallery->SetSubjectId($subject_id);
			$gallery->SetPath("http://images." . DOMAIN . "/" . $channel_name . "/cphoto/" . $date . "/" . $upfile['new_name']);
			$gallery->SetUrl($url);
			$gallery->SetDescription($description);
			$LastID=$gallery->Insert();

			if($LastID>0)
			{
				$ftp = new FTP($channel_name);
				$db_name=$db;
				$page = "<html>\n";
				$page.="<meta http-equiv=\"refresh\" content=\"0;url=".$url."\">\n";
				$page.="<head>\n <title></title> \n </head> \n <body>";
				$page.= "<script language='javascript'> \n";
				$page.= "location.href='" . $url . "' \n";
				$page.=	"</script> \n";
				$page.=	"</body> \n </html> \n";
				$date = date('Y-m-d');
				if(!is_dir(PATH_HTML_ROOT . "/$db_name/cphoto"))
					mkdir(PATH_HTML_ROOT . "/$db_name/cphoto");
				if(!is_dir(PATH_HTML_ROOT . "/$db_name/cphoto/$date"))
					mkdir(PATH_HTML_ROOT . "/$db_name/cphoto/$date");
				$path = PATH_HTML_ROOT . "/$db_name/cphoto/$date/" . $LastID . ".html";
				$path_remote = "/html/$db_name/cphoto/$date/" . $LastID . ".html";
				
				$tmp_db_name=('cms_blog'==$db_name)?'cms_blogs':$db_name;
				$tmp_db_name=('cms_group'==$tmp_db_name)?'cms_groups':$tmp_db_name;
				$html_url = "http://" . str_replace('cms_','',$tmp_db_name). "." . DOMAIN . "/cphoto/$date/" . $LastID . ".html";
				
				$fp = fopen($path, 'w');

				fwrite($fp, $page);
				fclose($fp);
				$ftp->Put($path, $path_remote);
				{
					$gallery->SetId($LastID);
					$gallery->SetUrl($html_url);
					$gallery->UpdateUrl();
				}
			}
		}
		else 
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近没有上传图片 。");
		}
		return "main.php?do=photo_list&channel_name=$channel_name&subject_id=$subject_id";
	}
}
?>