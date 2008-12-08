<?php
/**
 * Article.cls.php
 * @author  yudunde@bokee.com
 * @version  1.0
 * @abstract  文章类
 * @copyright bokee dot com
 * created at August 12, 2005, 13:22:37
 */

require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');
require_once('mod/Special.cls.php');
require_once('mod/Channel.cls.php');
require_once('lang/Assert.cls.php');
require_once('com/Log.cls.php');
require_once('com/FTP.cls.php');
require_once('com/UploadImg.cls.php');
require_once('com/Snoopy.cls.php');
require_once('smarttemplate/class.smarttemplate.php');
require_once('mod/Gallery.cls.php');

class Article
{
	//成员变量
	/**
	* @access private
	*/
	var $_db;
	/**
	* @access private
	*/
	var $_id;
	/**
	* @access private
	*/
	var $_title;
	var $_group_image_title;
	/**
	* @access private
	*/
	var $_sub_title;
	/**
	* @access private
	*/
	var $_create_time;
	/**
	* @access private
	*/
	var $_channel_id;
	/**
	* @access private
	*/
	var $_subject_id;
	/**
	* @access private
	*/
	var $_subject_dir;
	/**
	* @access private
	*/
	var $_author;
	/**
	* @access private
	*/
	var $_coop_media_id;
	/**
	* @access private
	*/
	var $_media_name;
	/**
	* @access private
	*/
	var $_area_id;
	/**
	* @access private
	*/
	var $_view_num;
	/**
	* @access private
	*/
	var $_comment_num;
	/**
	* @access private
	*/
	var $_score;
	/**
	* @access private
	*/
	var $_user_id;
	/**
	* @access private
	*/
	var $_description;
	/**
	* @access private
	*/
	var $_visible;
	/**
	* @access private
	*/
	var $_keyword;
	/**
	* @access private
	*/
	var $_mark;
	/**
	* @access private
	*/
	var $_content_path;
	/**
	* @access private
	*/
	var $_special_id;
	/**
	* @access private
	* @abstract 专题名称 
	*/
	var $_special_name;
	/**
	* @access private
	*/
	var $_special_subject_id;
	/**
	* @access private
	*/
	var $_is_multi_special;
	/**
	* @access private
	*/
	var $_rel_blog_path;
	var $_rel_cms_path;
	var $_rel_rss_path;
	/**
	* @access private
	*/
	var $_dao;
	/**
	* @access private
	*/
	var $_row;
	/**
	* @access private
	*/
	var $_content;
	/**
	* @access private
	*/
	var $_rel_blog_content;
	var $_rel_cms_content;
	var $_rel_rss_content;
	/**
	* @access private
	*/
	var $_static_file_path;
	var $_static_file_dir;
	/** 
	* @access private
	*/
	var $_enable_comment;
	/**
	* @access private 
	*/
	var $_enable_ad;
	/** 
	* @access private
	*/
	var $_channel_name;
	var $_channel_feed_redirect;
	/**
	* @access private
	*/
	var $_subject_name;
	/**
	* @access private 
	*/
	var $_files;
	/**
	* @access private
	*/
	var $_remote_static_file_path;
	var $_remote_static_file_dir;
	/**
	* @access private
	*/
	var $_images_text;
	/**
	* @access private
	*/
	var $_remote_url;
	
	/* @access private
	*/
	var $_is_rss;
	
	/* @access private
	*/
	var $_rss_url;
	/**
	* @access private
	*/
	var $_is_zip;
	var $_is_uploaded;				//当前操作是否是组图上传
	var $_images_file_name;			//上传图片文件名数组
	var $_image_nav_inc_file_name;	//组图导航包含文件名
	var $_group_image_desc;			//组图描述
	var $_group_image_descs;		//组图描述数组
	var $_group_image_start_article_id;			//组图第一篇文章id

	//如果为非zip包，此数组存放图片新名称
	var $_group_image_new_name_list;
	var $_rel_id;

	/**
	* @access private
	*/
	var $_group_id;

	/**
	* @access private
	*/
	var $_ori_group_id;

	/**
	* @access private
	*/
	var $_auto_redirect;

