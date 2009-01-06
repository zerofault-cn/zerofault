<?php
/**
* UserModifyPasswordAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/User.cls.php');
require_once('sql/DAO.cls.php');

class PageNumClear extends Action {
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
		
		$dao = new DAO;
		$dao = DAO::CreateInstance();
		$db = "cms_".$request['channel_name'];
		$dao->SetCurrentSchema($db);
		$id = $_REQUEST['id'];
		$id = intval($id);
		$sql_clear = "update template set cur_page_num = '0' where id = '".$id."' ";
		$result = $dao->Update($sql_clear);
		if ($result){
			echo "<script>alert(\"清除成功，请重新发布\");history.go(-1);</script>";
			}
		else {
			echo "<script>alert(\"清除失败\");history.go(-1);</script>";
			}
		
        
	}
}
?>