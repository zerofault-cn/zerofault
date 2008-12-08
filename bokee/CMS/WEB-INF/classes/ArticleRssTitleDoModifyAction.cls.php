<?php
/**
* ArticleRssTitleDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class ArticleRssTitleDoModifyAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema( "cms_" . $request['channel_name'] );

		//更新rel_article_subject表
		$sql = "update rel_article_subject set subject_id=".$request['subject_id'].",title='" . $request['rss_title'] . "', mark='" . $request['rss_mark'] . "' where id=" . $request['rss_id'];
		

		$sql2="update rss_entry_attach set title='" . $request['rss_title'] . "',author='".$request['author']."' where id=".$request['article_id'];
		if($dao->Update( $sql ) && $dao->Update( $sql2 ))
		{
			$js_str = "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
			$js_str.= "<script language='javascript'>";
			$js_str.= "alert('succeed!');";
			$js_str.= "self.close();window.opener.location.reload();";
			$js_str.= "</script>";
			echo $js_str;
		}
	}
}
?>