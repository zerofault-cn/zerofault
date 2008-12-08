<?php
/**
 * ArticleDoAddAction.cls.php
 * @copyright bokee dot com
 * @author yudunde@bokee.com
 * @version 0.1
 */

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('mod/User.cls.php');
require_once('mod/Subject.cls.php');

class ArticleDoAddAction extends Action {
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
		//$db_cms = "cms";
		
		$subject_string = $request['subject_string'];
		
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
				$rows_coop_media_num = count($rows_coop_media);
				for($i=0;$i<$rows_coop_media_num;$i++)
				{
					$id_array = split('_', $form['select_coop_media']);
					if($rows_coop_media[$i]['id'] == $id_array[0])
					{
						$rows_coop_media[$i]['selected'] = "selected";
					}
				}
			}
			$response['coop_media'] = $rows_coop_media;
			
			$response['channel_name'] = $channel_name;
			$subject = new Subject($db);
			$response['data']['subject_options'] = $subject->GetSubjectSelectedOptions(0, "", $form['subject_id']);
			
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
			
			//设置mark
			$mark = array();
			for($i=0;$i<5;$i++)
			{
				$mark[$i]['value'] = $i+1;
				if($mark[$i]['value'] == $form['radio_mark'])
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
			if($form['radio_is_comment'] == 1)
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
			if($form['radio_is_ad'] == 1)
				$ad[0]['checked'] = "checked";
			else 
				$ad[1]['checked'] = "checked";
			$response['ad'] = $ad;
			
			//设置跳转选项
			$jump = array();
			$jump[0]['value'] = 1;
			$jump[0]['name'] = "是";
			$jump[1]['value'] = 0;
			$jump[1]['name'] = "否";
			if($form['radio_is_jump'] == 1)
				$jump[0]['checked'] = "checked";
			else 
				$jump[1]['checked'] = "checked";
			$response['jump'] = $jump;

			$response['form'] = $form;

			return $actionMap->findForward('failure');
		}

		//添加文章处理
		$article = new Article($db);
		$images_text[] = $form['text_image1'];
		$images_text[] = $form['text_image2'];
		$images_text[] = $form['text_image3'];
		$images_text[] = $form['text_image4'];
		$images_text[] = $form['text_image5'];
		$images_text[] = $form['text_image6'];
		$article->SetFiles($_FILES);
		$article->SetGroupImageDesc($form['group_image_desc']);
		$article->SetImagesText($images_text);
		$article->SetTitle($form['title']);
		$article->SetSubTitle($form['sub_title']);
		$article->SetAuthor($form['author']);
	    $article->Setplush_time($form['plush_time']);
		if(!empty($form['select_coop_media']))
		{
			$coop_media = split('_', $form['select_coop_media']);
			$coop_media_id = $coop_media[0];
			$coop_media_name = $coop_media[1];
			if($coop_media_id != 0)
			{
				$article->SetCoopMediaId($coop_media_id);
			}
			$article->SetMediaName($coop_media_name);
		}
		else if (!empty($form['text_coop_media']))
		{
			$coop_media_name = $form['text_coop_media'];
			$article->SetMediaName($coop_media_name);
		}        

		$article->SetSubjectId($form['subject_id']);
		if(!empty($form['radio_mark']))
			$article->SetMark($form['radio_mark']);
		$article->SetKeyword($form['keyword']);
		$description = $this->h_substr($form['description'], 150);
		$article->SetDescription($description);
		
		$enable_ad = ($form['radio_is_ad']==1)?true:false;
		$content = $form['content'];

		
		/* 原广告头尾代码
		$content_pre = str_replace("　", "", $form['content']);
		$content_arr = split("\r\n", $content_pre);
		$content_arr_length = count($content_arr);
		$content = "";
		$c = 0;
		for($i=0;$i<$content_arr_length;$i++)
		{
			if(strlen($content_arr[$i])>1)
			{
				$content .= "<p style=\"TEXT-INDENT: 2em\">" . $content_arr[$i] . "</p>\n";
				$c++;
			
				if($c == 1 && $enable_ad)
				{
					$content .= '<table align="left"><tr><td><!--Adforward Begin:--><!--体育内页 - 360*300 画中画--><IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee&border=0&local=yes"><SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee&local=yes&js=on"></SCRIPT><NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME><!--Adforward End--></td></tr></table>' . "\n";
				}
			}
		}
		$keywords = split(" ", $form['keyword']);
		$keywords_num = count($keywords);
		$tag = "<p style=\"TEXT-INDENT: 2em\">Tag: ";
		for($i=0;$i<$keywords_num;$i++)
		{
			$tag .= " <a href=http://tag.bokee.com/tag/" . urlencode(mb_convert_encoding($keywords[$i], 'GBK', 'UTF-8')) . ">" . $keywords[$i] . "</a> ";
		}
		$tag .="</p>\n";
		$content .= $tag;
		*/


		$article->SetContent($content);
		$special_id = intval($form['select_special']);
		$article->SetSpecialId($special_id);
		$special_subject_id = intval(substr($form['select_special_subject'], 3, 3));
		$article->SetSpecialSubjectId($special_subject_id);
		$enable_comment = ($form['radio_is_comment']==1)?true:false;
		
		$article->SetEnableComment($enable_comment);
		$article->SetEnableAd($enable_ad);
		$article->SetUserId($_SESSION['user']['id']);
		
		//如果是跳转页面，则设定跳转url
		if( 1 == $form['radio_is_jump'] ){
			$article->SetRssURL( $form['text_jump_url'] );
		}

		//如果设置组信息
		if( 1 == $form['radio_is_group'] )
		{
			$article->SetGroupID( $form['select_group_id'] );
		}
		$article->SetAutoRedirect( $form['is_auto_redirect'] );
		$view_num=$_REQUEST['view_num'];
		$article->SetViewNum( $view_num );
		$id = $article->Save();
		if ( $id>0 )
		{
			//添加到其他栏目开始
			if( !empty( $subject_string ) )
			{
				$dao = DAO::CreateInstance();
				$dao->SetCurrentSchema($db);
				//获取当前article的ID
				$sql = "select id,title,remote_url,mark from article where id=$id";
				$article_info = $dao->GetRow( $sql );
				
				//插入到rel_article_subject数据表中
				$sql_begin = "insert into rel_article_subject(article_id,title,url,category,source,mark,datetime,subject_id) ";
				$sql_begin.=" values('" . $article_info['id'] . "','" . $article_info['title'] . "','" . $article_info['remote_url'] ."',0,'cms'," . $article_info['mark'] . ",now(),";
				if( !empty( $subject_string ) )
				{
					$subject_array = explode( "||",$subject_string );
				}
				if( is_array( $subject_array ) )
				{
					foreach( $subject_array as $tmp_subject_id )
					{
						$sql = $sql_begin . "'$tmp_subject_id')";
						$dao->insert( $sql );
					}
				}
				else
				{
					if( !empty( $subject_string ) )
					{
						$sql = $sql_begin . "'$subject_string')";
						$dao->insert( $sql );
					}
				}
			}
			//添加到其他栏目结束
			if($channel_name=='group')
			{
				return "main.php?do=article_list_for_group&channel_name=".$request['channel_name']."&subject_id=".$request['subject_id'];
			}
			else
			{
				return "main.php?do=article_list&channel_name=".$request['channel_name']."&subject_id=".$request['subject_id'];
			}
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 保存并发布文章 出错。");
			return $actionMap->findForward('sysError');
		}
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
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 " . $a);
			return $a;
		}
	}
}
?>
