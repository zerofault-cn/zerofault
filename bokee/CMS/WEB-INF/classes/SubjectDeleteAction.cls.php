<?php
/**
* ArticleDeleteAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');

class SubjectDeleteAction extends Action {
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
        $channel_name = $request['channel_name'];
        $db = "cms_" . $channel_name;
	    $id= $request['id'];
        if($id>0)
        {
       		$template_subjectid = new TemplateA($db);
			$template_subjectid -> GetTemplateBySubjectid($id);
			if (is_array($template_subjectid->_row_subjectid))
			{
				echo "<script>alert('请删除该栏目中的模版');history.go(-1);</script>";
				exit;
			}
       		$subject = new Subject($db);
       		if(is_array($subject->GetSubjectArray($id)))
			{
				echo "<script>alert('请删除该栏目中的子栏目');history.go(-1);</script>";
				exit;
			}
			$dao = DAO::CreateInstance();
			$dao->SetCurrentSchema($db);
			$sql1="select count(*) from article where subject_id=".$id;
			$article_count=$dao->GetOne($sql1);
			if($article_count>=1)//该栏目下还有文章
			{
				echo "<script>alert('该栏目下还有手发文章');history.go(-1);</script>";
				exit;
			}
			$sql2="select count(*) from rel_article_subject where subject_id=".$id;
			$rssarticle_count=$dao->GetOne($sql2);
			if($rssarticle_count>=1)//该栏目下还有rss文章(包含cms文章)
			{
				echo "<script>alert('该栏目下还有RSS来源文章');history.go(-1);</script>";
				exit;
			}
			$subject->DeleteByID($id);
       		$subject->DeletesubByID($id);
        }
        return "main.php?do=subject_list&channel_name=".$request['channel_name'];        
    }	
}
?>