<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>博客网CMS系统</title>
</head>
<frameset rows="50%,50%" cols="*" framespacing="10" frameborder="yes" border="10" bordercolor="#336699">
  <frame src="main.php?do=flash_edit_new&channel_name=<?php
echo $_obj['channel_name'];
?>
&id=<?php
echo $_obj['id'];
?>
" name="leftFrame" scrolling="auto">
  <frame src="main.php?do=flash_xml_edit&channel_name=<?php
echo $_obj['channel_name'];
?>
&id=<?php
echo $_obj['id'];
?>
" name="mainFrame">
</frameset>
<noframes><body>
</body></noframes>
</html>
