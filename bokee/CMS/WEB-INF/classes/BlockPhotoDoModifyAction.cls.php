<?php
/**
 * BlockPhotoDoModifyAction.cls.php
 * @copyright bokee dot com
 * @author yudunde@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('com/Log.cls.php');
require_once('mod/Subject.cls.php');

class BlockPhotoDoModifyAction extends Action {
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
		$start_id = $request['start_id'];
        $db = "cms_" . $channel_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		$id = intval($form['id']);
		
		$subject_id = $form['subject_id'];
		$select_subject_id = $form['select_subject'];
		$is_group = $form['radio_is_group'];
		$is_limit_title_length = $form['is_limit_title_length'];
		$title_length = $form['title_length'];

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


		$sql = "update template_block set subject_id=$subject_id, name='$name',start_id='$start_id', num=$limit, format='$format', content=\"" . $content . "\", selected_subject_id=$select_subject_id ";
		if( $is_limit_title_length )
		{
			$sql .= ", title_length=$title_length ";
		}
		else
		{
			$sql .= ", title_length=0 ";
		}
		
		$sql.= "where id=" . $id;
		if($dao->Query($sql))
		{
			$js_str = "<script language='javascript'>";
			$js_str.= "alert('图片区块修改成功！');";
			$js_str.= "location.href='main.php?do=block_list&channel_name=$channel_name&subject_id=$subject_id';";
			$js_str.= "</script>";
			echo $js_str;
		}
		Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 添加热评区块$sql");
		die("修改图片区块时有错误发生");

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
