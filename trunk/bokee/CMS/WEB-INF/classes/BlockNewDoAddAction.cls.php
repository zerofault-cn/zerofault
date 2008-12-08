<?php
/**
* BlockNewDoAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');
class BlockNewDoAddAction extends Action {
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
		$subject_id = $form['subject_id'];
		$select_subject = $form['select_subject'];
        $channel_name = $form['channel_name'];
        $source_arr = $form['source'];
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
		$is_group = $request['radio_is_group'];
		$start_id = $form['start_id'];
		if( strlen( $start_id ) ==0 )
			$start_id = 0;

		$is_limit_title_length = $form['is_limit_title_length'];
		$title_length = $form['title_length'];
		if( !( $is_limit_title_length ) || strlen( $title_length ) == 0 )
		{
			$title_length = 0;
		}


        $limit = $form['limit'];
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
		if($is_group)
		{
			$content = "select * from rel_article_subject where mark>=" . $mark . $source_str . $subject_str ." GROUP BY group_id order by id desc limit ".$start_id."," . $limit;
		}
		else
		{
			if(strrpos($source,"rss"))
			{
				$content ="select l.*,r.id as rid,r.entry_id as rentry_id from rel_article_subject l,rss_entry_attach r where l.source in (" . $source . ") and l.mark>=1 and r.id=l.article_id group by l.article_id order by l.datetime desc limit $start_id," . $limit;
				
			}
			$content = "select * from rel_article_subject where mark>=" . $mark . $source_str . $subject_str ." group by datetime order by id desc limit ".$start_id."," . $limit;
		}
		$sql = "insert into template_block (subject_id, name, source, start_id, num, mark, format, content, selected_subject_id, title_length) values($subject_id, '$name', \"" . $source . "\",$start_id , $limit, $mark, '$format', \"" . $content . "\", $select_subject, $title_length)";
        $dao->Insert($sql);
		$last_id = $dao->LastID();
        //return "main.php?do=block_list&channel_name=$channel_name&subject_id=$subject_id";
		$str_js = "<script language='javascript'>";
		$str_js.= "alert('添加成功');";
		$str_js.= "window.opener.createOption('$last_id','$name','$last_id');;";
		$str_js.= "window.self.close();";
		$str_js.= "</script>";
		echo $str_js;
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
