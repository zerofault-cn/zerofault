<html>
 <form action="main.php?do=block_do_modify" name="block_modify_form" method="post" enctype='multipart/form-data'>
<table>
<tr><td>栏目</td><td>
<select name="select_subject" id="select_subject">
<?php
echo $_obj['options'];
?>

</select>
(选中栏目文章显示时包含子栏目)
</td></tr>
<tr><td>名称</td><td>
<input name="name" type="text" value="<?php
echo $_obj['name'];
?>
" maxlength="20">
</td></tr>
<tr><td>来源</td><td>
<?php
echo $_obj['source'];
?>

</td></tr>
<tr><td>起始ID</td><td>
<input name="start_id" type="text" value="<?php
echo $_obj['start_id'];
?>
" maxlength="5" size="5">
&nbsp;&nbsp;&nbsp;&nbsp;条目数
<input name="limit" type="text" value="<?php
echo $_obj['limit'];
?>
" maxlength="5" size="5">
</td></tr>
<?php
echo $_obj['str_title_length'];
?>

<tr><td>星级</td><td>
<select name="mark" id="mark">
<?php
echo $_obj['mark'];
?>

</select>1星为最低等低，5星为最高等级，rss文章为1星
</td></tr>
<tr><td>格式</td><td>
<textarea name="format" cols="50" rows="10" id="format"><?php
echo $_obj['format'];
?>
</textarea>
<br>变量用大括号括起来，常用变量：<br>
title,url,source,datetime,datetime1,datetime2,datetime3,datetime4,<br>
datetime5,author,comment,subject,subject_link。<br>
时间格式范例：datetime: 8/21 12:12, datetime1: 8-21 12:12:12, datetime2: 8/21, <br>
datetime3: 12:12, datetime4: 2005-8-21 12:12:12, datetime5: 2005-8-21
</td></tr>
</table>
<input type="hidden" name="subject_id" value="<?php
echo $_obj['subject_id'];
?>
">
<input type="hidden" name="id" value="<?php
echo $_obj['id'];
?>
">
<input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
<input type="submit" name="Submit" value="保存">
</form>
</html>