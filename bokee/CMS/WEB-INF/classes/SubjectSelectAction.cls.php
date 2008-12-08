<?php
/**
* ChannelSelectAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');

class SubjectSelectAction extends Action {
	/**
	 * 
	 * @access public
	 * @param array &$request
	 * @param array &$files
	 */
	function execute(&$actionMap,&$actionError,$request,&$response,$form){
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema( "cms_" . $request['channel_name'] );
		$db = "cms_" . $request['channel_name'];
		$subject = new Subject( $db );
		
		$response['subjects'] = $subject->GetSubjectOptions();

	}	

}
?>
