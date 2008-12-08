<?php
/**
* FeedArticleTransferAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');

class ContributeArticleTransferAction extends Action {
	/**
	 * 
	 * @access public
	 * @param array &$request
	 * @param array &$files
	 */
	function execute(&$actionMap,&$actionError,$request,&$response,$form){
		
		session_start();
		$dao = DAO::CreateInstance();
		$user = $_SESSION['user'];
		$u = new User();
		$u->GetByID($user['id']);
		if( $user['role_id'] > 1 )
		{
			//只能管理具有权限的频道
			$channel_ids = $u->GetChannelIDs();
			$sql = "select * from channel where id in (".implode(',',$channel_ids).") order by id desc";
		}
		else
		{
			//所有频道都可以管理
			$sql = "select * from channel order by id desc ";
		}
		$rows_channel = $dao->GetPlan($sql);
		$rows_num_channel = count($rows_channel);
		$response['channels'] = $rows_channel;
        $subjects_array = "";
		for($i=0;$i<$rows_num_channel;$i++)
		{
			$channel_id = $rows_channel[$i]['id'];
			$subjects_array .= $this->getSubChannel($rows_channel[$i]['id'], $rows_channel[$i]['dir_name']);
    	}
    	$subjects_array = substr($subjects_array, 0, strlen($subjects_array)-2);
    	$response['data']['subjects_array'] = $subjects_array;
		
		$mark = array();
		for($i=0;$i<5;$i++)
		{
			$mark[$i]['value'] = $i+1;
			if( 0 == $i )
				$mark[$i]['checked'] = "checked";
		}
		$response['mark'] = $mark;

		$response['article_id_string'] = $request['article_id_string'];
		$response['feed_id'] = $request['feed_id'];

		$article_id_array = explode( "||",$response['article_id_string'] );
		
		$response['rss_article_num']="";
		$response['rss_article_type']="disabled";

		if (!isset($article_id_array[1])){//只选择了一篇文章
			$article_id = $article_id_array[0];
			$dao_contribute = DAO::CreateInstanceEmpty();
			$dao_contribute->Connect('contribute', 'root', '10y9c2U5', '221.238.254.205');
			$sql = "select * from article where id =" . $article_id;
			$row = $dao_contribute->GetRow($sql);
			$response['rss_article_type']= "";
			$response['rss_article_name'] = conv($row['title']);
			$response['rss_article_num'] = 1;
			}
	}
 	
 	function getSubChannel($channel_id, $dir_name, $parent_id=0, $level=1)
	{
		$db_name = "cms_" . $dir_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db_name);
		$sql = "select * from subject where parent_id=" . $parent_id . " and sort=" . $level . " order by id desc limit 0, 50";
		
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		$level++;
		$script = "";
		$minus = "";
		for($j=2;$j<$level;$j++)
		{
			$minus .= "--";
		}
		for($i=0;$i<$rows_num;$i++)
		{
			$id = $this->getNumberStr($channel_id) . $this->getNumberStr($rows[$i]['id']);
			$script .= "new Array(\"" . $id . "\",\"" . $minus . $rows[$i]['name'] . "\"),\n";
			$script .= $this->getSubChannel($channel_id, $dir_name, $rows[$i]['id'], $level);
		}
		return $script;
	}
	
	/**
	* @access private
	* @param int $number
	* @return stirng $string
	*/
	function getNumberStr($number)
	{
		$number = intval($number);
		if($number<10)
			return "00" . $number;
		if($number<100)
			return "0" . $number;
		return $number;
	}

}
function conv($str)
{
	return mb_convert_encoding($str,"utf-8","utf-8,gbk,gb2312");
}
?>