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
        <td width="100" bgcolor="C1D7F4" align="center">Flash头图添加</td>
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
    <td bgcolor="#FFFFFF"> 
      <form action="main.php?do=flash_do_add_new" name="subject_form" method="post" enctype='multipart/form-data'>
        <table width="90%" border="0" cellspacing="1" cellpadding="10" bgcolor="#CCCCCC">
          <tr bgcolor="#FFFFFF"> 
            <td>f头条命名：</td>
            <td><input name="name" type="text" value="<?php
echo $_obj['name'];
?>
"></td>
          </tr>    
		   <tr bgcolor="#FFFFFF"> 
            <td>图片目录名称：</td>
            <td> 
              <input name="picdir" type="text" value="<?php
echo $_obj['picdir'];
?>
" maxlength="100">
            </td>
          </tr> 
	      <tr bgcolor="#FFFFFF"> 
            <td>flash文件：</td>
            <td><input type="file" name="flash_file"> 
              </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>xml文件：</td>
            <td><input type="file" name="xml_file"> 
              </td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>css文件：</td>
            <td><input type="file" name="css_file"> 
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
    </td>
  </tr>
</table>
</BODY>
</HTML>
