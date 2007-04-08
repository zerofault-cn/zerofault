<?
$message="abcdefghijklmnopqrstuvwxyz";
echo mail("zerofault@eyou.com", "没有主题", $message, "From: zerofault@zerofault.8866.org\nReply-To: zerofault@zerofault.8866.org\nX-Mailer: PHP/" . phpversion());
?>