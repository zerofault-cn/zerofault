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
<table width="90%" border="1" align="center" cellpadding="20" bordercolor="C1D7F4">
  <tr>
    <td><table width="98%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10">&nbsp;</td>
        <td width="100" bgcolor="C1D7F4" align="center">修改</td>
        <td >&nbsp;</td>
      </tr>
      <tr bgcolor="C1D7F4">
        <td height="1"></td>
        <td height="1"></td>
        <td height="1"></td>
      </tr> 
    </table>
  
<table width="80%" border="0" cellspacing="2" cellpadding="10" bgcolor="#c1d7f4" align="center">
  <tr>
    <td bgcolor="#FFFFFF"><form action="main.php?do=flash_xml_do_edit" name="subject_form" method="post" enctype='multipart/form-data'>
        <table width="90%" border="0" cellspacing="1" cellpadding="10" bgcolor="#CCCCCC"><tr bgcolor="#FFFFFF">
            <td>名称：</td>
			
            <td><?php
echo $_obj['filename'];
?>

              <?php
echo $_obj['action_error_crontab_name'];
?>

			  <input type="HIDDEN" name="filename" value="<?php
echo $_obj['filename'];
?>
"></td>

          <tr bgcolor="#FFFFFF">
            <td>内容：</td>
            <td><textarea name="content" cols="75" rows="25" type="text" ><?php
echo $_obj['content'];
?>
</textarea></td>
          </tr>
          <tr bgcolor="#FFFFFF" align="center">
            <td colspan="2"><INPUT TYPE="hidden" NAME="channel_name" value="<?php
echo $_obj['channel_name'];
?>
"><INPUT TYPE="hidden" NAME="path" value="<?php
echo $_obj['path'];
?>
"><INPUT TYPE="hidden" NAME="id" value="<?php
echo $_obj['id'];
?>
"><input type="submit" name="Submit" value="修改">
            </td>
          </tr>
        </table>
    </form></td>
  </tr>
</table>
</BODY>
</HTML>