<?php
    /**********************************************************************/
    /* �ļ�����class_match_info_man.inc.php                                 */
    /* ���ܣ�  ���ʹ�����Ϣ�Ĺ���ģ��                                     */
    /* �汾��  0.1                                                        */
    /* ���ڣ�  2005-9-22                                                  */
    /* ���ߣ�  �콭��                                                     */
    /* ��Ȩ��  ��������ʱ����Ϣ�������޹�˾                               */
    /**********************************************************************/

if (!defined('CLASS_MATCH_INFO_MAN_INC_PHP'))
{
    define('CLASS_MATCH_INFO_MAN_INC_PHP', true);

    /**********************************************************************/
    /* ������RunUnitMan                                           */
    /* ���ܣ�����������Ϣ��������ɾ���ġ��б�                               */
    /**********************************************************************/
    class MatchInfoMan
    {
	    var $myDBOperate;                           // ���ݿ�����
	
        /******************************************************************/
        /* ������RunUnitMan                                       */
        /* ������                                     			  */
        /* ���ܣ����캯��                                                 */
        /* ����ֵ��                                                       */
        /******************************************************************/
        function MatchInfoMan()
        {
            global $db;
	    $this->myDBOperate = $db;
        }

        /******************************************************************/
        /* ������GetNewsList                                     	  */
        /* ������                                                         */
        /* ���ܣ���ȡ���ʹ���������Ϣ�б�                                 */
        /* ����ֵ�����ʹ������������б�                                   */
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
        /* ������GetCommentList                                     	  */
        /* ������                                                         */
        /* ���ܣ���ȡ������Ϣ�б�                                 */
        /* ����ֵ�����������б�                                   */
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
        /* ������GetCommentList                                     	  */
        /* ������                                                         */
        /* ���ܣ���ȡ������Ϣ�б�                                 */
        /* ����ֵ�����������б�                                   */
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
        /* ������GetBokeeTaxisList                                        */
        /* ������                                                         */
        /* ���ܣ���ȡͶƱ������Ϣ�б�                                 	  */
        /* ����ֵ��ͶƱ������Ϣ�б�                                       */
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
        /* ������GetGonggaoList                                        */
        /* ������                                                         */
        /* ���ܣ���ȡͶƱ������Ϣ�б�                                 	  */
        /* ����ֵ��ͶƱ������Ϣ�б�                                       */
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
        /* ������GetMatchBokeeList                                     	  */
        /* ������                                                         */
        /* ���ܣ���ȡ����������Ϣ�б�                                 	  */
        /* ����ֵ������������Ϣ�б�                                       */
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
        /* ������GetBokeePersonList                                       */
        /* ������                                                         */
        /* ���ܣ���ȡʮ�󲩿������б�                                 	  */
        /* ����ֵ��ʮ�󲩿�������Ϣ�б�                                   */
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
        /* ������GetBokeeInfo                                             */
        /* ������                                                         */
        /* ���ܣ���ȡ����������Ϣ                                 	  */
        /* ����ֵ������������Ϣ                                           */
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
        /* ������AddComment                                               */
        /* ������commentInfo��ʾ��Ҫ��ӵ�������Ϣ                   	  */
        /* ���ܣ�����µ�������Ϣ                                         */
        /* ����ֵ�����������Ϣ�Ƿ�ɹ�                                   */
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
                return 0;                           // �ɹ�
            else                                    
                return 2;                          // ʧ��
        }
    }
}
?>