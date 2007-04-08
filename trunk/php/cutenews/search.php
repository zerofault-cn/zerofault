<?php

error_reporting (E_ALL ^ E_NOTICE);

$cutepath =  __FILE__;
$cutepath = preg_replace( "'\\\search\.php'", "", $cutepath);
$cutepath = preg_replace( "'/search\.php'", "", $cutepath);

require_once("$cutepath/inc/functions.inc.php");

// Show Search Form
echo<<<HTML
<script language='javascript' type="text/javascript">
	function mySelect(form){
	    form.select();
    }
	function ShowOrHide(d1, d2) {
	  if (d1 != '') DoDiv(d1);
	  if (d2 != '') DoDiv(d2);
	}
	function DoDiv(id) {
	  var item = null;
	  if (document.getElementById) {
		item = document.getElementById(id);
	  } else if (document.all){
		item = document.all[id];
	  } else if (document.layers){
		item = document.layers[id];
	  }
	  if (!item) {
	  }
	  else if (item.style) {
		if (item.style.display == "none"){ item.style.display = ""; }
		else {item.style.display = "none"; }
	  }else{ item.visibility = "show"; }
 	}
</script>
<form method=GET action="$PHP_SELF?subaction=search">
<input type=hidden name=dosearch value=yes>

<div align="right">
  <table border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><table width="100%" cellspacing="0" cellpadding="0">
          <td width="100%"  style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
            <p align="right">文章<input type=text value="$story" name=story size="24"   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
        </table></td>
    </tr>
    <tr>
      <td>

<div id='advanced' style='display:none;z-index:1;'>
<table width="100%" cellspacing="0" cellpadding="0">
          <td width="100%" align="right"   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
            <p align="right">标题<input type=text value="$title" name=title size="24"   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
  <tr>
    <td width="100%" align="right"   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">作者<input type=text value="$user" name=user size="24"   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
  </tr>
  <tr>
    <td width="100%" align="right"   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">自&nbsp;&nbsp;&nbsp;<select name=from_date_day   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
       <option value="" >  </option>
HTML;
for($i=1;$i<32;$i++){
    if($from_date_day == $i){ echo"<option selected value=$i>$i</option>"; }
    else{ echo"<option value=$i>$i</option>"; }
}

echo"</select><select name=from_date_month   style=\"font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;\">       <option value=\"\">  </option>";

for($i=1;$i<13;$i++){
    $timestamp = mktime(0,0,0,$i,1,2003);
    if($from_date_month == $i){ echo"<option selected value=$i>". date("M", $timestamp) ."</option>"; }
    else{ echo"<option value=$i>". date("M", $timestamp) ."</option>"; }
}

echo"</select><select name=from_date_year   style=\"font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;\">       <option value=\"\">  </option>";

for($i=2003;$i<2011;$i++){
    if($from_date_year == $i){ echo"<option selected value=$i>$i</option>"; }
    else{ echo"<option value=$i>$i</option>"; }
}
//////////////////////////////////////////////////////////////////////////
echo<<<HTML
  </tr>
  <tr>
    <td width="100%" align="right"   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">至&nbsp;&nbsp;&nbsp;<select name=to_date_day   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
       <option value="">  </option>
HTML;
for($i=1;$i<32;$i++){
    if($to_date_day == $i){ echo"<option selected value=$i>$i</option>"; }
    else{ echo"<option value=$i>$i</option>"; }
}

echo"</select><select name=to_date_month   style=\"font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;\"><option value=\"\">  </option>";

for($i=1;$i<13;$i++){
    $timestamp = mktime(0,0,0,$i,1,2003);
    if($to_date_month == $i){ echo"<option selected value=$i>". date("M", $timestamp) ."</option>"; }
    else{ echo"<option value=$i>". date("M", $timestamp) ."</option>"; }
}

echo"</select><select name=to_date_year   style=\"font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;\"><option value=\"\">  </option>";

for($i=2003;$i<2011;$i++){
    if($to_date_year == $i){ echo"<option selected value=$i>$i</option>"; }
    else{ echo"<option value=$i>$i</option>"; }
}

if($search_in_archives){ $selected_search_arch = "checked=\"checked\""; }

echo<<<HTML
      </select>
  </tr>
  <tr>
    <td width="100%" align="right"   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
      <p align="right"><label>归档文件<input type=checkbox $selected_search_arch name="search_in_archives" value="TRUE"></label>
  </tr>
