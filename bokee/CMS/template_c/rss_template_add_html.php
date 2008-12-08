<html>
<style type="text/css">
<!--
table {
font-size: 14px;
}
.wraper {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	width:160px;
	border:1px solid black;
	padding:20px 10px;
}
-->
</style>

<body bgcolor="#FFFFFF" text="#000000">


      <form action="main.php?do=rss_template_do_add" name="template_add_form" method="post" enctype='multipart/form-data'>
        <table width="90%" border="0" cellspacing="1" cellpadding="10" bgcolor="#CCCCCC">
          <tr bgcolor="#FFFFFF"> 
            <tr bgcolor="#FFFFFF"> 
            <td>模板名称：</td>
            <td> 
              <input name="name" type="text" value="<?php
echo $_obj['name'];
?>
" maxlength="20"><?php
echo $_obj['action_error_template_name'];
?>

            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>生成文件名称：</td>
            <td> 
              <input name="file_name" type="text" value="<?php
echo $_obj['file_name'];
?>
" maxlength="20"><?php
echo $_obj['action_error_template_file_name'];
?>

            </td>
          </tr>
		   <tr bgcolor="#FFFFFF"> 
            <td>来源：</td>
            <td> 
              <input name=source[] type='checkbox' value='cms'>CMS <input name=source[] type='checkbox' value='rss'>RSS <input name=source[] type='checkbox' value='blogmark'>博采 <input name=source[] type='checkbox' value='column'>专栏 <input name=source[] type='checkbox' value='blog'>博客 
            </td>
          </tr> 
          <tr bgcolor="#FFFFFF"> 
            <td>是否设为默认模板：</td>
            <td> 
              <input name="radiodefault" type="radio" value="Y" checked>
              是
            <input type="radio" name="radiodefault" value="N">否</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>条目数：</td>
            <td> 
            <input name="limit" type="text" value="<?php
echo $_obj['limit'];
?>
" maxlength="5" size="5">
            </td>
          </tr>
          <tr bgcolor="#FFFFFF" align="center"> 
            <td colspan="2"> 
            <input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
            <input type="hidden" name="subject_id" value="<?php
echo $_obj['subject_id'];
?>
">
              <input type="submit" name="Submit" value="添加">
            </td>
          </tr>
        </table>
      </form>

</BODY>
</HTML>
