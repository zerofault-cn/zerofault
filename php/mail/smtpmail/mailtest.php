<?
include "smtp.class.php";
$smtpserver = "webmail.bokee-inc.com";
$port = 25 ; //smtp�������Ķ˿ڣ�һ���� 25
$smtpuser = "mingzhu@bokee-inc.com"; //����¼smtp���������û���
$smtppwd = "zhuMING&*("; //����¼smtp������������
$smtp  =   new smtp_mail("$smtpserver","$port","$smtpuser","$smtppwd");
$from= "�����û�<test@test.com>"; //������,һ��Ҫ������¼smtp���������û���($smtpuser)��ͬ,������ܻ���Ϊsmtp�����������õ��·���ʧ��
$to = "zerofault@gmail.com";
$subject = "���";
$smtp->mailformat=1;//����HTML��ʽ���ʼ� ,��� $smtp->mailformat=0 ���Ƿ�����ͨ�ı���ʽ���ʼ�
$body = "<h1>����һ���� <font color='red'><b> php socket </b></font> ���ʼ��Ĳ��ԡ�֧��SMTP��֤��</h1>";
$send=$smtp->send($from,$to,$subject,$body);
if($send==1){
echo "�ʼ����ͳɹ�";
}else{
echo "�ʼ�����ʧ��<br>";
echo "ԭ��".$smtp->result_str;
}
?>
