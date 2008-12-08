#!/opt/bokee/php/bin/php
<?php

require_once('../sql/DAO.cls.php');
require_once('../lang/Assert.cls.php');
require_once('../com/FTP.cls.php');

define('MAX_NUM',50);
define('IMAGE_MAX_NUM',24);
define('DB_HOST','211.152.20.34');
define('DB_PORT','3306');
define('DB_USERNAME','root');
define('DB_PASSWORD','10y9c2U5');
define('DB_SCHEMA','cms_sports');
//define('DB_SCHEMA','cms_pic');
define('PATH_ROOT', '/opt/bokee/www/CMS/web/root/' . DB_SCHEMA);
//define('PATH_ROOT', 'D:/GreenAMP/www/CMS/web/root/' . DB_SCHEMA);
define('REMOTE_PATH', '/html/' . DB_SCHEMA);


$ftp = new FTP();
$dao = DAO::CreateInstance();

//处理文字更多页
$sql = "select subject_id, cur_num, max_article_id, template_path from page_records where category='text' order by ID ";
$rows = $dao->GetPlan($sql);
for( $i=0;$i<count($rows);$i++ )
{
	//按栏目选出所有的文章
	$sql_article = "select count(distinct article_id) from rel_article_subject where subject_id = " . $rows[$i]['subject_id'];
	
	$article_num = $dao->GetOne( $sql_article );
	$page_num = intval( $article_num/MAX_NUM );

	if( $page_num <= $rows[$i]['cur_num'] )
	{
		continue;
	}
	else
	{
		//计算整页之外的新文章的最后id
		$remain_article_num = $article_num - $page_num * MAX_NUM;
		if( $remain_article_num )
		{
			$sql_remain = "select id from rel_article_subject where subject_id=" . $rows[$i]['subject_id'] . " order by id desc limit $remain_article_num";
			$tmp_remain_row = $dao->GetCol( $sql_remain );
			$remain_min_article_id = $tmp_remain_row[ $remain_article_num - 1 ];
		}
		else
		{
			$sql_remain = "select max(id) as remain_min_article_id from rel_article_subject where subject_id=" . $rows[$i]['subject_id'];
			$remain_min_article_id = $dao->GetOne( $sql_remain );
		}

		//计算整页之外的新文章的最后id结束
		

		//计算文件存储路径
		$sql		= "select sort, parent_id, dir_name from subject where id=" . $rows[$i]['subject_id'];
		$tmp_row	= $dao->GetRow( $sql );
		$parent_id	= $tmp_row['parent_id'];
		$dir_name	= $tmp_row['dir_name'];
		$level		= $tmp_row['sort'];

		$sub_dir	 = "";
		for( $a=0;$a<$level;$a++ )
		{
			$sql = "select parent_id, dir_name from subject where id = " . $parent_id;
			$tmp_row1 = $dao->GetRow( $sql );
			$sub_dir = $tmp_row1['dir_name'] . "/" . $sub_dir;
			$parent_id = $tmp_row1['parent_id'];
		}
		$subject_dir  = PATH_ROOT . $sub_dir . $dir_name . "/more";
		$remote_dir	  = REMOTE_PATH . $sub_dir . $dir_name . "/more";
		if( !is_dir( $subject_dir ) )
		{
			mkdir( $subject_dir,0700 );
		}
		//计算文件存储路径结束
			
		$start_id = 0;

		//修改原最新导航，从只有下一页变为有上一页和下一页
		if( $rows[$i]['cur_num'] > 0 )
		{
			$pre_page_num	= $rows[$i]['cur_num'] + 1;
			$next_page_num	= $rows[$i]['cur_num'] - 1;
			$last_nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$pre_page_num.shtml>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$next_page_num.shtml>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='0.shtml'>尾页</a></center>";
			$last_nav_name	= $rows[$i]['cur_num'] . ".nav.shtml";
			$fp = fopen( "$subject_dir/" . $last_nav_name,"w" );
			fwrite( $fp,$last_nav_str );
			fclose( $fp );
			$ftp->Put( "$subject_dir/" . $last_nav_name, "$remote_dir/" . $last_nav_name);
		}		
		//修改原最新导航结束

		//修改三级子页面导航
		$index_nav_str = "<br><center><a href='more/" . $page_num . ".shtml'>下一页</a></center>";
		$fp = fopen( "$subject_dir/index.nav.shtml" ,"w" );
		fwrite( $fp,$index_nav_str );
		fclose( $fp );	
		$ftp->Put( "$subject_dir/index.nav.shtml", "$remote_dir/index.nav.shtml");
		//修改三级子页面导航结束

		for( $j = $page_num; $j > $rows[$i]['cur_num'] ; $j-- )
		{
			//组建新的页面
			$sql_new_page	= "select id,title,source,url,datetime from rel_article_subject where subject_id = " . $rows[$i]['subject_id'] ." and id >= " . $rows[$i]['max_article_id'] . " and id < $remain_min_article_id" ;
			$sql_new_page	.=	" group by article_id order by id desc limit $start_id ," . MAX_NUM;
			$tmp_rows		= $dao->GetPlan( $sql_new_page );
			$num_rows		= count($tmp_rows);
			$str			= "";
			for( $m=0;$m<$num_rows;$m++ )
			{
					$str .= "<ul><li><span class='thirdwhere'>";
					$str .= substr( $tmp_rows[$m]['datetime'],4,2 )."/".substr( $tmp_rows[$m]['datetime'],6,2 )." ";
					$str .= substr( $tmp_rows[$m]['datetime'],8,2 ).":".substr( $tmp_rows[$m]['datetime'],10,2 );
					$str .=	"</span>";				

					switch( $tmp_rows[$m]['source'] )
					{
						case "cms":
							$source = "[原创]";
							break;
						case "rss":
							$source = "[RSS]";
							break;
						case "blogmark":
							$source = "[博采]";
							break;
						case "blog":
							$source = "[博客]";
							break;
						case "column":
							$source = "[专栏]";
							break;
						case "bbs":
							$source = "[社区]";
							break;
					}
					
					$str .= "<span>" . $source . "</span>";
					$str .= "<span><a href='" . $tmp_rows[$m]['url'] . "' target=_blank>" . $tmp_rows[$m]['title'] . "</a></span></li></ul>";
			}
			
			$nav_name = $j . ".nav.shtml";
			$str .= "<br><!--#include virtual=\"" . $nav_name . "\"--><br>";	
			
			//打开标准模版
			$fp1 = fopen( $rows[$i]['template_path'],"r" );
			$content = fread( $fp1,filesize( $rows[$i]['template_path'] ) );
			fclose( $fp1 );

			$str = str_replace( "{CONTENT}",$str,$content );
			

			//写进file
			$file_name = $j . ".shtml";
			$fp = fopen( "$subject_dir/" . $file_name,"w" );
			fwrite( $fp,$str );
			fclose( $fp );
			$ftp->Put( "$subject_dir/" . $file_name, "$remote_dir/" . $file_name);


			//写导航
			if( $j == $page_num-$rows[$i]['cur_num'] && $j != 1 )
			{
				$next_page_num = $j-1;
				$nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='" . $next_page_num . ".shtml'>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='1.shtml'>尾页</a></center>";
			}
			else if( 1 == $j  && $page_num > 1 )
			{
				$pre_page_num = $j+1;
				$nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='" . $pre_page_num . ".shtml'>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='1.shtml'>尾页</a></center>";
			}
			else if( 1 == $j  && 1 == $page_num )
			{
				$nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='1.shtml'>尾页</a></center>";
			}
			else
			{
				$pre_page_num = $j+1;
				$next_page_num = $j-1;
				$nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$pre_page_num.shtml>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$next_page_num.shtml>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='1.shtml'>尾页</a></center>";
			}
			$fp = fopen( "$subject_dir/" . $nav_name,"w" );
			fwrite( $fp, $nav_str );
			fclose( $fp );
			$ftp->Put( "$subject_dir/" . $nav_name, "$remote_dir/" . $nav_name);

			//写导航结束

			$start_id += MAX_NUM;
		}

		//在数据库中做上标记
		$sql_update = "update page_records set cur_num=". $page_num . " , max_article_id = $remain_min_article_id, update_time = NOW() where category='text' and subject_id = " . $rows[$i]['subject_id'] ;
		if( $dao->update( $sql_update ) )
		{
			echo "数据库更新成功","<br>";
		}
		else
		{
			echo "数据库更新失败","<br>";
		}
		echo "该栏目共有文章" .  $page_num . "页";
	}
}
$ftp->Close();

