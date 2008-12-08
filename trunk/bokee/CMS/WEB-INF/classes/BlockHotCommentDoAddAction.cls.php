<?php
/**
 * BlockAction.cls.php
 * @copyright bokee dot com
 * @author liut@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Log.cls.php');
require_once('mod/Subject.cls.php');

class BlockHotCommentDoAddAction extends Action {
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
		$start_id = $form['start_id'];
		if( strlen( $start_id ) == 0 )
			$start_id = 0;

        $db = "cms_" . $channel_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		
		$subject_id = $form['subject_id'];
		$select_subject_id = $form['select_subject'] > 0?$form['select_subject']:0;
		$is_group = $form['radio_is_group'];
		$radio_source = $form['radio_source'];

		$limit = $form['limit'];
		$time = $form['time'];

		$is_limit_title_length = $form['is_limit_title_length'];
		$title_length = $form['title_length'];
		if( !( $is_limit_title_length ) || strlen( $title_length ) == 0 )
		{
			$title_length = 0;
		}
		
		if($select_subject_id==0)
		{
			$subject_name = "根栏目";
		}
		else 
		{
			$subject = new Subject($db);
			$subject->GetByID($select_subject_id); 
			$subject_name = $subject->GetName();
		}

		$name = "*@*@*" . $subject_name .$time."小时内, 从" . $start_id . "开始 " .$limit."条热评文章";
		$subject_str = $select_subject_id . $this->getSubjectIdStr($dao, $select_subject_id);
		if($select_subject_id==0)
		{
			$where_subject = "";
		}
		else 
		{
			$where_subject = "subject_id in ($subject_str) AND ";
			$where_subject1 = "a.subject_id in ($subject_str) AND ";
		}
		$format = $form['format'];
		if( "cms" == $radio_source )
		{
			$content = "SELECT * FROM article WHERE $where_subject create_time > ( now() - INTERVAL " . $time . " HOUR ) ";	
			if( $is_group )
			{
				$content .= " GROUP BY group_id ";
			}
			$content.= " ORDER BY comment_num DESC LIMIT " . $start_id . " , " .$limit;
		}
		else
		{
			$content = "SELECT e.id as id,e.title as title,e.author,e.commentnum,e.url  ";
			$content.= " FROM rss_entry_attach as e,rel_article_subject as a ";
			$content.= " WHERE $where_subject1  e.datetime > ( now() - INTERVAL " . $time . " HOUR ) and a.article_id=e.id ";	
			$content.= " ORDER BY e.commentnum DESC LIMIT " . $start_id . " , " .$limit;
		}


		$sql = "insert into template_block (subject_id, start_id, name, source, num, mark, format, content, selected_subject_id, time,title_length) values($subject_id, '$start_id', '$name', '', $limit, 0, '$format', \"" . $content . "\", $select_subject_id, $time, $title_length)";

				
		if($dao->Query($sql))
		{
			$last_id= $dao->LastID();
			$str_js = "<script language='javascript'>";
			$str_js.= "alert('添加成功');";
			$str_js.= "window.opener.createOption('$last_id','$name','$last_id');;";
			$str_js.= "window.self.close();";
			$str_js.= "</script>";
			echo $str_js;
		}
		Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 添加热评区块$sql");
		die("添加热评区块时有错误发生");

	}

	function getSubjectIdStr($dao, $subject_id)
	{
		$sql = "SELECT id FROM subject WHERE parent_id = ".$subject_id." ORDER BY id DESC";
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{
			$subject_str .= "," . $rows[$i]['id'];
			$subject_str .= $this->getSubjectIdStr($dao, $rows[$i]['id']);
		}
		return $subject_str;
	}
}
?>
