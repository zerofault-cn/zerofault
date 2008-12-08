<?php
/**
* RSSArticleTransferAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Article.cls.php');
require_once('com/Log.cls.php');
require_once('com/FTP.cls.php');

class RSSArticleDoTransferAction extends Action {
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
		
		//接收变量
		$is_auto = $request['is_auto'];
		$radio_source = $request['source'];

		$dao = DAO::CreateInstance();
		
		
		//整理需转移的文章id,取出其信息
		$rss_id_array = explode( "||",$form['rss_string'] );
		$rss_ids = "(";
		foreach( $rss_id_array AS $tmp_rss_id )
			$rss_ids .= $tmp_rss_id . ",";
		$rss_ids = substr( $rss_ids,0,-1 ) . ")";
		$dao->SetCurrentSchema( 'cms' );
		$sql_select = "select id,url,title,source,pub_date from rss_article where id in $rss_ids";
		$res = $dao->GetPlan( $sql_select );
		
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
				//静态化选中的文章为跳转页
				$page = "<html> \n <head> \n <title></title> \n </head> \n <body>";
				$page.= "<script language='javascript'> \n";
				$page.= "location.href='" . $res[$j]['url'] . "' \n";
				$page.=	"</script> \n";
				$page.=	"</body> \n </html> \n";
				$date = date('Y-m-d');
				if(!is_dir(PATH_HTML_ROOT . "/$db_name/rss"))
					mkdir(PATH_HTML_ROOT . "/$db_name/rss");
				if(!is_dir(PATH_HTML_ROOT . "/$db_name/rss/$date"))
					mkdir(PATH_HTML_ROOT . "/$db_name/rss/$date");
				$path = PATH_HTML_ROOT . "/$db_name/rss/$date/" . $res[$j]['id'] . ".shtml";
				$path_remote = "/html/$db_name/rss/$date/" . $res[$j]['id'] . ".shtml";
				
				if($channel_info['dir_name'] == 'blog')
					$url = "http://" . $channel_info['dir_name'] . "s." . DOMAIN . "/rss/$date/" . $res[$j]['id'] . ".shtml";
				else 
					$url = "http://" . $channel_info['dir_name'] . "." . DOMAIN . "/rss/$date/" . $res[$j]['id'] . ".shtml";
				
				$fp = fopen($path, 'w');
				fwrite($fp, $page);
				fclose($fp);
				
				$ftp->Put($path, $path_remote);
				
				//根据是否手动判断source
				if( 0 == $is_auto )
				{
					 $source = $radio_source;
				}
				else
				{
					$source = $res[$j]['source'];
				}

				$sql_insert = "insert into rel_article_subject(article_id, subject_id,title,url,datetime,category,source,mark,user_id)"; 
				$sql_insert.= " values(" . $res[$j]['id'] . ",'$subject_id','" . $res[$j]['title'] . "','" . $res[$j]['url'] ."','" . $res[$j]['pub_date'] . "',2,'" . $source . "'," . $form['radio_mark'] . "," . $user['id'] . ")";
				if(!$dao->Insert( $sql_insert ))
				{
					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 $sql_insert 出错。");
				}
				
			}
			$ftp->Close();
		}
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
