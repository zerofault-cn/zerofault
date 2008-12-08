<?php
/**
 * BlockHotCommentDoModifyAction.cls.php
 * @copyright bokee dot com
 * @author yudunde@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Log.cls.php');
require_once('mod/Subject.cls.php');

class BlockHotCommentDoModifyAction extends Action {
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
        $db = "cms_" . $channel_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		$id = $form['id'];
		$is_group = $form['radio_is_group'];
		$subject_id = $form['subject_id'] > 0?$form['subject_id']:0;
		$select_subject_id = $form['select_subject'] > 0?$form['select_subject']:0;
		
		$limit = $form['limit'] > 0?$form['limit']:5;
		$time = $form['time'] > 0?$form['time']:24;

		$is_limit_title_length = $form['is_limit_title_length'];
		$title_length = $form['title_length'];
		if( !( $is_limit_title_length ) || strlen( $title_length ) == 0 )
		{
			$title_length = 0;
		}
		$radio_source = $form['radio_source'];
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
		
		$format = $form['format'];
		if($select_subject_id==0)
		{
			$where_subject = "";
		}
		else 
		{
			$where_subject = "subject_id in ($subject_str) AND ";
			$where_subject1 = "a.subject_id in ($subject_str) AND ";
		}

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
			$content = "SELECT e.id as id,e.title as title,e.author,e.commentnum,e.url ";
			$content.= " FROM rss_entry_attach as e,rel_article_subject as a ";
			$content.= " WHERE $where_subject1  e.datetime > ( now() - INTERVAL " . $time . " HOUR ) and a.article_id=e.id  ";	
			$content.= " ORDER BY e.commentnum DESC LIMIT " . $start_id . " , " .$limit;
		}

		$sql = "update template_block set subject_id=$subject_id, name='$name', start_id='$start_id' , num=$limit, time=$time, format='$format', content=\"" . $content . "\", selected_subject_id=$select_subject_id,title_length=$title_length where id=" . $id;
		
		if($dao->Query($sql))
		{
			//die("热评区块成功保存");
			$js_str = "<script language='javascript'>";
			$js_str.= "alert('热评区块成功保存！');";
			$js_str.= "location.href='main.php?do=block_list&channel_name=$channel_name&subject_id=$subject_id';";
			$js_str.= "</script>";
			echo $js_str;
		}
		Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 修改热评区块 " . $sql);
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
