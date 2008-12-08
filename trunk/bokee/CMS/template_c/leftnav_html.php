<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>导航</title>
<style type="text/css">
<!--
body {
font-size: 12px;
}
.wraper {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	width:160px;
	border:1px solid black;
	padding:5px 10px;
	margin:3px 0px;
}
h1 {
text-align:center;
font-size:12px;
margin:0px 0px;
}
h2 {
font-size:12px;
padding:4px 10px;
margin:0px 0px;
color:#FFFFFF;
background-color:#134268;
text-align: center;
}
h3 {
font-size:12px;
background-color: #eeeeee;
padding:4px 10px;
margin:0px 0px;

}
h3 a{
color:blue;
text-decoration: none;
}
h3 a:hover{
color:red;
text-decoration: underline;
}
h3 a:visited{
color:blue;
text-decoration: none;
}
/* Style for tree item text */
.t0i {
		font-family: Tahoma, Verdana, Geneva, Arial, Helvetica, sans-serif;
		font-size: 12px;
		color: #000000;
		background-color: #ffffff;
		text-decoration: none;
}
/* Style for tree item image */
.t0im {
	border: 0px;
	width: 20px;
	height: 16px;
}
-->
</style>
<script language="JavaScript" src="tree.js"></script>
<script language="javascript">
<?php
echo $_obj['script'];
?>

</script>

</head>

<body>
<h1>博客网CMS</h1>
<h1>用户：<?php
echo $_obj['name'];
?>
</h1>
<p>
<script language="JavaScript">tree (TREE_ITEMS, tree_tpl); </script>
</p>
</body>
</html>
