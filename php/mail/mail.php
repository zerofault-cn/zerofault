<?
//-------------------------------------
//��ĵ��÷���
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

//˵����
//headers[]Ϊ�Զ����ʼ�ͷ��ʽ����ʡ�ԡ�
//disposition[]Ϊ��������ʾ��ʽ��Ĭ��Ϊattachment
//MIMEType[]Ϊ�����ļ���MIME���ͣ����Բ�ָ����������Զ��жϡ�
//CharSet Ϊ�ʼ��ַ����� Ĭ��Ϊgb2312
//-------------------------------------

?>