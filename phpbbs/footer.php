<div valign="bottom">
<hr width="758" size='0.6' noshade>
<a href="/phpbbs/introduce.php">��վ���</a> | 
<a href="/phpbbs/board/insert_1.php">��Ҫ����</a> |
<a href="/phpbbs/board/index.php">�鿴����</a> |
<a href="mailto:zerofault@163.com"> ��ϵ��</a><br>
Copyright &copy; 2002-2006 <a href="http://zerofault.8866.org/">����һɫ</a> All Rights Reserved
<br />
��������վ�������ݽ�������ѧϰ����ʹ�ã������ַ����İ�Ȩ������ϵ�Ҹ�����
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
echo ' ҳ��ִ��ʱ��:'.$timer->spent().'��<br />';
echo '<div style="font-size:12px;font-style:italic">'.$_SERVER["SERVER_SOFTWARE"].' serving at '.$_SERVER["SERVER_NAME"].' Port '.$_SERVER["SERVER_PORT"].'</div>';
?>
<script>
var a="zerofault";
</script>
<!-- <script src="http://count2.zhao123.com/stat.js"></script> -->
��ҳ�������޸�ʱ��:<?=$filemodtime?> <a href='<?=$phpbbs_root_path?>/utilities/show_source.php'><span class="red">��ҳԴ����</span></a>
</div>