<?php
$ID=$_GET['id'];
$arr=$oSync_XML->view($ID);
if(empty($_GET['field']))
{
	header("content-type: text/xml");
	echo $arr['Content'];
}
else
{
	echo '<a href="javascript:void(0)" onclick="tb_remove();">Close</a>';
	echo '<pre>';
	echo $arr[$_GET['field']];
	echo '</pre>';
}
exit;
?>