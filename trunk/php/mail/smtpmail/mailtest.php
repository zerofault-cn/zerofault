<?
include "smtp.class.php";
$smtpserver = "webmail.bokee-inc.com";
$port = 25 ; //smtp服务器的端口，一般是 25
$smtpuser = "mingzhu@bokee-inc.com"; //您登录smtp服务器的用户名
$smtppwd = "zhuMING&*("; //您登录smtp服务器的密码
$smtp  =   new smtp_mail("$smtpserver","$port","$smtpuser","$smtppwd");
$from= "测试用户<test@test.com>"; //发件人,一般要与您登录smtp服务器的用户名($smtpuser)相同,否则可能会因为smtp服务器的设置导致发送失败
$to = "zerofault@gmail.com";
$subject = "你好";
$smtp->mailformat=1;//发送HTML格式的邮件 ,如果 $smtp->mailformat=0 则是发送普通文本格式的邮件
$body = "<h1>这是一个用 <font color='red'><b> php socket </b></font> 发邮件的测试。支持SMTP论证！</h1>";
$send=$smtp->send($from,$to,$subject,$body);
if($send==1){
echo "邮件发送成功";
}else{
echo "邮件发送失败<br>";
echo "原因：".$smtp->result_str;
}
?>
