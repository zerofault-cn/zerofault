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
textarea {
	font-size:12px;
}
-->
</style>

<body bgcolor="#FFFFFF" text="#000000">


      <form action="main.php?do=template_do_add" name="template_add_form" method="post" enctype='multipart/form-data'>
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
" maxlength="40"><?php
echo $_obj['action_error_template_file_name'];
?>

            </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>模板内容：</td>
            <td> 
            <textarea name="content" cols="100" rows="30" id="content"><?php
echo $_obj['content'];
?>
</textarea>
            <?php
echo $_obj['action_error_template_content'];
?>

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
