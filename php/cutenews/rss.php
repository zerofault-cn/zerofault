<?php

error_reporting (E_ALL ^ E_NOTICE);

$cutepath =  __FILE__;
$cutepath = preg_replace( "'\\\rss\.php'", "", $cutepath);
$cutepath = preg_replace( "'/rss\.php'", "", $cutepath);

require_once("$cutepath/inc/config.php");

require_once("$cutepath/inc/class.RSSBuilder.inc.php");

// read active news file
$news_file = "$cutepath/news.txt";
$all_active_news = file("$news_file");
 
$rssfile     = new RSSBuilder($config_channel_encoding, 
                              $about, // null
                              $config_channel_name, 
                              $config_channel_description, 
                              $image_link, // null
                              $category,   // null
                              $cache);     // null

$language = (string) 'cn';  // here only set the language
$rssfile->addDCdata($publisher,	$creator, $date, $language,$rights, $coverage, $contributor);

// paser active news file
foreach($all_active_news as $active_news)
{
    $news_arr = explode("|", $active_news);

    $about = $link   = htmlspecialchars($config_http_script_dir."/index.php?subaction=showfull&id=".$news_arr[0]);
    $title           = (string) htmlspecialchars ($news_arr[2]);
    $description     = (string) htmlspecialchars ($news_arr[3]);
    $date            = (string) date($config_timestamp_active, $news_arr[0]); // optional DC value
    $author          = (string) htmlspecialchars ($news_arr[1]); // author of item

    $rssfile->addItem($about, $title, $link, $description, $subject, $date,$author, $comments, $image);

}

$version = '2.0'; // 0.91 / 1.0 / 2.0
$rssfile->outputRSS($version);

?>