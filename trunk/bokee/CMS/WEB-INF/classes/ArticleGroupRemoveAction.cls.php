<?php
/**
* ArticleGroupRemoveAction.cls.php
* @copyright bokee dot com
* @author yudunde@hotmail.com
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('com/FTP.cls.php');

class ArticleGroupRemoveAction extends Action {
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
        $group_id = $request['group_id'];
        $subject_id = $request['subject_id'];
        $article_id = $request['id'];
        $db = "cms_" . $channel_name;
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
		$sql = "update article set group_id=0 where id=$article_id";
		$dao->Query($sql);
		
		$sql = "select * from article where id=$article_id";
		$row = $dao->GetRow($sql);
		$nav_local_file_path = str_replace(".shtml", ".imgnav.shtml", $row['static_file_path']);
		$nav_remote_file_path = str_replace(".shtml", ".imgnav.shtml", $row['remote_static_file_path']);
		$nav = "　　";
		$fp = fopen($nav_local_file_path, 'w');
		fwrite($fp, $nav);
		fclose($fp);	
		$ftp = new FTP($channel_name);
		if(!$ftp->Put($nav_local_file_path, $nav_remote_file_path))
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传图片导航文章 出错。");
		}
			
		//查询该组内所有文章
		$sql = "select * from article where group_id = $group_id order by id";
		$rows = $dao->GetPlan( $sql );
		$rows_num = count($rows);
		//遍历文章
		for( $i=0;$i<$rows_num;$i++ )
		{
			$nav = "<div class=article_nav>";
			if($i>0)
			{
				$nav .="[ <a href=" . $rows[$i-1]['remote_url'] . ">上一篇</a> ]";
			}
			for($j=0;$j<count($rows);$j++)
			{
				if($i==$j)
				{
					$nav .= " <font color=red>" . ($j+1) . "</font> ";
				}
				else 
				{
					$nav .= " <a href=" . $rows[$j]['remote_url'] . ">" . ($j+1) . "</a> ";
				}
			}
			if($i<count($rows)-1)
			{
				$nav .="[ <a href=" . $rows[$i+1]['remote_url'] . ">下一篇</a> ]";
			}
			$nav .="</div>";
			$nav_local_file_path = str_replace(".shtml", ".imgnav.shtml", $rows[$i]['static_file_path']);
			$nav_remote_file_path = str_replace(".shtml", ".imgnav.shtml", $rows[$i]['remote_static_file_path']);

			$fp = fopen($nav_local_file_path, 'w');
			fwrite($fp, $nav);
			fclose($fp);
				
			$ftp = new FTP($channel_name);
			if(!$ftp->Put($nav_local_file_path, $nav_remote_file_path))
			{
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传图片导航文章 出错。");
			}
		}
		
		return "main.php?do=article_group_modify&channel_name=$channel_name&subject_id=$subject_id&id=$group_id";
        
	}
}
?>