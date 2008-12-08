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

class ContributeArticleDoTransferAction extends Action {
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
		$feed_id=$_REQUEST['feed_id'];
		$rss_article_num = $_REQUEST['rss_article_num'];
		$rss_article_name = $_REQUEST['rss_article_name'];
		$is_auto = $request['is_auto'];
		$radio_source = $request['source'];
				
		$dao = DAO::CreateInstance();
		
		//整理需转移的文章id,取出其信息
		$dao_rss = DAO::CreateInstanceEmpty();
		if(!$dao_rss->Connect('contribute', 'root', '10y9c2U5', '221.238.254.205'))
			die("connect error");
		$article_id_array = explode( "||",$form['article_id_string'] );
		//从投稿器数据库中查询待转的文章
		$sql = "select * from article where id in (".implode(',',$article_id_array).")";
		$article_arr = $dao_rss->GetPlan( $sql );
		$article_count = count($article_arr);//待转文章条数

		//将文章信息插入到对应不同subject的数据库中
		$subject_id_arr=$form['subject_id'];//subject_id的格式为001002，前面3位是channel_id,后面3位是subject_id
		$subject_count=count($subject_id_arr);//目的栏目，可能有多个
		for( $i=0;$i<$subject_count;$i++)
		{
			$channel_id = intval(substr($subject_id_arr[$i],0,3));
			$subject_id = intval(substr($subject_id_arr[$i],3));
			$channel_info = $this->getInfoFromId( $channel_id );
			$db_name = "cms_" . $channel_info['dir_name'];
			$dao->SetCurrentSchema( $db_name );
					
			$ftp = new FTP($channel_info['dir_name']);
			for( $j=0;$j<$article_count;$j++ )
			{
				$source = "blogmark";
				
				//check if entry_id exists
				$dao->SetCurrentSchema( $db_name );
				$sql = "select * from rss_entry_attach where feed_id=".$feed_id." and source='blogmark' and entry_id=" . $article_arr[$j]['id'];
				$tmp_result = $dao->GetRow( $sql );
				if( $dao->CountAffectedRows() > 0 )//cms里已有这篇文章
				{
					$page = "<html> \n <head> \n <title></title> \n </head> \n <body>";
					$page.= "<script language='javascript'> \n";
					$page.= "location.href='" . $tmp_result['url'] . "' \n";
					$page.=	"</script> \n";
					$page.=	"</body> \n </html> \n";
					$date = date('Y-m-d');
					if(!is_dir(PATH_HTML_ROOT . "/$db_name/feed"))
						mkdir(PATH_HTML_ROOT . "/$db_name/feed");
					if(!is_dir(PATH_HTML_ROOT . "/$db_name/feed/$date"))
						mkdir(PATH_HTML_ROOT . "/$db_name/feed/$date");
					$path = PATH_HTML_ROOT . "/$db_name/feed/$date/" . $tmp_result['id'] . ".shtml";
					$path_remote = "/html/$db_name/feed/$date/" . $tmp_result['id'] . ".shtml";
					$tmp_db_name=('cms_blog'==$db_name)?'cms_blogs':$db_name;
					$url = "http://" . str_replace('cms_','',$tmp_db_name). "." . DOMAIN . "/feed/$date/" . $tmp_result['id'] . ".shtml";
					$fp = fopen($path, 'w');

					fwrite($fp, $page);
					fclose($fp);
					$ftp->Put($path, $path_remote);
					
					//insert into table rel_article_subject
					$tmp_article_title=(''==$rss_article_name)?$tmp_result['title']:$rss_article_name;
					$sql_insert = "insert into rel_article_subject(article_id, subject_id,title,url,datetime,category,source,mark,user_id)"; 
					$sql_insert.= " values('" . $tmp_result['id'] . "',".$subject_id.",'" . $tmp_article_title . "','" . $url ."','" . $tmp_result['datetime'] . "',1,'".$source."'," . $form['radio_mark'] . "," . $user['id'] . ")";
					
					if(!$dao->Insert( $sql_insert ))
					{
						Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 $sql_insert 出错。");
					}
				}
				else//cms里还没有这篇文章
				{
					$sql0="select blogname from author where id=".$article_arr[$j]['author_id'];
					$author_blogname=conv($dao_rss->GetOne($sql0));
					$tmp_article_title=(''==$rss_article_name)?conv($article_arr[$j]['title']):$rss_article_name;
					
					//insert into table rss_entry_attach
					$dao->SetCurrentSchema( $db_name );
					$sql_insert = "insert into rss_entry_attach(title,url,datetime,feed_id,entry_id,source,author,commentnum) ";
					$sql_insert.= "values('" . $tmp_article_title . "','" . $article_arr[$j]['url'] .  "','" . date("Y-m-d H:i:s",$article_arr[$j]['addtime']) . "',";
					$sql_insert.= "'" . $feed_id . "','" .$article_arr[$j]['id'] ."','".$source."','" . $author_blogname . "'," . $article_arr[$j]['vote'] . ")";
					
					if( $dao->Insert( $sql_insert ) )
					{
						$LastID = $dao->LastID();
			
						$page = "<html> \n <head> \n <title></title> \n </head> \n <body>";
						$page.= "<script language='javascript'> \n";
						$page.= "location.href='" . $article_arr[$j]['url'] . "' \n";
						$page.=	"</script> \n";
						$page.=	"</body> \n </html> \n";
						$date = date('Y-m-d');
						if(!is_dir(PATH_HTML_ROOT . "/$db_name/feed"))
							mkdir(PATH_HTML_ROOT . "/$db_name/feed");
						if(!is_dir(PATH_HTML_ROOT . "/$db_name/feed/$date"))
							mkdir(PATH_HTML_ROOT . "/$db_name/feed/$date");
						$path = PATH_HTML_ROOT . "/$db_name/feed/$date/" . $LastID . ".shtml";
						$path_remote = "/html/$db_name/feed/$date/" . $LastID . ".shtml";
						
						$tmp_db_name=('cms_blog'==$db_name)?'cms_blogs':$db_name;
						$url = "http://" . str_replace('cms_','',$tmp_db_name). "." . DOMAIN . "/feed/$date/" . $LastID . ".shtml";
						
						$fp = fopen($path, 'w');
	
						fwrite($fp, $page);
						fclose($fp);
						$ftp->Put($path, $path_remote);
					
						//insert into table rel_article_subject
						$sql_insert = "insert into rel_article_subject(article_id, subject_id,title,url,datetime,category,source,mark,user_id)"; 
						$sql_insert.= " values(" . $LastID . ",".$subject_id.",'" . $tmp_article_title . "','" . $url ."','" . date("Y-m-d H:i:s",$article_arr[$j]['addtime']) . "',1,'".$source."'," . $form['radio_mark'] . "," . $user['id'] . ")";
				
						if(!$dao->Insert( $sql_insert ))
						{
							Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 $sql_insert 出错。");
						}
					}
				}
				//insert into table cms_entry
				$dao->SetCurrentSchema( 'cms' );
				$entry_insert = "insert into cms_entry(entry_id, mark, channel_name, subject_id, user_id, selected_time)".
						" values('".$article_arr[$j]['id']."', '".$form['radio_mark']."', '".$channel_info['dir_name']."', '".$subject_id."', '".$user['id']."', '".time()."')";
				if(!$dao->Insert( $entry_insert ))
				{
					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 $entry_insert 出错。");
				}
			}
			$ftp->Close();
		} 
		

		$db = $dao->SetCurrentSchema( 'cms' );
		$sql = "update user set rss_article_num = rss_article_num + ".$article_count." where id = ".$user_id."";
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
function conv($str)
{
	return mb_convert_encoding($str,"utf-8","utf-8,gbk,gb2312");
}
?>
