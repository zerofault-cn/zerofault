<?php
    /**********************************************************************/
    /* 文件名：class_match_info_man.inc.php                                 */
    /* 功能：  博客大赛信息的管理模型                                     */
    /* 版本：  0.1                                                        */
    /* 日期：  2005-9-22                                                  */
    /* 作者：  朱江敏                                                     */
    /* 版权：  北京博客时代信息技术有限公司                               */
    /**********************************************************************/

if (!defined('CLASS_MATCH_INFO_MAN_INC_PHP'))
{
    define('CLASS_MATCH_INFO_MAN_INC_PHP', true);

    /**********************************************************************/
    /* 类名：RunUnitMan                                           */
    /* 功能：参赛博客信息管理：增、删、改、列表                               */
    /**********************************************************************/
    class MatchInfoMan
    {
	    var $myDBOperate;                           // 数据库连接
	
        /******************************************************************/
        /* 函数：RunUnitMan                                       */
        /* 参数：                                     			  */
        /* 功能：构造函数                                                 */
        /* 返回值：                                                       */
        /******************************************************************/
        function MatchInfoMan()
        {
            global $db;
	    $this->myDBOperate = $db;
        }

        /******************************************************************/
        /* 函数：GetNewsList                                     	  */
        /* 参数：                                                         */
        /* 功能：获取博客大赛新闻信息列表                                 */
        /* 返回值：博客大赛新闻数组列表                                   */
        /******************************************************************/
        function GetNewsList($type, $limitNum)
        {
		$newsList = array();
		$sql = "SELECT * FROM school_news  ".
			"where news_tag = '".$type.
			"' order by news_post_time desc limit ".$limitNum;
			if(2==$type)
			{
				$sql="select * from school_comment order by comment_time desc limit 0,".$limitNum;
			}
		$result = $this->myDBOperate->sql_query($sql);
		while($line = $this->myDBOperate->sql_fetchrow($result))
		{
			$newsList[] = $line;
		}
		return $newsList;
        }
        /******************************************************************/
        /* 函数：GetCommentList                                     	  */
        /* 参数：                                                         */
        /* 功能：获取评论信息列表                                 */
        /* 返回值：评论数组列表                                   */
        /******************************************************************/
        function GetCommentList($comment_type='', $object_id='', $limitNum='')
        {
		$commentList = array();
	        $sql = "select comment_mome, comment_user, comment_time ".
	        	"from school_comment";
	        
	        if($comment_type != '')
	        	$sql .= " where comment_type = ".$comment_type;

	        if($object_id != '')
	        	$sql .= " and news_id = ".$object_id;
	        
	        $sql .= " order by comment_time desc";

	        if($limitNum != '')
	        	$sql .= " limit ".$limitNum;
	        	
		$result = $this->myDBOperate->sql_query($sql);
		while($line = $this->myDBOperate->sql_fetchrow($result))
		{
			$commentList[] = $line;
		}
		return $commentList;
        }
        /******************************************************************/
        /* 函数：GetCommentList                                     	  */
        /* 参数：                                                         */
        /* 功能：获取评论信息列表                                 */
        /* 返回值：评论数组列表                                   */
        /******************************************************************/
        function GetUserCount($school = '')
        {
		$sql = "SELECT * FROM school_user ";
		
		if ($school != '')
		{                 
	           $sql .= "WHERE user_school = '".$school."'";
	        }	        
		$result = $this->myDBOperate->sql_query($sql);
		$userCount = $this->myDBOperate->sql_numrows($result);
		return $userCount;
        }
        /******************************************************************/
        /* 函数：GetBokeeTaxisList                                        */
        /* 参数：                                                         */
        /* 功能：获取投票排行信息列表                                 	  */
        /* 返回值：投票排行信息列表                                       */
        /******************************************************************/
        function  GetActiveList($type)
        {
		$activeList = array();
		$sql = "SELECT * FROM school_play ".
			"WHERE play_cote = $type ".
	        	"order by play_id desc limit 0,3";

		$result = $this->myDBOperate->sql_query($sql);
		while($line = $this->myDBOperate->sql_fetchrow($result))
		{
			$activeList[] = $line;
		}
		return $activeList;
        }
        /******************************************************************/
        /* 函数：GetGonggaoList                                        */
        /* 参数：                                                         */
        /* 功能：获取投票排行信息列表                                 	  */
        /* 返回值：投票排行信息列表                                       */
        /******************************************************************/
        function  GetGonggaoList($limitNum = '')
        {
		$gonggaoList = array();
		$sql = "SELECT * FROM school_pla ".
	        	"order by pla_time desc ";
	        if($limitNum != '')
	        	$sql .= "limit ".$limitNum;

		$result = $this->myDBOperate->sql_query($sql);
		while($line = $this->myDBOperate->sql_fetchrow($result))
		{
			$gonggaoList[] = $line;
		}
		return $gonggaoList;
        }
        /******************************************************************/
        /* 函数：GetMatchBokeeList                                     	  */
        /* 参数：                                                         */
        /* 功能：获取参赛博客信息列表                                 	  */
        /* 返回值：参赛博客信息列表                                       */
        /******************************************************************/
        function GetPicsList($type, $limitNum)
        {
		$picsList = array();
		$sql = "SELECT a.pic_link, b.play_school FROM school_cote_pic a, school_play b  ".
			"where a.play_id = b.play_id and a.pic_addr = '".$type.
			"' order by pic_id desc limit ".$limitNum;
		if(2==$type)
		{
			$sql = "SELECT distinct(a.play_id) FROM school_cote_pic a, school_play b  ".
			"where a.play_id = b.play_id and a.pic_addr = '".$type.
			"' order by pic_id desc limit ".$limitNum;
		}
			//echo $sql;die;
		$result = $this->myDBOperate->sql_query($sql);
		while($line = $this->myDBOperate->sql_fetchrow($result))
		{
			$picsList[] = $line;
		}
		return $picsList;
        }
        /******************************************************************/
        /* 函数：GetBokeePersonList                                       */
        /* 参数：                                                         */
        /* 功能：获取十大博客人物列表                                 	  */
        /* 返回值：十大博客人物信息列表                                   */
        /******************************************************************/
        function GetViewPointList($limitNum)
        {
		$pointList = array();
		$sql = "SELECT * FROM school_viewpoint ".
			"order by vp_id desc limit ".$limitNum;
		$result = $this->myDBOperate->sql_query($sql);
		while($line = $this->myDBOperate->sql_fetchrow($result))
		{
			$pointList[] = $line;
		}
		return $pointList;
        }
        /******************************************************************/
        /* 函数：GetBokeeInfo                                             */
        /* 参数：                                                         */
        /* 功能：获取参赛博客信息                                 	  */
        /* 返回值：参赛博客信息                                           */
        /******************************************************************/
        function GetNewsInfo($newsID)
        {
		$newsInfo = array();
		$sql = "SELECT * ".			
			"FROM school_news a ".
			"WHERE news_id = '".$newsID."'";

		$result = $this->myDBOperate->sql_query($sql);
		$newsInfo = $this->myDBOperate->sql_fetchrow($result);
		return $newsInfo;
        }
        /******************************************************************/
        /* 函数：AddComment                                               */
        /* 参数：commentInfo表示需要添加的评论信息                   	  */
        /* 功能：添加新的评论信息                                         */
        /* 返回值：添加评论信息是否成功                                   */
        /******************************************************************/
        function AddComment($commentInfo)
        {
            global $userdata;
            $comment_user = $userdata["user_name"];
	    $current_time = time();
	    $add_sql = "INSERT INTO school_comment(comment_type, news_id, comment_time, ".
	    	"comment_user, comment_mome) ".
                " VALUES('".$commentInfo["comment_type"]."', '".$commentInfo["object_id"].
                "', '".$current_time."', '".$comment_user."', '".htmlspecialchars($commentInfo["comment_text"], ENT_QUOTES).
                "')";  
            $add_result = $this->myDBOperate->sql_query($add_sql);             

            if ($add_result)
                return 0;                           // 成功
            else                                    
                return 2;                          // 失败
        }
    }
}
?>