<?php
/**
* RSSArticleDoAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');

class RSSArticleDoAddAction extends Action {
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
		$xml = stripslashes($form['xml']);

		$parser = xml_parser_create('UTF-8');
		xml_parse_into_struct($parser, $xml, $vals, $index);
		xml_parser_free($parser);
		$title = $vals[$index['TITLE'][0]]['value'];
		$url = $vals[$index['LINK'][0]]['value'];
		$pub_date = $vals[$index['DATETIME'][0]]['value'];
		$feed_title = $vals[$index['FEEDTITLE'][0]]['value'];
		$feed_url = $vals[$index['FEEDLINK'][0]]['value'];
		
		//根据url判断来源
		$source = "rss";
		$match_blogmark = "/blogmark\.bokee\.com/i";
		$match_blogmark_bc = "/blogmark\.blogchina\.com/i";
		$match_blog = "/bokee\.com\/\d+\.html/i";
		$match_blog_bc = "/blogchina\.com\/\d+\.html/i";
		$match_cms = "/bokee\.com/i";
		$match_cms_bc = "/blogchina\.com/i";
		$match_bbs = "/bbs\.bokee\.com/i";
		$match_bbs_bc = "/bbs\.blogchina\.com/i";
		$match_column = "/column\.bokee\.com/i";
		$match_column_bc = "/column\.blogchina\.com/i";
		$match_column_bco = "/www\.blogchina\.com\/new\/display/i";
		
		if(preg_match($match_cms, $url) || preg_match($match_cms_bc, $url))
			$source = "cms";
		if(preg_match($match_bbs, $url) || preg_match($match_bbs_bc, $url))
			$source = "bbs";		
		if(preg_match($match_blogmark, $url) || preg_match($match_blogmark_bc, $url))
			$source = "blogmark";
		if(preg_match($match_blog, $url) || preg_match($match_blog_bc, $url))
			$source = "blog";
		if(preg_match($match_column, $url) || preg_match($match_column_bc, $url) || preg_match($match_column_bco, $url))
			$source = "column";
		
					
		$dao = DAO::CreateInstance();
		$sql = "insert into rss_article set 
				title='$title',
				url='$url',
				pub_date='$pub_date',
				feed_title='$feed_title',
				feed_url='$feed_url',
				source='$source'
				";
		if($dao->Query($sql))
			echo "ok";
		else 
			echo "failure";
		exit;
	}
}
?>