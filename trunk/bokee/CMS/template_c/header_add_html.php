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
        <td width="100" bgcolor="C1D7F4" align="center">添加头条管理</td>
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
      <form action="main.php?do=header_do_add" name="header_add_form" method="post" enctype='multipart/form-data'>
        <table width="90%" border="0" cellspacing="1" cellpadding="10" bgcolor="#CCCCCC"><tr bgcolor="#FFFFFF"> 
            <td>头条名称</td>
            <td> 
              <input name="name" type="text" value="<?php
echo $_obj['name'];
?>
"></td>
          </tr>
		  <tr bgcolor="#FFFFFF"> 
            <td>栏目名称</td>
            <td> <?php
echo $_obj['subject_name'];
?>
</td>
          </tr>
          <tr bgcolor="#FFFFFF"> 
            <td>内容</td>
            <td> 
<?php
echo $_obj['options'];
?>
            </td>
          </tr>
          <tr bgcolor="#FFFFFF" align="center"> 
            <td colspan="2"> 
              <input type="submit" name="Submit" value="确定">
			  <input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
			  <input type="hidden" name="subject_id" value="<?php
echo $_obj['subject_id'];
?>
">
			  <input type="hidden" name="parent_id" value="<?php
echo $_obj['parent_id'];
?>
">
			  <input type="hidden" name="sort" value="<?php
echo $_obj['sort'];
?>
">
			  
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
</BODY>
</HTML>

