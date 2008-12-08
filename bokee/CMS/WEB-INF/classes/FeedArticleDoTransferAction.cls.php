<?php
/**
* FeedArticleDoTransferAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('com/Log.cls.php');
require_once('com/FTP.cls.php');

class FeedArticleDoTransferAction extends Action {
	/**
	 * 
	 * @access public
	 * @param array &$request
	 * @param array &$files
	 */
	function execute(&$actionMap,&$actionError,$request,&$response,$form){
		
		//权限验证开始
		session_start();
		$user = $_SESSION['user'];
		$user_id = $user['id'];
		//接收变量
		$rss_article_num = $_REQUEST['rss_article_num'];
		$rss_article_name = $_REQUEST['rss_article_name'];
		$is_auto = $request['is_auto'];
		$radio_source = $request['source'];
				
		$dao = DAO::CreateInstance();
		
		//整理需转移的文章id,取出其信息
		$dao_rss = DAO::CreateInstanceEmpty();
		if(!$dao_rss->Connect('rss', 'root', '10y9c2U5', '211.152.20.27'))
			die("connect error");
		$feed_id_array = explode( "||",$form['feed_string'] );
		$feed_ids = "(";
		foreach( $feed_id_array AS $tmp_feed_id )
			$feed_ids .= $tmp_feed_id . ",";
		$feed_ids = substr( $feed_ids,0,-1 ) . ")";
		$sql_select = "select * from entry where id in $feed_ids";
		$res = $dao_rss->GetPlan( $sql_select );
		$num_res = count($res);

		//将文章信息插入到对应不同subject的数据库中
		for( $i=0;$i<count($form['subject']);$i++)
		{
			$tmp_subject = explode( "||",$form['subject'][$i] );
			$channel_id = $tmp_subject[0];
				
			$subject_id = $tmp_subject[1];
			$channel_info = $this->getInfoFromId( $channel_id );
			$db_name = "cms_" . $channel_info['dir_name'];
			$dao->SetCurrentSchema( $db_name );
			
			
					
			$ftp = new FTP($channel_info['dir_name']);
			for( $j=0;$j<count($res);$j++ )
			{
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
				
				if(preg_match($match_cms, $res[$j]['url']) || preg_match($match_cms_bc, $res[$j]['url']))
					$source = "cms";
				if(preg_match($match_bbs, $res[$j]['url']) || preg_match($match_bbs_bc, $res[$j]['url']))
					$source = "bbs";
				if(preg_match($match_blogmark, $res[$j]['url']) || preg_match($match_blogmark_bc, $res[$j]['url']))
					$source = "blogmark";
				if(preg_match($match_blog, $res[$j]['url']) || preg_match($match_blog_bc, $res[$j]['url']))
					$source = "blog";
				if(preg_match($match_column, $res[$j]['url']) || preg_match($match_column_bc, $res[$j]['url']) || preg_match($match_column_bco, $res[$j]['url']))
					$source = "column";
					
				//根据是否手动判断source
				if( 0 == $is_auto )
				{
					 $source = $radio_source;
				}
			
				//check if entry_id exists
				$dao->SetCurrentSchema( $db_name );
				$sql_select = "select * from rss_entry_attach where entry_id=" . $res[$j]['id'];
				$tmp_res = $dao->GetRow( $sql_select );
				if( $dao->CountAffectedRows() > 0 )
				{
					$page = "<html> \n <head> \n <title></title> \n </head> \n <body>";
					$page.= "<script language='javascript'> \n";
					$page.= "location.href='" . $tmp_res['url'] . "' \n";
					$page.=	"</script> \n";
					$page.=	"</body> \n </html> \n";
					$date = date('Y-m-d');
					if(!is_dir(PATH_HTML_ROOT . "/$db_name/feed"))
						mkdir(PATH_HTML_ROOT . "/$db_name/feed");
					if(!is_dir(PATH_HTML_ROOT . "/$db_name/feed/$date"))
						mkdir(PATH_HTML_ROOT . "/$db_name/feed/$date");
					$path = PATH_HTML_ROOT . "/$db_name/feed/$date/" . $tmp_res['id'] . ".shtml";
					$path_remote = "/html/$db_name/feed/$date/" . $tmp_res['id'] . ".shtml";
					if($channel_info['dir_name'] == 'blog')
						$url = "http://" . $channel_info['dir_name'] . "s." . DOMAIN . "/feed/$date/" . $tmp_res['id'] . ".shtml";
					else 
						$url = "http://" . $channel_info['dir_name'] . "." . DOMAIN . "/feed/$date/" . $tmp_res['id'] . ".shtml";
					$fp = fopen($path, 'w');

					fwrite($fp, $page);
					fclose($fp);
					$ftp->Put($path, $path_remote);
					
					//insert into table rel_article_subject
					switch ($rss_article_num){
						case "":
						$sql_insert = "insert into rel_article_subject(article_id, subject_id,title,url,datetime,category,source,mark,user_id)"; 
						$sql_insert.= " values('" . $tmp_res['id'] . "',".$subject_id.",'" . $tmp_res['title'] . "','" . $tmp_res['url'] ."','" . $tmp_res['datetime'] . "',1,'$source'," . $form['radio_mark'] . "," . $user['id'] . ")";
						break;

						case "1":
						$sql_insert = "insert into rel_article_subject(article_id, subject_id,title,url,datetime,category,source,mark,user_id)"; 
						$sql_insert.= " values('" . $tmp_res['id'] . "',".$subject_id.",'" . $rss_article_name . "','" . $url ."','" . $tmp_res['datetime'] . "',1,'$source'," . $form['radio_mark'] . "," . $user['id'] . ")";
						break;
					}

					if(!$dao->Insert( $sql_insert ))
					{
						Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 $sql_insert 出错。");
					}
				}
				else
				{
					//insert into table rss_entry_attach
					$dao->SetCurrentSchema( $db_name );
					$sql_insert = "insert into rss_entry_attach(title,url,datetime,feed_id,entry_id,source,author,commentnum) ";
					$sql_insert.= "values('" . $res[$j]['title'] . "','" . $res[$j]['url'] .  "','" . $res[$j]['date_time'] . "',";
					$sql_insert.= "'" . $res[$j]['feed_id'] . "','" .$res[$j]['id'] ."','$source','" . $res[$j]['author'] . "'," . $res[$j]['commentnum'] . ")";
					
					if( $dao->Insert( $sql_insert ) )
					{
						$LastID = $dao->LastID();
			
						$page = "<html> \n <head> \n <title></title> \n </head> \n <body>";
						$page.= "<script language='javascript'> \n";
						$page.= "location.href='" . $res[$j]['url'] . "' \n";
						$page.=	"</script> \n";
						$page.=	"</body> \n </html> \n";
						$date = date('Y-m-d');
						if(!is_dir(PATH_HTML_ROOT . "/$db_name/feed"))
							mkdir(PATH_HTML_ROOT . "/$db_name/feed");
						if(!is_dir(PATH_HTML_ROOT . "/$db_name/feed/$date"))
							mkdir(PATH_HTML_ROOT . "/$db_name/feed/$date");
						$path = PATH_HTML_ROOT . "/$db_name/feed/$date/" . $LastID . ".shtml";
						$path_remote = "/html/$db_name/feed/$date/" . $LastID . ".shtml";
						
						if($channel_info['dir_name'] == 'blog')
						$url = "http://" . $channel_info['dir_name'] . "s." . DOMAIN . "/feed/$date/" . $LastID . ".shtml";
						else 
						$url = "http://" . $channel_info['dir_name'] . "." . DOMAIN . "/feed/$date/" . $LastID . ".shtml";
						
						$fp = fopen($path, 'w');
	
						fwrite($fp, $page);
						fclose($fp);
						$ftp->Put($path, $path_remote);
					
						//insert into table rel_article_subject
						if($rss_article_num == 1)
						{
						            $up_title = $rss_article_name;
						}
						else 
						{
						            $up_title = $res[$j]['title'];
						}
						$sql_insert = "insert into rel_article_subject(article_id, subject_id,title,url,datetime,category,source,mark,user_id)"; 
						$sql_insert.= " values(" . $LastID . ",".$subject_id.",'" . $up_title . "','" . $res[$j]['url'] ."','" . $res[$j]['date_time'] . "',1,'$source'," . $form['radio_mark'] . "," . $user['id'] . ")";
				
						if(!$dao->Insert( $sql_insert ))
						{
							Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 $sql_insert 出错。");
						}
					}
				}
				//insert into table cms_entry
				$dao->SetCurrentSchema( 'cms' );
				$entry_insert = "insert into cms_entry(entry_id, mark, channel_name, subject_id, user_id, selected_time)".
						" values('".$res[$j]['id']."', '".$form['radio_mark']."', '".$channel_info['dir_name']."', '".$subject_id."', '".$user['id']."', '".time()."')";
				if(!$dao->Insert( $entry_insert ))
				{
					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 $entry_insert 出错。");
				}
			}
			$ftp->Close();
		} 
		

		$db = $dao->SetCurrentSchema( 'cms' );
		$sql = "update user set rss_article_num = rss_article_num + ".$num_res." where id = ".$user_id."";
		$rest = $dao->Update($sql);

		$js_str = "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
		$js_str.= "<script language='javascript'>";
		$js_str.= "alert('succeed!');";
		$js_str.= "window.opener.location.reload();";
		$js_str.= "self.close()";
		$js_str.= "</script>";
		echo $js_str;


 	}	
 	
 	function getInfoFromId( $Id ){
		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema( "cms" );
		$sql = "select name,dir_name from channel where id='$Id'";
		return $dao->GetRow( $sql );
 	}
}
?>
