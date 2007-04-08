<?
class send_mail{
function send($mailto,$mailfrom,$frominfo,$subject,$message)
{
$smtp = "smtp.163.com";                    //邮件服务器地址
$auth_username = "zerofault";        // 验证用户名
$auth_password = "548512";            // 验证密码
$toinfo = $mailto;                        //这是我的设定，你可以改变的
//$mailfrom = "";                        发件人地址
//$mailto = ""                            收件人地址
//$frominfo = ""                        发件人信息
//$toinfo = ""                            收件人信息
//$message = ""                            信件内容
//$subject = ""                            主题
//邊線服務器
$mail_con=fsockopen($smtp,25,$errno,$errstr,120) or die("不能连接到邮件服务器!");
$rtn=fgets($mail_con,512);
if( !ereg("^220",$rtn) )
{
   //設置出錯誤提示
   fclose($mail_con);
   return false;
}
//調試程序咝悬c
//開始溝通
fputs($mail_con,"helo aNErG\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^250",$rtn) )
{
   //設置出錯誤提示
   fclose($mail_con);
   return false;
}
//調試程序咝悬c
//開始認證用戶名密碼
fputs($mail_con,"auth login\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^334",$rtn) )
{
   //設置出錯誤提示
   fclose($mail_con);
   return false;
}
//調試程序咝悬c

//提交用戶名
fputs($mail_con,base64_encode($auth_username)."\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^334",$rtn) )
{
   //設置出錯誤提示
   fclose($mail_con);
   return false;
}
//調試程序咝悬c
//提交密碼
fputs($mail_con,base64_encode($auth_password)."\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^235",$rtn) )
{
   //設置出錯誤提示
   fclose($mail_con);
   return false;
}
//調試程序咝悬c
//提交發信人EMAIL址
fputs($mail_con,"mail from:$mailfrom \r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^250",$rtn) )
{
   //設置出錯誤提示
   fclose($mail_con);
   return false;
}
//調試程序咝悬c
//收信人EMAIL址
fputs($mail_con,"rcpt to:$mailto \r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^250",$rtn) )
{
   //設置出錯誤提示
   fclose($mail_con);
   return false;
}
//調試程序咝悬c
//開始寫數據
fputs($mail_con,"data\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^354",$rtn) )
{
   //設置出錯誤提示
   fclose($mail_con);
   return false;
}
//調試程序咝悬c
//信件內容
fputs($mail_con,"DATA\r\n");
$tosend  = "From: $frominfo\r\n";
$tosend .= "To: $toinfo\r\n";
$tosend .= 'Subject: '.str_replace("\n", ' ', $subject)."\r\n\r\n$message\r\n.\r\n"; 
fputs($mail_con, $tosend);
$rtn=fgets($mail_con,512);
if( !ereg("^250",$rtn) )
{
   //設置出錯誤提示
   fclose($mail_con);
   return false;
}
//調試程序咝悬c
//發信完畢，關閉連接
fputs($mail_con,"quit\r\n");
$rtn=fgets($mail_con,512);
if( !ereg("^221",$rtn) )
{
   //設置出錯誤提示
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
