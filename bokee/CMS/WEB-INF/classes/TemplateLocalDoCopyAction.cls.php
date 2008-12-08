<?php
/**
* TemplateLocalDoCopyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/TemplateA.cls.php');

class TemplateLocalDoCopyAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){

		//接收数据
		$id = $request['template_id'];
		$subject_id = $request['subject_id'];
		$db = "cms_" . $request['channel_name'];


		//读取源文件及数据库数据
		$tpl = new TemplateA( $db );
		$tpl->GetTemplateById( $id );
		$content = file_get_contents( $tpl->_path );

		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema( $db );

		//复制原template表中数据
		$sql_select = "select * from template where id=$id";
		$tpl_row = $dao->GetRow( $sql_select );
		$new_tpl_name = $tpl_row['name']."_副本";
		$new_file_name = $tpl_row['file_name'];
		$sql_insert = "insert into template(special_id,name,file_name,sort,is_default,subject_id,special_subject_id,is_more) ";
		$sql_insert.= "values('" . $tpl_row['special_id'] . "','$new_tpl_name','$new_file_name','0','N','$subject_id','" . $tpl_row['special_subject_id'] . "','".$tpl_row['is_more'] . "')";
		$dao->Insert( $sql_insert );
		
		$LastID = $dao->LastID();
		$new_tpl_path = PATH_TEMPLATE . "/" . $db . "/" . $LastID . ".html";
		
		$sql_update = "update template set path = '$new_tpl_path' where id='$LastID'";
		$dao->Update( $sql_update );
		
		//按照template_slash数据库内容替换content
		$sql_select = "select * from template_slash where template_id='$id' ";
		$slash_res = $dao->GetPlan( $sql_select );
		for( $i=0;$i<count($slash_res);$i++ )
		{
			//逐条复制slash信息，然后替换$content中相应的标志
			$sql_insert = "insert into template_slash(name,template_id,content,category,block_id) ";
			$sql_insert.= "values('" . $slash_res[$i]['name'] . "','$LastID', '" . $slash_res[$i]['content'] . "' , ";
			$sql_insert.= "'" . $slash_res[$i]['category'] . "','" . $slash_res[$i]['block_id'] . "')";
			$dao->Insert( $sql_insert );
			$slash_lastID = $dao->LastID();

			$old_string = "<input type=hidden name=" . $slash_res[$i]['name'] . " value=" . $slash_res[$i]['id'] . ">";
			$new_string = "<input type=hidden name=" . $slash_res[$i]['name'] . " value=" . $slash_lastID . ">";
			$content = str_replace( $old_string,$new_string,$content );
		}
		$fp = fopen( $new_tpl_path,"w" );
		fwrite( $fp,$content );
		fclose( $fp );

		$js_str = "<script language='javascript'>";
		$js_str.= "alert('复制成功！');";
		$js_str.= "history.back();";
		$js_str.= "</script>";
		echo $js_str;

	}
}