</table>
</div>

          </td>
    </tr>
    <tr>
      <td   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
        <p align="right">&nbsp;
    <a href="javascript:ShowOrHide('advanced','')">高级</a>&nbsp;&nbsp; <input type=submit value=搜索   style="font-family:georgia, verdana, arial, sans-serif;color:#666; font-size:12;">
      </td>
    </tr>
  </table>
</div></form>
<left>
HTML;

// Don't edit below this line unless you know what you are doing !!!

if($dosearch == "yes")
{

    if( $from_date_day != "" and $from_date_month != "" and $from_date_year != "" and $to_date_day != "" and $to_date_month != "" and $to_date_year != "" )
    {
        $date_from 	= mktime(0,0,0,$from_date_month,$from_date_day,$from_date_year);
        $date_to 	= mktime(0,0,0,$to_date_month,$to_date_day,$to_date_year);

        $do_date = TRUE;
    }


	$story = trim($story);

	if($search_in_archives){
    	if(!$handle = opendir("$cutepath/archives")){ die("<left>不能打开目录$cutepath/存档 "); }
		while (false !== ($file = readdir($handle)))
		{
			if($file != "." and $file != ".." and eregi("news", $file))
			{
				$files_arch[] = "$cutepath/archives/$file";
	        }
		}
	}
    $files_arch[] = "$cutepath/news.txt";

    foreach($files_arch as $file)
    {
        $archive = FALSE;
        if(ereg("([[:digit:]]{0,})\.news\.arch", $file, $regs)){ $archive = $regs[1]; }
        $all_news_db = file("$file");
    	foreach($all_news_db as $news_line){
			$news_db_arr = explode("|",$news_line);
			$found  = 0;

			$fuser  = FALSE;
			$ftitle = FALSE;
			$fstory = FALSE;
			if($title and @preg_match("/$title/i", "$news_db_arr[2]")){ $ftitle = TRUE; }
			if($user  and @preg_match("/\b$user\b/i", "$news_db_arr[1]")){ $fuser = TRUE; }
			if($story and (@preg_match("/$story/i", "$news_db_arr[4]") or @preg_match("/$story/i", "$news_db_arr[3]"))){ $fstory = TRUE;}

			if($title and $ftitle){ $ftitle = TRUE; }elseif(!$title){ $ftitle = TRUE; }else{ $ftitle = FALSE; }
			if($story and $fstory){ $fstory = TRUE; }elseif(!$story){ $fstory = TRUE; }else{ $fstory = FALSE; }
			if($user  and $fuser) { $fuser  = TRUE; }elseif(!$user) { $fuser  = TRUE; }else{ $fuser  = FALSE; }
            if($do_date)
            {
            	if($date_from < $news_db_arr[0] and  $news_db_arr[0] < $date_to){ $fdate = TRUE; }else{ $fdate = FALSE; }
            }else{ $fdate = TRUE; }

			if($fdate and $ftitle and $fuser and $fstory){ $found_arr[$news_db_arr[0]] = $archive; }

		}//foreach news line
	}


	echo"<br /><b>搜索到如下文章[". count($found_arr)."]：</b><br />";


    	if($do_date){echo"自".@date("d F Y",$date_from)."至".@date("d F Y",$date_to)."<br />";}


    // Display Search Results
    if(is_array($found_arr)){
        foreach($found_arr as $news_id => $archive)
        {
            if($archive){$all_news = file("$cutepath/archives/$archive.news.arch");}
            else{ $all_news = file("$cutepath/news.txt"); }

            foreach($all_news as $single_line)
   			{
   				$item_arr = explode("|",$single_line);
   				$local_id = $item_arr[0];

   				if($local_id == $news_id){
////////// Showing Result

//                    echo"<br /><b><a href=\"$PHP_SELF?misc=search&subaction=showfull&id=$local_id&archive=$archive&cnshow=news&start_from=\">$item_arr[2]</a></b> 作者 $item_arr[1]";
                    echo"<br /><b><a href=\"$PHP_SELF?misc=search&subaction=showfull&id=$local_id&archive=$archive&cnshow=news&start_from=\">$item_arr[2]</a></b>";

////////// End Showing Result
                }
   			}
   		}
     }else{ echo"搜索不到符合指定条件的文章"; }

}//if user wants to search
elseif( ($misc == "search") and ($subaction == "showfull" or $subaction == "addcomment")){

	require_once("$cutepath/show_news.php");

	unset($action,$subaction);
}

?>