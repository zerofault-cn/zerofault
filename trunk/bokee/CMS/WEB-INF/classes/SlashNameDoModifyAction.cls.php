<?php
/**
* SlashNameDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class SlashNameDoModifyAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){

        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema( "cms_" . $request['channel_name'] );
	$sql_select = "select name from template_slash where id=".$request['slash_id'];
	$tmp_name = $dao->GetOne( $sql_select );
	if( empty( $tmp_name ) )
		die( "参数错误!" );
		
	//检查模版文件中是否已存在该碎片名称
	$sql_select = "select t.path ";
	$sql_select.= "from template as t,template_slash as s ";
	$sql_select.= "where t.id = s.template_id and s.id=".$request['slash_id'];
        $file_path = $dao->GetOne( $sql_select );
        if( !file_exists( $file_path ) )
        {
        	Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
        	die( "文件读取错误!" );
	}
	else
	{
		$content = file_get_contents( $file_path );
	}
        if( $tmp_name == $request['slash_name'] )
       	{
        	die("替换成功！");
        }
        else
        {
       		$old_string = "<input type=hidden name=" . $tmp_name . " value=" . $request['slash_id'] . ">";
       		$new_string = "<input type=hidden name=" . $request['slash_name'] . " value=" . $request['slash_id'] . ">";
        }
        $content = str_replace( $old_string,$new_string,$content );
	$fp = fopen( $file_path,"w" );
	fwrite( $fp,$content );
	fclose( $fp );        
	$sql_update = "update template_slash set name='" . $request['slash_name'] . "' where id=" . $request['slash_id'];
	$dao->Update( $sql_update );
	echo "<font color=red>替换成功！</font>";
	echo "<script language='javascript'>window.opener.location.reload(); </script>";
     }
}
?>