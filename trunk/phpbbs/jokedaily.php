<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title></title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

<?php
	$day=date("d");
	$filename="/document/joke/joke/$day.txt";
	$fp=fopen($filename,"r"); 
	$content=str_replace("\r","<br>",fread($fp,filesize($filename)));
	
	fclose( $fp );
	echo $content;
	?>
</body>
</html>