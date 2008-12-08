<?php
/**
 * ArticleModifyAction.cls.php
 * @copyright bokee dot com
 * @author yudunde@bokee.com
 * @version 0.1
 */

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/Subject.cls.php');

class ArticleModifyAction extends Action {
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
		
		$id = intval($request['id']);
		$channel_name = $request['channel_name'];
		$db = "cms_" . $channel_name;
		
		
		$article = new Article($db);
		$article->GetByID($id);
		$row = array();
		$row['channel_name'] = $channel_name;
		$subject_id = $article->GetSubjectId();
		$subject = new Subject($db);
		$row['subject_options'] = $subject->GetSubjectSelectedOptions(0, "", $subject_id);
		$row['id'] = $article->GetId();
		$row['title'] = $article->GetTitle();
		$row['title_num'] = ceil(strlen($row['title'])/3);
		$row['sub_title'] = $article->GetSubTitle();
		$row['author'] = $article->GetAuthor();
		$row['keyword'] = $article->GetKeyword();
		$row['description'] = $article->GetDescription();
		$row['view_num'] = $article->GetViewNum();
		$row['rss_url'] = $article->GetRssURL();
		$content = $article->GetContent();

		$row['content'] = $this->filter($content);
		
		$response['article'] = $row;

		//获取合作媒体
		$dao = DAO::CreateInstance();
		
		$sql = "select * from coop_media";
		$rows_coop_media = $dao->GetPlan($sql);
		$coop_media_id = $article->GetCoopMediaId();
		if(!empty($coop_media_id))
		{
			$rows_coop_media_num = count($rows_coop_media);
			for($i=0;$i<$rows_coop_media_num;$i++)
			{
				if($rows_coop_media[$i]['id'] == $coop_media_id)
				{
					$rows_coop_media[$i]['selected'] = "selected";
				}
			}
		}
		$response['coop_media'] = $rows_coop_media;

		//获取专题
		$dao->SetCurrentSchema($db);
		$sql = "select * from special order by id desc limit 50";
		$rows_special = $dao->GetPlan($sql);
		
		$special_id = $article->GetSpecialId();
		$special_subject_id = $article->GetSpecialSubjectId();
		if(!empty($special_id))
			{
				$rows_special_num = count($rows_special);
				for($i=0;$i<$rows_special_num;$i++)
				{
					if($rows_special[$i]['id'] == $special_id)
					{
						$rows_special[$i]['selected'] = "selected";
						$script .= "load_special_subject(" . $special_id . ");";
						if(!empty($special_subject_id))
						{
							$script .= "prepare_special_subject(" . $special_subject_id . ");";
						}
					}
				}
			}
		$response['special'] = $rows_special;	
		$response['script'] = $script;

		//获取专题栏目
		$rows_special_subject = array();
		$rows_special_subject_last = array();
		$rows_special_num = count($rows_special);
		for($i=0;$i<$rows_special_num;$i++)
		{
			$sql = "select * from special_subject where special_id=" . $rows_special[$i]['id'];
			$rows = $dao->GetPlan($sql);
			$rows_num = count($rows);
			for($j=0;$j<$rows_num;$j++)
			{
				if($i<$rows_special_num-1 || $j<$rows_num-1)
				{
					$rows[$j]['id'] = $this->getNumberStr($rows_special[$i]['id']) . $this->getNumberStr($rows[$j]['id']);
					$rows_special_subject[] = $rows[$j];
				}
				else
				{
					$rows[$j]['id'] = $this->getNumberStr($rows_special[$i]['id']) . $this->getNumberStr($rows[$j]['id']);
					$rows_special_subject_last[] = $rows[$j];
				}
			}		
		}
		$response['special_subject'] = $rows_special_subject;
		$response['special_subject_last'] = $rows_special_subject_last;

		//设置跳转URL选项
		$is_url = $article->GetIsRss();
		if($is_url)
			$response['jump_value'] = "1";
		else 
			$response['jump_value'] = "0";
		
		//设置mark
		$mark = array();
		for($i=0;$i<5;$i++)
		{
			$mark[$i]['value'] = $i+1;
			if($mark[$i]['value'] == $article->GetMark())
			{
				$mark[$i]['checked'] = "checked";
			}
		}
		$response['mark'] = $mark;
		
		//设置评论选项
		$comment = array();
		$comment[0]['value'] = 1;
		$comment[0]['name'] = "是";
		$comment[1]['value'] = 0;
		$comment[1]['name'] = "否";
		if($article->GetEnableComment())
			$comment[0]['checked'] = "checked";
		else 
			$comment[1]['checked'] = "checked";
		$response['comment'] = $comment;
		
		//设置广告选项
		$ad = array();
		$ad[0]['value'] = 1;
		$ad[0]['name'] = "是";
		$ad[1]['value'] = 0;
		$ad[1]['name'] = "否";
		if($article->GetEnableAd())
			$ad[0]['checked'] = "checked";
		else 
			$ad[1]['checked'] = "checked";
		$response['ad'] = $ad;
		$response['data']['rel_blog_content'] = $article->GetRelBlogContent();
		$response['data']['rel_cms_content'] = $article->GetRelCMSContent();
		$response['data']['rel_rss_content'] = $article->GetRelRSSContent();



		//设置组选项
		$group_id = $article->GetGroupID();
		if( $group_id )
		{
			$response['group_checked'] = "checked";
		}
		else
		{
			$response['group_not_checked'] = "checked";
			$response['is_group_disabled'] = "disabled='true'";
		}
		$sql = "select id, name from article_group where subject_id=" . $subject_id;
		$row = $dao->GetPlan( $sql );
		for( $i=0;$i<count($row);$i++ )
		{
			$tmp_row[$i]['id'] = $row[$i]['id'];
			$tmp_row[$i]['name'] = $row[$i]['name'];
			if( $group_id == $row[$i]['id'] )
				$tmp_row[$i]['selected'] = "selected";
		}
		$response['group_list'] = $tmp_row;

		//设置自动翻页
		$auto_redirect = $article->GetAutoRedirect();
		if( $auto_redirect )
		{
			$html_auto_redirect = "<input type='radio' name='is_auto_redirect' value='1' checked>是";	
			$html_auto_redirect .= "<input type='radio' name='is_auto_redirect' value='0'>否";	
		}
		else
		{
			$html_auto_redirect = "<input type='radio' name='is_auto_redirect' value='1'>是";	
			$html_auto_redirect .= "<input type='radio' name='is_auto_redirect' value='0' checked>否";	
		}
		$response['html_auto_redirect'] = $html_auto_redirect;
	}

	/**
	 * @access private
	 * @param int $number
	 * @return stirng $string
	 */
	function getNumberStr($number)
	{
		$number = intval($number);
		if($number<10)
			return "00" . $number;
		if($number<100)
			return "0" . $number;
		return $number;
	}
	
	/**
	* @abstract 过滤文章中的段落格式
	* @access private
	*/
	function filter($str)
	{
        $patterns[0] = "/<p style=\"TEXT-INDENT: 2em\">/";
        $patterns[1] = "/<\/p>/";
        $replacements[0] = "";
        $replacements[1] = "";
        $astr = preg_replace($patterns, $replacements, $str);
        return $astr;
	}

}
?>
