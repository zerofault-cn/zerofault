

<?php
/*
没有mail(),我用socket 
在网上看到了有人写了个SOCKET发邮件的例子,可我老是运行不了
算了,我自己写了一个,结果成功了,根本不用PHP还不算真正的类的"类".
代码如下:
*/
//定义相关变量
set_time_limit ( 120 ) ;
$host="smtp.163.com"; //网易的油箱,建议使用
$username=base64_encode("zerofault"); //改成你的用户名
$pwd=base64_encode("548512"); //改为你自己的密码
$from="zerofault@163.com"; //你的邮箱名称
$to="zerofault@126.com"; //要发送的邮箱
$subject="Test";
$headers="Hello";
$message="测试成功!2003-11-27 13:03";

//连接服务器
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


//发信
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

//关闭服务器
fputs($connection,"QUIT\n");
$res=fgets($connection,250);
echo $res."10"."<br>";

?>

