<?php
/**
 * BlockPhotoDoAddAction.cls.php
 * @copyright bokee dot com
 * @author yudunde@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/Log.cls.php');
require_once('mod/Subject.cls.php');

class BlockPhotoDoAddAction extends Action {
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
		$title_length = $form['title_length'];
		if( !( $is_limit_title_length ) || strlen( $title_length ) == 0 )
		{
			$title_length = 0;
		}
		$start_id = $request['start_id'];
        $db = "cms_" . $channel_name;
		$is_group = $request['radio_is_group'];

		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		
		$subject_id = $form['subject_id'];
		$select_subject_id = $form['select_subject'];
		$limit = $form['limit'];
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
		$curtime = date("Ymd-His");
		$name = "@*@*@" . $subject_name . "从" . $start_id . "开始，最新" . $limit . "张图片_" . $curtime;
		
		if($select_subject_id==0)
		{
			$where_subject = " ";
		}
		else 
		{
			$subject_str = $select_subject_id . $this->getSubjectIdStr($dao, $select_subject_id);
			$where_subject = " WHERE subject_id in ($subject_str) ";
		}
		$format = $form['format'];

		$content = "SELECT * FROM gallery $where_subject ";
		
		if( $is_group )
		{
			$content.= "GROUP BY group_id ";
		}

		$content.= " ORDER BY id DESC LIMIT $start_id,$limit";

	$sql = "insert into template_block (subject_id, name, source,start_id , num, mark, format, content, selected_subject_id ,title_length) values($subject_id, '$name', '', $start_id , $limit, 0, '$format', \"" . $content . "\", $select_subject_id ,$title_length)";
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
		die("添加图片区块时有错误发生");

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
