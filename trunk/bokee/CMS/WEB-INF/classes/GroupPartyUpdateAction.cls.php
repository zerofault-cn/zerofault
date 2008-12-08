<?php 
/**
* ArticleListAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/
require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/User.cls.php');
require_once('com/Pager.cls.php');
require_once('mod/Subject.cls.php');

class GroupPartyUpdateAction extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中

        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError');   
        
		$dao = DAO::CreateInstance();
		$db = "cms_" . $request['channel_name'];
		$subject_id = $request['subject_id'];
		$dao->SetCurrentSchema($db);
		$del_flag=$request['del_flag'];
		$group_partyid=$request['group_partyid'];

		$sql = "update group_party set del_flag=".$del_flag." where id=".$group_partyid;
		
		if($dao->Update($sql))
		{
			echo '<script>parent.location.reload();</script>';
		}
		return;
	}
}
?>
