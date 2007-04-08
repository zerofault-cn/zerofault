<?PHP

error_reporting (E_ALL ^ E_NOTICE);

$cutepath =  __FILE__;
$cutepath = preg_replace( "'\\\show_archives\.php'", "", $cutepath);
$cutepath = preg_replace( "'/show_archives\.php'", "", $cutepath);

require_once("$cutepath/inc/functions.inc.php");
require_once("$cutepath/inc/templates.php");
require_once("$cutepath/inc/config.php");


// Prepare requested categories
$category = preg_replace("/ /", "", $category);
$tmp_cats_arr = explode(",", $category);
foreach($tmp_cats_arr as $key=>$value){
    if($value != ""){ $my_cats[$value] = TRUE; }
}


if($archive == "" or !$archive){
	$news_file = "$cutepath/news.txt";
	$comm_file = "$cutepath/comments.txt";
}else{
	$news_file = "$cutepath/archives/$archive.news.arch";
	$comm_file = "$cutepath/archives/$archive.comments.arch";
}

if($subaction == ""){
        if(!$handle = opendir("$cutepath/archives")){ die("<center>不能打开目录$cutepath/归档 "); }
        while (false !== ($file = readdir($handle))) {
			$file_arr = explode(".",$file);
			if($file != "." and $file != ".." and $file_arr[1] == "news"){
				$arch_arr[] = $file_arr[0];
			}
		}
        closedir($handle);

        if(is_array($arch_arr)){
	        $arch_arr = array_reverse($arch_arr);
	        foreach($arch_arr as $arch_file){

				$news_lines = file("$cutepath/archives/$arch_file.news.arch");
				$count = count($news_lines);
				$last = $count-1;
				$first_news_arr = explode("|", $news_lines[$last]);
				$last_news_arr	= explode("|", $news_lines[0]);

				$first_timestamp = $first_news_arr[0];
				$last_timestamp	 = $last_news_arr[0];

				echo"<a href=\"$PHP_SELF?archive=$arch_file&subaction=list-archive&cnshow=archive\">".date("d M Y",$first_timestamp) ." - ". date("d M Y",$last_timestamp).", (<b>$count</b>)</a><br />";
	        }
		}
}
else{


$allow_add_comment			= FALSE;
$allow_full_and_comment		= FALSE;
$allow_active_and_headline	= FALSE;

//< Detarime what user want to do
if($subaction == "addcomment"){
	$allow_add_comment = TRUE;
}
if($subaction == "showcomments" or $subaction == "showfull" or $subaction == "addcomment"){
	$allow_full_and_comment = TRUE;
}
else{
	$my_template = $template_active;
	$allow_active_and_headline = TRUE;
}


//> Detarime what user want to do

$loc_show = "archive";
require("$cutepath/inc/shows.inc.php");
$loc_show = "";

}
unset($my_cats, $reverse, $in_use, $archive, $archives_arr, $number, $no_prev, $no_next, $i, $showed, $prev, $used_archives);
?>
