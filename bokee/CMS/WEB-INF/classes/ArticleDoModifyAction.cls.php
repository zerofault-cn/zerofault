<?php
/**
 * ArticleDoModifyAction.cls.php
 * @copyright bokee dot com
 * @author yudunde@bokee.com
 * @version 0.1
 */

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/User.cls.php');
require_once('mod/Subject.cls.php');

class ArticleDoModifyAction extends Action {
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

		$channel_name = $form['channel_name'];
		$db = "cms_" . $channel_name;
		// 对先前的错误进行处理
		if ( !$actionError->isEmpty() ){
			// 是系统错误吗？
			if ($actionError->getProp('sysError') != false){
				return $actionMap->findForward('sysError');
			}

			//获取合作媒体
			$dao = DAO::CreateInstance();
			$sql = "select * from coop_media";
			$rows_coop_media = $dao->GetPlan($sql);
			if(!empty($form['select_coop_media']))
			{
				// 可能有多个合作媒体。

				$rows_coop_media_num = count($rows_coop_media);

				// 遍历并添加他们

				for($i=0;$i<$rows_coop_media_num;$i++)
				{
					$id_array = split('_', $form['select_coop_media']);
					if($rows_coop_media[$i]['id'] == $id_array[0])
					{
						$rows_coop_media[$i]['selected'] = "selected";
					}
				}
			}
			// 返回合作媒体数组。
			$response['coop_media'] = $rows_coop_media;
			$response['channel_name'] = $channel_name;
			$subject = new Subject($db);
			$response['data']['subject_options'] = $subject->GetSubjectSelectedOptions(0, "", $request['subject_id']);

			$dao->SetCurrentSchema($db);
			//获取专题
			$sql = "select * from special order by id desc limit 50";
			$rows_special = $dao->GetPlan($sql);

			if(!empty($form['select_special']))
			{
				$rows_special_num = count($rows_special);
				for($i=0;$i<$rows_special_num;$i++)
				{
					if($rows_special[$i]['id'] == $form['select_special'])
					{
						$rows_special[$i]['selected'] = "selected";
						$script .= "load_special_subject(" . $form['select_special'] . ");";
						if(!empty($form['select_special_subject']))
						{
							$script .= "prepare_special_subject('" . $form['select_special_subject'] . "');";
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

			$response['form'] = $form;

			return $actionMap->findForward('failure');
		}

		//修改文章处理

		//init 
		$article = new Article($db);
		$id = intval($form['id']);
		$article->GetByID($id);
		$article->SetFiles($_FILES);
		$article->SetTitle($form['title']);
		$article->SetSubTitle($form['sub_title']);
		$article->SetAuthor($form['author']);
		$article->SetSubjectId($form['subject_id']);

		if(!empty($form['select_coop_media']))
		{
			$coop_media = split('_', $form['select_coop_media']);
			$coop_media_id = $coop_media[0];
			$coop_media_name = $coop_media[1];
			$article->SetCoopMediaId($coop_media_id);
			$article->SetMediaName($coop_media_name);
		}
		else if (!empty($form['text_coop_media']))
		{
			$coop_media_name = $form['text_coop_media'];
			$article->SetMediaName($coop_media_name);
		}        

		$article->SetMark($form['radio_mark']);
		$article->SetKeyword($form['keyword']);
		$description = $this->h_substr($form['description'], 250);
		$article->SetDescription($description);
		if(''!=$form['rss_url'])
		{
			$article->SetRssURL($form['rss_url']);
		}
		if(''!=$form['view_num'])
		{
			$article->SetViewNum($form['view_num']);
		}
		$enable_ad = ($form['radio_is_ad']==1)?true:false;
		$content_arr = split("\r\n", $form['content']);
		$content_arr_length = count($content_arr);
		$content = "";
		for($i=0;$i<$content_arr_length;$i++)
		{
			if(strlen($content_arr[$i])>1)
			{
				$content .= "<p style=\"TEXT-INDENT: 2em\">" . $content_arr[$i] . "</p>\n";
			}
		}
		
		$article->SetContent($content);
		if(''!=$form['rel_blog_content'])
		{
			$article->SetRelBlogContent($form['rel_blog_content']);
		}
		if(''!=$form['rel_cms_content'])
		{
			$article->SetRelCMSContent($form['rel_cms_content']);
		}
		if(''!=$form['rel_rss_content'])
		{
			$article->SetRelRSSContent($form['rel_rss_content']);
		}
		$special_id = intval($form['select_special']);
		$article->SetSpecialId($special_id);
		$special_subject_id = intval(substr($form['select_special_subject'], 3, 3));
		$article->SetSpecialSubjectId($special_subject_id);
		$article->SetEnableAd($enable_ad);

		//修改是否组文章
		if( $form['radio_is_group'] )
		{
			$article->SetGroupID( $form['select_group_id'] );
		}
		else
		{
			$article->SetGroupID( 0 );
		}
		if(''!=$form['is_auto_redirect'])
		{
			$article->SetAutoRedirect( $form['is_auto_redirect'] );
		}
		// update
		if ( $article->Modify() )
		{
			return "main.php?do=article_list&channel_name=".$form['channel_name']."&subject_id=".$form['subject_id'];
		}
		else 
			return $actionMap->findForward('sysError');
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
	
	function h_substr($str,$len)
	{
		if(func_num_args() <= 1) 
			return $str;
		elseif(func_num_args() == 2)
		{
			$str = mb_convert_encoding( $str ,"GBK","UTF-8");
			preg_match_all("/[\x80-\xff]?./",$str,$ar);
			$counter=0;
			$flag=0;
			while($counter<$len&&$flag<count($ar[0]))
        	{
               	if(strlen($ar[0][$flag])==1)
                   	$counter+=1;
                elseif(strlen($ar[0][$flag])==2)
                   	$counter+=2;
                //the following lines should not be executed.
                else
                   	$counter+=1;
                $flag++;
           	}
			
			$a = mb_convert_encoding( join("",array_slice($ar[0],0,$flag))."" ,"UTF-8",'GBK' ) ;
			return $a;
		}
	}
}
?>
