<?
$smtpuser = "mingzhu@bokee-inc.com"; //您登录smtp服务器的用户名
$smtppwd = "zhuMING&*("; //您登录smtp服务器的密码

function send_mail($to_address, $to_name ,$subject, $body, $attach = '')
{
//使用phpmailer发送邮件
include_once("class.phpmailer.php");
$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTP
$mail->CharSet = 'gb2312';
$mail->Encoding = 'base64';
$mail->From = 'zerofault@gmail.com';
$mail->FromName = '朱明';
//$mail->Sender = ‘fwolf.mailagent@gmail.com’;
//$mail->ConfirmReadingTo = ‘fwolf.mailagent@gmail.com’; //回执？

//$mail->Host = 'ssl://webmail.bokee-inc.com';
$mail->Host = 'ssl://smtp.gmail.com';
$mail->Port = 465; //default is 25, gmail is 465 or 587
$mail->SMTPAuth = true;
$mail->Username = $mail->From;
$mail->Password = "548512";

$mail->addAddress($to_address, $to_name);
//$mail->AddReplyTo(’fwolf.aide@gmail.com’, “Fwolf”); //针对gmail无用，gmail是In-Reply-To:，phpmailer默认生成的是Reply-to:
$mail->WordWrap = 50;
if (!empty($attach))
$mail->AddAttachment($attach);
$mail->IsHTML(false);
$mail->Subject = $subject;
$mail->Body = $body;
//$mail->AltBody = “This is the body in plain text for non-HTML mail clients”;

if(!$mail->Send())
{
echo "Mail send failed.\r\n";
echo "Error message: ” . $mail->ErrorInfo . “\r\n";
return false;
}
else
{
echo("Send $attach to $to_name <$to_address> successed.\r\n");
return true;
}
//echo “Message has been sent”;
//
} 
send_mail('zoudeshun666@sina.com.cn','to zou de shun','你好','this is body','');

?>
