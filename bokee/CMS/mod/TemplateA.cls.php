<?php
//Now I have a test template named idea.htm which is located at "./toliutao" in my path.
//many functions need combine with block class


require_once('sql/DAO.cls.php');
require_once('mod/Block.cls.php');
require_once('com/Log.cls.php');
require_once('mod/Subject.cls.php');
require_once('com/FTP.cls.php');

class TemplateA
{
	var $_id;	//模板ID
	var $_db;	//数据库名称
	var $_row;	//本模板所对应的行
	var $_dao;	//数据库连接
	
	var $_special_id;
	var $_subject_id;
	var $_special_subject_id;
	var $_name;
	var $_path;
	var $_file_name;
	var $_sort;
	var $_is_default;
	var $_content;
	var $_default_template;
	var $_is_more;
	var $_cur_page_num=0;
	var $_row_subjectid;
	
	
	/**
	@abstract 构造函数
	*/
	function TemplateA($db)	
	{
		$this->_db = $db;
		$this->_dao = DAO::CreateInstance();
		$this->_dao->assoc = true;
		$this->_dao->SetCurrentSchema($this->_db);
	}

	/**
	@abstract 根据ID获取模板
	*/
	function GetTemplateBySubjectid($subject_id)
	{
		$sql = "SELECT * FROM template WHERE subject_id = ".$subject_id;
		$this->_row_subjectid = $this->_dao->GetRow($sql);
	}

