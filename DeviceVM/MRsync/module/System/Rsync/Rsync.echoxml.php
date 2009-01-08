<?php
$ID=$_GET['id'];
$arr=$oSync_XML->view($ID);
header("content-type: text/xml");
echo $arr['Content'];
exit;
?>