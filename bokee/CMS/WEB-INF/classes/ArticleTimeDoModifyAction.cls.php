<?php
/**
* ArticleTimeDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class ArticleTimeDoModifyAction extends Action {

    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema( "cms_" . $request['channel_name'] );
		
		//接收变量
		$year = $request['year'];
		$month = $request['month'];
		$day = $request['day'];
		$hour = $request['hour'];
		$minute = $request['minute'];
		$second = $request['second'];

		$article_id = $request['article_id'];
		$r_id = $request['r_id'];

		$new_time = $year."-".$month."-".$day." ".$hour.":".$minute.":".$second;
		$new_time_ts = $year.$month.$day.$hour.$minute.$second;
		
		//如果对原创文章时间进行修改
		if( $article_id != 0 )
		{
			$sql_select = "select create_time from article where id='$article_id'";
			$row_cms = $dao->GetRow($sql_select);
			
			//判断如果相同，则不用更新
			if( $row_cms['create_time'] == $new_time )
			{
				$str_js = "<script language='javascript'>";
				$str_js.= "alert('更新成功!');";
				$str_js.= "self.close();";
				$str_js.= "</script>";
				echo $str_js;
				die;
			}

			//更新article中时间
			$sql_update = "update article set create_time='$new_time' where id='$article_id'";
			if( $dao->Update( $sql_update ) )
			{
				//更新rel_article_subject表中时间
				$sql_update = "update rel_article_subject set datetime='$new_time_ts' where article_id='$article_id' and category='0'";
				if( $dao->Update( $sql_update ) )
				{
					$str_js = "<script language='javascript'>";
					$str_js.= "alert('更新成功!');";
					$str_js.= "self.close();";
					$str_js.= "window.opener.location.reload();";
					$str_js.= "</script>";
					echo $str_js;
					die;
				}
			}
		}
		
		//如果对rss文章进行修改
		if( $r_id != 0 )
		{

			$sql_select = "select article_id,category,datetime from rel_article_subject where id='$r_id'";
			$row = $dao->GetRow( $sql_select );

			if( $row['datetime'] == $new_time_ts )
			{
				$str_js = "<script language='javascript'>";
				$str_js.= "alert('更新成功!');";
				$str_js.= "self.close();";
				$str_js.= "</script>";
				echo $str_js;
				die;
			}
			else
			{
				//更新rel_article_subject表
				$sql = "update rel_article_subject set datetime='$new_time_ts' ";
				$sql.= "where article_id=" . $row['article_id'];
				$dao->Update( $sql );
				if( $dao->CountAffectedRows() >=1 )
				{
					switch( $row['category'] )
					{

						case "1":
							//更新rss_entry_attach表中datetime
							$sql = "update rss_entry_attach set datetime='$new_time' ";
							$sql.= "where id=" . $row['article_id'];
							$dao->Update( $sql );
							break;
			
						case "2":
							//更新cms数据库中article表中title
							$dao->SetCurrentSchema( "cms" );
							$sql = "update rss_article set pub_date='$new_time' ";
							$sql.= "where id=" . $row['article_id'];
							$dao->Update( $sql );
							break;
					}
					//如果数据库更新成功,或者是只是mark被改变,而数据库无更新
					if( $dao->CountAffectedRows() == 1 )
					{
						$str_js = "<script language='javascript'>";
						$str_js.= "alert('更新成功!');";
						$str_js.= "self.close();";
						$str_js.= "window.opener.location.reload();";
						$str_js.= "</script>";
						echo $str_js;
						die;
					}
					else
					{
						die("更新源数据失败!");
					}
				}		
				else
				{
					die("替换失败!");
				}

			}
		}		
		
	
     }
}
?>