$ftp = new FTP();

//处理图片更多页
$sql = "select subject_id, cur_num, max_article_id, template_path from page_records where category='image' order by ID ";
$rows = $dao->GetPlan($sql);
for( $i=0;$i<count($rows);$i++ )
{
	//按栏目选出所有的文章
	$sql_gallery = "select count(distinct group_id) from gallery where subject_id = " . $rows[$i]['subject_id'];
	$gallery_num = $dao->GetOne( $sql_gallery );
	$page_num = intval( $gallery_num/IMAGE_MAX_NUM );
	if( $page_num <= $rows[$i]['cur_num'] )
	{
		continue;
	}
	else
	{
		//计算整页之外的新文章的最后id
		$remain_gallery_num = $gallery_num - $page_num * IMAGE_MAX_NUM;
		if( $remain_gallery_num )
		{
			$sql_remain = "select id from gallery where subject_id=" . $rows[$i]['subject_id'] . " order by id desc limit $remain_gallery_num";
			$tmp_remain_row = $dao->GetCol( $sql_remain );
			$remain_min_gallery_id = $tmp_remain_row[ $remain_gallery_num - 1 ];
		}
		else
		{
			$sql_remain = "select max(id) as remain_min_gallery_id from gallery where subject_id=" . $rows[$i]['subject_id'];
			$remain_min_gallery_id = $dao->GetOne( $sql_remain );
		}

		//计算整页之外的新文章的最后id结束
		

		//计算文件存储路径
		$sql		= "select sort, parent_id, dir_name from subject where id=" . $rows[$i]['subject_id'];
		$tmp_row	= $dao->GetRow( $sql );
		$parent_id	= $tmp_row['parent_id'];
		$dir_name	= $tmp_row['dir_name'];
		$level		= $tmp_row['sort'];

		$sub_dir	 = "";
		for( $a=0;$a<$level;$a++ )
		{
			$sql = "select parent_id, dir_name from subject where id = " . $parent_id;
			$tmp_row1 = $dao->GetRow( $sql );
			$sub_dir = $tmp_row1['dir_name'] . "/" . $sub_dir;
			$parent_id = $tmp_row1['parent_id'];
		}
		$subject_dir  = PATH_ROOT . $sub_dir . $dir_name . "/more_images";
		$remote_dir	  = REMOTE_PATH . $sub_dir . $dir_name . "/more_images";

		if( !is_dir( $subject_dir ) )
		{
			mkdir( $subject_dir,0700 );
		}
		//计算文件存储路径结束
		$start_id = 0;

		//修改原最新导航，从只有下一页变为有上一页和下一页
		if( $rows[$i]['cur_num'] > 0 )
		{
			$pre_page_num	= $rows[$i]['cur_num'] + 1;
			$next_page_num	= $rows[$i]['cur_num'] - 1;
			$last_nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$pre_page_num.shtml>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$next_page_num.shtml>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='0.shtml'>尾页</a></center>";
			$last_nav_name	= $rows[$i]['cur_num'] . ".nav.shtml";
			$fp = fopen( "$subject_dir/" . $last_nav_name,"w" );
			fwrite( $fp,$last_nav_str );
			fclose( $fp );
			$ftp->Put( "$subject_dir/" . $last_nav_name, "$remote_dir/" . $last_nav_name);
		}		
		//修改原最新导航结束

		//修改三级子页面导航
		$index_nav_str = "<br><center><a href='more_images/" . $page_num . ".shtml'>下一页</a></center>";
		$fp = fopen( "$subject_dir/index.nav.shtml" ,"w" );
		fwrite( $fp,$index_nav_str );
		fclose( $fp );	
		$ftp->Put( "$subject_dir/index.nav.shtml", "$remote_dir/index.nav.shtml");
		//修改三级子页面导航结束

		for( $j = $page_num; $j > $rows[$i]['cur_num'] ; $j-- )
		{
			//组建新的页面
			$sql_new_page	= "select id,name,path,url,create_time from gallery where subject_id = " . $rows[$i]['subject_id'] ." and id >= " . $rows[$i]['max_article_id'] . " and id < $remain_min_gallery_id" ;
			$sql_new_page	.=	" group by group_id order by id desc limit $start_id ," . IMAGE_MAX_NUM;
			$tmp_rows		= $dao->GetPlan( $sql_new_page );
			$num_rows		= count($tmp_rows);
			$str			= "<TABLE class=sportimg-box cellSpacing=2 cellPadding=2 width=760 align=center border=0>";
			$str			.="<TBODY><TR><TD colSpan=4 height=5></TD></TR><TR>";
			$str_image		= "";
			$str_text		= "";
			for( $m=0;$m<$num_rows;$m++ )
			{
				if( $m % 4 == 0 && $m != 0 )
				{
					$str_image	.= "</TR>";
					$str_text	.= "</TR>";
					$str		.=	$str_image.$str_text;
					$str_image  = "<TR><TD colSpan=4 height=5></TD></TR><TR>";
					$str_text	= "<TR>";	
				}
				$str_image	.=	"<TD align='center'><A href=" . $tmp_rows[$m]['url'] . ">";
				$str_image	.=	"<IMG alt= '" . $tmp_rows[$m]['name'] . "' src='". $tmp_rows[$m]['path'] . "'></A></TD>";

				$str_text	.=	"<TD vAlign=top width='25%' bgColor=#848484 height=40>";
				$str_text	.=	"<A href=". $tmp_rows[$m]['url'] .">" . $tmp_rows[$m]['name'] . "</A></TD>" ;
				
			}
			$str .= "</TBODY></TABLE>";
			
			$nav_name = $j . ".nav.shtml";
			$str .= "<br><!--#include virtual=\"" . $nav_name . "\"--><br>";	
			
			//打开标准模版
			$fp1 = fopen( $rows[$i]['template_path'],"r" );
			$content = fread( $fp1,filesize( $rows[$i]['template_path'] ) );
			fclose( $fp1 );

			$str = str_replace( "{CONTENT}",$str,$content );
			

			//写进file
			$file_name = $j . ".shtml";
			$fp = fopen( "$subject_dir/" . $file_name,"w" );
			fwrite( $fp,$str );
			fclose( $fp );
			$ftp->Put( "$subject_dir/" . $file_name, "$remote_dir/" . $file_name);


			//写导航
			if( $j == $page_num-$rows[$i]['cur_num'] && $j != 1 )
			{
				$next_page_num = $j-1;
				$nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='" . $next_page_num . ".shtml'>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='1.shtml'>尾页</a></center>";
			}
			else if( 1 == $j  && $page_num > 1 )
			{
				$pre_page_num = $j+1;
				$nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='" . $pre_page_num . ".shtml'>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='1.shtml'>尾页</a></center>";
			}
			else if( 1 == $j  && 1 == $page_num )
			{
				$nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='1.shtml'>尾页</a></center>";
			}
			else
			{
				$pre_page_num = $j+1;
				$next_page_num = $j-1;
				$nav_str	=  "<br><center><a href='../index.shtml'>首页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$pre_page_num.shtml>上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=$next_page_num.shtml>下一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='1.shtml'>尾页</a></center>";
			}
			$fp = fopen( "$subject_dir/" . $nav_name,"w" );
			fwrite( $fp, $nav_str );
			fclose( $fp );
			$ftp->Put( "$subject_dir/" . $nav_name, "$remote_dir/" . $nav_name);

			//写导航结束

			$start_id += IMAGE_MAX_NUM;
		}

		//在数据库中做上标记
		$sql_update = "update page_records set cur_num=". $page_num . " , max_article_id = $remain_min_gallery_id, update_time = NOW() where category='image' and subject_id = " . $rows[$i]['subject_id'] ;
		if( $dao->update( $sql_update ) )
		{
			echo "数据库更新成功","<br>";
		}
		else
		{
			echo "数据库更新失败","<br>";
		}
		echo "该栏目共有文章" .  $page_num . "页";
	}
}
$ftp->Close();


?>