<?php
/**
* SlashDoEditAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/UploadImg.cls.php');
require_once('com/Log.cls.php');

class SlashDoEditAction extends Action {
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
        $response['channel_name'] = $channel_name;
        $id = intval($form['id']);
        $template_id = intval($form['template_id']);
        $content = $form['content'];
        $subject_id = intval($form['subject_id']);
        
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        if($_FILES['image']['size']>0)
        {
        	$upload = new UploadImg();
			$date = date('Y-m-d');
			$path = "/" . $db . $this->GetSubjectPath($subject_id, $db) . "/index/" . $date;
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 " . $path);
			$upload->setPath($path);
			$path = str_replace('cms_', '', $path);
			$file_name = $upload->upload($_FILES['image']);
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 " . $file_name['new_name']);
			$image_url .= "http://images." . DOMAIN . $path . "/" . $file_name['new_name'];
			
			$content = preg_replace("/src=\".*?\"/i", "src=\"" . $image_url . "\"", $content);
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 $content。");
        }
		$content = str_replace("'","\'",$content);
        $sql = "update template_slash set content='" . $content . "' where id =" . $id;
      
        if( $dao->Query($sql))
        {
        	return "main.php?do=template_edit&channel_name=".$channel_name."&id=".$template_id."&subject_id=".$subject_id;
        }
        else 
        {
        	return $actionMap->findForward('failure');
        }
	}
	function GetSubjectPath($subject_id, $db)
	{
		$subject = new Subject($db);
		$subject->GetByID($subject_id);
		$level = $subject->GetSort();
		for($i=0;$i<$level;$i++)
		{
			$subjects[$i] = $subject->GetDirName();
			$subject->GetByID($subject->GetParentId());
		}
		$subject_path = "";
		for($i=$level-1;$i>=0;$i--)
		{
			$subject_path .= "/" . $subjects[$i];
			if(!is_dir($subject_path))
			{
				mkdir($subject_path, 0700);
			}
		}
		return $subject_path;
	}
}
?>