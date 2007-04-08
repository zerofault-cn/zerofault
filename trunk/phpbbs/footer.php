<div valign="bottom">
<hr width="758" size='0.6' noshade>
<a href="/phpbbs/introduce.php">网站简介</a> | 
<a href="/phpbbs/board/insert_1.php">我要留言</a> |
<a href="/phpbbs/board/index.php">查看留言</a> |
<a href="mailto:zerofault@163.com"> 联系我</a><br>
Copyright &copy; 2002-2006 <a href="http://zerofault.8866.org/">海天一色</a> All Rights Reserved
<br />
声明：本站所有内容仅供个人学习测试使用，如有侵犯您的版权，请联系我改正。
<br />
<?php
session_start();
$filemod = filemtime($_SERVER["PHP_SELF"]);
$filemodtime = date("Y-n-j H:i:s", $filemod);
//if(!session_is_registered("count"))
{
	include_once $phpbbs_root_path.'/count.php';
	session_register("count");
}
$timer->stop();
echo ' 页面执行时间:'.$timer->spent().'秒<br />';
echo '<div style="font-size:12px;font-style:italic">'.$_SERVER["SERVER_SOFTWARE"].' serving at '.$_SERVER["SERVER_NAME"].' Port '.$_SERVER["SERVER_PORT"].'</div>';
?>
<script>
var a="zerofault";
</script>
<!-- <script src="http://count2.zhao123.com/stat.js"></script> -->
本页框架最后修改时间:<?=$filemodtime?> <a href='<?=$phpbbs_root_path?>/utilities/show_source.php'><span class="red">本页源代码</span></a>
</div>