	/**
	* @access private
	*/
	var $_plush_time;
	//成员方法
	/**
	* @access public
	* @return  int $id
	*/
	function GetId()
	{
		return $this->_id;
	}
	/**
	* @access public
	* @param $_plsh_time
	* @return  shuzi
	*/
	function Setplush_time($value)
	{
		return $this->_plush_time = $value;
	}
	/**
	* @access public
	* @return string $title
	*/
	function GetTitle()
	{
		return $this->_title;
	}
	function Getplush_time()
	{
		return $this->__plush_time;
	}
	/**
	* @access public
	* @param string $value
	* @return  bool
	*/
	function SetTitle($value)
	{
		$this->_title = $value;
	}
	/**
	* @access public
	* @return string $sub_title
	*/
	function GetSubTitle()
	{
		return $this->_sub_title;
	}
	/**
	* @access public
	* @param string $value
	* @return  bool
	*/
	function SetSubTitle($value)
	{
		$this->_sub_title = $value;
	}
	/**
	* @access public
	* @return string $create_time
	* @return  bool
	*/
	function GetCreateTime()
	{
		return $this->_create_time;
	}
	/**
	* @access public
	* @param string $value
	* @return  bool
	*/
	function SetCreateTime($value)
	{
		$this->_create_time = $value;
	}
	/**
	* @access public
	* @return int $channel_id
	*/
	function GetChannelId()
	{
		return $this->_channel_id;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetChannelId($value)
	{
		$this->_channel_id = $value;
		if($this->_channel_id>0)
		{
			$channel = new Channel($this->_db);
			$channel->GetByID($this->_channel_id);
			$this->_channel_name = $channel->GetName();
			$this->_channel_feed_redirect=$channel->GetFeedRedirect();
		}		
	}
	/**
	* @access public
	* @return int $subject_id
	*/
	function GetSubjectId()
	{
		return $this->_subject_id;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetSubjectId($value)
	{
		$this->_subject_id = $value;
		if($this->_subject_id>0)
		{
			$subject = new Subject($this->_db);
			$subject->GetByID($this->_subject_id);
			$this->_subject_dir = $subject->GetDirName();
			$this->_subject_name = $subject->GetName();
		}
	}
	/**
	* @access public
	* @return string $author
	*/
	function GetAuthor()
	{
		return $this->_author;
	}
	/**
	* @access public
	* @param string $value
	* @return  bool
	*/
	function SetAuthor($value)
	{
		$this->_author = $value;
	}
	/**
	* @access public
	* @return int $coop_media_id
	*/
	function GetCoopMediaId()
	{
		return $this->_coop_media_id;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetCoopMediaId($value)
	{
		$this->_coop_media_id = $value;
	}
	/**
	* @access public
	* @return stirng $media_name;
	*/
	function GetMediaName()
	{
		return $this->_media_name;
	}
	/**
	* @access public
	* @param string $value
	* @return  bool
	*/
	function SetMediaName($value)
	{
		$this->_media_name = $value;
	}
	/**
	* @access public
	* @return int $area_id
	*/
	function GetAreaId()
	{
		return $this->_area_id;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetAreaId($value)
	{
		$this->_area_id = $value;
	}
	/**
	* @access public
	* @return int $view_num
	*/
	function GetViewNum()
	{
		return $this->_view_num;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetViewNum($value)
	{
		$this->_view_num = $value;
	}
	/**
	* @access public
	* @return int $comment_num;
	*/
	function GetCommentNum()
	{
		return $this->_comment_num;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetCommentNum($value)
	{
		$this->_comment_num = $value;
	}
	/**
	* @access public
	* @return int $score
	*/
	function GetScore()
	{
		return $this->_score;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetScore($value)
	{
		$this->_score = $value;
	}
	/**
	* @access public
	* @return int $user_id
	*/
	function GetUserId()
	{
		return $this->_user_id;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetUserId($value)
	{
		$this->_user_id = $value;
	}
	/**
	* @access public
	* @return int $template_id
	*/
	function GetTemplateId()
	{
		return $this->_template_id;
	}
	/**
	* @access public
	* @param int $value;
	* @return  bool
	*/
	function SetTemplateId($value)
	{
		$this->_template_id = $value;
	}
	/**
	* @access public
	* @return string $description
	*/
	function GetDescription()
	{
		return $this->_description;
	}
	/**
	* @access public
	* @param string $value
	* @return  bool
	*/
	function SetDescription($value)
	{
		$this->_description = $value;
	}
	/**
	* @access public
	* @return int $visible
	*/
	function GetVisible()
	{
		return $this->_visible;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetVisible($value)
	{
		$this->_visible = $value;
	}
	/**
	* @access public
	* @return stirng $keyword
	*/
	function GetKeyword()
	{
		return $this->_keyword;
	}
	/**
	* @access public
	* @param string $value
	* @return  bool
	*/
	function SetKeyword($value)
	{
		$this->_keyword = $value;
	}
	/**
	* @access public
	* @return int $mark
	*/
	function GetMark()
	{
		return $this->_mark;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetMark($value)
	{
		$this->_mark = $value;
	}
	/**
	* @access public
	* @return string $content_path
	*/
	function GetContentPath()
	{
		return $this->_content_path;
	}
	/**
	* @access public
	* @param string $value
	* @return  bool
	*/
	function SetContentPath($value)
	{
		$this->_content_path = $value;
	}
	/**
	* @access public
	* @return int $special_id
	*/
	function GetSpecialId()
	{
		return $this->_special_id;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetSpecialId($value)
	{
		$this->_special_id = $value;
		if($this->_special_id>0)
		{
			$special = new Special($this->_db);
			$special->GetByID($this->_special_id);
			$this->_special_name = $special->GetName();		
		}
	}
	/**
	* @access public
	* @return int $special_subject_id
	*/
	function GetSpecialSubjectId()
	{
		return $this->_special_subject_id;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetSpecialSubjectId($value)
	{
		$this->_special_subject_id = $value;
	}
	/**
	* @access public
	* @return int $is_multi_special
	*/
	function GetIsMultiSpecial()
	{
		return $this->_is_multi_special;
	}
	/**
	* @access public
	* @param int $value
	* @return  bool
	*/
	function SetIsMultiSpecial($value)
	{
		$this->_is_multi_special = $value;
	}
	/**
	* @access public
	* @return string $rel_blog_path
	*/
	function GetRelBlogPath()
	{
		return $this->_rel_blog_path;
	}
	/**
	* @access public
	* @param string $value
	* @return  bool
	*/
	function SetRelBlogPath($value)
	{
		$this->_rel_blog_path = $value;
	}
	/**
	* @access public
	* @return string $content
	*/
	function GetContent()
	{
		return $this->_content;
	}
	/**
	* @access public
	* @param string $value
	* @return bool
	*/
	function SetContent($value)
	{
		$this->_content = $value;
	}
	/**
	* @access public
	* @return string $rel_blog_content
	*/
	function GetRelBlogContent()
	{
		return $this->_rel_blog_content;
	}
	function GetRelCMSContent()
	{
		return $this->_rel_cms_content;
	}
	function GetRelRSSContent()
	{
		return $this->_rel_rss_content;
	}
	/**
	* @access public
	* @param string $value
	* @return bool
	*/
	function SetRelBlogContent($value)
	{
		$this->_rel_blog_content = $value;
	}
	function SetRelCMSContent($value)
	{
		$this->_rel_cms_content = $value;
	}
	function SetRelRSSContent($value)
	{
		$this->_rel_rss_content = $value;
	}
	/**
	* @access public
	* @return string $static_file_path
	*/
	function GetStaticFilePath()
	{
		return $this->_static_file_path;
	}
	/**
	* @access public
	* @param string $value;
	* @return bool
	*/
	function SetStaticFilePath($value)
	{
		$this->_static_file_path = $value;
		return true;
	}
	/** 
	* @access public
	* @param string $value
	* @return bool
	*/
	function SetSubjectDir($value)
	{
		$this->_subject_dir = $value;
		return true;
	}
	/**
	* @access public
	* @return stirng $subject_dir
	*/
	function GetSubjectDir()
	{
		return $this->_subject_dir;
	}
	/**
	* @access public
	*/
	function GetRow()
	{
		return $this->_row;
	}
	/**
	* @access public
	*/
	function SetRow($value)
	{
		$this->_row = $value;
		$this->initUseRow();
	}
	/**
	* @access public
	* @return bool
	*/
	function GetEnableComment()
	{
		return ($this->_enable_comment=='Y')?true:false;
	}
	/**
	* @access public
	* @param bool $value
	* @return bool
	*/
	function SetEnableComment($value)
	{
		$this->_enable_comment = $value?'Y':'N';
		return true;
	}
	/**
	* @access public
	* @return bool 
	*/
	function GetEnableAd()
	{
		return ($this->_enable_ad=='Y')?true:false;
	}
	/** 
	* @access public
	* @param bool $value
	* @return bool
	*/
	function SetEnableAd($value)
	{
		$this->_enable_ad = $value?'Y':'N';
		return true;
	}
	/**
	* @access public
	* @return string $channel_name
	*/
	function GetChannelName()
	{
		return $this->_channel_name;
	}
	/**
	* @access public
	* @return string $subject_name
	*/
	function GetSubjectName()
	{
		return $this->_subject_name;
	}
	/**
	* @access public
	* @return string $special_name
	*/
	function GetSpecialName()
	{
		return $this->_special_name;
	}
	/**
	* @access public
	* @return bool
	*/
	function SetFiles($files)
	{
		$this->_files = $files;
		return true;
	}
	function GetRemoteStaticFileName()
	{
		return $this->_remote_static_file_path;
	}
	function SetRemoteStaticFileName($value)
	{
		$this->_remote_static_file_path = $value;
		return true;
	}
	function GetRemoteURL()
	{
		return $this->_remote_url;
	}
	function SetImagesText($value)
	{
		$this->_images_text = $value;
		return true;
	}
	function SetRemoteURL($value)
	{
		$this->_remote_url = $value;
		return true;
	}
	function GetIsRss()
	{
		return ( $this->_is_rss == 'Y')?true:false;
	}
	function SetIsRss($value)
	{
		$this->_is_rss = $value?'Y':'N';
		return true;
	}
	function SetRssURL($value)
	{
		$this->_rss_url = $value;
		$this->SetIsRss('Y');
		return true;
	}
	function GetRssURL()
	{
		return $this->_rss_url;
	}
	function SetIsUploaded($value)
	{
		$this->_is_uploaded = $value;
	}
	function GetIsUploaded()
	{
		return $this->_is_uploaded;
	}
	function SetImageNavIncFileName($value)
	{
		$this->_image_nav_inc_file_name = value;
	}
	function SetGroupImageDesc($value)
	{
		$this->_group_image_desc = $value;
		$array = split("\r\n", $this->_group_image_desc);
		$arr_length = count($array);
		$this->_group_image_descs = array();
		$j = 0;
		for($i=0;$i<$arr_length;$i++)
		{
			if( strpos($array[$i],'::') === false )
			{
				continue;
			}
			if(!empty($array[$i]))
			{
				$this->_group_image_descs[$j] = $array[$i];
				$j++;
			}
		}

	}
	function SetGroupImageStartArticleID($value)
	{
		$this->_group_image_start_article_id = $value;
	}
	
	function SetGroupID($value)
	{
		$this->_group_id = $value;
	}
	function GetGroupID()
	{
		return $this->_group_id;
	}
	function SetAutoRedirect($value)
	{
		$this->_auto_redirect = $value;
	}
	function GetAutoRedirect()
	{
		return $this->_auto_redirect;
	}
	/**
	* @access public
	* @abstract  构造函数
	* @param string $channel_db
	* @param array $row
	*/
	function Article($channel_db, $row = null)
	{
		if(empty($row))
		{
			//成员变量初始化
			$this->SetTitle("标题");
			$this->SetSubTitle("副标题");
			$this->SetCreateTime(date("Y-m-d H:i:s"));
			$this->SetChannelId(0);
			$this->SetSubjectId(0);
			$this->SetAuthor("作者");
			$this->SetCoopMediaId(0);
			$this->SetMediaName("合作媒体");
			$this->SetAreaId(0);
			$this->SetViewNum(0);
			$this->SetCommentNum(0);
			$this->SetScore(0);
			$this->SetUserId(0);
			$this->SetTemplateId(0);
			$this->SetDescription("描述");
			$this->SetVisible(0);
			$this->SetKeyword("关键词");
			$this->SetMark(0);
			$this->SetContentPath("");
			$this->SetSpecialId(0);
			$this->SetSpecialSubjectId(0);
			$this->SetIsMultiSpecial(0);
			$this->SetRelBlogPath("");
			$this->SetStaticFilePath("");
			$this->SetSubjectDir("");
			$this->SetEnableComment(true);
			$this->SetEnableAd(true);
			$this->SetIsRss(false);
			$this->_is_zip = false;
			$this->_is_uploaded = false;
		}
		else
		{
			$this->_row = $row;
			//成员变量初始化
			$this->initUseRow();
		}

		$this->_db = $channel_db;
		$channel = new Channel();
		$db_name = str_replace('cms_', '', $this->_db);
		$channel->GetByDirName($db_name);
		$this->_channel_id = $channel->GetId();
		
		$this->_dao = DAO::CreateInstance();
		$this->_dao->SetCurrentSchema($this->_db);
	}
	
	/**
	* @access private
	*/
	function initUseRow()
	{
		$this->_id = $this->_row["id"];
			$this->SetTitle($this->_row['title']);
			$this->SetSubTitle($this->_row['sub_title']);
			$this->SetCreateTime($this->_row['create_time']);
			$this->SetChannelId($this->_row['channel_id']);
			$this->SetSubjectId($this->_row['subject_id']);
			$this->SetAuthor($this->_row['author']);
			$this->SetCoopMediaId($this->_row['coop_media_id']);
			$this->SetMediaName($this->_row['media_name']);
			$this->SetAreaId($this->_row['area_id']);
			$this->SetViewNum($this->_row['view_num']);
			$this->SetCommentNum($this->_row['comment_num']);
			$this->SetScore($this->_row['score']);
			$this->SetUserId($this->_row['user_id']);
			$this->SetTemplateId($this->_row['template_id']);
			$this->SetDescription($this->_row['description']);
			$this->SetVisible($this->_row['visible']);
			$this->SetKeyword($this->_row['keyword']);
			$this->SetMark($this->_row['mark']);
			$this->SetContentPath($this->_row['content_path']);
			$this->SetSpecialId($this->_row['special_id']);
			$this->SetSpecialSubjectId($this->_row['special_subject_id']);
			$this->SetIsMultiSpecial($this->_row['is_multi_special']);
			$this->SetRelBlogPath($this->_row['rel_blog_path']);
			$this->_rel_cms_path = str_replace('rel_blog', 'rel_cms', $this->_rel_blog_path);
			$this->_rel_rss_path = str_replace('rel_blog', 'rel_rss', $this->_rel_blog_path);
			$this->SetStaticFilePath($this->_row['static_file_path']);
			$this->_enable_comment = $this->_row['enable_comment'];
			$this->_enable_ad = $this->_row['enable_ad'];
			$this->_is_rss = $this->_row['is_rss'];
			$this->_remote_static_file_path = $this->_row['remote_static_file_path'];
			$this->_remote_url = $this->_row['remote_url'];
			$this->_rss_url = $this->_row['rss_url'];
			$this->_group_id = $this->_row['group_id'];
			$this->_ori_group_id = $this->_row['group_id'];
			$this->_auto_redirect = $this->_row['auto_redirect'];
	}

	/**
	* @access public
	* @abstract  获取/更新本文章
	* @return  bool
	*/
	function Get()
	{
		if($this->_id>0)
		{
			return $this->GetByID($this->_id);
		}
		else
		{
			return false;
		}
	}

	/**
	* @access public
	* @param int $id
	* @abstract  按ID获取文章
	* @return  bool
	*/
	function GetByID($id)
	{
		$this->_id = intval($id);
		$get_clause = "select * from article where id=$this->_id";
		$this->_row=$this->_dao->GetRow($get_clause);
		if(!$this->_row)
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		$this->initUseRow();
		
		//从文件中读出正文
		if(file_exists($this->_content_path))
		{
			$this->_content = file_get_contents($this->_content_path);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		
		//从文件中读出相关博客内容
		if(file_exists($this->_rel_blog_path))
		{
			$this->_rel_blog_content = file_get_contents($this->_rel_blog_path);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		//从文件中读出相关CMS内容
		if(file_exists($this->_rel_cms_path))
		{
			$this->_rel_cms_content = file_get_contents($this->_rel_cms_path);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		//从文件中读出相关RSS内容
		if(file_exists($this->_rel_rss_path))
		{
			$this->_rel_rss_content = file_get_contents($this->_rel_rss_path);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		
		$channel = new Channel();
		$channel->GetByID($this->_channel_id);
		$this->_channel_name = $channel->GetName();
		$this->_channel_feed_redirect=$channel->GetFeedRedirect();
		
		$subject = new Subject($this->_db);
		$subject->GetByID($this->_subject_id);
		$this->_subject_name = $subject->GetName();
		
		$special = new Special($this->_db);
		$special->GetByID($this->_special_id);
		$this->_special_name = $special->GetName();
		
		return true;
	}
	/**
	* @access public
	* @abstract  更新文章
	* @return bool
	*/
	function Update()
	{
		if(!$this->_is_uploaded)
		{
			//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近上传图片。");
			//上传图片
			$upload = new UploadImg();
			$date = date('Y-m-d');
			$path = "/" . $this->_db . $this->_subject_dir."/".$date;
			$smallpath = "/" . $this->_db . $this->_subject_dir."/s/".$date;
			$upload->setPath($path);
			$upload->setSmallPath($smallpath);
			
			$path = str_replace('cms_', '', $path);
			$smallpath = str_replace('cms_', '', $smallpath);
			

			$image_html = "<center>";
			$i = 0;
			if($this->_files['image1']['size']>0)
			{
				//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近上传图片。");
				$file_name1 = $upload->upload($this->_files['image1']);
				//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近上传图片。" . print_r($file_name1, true));
				if(is_array($file_name1[0]))
				{
					//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 。" . print_r($file_name1, true));
					$this->_is_zip = true;		//是zip包文件
					$this->_images_file_name = $file_name1;
					$file_name1 = $this->_images_file_name[0];
					$this->_image_nav_inc_file_name = $this->getNumberStr($this->_subject_id) . $this->_id . ".imgnav.shtml";
					$this->_group_image_title = $this->_title;
					
					//从文字描述识别对应的文件名称
					$desc_num = count($this->_group_image_descs);
					for($i=0;$i<$desc_num;$i++)
					{
						if(substr($this->_group_image_descs[0], 0, strpos($this->_group_image_descs[0], '::'))==$this->_images_file_name[$i]['ori_name'])
						{
							$this->_title = $this->_title . " " . $this->h_substr( substr($this->_group_image_descs[0], strpos($this->_group_image_descs[0], '::')+2) , 40);
							$image_html .= "<img src=http://images.". DOMAIN . $path . "/" . $this->_images_file_name[$i]['new_name'] . "><br><br>" . substr($this->_group_image_descs[0], strpos($this->_group_image_descs[0], '::')+2) . "<br>";
							break;
						}
					}
					

					$this->AddIntoGallery($this->_group_image_title, substr($this->_group_image_descs[0], strpos($this->_group_image_descs[0], '::')+2), "http://images.". DOMAIN . $smallpath . "/" . $this->_images_file_name[$i]['small_name']);
		
					/*
					//从文件名称识别对应的文字描述
					$desc_num = count($this->_group_image_descs);
					for($i=0;$i<$desc_num;$i++)
					{
						if(substr($this->_group_image_descs[$i], 0, strpos($this->_group_image_descs[$i], ':'))==$file_name1['ori_name'])
						{
							$this->_title = $this->_title . " " . substr($this->_group_image_descs[$i], strpos($this->_group_image_descs[$i], ':')+1);
							$image_html .= "<img src=http://images.". DOMAIN . $path . "/" . $file_name1['new_name'] . "><br><br>" . substr($this->_group_image_descs[$i], strpos($this->_group_image_descs[$i], ':')+1) . "<br>";
							break;
						}
					}
					$this->AddIntoGallery($this->_group_image_title, substr($this->_group_image_descs[$i], strpos($this->_group_image_descs[$i], ':')+1), "http://images.". DOMAIN . $smallpath . "/" . $file_name1['small_name']);
					*/
				}
				else 
				{
					$this->AddIntoGallery($this->_title, $this->_images_text[0], "http://images.". DOMAIN . $smallpath . "/" . $file_name1['small_name']);
					
					$image_html .= "<img src=http://images." . DOMAIN . $path . "/" . $file_name1['new_name'] . "><br><br>" . $this->_images_text[0] . "<br>";
					$this->_group_image_new_name_list[0] = $file_name1;
				}
				
				if(!empty($this->_image_nav_inc_file_name))
				{
					$image_html .= "<br><!--#include virtual=\"" . $this->_image_nav_inc_file_name . "\"--><br>";
				}
				$i++;
			}
			if($this->_files['image2']['size']>0  && !$this->_is_zip)
			{
				$file_name2 = $upload->upload($this->_files['image2']);
				$this->AddIntoGallery($this->_title, $this->_images_text[1], "http://images.". DOMAIN . $smallpath . "/" . $file_name2['small_name']);
				
				$image_html .= "<img src=http://images." . DOMAIN . $path . "/" . $file_name2['new_name'] . "><br><br>" . $this->_images_text[1] . "<br>";
				$this->_group_image_new_name_list[1] = $file_name2;
				$i++;
			}
			if($this->_files['image3']['size']>0 && !$this->_is_zip)
			{
				$file_name3 = $upload->upload($this->_files['image3']);
				$this->AddIntoGallery($this->_title, $this->_images_text[2], "http://images.". DOMAIN . $smallpath . "/" . $file_name3['small_name']);
				
				$image_html .= "<img src=http://images." . DOMAIN . $path . "/" . $file_name3['new_name'] . "><br><br>" . $this->_images_text[2] . "<br>";
				$this->_group_image_new_name_list[2] = $file_name3;
				$i++;
			}
			if($this->_files['image4']['size']>0 && !$this->_is_zip)
			{
				$file_name4 = $upload->upload($this->_files['image4']);
				$this->AddIntoGallery($this->_title, $this->_images_text[3], "http://images.". DOMAIN . $smallpath . "/" . $file_name4['small_name']);
				
				$image_html .= "<img src=http://images." . DOMAIN . $path . "/" . $file_name4['new_name'] . "><br><br>" . $this->_images_text[3] . "<br>";
				$this->_group_image_new_name_list[3] = $file_name4;
				$i++;
			}
			if($this->_files['image5']['size']>0 && !$this->_is_zip)
			{
				$file_name5 = $upload->upload($this->_files['image5']);
				$this->AddIntoGallery($this->_title, $this->_images_text[4], "http://images.". DOMAIN . $smallpath . "/" . $file_name5['small_name']);
				
				$image_html .= "<img src=http://images." . DOMAIN . $path . "/" . $file_name5['new_name'] . "><br><br>" . $this->_images_text[4] . "<br>";
				$this->_group_image_new_name_list[4] = $file_name5;
				$i++;
			}
			if($this->_files['image6']['size']>0 && !$this->_is_zip)
			{
				$file_name6 = $upload->upload($this->_files['image6']);
				$this->AddIntoGallery($this->_title, $this->_images_text[5], "http://images.". DOMAIN . $smallpath . "/" . $file_name6['small_name']);
				
				$image_html .= "<img src=http://images." . DOMAIN . $path . "/" . $file_name6['new_name'] . "><br><br>" . $this->_images_text[5] . "<br>";
				$this->_group_image_new_name_list[5] = $file_name6;
				$i++;
			}
			$image_html .= "</center>";
			
			//如果为组图/组文，则添加导航
			if( $this->_group_id >0 && empty($this->_image_nav_inc_file_name))
			{
				 $image_html .= "<!--#include virtual=\"" . $this->getNumberStr($this->_subject_id) . $this->_id . ".imgnav.shtml" . "\"-->";
			}

			if($i>0)
			{
				$this->_content = $image_html . $this->_content;
			}
			else if($this->_group_id>0)
			{
				//组文
				$this->_content = $this->_content . $image_html;
			}
		}
		else 
		{
			//图片已经上传，指定图片url，一般用于组图上传
			$image_html = "<img src=" . $this->_files['url'] . "><br><br>" . $this->_files['description'] . "<br>";
			$pattern = "/<img src=http:\/\/.*?><br><br>.*?<br>/i";
			$this->_content = preg_replace($pattern, $image_html, $this->_content);
			$this->_image_nav_inc_file_name = $this->getNumberStr($this->_subject_id) . $this->_id . ".imgnav.shtml";
			$nav_html = "<!--#include virtual=\"" . $this->_image_nav_inc_file_name . "\"-->";
			$pattern = "/<!--#include virtual=\".*?\"-->/i";
			$this->_content = preg_replace($pattern, $nav_html, $this->_content);
			
			$this->AddIntoGallery(str_replace(" " . $this->_files['description'], "", $this->_title), $this->_files['description'], $this->_files['small_url']);
		}
		//将正文更新至文件系统
		if(!empty($this->_content_path))
		{
			$fp = fopen($this->_content_path, 'w');
			if( !empty( $this->_content ) ){
				if(!fwrite($fp, $this->_content))
				{
					fclose($fp);
					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
					return false;
				}
			}
			fclose($fp);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		
		//更新数据库
		$update_clause = "update article set
		title = '$this->_title',
		sub_title = '$this->_sub_title',
		create_time = '$this->_create_time',
		channel_id = $this->_channel_id,
		subject_id = $this->_subject_id,
		author = '$this->_author',
		coop_media_id = $this->_coop_media_id,
		media_name = '$this->_media_name',
		area_id = $this->_area_id,
		view_num = $this->_view_num,
		comment_num = $this->_comment_num,
		score = $this->_score,
		user_id = $this->_user_id,
		template_id = $this->_template_id,
		description = '$this->_description',
		visible = $this->_visible,
		keyword = '$this->_keyword',
		mark = $this->_mark,
		content_path = '$this->_content_path',
		special_id = $this->_special_id,
		special_subject_id = $this->_special_subject_id,
		is_multi_special = $this->_is_multi_special,
		rel_blog_path = '$this->_rel_blog_path',
		enable_comment = '$this->_enable_comment',
		enable_ad = '$this->_enable_ad',
		is_rss = '$this->_is_rss',
		static_file_path = '$this->_static_file_path',
		remote_static_file_path = '$this->_remote_static_file_path',
		remote_url = '$this->_remote_url',
		rss_url = '$this->_rss_url',
		group_id = '$this->_group_id' 
		where id=$this->_id
		";
		
		if(!$this->_dao->Update($update_clause))
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}

		return true;
	}
	/**
	* @abstract 更新相关cms/博客/rss内容
	*/
	function UpdateRelContent()
	{
		//将相关博客文章更新至文件系统
		if(!empty($this->_rel_blog_content))
		{
			$fp = fopen($this->_rel_blog_path, 'w');
			if(!fwrite($fp, $this->_rel_blog_content))
			{
				fclose($fp);
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
				return false;
			}
			fclose($fp);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		
		//将相关CMS文章更新至文件系统
		if(!empty($this->_rel_cms_content))
		{
			$fp = fopen($this->_rel_cms_path, 'w');
			if(!fwrite($fp, $this->_rel_cms_content))
			{
				fclose($fp);
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
				return false;
			}
			fclose($fp);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		
		//将相关RSS文章更新至文件系统
		if(!empty($this->_rel_rss_content))
		{
			$fp = fopen($this->_rel_rss_path, 'w');
			if(!fwrite($fp, $this->_rel_rss_content))
			{
				fclose($fp);
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
				return false;
			}
			fclose($fp);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		return true;
	}
	
	function UpLoadImageA($file, $index)
	{
		$image_html = "";
		$upload = new UploadImg();
		$date = date('Y-m-d');
		$path = "/" . $this->_db .  "/" . $this->_subject_dir."/".$date;
		$smallpath = "/" . $this->_db .  "/" . $this->_subject_dir."/s/".$date;
		$upload->setPath($path);
		$upload->setSmallPath($smallpath);	
		$path = str_replace('cms_', '', $path);
		$smallpath = str_replace('cms_', '', $smallpath);
		if($file['size']>0)
		{
			$file_name = $upload->upload($file);
			$this->AddIntoGallery($this->_title, $this->_images_text[$index], "http://images.". DOMAIN . $smallpath . "/" . $file_name['small_name']);
				
			$image_html .= "<img src=http://images." . DOMAIN . $path . "/" . $file_name['new_name'] . "><br><br>" . $this->_images_text[$index] . "<br>";
		}
		return $image_html;
	}
	
	function Modify()
	{
		//上传图片
		$image_html = "<center>";
		$i = 0;
		$html1 = $this->UpLoadImageA($this->_files['image1'], 0);
		$html2 = $this->UpLoadImageA($this->_files['image2'], 1);
		$html3 = $this->UpLoadImageA($this->_files['image3'], 2);
		$html4 = $this->UpLoadImageA($this->_files['image4'], 3);
		$html5 = $this->UpLoadImageA($this->_files['image5'], 4);
		$html6 = $this->UpLoadImageA($this->_files['image6'], 5);
		if(strlen($html1)>1)
		{
			$image_html .= $html1;
			$i++;
		}
		if(strlen($html2)>1)
		{
			$image_html .= $html2;
			$i++;
		}
		if(strlen($html3)>1)
		{
			$image_html .= $html3;
			$i++;
		}
		if(strlen($html4)>1)
		{
			$image_html .= $html4;
			$i++;
		}
		if(strlen($html5)>1)
		{
			$image_html .= $html5;
			$i++;
		}
		if(strlen($html6)>1)
		{
			$image_html .= $html6;
			$i++;
		}
		$image_html .= "</center>";
		
		if($i>0)
		{
			$this->_content = $image_html . $this->_content;
		}

		//如果为组图/组文，则添加导航
		$nav_name = $this->getNumberStr($this->_subject_id) . $this->_id . ".imgnav.shtml";
		if( $this->_group_id >0 && empty($this->_image_nav_inc_file_name) && strpos( $this->_content,$nav_name ) == false )
		{
				 $this->_content = substr( $this->_content, 0, strlen( $this->_content )-5 );
				 $this->_content .= "<center></center><!--#include virtual=\"" . $nav_name . "\"--></p>";

		}

		$this->_static_file_dir = substr( $this->_static_file_path, 0, strrpos( $this->_static_file_path ,'/') );
		$this->_remote_static_file_dir = substr( $this->_remote_static_file_path, 0, strrpos( $this->_remote_static_file_path ,'/') );

		//如果从组图/组文中去除，则上传一个空的导航覆盖原来导航
		if( $this->_group_id == 0 || !( file_exists( $this->_static_file_dir . "/" . $nav_name )) )
		{
				$nav_local_file_path = $this->_static_file_dir . "/" . $nav_name;

				$fp = fopen($nav_local_file_path, 'w');
				fclose($fp);
				$nav_remote_file_path = $this->_remote_static_file_dir . "/" . $nav_name;
				$ftp = new FTP(substr($this->_db, 4));
				if(!$ftp->Put($nav_local_file_path, $nav_remote_file_path))
				{

					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . "ftp上传导航失败");
				}
		}

		//将正文更新至文件系统
		if(!empty($this->_content_path))
		{
			$fp = fopen($this->_content_path, 'w');
			if( !empty( $this->_content ) ){
				if(!fwrite($fp, $this->_content))
				{
					fclose($fp);
					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
					return false;
				}
			}
			fclose($fp);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		
		//更新数据库article表
		$update_clause = "update article set
		title = '$this->_title',
		sub_title = '$this->_sub_title',
		create_time = '$this->_create_time',
		channel_id = $this->_channel_id,
		subject_id = $this->_subject_id,
		author = '$this->_author',
		coop_media_id = $this->_coop_media_id,
		media_name = '$this->_media_name',
		area_id = $this->_area_id,
		view_num = $this->_view_num,
		comment_num = $this->_comment_num,
		score = $this->_score,
		user_id = $this->_user_id,
		template_id = $this->_template_id,
		description = '$this->_description',
		visible = $this->_visible,
		keyword = '$this->_keyword',
		mark = $this->_mark,
		content_path = '$this->_content_path',
		special_id = $this->_special_id,
		special_subject_id = $this->_special_subject_id,
		is_multi_special = $this->_is_multi_special,
		rel_blog_path = '$this->_rel_blog_path',
		enable_comment = '$this->_enable_comment',
		enable_ad = '$this->_enable_ad',
		is_rss = '$this->_is_rss',
		static_file_path = '$this->_static_file_path',
		remote_static_file_path = '$this->_remote_static_file_path',
		remote_url = '$this->_remote_url',
		rss_url = '$this->_rss_url',
		group_id = '$this->_group_id' 
		where id=$this->_id
		";
		
		if(!$this->_dao->Update($update_clause))
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。sql=" .$update_clause );
			return false;
		}
		
		//重新排列导航
		if( $this->_group_id > 0 || $this->_ori_group_id > 0 )
		{
			//先更新新的组文/组图导航
			$this->GroupImageAddToNav();
			
			$tmp_group_id = $this->_group_id;

			//再更新旧的组文/组图导航
			$this->_group_id = $this->_ori_group_id;
			$this->GroupImageAddToNav();

			$this->_group_id = $tmp_group_id;
		}

		//更新rel_article_subject表
		$url=$this->_channel_feed_redirect?$this->_remote_url:$this->_rss_url;
		$update_clause = "update rel_article_subject set title='".$this->_title."',subject_id=".$this->_subject_id.",mark=".$this->_mark." where article_id=".$this->_id." and category=0";
		if(!$this->_dao->Update($update_clause))
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		
		//更新相关内容
		if(!$this->UpdateRelContent())
		{
			return false;
		}
		
		$this->Publish();
		return true;
	}
	/**
	* @access public 
	* @abstract  删除本文章
	* @return  bool
	*/
	function Delete()
	{
		if(!empty($this->_id))
		{
			return $this->DeleteByID($this->_id);
		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
	}
	/**
	* @access public
	* @param int $id
	* @abstract  按ID删除文章
	* @return  bool
	*/
	function DeleteByID($id,$channel_name)
	{
		//删除36上的SHTML
		$this->_id = intval($id);
		$del_ftp = "select remote_static_file_path from article where id = $this->_id";
		$this->_row = $this->_dao->GetRow($del_ftp);
		$ftp = new FTP($channel_name);
		$ftp->Delete($this->_row['remote_static_file_path']);

		$delete_rel_clause = "DELETE FROM rel_article_subject WHERE article_id = $id AND category = 0";
		$delete_article_clause = "delete from article where id= $id";
		if(!$this->_dao->Query($delete_article_clause))
		{
			return false;
		}
		if(!$this->_dao->Query($delete_rel_clause))
		{
			return false;
		}
		//删除正文文件
		if((!empty($this->_content_path)) && file_exists($this->_content_path))
		{
			unlink($this->_content_path);
		}
		//删除对应图片
		$del_img = "delete from gallery where article_id='$id'";
		if(!$this->_dao->Query($del_img))
		{
			return false;
		}
		return true;
	}
	/**
	* @access public
	* @abstract  保存文章
	* @return  int
	*/
	function Save()
	{
		$insert_clause = "insert into article set
		title = '$this->_title',
		sub_title = '$this->_sub_title',
		create_time = '$this->_create_time',
		channel_id = $this->_channel_id,
		subject_id = $this->_subject_id,
		author = '$this->_author',
		coop_media_id = $this->_coop_media_id,
		media_name = '$this->_media_name',
		area_id = $this->_area_id,
		view_num = $this->_view_num,
		comment_num = $this->_comment_num,
		score = $this->_score,
		user_id = $this->_user_id,
		template_id = $this->_template_id,
		description = '$this->_description',
		visible = $this->_visible,
		keyword = '$this->_keyword',
		mark = $this->_mark,
		content_path = '$this->_content_path',
		special_id = $this->_special_id,
		special_subject_id = $this->_special_subject_id,
		is_multi_special = $this->_is_multi_special,
		rel_blog_path = '$this->_rel_blog_path',
		enable_comment = '$this->_enable_comment',
		enable_ad = '$this->_enable_ad',
		is_rss = '$this->_is_rss',
		rss_url = '$this->_rss_url',
		group_id = '$this->_group_id',
		auto_redirect = '$this->_auto_redirect'
		";
		if($this->_dao->Insert($insert_clause))
		{
			$this->_id = $this->_dao->LastID();

			$this->_dao->SetCurrentSchema('cms');
			$sql = "update user set cms_article_num = cms_article_num +1 where id = ".$this->_user_id."";
			$this->_dao->Update($sql);

		}
		else
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 文章插入数据库 出错。 sql: $insert_clause");
			return -1;
		}
		//生成内容文件路径
		if(!$this->createContentPath())
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 生成内容路径 出错。");
			return -1;
		}
		//生成相关内容文件路径
		if(!$this->createRelPath())
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 生成博客内容文件 出错。");
			return -1;
		}
		//生成静态化文件路径
		if(!$this->createStaticFilePath())
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 生成静态化文件 出错。");
			return -1;
		}
		if( $this->_group_id )
		{
			$rel_group_id = $this->_group_id;
		}
		else
		{
			$rel_group_id = 1000000 + $this->_id;
		}

		//添加至rel_article_subject
		$datetime = date('YmdHis');
		$url=$this->_channel_feed_redirect?$this->_remote_url:$this->_rss_url;
		$plush_time=date('YmdHis',(($this->_plush_time)*3600)+time());
		$sql = "insert into rel_article_subject set
		article_id = $this->_id,
		subject_id = $this->_subject_id,
		title = '$this->_title',
		url = '$this->_remote_url',
		plush_time=$plush_time,
		category = 0,
		mark = $this->_mark, 
		source = 'cms',
		datetime = '$datetime',
		group_id = '$rel_group_id'
		";
		if(!$this->_dao->Insert($sql))
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。\nsql: $sql");
			
		$this->_rel_id = $this->_dao->LastID();
		
		//更新$_content_path，并将正文内容、相关博客内容写入文件
		if(!$this->Update())
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 更新内容 出错。");
			return -1;
		}
		
		//ping
		if(!$this->_is_uploaded)
		{
			//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 ping tag engine。");
			if(!$this->Ping())
			{
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 ping功能 出错。");
				return -1;
			}
		}
		
		//更新相关内容
		if(!$this->UpdateRelContent())
		{
			return -1;
		}
		
		//发布
		if(!$this->Publish())
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 页面发布 出错。");
			return -1;
		}
		if($this->_is_zip)
		{
			$this->GroupImageInsert();
		}
		
		//如果是组图/组文
		if( $this->_group_id != 0)
		{
			$this->GroupImageAddToNav();
		}
		
		return $this->_id;
	}
	/**
	* @access public
	* @abstract 发布单篇文章页面
	* @return bool
	*/
	function Publish()
	{
		//如果为跳转页面
		if( $this->GetIsRss() ){
			$page = "<html> \n <head> \n <title></title> \n </head> \n <body>";
			$page.= "<script language='javascript'> \n";
			$page.= "location.href='$this->_rss_url' \n";
			$page.=	"</script> \n";
			$page.=	"</body> \n </html> \n";
		}
		else{
		//如果为非跳转页面
			$template_path = "WEB-INF/html/temproot/" . $this->_db . "/include/article.html";
			//$template_path = "WEB-INF/html/templates/article/" . $this->_db . "/default.html";
			if(!file_exists($template_path))
			{
				//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " template_path:" . $template_path);
				$template_path = "templates/article/default/default.html";
			}
			
			$tpl = new SmartTemplate($template_path);
			$arr = array();
			$arr['article_nav'] = $this->createArticleNav();
			$arr['title'] = $this->_title;
			$arr['url'] = $this->_remote_url;
			$arr['create_time'] = substr($this->_create_time, 0, 16);
			$arr['coop_media_name'] = $this->_media_name;
			$arr['author'] = "作者: " . $this->_author;
			$arr['channel_name'] = substr($this->_db, 4);
			$arr['page_id'] =  $this->getNumberStr($this->_subject_id) . $this->_id;

			$content = $this->_content;
			
			//加上广告头尾

			if( $this->GetEnableAd() )
			{
				//广告头开始
				$content_pre = str_replace("　", "", $content);
				$content_arr = split("\n", $content_pre);
				$content_arr_length = count($content_arr);
				$content = "";
				$c = 0;
				for($i=0;$i<$content_arr_length;$i++)
				{
					if(strlen($content_arr[$i])>1)
					{
						$content .= "<p style=\"TEXT-INDENT: 2em\">" . $content_arr[$i] . "</p>\n";
						$c++;
					
						if($c == 2 || ($content_arr_length <= 2 && $c == 1))
						{
							//$content .= '<script type="text/javascript" src="/include/ad.js"></script><script language="javascript">show_huazhonghua();</script>';	
							switch( $this->_channel_id )
							{

							case 25:
								$content .= '<table align="left"><tr><td><!--体育内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 38:
								$content .= '<table align="left"><tr><td><!--访谈内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|talk_sub|talk_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|talk_sub|talk_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|talk_sub|talk_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|talk_sub|talk_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 40:
								$content .= '<table align="left"><tr><td><!--科技内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|tech_sub|tech_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|tech_sub|tech_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|tech_sub|tech_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|tech_sub|tech_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 42:
								$content .= '<table align="left"><tr><td><!--图片中心 - 内页360*300 画中画--><IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|pic_sub|pic_sub_pip&db=bokee&border=0&local=yes"><SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|pic_sub|pic_sub_pip&db=bokee&local=yes&js=on"></SCRIPT><NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|pic_sub|pic_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|pic_sub|pic_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME><!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 48:
								$content .= '<table align="left"><tr><td><!--时尚内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO 		SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|lady_sub|lady_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|lady_sub|lady_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|lady_sub|lady_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|lady_sub|lady_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 49:
								$content .= '<table align="left"><tr><td><!--文化内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|cul_sub|cul_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|cul_sub|cul_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|cul_sub|cul_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|cul_sub|cul_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 50:
								$content .= '<table align="left"><tr><td><!--娱乐内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|ent_sub|ent_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|ent_sub|ent_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|ent_sub|ent_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|ent_sub|ent_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 51:
								$content .= '<table align="left"><tr><td><!--两性内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sex_sub|sex_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sex_sub|sex_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|sex_sub|sex_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sex_sub|sex_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 52:
								$content .= '<table align="left"><tr><td><!--生活内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|life_sub|life_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|life_sub|life_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|life_sub|life_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|life_sub|life_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 53:
								$content .= '<table align="left"><tr><td><!--新知内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|xz_sub|xz_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|xz_sub|xz_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|xz_sub|xz_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|xz_sub|xz_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 54:
								$content .= '<table align="left"><tr><td><!--旅游内页 - 360*300画中画--->
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|travel_sub|travel_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|travel_sub|travel_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|travel_sub|travel_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|travel_sub|travel_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 55:
								$content .= '<table align="left"><tr><td><!--传媒内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|media_sub|media_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|media_sub|media_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|media_sub|media_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|media_sub|media_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 56:
								$content .= '<table align="left"><tr><td><!--音乐内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|music_sub|music_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|music_sub|music_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|music_sub|music_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|music_sub|music_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;
							
							case 57:
								$content .= '<table align="left"><tr><td><!--游戏内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|game_sub|game_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|game_sub|game_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|game_sub|game_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|game_sub|game_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 58:
								$content .= '<table align="left"><tr><td><!--电影内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|movie_sub|movie_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|movie_sub|movie_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|movie_sub|movie_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|movie_sub|movie_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 59:
								$content .= '<table align="left"><tr><td><!--汽车内页 - 360*300画中画--->
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|auto_sub|auto_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|auto_sub|auto_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|auto_sub|auto_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|auto_sub|auto_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 60:
								$content .= '<table align="left"><tr><td><!--财经内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|finance_sub|finance_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|finance_sub|finance_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|finance_sub|finance_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|finance_sub|finance_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 61:
								$content .= '<table align="left"><tr><td><!--通信内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|tele_sub|tele_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|tele_sub|tele_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|tele_sub|tele_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|tele_sub|tele_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 62:
								$content .= '<table align="left"><tr><td><!--房产内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|house_sub|house_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|house_sub|house_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|house_sub|house_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|house_sub|house_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 63:
								$content .= '<table align="left"><tr><td><!--数码频道 - 内页360*300 画中画--><IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|digi_sub|digi_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|digi_sub|digi_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|digi_sub|digi_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|digi_sub|digi_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 65:
								$content .= '<table align="left"><tr><td><!--教育内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|edu_sub|edu_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|edu_sub|edu_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|edu_sub|edu_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|edu_sub|edu_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 66:
								$content .= '<table align="left"><tr><td><!--专栏内页 - 360*300画中画--->	
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|column_sub|column_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|column_sub|column_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|column_sub|column_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|column_sub|column_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 71:
								$content .= '<table align="left"><tr><td><!--手机内页 - 360*300画中画--->
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|mobile_sub|mobile_sub_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|mobile_sub|mobile_sub_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|mobile_sub|mobile_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|mobile_sub|mobile_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							case 74:
								$content .= '<table align="left"><tr><td><!--资讯文章页 - 360*300画中画--->
								<IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|news_article|news_article_pip&db=bokee&border=0&local=yes">
								<SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|news_article|news_article_pip&db=bokee&local=yes&js=on"></SCRIPT>
								<NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|news_article|news_article_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|news_article|news_article_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME>
								<!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;

							default:
								$content .= '<table align="left"><tr><td><!--Adforward Begin:--><!--体育内页 - 360*300 画中画--><IFRAME MARGINHEIGHT=0 MARGINWIDTH=0 FRAMEBORDER=0 WIDTH=360 HEIGHT=300 SCROLLING=NO SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee&border=0&local=yes"><SCRIPT LANGUAGE="JavaScript1.1" SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee&local=yes&js=on"></SCRIPT><NOSCRIPT><A HREF="http://bokee.allyes.com/main/adfclick?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee"><IMG SRC="http://bokee.allyes.com/main/adfshow?user=BokeeNetwork|sports_sub|sports_sub_pip&db=bokee" WIDTH=360 HEIGHT=300 BORDER=0></a></NOSCRIPT></IFRAME><!--Adforward End--></td></tr>
								<tr>
								 <script language="javascript1.1" src="http://adimage.bokee.com/images/static/pip_all_4wenzi.utf-8.php"></script>
								</tr>
								</table>' . "\n";
								break;
							}
						}
					}
				}
				//广告头结束

				//广告尾开始
				$keywords = split(" ", $this->GetKeyword());
				$keywords_num = count($keywords);
				$tag = "<p style=\"TEXT-INDENT: 2em;clear:both;\">Tag: ";
				for($i=0;$i<$keywords_num;$i++)
				{
					$tag .= " <a href=http://tag.bokee.com/tag/" . urlencode(mb_convert_encoding($keywords[$i], 'GBK', 'UTF-8')) . ">" . $keywords[$i] . "</a> ";
				}
				$tag .="</p>\n";
				$content .= $tag;
				//广告尾结束
			}
			//加上广告头尾结束
			
			$arr['content'] = $content;
			$arr['description'] = $this->_description;
			$arr['rel_blog_content'] = $this->_rel_blog_content;
			$arr['rel_cms_content'] = $this->_rel_cms_content;
			$arr['rel_rss_content'] = $this->_rel_rss_content;
			//article_id仅用于评论功能，发表组图时使用同一id
			if($this->_is_uploaded)
			{
				$arr['article_id'] = $this->_group_image_start_article_id;
			}
			else 
			{
				$arr['article_id'] = $this->_id;
			}
			$arr['article_dir'] = floor($this->_id/1000);
			$arr['channel_id'] = $this->_channel_id;
			$tpl->assign($arr);
			$page = $tpl->result();
		}

		if(strlen($page)==0)
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 生成静态文件 出错。");
			return false;
		}

		$fp = fopen($this->_static_file_path, 'w');
		fwrite($fp, $page);
		fclose($fp);
		
		$ftp = new FTP(substr($this->_db, 4));
		if(!$ftp)
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		if(!$ftp->Put($this->_static_file_path, $this->_remote_static_file_path)) 
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。" . $this->_static_file_path . $this->_remote_static_file_path);
			return false;
		}
		
		return true;
	}
	
	/**
	* @abstract 获取文章导航
	* @access private
	*/
	function createArticleNav()
	{
		$subject = new Subject($this->_db);
		$subject->GetByID($this->_subject_id);
		$level = $subject->GetSort();
		for($i=0;$i<$level;$i++)
		{
			$subjects[$i]['dir_name'] = $subject->GetDirName();
			$subjects[$i]['name'] = $subject->GetName();
			$subject->GetByID($subject->GetParentId());
		}
			
		$dir_name = substr($this->_db, 4);
		
		$channel = new Channel();
		$channel->GetByDirName($dir_name);
		$channel_name = $channel->GetName();
		
		$nav_str = "<a href=http://www." . DOMAIN . ">博客网</a> > <a href=http://" . $dir_name . "." . DOMAIN . ">" . $channel_name . "</a>";
		$path = "";
		for($i=$level-1;$i>=0;$i--)
		{
			$path .= $subjects[$i]['dir_name'] . "/";
			$nav_str .=" > <a href=http://" . $dir_name . "." . DOMAIN . "/" . $path . ">" . $subjects[$i]['name'] . "</a>";
		}
		return $nav_str;
	}

	/**
	* @access private
	* @abstract 创建文章静态化路径，创建不存在的目录，包括图片目录
	* @return book
	*/
	function createStaticFilePath()
	{
		if($this->_id)
		{
			$dir = PATH_HTML_ROOT . "/" . $this->_db;	//本机路径
			$image_dir = PATH_IMAGES . "/" . $this->_db;	//本机路径
			$remote_dir = "/html/" . $this->_db;	//服务器路径
			
			if($this->_db == 'cms_blog')
				$url_dir = "http://blogs." . DOMAIN; 	//url
			elseif($this->_db == 'cms_piccenter')
				$url_dir = "http://pic." . DOMAIN;
			else
				$url_dir = "http://" . str_replace('cms_', '', $this->_db) . "." . DOMAIN; 	//url
			
			if(!is_dir($dir))
			{
				mkdir($dir, 0700);
			}
			if(!is_dir($image_dir))
			{
				mkdir($image_dir, 0700);
			}
			
			//获取栏目路径
			$subject = new Subject($this->_db);
			$subject->GetByID($this->_subject_id);
			$level = $subject->GetSort();
			for($i=0;$i<$level;$i++)
			{
				$subjects[$i] = $subject->GetDirName();
				$subject->GetByID($subject->GetParentId());
			}

			$this->_subject_dir = "";
			for($i=$level-1;$i>=0;$i--)
			{
				//Log::Append($this->_subject_dir);
				$this->_subject_dir .= "/" . $subjects[$i];
				if(!is_dir($dir.$this->_subject_dir))
				{
					mkdir($dir.$this->_subject_dir, 0700);
				}
				if(!is_dir($image_dir.$this->_subject_dir))
				{
					mkdir($image_dir.$this->_subject_dir, 0700);
				}
			}

			$dir .= $this->_subject_dir . "/" . date("Y-m-d");
			$image_dir .= $this->_subject_dir . "/" . date("Y-m-d");
			$remote_dir .= $this->_subject_dir . "/" . date("Y-m-d");
			$url_dir .= $this->_subject_dir . "/" . date("Y-m-d");
			if(!is_dir($dir))
			{
				mkdir($dir, 0700);
			}
			if(!is_dir($image_dir))
			{
				mkdir($image_dir, 0700);
			}
			$this->_static_file_dir = $dir;
			$this->_static_file_path = $dir . "/" . $this->getNumberStr($this->_subject_id) . $this->_id . ".shtml";
			$this->_remote_static_file_dir = $remote_dir;
			$this->_remote_static_file_path = $remote_dir . "/" . $this->getNumberStr($this->_subject_id) . $this->_id . ".shtml";
			$this->_remote_url = $url_dir . "/" . $this->getNumberStr($this->_subject_id) . $this->_id . ".shtml";
			
			if($this->_is_rss == 'Y')
			{
				//如果发表的文章是跳转url，
		//		$this->_remote_url = $this->_rss_url;
			}
			return true;
		}
		return false;
	}
	
	/**
	* @access private
	* @param int $number
	* @return string
	*/
	function getNumberStr($number)
	{
		return ($number<10)?'0'.$number:$number;
	}

	/**
	* @access  private
	* @abstract  获取文章正文存储路径
	* @return bool
	*/
	function createContentPath()
	{
		if($this->_id)
		{
			$dir = PATH_MODULE . "/content/" . $this->_db;
			if(!is_dir($dir))
			{
				mkdir($dir, 0700);
			}
			$dir .= "/" . date("Y-m-d");
			if(!is_dir($dir))
			{
				mkdir($dir, 0700);
			}
			$this->_content_path = $dir . "/" . $this->_id . ".txt";

			return true;
		}
		return false;
	}
	/**
	* @access  private
	* @abstract  获取相关博客文章链接存储路径
	* @return  bool
	*/
	function createRelPath()
	{
		if($this->_id)
		{
			$dir = PATH_MODULE . "/content/" . $this->_db;
			if(!is_dir($dir))
			{
				mkdir($dir, 0700);
			}
			$dir .= "/" . date("Y-m-d");
			if(!is_dir($dir))
			{
				mkdir($dir, 0700);
			}
			$this->_rel_blog_path = $dir . "/" . $this->_id . "rel_blog.txt";
			$this->_rel_cms_path = $dir . "/" . $this->_id . "rel_cms.txt";
			$this->_rel_rss_path = $dir . "/" . $this->_id . "rel_rss.txt";
			return true;
		}
		return false;
	}
	
	/**
	* @access public
	* @abstract Ping 搜索引擎，并取得相关记录
	* @return bool
	*/
	function Ping()
	{
        $dir_name = substr($this->_db, 4);
		$channel = new Channel();
		$channel->GetByDirName($dir_name);
		$channel_name = $channel->GetName();
		
		$patterns[0] = "/&\w+?;/";
        $patterns[1] = "/&#\w+?;/";
        $patterns[2] = "/<.+?>/";
        $patterns[3] = "/'/";
        $patterns[4] = "/\"/";
        $patterns[5] = "/\?/";
        $patterns[6] = "/\+/";
        $patterns[7] = "/\-/";
        $patterns[8] = "/\-/";
        $patterns[9] = "/\!/";
        $patterns[10] = "/#/";
        $patterns[11] = "/\$/";
        $patterns[12] = "/\^/";
        $patterns[13] = "/\(/";
        $patterns[14] = "/\)/";
        $patterns[15] = "/\{/";
        $patterns[16] = "/\}/";
        $patterns[17] = "/\:/";
		
		$data = "<?xml version='1.0' encoding='utf-8'?>";
		$data .= "<methodCall>";
		$data .= "<methodName>bokee.6e</methodName>";
		$data .= "<channeltitle><![CDATA[" . $channel_name .  "]]></channeltitle>";
		$data .= "<channellink><![CDATA[http://" . $dir_name .  "." . DOMAIN . "]]></channellink>";
		$data .= "<link><![CDATA[" . $this->_remote_url .  "]]></link>";
		$data .= "<title><![CDATA[" . preg_replace($patterns, "", $this->_title) . "]]></title>";
		$data .= "<excerpt><![CDATA[" . preg_replace($patterns, "", $this->_description) . "]]></excerpt>";
		$data .= "<author><![CDATA[" . $this->_author . "]]></author>";
		//$data .= "<category><![CDATA[" . $this->_channel_name . "]]></category>";
		$data .= "<category>cms</category>";
		$data .= "<datetime><![CDATA[" . date('Y-m-d H:i:s') . "]]></datetime>";
		$data .= "<tags>";
		
		$keywords = split(" ", $this->_keyword);
		$keywords_num = count($keywords);
		for($i=0;$i<$keywords_num;$i++)
		{
			$data .= "<item><![CDATA[" . $keywords[$i] . "]]></item>";
		}
		
		$data .= "</tags>";
		$data .= "</methodCall>";
		$ori_data = $data;
		//$data = mb_convert_encoding($data, "GBK", "UTF-8");
		
        $data = urlencode($data);
        $data = "xml=" . $data;

        $url="http://tag.bokee.com/XMLServer.b";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
		#curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec ($ch); # This returns HTML
		curl_close ($ch); 
		
		$xmlstr = mb_convert_encoding($content, 'UTF-8', 'GBK');
		
		$parser = xml_parser_create('UTF-8');
		xml_parse_into_struct($parser, $xmlstr, $vals, $index);
		xml_parser_free($parser);

		$item_num = count($index['TITLE']);
		$html = "";
		$html_cms = "";
		$html_rss = "";
		for($i=0;$i<$item_num;$i++)
		{
			switch($vals[$index['CATEGORY'][$i]]['value'])
			{
				case 'rss':
				if(strpos($html_rss, $vals[$index['TITLE'][$i]]['value']) === false)
				{
					$html_rss .= "<li><a href=" . $vals[$index['LINK'][$i]]['value'] . ">" . $vals[$index['TITLE'][$i]]['value'] . "</a> (<font color=gray>" . substr($vals[$index['DATETIME'][$i]]['value'], 0, strlen($vals[$index['DATETIME'][$i]]['value'])-2) . "</font>) </li>\n";
				}
				break;
				case 'cms':
				if(strpos($html_cms, $vals[$index['TITLE'][$i]]['value']) === false)
				{
					$html_cms .= "<li><a href=" . $vals[$index['LINK'][$i]]['value'] . ">" . $vals[$index['TITLE'][$i]]['value'] . "</a> (<font color=gray>" . substr($vals[$index['DATETIME'][$i]]['value'], 0, strlen($vals[$index['DATETIME'][$i]]['value'])-2) . "</font>) </li>\n";
				}
				break;
				case 'blog':
				default:
				if(strpos($html, $vals[$index['TITLE'][$i]]['value']) === false)
				{
					$html .= "<li><a href=" . $vals[$index['LINK'][$i]]['value'] . ">" . $vals[$index['TITLE'][$i]]['value'] . "</a> (<font color=gray>" . substr($vals[$index['DATETIME'][$i]]['value'], 0, strlen($vals[$index['DATETIME'][$i]]['value'])-2) . "</font>) </li>\n";
				}
				break;
			}
		}
		
		$this->_rel_blog_content = "<ul>" . $html . "</ul>";
		$this->_rel_cms_content = "<ul>" . $html_cms . "</ul>";
		$this->_rel_rss_content = "<ul>" . $html_rss . "</ul>";

		//$this->_rel_blog_content = $xmlstr . print_r($vals, true) . print_r($index, true);
		
		//ping 评论服务器
		$title = urlencode($this->_title);
		$link = urlencode($this->_remote_url);
		$url = 'http://ccomment.' . DOMAIN . '/comment/admin.php?cat_id=' . $this->_channel_id . '&index_id=' . $this->_id . '&title=' . $title . '&link=' . $link;
		$client = new Snoopy();
		$client->agent = 'Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)';
		$client->read_timeout = 15;
		$client->use_gzip = false;
		
		$client->fetch($url);
//		if($client->results != "ok")
//		{
//			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 ping评论服务器 出错。");
//			return false;
//		}
        return true;
	}
	
	/**
	* @abstract zip包组图复制添加文章
	*/
	function GroupImageInsert()
	{
		$this->_title = $this->_group_image_title;
		$file_num = count($this->_images_file_name);
		$date = date('Y-m-d');
		$path = "/" . str_replace('cms_', '', $this->_db) . $this->_subject_dir."/".$date;
		$small_path = "/" . str_replace('cms_', '', $this->_db) . $this->_subject_dir."/s/".$date;
		$url = array();
		$id[] = $this->_id;
		$url[] = $this->_remote_url;
		for($i=1;$i<$file_num;$i++)
		{
			$article = $this->Duplicate();
			$article->SetIsUploaded(true);
			$article->SetGroupImageStartArticleID($this->_id);
			
			
			//从描述识别相应的文件名称
			$desc_num = count($this->_group_image_descs);
			for($j=0;$j<$desc_num;$j++)
			{
				if(substr($this->_group_image_descs[$i], 0, strpos($this->_group_image_descs[$i], '::'))==$this->_images_file_name[$j]['ori_name'])
				{
					$file_desc['description'] = substr($this->_group_image_descs[$i], strpos($this->_group_image_descs[$i], '::')+2);
					$file_desc['url'] = "http://images." . DOMAIN . $path . "/" . $this->_images_file_name[$j]['new_name'];
					$file_desc['small_url'] = "http://images." . DOMAIN . $small_path . "/" . $this->_images_file_name[$j]['small_name'];
					break;
				}
			}
			/*
			//从文件名称识别对应的文字描述
			$desc_num = count($this->_group_image_descs);
			for($j=0;$j<$desc_num;$j++)
			{
				if(substr($this->_group_image_descs[$j], 0, strpos($this->_group_image_descs[$j], ':'))==$this->_images_file_name[$i]['ori_name'])
				{
					$file_desc['description'] = substr($this->_group_image_descs[$j], strpos($this->_group_image_descs[$j], ':')+1);
					break;
				}
			}
			*/

			$article->SetTitle($this->_title . " " . $this->h_substr( $file_desc['description'],40 ) );
			$article->SetFiles($file_desc);
			//已经改为自动计算，使用各自文章ID而非统一ID
			//$article->SetImageNavIncFileName($this->_image_nav_inc_file_name);
			$aid = $article->Save();
			if( $aid < 1)
			{
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 插入新文章 出错。");
			}
			$id[] = $aid;
			$url[] = $article->GetRemoteURL();
		}
		//写入导航，由于有上一页下一页，所以每篇文章的导航都不相同
		for($c=0;$c<$file_num;$c++)
		{
			$nav = "<div class=article_nav>";
			if($c>0)
			{
				$nav .="[ <a href=" . $url[$c-1] . " target='_self'>上一篇</a> ]";
			}
			for($i=0;$i<$file_num;$i++)
			{
				if($i==$c)
				{
					$nav .= " <font color=red>" . ($i+1) . "</font> ";
				}
				else 
				{
					$nav .= " <a href=" . $url[$i] . " target='_self'>" . ($i+1) . "</a> ";
				}
			}
			if($c<$file_num-1)
			{
				$nav .="[ <a href=" . $url[$c+1] . " target='_self'>下一篇</a> ]";
			}
			$nav .="</div>";

			//自动跳转代码
			if( $this->_auto_redirect )
			{
				$auto_nav = "<form name='form1' id='form1'>选择自动翻页速度 <select name='change_cookie_time' id='change_cookie_time' onChange='ChangeCookie(this)'></select></form>";
				$auto_nav.=	"<script language='javascript'>";

				$auto_nav.= "function SetCookie(cookieName,cookieValue,nDays) { \n";
				$auto_nav.= "var today = new Date(); \n";
				$auto_nav.= "var expire = new Date(); \n";
				$auto_nav.= "if (nDays==null || nDays==0) nDays=1; \n";
				$auto_nav.= "expire.setTime(today.getTime() + 3600000*24*nDays); \n";
				$auto_nav.= "document.cookie = cookieName+'='+escape(cookieValue)+ ';expires='+expire.toGMTString(); }\n";
				$auto_nav.= "function GetCookie(name){ \n";
				$auto_nav.= "var result=null; \n";
				$auto_nav.= "var myCookie=' '+document.cookie+';'; \n";
				$auto_nav.= "var searchName=' '+name+'='; \n";
				$auto_nav.= "var startOfCookie=myCookie.indexOf(searchName); \n";
				$auto_nav.= "var endOfCookie; \n";
				$auto_nav.= "if(startOfCookie!=-1){ \n";
				$auto_nav.= "startOfCookie+=searchName.length; \n";
				$auto_nav.= "endOfCookie=myCookie.indexOf(';',startOfCookie); \n";
				$auto_nav.= "result=unescape(myCookie.substring(startOfCookie,endOfCookie)); \n";
				$auto_nav.= "} \n";
				$auto_nav.= "return result; \n";
				$auto_nav.= "} \n";
				$auto_nav.= "function Jump(){location.href=next_url;} \n";
				$auto_nav.= "function ChangeCookie(a){SetCookie( 'step',a.value ); } \n";
				$auto_nav.= "function createOption(value,text,selected_value){ \n";
				$auto_nav.= "var newOpt	= document.createElement('OPTION'); \n";
				$auto_nav.= "newOpt.setAttribute('value',value); \n";
				$auto_nav.= "newOpt.innerHTML = text; \n";
				$auto_nav.= "if( value == selected_value ) \n";
				$auto_nav.= "newOpt.setAttribute('selected',true); \n";
				$auto_nav.= "document.form1.change_cookie_time.appendChild(newOpt);} \n";
				$auto_nav.= "var step = GetCookie('step'); \n";
				$auto_nav.= "if( step == null || step == '' ) \n";
				$auto_nav.= "{SetCookie('step',10000);step = 10000;} \n";

				$auto_nav.= "var steps	= new Array();";
				$auto_nav.= "steps[0] = 5; steps[1] = 10; steps[2] = 20; steps[3] = 30;";
				$auto_nav.= "for(m in steps){createOption(steps[m]*1000,steps[m]+'秒',step);}";
				$auto_nav.= "window.setTimeout( 'Jump()',step );";
				if( $c == $file_num-1 )
					$auto_nav.= "var next_url='" . $url[0] . "';";
				else
					$auto_nav.= "var next_url='" . $url[$c+1] . "';";
				$auto_nav .= "</script>";
				$nav = $auto_nav.$nav;
			}

			$nav_local_file_path = $this->_static_file_dir . "/" . $this->getNumberStr($this->_subject_id) . $id[$c] . ".imgnav.shtml";
			$nav_remote_file_path = $this->_remote_static_file_dir . "/" . $this->getNumberStr($this->_subject_id) . $id[$c] . ".imgnav.shtml";
			$fp = fopen($nav_local_file_path, 'w');
			fwrite($fp, $nav);
			fclose($fp);
			$ftp = new FTP(substr($this->_db, 4));
			if(!$ftp->Put($nav_local_file_path, $nav_remote_file_path))
			{
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传图片导航文章 出错。");
			}
		}
	}
		
	/**
	* @截取字符串
	*/
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
			
			return mb_convert_encoding( join("",array_slice($ar[0],0,$flag))."" ,"UTF-8",'GBK' ) ;
		}
	}


	/**
	* @abstract 非zip包组图/组文复制添加
	*/
	function GroupImageAddToNav()
	{
		
		if( $this->_group_id != 0 )
		{
			//查询该组内所有文章
			$sql = "select id,remote_url from article where group_id = $this->_group_id order by id";

			$dao = DAO::CreateInstance();
			$dao->SetCurrentSchema($this->_db);
			$rows = $dao->GetPlan( $sql );
		
			//如果之前不存在，则建立一个新文件
			if( $this->_dao->CountAffectedRows() ==0 )
			{
				$nav_local_file_path = $this->_static_file_dir . "/" . $this->getNumberStr($this->_subject_id) . $this->_id . ".imgnav.shtml";
				$fp = fopen($nav_local_file_path, 'w');
				fclose($fp);
			}

			//遍历文章
			for( $i=0;$i<count($rows);$i++ )
			{
				$nav = "<div class=article_nav>";
				if($i>0)
				{
					$nav .="[ <a href=" . $rows[$i-1]['remote_url'] . " target='_self'>上一篇</a> ]";
				}
				for($j=0;$j<count($rows);$j++)
				{
					if($i==$j)
					{
						$nav .= " <font color=red>" . ($j+1) . "</font> ";
					}
					else 
					{
						$nav .= " <a href=" . $rows[$j]['remote_url'] . " target='_self'>" . ($j+1) . "</a> ";
					}
				}
				if($i<count($rows)-1)
				{
					$nav .="[ <a href=" . $rows[$i+1]['remote_url'] . " target='_self'>下一篇</a> ]";
				}
				$nav .="</div>";
				
				//自动跳转代码
				if( $this->_auto_redirect )
				{
					$auto_nav = "<form name='form1' id='form1'><center>选择自动翻页速度 <select name='change_cookie_time' id='change_cookie_time' onChange='ChangeCookie(this)'></select></center></form>";
					$auto_nav.=	"<script language='javascript'>";

					$auto_nav.= "function SetCookie(cookieName,cookieValue,nDays) { \n";
					$auto_nav.= "var today = new Date(); \n";
					$auto_nav.= "var expire = new Date(); \n";
					$auto_nav.= "if (nDays==null || nDays==0) nDays=1; \n";
					$auto_nav.= "expire.setTime(today.getTime() + 3600000*24*nDays); \n";
					$auto_nav.= "document.cookie = cookieName+'='+escape(cookieValue)+ ';expires='+expire.toGMTString(); }\n";
					$auto_nav.= "function GetCookie(name){ \n";
					$auto_nav.= "var result=null; \n";
					$auto_nav.= "var myCookie=' '+document.cookie+';'; \n";
					$auto_nav.= "var searchName=' '+name+'='; \n";
					$auto_nav.= "var startOfCookie=myCookie.indexOf(searchName); \n";
					$auto_nav.= "var endOfCookie; \n";
					$auto_nav.= "if(startOfCookie!=-1){ \n";
					$auto_nav.= "startOfCookie+=searchName.length; \n";
					$auto_nav.= "endOfCookie=myCookie.indexOf(';',startOfCookie); \n";
					$auto_nav.= "result=unescape(myCookie.substring(startOfCookie,endOfCookie)); \n";
					$auto_nav.= "} \n";
					$auto_nav.= "return result; \n";
					$auto_nav.= "} \n";
					$auto_nav.= "function Jump(){location.href=next_url;} \n";
					$auto_nav.= "function ChangeCookie(a){SetCookie( 'step',a.value ); } \n";
					$auto_nav.= "function createOption(value,text,selected_value){ \n";
					$auto_nav.= "var newOpt	= document.createElement('OPTION'); \n";
					$auto_nav.= "newOpt.setAttribute('value',value); \n";
					$auto_nav.= "newOpt.innerHTML = text; \n";
					$auto_nav.= "if( value == selected_value ) \n";
					$auto_nav.= "newOpt.setAttribute('selected',true); \n";
					$auto_nav.= "document.form1.change_cookie_time.appendChild(newOpt);} \n";
					$auto_nav.= "var step = GetCookie('step'); \n";
					$auto_nav.= "if( step == null || step == '' ) \n";
					$auto_nav.= "{SetCookie('step',60000);step = 60000;} \n";

					$auto_nav.= "var steps	= new Array();";
					$auto_nav.= "steps[0] = 5; steps[1] = 10; steps[2] = 20; steps[3] = 30;steps[4] = 60;";
					$auto_nav.= "for(m in steps){createOption(steps[m]*1000,steps[m]+'秒',step);}";
					$auto_nav.= "window.setTimeout( 'Jump()',step );";
					if( $i == count($rows)-1 )
						$auto_nav.= "var next_url='" . $rows[0]['remote_url'] . "';";
					else
						$auto_nav.= "var next_url='" . $rows[$i+1]['remote_url'] . "';";
					$auto_nav .= "</script>";
					$nav = $auto_nav.$nav;

				}

				$nav_local_file_path = $this->_static_file_dir . "/" . $this->getNumberStr($this->_subject_id) . $rows[$i]['id'] . ".imgnav.shtml";
				
				$nav_remote_file_path = $this->_remote_static_file_dir . "/" . $this->getNumberStr($this->_subject_id) . $rows[$i]['id'] . ".imgnav.shtml";

				$fp = fopen($nav_local_file_path, 'w');
				fwrite($fp, $nav);
				fclose($fp);

				$ftp = new FTP(substr($this->_db, 4));
				if(!$ftp->Put($nav_local_file_path, $nav_remote_file_path))
				{
					Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP上传图片导航文章 出错。");
				}
				
			}			
					
			$sql_update = "update article set auto_redirect = '".$this->_auto_redirect ."' where group_id=" . $this->_group_id;
			if(!$dao->Update($sql_update))
			{
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行更新article表auto_redirect字段失败。");
			}
		}
	}
	
	/**
	* @abstract 使用当前对象实例化一个新的对象
	*/
	function Duplicate()
	{
		$a = new Article($this->_db);
		$a->SetTitle($this->_title);
		$a->SetSubTitle($this->_sub_title);
		$a->SetAuthor($this->_author);
		$a->SetSubjectId($this->_subject_id);
		$a->SetCoopMediaId($this->_coop_media_id);
		$a->SetMediaName($this->_media_name);
		$a->SetUserId($this->_user_id);
		$a->SetDescription($this->_description);
		$a->SetKeyword($this->_keyword);
		$a->SetVisible($this->_visible);
		$a->SetMark($this->_mark);
		$a->SetSpecialId($this->_special_id);
		$a->SetSpecialSubjectId($this->_special_subject_id);
		$a->SetIsMultiSpecial($this->_is_multi_special);
		$a->SetEnableAd($this->_enable_ad);
		$a->SetEnableComment($this->_enable_comment);
		$a->SetContent($this->_content);
		$a->SetRelBlogContent($this->_rel_blog_content);
		$a->SetRelCMSContent($this->_rel_cms_content);
		$a->SetRelRSSContent($this->_rel_rss_content);
		$a->SetGroupID($this->_group_id);
		$a->SetAutoRedirect($this->_auto_redirect);
		return $a;
	}
	
	function AddIntoGallery($title, $desc, $path)
	{
		$gallery = new Gallery($this->_db);
		$gallery->SetName($title);
		$gallery->SetDescription($desc);
		$gallery->SetSubjectId($this->_subject_id);
		$gallery->SetPath($path);
		$gallery->SetUrl($this->_remote_url);
		$gallery->SetArticleId($this->_id);

		$group_id = $this->_group_id;
		if( empty( $group_id ) )
		{
			$group_id = 0;
		}
		$gallery->SetGroupID($group_id);

		$gallery->SetUserId($this->_user_id);
		$gallery->SetCategory(1);	//cms文章中附带缩略图category值为1
		return $gallery->Insert();
	}
}
?>