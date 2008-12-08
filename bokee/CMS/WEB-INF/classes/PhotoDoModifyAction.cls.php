<?php
/**
* PhotoDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Gallery.cls.php');
require_once('com/UploadImg.cls.php');
require_once('com/Log.cls.php');

class PhotoDoModifyAction extends Action {
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
        $id = $form['id'];
        $file = $_FILES['file'];
        $name = $form['name'];
        $path = $form['path'];
        $url = $form['url'];
		if($file['size']>0)
		{
	        $upload = new UploadImg();
	        $date = date('Y-m-d');
	        $path = "/" . $db . "/cphoto/".$date;
			$upload->setPath($path);
	        $upfile = $upload->upload($file);
	        $path = "http://images." . DOMAIN . "/" . $channel_name . "/cphoto/" . $date . "/" . $upfile['new_name'];
		}
		$gallery = new Gallery($db);
		$gallery->GetByID($id);
	    $gallery->SetName($name);
	    $gallery->SetSubjectId($subject_id);
		$gallery->SetPath($path);
		$gallery->SetUrl($url);
		$gallery->Update();
		
		return "main.php?do=photo_list&channel_name=$channel_name&subject_id=$subject_id";
	}
}
?>