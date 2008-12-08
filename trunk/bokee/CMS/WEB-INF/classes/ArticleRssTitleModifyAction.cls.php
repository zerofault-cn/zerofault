<?php
/**
* ArticleRssTitleModifyAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class ArticleRssTitleModifyAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){

    	
		$channel_name = $request['channel_name'];

        $db = "cms_" . $channel_name;
        $response['channel_name'] = $channel_name;
        
        $id = intval($request['id']);
 				
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $sql = "select article_id,subject_id,title,mark from rel_article_subject where id=" . $id;
        $row = $dao->GetRow($sql);
		$cur_subject_id=$row['subject_id'];
        $response['rss_title'] = $row['title'];//文章标题
		$response['article_id'] =$row['article_id'];//rss_entry_attach表文章id
		$sql2="select author from rss_entry_attach where id=".$row['article_id'];
		$response['author']=$dao->GetOne($sql2);//作者名

		//获取子栏目
		$response['subject_options']=$this->getSubject($channel_name,$cur_subject_id);

		for( $i=0;$i<5;$i++ )
		{
			$tmp[$i]['value'] = $i+1;
			 if( $row['mark'] == $i+1 )
				$tmp[$i]['checked'] = "checked";
		}

		$response['rss_mark'] = $tmp;
		$response['rss_id'] = $id;
    		
    }
	function getSubject($dir_name,$subject_id, $parent_id=0, $level=1)
	{
		$db_name = "cms_" . $dir_name;
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db_name);
		$sql = "select * from subject where parent_id=" . $parent_id . " and sort=" . $level . " order by id desc limit 0, 50";
		
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		$level++;
		$minus = "";
		for($j=2;$j<$level;$j++)
		{
			$minus .= "--";
		}
		$script='';
		for($i=0;$i<$rows_num;$i++)
		{
			$id = $rows[$i]['id'];
			$name=$minus . $rows[$i]['name'];
			if($subject_id==$id)
			{
				$script .= '<option value="'.$id.'" selected>'.$name.'</option>'."\n";
			}
			else
			{
				$script .= '<option value="'.$id.'">'.$name.'</option>'."\n";
			}
			$script .= $this->getSubject( $dir_name, $id, $level);
		}
		return $script;
	}
}
?>