<?PHP

$user_query = cute_query_string($QUERY_STRING, array("start_from", "archive", "subaction", "id", "cnshow", "ucat"));
$user_post_query = cute_query_string($QUERY_STRING, array("start_from", "archive", "subaction", "id", "cnshow", "ucat"), "post");
//####################################################################################################################
//			 Define Categories
//####################################################################################################################
$cat_lines = @file("$cutepath/inc/category.db.php");
foreach($cat_lines as $single_line){
	$cat_arr = explode("|", $single_line);
    $cat[$cat_arr[0]] = $cat_arr[1];
    $cat_icon[$cat_arr[0]]=$cat_arr[2];
}
//####################################################################################################################
//			 Define Users
//####################################################################################################################
$all_users = file("$cutepath/inc/users.db.php");
foreach($all_users as $user)
{
	if(!eregi("<\?",$member_db_line)){
		$user_arr = explode("|",$user);
			if($user_arr[4] != "")
			    {
			    	if($user_arr[7] != 1 and $user_arr[5] != ""){ $my_names[$user_arr[2]] = "<a href=\"mailto:$user_arr[5]\">$user_arr[4]</a>"; }
					else{ $my_names[$user_arr[2]] = "$user_arr[4]"; }
			    }
				else
			    {
			    	if($user_arr[7] != 1 and $user_arr[5] != ""){ $my_names[$user_arr[2]] = "<a href=\"mailto:$user_arr[5]\">$user_arr[2]</a>"; }
					else{ $my_names[$user_arr[2]] = "$user_arr[2]"; }
				}

				$my_passwords[$user_arr[2]] = $user_arr[3];
				$my_users[] = $user_arr[2];
    }
}
//####################################################################################################################
// 			Add Comment
//####################################################################################################################
if($allow_add_comment){

    if(!$ip){
		if(isset($HTTP_X_FORWARDED_FOR)){ $ip = $HTTP_X_FORWARDED_FOR; }
		elseif(isset($HTTP_CLIENT_IP))	{ $ip = $HTTP_CLIENT_IP; }
		if($ip == "")				    { $ip = $REMOTE_ADDR; }
		if($ip == "")					{ $ip = "not detected";}
    }

// Check Flood Protection
    if($config_flood_time != 0 and $config_flood_time != "" ){
        if(flooder($ip, $id) == TRUE ){
        	die("<center>Flood protection activated !!!<br />you have to wait $config_flood_time seconds after your last comment before posting again at this article.</center>");
		}
    }
// Check if IP is banned

    $blockip = FALSE;
    $old_ips = file("$cutepath/inc/ipban.db.php");
    $new_ips = fopen("$cutepath/inc/ipban.db.php", "w");
    @flock ($new_ips,2);
    foreach($old_ips as $old_ip_line){
            $ip_arr = explode("|", $old_ip_line);
            if($ip_arr[0] != $ip){
				fwrite($new_ips, $old_ip_line);
        }else{
			$countblocks = $ip_arr[1] = $ip_arr[1] + 1;
			fwrite($new_ips, "$ip|$countblocks||\n"); $blockip = TRUE;
        }
    }
    @flock ($new_ips,3);
    fclose($new_ips);
    if($blockip){ die("<center>Sorry but you have been blocked from posting comments</center>"); }

// Check if name is Protected
    $is_member = FALSE;
    foreach($all_users as $member_db_line)
    {
        if(!eregi("<\?",$member_db_line) and $member_db_line != ""){
			$user_arr = explode("|",$member_db_line);

            //if the name is protected
            if((strtolower($user_arr[2]) == strtolower($name) or strtolower($user_arr[4]) == strtolower($name)) and $user_arr[3] != md5($password) and $name != "")
        	{
             echo"<center>This name is owned by a registered user and you must enter password to use it<br />
             <form method=post>Password: <input type=password name=password />
             <input type=hidden name=name value=\"$name\" />
             <input type=hidden name=comments value=\"$comments\" />
             <input type=hidden name=mail value=\"$mail\" />
             <input type=hidden name=ip value=\"$ip\" />
             <input type=hidden name=subaction value=\"addcomment\" />
             <input type=hidden name=show value=\"$show\" />
             <input type=hidden name=ucat value=\"$ucat\" />
             $user_post_query
             <input type=submit /></form></center>";
             exit();
        	}

            if(strtolower($user_arr[2]) == strtolower($name)) $is_member = TRUE;
        }
	}

// Check if only members can post comments
	if($config_only_registered_comment == "yes" and !$is_member){
	    echo"<center>Sorry but only registered users can post comments, and '$name' is not recognized as valid member.</center>";
		exit();
    }

//* Wrap long words
    if($config_auto_wrap > 1){
        $comments_arr = explode("\n", $comments);
        foreach($comments_arr as $line){
        	$wraped_comm .= ereg_replace("([^ \/\/]{".$config_auto_wrap."})","\\1\n", $line) ."\n";
        }
	    if(strlen($name) > $config_auto_wrap){ $name = substr($name, 0, $config_auto_wrap)." ..."; }
    $comments = $wraped_comm;
    }
//*/

    $comments 	= replace_comment("add", $comments);
    $name		= replace_comment("add", preg_replace("/\n/", "",$name));
	$mail 		= replace_comment("add", preg_replace("/\n/", "",$mail));

    if($name == " " or $name == ""){ die("<center>Please enter your name"); }
    if($mail == " " or $mail == ""){ $mail = "none"; }
    else{ if(!preg_match("/^[\.A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $mail)) die("<center>This is not a valid e-mail</center>"); }
    if($comments == ""){ die("<center>Sorry but the comment can not be blank</center>"); }

    $time = time()+($config_date_adjust*60);


// Add the Comment
    $old_comments = file("$comm_file");
    $new_comments = fopen("$comm_file", "w");
    @flock ($new_comments,2);
    $found = FALSE;
    foreach($old_comments as $old_comments_line)
    {
		$old_comments_arr = explode("|>|", $old_comments_line);
		if($old_comments_arr[0] == $id)
		{
			$old_comments_arr[1] = trim($old_comments_arr[1]);
			fwrite($new_comments, "$old_comments_arr[0]|>|$old_comments_arr[1]$time|$name|$mail|$ip|$comments||\n");
            $found = TRUE;
        }else{
			fwrite($new_comments, $old_comments_line);
		}
	}
    if(!$found){ fwrite($new_comments, "$id|>|$time|$name|$mail|$ip|$comments||\n"); }
    @flock ($new_comments,3);
    fclose($new_comments);

// Add Flood Protection
    if($config_flood_time != "0" and $config_flood_time != "" ){

    	$flood_file = fopen("$cutepath/inc/flood.db.php", "a");
	    @flock ($flood_file,2);
        fwrite($flood_file, time()."|$ip|$id|\n");
	    @flock ($flood_file,3);
        fclose($flood_file);
    }
}
//####################################################################################################################
//		 Show Full Story and/or Comments
//####################################################################################################################
if($allow_full_and_comment){

/////// Show Full News Part
    if($subaction == "showfull" or (($subaction == "showcomments" or $subaction == "addcomment") and $config_show_full_with_comments == "yes"))
    {
        $all_active_news = file("$news_file");

        foreach($all_active_news as $active_news)
        {
            $news_arr = explode("|", $active_news);
            if($news_arr[0] == $id and (!$catid or $catid == $news_arr[6]))
            {
                $found = TRUE;
                if($news_arr[4] == "" and (!eregi("\{short-story\}", $template_full)) ){ $news_arr[4] = $news_arr[3]; }

                if($my_names[$news_arr[1]]){ $my_author = $my_names[$news_arr[1]]; }
        		else{ $my_author = $news_arr[1]; }

				$output = str_replace("{title}", $news_arr[2], $template_full);
				$output = str_replace("{date}", date($config_timestamp_active, $news_arr[0]), $output);
				$output = str_replace("{author}", $my_author, $output);
				$output = str_replace("{short-story}", $news_arr[3], $output);
				$output = str_replace("{full-story}", $news_arr[4], $output);
				$output = str_replace("{avatar}", "<img src=\"$news_arr[5]\" border=0 />", $output);
				$output = str_replace("{avatar-url}", "$news_arr[5]", $output);
				$output = str_replace("{comments-num}", countComments($news_arr[0], $archive), $output);
				$output = str_replace("{category}", $cat[$news_arr[6]], $output);
				$output = str_replace("{category-id}", $news_arr[6], $output);
				if($cat_icon[$news_arr[6]] != ""){ $output = str_replace("{category-icon}", "<img border=0 src=\"".$cat_icon[$news_arr[6]]."\" />", $output); }
				else{ $output = str_replace("{category-icon}", "", $output); }

        		if($config_comments_popup == "yes"){
					$output = str_replace("[com-link]","<a href=\"#\" onclick=\"window.open('$config_http_script_dir/show_news.php?subaction=showcomments&id=$news_arr[0]&archive=$archive&cnshow=$loc_show&start_from=$my_start_from&ucat=$news_arr[6]', '_News', '$config_comments_popup_string');return false;\">", $output);
				}else{
					$output = str_replace("[com-link]","<a href=\"$PHP_SELF?subaction=showcomments&id=$news_arr[0]&archive=$archive&cnshow=$loc_show&start_from=$my_start_from&ucat=$news_arr[6]&$user_query\">", $output);
				}
				$output = str_replace("[/com-link]","</a>", $output);


				$output = str_replace("{news-id}", $news_arr[0], $output);
				$output = str_replace("{archive-id}", $archive, $output);
				$output = str_replace("{php-self}", $PHP_SELF, $output);
				$output = str_replace("{cute-http-path}", $config_http_script_dir, $output);


				$output = replace_news("show", $output);

				echo $output;
            }
		}
    	if(!$found){ die("<center>Can not find an article with id: <b>$id</b></center>"); }
    }
/////// Show Comments Part
	if($subaction == "showcomments" or $subaction == "addcomment" or ($subaction == "showfull" and $config_show_comments_with_full == "yes"))
	{
		$all_comments = file("$comm_file");

		foreach($all_comments as $comment_line)
		{
			$comment_line = trim($comment_line);
			$comment_line_arr = explode("|>|", $comment_line);
			if($id == $comment_line_arr[0])
			{
				$individual_comments = explode("||", $comment_line_arr[1]);
                if($reverse_comments == TRUE){ $individual_comments = array_reverse($individual_comments); }
                foreach($individual_comments as $comment)
				{
					$comment_arr = explode("|", $comment);
					if($comment_arr[0] != "")
					{
						$comment_arr[4] = stripslashes(rtrim($comment_arr[4]));

						if($comment_arr[2] != "none"){ $output = str_replace("{author}", "<a href=\"mailto:".stripslashes($comment_arr[2])."\">".stripslashes($comment_arr[1])."</a>", $template_comment); }
						else{ $output = str_replace("{author}", $comment_arr[1], $template_comment); }

						$output = str_replace("{mail}", "$comment_arr[2]",$output);
						$output = str_replace("{date}", date($config_timestamp_comment, $comment_arr[0]),$output);
						$output = str_replace("{comment}", "$comment_arr[4]",$output);

						$output = replace_comment("show", $output);
						echo $output;
					}
				}
			}
		}
		$template_form = str_replace("{config_http_script_dir}", "$config_http_script_dir", $template_form);

	    $smilies_form = "\n<script language=\"javascript\">
		function insertext(text){
		document.comment.comments.value+=\" \"+ text;
        document.comment.comments.focus();
		}</script>".insertSmilies('short', FALSE);

	    $template_form = str_replace("{smilies}", $smilies_form, $template_form);
	    echo"<form method=POST name=comment>".$template_form."<input type=hidden name=subaction value=addcomment /><input type=hidden name=ucat value=\"$ucat\" /><input type=hidden name=show value=\"$show\" />$user_post_query</form>";
	}
}


//####################################################################################################################
//		 Active News and Headlines
//####################################################################################################################

if($allow_active_and_headline){

	$all_news = file("$news_file");
    if($reverse == TRUE){ $all_news = array_reverse($all_news); }
    if($cnshow != $loc_show){$my_start_from = "";}

    $count_all = 0;

    if($category and $category != ""){
	    foreach($all_news as $news_line){
			$news_arr = explode("|", $news_line);
			if($my_cats and $my_cats[$news_arr[6]] == TRUE){ $count_all ++; }
	        else{ continue; }
		}
	}else{ $count_all = count($all_news); }

    $i = 0;
    $showed = 0;
	$repeat = TRUE;
    $url_archive = $archive;
    while($repeat != FALSE){

		foreach($all_news as $news_line){

	   	$news_arr = explode("|", $news_line);
		if($category and $my_cats[$news_arr[6]] != TRUE){ continue; }

        if($start_from != "" and $cnshow == $loc_show){
        	if($i < $start_from){ $i++; continue; }
            elseif($showed == $number){  break; }
        }

        if($my_names[$news_arr[1]]){ $my_author = $my_names[$news_arr[1]]; }
        else{ $my_author = $news_arr[1]; }

        $output = $my_template;
        $output = str_replace("{title}", $news_arr[2], $output);
        $output = str_replace("{date}", date($config_timestamp_active, $news_arr[0]), $output);
        $output = str_replace("{author}", $my_author, $output);
        if($news_arr[5] != ""){$output = str_replace("{avatar}", "<img src=\"$news_arr[5]\" border=0>", $output); }
        else{ $output = str_replace("{avatar}", "", $output); }
		$output = str_replace("{avatar-url}", "$news_arr[5]", $output);
        $output = str_replace("[link]","<a href=$PHP_SELF?subaction=showfull&id=$news_arr[0]&archive=$archive&cnshow=$loc_show&start_from=$my_start_from&ucat=$news_arr[6]&$user_query>", $output);
        $output = str_replace("[/link]","</a>", $output);
        $output = str_replace("{comments-num}", countComments($news_arr[0], $archive), $output);
        $output = str_replace("{short-story}", $news_arr[3], $output);
        $output = str_replace("{full-story}", $news_arr[4], $output);
		$output = str_replace("{category}", $cat[$news_arr[6]], $output);
		$output = str_replace("{category-id}", $news_arr[6], $output);
		if($cat_icon[$news_arr[6]] != ""){ $output = str_replace("{category-icon}", "<img border=0 src=\"".$cat_icon[$news_arr[6]]."\">", $output); }
		else{ $output = str_replace("{category-icon}", "", $output); }


		$output = str_replace("{news-id}", $news_arr[0], $output);
		$output = str_replace("{archive-id}", $archive, $output);
		$output = str_replace("{php-self}", $PHP_SELF, $output);
		$output = str_replace("{cute-http-path}", $config_http_script_dir, $output);

        $output = replace_news("show", $output);


        if($news_arr[4] != "" or $action == "showheadlines"){//if full story
            if($config_full_popup == "yes"){

            	$output = preg_replace("/\\[full-link\\]/","<a href=\"#\" onclick=\"window.open('$config_http_script_dir/show_news.php?subaction=showfull&id=$news_arr[0]&archive=$archive&cnshow=news&ucat=$news_arr[6]>&start_from=$my_start_from', '_News', '$config_full_popup_string');return false;\">", $output);
            }else{
            	$output = str_replace("[full-link]","<a href=\"$PHP_SELF?subaction=showfull&id=$news_arr[0]&archive=$archive&cnshow=$loc_show&start_from=$my_start_from&ucat=$news_arr[6]&$user_query\">", $output);
            }
                $output = str_replace("[/full-link]","</a>", $output);
		}else{
			$output = preg_replace("'\[full-link\](.*?)\[/full-link\]'","<!-- no full story-->", $output);
		}

		if($config_comments_popup == "yes"){
			$output = str_replace("[com-link]","<a href=\"#\" onclick=\"window.open('$config_http_script_dir/show_news.php?subaction=showcomments&id=$news_arr[0]&archive=$archive&cnshow=news&start_from=$my_start_from&ucat=$news_arr[6]', '_News', '$config_comments_popup_string');return false;\">", $output);
		}else{
			$output = str_replace("[com-link]","<a href=\"$PHP_SELF?subaction=showcomments&id=$news_arr[0]&archive=$archive&cnshow=$loc_show&start_from=$my_start_from&ucat=$news_arr[6]&$user_query\">", $output);
		}
		$output = str_replace("[/com-link]","</a>", $output);


		echo $output;
		$showed++;
        $i++;

        if($number != 0 and $number == $i){ break; }
	    }
        $used_archives[$archive] = TRUE;
// Archives Looop
        if($i < $number and $only_active != TRUE){

			if(!$handle = opendir("$cutepath/archives")){ die("<center>Can not open directory $cutepath/archives "); }
         		while (false !== ($file = readdir($handle)))
                 {
         			if($file != "." and $file != ".." and eregi("news.arch", $file))
                     {
         				$file_arr = explode(".",$file);
                        $archives_arr[$file_arr[0]] = $file_arr[0];
         			}
         		}
			closedir($handle);

            $archives_arr[$in_use]="";
            $in_use = max($archives_arr);

			if($in_use != "" and !$used_archives[$in_use]){
				$all_news = file("$cutepath/archives/$in_use.news.arch");
				$archive = $in_use;
                $used_archives[$in_use] = TRUE;
			}else{ $repeat = FALSE; }

	    }else{ $repeat = FALSE; }
	}

// << Previouse   &   Next >>

    $prev_next_msg = $template_prev_next;

    if($start_from != "" and $start_from > 0){
    	$prev = $start_from - $number;
        $prev_next_msg = preg_replace("'\[prev-link\](.*?)\[/prev-link\]'", "<a href=$PHP_SELF?start_from=$prev&archive=$url_archive&subaction=$subaction&cnshow=$loc_show&id=$id&$user_query>\\1</a>", $prev_next_msg);
    }else{ $prev_next_msg = preg_replace("'\[prev-link\](.*?)\[/prev-link\]'", "\\1", $prev_next_msg); $no_prev = TRUE; }

    if($number < $count_all and $i < $count_all){
        $prev_next_msg = preg_replace("'\[next-link\](.*?)\[/next-link\]'", "<a href=$PHP_SELF?start_from=$i&archive=$url_archive&subaction=$subaction&cnshow=$loc_show&id=$id&$user_query>\\1</a>", $prev_next_msg);
    }else{ $prev_next_msg = preg_replace("'\[next-link\](.*?)\[/next-link\]'", "\\1", $prev_next_msg); $no_next = TRUE;}

    if	(
    	 	 ( !$no_prev or !$no_next)
         and ($cnshow == $loc_show or $cnshow == "" )
         and (($loc_show == "headlines" and $hide_prev_next_for_headlines != TRUE) or $loc_show != "headlines")
         and $hide_prev_next != TRUE
		){ echo $prev_next_msg; }
}

?>