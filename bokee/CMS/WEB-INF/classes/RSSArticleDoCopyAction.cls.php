<?php
/**
* RSSArticleLocalDoTransferAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');



class RSSArticleDoCopyAction extends Action {
	/**
	 * 
	 * @access public
	 * @param array &$request
	 * @param array &$files
	 */
	function execute(&$actionMap,&$actionError,$request,&$response,$form){
		
		//接收用户信息
		session_start();
		$user = $_SESSION['user'];

		//接收变量
		$channel_name = $request['channel_name'];
		$id = $request['id'];
		$radio_mark = $request['radio_mark'];
		$title = $request['title'];
		$subject_id = $request['subject'];
	
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema( "cms_" . $channel_name );

		$sql_select = "select * from rel_article_subject where id='$id'";
		$row = $dao->GetRow( $sql_select );
		
		for( $i=0;$i<count($subject_id);$i++ )
		{
			$sql_insert = "insert into rel_article_subject(article_id,subject_id,title,url,category,updatetime,datetime,source,mark,user_id) ";
			$sql_insert.= "values('" . $row['article_id'] . "','" . $subject_id[$i] . "','" . $title . "','";
			$sql_insert.= $row['url'] . "','" . $row['category'] . "','" . $row['updatetime'] . "','" . $row['datetime'] . "','";
			$sql_insert.= $row['source'] . "','" . $radio_mark . "','" .$user['id'] . "')";
			$dao->Insert( $sql_insert );
		}
		
		
		$js_str = "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
		$js_str.= "<script language='javascript'>";
		$js_str.= "alert('succeed!');";
		$js_str.= "self.close()";
		$js_str.= "</script>";
		echo $js_str;
		
 	}	
 	
 	
}
?>
