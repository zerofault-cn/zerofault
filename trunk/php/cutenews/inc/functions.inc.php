<?PHP

if(!$PHP_SELF){
	if($HTTP_POST_VARS) 	{extract($HTTP_POST_VARS, EXTR_PREFIX_SAME, "post_");}
	if($HTTP_GET_VARS)  	{extract($HTTP_GET_VARS, EXTR_PREFIX_SAME, "get_");}
	if($HTTP_COOKIE_VARS)	{extract($HTTP_COOKIE_VARS, EXTR_PREFIX_SAME, "cookie_");}
	if($HTTP_ENV_VARS)	 	{extract($HTTP_ENV_VARS, EXTR_PREFIX_SAME, "env_");}
    }
if($PHP_SELF == ""){ $PHP_SELF = $HTTP_SERVER_VARS[PHP_SELF]; }

///////////////////////////////////////////////////////
// Function: 	formatsize
// Description: Format the size of given file

function formatsize($file_size){
	if($file_size >= 1073741824)
		{$file_size = round($file_size / 1073741824 * 100) / 100 . "Gb";}
    elseif($file_size >= 1048576)
    	{$file_size = round($file_size / 1048576 * 100) / 100 . "Mb";}
    elseif($file_size >= 1024)
    	{$file_size = round($file_size / 1024 * 100) / 100 . "Kb";}
    else{$file_size = $file_size . "b";}
return $file_size;
}

///////////////////////////////////////////////////////
// Function: 	check_login
// Description: Check login information

function check_login($username, $md5_password){
	$result = FALSE;
    $full_member_db = file("./inc/users.db.php");
    global $member_db;

    foreach($full_member_db as $member_db_line)
    {
		if(!eregi("<\?",$member_db_line)){
	        $member_db = explode("|",$member_db_line);
	        if(strtolower($member_db[2]) == strtolower($username) && $member_db[3] == $md5_password)
	        {
				$result = TRUE;
            	break;
            }
		}
	}
	return $result;
}

///////////////////////////////////////////////////////
// Function: 	cute_query_string
// Description: Format the Query_String for CuteNews purpuses index.php?

function cute_query_string($q_string, $strips, $type="get"){
	foreach($strips as $key){
		$strips[$key] = TRUE;
    }
	$var_value = explode("&", $q_string);

    foreach($var_value as $var_peace){
        $parts = explode("=", $var_peace);
        if($strips[$parts[0]] != TRUE and $parts[0] != ""){
			if($type == "post"){
            	$my_q .= "<input type=hidden name=\"".$parts[0]."\" value=\"".$parts[1]."\" />\n";
            }else{
            	$my_q .= "$var_peace&";
			}
        }
    }

if( substr($my_q, -1) == "&" ){ $my_q = substr($my_q, 0, -1); }

return $my_q;
}

///////////////////////////////////////////////////////
// Function:	Flooder
// Description: Flood Protection Function
function flooder($ip, $comid){
    global $cutepath, $config_flood_time;

	$old_db = file("$cutepath/inc/flood.db.php");
	$new_db = fopen("$cutepath/inc/flood.db.php", w);
    $result = FALSE;
    foreach($old_db as $old_db_line){
        $old_db_arr = explode("|", $old_db_line);

        if(($old_db_arr[0] + $config_flood_time) > time() ){
        	fwrite($new_db, $old_db_line);
        	if($old_db_arr[1] == $ip and $old_db_arr[2] == $comid)
            { $result = TRUE; }
        }
    }
    fclose($new_db);
    return $result;
}

////////////////////////////////////////////////////////
// Function: 	msg
// Description: Displays message to user

function msg($type, $title, $text, $back=FALSE){
  echoheader($type, $title);
  global $lang;
  	echo"<table border=0 cellpading=0 cellspacing=0 width=654 height=100% ><tr><td>$text";
    if($back){
		echo"<br /><br> <a href=\"$back\">返回</a>";
    }
    echo"</td></tr></table>";
  echofooter();
exit();
}

////////////////////////////////////////////////////////
// Function: 	echoheader
// Description: Displays header skin

function echoheader($image, $header_text){
	global $PHP_SELF, $is_loged_in, $config_skin, $skin_header, $lang_content_type, $skin_menu, $skin_prefix, $config_version_name;

    if($is_loged_in == TRUE){ $skin_header = preg_replace("/{menu}/", "$skin_menu", "$skin_header"); }
    else { $skin_header = preg_replace("/{menu}/", " &nbsp; $config_version_name", "$skin_header"); }

    $skin_header = preg_replace("/{image-name}/", "${skin_prefix}${image}", $skin_header);
    $skin_header = preg_replace("/{header-text}/", $header_text, $skin_header);
    $skin_header = preg_replace("/{content-type}/", $lang_content_type, $skin_header);
    $skin_header = preg_replace("/{copyrights}/", "<div style='font-size: 9px'>本站基于<a style='font-size: 9px' href=\"http://cutephp.com/\" target=_blank>$config_version_name</a>软件 &copy;2003  <a style='font-size: 9px' href=\"http://cutephp.com/\" target=_blank>CutePHP</a><br>由<a href=\"http://www.urpos.com\">玉珀电子科技</a>汉化</div>", $skin_header);

    echo $skin_header;
}

