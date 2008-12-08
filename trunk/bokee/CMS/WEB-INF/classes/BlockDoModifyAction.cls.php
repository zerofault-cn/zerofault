<?php
/**
* BlockDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class BlockDoModifyAction extends Action {
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
        $id = $form['id'];
        $subject_id = $form['subject_id'];
		$select_subject = $form['select_subject'];
        $channel_name = $form['channel_name'];
        $source_arr = $form['source'];

		$is_limit_title_length = $form['is_limit_title_length'];
		$title_length = $form['title_length'];

        $source_num = count($source_arr);
        $source = "";
		/**
		*根据source的值优化sql
		*add by zhuming at 2007/3/9
		*/
		$source_str = "";
		if($source_num==1)//只有一项匹配时用“＝”加快sql执行速度
		{
			$source="'".$source_arr[0]."'";
			$source_str=" and source='". $source_arr[0] ."' ";
		}
		else
		{
			for($i=0;$i<$source_num;$i++)
			{
				$source .= "'" . $source_arr[$i] . "',";
			}
			$source = substr($source, 0, strlen($source)-1);
			if($source_num==6)//即全部source
			{
				$source_str="";
			}
			else
			{
				$source_str=" and source in (".$source.") ";
			}
		}
        $name = $form['name'];
		$start_id = $form['start_id'];
        $limit = $form['limit'];
        if( strlen($start_id) ==0 )
			$start_id = 0;
		
		$mark = $form['mark'];
        $format = $form['format'];
        $db = "cms_" . $channel_name;
        
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);
		if($select_subject>0)
		{
			$subjectId_str=$this->getSubjectIdStr($dao, $select_subject);
			if(''==$subjectId_str)
			{
				$subject_str=" and subject_id=".$select_subject;
			}
			else
			{
				$subject_str = " and subject_id in (" . $select_subject . $subjectId_str .  ")";
			}
		}
		else 
		{
			$subject_str = "";
		}
		$content = "select * from rel_article_subject where mark>=" . $mark . $source_str . $subject_str ." group by datetime order by id desc limit $start_id," . $limit;
        
        $sql = "update template_block set subject_id=".$subject_id.", name='".$name."', source=\"" . $source . "\", start_id=".$start_id.", num=".$limit.", mark=".$mark.", format='".$format."', content=\"" . $content . "\", selected_subject_id=".$select_subject;
		
		if( $is_limit_title_length )
		{
			$sql .= ", title_length=".$title_length;
		}
		else
		{
			$sql .= ", title_length=0 ";
		}
		
		$sql.= " where id=" . $id;

        $dao->Query($sql);
        return "main.php?do=block_list&channel_name=$channel_name&subject_id=$subject_id";
        
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
