<?php
/**
* FeedDoAttachToSubjectAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Channel.cls.php');

class ContributeDoAttachToSubjectAction extends Action {
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
      	$channel_id = $form['select_channel'];
		$source = $request['source'];
      	$subject_id = intval(substr($form['subject_list'], 3, 3));
      	$feed_id = $request['feed_id'];
      	$channel = new Channel();
      	$channel->GetByID($channel_id);
      	$database = "cms_" . $channel->GetDirName();
      	$dao = DAO::CreateInstance();
      	$dao->SetCurrentSchema($database);
      	$sql = "select count(id) as num from rss_feed_attach where feed_id=$feed_id and subject_id=$subject_id";
      	$rows_num = $dao->GetOne($sql);
      	if($rows_num>0)
      	{
      		echo "此对应已经存在，请不要重复添加。";
      		exit;
      	}
      	$sql = "insert into rss_feed_attach set feed_id=".$feed_id.",subject_id=".$subject_id.",source='".$source."'";
      	if($dao->Query($sql))
      	  	echo "操作成功";
      	else 
      		echo "操作失败";
      	exit;
	}
}
?>