////////////////////////////////////////////////////////
// Function: 	echofooter
// Description: Displays footer skin

function echofooter(){

	global $PHP_SELF, $is_loged_in, $config_skin, $skin_footer, $lang_content_type, $skin_menu, $skin_prefix, $config_version_name;

    if($is_loged_in == TRUE){ $skin_footer = preg_replace("/{menu}/", "$skin_menu", "$skin_footer"); }
    else { $skin_footer = preg_replace("/{menu}/", " &nbsp; CuteNews v.1.00汉化版", "$skin_footer"); }

    $skin_footer = preg_replace("/{image-name}/", "${skin_prefix}${image}", $skin_footer);
    $skin_footer = preg_replace("/{header-text}/", $header_text, $skin_footer);
    $skin_footer = preg_replace("/{content-type}/", $lang_content_type, $skin_footer);
    $skin_footer = preg_replace("/{copyrights}/", "<div style='font-size: 9px'>本站基于<a style='font-size: 9px' href=\"http://cutephp.com/\" target=_blank>$config_version_name</a>软件 &copy;2003  <a style='font-size: 9px' href=\"http://cutephp.com/\" target=_blank>CutePHP</a><br>由<a href=\"http://www.urpos.com\">玉珀电子科技</a>汉化</div>", $skin_footer);

    echo $skin_footer;

}

////////////////////////////////////////////////////////
// Function: 	CountComments
// Description: Count How Many Comments Have a Specific Article

function CountComments($id, $archive = FALSE){

    global $cutepath;

    if($cutepath == ""){ $cutepath = "."; }
    $result = "0";
    if($archive){ $all_comments = file("$cutepath/archives/${archive}.comments.arch"); }
    else{ $all_comments = file("$cutepath/comments.txt"); }

    foreach($all_comments as $comment_line)
    {
		$comment_arr_1 = explode("|>|", $comment_line);
        if($comment_arr_1[0] == $id)
        {
			$comment_arr_2 = explode("||", $comment_arr_1[1]);
            $result = count($comment_arr_2)-1;

        }
    }

return $result;
}

////////////////////////////////////////////////////////
// Function: 	insertSmilies
// Description: insert smilies for adding into news/comments

function insertSmilies($insert_location, $break_location = FALSE)
{
    global $config_http_script_dir, $config_smilies;

    $smilies = explode(",", $config_smilies);
	foreach($smilies as $smile)
	{
        $i++; $smile = trim($smile);

        $output .= "<a href=\"javascript:insertext(':$smile:','$insert_location')\"><img border=\"0\" src=\"$config_http_script_dir/images/emoticons/$smile.gif\" /></a>";
		if($i%$break_location == 0 and $break_location)
		{
			$output .= "<br />";
		}else{ $output .= "&nbsp;"; }
    }
	return $output;
}

////////////////////////////////////////////////////////
// Function: 	replace_comments
// Description: Replaces comments charactars
function replace_comment($way, $sourse){
    global $config_allow_html_in_news, $config_allow_html_in_comments, $config_http_script_dir, $config_smilies;

    $sourse = stripslashes(trim($sourse));

	if($way == "add"){

		$find = array(
	    			"'\"'",
					"'\''",
					"'<'",
					"'>'",
					"'\|'",
					"'\n'",
					"'\r'",
	                 );
		$replace = array(
	    			"&quot;",
					"&#039;",
					"&lt;",
					"&gt;",
 					"&#124",
					"<br />",
                    "",
	                 );

    }
    elseif($way == "show"){

		$find = array(
					"'\[b\](.*?)\[/b\]'i",
					"'\[i\](.*?)\[/i\]'i",
					"'\[u\](.*?)\[/u\]'i",
					"'\[link\](.*?)\[/link\]'i",
					"'\[link=(.*?)\](.*?)\[/link\]'i",

                    "'\[quote=(.*?)\](.*?)\[/quote\]'",
                    "'\[quote\](.*?)\[/quote\]'",
                     );
		$replace = array(
					"<b>\\1</b>",
					"<i>\\1</i>",
					"<u>\\1</u>",
					"<a href=\"\\1\">\\1</a>",
					"<a href=\"\\1\">\\2</a>",

                    "<blockquote><div style=\"font-size: 13px;\">quote (\\1):</div><hr noshade size=1>\\2<hr noshade size=1></blockquote>",
                    "<blockquote><div style=\"font-size: 13px;\">quote:</div><hr noshade size=1>\\1<hr noshade size=1></blockquote>",
                     );

		$smilies_arr = explode(",", $config_smilies);
	    foreach($smilies_arr as $smile){
	        $smile = trim($smile);
	        $find[] = "':$smile:'";
	        $replace[] = "<img border=0 src=\"$config_http_script_dir/images/emoticons/$smile.gif\" />";
	    }

    }

$sourse  = preg_replace($find,$replace,$sourse);
return $sourse;
}