	function GetTemplateById($id)
	{
		$this->_id = intval($id);
		$sql = "SELECT * FROM template WHERE id = ".$this->_id;

		$this->_row = $this->_dao->GetRow($sql);
		if(!$this->_row)
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。" . $sql);
			return false;
		}
		$this->InitUseRow();
		return true;
	}
	
	/**
	* @abstract 使用$this->_row进行初始化
	* @access public
	*/
	function InitUseRow()
	{
		if(!$this->_row)
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		$this->_special_id = $this->_row['special_id'];
		$this->_subject_id = $this->_row['subject_id'];
		$this->_special_subject_id = $this->_row['special_subject_id'];
		$this->_name = $this->_row['name'];
		$this->_path = $this->_row['path'];
		$this->_file_name = $this->_row['file_name'];
		$this->_sort = $this->_row['sort'];
		$this->_default_template = $this->_row['is_default'];
		$this->_is_more = $this->_row['is_more'];
		$this->_cur_page_num = $this->_row['cur_page_num'];
		
		if(!file_exists($this->_path))
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。".$this->_path);
			return false;
		}
		$this->_content = file_get_contents($this->_path);
		$this->_row['content'] = $this->_content;
		return true;
	}

	/**
	* @access public
	* @abstract 添加模板
	*/
	function Add()
	{
		$insert_clause = "insert into template set 
			name = '$this->_name',
			file_name = '$this->_file_name',
			subject_id = $this->_subject_id,
			is_default ='$this->_default_template',
			is_more = '$this->_is_more',
			cur_page_num = '$this->_cur_page_num'
			";
		if($this->_dao->Insert($insert_clause))
		{
			$this->_id = $this->_dao->LastID();
		}
		else
		{
			die($insert_clause);
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return -1;
		}
		$this->_path = PATH_TEMPLATE . "/" . $this->_db . "/" . $this->_id . ".html";

		if(!file_exists(PATH_TEMPLATE . "/" . $this->_db))
			mkdir(PATH_TEMPLATE . "/" . $this->_db);
		if($fp = fopen($this->_path, 'w'))
		{
			fwrite($fp, $this->_content);
		}
		else
		{
			die("error");
		}
		fclose($fp);
		
		if(!$this->Update())
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return -1;
		}
		
		return $this->_id;
	}
	
	/** 
	* @access public
	* @abstract 更新模板
	*/
	function Update()
	{
		    $update_clause = "update template set 
			name = '$this->_name',
			file_name = '$this->_file_name',
			subject_id= $this->_subject_id,
			path = '$this->_path',
			is_default = '$this->_default_template',
			is_more = '$this->_is_more',
			cur_page_num = '$this->_cur_page_num' 
			where id=$this->_id
			";
		if(!$this->_dao->Update($update_clause))
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		
		$fp = fopen($this->_path, 'w');
		if(!$fp)
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		fwrite($fp, $this->_content);
		fclose($fp);
		return true;
	}

		/**
	* @access public
	* @abstract 添加	*/
	function AddBlock()
	{
	    $source_arr = $this->_source;
        $source_num = count($source_arr);
        $source = "";
        for($i=0;$i<$source_num;$i++)
        {
        	$source .= "'" . $source_arr[$i] . "',";
        }
        $source = substr($source, 0, strlen($source)-1);
        $mark = 1;
		$format = "<item>";
        $format .= "<title>{title}</title>"; 
        $format .= "<link>{url}</link>"; 
        $format .= "<author>www." . DOMAIN . "</author>";
        $format .= "<pubDate>{datetime4}</pubDate>";
        $format .= "<category>{subject}</category>"; 
        $format .= "</item>  ";
        $subject = new Subject($this->_db);
        
		$subject_str = " and subject_id in (" . $subject->GetSubjectIdStr($this->_subject_id) .  ")";
		Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近：" . $subject_str . "\n" . $this->_subject_id);
//		$content = "select * from rel_article_subject where $subject_str group by article_id order by datetime desc limit " . $this->_limit;
		$content = "select * from rel_article_subject where source in (" . $source . ") $subject_str and  mark>=" . $mark . " group by article_id order by datetime desc limit " . $this->_limit;
		
        $sql = "insert into template_block (subject_id, name, source, num, format, content, selected_subject_id) values($this->_subject_id, '$this->_name', \"" . $source . "\", $this->_limit, '$format', \"" . $content . "\" , $this->_subject_id)";    
        Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近：" . $content . "\n" . $this->_subject_id);
        if($this->_dao->Insert($sql))
		{
			$this->_block_id = $this->_dao->LastID();
		}
		return $this->_block_id;
	}
	
		/**
	* @access public
	* @abstract 添加	*/
	function Addslash()
	{   
		$pathrule = $this->GetLPathRule($this->_subject_id);
        $subject_id = empty($this->_subject_id)?0:$this->_subject_id;
        $sql = "select name from subject where id=" . $subject_id;
		$row = $this->_dao->GetRow($sql);
        $special_id = empty($this->_special_id)?0:$this->_special_id;
        $special_subject_id = empty($this->_special_subject_id)?0:$this->_special_subject_id;
        $datet=date ("Y-m-d H:i:s" ,time());
        $rep_content = "<item></item>";
        $content =  "<"."?xml version=\"1.0\" encoding=\"utf-8\"?>";
        $content .= "<rss version=\"2.0\">";
        $content .= "<channel>";
        $content .= "<title>".$row[name]."</title>"; 
        $content .= "<link>".$pathrule."</link>"; 
        $content .= "<language>zh-cn</language>"; 
        $content .= "<generator>WWW." . DOMAIN . "</generator>";
        $content .= "<copyright>Copyright 2002 - 2005 " . DOMAIN . ", All Rights Reserved</copyright>";        
        $content .= "<pubDate>".$datet."</pubDate>";
        $content .= "[[##]]";
        $content .= "</channel>";
        $content .= "</rss>";
        if($rep_content!="")
        {
	        $rep_name = $this->_name;
	        $rep_category = "block";
			$rep_blog_id = $this->_block_id!=""?$this->_block_id:0;
			
	        $sql = "insert into template_slash (name, template_id, content, category, block_id) values('$rep_name',$this->_id, '$rep_content', '$rep_category', $rep_blog_id)";

	        $this->_dao->Insert($sql);
	        $rep_id = $this->_dao->LastID();
	        $replace = "<input type=hidden name=" . $rep_name . " value=" . $rep_id . ">";
	        //$replace = htmlspecialchars($replace);
	        
	        $content = str_replace("[[##]]", $replace , $content);
        }
        $this->_content = $content;

        $fp = fopen($this->_path, 'w');
		if(!$fp)
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		fwrite($fp, $this->_content);
		fclose($fp);
		return true;
	}	
	
	/**
	* @access public
	* @abstract 根据 ID 删除模板
	*/
	function DeleteByID($id)
	{
		$sql = "delete from template where id=" . $id;
		if(!$this->_dao->Query($sql))
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
		return true;
	}
	
	/**
	* @access public
	* @abstract 发布
	*/
	function Publish()
	{
		//计算发布路径
		$local_path = $this->GetLocalPath($this->_subject_id);
		$remote_path = str_replace(PATH_HTML_ROOT, "/CMS_html", $local_path);
		$this->BuildPage();
		//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行上传路径:" .$remote_path);
		$ftp = new FTP(substr($this->_db,4));
		
		//如果需要更多页，替换导航
		if( $this->_is_more == 'Y' && $this->_cur_page_num == 0 )
		{
			$index_nav_name	= substr( $this->_file_name,0,strrpos($this->_file_name,".") ) . ".nav.shtml";
			$this->_content = str_replace("{PAGE_NAV}","<!--#include virtual='$index_nav_name'--> ",$this->_content);
			$local_nav_path = substr( $local_path, 0, strrpos($local_path,"/")+1 ) . $index_nav_name;
			$fp = fopen($local_nav_path,"w");
			fwrite( $fp,"" );
			fclose();
			$ftp->Put( $local_nav_path, str_replace(PATH_HTML_ROOT, "/CMS_html", $local_nav_path) );	
		}
		else if( $this->_is_more == 'Y' && $this->_cur_page_num != 0 )
		{
			$index_nav_name	= substr( $this->_file_name,0,strrpos($this->_file_name,".") ) . ".nav.shtml";
			$this->_content = str_replace("{PAGE_NAV}","<!--#include virtual='$index_nav_name'--> ",$this->_content);
		}
		else
		{
			$this->_content = str_replace("{PAGE_NAV}","",$this->_content);
		}
		//替换结束

		$this->ReplaceSubjectTag();

		$fp = fopen($local_path, 'w');
		fwrite($fp, $this->_content);
		fclose($fp);
		
		$ftp->Put($local_path, $remote_path);
		
		//计算更多页
		$pubmore=1;//1表示允许处理多页，0表示只处理单页
		if( $pubmore && $this->_is_more == 'Y' )
		{
			$this->_dao->SetCurrentSchema( $this->_db );

			$sql =	"select b.num,b.selected_subject_id,b.content ";
			$sql.=	"from template_slash as s,template_block as b "; 
			$sql.=	" where s.block_id=b.id and s.category='block' and s.template_id=" . $this->_id;

			$res = $this->_dao->GetPlan( $sql );
			if( count( $res ) >1 )
				die("区块数量大于1，无法生成更多页");
			else
			{
				$num		= $res[0]['num'];//每页行数
				$subject_id = $res[0]['selected_subject_id'];
				
				$sql = $res[0]['content'];

				if(strpos( $sql,"LIMIT" ))
					$sql = substr( $sql,0,strpos( $sql,"LIMIT" ) );
				if(strpos( $sql,"limit" ))
					$sql = substr( $sql,0,strpos( $sql,"limit" ) );
				
				$res = $this->_dao->GetPlan( $sql );

				$article_num = count($res);							//文章数量
				$page_num = intval( $article_num/$num );			//页面数量							
	
				if( $page_num > $this->_cur_page_num )
				{
					//写导航
					$local_path =	$this->GetLocalPath($this->_subject_id);
					$local_dir	=	substr( $local_path,0,strrpos($local_path,"/")+1 );

					//修改首页导航
					$file_first_name = substr( $this->_file_name,0,strrpos($this->_file_name,".") );
					$index_nav_name	= $file_first_name . ".nav.shtml";
					$index_nav_path	= $local_dir . $index_nav_name;
					$index_remote_path = str_replace(PATH_HTML_ROOT, "/CMS_html", $index_nav_path);
					$index_nav_str = "<br><center><a href='" . $file_first_name . "_" . $page_num . ".shtml'>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='".$file_first_name."_1.shtml'>尾页</a></center>";
					$fp	=	fopen($index_nav_path,"w");
					fwrite($fp,$index_nav_str);
					fclose($fp);
					$ftp->Put($index_nav_path, $index_remote_path);
					//修改首页导航结束

					//修改原最新导航，从只有下一页变为有上一页和下一页
					if( $this->_cur_page_num >= 1 )
					{
						$pre_page_num	= $this->_cur_page_num + 1;
						$next_page_num	= $this->_cur_page_num - 1;
						$pre_page_name = $file_first_name . "_" .$pre_page_num . ".shtml";
						$next_page_name = $file_first_name . "_" .$next_page_num . ".shtml";
						$last_nav_str	=  "<br><center><a href='".$this->_file_name."'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$pre_page_name>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$next_page_name>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='".$file_first_name."_1.shtml'>尾页</a></center>";
						$last_nav_name	= $file_first_name."_".$this->_cur_page_num.".nav.shtml";
						$fp = fopen( $local_dir . $last_nav_name,"w" );
						fwrite( $fp,$last_nav_str );
						fclose( $fp );
						$ftp->Put( $local_dir.$last_nav_name, str_replace(PATH_HTML_ROOT, "/CMS_html", $local_dir.$last_nav_name));
					}		
					//修改原最新导航结束

					for( $i=$this->_cur_page_num+1;$i<=$page_num;$i++ )
					{
						$start_id = ($i-1)*$num+1;
						$this->BuildMorePage($start_id);
						$local_path = $this->GetLocalPath($this->_subject_id);
						$new_path = substr( $local_path,0,strrpos($local_path,"/")+1 ) . substr( $this->_file_name,0,strrpos($this->_file_name,".") ) ."_" . $i . ".shtml";
						$nav_name = $file_first_name . "_" . $i . ".nav.shtml";
						$this->_content = str_replace("{PAGE_NAV}","<!--#include virtual='$nav_name'--> ",$this->_content);
						$this->ReplaceSubjectTag();
						$fp = fopen($new_path, 'w');
						fwrite($fp, $this->_content);
						fclose($fp);
						$remote_path = str_replace(PATH_HTML_ROOT, "/CMS_html", $new_path);
						$ftp->Put($new_path, $remote_path);
						//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近。".$page_num);
						
						if( $i == 1 && $page_num>1 )
						{
							$pre_page_num = $i+1;
							$pre_page_name = $file_first_name . "_" .$pre_page_num . ".shtml";
							$nav_str	=  "<br><center><a href='".$this->_file_name."'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$pre_page_name>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='".$file_first_name."_1.shtml'>尾页</a></center>";
						}
						else if( $i == $page_num )
						{
							$next_page_num = $i-1;
							$next_page_name = $file_first_name . "_" .$next_page_num . ".shtml";
							$nav_str	=  "<br><center><a href='".$this->_file_name."'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$next_page_name>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='".$file_first_name."_1.shtml'>尾页</a></center>";
						}
						else
						{
							$pre_page_num = $i+1;
							$next_page_num = $i-1;
							$pre_page_name = $file_first_name . "_" .$pre_page_num . ".shtml";
							$next_page_name = $file_first_name . "_" .$next_page_num . ".shtml";
							$nav_str	=  "<br><center><a href='".$this->_file_name."'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$pre_page_name>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$next_page_name>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='".$file_first_name."_1.shtml'>尾页</a></center>";
						}
						$file_name = $file_first_name . "_" .$i . ".nav.shtml";
						$fp = fopen( $local_dir . $file_name,"w" );
						fwrite( $fp,$nav_str );
						fclose( $fp );
						$ftp->Put( $local_dir.$file_name, str_replace(PATH_HTML_ROOT,"/CMS_html",$local_dir.$file_name));
					}	
					$sql_update = "update template set cur_page_num = $page_num where id=".$this->_id;

					if( !$this->_dao->Update( $sql_update ) )
						Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近更新template表失败:" .$sql_update);
				}
			}
		}
		$ftp->close();
	}
	
	//替换页面中二级三级栏目名称
	function ReplaceSubjectTag()
	{
		
		$sql_select = "select name,dir_name,sort,parent_id from subject where id=".$this->_subject_id;
		$row = $this->_dao->GetRow($sql_select);
		if( $row['sort'] == 1 )
		{
			$this->_content = str_replace("{FIRST_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{FIRST_TITLE_E}",$row['dir_name'],$this->_content);
		}

		if( $row['sort'] == 2 )
		{
			$this->_content = str_replace("{SECOND_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{SECOND_TITLE_E}",$row['dir_name'],$this->_content);

			$sql_select = "select name,dir_name from subject where sort=1 and id=".$row['parent_id'];
			$row = $this->_dao->GetRow($sql_select);
			$this->_content = str_replace("{FIRST_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{FIRST_TITLE_E}",$row['dir_name'],$this->_content);
		}

		if( $row['sort'] == 3 )
		{
			$this->_content = str_replace("{THIRD_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{THIRD_TITLE_E}",$row['dir_name'],$this->_content);

			$sql_select = "select name,dir_name,parent_id from subject where sort=2 and id=".$row['parent_id'];
			$row = $this->_dao->GetRow($sql_select);
			$this->_content = str_replace("{SECOND_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{SECOND_TITLE_E}",$row['dir_name'],$this->_content);

			$sql_select = "select name,dir_name,parent_id from subject where sort=1 and id=".$row['parent_id'];
			$row = $this->_dao->GetRow($sql_select);
			$this->_content = str_replace("{FIRST_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{FIRST_TITLE_E}",$row['dir_name'],$this->_content);
		}

		if( $row['sort'] == 4 )
		{
			$this->_content = str_replace("{FOURTH_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{FOURTH_TITLE_E}",$row['dir_name'],$this->_content);

			$sql_select = "select name,dir_name,parent_id from subject where sort=3 and id=".$row['parent_id'];
			$row = $this->_dao->GetRow($sql_select);
			$this->_content = str_replace("{THIRD_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{THIRD_TITLE_E}",$row['dir_name'],$this->_content);

			$sql_select = "select name,dir_name,parent_id from subject where sort=2 and id=".$row['parent_id'];
			$row = $this->_dao->GetRow($sql_select);
			$this->_content = str_replace("{SECOND_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{SECOND_TITLE_E}",$row['dir_name'],$this->_content);

			$sql_select = "select name,dir_name,parent_id from subject where sort=1 and id=".$row['parent_id'];
			$row = $this->_dao->GetRow($sql_select);
			$this->_content = str_replace("{FIRST_TITLE}",$row['name'],$this->_content);
			$this->_content = str_replace("{FIRST_TITLE_E}",$row['dir_name'],$this->_content);
		}
	}

	/**
	* @access private
	* @abstract 组装分页页面
	*/
	function BuildMorePage( $start_id )
	{
		
		$this->_dao->SetCurrentSchema( "cms" );
		$sql = "select feed_redirect from channel where dir_name='" . substr( $this->_db,strpos( $this->_db,"_" ) + 1 ) . "'";
		$row1 = $this->_dao->GetRow( $sql );
		$feed_redirect = $row1['feed_redirect'];
		
		$this->_dao->SetCurrentSchema( $this->_db );
		$sql = "select * from template_slash where template_id=" . $this->_id;

		$rows = $this->_dao->GetPlan($sql);

		$rows_num = count($rows);
		$this->_content = file_get_contents($this->_path);
		for($i=0;$i<$rows_num;$i++)
		{
			switch ($rows[$i]['category'])
			{
				case 'block':
				$sql = "select * from template_block where id=" . $rows[$i]['block_id'];
				$row = $this->_dao->GetRow($sql);

				$num = $row['num'];
				$sql = $row['content'];

				$sql = str_replace( "DESC","",$sql );
				$sql = str_replace( "desc","",$sql );
				if(strpos( $sql,"LIMIT" ))
					$sql = substr( $sql,0,strpos( $sql,"LIMIT" ) );
				if(strpos( $sql,"limit" ))
					$sql = substr( $sql,0,strpos( $sql,"limit" ) );
				$sql .= " limit $start_id,$num ";
				//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近:" .$sql);

				$rows_block = $this->_dao->GetPlan($sql);

				$format = $row['format'];
				$match_num = preg_match_all("/{(.*?)}/", $format, $matches);
				$rows_block_num = count($rows_block);
				$result = "";
				for($j=$rows_block_num-1;$j>=0;$j--)
				{
					$line = $format;
					for($k=0;$k<$match_num;$k++)
					{
						//热评文章，注意是'非全等'
						if(strpos($row['name'], "*@*@*")!==false || strpos($row['name'], "@*@*@")!==false)
						{
							//直接替换，不需要判断，不过字段与rel_article_subject不同
							if($matches[1][$k]=="title" && $row['title_length'] != 0)
							{
								$title = $rows_block[$j]["title"];
								$tmp_title = $this->h_substr( $title, $row['title_length'] );								
								$line = str_replace($matches[0][$k], $tmp_title, $line);
							}
							else if($matches[1][$k]=="title0")
							{
								$title0 = $rows_block[$j]["title"];
								$line = str_replace($matches[0][$k], $title0, $line);
							}
							else if( $matches[1][$k]=="comment_num" && strpos( $row['content'],"rss_entry_attach" ) )
							{	
								$sql1 = "select commentnum from rss_entry_attach where id=" . $rows_block[$j]['id'];
								$row1 = $this->_dao->GetRow($sql1);
								$line = str_replace($matches[0][$k], $row1['commentnum'], $line);
							}
							else if( $matches[1][$k]=="remote_url" && strpos( $row['content'],"rss_entry_attach") )
							{
								$sql1 = "select url from rss_entry_attach where id=" . $rows_block[$j]['id'];
								$row1 = $this->_dao->GetRow($sql1);
								$line = str_replace($matches[0][$k], $row1['url'], $line);
							}
							else if( $matches[1][$k]=="name" && $row['title_length'] != 0 )
							{
								$name = $rows_block[$j]["name"];
								$tmp_name = $this->h_substr( $name, $row['title_length'] );								
								$line = str_replace($matches[0][$k], $tmp_name, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], $rows_block[$j][$matches[1][$k]], $line);
							}
						}
			            else if($matches[1][$k]=="subject")
						{  
						    $sql1 = "select s.name from subject as s,rel_article_subject as r where s.id=r.subject_id and r.id = ".$rows_block[$j]['id'];
		                    $row1 = $this->_dao->GetRow($sql1);
							$line = str_replace($matches[0][$k], $row1['name'], $line);
						}
						else if($matches[1][$k]=="subject_link")
						{  
						    $sql		= "select sort, parent_id, dir_name from subject where id=" . $rows_block[$j]['subject_id'];
							$tmp_row	= $this->_dao->GetRow( $sql );
							$parent_id	= $tmp_row['parent_id'];
							$dir_name	= $tmp_row['dir_name'];
							$level		= $tmp_row['sort'];

							$sub_dir	 = "";
							for( $a=0;$a<$level;$a++ )
							{
								$sql = "select parent_id, dir_name from subject where id = " . $parent_id;
								$tmp_row1 = $this->_dao->GetRow( $sql );
								$sub_dir = $tmp_row1['dir_name'] . "/" . $sub_dir;
								$parent_id = $tmp_row1['parent_id'];
							}
							if($this->_db == 'cms_blog' || $this->_db == 'cms_group')
							$subject_dir  = "http://" . substr($this->_db, strpos( $this->_db,'_')+1 ) ."s.bokee.com" . $sub_dir . $dir_name . "/index.shtml";
							else 
							$subject_dir  = "http://" . substr($this->_db, strpos( $this->_db,'_')+1 ) .".bokee.com" . $sub_dir . $dir_name . "/index.shtml";

							$line = str_replace($matches[0][$k], $subject_dir, $line);
						}
						else if($matches[1][$k]=="author")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql_author = "select author from article where id=" . $rows_block[$j]['article_id'];
								$row_author = $this->_dao->GetRow($sql_author);
								$author = $this->h_substr( $row_author['author'] ,4 );
								$line = str_replace($matches[0][$k], $author, $line);
							}
							//if(!isset($author) || $author == '')
							else
							{
								$sql_select = "select author from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
								$author_rows = $this->_dao->GetRow($sql_select);
								$author = $this->h_substr( $author_rows['author'] ,4 );
								$line = str_replace($matches[0][$k], $author, $line);
							}
						}
						else if($matches[1][$k]=="sub_title")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql_sub_title = "select sub_title from article where id=" . $rows_block[$j]['article_id'];
								$row_sub_title = $this->_dao->GetRow($sql_sub_title);
								$sub_title = $row_sub_title['sub_title'];
								$line = str_replace($matches[0][$k], $sub_title, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '#', $line);
							}
						}
						else if($matches[1][$k]=="keyword")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql = "select keyword from article where id=" . $rows_block[$j]['article_id'];
								$row = $this->_dao->GetRow($sql);
								$keyword = $row['keyword'];
								$line = str_replace($matches[0][$k], $keyword, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '', $line);
							}
						}
						else if($matches[1][$k]=="rss_url")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql = "select rss_url from article where id=" . $rows_block[$j]['article_id'];
								$row = $this->_dao->GetRow($sql);
								$rss_url = $row['rss_url'];
								$line = str_replace($matches[0][$k], $rss_url, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '', $line);
							}
						}
						else if($matches[1][$k]=="desc")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql = "select description from article where id=" . $rows_block[$j]['article_id'];
								$row = $this->_dao->GetRow($sql);
								$description = $row['description'];
								if(substr($description,-1)!='/')
								{
									$description.='/';
								}
								$line = str_replace($matches[0][$k], $description, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '', $line);
							}
						}
						else if($matches[1][$k]=="view_num")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql = "select view_num from article where id=" . $rows_block[$j]['article_id'];
								$row = $this->_dao->GetRow($sql);
								$view_num = $row['view_num'];
								$line = str_replace($matches[0][$k], $view_num, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '', $line);
							}
						}
						else if($matches[1][$k]=="bl01")
						{
							if($bl01==1)
							{
								$bl01=0;
							}
							else
							{
								$bl01=1;
							}
							$line = str_replace($matches[0][$k], $bl01, $line);
						}
						else if(substr($matches[1][$k],0,4)=='int_')
						{
							if(-1==$int_m_n)
							{
								$int_m_n=substr($matches[1][$k],-1);//初始值，产生的第一个值比它大1
							}
							$int_m_n++;
							$n=substr($matches[1][$k],-3,1);//位数
							$line = str_replace($matches[0][$k], sprintf("%0".$n."d",$int_m_n), $line);
						}
						else if(substr($matches[1][$k],0,6)=='party_')
						{
							$field=substr($matches[1][$k],6);
							if($field=='title')
							{
								$line=str_replace($matches[0][$k],'<a href="http://group.bokee.com/group/partypost.action?groupId='.$rows_block[$j]['groupid'].'&partyid='.$rows_block[$j]['id'].'" target="_blank">'.$rows_block[$j]['title'].'</a>',$line);
							}
							elseif($field=='creator')
							{
								$userinfo_arr=$this->getUserInfo($rows_block[$j]['creatorid']);
								$line=str_replace($matches[0][$k],'<a href="http://'.$userinfo_arr['blogId'].'" target="_blank">'.$userinfo_arr['nickName'].'</a>',$line);
							}
							else
							{
								$line=str_replace($matches[0][$k], $rows_block[$j][$field], $line);
							}
						}
						else if($matches[1][$k]=="comment")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql_comment = "select comment_num from article where id=" . $rows_block[$j]['article_id'];
								$row_comment = $this->_dao->GetRow($sql_comment);
								$comment_num = $row_comment['comment_num'];
								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 line:" . $line);
								$line = str_replace($matches[0][$k], $comment_num, $line);
								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 评论数:" . $comment_num . " sql:" . $sql_comment . " line:" . $line);
							}
							else 
							{
								$sql_select = "select commentnum from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
								$comment_rows = $this->_dao->GetRow($sql_select);
								$commentnum = $comment_rows['commentnum'];
							
								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 commentnum:" . $commentnum);
								$line = str_replace($matches[0][$k], $commentnum, $line);
							}
						}
						else if($matches[1][$k]=="feedname")
						{
							if($rows_block[$j]['source']!="cms")
							{
								$sql_feedid = "select feed_id from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
								$row_feedid = $this->_dao->GetRow($sql_feedid);
								$dao_rss = DAO::CreateInstanceEmpty();
								if(!$dao_rss->Connect(RSS_DB_SCHEMA, RSS_DB_USERNAME, RSS_DB_PASSWORD, RSS_DB_HOST, RSS_DB_PORT))
								{
									Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 无法连接rss数据库。");
									$line = str_replace($matches[0][$k], "", $line);
								}
								else 
								{
									$sql_feedname = "select title from feed where id=" . $row_feedid['feed_id'];
									$row_feedname = $dao_rss->GetRow($sql_feedname);
									$feedname = $row_feedname['title'];
									$line = str_replace($matches[0][$k], $feedname, $line);
								}
							}
							else 
							{
								$line = str_replace($matches[0][$k], "", $line);
							}
						}
						else if($matches[1][$k]=="feedlink")
						{
							if($rows_block[$j]['source']!="cms")
							{
								$sql_feedid = "select feed_id from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
								$row_feedid = $this->_dao->GetRow($sql_feedid);
								$feedlink = "http://rss.bokee.com/feed." . $row_feedid['feed_id'] . ".html";
								$line = str_replace($matches[0][$k], $feedlink, $line);
							}
							else 
							{
								$line = str_replace($matches[0][$k], "", $line);
							}
						}
						else if($matches[1][$k]=="datetime")
						{
							$timestamp = $rows_block[$j][$matches[1][$k]];
							$datetime = $this->hdate('m/d H:i', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime1")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('m-d H:i:s', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime2")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('m/d', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime3")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('H:i', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime4")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('Y-m-d H:i:s', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime5")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('Y-m-d', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="title" && $row['title_length'] != 0)
						{
							$title = $rows_block[$j]["title"];
							$title_match_num = preg_match_all("/>(.*?)</", $title, $title_matches);
							if($title_match_num)
							{
								$title_inner_text = $title_matches[1][0];
								$title_inner_text_r = $this->h_substr( $title_inner_text, $row['title_length'] );
								$tmp_title = str_replace($title_inner_text, $title_inner_text_r, $title);
							}
							else 
							{
								$tmp_title = $this->h_substr( $title, $row['title_length'] );
							}
							
							$line = str_replace($matches[0][$k], $tmp_title, $line);
						}
						else if($matches[1][$k]=="title0")
						{
							$title0 = $rows_block[$j]["title"];
							$line = str_replace($matches[0][$k], $title0, $line);
						}
						else if($matches[1][$k]=="comment_num" && $rows_block[$j]['source'] != "cms")
						{
							$sql_select = "select commentnum from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
							$comment_rows = $this->_dao->GetRow($sql_select);
							$commentnum = $comment_rows['commentnum'];
							
							//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 commentnum:" . $commentnum);
							$line = str_replace($matches[0][$k], $commentnum, $line);

						}
						//comment_num与comment应该合并起来
						else if($matches[1][$k]=="comment_num" && $rows_block[$j]['source'] == "cms")
						{
							$sql_comment = "select comment_num from article where id=" . $rows_block[$j]['article_id'];
							$row_comment = $this->_dao->GetRow($sql_comment);
							$comment_num = $row_comment['comment_num'];
							//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 line:" . $line);
							$line = str_replace($matches[0][$k], $comment_num, $line);
						}
						else if($matches[1][$k]=="url" && $rows_block[$j]['source'] != "cms" && 0 == $feed_redirect)
						{
							$sql_url = "select url from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
							$row_url = $this->_dao->GetRow($sql_url);
							$line = str_replace($matches[0][$k], $row_url['url'], $line);						
						}
						else 
						{
							$line = str_replace($matches[0][$k], $rows_block[$j][$matches[1][$k]], $line);
						}
						$line = str_replace("[rss]", "[RSS]", $line);
						$line = str_replace("[cms]", "[原创]", $line);
						$line = str_replace("[blogmark]", "[博采]", $line);
						$line = str_replace("[blog]", "[博客]", $line);
						$line = str_replace("[column]", "[专栏]", $line);
						$line = str_replace("[bbs]", "[社区]", $line);
					}
					$result .= $line;
				}
				
				$find = "<input type=hidden name=" . $rows[$i]['name'] . " value=" . $rows[$i]['id'] . ">";
				$this->_content = str_replace($find, $result, $this->_content);

				break;
		
				default:
				$find = "<input type=hidden name=" . $rows[$i]['name'] . " value=" . $rows[$i]['id'] . ">";
				$replace = $rows[$i]['content'];
				$this->_content = str_replace($find, $replace, $this->_content);

				break;
			}
		}
	}

	/**
	* @access private
	* @abstract 组装页面内容
	*/
	function BuildPage()
	{
		
		$this->_dao->SetCurrentSchema( "cms" );
		$sql = "select feed_redirect,dir_name from channel where dir_name='" . substr( $this->_db,strpos( $this->_db,"_" ) + 1 ) . "'";
		$row1 = $this->_dao->GetRow( $sql );
		$feed_redirect = $row1['feed_redirect'];
		
		$this->_dao->SetCurrentSchema( $this->_db );
		$sql = "select * from template_slash where template_id=" . $this->_id;
		//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 " . $sql);
		$rows = $this->_dao->GetPlan($sql);
		//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 " . print_r($rows, true));
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{
			$bl01=1;//设置一个交替产生0和1的变量，引用时，第一个值为0
			$int_m_n=-1;//设置一个产生n位自增数字序列，不足n位前面补0,第一个值是1,初始化为-1，表示未接受到初时值,例如{int_3_0}表示产生001,002,003序列
			switch ($rows[$i]['category'])
			{
				case 'block':
				$sql = "select * from template_block where id=" . $rows[$i]['block_id'];
				$row = $this->_dao->GetRow($sql);
				$sql = $row['content'];
				$rows_block = $this->_dao->GetPlan($sql);
				//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 " . $sql);
			//	print_r($rows_block);
				$format = $row['format'];
				$match_num = preg_match_all("/{(.*?)}/", $format, $matches);

				//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 " . print_r($matches, true));
				$rows_block_num = count($rows_block);
				$result = "";
				for($j=0;$j<$rows_block_num;$j++)
				{
					$line = $format;
					for($k=0;$k<$match_num;$k++)
					{
						//热评文章，注意是'非全等'
						if(strpos($row['name'], "*@*@*")!==false || strpos($row['name'], "@*@*@")!==false)
						{
							//直接替换，不需要判断，不过字段与rel_article_subject不同
							if($matches[1][$k]=="title" && $row['title_length'] != 0)
							{
								$title = $rows_block[$j]["title"];
								$tmp_title = $this->h_substr( $title, $row['title_length'] );								
								$line = str_replace($matches[0][$k], $tmp_title, $line);
							}
							else if($matches[1][$k]=="title0")
							{
								$title0 = $rows_block[$j]["title"];
								$line = str_replace($matches[0][$k], $title0, $line);
							}
							else if( $matches[1][$k]=="comment_num" && strpos( $row['content'],"rss_entry_attach" ) )
							{	
								$sql1 = "select commentnum from rss_entry_attach where id=" . $rows_block[$j]['id'];
								$row1 = $this->_dao->GetRow($sql1);
								$line = str_replace($matches[0][$k], $row1['commentnum'], $line);
							}
							else if( $matches[1][$k]=="remote_url" && strpos( $row['content'],"rss_entry_attach") )
							{
								$sql1 = "select url from rss_entry_attach where id=" . $rows_block[$j]['id'];
								$row1 = $this->_dao->GetRow($sql1);
								$line = str_replace($matches[0][$k], $row1['url'], $line);
							}
							else if( $matches[1][$k]=="name" && $row['title_length'] != 0 )
							{
								$name = $rows_block[$j]["name"];
								$tmp_name = $this->h_substr( $name, $row['title_length'] );								
								$line = str_replace($matches[0][$k], $tmp_name, $line);
							}
							else if(substr($matches[1][$k],0,4)=='int_')
							{
								if(-1==$int_m_n)
								{
									$int_m_n=substr($matches[1][$k],-1);//初始值，产生的第一个值比它大1
								}
								$int_m_n++;
								$n=substr($matches[1][$k],-3,1);//位数
								$line = str_replace($matches[0][$k], sprintf("%0".$n."d",$int_m_n), $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], $rows_block[$j][$matches[1][$k]], $line);
							}
						}
						else if($matches[1][$k]=="subject")
						{
							$sql1 = "select s.name from subject as s,rel_article_subject as r where s.id=r.subject_id and r.id = ".$rows_block[$j]['id'];
							$row1 = $this->_dao->GetRow($sql1);
							$line = str_replace($matches[0][$k], $row1['name'], $line);
						}
						else if($matches[1][$k]=="subject_link")
						{
							$sql		= "select sort, parent_id, dir_name from subject where id=" . $rows_block[$j]['subject_id'];
							$tmp_row	= $this->_dao->GetRow( $sql );
							$parent_id	= $tmp_row['parent_id'];
							$dir_name	= $tmp_row['dir_name'];
							$level		= $tmp_row['sort'];

							$sub_dir	 = "";
							for( $a=0;$a<$level;$a++ )
							{
								$sql = "select parent_id, dir_name from subject where id = " . $parent_id;
								$tmp_row1 = $this->_dao->GetRow( $sql );
								$sub_dir = $tmp_row1['dir_name'] . "/" . $sub_dir;
								$parent_id = $tmp_row1['parent_id'];
							}
							if($this->_db == 'cms_blog' || $this->_db == 'cms_group')
							$subject_dir  = "http://" . substr($this->_db, strpos( $this->_db,'_')+1 ) ."s.bokee.com" . $sub_dir . $dir_name . "/index.shtml";
							else 
							$subject_dir  = "http://" . substr($this->_db, strpos( $this->_db,'_')+1 ) .".bokee.com" . $sub_dir . $dir_name . "/index.shtml";

							$line = str_replace($matches[0][$k], $subject_dir, $line);
						}
						else if($matches[1][$k]=="author")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql_author = "select author from article where id=" . $rows_block[$j]['article_id'];
								$row_author = $this->_dao->GetRow($sql_author);
								$author = $this->h_substr( $row_author['author'] ,4 );
								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 line:" . $line);
								$line = str_replace($matches[0][$k], $author, $line);
								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 作者:" . $author . " sql:" . $sql_author . " line:" . $line);
							}
							//if(!isset($author) || $author == '')
							else
							{
								$sql_select = "select author from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
								$author_rows = $this->_dao->GetRow($sql_select);
								$author = $this->h_substr( $author_rows['author'] ,4 );
								
								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 author:" . $tmp_entry_id);
								$line = str_replace($matches[0][$k], $author, $line);

								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 作者:" . $author . " sql:" . $sql_author . " line:" . $line);

							}
						}
						else if($matches[1][$k]=="sub_title")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql_sub_title = "select sub_title from article where id=" . $rows_block[$j]['article_id'];
								$row_sub_title = $this->_dao->GetRow($sql_sub_title);
								$sub_title = $row_sub_title['sub_title'];
								$line = str_replace($matches[0][$k], $sub_title, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '#', $line);
							}
						}
						else if($matches[1][$k]=="keyword")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql = "select keyword from article where id=" . $rows_block[$j]['article_id'];
								$row = $this->_dao->GetRow($sql);
								$keyword = $row['keyword'];
								$line = str_replace($matches[0][$k], $keyword, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '', $line);
							}
						}
						else if($matches[1][$k]=="rss_url")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql = "select rss_url from article where id=" . $rows_block[$j]['article_id'];
								$row = $this->_dao->GetRow($sql);
								$rss_url = $row['rss_url'];
								$line = str_replace($matches[0][$k], $rss_url, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '', $line);
							}
						}
						else if($matches[1][$k]=="desc")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql = "select description from article where id=" . $rows_block[$j]['article_id'];
								$row = $this->_dao->GetRow($sql);
								$description = $row['description'];
								if(substr($description,-1)!='/')
								{
									$description.='/';
								}
								$line = str_replace($matches[0][$k], $description, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '', $line);
							}
						}
						else if($matches[1][$k]=="view_num")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql = "select view_num from article where id=" . $rows_block[$j]['article_id'];
								$row = $this->_dao->GetRow($sql);
								$view_num = $row['view_num'];
								$line = str_replace($matches[0][$k], $view_num, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], '', $line);
							}
						}
						else if($matches[1][$k]=="bl01")
						{
							if($bl01==1)
							{
								$bl01=0;
							}
							else
							{
								$bl01=1;
							}
							$line = str_replace($matches[0][$k], $bl01, $line);
						}
						else if(substr($matches[1][$k],0,4)=='int_')
						{
							if(-1==$int_m_n)
							{
								$int_m_n=substr($matches[1][$k],-1);//初始值，产生的第一个值比它大1
							}
							$int_m_n++;
							$n=substr($matches[1][$k],-3,1);//位数
							$line = str_replace($matches[0][$k], sprintf("%0".$n."d",$int_m_n), $line);
						}
						else if(substr($matches[1][$k],0,6)=='party_')
						{
							$field=substr($matches[1][$k],6);
							if($field=='title')
							{
								$line=str_replace($matches[0][$k],'<a href="http://group.bokee.com/group/partypost.action?groupId='.$rows_block[$j]['groupid'].'&partyid='.$rows_block[$j]['id'].'" target="_blank">'.$rows_block[$j]['title'].'</a>',$line);
							}
							elseif($field=='creator')
							{
								$userinfo_arr=$this->getUserInfo($rows_block[$j]['creatorid']);
								$line=str_replace($matches[0][$k],'<a href="http://'.$userinfo_arr['blogId'].'" target="_blank">'.$userinfo_arr['nickName'].'</a>',$line);
							}
							else
							{
								$line=str_replace($matches[0][$k], $rows_block[$j][$field], $line);
							}
						}
						else if($matches[1][$k]=="comment")
						{
							if($rows_block[$j]['source']=="cms")
							{
								$sql_comment = "select comment_num from article where id=" . $rows_block[$j]['article_id'];
								$row_comment = $this->_dao->GetRow($sql_comment);
								$comment_num = $row_comment['comment_num'];
								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 line:" . $line);
								$line = str_replace($matches[0][$k], $comment_num, $line);
								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 评论数:" . $comment_num . " sql:" . $sql_comment . " line:" . $line);
							}
							else 
							{
								$sql_select = "select commentnum from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
								$comment_rows = $this->_dao->GetRow($sql_select);
								$commentnum = $comment_rows['commentnum'];
							
								//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 commentnum:" . $commentnum);
								$line = str_replace($matches[0][$k], $commentnum, $line);
							}
						}
						else if($matches[1][$k]=="feedname")
						{
							if($rows_block[$j]['source']!="cms")
							{
								$sql_feedid = "select feed_id from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
								$row_feedid = $this->_dao->GetRow($sql_feedid);
								$dao_rss = DAO::CreateInstanceEmpty();
								if(!$dao_rss->Connect(RSS_DB_SCHEMA, RSS_DB_USERNAME, RSS_DB_PASSWORD, RSS_DB_HOST, RSS_DB_PORT))
								{
									Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 无法连接rss数据库。");
									$line = str_replace($matches[0][$k], "", $line);
								}
								else 
								{
									$sql_feedname = "select title from feed where id=" . $row_feedid['feed_id'];
									$row_feedname = $dao_rss->GetRow($sql_feedname);
									$feedname = $row_feedname['title'];
									$line = str_replace($matches[0][$k], $feedname, $line);
								}
							}
							else 
							{
								$line = str_replace($matches[0][$k], "", $line);
							}
						}
						else if($matches[1][$k]=="feedlink")
						{
							if($rows_block[$j]['source']!="cms")
							{
								$sql_feedid = "select feed_id from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
								$row_feedid = $this->_dao->GetRow($sql_feedid);
								$feedlink = "http://rss.bokee.com/feed." . $row_feedid['feed_id'] . ".html";
								$line = str_replace($matches[0][$k], $feedlink, $line);
							}
							else 
							{
								$line = str_replace($matches[0][$k], "", $line);
							}
						}
						else if($matches[1][$k]=="datetime")
						{
							$timestamp = $rows_block[$j][$matches[1][$k]];
							$datetime = $this->hdate('m/d H:i', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime1")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('m-d H:i:s', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime2")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('m/d', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime3")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('H:i', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime4")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('Y-m-d H:i:s', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="datetime5")
						{
							$timestamp = $rows_block[$j]["datetime"];
							$datetime = $this->hdate('Y-m-d', $timestamp);
							$line = str_replace($matches[0][$k], $datetime, $line);
						}
						else if($matches[1][$k]=="title" && $row['title_length'] != 0)
						{
							$title = $rows_block[$j]["title"];
							$title_match_num = preg_match_all("/>(.*?)</", $title, $title_matches);
							if($title_match_num)
							{
								$title_inner_text = $title_matches[1][0];
								$title_inner_text_r = $this->h_substr( $title_inner_text, $row['title_length'] );
								$tmp_title = str_replace($title_inner_text, $title_inner_text_r, $title);
							}
							else 
							{
								$tmp_title = $this->h_substr( $title, $row['title_length'] );
							}
							
							$line = str_replace($matches[0][$k], $tmp_title, $line);
						}
						else if($matches[1][$k]=="title0")
						{
							$title0 = $rows_block[$j]["title"];
							$line = str_replace($matches[0][$k], $title0, $line);
						}
						else if($matches[1][$k]=="comment_num" && $rows_block[$j]['source'] != "cms")
						{
							$sql_select = "select commentnum from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
							$comment_rows = $this->_dao->GetRow($sql_select);
							$commentnum = $comment_rows['commentnum'];
							
							//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 commentnum:" . $commentnum);
							$line = str_replace($matches[0][$k], $commentnum, $line);

						}
						//comment_num与comment应该合并起来
						else if($matches[1][$k]=="comment_num" && $rows_block[$j]['source'] == "cms")
						{
							$sql_comment = "select comment_num from article where id=" . $rows_block[$j]['article_id'];
							$row_comment = $this->_dao->GetRow($sql_comment);
							$comment_num = $row_comment['comment_num'];
							//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 line:" . $line);
							$line = str_replace($matches[0][$k], $comment_num, $line);
						}
						else if($matches[1][$k]=="url" && $rows_block[$j]['source'] != "cms" && 0 == $feed_redirect)
						{
							$sql_url = "select url from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
							$row_url = $this->_dao->GetRow($sql_url);
							$line = str_replace($matches[0][$k], $row_url['url'], $line);
						}
						else if($matches[1][$k]=="blog_url" && 0 == $feed_redirect)
						{
							if( $rows_block[$j]['source'] != "cms" )
							{
								$sql_url = "select url from rss_entry_attach where id=" . $rows_block[$j]['article_id'];
								$row_url = $this->_dao->GetRow($sql_url);
								$tmp_url = substr( $row_url['url'],0,strrpos( $row_url['url'],"/" ) );
								$line = str_replace($matches[0][$k], $tmp_url, $line);
							}
							else
							{
								$line = str_replace($matches[0][$k], $rows_block[$j]['url'], $line);
							}
						}
						else 
						{
							$line = str_replace($matches[0][$k], $rows_block[$j][$matches[1][$k]], $line);
						}
						$line = str_replace("[rss]", "[RSS]", $line);
						$line = str_replace("[cms]", "[原创]", $line);
						$line = str_replace("[blogmark]", "[博采]", $line);
						$line = str_replace("[blog]", "[博客]", $line);
						$line = str_replace("[column]", "[专栏]", $line);
						$line = str_replace("[bbs]", "[社区]", $line);
					}
					$result .= $line;
				}
				//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 $result");
				//echo $this->_content;
			    $find = "<input type=hidden name=" . $rows[$i]['name'] . " value=" . $rows[$i]['id'] . ">";
				//$find=htmlspecialchars($find);
				$this->_content = str_replace($find, $result, $this->_content);
				//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 " . $result);
				break;
				case 'ad':
				case 'image':
				case 'text':
				default:
				$channel_name=$row1['dir_name'];
				$subject_id=$row['subject_id'];
				$modf="<<<"."<a href=# onclick=window.open('http://cms2.bokee.com/CMS/main.php?do=template_modify_Look&id=".$rows[$i][id]."&subject_id=$subject_id&channel_name=$channel_name&p=1','template_modify_Look','width=800,height=400')" . " >"."修改" .$rows[$i]['name']. "</a>".">>>";
				$find = "<input type=hidden name=" . $rows[$i]['name'] . " value=" . $rows[$i]['id'] . ">";
				$replace = $rows[$i]['content'];
				$this->_content = str_replace($find, $replace, $this->_content);
				//Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 " . $replace);
				break;
			}
		}
	}
	
	function hdate($op,$ts)
	{
		 $unix_ts = mktime( substr($ts,8,2), substr($ts,10,2), substr($ts,12,2), substr($ts,4,2), substr($ts,6,2), substr($ts,0,4) );
		 $output = date($op,$unix_ts);
		 return $output;
	}
	
	function GetLocalPath($subject_id)
	{
		$subject = new Subject($this->_db);
		$subject->GetByID($this->_subject_id);
		$level = $subject->GetSort();
		for($i=0;$i<$level;$i++)
		{
			$subjects[$i] = $subject->GetDirName();
			$subject->GetByID($subject->GetParentId());
		}
		$local_path = PATH_HTML_ROOT . "/" . $this->_db;
		if(!is_dir($local_path))
		{
			mkdir($local_path, 0700);
		}
		for($i=$level-1;$i>=0;$i--)
		{
			$local_path .= "/" . $subjects[$i];
			if(!is_dir($local_path))
			{
				mkdir($local_path, 0700);
			}
		}
		$local_path .= "/" . $this->_file_name;
		//log::Append($local_path);
		return $local_path;
	}
	
    function GetLPathRule($subject_id)
	{

		$subject = new Subject($this->_db);
		$subject->GetByID($this->_subject_id);
		$level = $subject->GetSort();
		for($i=0;$i<$level;$i++)
		{
			$subjects[$i] = $subject->GetDirName();
			$subject->GetByID($subject->GetParentId());
		}
		//$local_path = PATH_HTML_ROOT . "/" . $this->_db;
		for($i=$level-1;$i>=0;$i--)
		{
			$path_rule .= "/" . $subjects[$i];
		}
		$cname = explode("_" , $this->_db);
		$cname=$cname[1];
		$path_rule = "http://".$cname.".".DOMAIN.$path_rule;
		return $path_rule;
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
			$len = $len*2;
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
	function getUserInfo($userid) {
		$dao_group = DAO::CreateInstanceEmpty();
		if(!$dao_group->Connect('groupinfo', 'cms', 'zmCMS0522', '221.238.254.187'))
			die("connect error");
		$sql="select * from userinfo where userId=".$userid;
		return $result=$dao_group->GetRow($sql);
	}
}
?>