<?php
/**
* RSSArticleLocalTransferAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');
require_once('com/Log.cls.php');
class RSSArticleLocalTransferAction extends Action {
	/**
	 * 
	 * @access public
	 * @param array &$request
	 * @param array &$files
	 */
	function execute(&$actionMap,&$actionError,$request,&$response,$form){

		
		$subject_id = $request['subject_id'];
		$channel_name = $request['channel_name'];
		$id = $request['id'];
		
		//设置mark
		$mark = array();
		for($i=0;$i<5;$i++)
		{
			$mark[$i]['value'] = $i+1;
			if( 0 == $i )
				$mark[$i]['checked'] = "checked";
		}
		$response['mark'] = $mark;
		//设置mark

				
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema( "cms_" . $channel_name );
		
		$subject_list = $this->GetSubjectList($dao, 0);
		
		
		//设置传递给页面值
		$response['channel_name'] = $channel_name;
		$response['id'] = $id;
		$response['subject_list'] = $subject_list;
		
 	}	

 	function GetSubjectList($dao, $parent_id)
 	{
 		if($parent_id>0)
 		{
	 		$subject_list = "<table width=100% border=0 cellpadding=0 cellspacing=1 bgcolor=C1D7F4><tr bgcolor=#F0F4FF><td>";
	 		$sql = "select id,name from subject where id=$parent_id";
	 		$row = $dao->GetRow($sql);
	 		$subject_list .= "<input name=subject[] type='checkbox' value='" . $row['id'] . "'>" . $row['name'];
 		}
 		$sql = "select count(*) from subject where parent_id=$parent_id";
		$num = $dao->GetOne( $sql );
		//Log::Append($num);
		if( $num>0)
		{
			if($parent_id>0)
			{
				$subject_list .= "</td><td>";
			}
			$sql = "select * from subject where parent_id=$parent_id";
			$rows = $dao->GetPlan($sql);
			$rows_num = count($rows);
			for($i=0;$i<$rows_num;$i++)
			{
				$subject_list .= $this->GetSubjectList($dao, $rows[$i]['id']);
			}
		}

		if($parent_id>0)
		{
			$subject_list .= "</td></tr></table>";
		}

		return $subject_list;
 	}
}
?>