////////////////////////////////////////////////////////
// Function: 	replace_news
// Description: Replaces news charactars

function replace_news($way, $sourse, $replce_n_to_br=TRUE, $use_html=TRUE){
    global $config_allow_html_in_news, $config_allow_html_in_comments, $config_http_script_dir, $config_smilies;
    $sourse = stripslashes($sourse);

    if($way == "show")
    {
		$find= array(

/* 11 */				"'\[upimage=(.*?) ([^\]]{1,})\]'i",
/* 2 */					"'\[upimage=(.*?)\]'i",
/* 3 */					"'\[b\](.*?)\[/b\]'i",
/* 4 */					"'\[i\](.*?)\[/i\]'i",
/* 5 */					"'\[u\](.*?)\[/u\]'i",
/* 6 */					"'\[link\](.*?)\[/link\]'i",
/* 7 */					"'\[color=(.*?)\](.*?)\[/color\]'i",
/* 8 */					"'\[size=(.*?)\](.*?)\[/size\]'i",
/* 9 */					"'\[font=(.*?)\](.*?)\[/font\]'i",
/* 10 */ 				"'\[align=(.*?)\](.*?)\[/align\]'i",
/* 11 */				"'\[image=(.*?) ([^\]]{1,})\]'i",
/* 12 */ 				"'\[image=(.*?)\]'i",
/* 13 */ 				"'\[link=(.*?)\](.*?)\[/link\]'i",

/* 14 */                "'\[quote=(.*?)\](.*?)\[/quote\]'i",
/* 15 */                "'\[quote\](.*?)\[/quote\]'i",

/* 16 */                "'\[list\]'i",
/* 17 */                "'\[/list\]'i",
/* 18 */                "'\[\*\]'i",

    	                "'{nl}'",
                       );

		$replace=array(

/* 1 */					"<img \\2 src=\"${config_http_script_dir}/images/upimages/\\1\" border=0>",
/* 2 */					"<img src=\"${config_http_script_dir}/images/upimages/\\1\" border=0>",
/* 3 */					"<b>\\1</b>",
/* 4 */					"<i>\\1</i>",
/* 5 */					"<u>\\1</u>",
/* 6 */					"<a href=\"\\1\">\\1</a>",
/* 7 */					"<font color=\\1>\\2</font>",
/* 8 */					"<font size=\\1>\\2</font>",
/* 9 */					"<font face=\"\\1\">\\2</font>",
/* 10 */				"<div align=\\1>\\2</div>",
/* 11 */				"<img \\2 src=\"\\1\" border=0>",
/* 12 */				"<img src=\"\\1\" border=0>",
/* 13 */				"<a href=\"\\1\">\\2</a>",

/* 14 */				"<blockquote><div style=\"font-size: 13px;\">quote (\\1):</div><hr noshade size=1>\\2<hr noshade size=1></blockquote>",
/* 15 */				"<blockquote><div style=\"font-size: 13px;\">quote:</div><hr noshade size=1>\\1<hr noshade size=1></blockquote>",

/* 16 */				"<ul>",
/* 17 */				"</ul>",
/* 18 */				"<li>",

    					"\n",
                        );

    	$smilies_arr = explode(",", $config_smilies);
	    foreach($smilies_arr as $smile){
	        $smile = trim($smile);
	        $find[] = "':$smile:'";
	        $replace[] = "<img border=0 src=\"$config_http_script_dir/images/emoticons/$smile.gif\" />";
	    }
    }
    elseif($way == "add"){

		$find = array(
					"'\|'",
					"'\r'",
	                 );
		$replace = array(
					"&#124",
					"",
	                 );

		if($use_html != TRUE){
        	$find[] 	= "'<'";
        	$find[] 	= "'>'";

			$replace[] 	= "&lt;";
			$replace[] 	= "&gt;";
        }
		if($replce_n_to_br == TRUE){
        	$find[] 	= "'\n'";
			$replace[] 	= "<br />";
        }else{
        	$find[] 	= "'\n'";
			$replace[] 	= "{nl}";
        }

    }
    elseif($way == "admin"){

		$find = array(
					"''",
					"'<br />'",
					"'{nl}'",
                    );
		$replace = array(
					"",
					"\n",
					"\n",
	                 );

    }

$sourse  = preg_replace($find,$replace,$sourse);
return $sourse;
}

?>