<?PHP

error_reporting (E_ALL ^ E_NOTICE);

$cutepath =  __FILE__;
$cutepath = preg_replace( "'\\\show_news\.php'", "", $cutepath);
$cutepath = preg_replace( "'/show_news\.php'", "", $cutepath);

require_once("$cutepath/inc/functions.inc.php");
require_once("$cutepath/inc/templates.php");
require_once("$cutepath/inc/config.php");


// Prepare requested categories
$category = preg_replace("/ /", "", $category);
$tmp_cats_arr = explode(",", $category);
foreach($tmp_cats_arr as $key=>$value){
    if($value != ""){ $my_cats[$value] = TRUE; }
}

if($cnshow != "news"){ $skip_archive = $archive; $archive=""; }

if($archive == "" or !$archive){
	$news_file = "$cutepath/news.txt";
	$comm_file = "$cutepath/comments.txt";
}else{
	$news_file = "$cutepath/archives/$archive.news.arch";
	$comm_file = "$cutepath/archives/$archive.comments.arch";
}

$allow_add_comment		= FALSE;
$allow_full_and_comment		= FALSE;
$allow_active_and_headline	= FALSE;

//< Detarime what user want to do
if($subaction == "addcomment" and ($category == "" or $my_cats[$ucat] == TRUE)){
	$allow_add_comment = TRUE;
}
if(($subaction == "showcomments" or $subaction == "showfull" or $subaction == "addcomment" ) and ($category == "" or $my_cats[$ucat] == TRUE) ){
	$allow_full_and_comment = TRUE;
}
else{
	$my_template = $template_active;
    if($config_reverse_active == "yes"){ $reverse = TRUE; }
	$allow_active_and_headline = TRUE;
}


//> Detarime what user want to do

$loc_show = "news";
require("$cutepath/inc/shows.inc.php");
$loc_show = "";


if($cnshow != "news"){ $archive = $skip_archive; $skip_archive=""; }

unset($my_cats, $category, $catid, $cat,$reverse, $in_use, $archives_arr, $number, $no_prev, $no_next, $i, $showed, $prev, $used_archives);
?>
