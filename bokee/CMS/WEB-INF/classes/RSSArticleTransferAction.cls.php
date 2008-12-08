<?php
/**
* RSSArticleTransferAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');
require_once('com/Log.cls.php');
class RSSArticleTransferAction extends Action {
	/**
	 * 
	 * @access public
	 * @param array &$request
	 * @param array &$files
	 */
	function execute(&$actionMap,&$actionError,$request,&$response,$form){
		session_start();
		$user = $_SESSION['user'];
		
		$u = new User();
		$u->GetByID($user['id']);
		
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema( "cms" );
		if($user['role_id']<=1)
		{
			$sql = "select id from channel order by id desc limit 0, 50";
			$channel_ids = $dao->GetPlan($sql);
		}
		else 
		{
			$channel_ids = $u->GetChannelIDs();
		}
		
		$mark = array();
		for($i=0;$i<5;$i++)
		{
			$mark[$i]['value'] = $i+1;
			if( 0 == $i )
				$mark[$i]['checked'] = "checked";
		}
		$response['mark'] = $mark;
		
		$response['rss_string'] = $request['rss_string'];
		
		$channel_no = 0;
		for( $j=0;$j<count( $channel_ids );$j++ )
		{
			if($user['role_id']<=1)
			{
				$tmp_channel_id = $channel_ids[$j]['id'];
			}
			else
			{
				$tmp_channel_id = $channel_ids[$j]['channel_id'];
			}
			$channel_info = $this->getInfoFromId( $tmp_channel_id );
			$db = "cms_" . $channel_info['dir_name'];
			$dao->SetCurrentSchema( $db );
			$subject_list = $this->GetSubjectList($dao, 0, $tmp_channel_id);
			
			$response['channel_list'][$channel_no]['channel_name'] = $channel_info['name'];
			$response['channel_list'][$channel_no]['subject_list'] = $subject_list;
			$channel_no++;
		}
		
 	}	
 	function getInfoFromId( $Id ){
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema( "cms" );
		$sql = "select name,dir_name from channel where id='$Id'";
		return $dao->GetRow( $sql );
 	}
 	function GetSubjectList($dao, $parent_id, $channel_id)
 	{
 		if($parent_id>0)
 		{
	 		$subject_list = "<table width=100% border=0 cellpadding=0 cellspacing=1 bgcolor=C1D7F4><tr bgcolor=#F0F4FF><td>";
	 		$sql = "select id,name from subject where id=$parent_id";
	 		$row = $dao->GetRow($sql);
	 		$subject_list .= "<input name=subject[] type='checkbox' value='" . $channel_id . "||" . $row['id'] . "'>" . $row['name'];
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
				$subject_list .= $this->GetSubjectList($dao, $rows[$i]['id'], $channel_id);
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
