<?php
/**
* TemplateDoCopyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/TemplateA.cls.php');

class TemplateDoCopyAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){

		//接收数据
		$id = $request['template_id'];
		$target_subject = $request['subject_id'];
		$new_tpl_name = $request['new_tpl_name'];
		$new_file_name = $request['file_name'];
		$db = "cms_" . $request['channel_name'];
		if( empty($new_tpl_name) || empty($new_file_name) )
		{
			die("模版或者目标文件名称不能为空！");
		}		
		

		$subject_array_id = explode(",", $target_subject);
		for($su = 0; $su< count($subject_array_id)-1; $su++)
		{		
		$subject_id = $subject_array_id[$su];

		//读取源文件及数据库数据
		$tpl = new TemplateA( $db );
		$tpl->GetTemplateById( $id );
		$content = file_get_contents( $tpl->_path );

		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema( $db );
		
		//复制原template表中数据
		$sql_select = "select * from template where id=$id";
		$tpl_row = $dao->GetRow( $sql_select );

		$sql_insert = "insert into template(special_id,name,file_name,sort,is_default,subject_id,special_subject_id,is_more) ";
		$sql_insert.= "values('" . $tpl_row['special_id'] . "','$new_tpl_name','$new_file_name','0','N','$subject_id','" . $tpl_row['special_subject_id'] . "','" . $tpl_row['is_more'] ."')";
		$dao->Insert( $sql_insert );
		
		$LastID = $dao->LastID();
		$new_tpl_path = PATH_TEMPLATE . "/" . $db . "/" . $LastID . ".html";
		
		$sql_update = "update template set path = '$new_tpl_path' where id='$LastID'";
		$dao->Update( $sql_update );
		
		//按照template_slash数据库内容替换content
		$sql_select = "select * from template_slash where template_id='$id' ";
		$slash_res = $dao->GetPlan( $sql_select );
		$block_lastID = 0;
		for( $i=0;$i<count($slash_res);$i++ )
		{
			//如果是区块，则复制区块
			if( $slash_res[$i]['category'] == "block" )
			{
				//从slash中得到block信息，然后进行复制
				$sql_select = "select * from template_block where id=" . $slash_res[$i]['block_id'];
				$block_res = $dao->GetRow($sql_select);

				$subject_str = " and subject_id in (" . $subject_id . $this->getSubjectIdStr($dao, $subject_id) .  ")";

			
				//图片区块
				if( strpos( $block_res['name'],'@*@*@' ) )
				{
					$sql_content = "SELECT * FROM gallery WHERE $where_subject GROUP BY group_id ORDER BY id DESC LIMIT " . $block_res['start_id'] . "," . $block_res['num'] ;
				}

				//热评文章区块
				if( strpos( $block_res['name'],'*@*@*' ) )
				{
					$sql_content = "SELECT * FROM article WHERE $where_subject create_time > ( now() - INTERVAL " . 	$block_res['time'] . " HOUR )  ORDER BY comment_num DESC LIMIT ".$block_res['num'];
				}

				//普通区块
				if( strpos( $block_res['name'],'*@*@*' ) === false && strpos( $block_res['name'],'@*@*@' ) == false )
				{
				
					$sql_content = "select * from rel_article_subject where source in (" . $block_res['source'] . ") $subject_str and mark>=" . $block_res['mark'] . " group by article_id order by `datetime` desc limit " . $block_res['num'];
				}
			
				//插入到template_block表
				$sql_insert = "insert into template_block(name,content,template_id,format,subject_id,source,start_id,num,mark,selected_subject_id,time) values('" . $block_res['name'] . "',\"" . $sql_content . "\",'0','" . $block_res['format'] . "','" . $subject_id . "',\"" . $block_res['source'] . "\",'" . $block_res['start_id'] . "','" . $block_res['num'] . "','" . $block_num['mark'] . "','" . $subject_id . "','" . $block_res['time'] . "')";
			

				$dao->Insert($sql_insert);
				$block_lastID = $dao->LastID();
			}

			//逐条复制slash信息，然后替换$content中相应的标志
			$sql_insert = "insert into template_slash(name,template_id,content,category,block_id) ";
			$sql_insert.= "values('" . $slash_res[$i]['name'] . "','$LastID', '" . $slash_res[$i]['content'] . "' , ";
			$sql_insert.= "'" . $slash_res[$i]['category'] . "','" . $block_lastID . "')";

			$dao->Insert( $sql_insert );
			$slash_lastID = $dao->LastID();

			$old_string = "<input type=hidden name=" . $slash_res[$i]['name'] . " value=" . $slash_res[$i]['id'] . ">";
			$new_string = "<input type=hidden name=" . $slash_res[$i]['name'] . " value=" . $slash_lastID . ">";
			$content = str_replace( $old_string,$new_string,$content );
		}
		$fp = fopen( $new_tpl_path,"w" );
		fwrite( $fp,$content );
		fclose( $fp );
		
		}

		$js_str = "<script language='javascript'>";
		$js_str.= "alert('复制成功！');";
		$js_str.= "location.href='main.php?do=template_list&channel_name=" . $request['channel_name'] ."&subject_id=$subject_id';";
		$js_str.= "</script>";
		echo $js_str;

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
