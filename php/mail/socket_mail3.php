<?
class send_mail{
function send($mailto,$mailfrom,$frominfo,$subject,$message)
{
$smtp = "smtp.163.com";                    //�ʼ���������ַ
$auth_username = "zerofault";        // ��֤�û���
$auth_password = "548512";            // ��֤����
$toinfo = $mailto;                        //�����ҵ��趨������Ըı��
//$mailfrom = "";                        �����˵�ַ
//$mailto = ""                            �ռ��˵�ַ
//$frominfo = ""                        ��������Ϣ
//$toinfo = ""                            �ռ�����Ϣ
//$message = ""                            �ż�����
//$subject = ""                            ����
//߅��������
$mail_con=fsockopen($smtp,25,$errno,$errstr,120) or die("�������ӵ��ʼ�������!");
$rtn=fgets($mail_con,512);
if( !ereg("^220",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
//�{ԇ��������c
//�_ʼ��ͨ
fputs($mail_con,"helo aNErG\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^250",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
//�{ԇ��������c
//�_ʼ�J�C�Ñ����ܴa
fputs($mail_con,"auth login\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^334",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
//�{ԇ��������c

//�ύ�Ñ���
fputs($mail_con,base64_encode($auth_username)."\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^334",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
//�{ԇ��������c
//�ύ�ܴa
fputs($mail_con,base64_encode($auth_password)."\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^235",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
//�{ԇ��������c
//�ύ�l����EMAILַ
fputs($mail_con,"mail from:$mailfrom \r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^250",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
//�{ԇ��������c
//������EMAILַ
fputs($mail_con,"rcpt to:$mailto \r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^250",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
//�{ԇ��������c
//�_ʼ������
fputs($mail_con,"data\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^354",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
//�{ԇ��������c
//�ż�����
fputs($mail_con,"DATA\r\n");
$tosend  = "From: $frominfo\r\n";
$tosend .= "To: $toinfo\r\n";
$tosend .= 'Subject: '.str_replace("\n", ' ', $subject)."\r\n\r\n$message\r\n.\r\n"; 
fputs($mail_con, $tosend);
$rtn=fgets($mail_con,512);
if( !ereg("^250",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
//�{ԇ��������c
//�l���ꮅ���P�]�B��
fputs($mail_con,"quit\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^221",$rtn) )
{
   //�O�ó��e�`��ʾ
   fclose($mail_con);
   return false;
}
}
}
$mailto="zerofault@163.com";
$mailfrom="zerofault@163.com";
$frominfo="null";
$subject="test";
$message="2003-11-27 13:15 ";
$sendmail=new send_mail;
$sendmail->send( $touser,"zerofault", $frominfo , $subject , $email);
?>
