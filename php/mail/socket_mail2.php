

<?php
/*
û��mail(),����socket 
�����Ͽ���������д�˸�SOCKET���ʼ�������,�����������в���
����,���Լ�д��һ��,����ɹ���,��������PHP���������������"��".
��������:
*/
//������ر���
set_time_limit ( 120 ) ;
$host="smtp.163.com"; //���׵�����,����ʹ��
$username=base64_encode("zerofault"); //�ĳ�����û���
$pwd=base64_encode("548512"); //��Ϊ���Լ�������
$from="zerofault@163.com"; //�����������
$to="zerofault@126.com"; //Ҫ���͵�����
$subject="Test";
$headers="Hello";
$message="���Գɹ�!2003-11-27 13:03";

//���ӷ�����
$connection = fsockopen ($host, 25, &$errno, &$errstr, 1);
$res=fgets($connection,256);
echo $res."1"."<br>";

fputs($connection, "EHLO \n");
$res=fgets($connection,256);
echo $res."2"."<br>";

fputs($connection, "AUTH LOGIN \n");
$res=fgets($connection,334);
echo $res."3"."<br>";

fputs($connection, "$username\n");
$res=fgets($connection,334);
echo $res."4"."<br>";

fputs($connection, "$pwd\n");
$res=fgets($connection,235);
echo $res."5"."<br>";


//����
fputs($connection, "MAIL FROM: $from\n");
$res=fgets($connection,250);
echo $res."6"."<br>";

fputs($connection, "RCPT TO: $to\n");
$res=fgets($connection,250);
echo $res."7"."<br>";


fputs($connection, "DATA\n");
$res=fgets($connection,354);
echo $res."8"."<br>";


fputs($connection, "To: $to\nFrom: $from\nSubject: $subject\n$headers\n\n$message\n.\n");
$res=fgets($connection,256);
echo $res."9"."<br>";

//�رշ�����
fputs($connection,"QUIT\n");
$res=fgets($connection,250);
echo $res."10"."<br>";

?>

