<?
//-------------------------------------
//类的调用方法
//-------------------------------------
include("mime_mail_class.php");
$message=new MIMEMail();
$message->to="zerofault@163.com";
$message->subject="Hello!";
$message->headers["Reply-To"]="zerofault@zerofault.8866.org";
$message->headers["From"]="zerofault@zerofault.8866.org";
$message->attachments[0]="images/ad.swf";
$message->attachments[1]="images/index.html";
//$message->disposition[0]="inline";
//$message->disposition[1]="attachment";
//$message->MIMEType[0]="image/gif";
//$message->MIMEType[1]="application/zip";
$message->body="<h1>Thank you very much!</h1>";
$message->CharSet="gb2312";
$message->SendMail();

//说明：
//headers[]为自定义邮件头格式，可省略。
//disposition[]为附件的显示方式，默认为attachment
//MIMEType[]为附件文件的MIME类型，可以不指定，程序会自动判断。
//CharSet 为邮件字符编码 默认为gb2312
//-------------------------------------

?>