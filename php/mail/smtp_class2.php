PHP SMTP类 
<?
/*********************************** 
PHP MIME　SMTP ver 1.0 Powered by Boss_ch， Unigenius soft ware co. Ltd 
All rights reserved, Copyright 2000 ;
本类用　PHP　通过　smtp 　sock 操作发送　MIME 类型的邮件，可以发送 
HTML 格式的正文、附件，采用　base64 编码 
本版本是针对个人的发送，与多人群发版本不同的是，每发送到一个人，就重新进行一次编码，在接收端的用户看来，只是发送给他一个人的。 
针对多人群发的情况，只发送一次，通过多个　RCPT　TO　命令发送到不同的人信箱中， 
说明： 
请把　$hostname 设为你有权限的　默认　smtp 服务器或是在　new 时指定 
把　$charset 改成你的默认　字符集 
Html 正文中如有图片，请用绝对路径的引用　"httP://host/path/image.gif";
　　并连上网，以保证程序能读取到图片的数据信息 
如果是通过表单提交过来的　Html 正文，请先用　StripSlashes($html_body)　把正文内容进行预处理 
　　Html 中用到的样式表文件，请不要用　<link >之类　的引用，直接把样式表定义放在 
<style></style>标签中 

转载请保留此版权信息，　Bugs Report : boss_ch@china.com 
*************************************/ 
if(!isset($__smtp_class__)){
$__smtp_class__=1;

class smtp 
{
var $hostname="";
var $port=25;
var $connection=0;
var $debug=1;

var $timeout=30;
var $err_str;
var $err_no;

var $autocode=true;
var $charset="??????";
var $subject="";
var $body="";
var $attach="";
var $temp_text_body;
var $temp_html_body;
var $temp_body_images;

var $bound_begin="=====powered_by_boss_chen_";
var $bound_end="_046484063883_=====";

Function smtp($server="smtp.china.com",$port=25,$time_out=20) 
{$this->hostname=$server;
$this->port=$port;
$this->timeout=$time_out;
return true;
}

Function outdebug($message)
{
echo htmlspecialchars($message)."<br>\n";
}


function command($command,$return_lenth=1,$return_code='2') 
{
if ($this->connection==0) 
{
$this->err_str="没有连接到任何服务器，请检查网络连接";
return false;
}
if ($this->debug) 
$this->outdebug(">>> $command");
if (!fputs($this->connection,"$command \r\n")) 
{
$this->err_str="无法发送命令".$command;
return false;
}
else 
{
$resp=fgets($this->connection,256);
if($this->debug) 
$this->outdebug("$resp");
if (substr($resp,0,$return_lenth)!=$return_code) 
{
$this->err_str=$command." 命令服务器返回无效:".$resp;
return false;
}
else 
return true;
}
}


Function open() 
{
if($this->hostname=="") 
{$this->err_str="无效的主机名!!";
return false;
}

if ($this->debug) echo "$this->hostname,$this->port,&$err_no, &$err_str, $this->timeout<BR>";
if (!$this->connection=fsockopen($this->hostname,$this->port,&$err_no, &$err_str, $this->timeout)) 
{
$this->err_str="连接到　SMTP 服务器失败,错误信息：".$err_str."错误号：".$err_no;
return false;
}
else 
{
$resp=fgets($this->connection,256);
if($this->debug) 
$this->outdebug("$resp");
if (substr($resp,0,1)!="2") 
{$this->err_str="服务器返回无效的信息：".$resp."请检查SMTP服务器是否正确";
return false;
}
return true;
}
}


Function Close() 
{
if($this->connection!=0) 
{
fclose($this->connection);
$this->connection=0;
}
}

Function Buildhead($from_name,$to_name,$from_mail,$to_mail,$subject) 
{
if (empty($from_name)) 
$from_name=$from_mail;
if (empty($to_name)) $to_name=$to_mail;
$this->subject="From: =?$this->charset?B?".base64_encode($from_name)."?=<$from_mail>\r\n";
$this->subject.="To: =?$this->charset?B?".base64_encode($to_name)."?=<$to_mail>\r\n";
$subject=ereg_replace("\n","",$subject);
$this->subject.="Subject: =?$this->charset?B?".base64_encode($subject)."?=\r\n";
if ($this->debug) echo nl2br(htmlspecialchars($this->subject));
return true;
}


Function parse_html_body($html_body=null) 
{
$passed="";
$image_count=0;
$this->temp_body_images=array();
while (eregi("\<*img([^\>]+)src[[:space:]]*=[[:space:]]*([^ ]+)",$html_body,$reg)) 
{

$pos=@strpos($html_body,$reg[0]);
$passed.=substr($html_body,0,$pos);
$html_body=substr($html_body,$pos+strlen($reg[0]));
$image_tag=$reg[2];
$image_att=$reg[1];
$tag_len=strlen($image_tag);
if ($image_tag[0]=="'" or $image_tag[0]=='"') 
$image_tag=substr($image_tag,1);
if (substr($image_tag,strlen($imgage_tag)-1,1)=="'" or substr($image_tag,strlen($imgage_tag)-1,1)=='"') 
$image_tag=substr($image_tag,0,strlen($imgage_tag)-1);
//echo $image_tag."<br>";
$cid=md5(uniqid(rand()));
$cid=substr($cid,0,15)."@unigenius.com";
$passed.="<img ".$image_att."src=\"cid:".$cid."\"";
$end_pos=@strpos($html_body,'>');
$passed.=substr($html_body,0,$end_pos);
$html_body=substr($html_body,$end_pos);
// 把图片数据读出来保存到一个数据； 

$img_file_con=fopen($image_tag,"r");
unset($image_data);
while ($tem_buffer=AddSlashes(fread($img_file_con,16777216))) 
$image_data.=$tem_buffer;
fclose($img_file_con);
$image_exe_name=substr($image_tag,strrpos($image_tag,'.')+1,3);
switch (strtolower($image_exe_name)) 
{
case "jpg": 
case "jpeg": 
$content_type="image/jpeg";
break;
case "gif": 
$content_type="image/gif";
break;
case "png": 
$content_type="image/x-png";
break;
case "tif": 
$content_type="image/tif";
break;
default: 
$content_type="image/";
break;
}

$this->temp_body_images[$image_count][name]=basename($image_tag);
$this->temp_body_images[$image_count][type]=$content_type;
$this->temp_body_images[$image_count][cid]=$cid;
$this->temp_body_images[$image_count][data]=$image_data;
$image_count++;
}
$this->temp_html_body=$passed.$html_body;
return true;

}

function build_content($bound_level=0,$text_body,$html_body,$hava_att=false) 
{
if ($html_body) 
{
if (eregi("\<*img[[:space:]]+src[[:space:]]*=[[:space:]]*([^ ]+)",$html_body,$reg)) 
{
$bound_level++;
if ($text_body) 
{
$this->body.="Content-Type: multipart/related;
type=\"multipart/alternative\";
\tboundary=\"";
$this->body.=$this->bound_begin.$bound_level.$this->bound_end."\"\r\n\r\n";
}
else 
{
$this->body.="Content-Type: multipart/related;
\tboundary=\"";
$this->body.=$this->bound_begin.$bound_level.$this->bound_end."\"\r\n\r\n";

}// 对于是否 text 正文 、 html正文 有没有，须有不同的 MIME 头 
if (!$hava_att) $this->body.="This is a multi-part message in MIME format.\r\n\r\n";
// 正文标识，如果是已经有附件的编码，则在正文 中不需要这一句 
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->parse_html_body($html_body);
if ($text_body)
{
$this->body.="Content-Type: multipart/alternative;
\tboundary=\"";
$bound_level++;
$this->body.=$this->bound_begin.$bound_level.$this->bound_end."\"\r\n\r\n";
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->body.="Content-Type: text/plain;\r\n";
$this->body.="\tcharset=\"$this->charset\"\r\n";
$this->body.="Content-Transfer-Encoding: base64\r\n";
$this->body.="\r\n".chunk_split(base64_encode(StripSlashes($text_body)))."\r\n";
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->body.="Content-Type: text/html;\r\n";
$this->body.="\tcharset=\"$this->charset\"\r\n";
$this->body.="Content-Transfer-Encoding: base64\r\n";
$this->body.="\r\n".chunk_split(base64_encode(StripSlashes($this->temp_html_body)))."\r\n";
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."--\r\n\r\n";
$bound_level--;
}
else 
{
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->body.="Content-Type: text/html;\r\n";
$this->body.="\tcharset=\"$this->charset\"\r\n";
$this->body.="Content-Transfer-Encoding: base64\r\n";
$this->body.="\r\n".chunk_split(base64_encode(StripSlashes($this->temp_html_body)))."\r\n";
}//正文编码，有或没有　text 部分，编成不同的格式。 
for ($i=0;$i<count($this->temp_body_images);$i++) 
{
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->body.="Content-Type:".$this->temp_body_images[$i][type].";
name=\"";
$this->body.=$this->temp_body_images[$i][name]."\"\r\n";
$this->body.="Content-Transfer-Encoding: base64\r\n";
$this->body.="Content-ID: <".$this->temp_body_images[$i][cid].">\r\n";
$this->body.="\r\n".chunk_split(base64_encode(StripSlashes($this->temp_body_images[$i][data])))."\r\n";
}
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."--\r\n\r\n";
$bound_level--;
}
else // 有或没有图片，以上是有图片的处理，下面是没有图片的处理 
{
$this->temp_html_body=$html_body;
if ($text_body) 
{
$bound_level++;
$this->body.="Content-Type: multipart/alternative;
\tboundary=\"";
$this->body.=$this->bound_begin.$bound_level.$this->bound_end."\"\r\n\r\n";

if (!$hava_att) $this->body.="\r\nThis is a multi-part message in MIME format.\r\n\r\n";
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->body.="Content-Type: text/plain;\r\n";
$this->body.="\tcharset=\"$this->charset\"\r\n";
$this->body.="Content-Transfer-Encoding: base64\r\n";
$this->body.="\r\n".chunk_split(base64_encode(StripSlashes($text_body)))."\r\n";
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->body.="Content-Type: text/html;\r\n";
$this->body.="\tcharset=\"$this->charset\"\r\n";
$this->body.="Content-Transfer-Encoding: base64\r\n";
$this->body.="\r\n".chunk_split(base64_encode(StripSlashes($this->temp_html_body)))."\r\n";
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."--\r\n\r\n";
$bound_level--;
}
else 
{
$this->body.="Content-Type: text/html;\r\n";
$this->body.="\tcharset=\"$this->charset\"\r\n";
$this->body.="Content-Transfer-Encoding: base64\r\n";
$this->body.="\r\n".chunk_split(base64_encode(StripSlashes($this->temp_html_body)))."\r\n";
}//正文编码，有或没有　text 部分，编成不同的格式。 

}// end else 
}
else // 如果没有　html 正文，只有　text 正文　 
{
$this->body.="Content-Type: text/plain;
\tcharset=\"$this->charset\"\r\n";
$this->body.="Content-Transfer-Encoding: base64\r\n";
$this->body.="\r\n".chunk_split(base64_encode(StripSlashes($text_body)))."\r\n";
}
}// end function default 


Function Buildbody($text_body=null,$html_body=null,$att=null) 
{
$this->body="MIME-Version: 1.0\r\n";
if (null==$att or (@count($att)==0)) //如果没有附件，查看正文的类型　； 
{
$encode_level=0;
$this->build_content($encode_level,$text_body,$html_body);
}// 如果没有附件， 
// ******************************************************** 
else //如果有附件， 
{
$bound_level=0;
$this->body.="Content-Type: multipart/mixed;
\tboundary=\"";
$bound_level++;

$this->body.=$this->bound_begin.$bound_level.$this->bound_end."\"\r\n\r\n";
$this->body.="This is a multi-part message in MIME format.\r\n\r\n";
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->build_content($bound_level,$text_body,$html_body,true);// 编入正文部分 

$num=count($att);
for ($i=0;$i<$num;$i++) 
{
$file_name=$att[$i][name];
$file_source=$att[$i][source];
$file_type=$att[$i][type];
$file_size=$att[$i][size];

if (file_exists($file_source)) 
{
$file_data=addslashes(fread($fp=fopen($file_source,"r"), filesize($file_source)));
$file_data=chunk_split(base64_encode(StripSlashes($file_data)));
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->body.="Content-Type: $file_type;\r\n\tname=\"$file_name\"\r\nContent-Transfer-Encoding: base64\r\n";
$this->body.="Content-Disposition: attachment;\r\n\tfilename=\"$file_name\"\r\n\r\n";
$this->body.=$file_data."\r\n";
}
}//end for 

$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."--\r\n\r\n";
}// end else 

if ($this->debug) echo nl2br(htmlspecialchars($this->body));

return true;
}


function send($from_name,$to_name,$from_mail,$to_mail,$subject,$text_body=false,$html_body=false,$att=false) 
{

if (empty($from_mail) or empty($to_mail)) 
{
$this->err_str="没有指定正确的邮件地址:发送人：".$from_mail."接收人：".$to_mail;
return false;
}

if (gettype($to_mail)!="array") 
$to_mail=split(",",$to_mail);//如果不是数组，转换成数组，哪怕只有一个发送对象;
if (gettype($to_name)!="array") 
$to_name=split(",",$to_name);//如果不是数组，转换成数组，哪怕只有一个发送对象;

$this->Buildbody($text_body,$html_body,$att);
// 所有信件的内容是一样的，可以只编一次，而对于不同的收信人，需要不同的　Head 


if (!$this->open()) return false;
if (!$this->command("HELO $this->hostname",3,"250")) return false;
// 与服务器建立链接 
if (!$this->open()) return false;
if (!$this->command("HELO $this->hostname",3,"250")) return false;

for ($i=0;$i<count($to_mail);$i++) 
{
$this->Buildhead($from_name,$to_name[$i],$from_mail,$to_mail[$i],$subject);
if (!$this->command("RSET",3,"250")) return false;
if (!$this->command("MAIL FROM:".$from_mail,3,"250")) return false;
if (!$this->command("RCPT TO:".$to_mail[$i],3,"250")) return false;
if (!$this->command("DATA",3,"354")) return false;
// 准备发送邮件 
if ($this->debug) $this->outdebug("sending subject;");
if (!fputs($this->connection,$this->subject)) {$this->err_str="发送邮件头时出错！";return false;}
if ($this->debug) $this->outdebug("sending body;");
if (!fputs($this->connection,$this->body)) {$this->err_str="发送正文时出错！";return false;}
if (!fputs($this->connection,".\r\n")) {$this->err_str="发送正文时出错！";return false;}//正文发送完毕，退出； 
$resp=fgets($this->connection,256);
if($this->debug)
$this->outdebug("$resp");
if (substr($resp,0,1)!="2")
{
$this->err_str="发送完后，服务器没有响应！！";
return false;
}
// 发送邮件 
}
if (!$this->command("QUIT",3,"221")) return false;
$this->close();
return true;
}

}//end class define 
}//end if(!isset($__smtp_class__)) 
?>

PHP SMTP类使用方法 
<?
include("smtp.php");

$mail = new smtp("localhost");

$mail->debug = 0;

$sender_name = "root";
$sender_mail = "root@localhost";
$to_name = "mm";
$to_mail = "mm@your.com";
$subject = "i miss u";
$content = "i miss u much.";
$att[0]["name"] = "miss.jpg";
$att[0]["source"] = "/path/to/your/miss.jpg";
$att[0]["type"] = "image/jpeg";
$att[0]["size"] = "10kb";
$extra_subject = "To:".$to_mail." 主题:".$subject;

if (!$mail->send($sender_name,$to_name,$sender_mail,$to_mail,$extra_subject,$content,false,$att))
$err = 1;
?>

返回文件的MIME类型的函数guessMIMEType() 
function guessMIMEType($filename) {
//GUESS MIME TYPE
$filename = basename($filename);
if(strrchr($filename,".") == false) {
return("application/octet-stream");
}

$ext = strrchr($filename,".");
switch($ext) {
case ".gif":
return "image/gif";
break;
case ".gz":
return "application/x-gzip";
case ".htm":
case ".html":
return "text/html";
break;
case ".jpg":
return "image/jpeg";
break;
case ".tar":
return "application/x-tar";
break;
case ".txt":
return "text/plain";
break;
case ".zip":
return "application/zip";
break;
default:
return "application/octet-stream";
break;
}
}

检测Email地址的函数IsValidEmail() 
function IsValidEmail($Email) {
if(!ereg("^[[:alnum:]\_\.]+@([[:alnum:]\_]+\.)+[[:alnum:]][[:alnum:]][[:alnum:]]?$",$Email, $regs)){
$IsValidEmail = false;
}
else
{
$IsValidEmail = true;
}
return $IsValidEmail;
}

一个MIME MAIL类，请大家注意如何构造一个邮件体 
<?
class mime_mail 
{ 
var $parts; 
var $to; 
var $from; 
var $headers; 
var $subject; 
var $body; 

/* 
* void mime_mail() 
* class constructor 
*/ 
function mime_mail() 
{ 
$this->parts = array(); 
$this->to = ""; 
$this->from = ""; 
$this->subject = ""; 
$this->body = ""; 
$this->headers = ""; 
} 

/* 
* void add_attachment(string message, [string name], [string ctype]) 
* Add an attachment to the mail object 
*/ 
function add_attachment($message, $name = "", $ctype = "application/octet-stream") 
{ 
$this->parts[] = array ( 
"ctype" => $ctype, 
"message" => $message, 
"encode" => $encode, 
"name" => $name 
); 
} 

/* 
* void build_message(array part= 
* Build message parts of an multipart mail 
*/ 
function build_message($part) 
{ 
$message = $part["message"]; 
$message = chunk_split(base64_encode($message)); 
$encoding = "base64"; 
return "Content-Type: ".$part["ctype"].
($part["name"]?";\n\tname=\"".$part["name"]."\"" : "").
"\nContent-Transfer-Encoding: $encoding".
"\nContent-Disposition: attachment".
($part["name"]?";\n\tfilename=\"".$part["name"]."\"" : "").
"\n\n$message\n";
}

/* 
* void build_multipart() 
* Build a multipart mail 
*/ 
function build_multipart() 
{ 
$boundary = "b".md5(uniqid(time())); 
$multipart = "Content-Type: multipart/mixed;\n\tboundary=\"$boundary\"\n\nThis is a MIME encoded message.\n\n--$boundary"; 

for($i = sizeof($this->parts)-1; $i >= 0; $i--) 
{ 
$multipart .= "\n".$this->build_message($this->parts[$i])."--$boundary"; 
} 
return $multipart.= "--\n"; 
} 

/* 
* void send() 
* Send the mail (last class-function to be called) 
*/ 
function send() 
{ 
$addtionheaders = ""; 
if (!empty($this->from)) 
$addtionheaders .= "From: ".$this->from."\n"; 
if (!empty($this->headers)) 
$addtionheaders .= $this->headers."\n"; 

if (!empty($this->body)) 
$this->add_attachment($this->body, "", "text/plain");

$addtionheaders .= "MIME-Version: 1.0\n".$this->build_multipart();

$fp = fopen("mail.txt","w");
fputs($fp,$addtionheaders);
fclose($fp);
mail($this->to, $this->subject, "", $addtionheaders); 
} 
}; // end of class 

/* 
* Example usage 
* 

$attachment = fread(fopen("test.jpg", "r"), filesize("test.jpg")); 

$mail = new mime_mail(); 
$mail->from = "foo@bar.com"; 
$mail->headers = "Errors-To: foo@bar.com"; 
$mail->to = "bar@foo.com"; 
$mail->subject = "Testing..."; 
$mail->body = "This is just a test."; 
$mail->add_attachment("$attachment", "test.jpg", "image/jpeg"); 
$mail->send(); 

*/ 
?>

myimap类，读取邮件 
<?php
//////////////////////////////////////////////
//Origin by Alpha.Z (5/21/2000)
//Modified By Belltree <belltree@163.com> (11/01/2000)
///////////////////////////////////////////////
class myimap
{
var $username="";
var $userpwd="";
var $hostname="";
var $port=0;
var $connection=0; //是否连接
var $state="DISCONNECTED"; //连接状态
var $greeting="";
var $must_update=0;
var $inStream=0;
var $num_msg_parts = 0;
var $attach;
var $num_of_attach = 0;

function open()
{
if ($this->port==110)
$this->inStream=imap_open("{".$this->hostname."/pop3:110}inbox",$this->username,$this->userpwd);
else
$this->inStream=imap_open("{".$this->hostname.":143}INBOX",$this->username,$this->userpwd);

if ($this->inStream)
{
//echo "用户：$this->username 的信箱连接成功。<br>";
return $inStream;
}
else
{
echo "用户：$this->username 的信箱连接失败。<br>";
return 0;
}
}

Function close()
{
if(imap_close($this->inStream))
{
//echo "<hr>已经与服务器 $this->hostname 断开连接。";
return 1;
}
else
{
//echo "<hr>与服务器 $this->hostname 断开连接失败。";
return 0;
}
}

function DeleteMail($msg_no){
if (@imap_delete($this->inStream,$msg_no))
return true;
else
return false; 
}

function ExpungeMail(){
if (@imap_expunge($this->inStream))
return true;
else
return false;
}


function CheckMailbox($page_size,$page)
{
$mboxinfo=@imap_mailboxmsginfo($this->inStream);
//$mboxinfo=imap_check($this->inStream);
if ($mboxinfo)
if ($mboxinfo->Nmsgs>0)
{
//echo "您邮箱：".$mboxinfo->Mailbox."<br>";
echo $this->username."@wells.com的收件箱里共有邮件数：".$mboxinfo->Nmsgs."<br>\n";
echo "未读邮件数：".$mboxinfo->Unread."　";
echo "新邮件数：".$mboxinfo->Recent." ";
echo "总共占用空间：".$mboxinfo->Size."字节<br>\n";
$last_page = ceil($mboxinfo->Nmsgs/$page_size);
$cur_page = $page +1;
$num_page = $last_page;
echo "第".$cur_page."页，共".$last_page."页。\n";
}
else
{
echo "您的信箱里没有邮件。<br><hr>\n";
}
else
{
echo '<font color="#ff0000">错误：无法获取收件箱的信息。</font>';
return 0;
}
echo "<table border=1 width=100% cellpadding=2 cellspacing=0 bordercolorlight=#000080 bordercolordark=#ffffff style=\"font:9pt Tahoma,宋体\">\n";
echo "<tr bgcolor=#ffffd8><td width=24>状态</td><td width=24> </td><td>发件人</td><td>主题</td><td>时间</td><td>大小</td></tr>\n";
$sortby="SORTDATE";
$sort_reverse=1;
$sorted = imap_sort($this->inStream, $sortby, $sort_reverse, SE_UID);

for ($i=0;$i<$mboxinfo->Nmsgs;$i++)
{
if (($i>=$page*$page_size) and ($i<$page*$page_size+$page_size)){
$msg_no = @imap_msgno($this->inStream, $sorted[$i]);
$msgHeader = @imap_header($this->inStream, $msg_no);
//日期

if (isset($msgHeader->date))
{
$date = $msgHeader->date;

if (ord($date) > 64)
$date = substr($date, 5);

$datepart = split(" ",$date);
$date = $datepart[0]." ".$datepart[1]." ".$datepart[2]." ".$datepart[3];
/*
while (strstr(' ', $date))
{
$date = str_replace(' ', ' ', $date);
}
*/
}

if (isset($msgHeader->from[0]))
{
$from = $msgHeader->from[0];
if (isset($from->personal))
{
$frm = trim($this->decode_mime_string($from->personal));
if (isset($from->mailbox) && isset($from->host))
{
$frm_add = $from->mailbox . '@' . $from->host;
}
}
else
if (isset($from->mailbox) && isset($from->host))
{
$frm = $from->mailbox . '@' . $from->host;
}
else
if (isset($msgHeader->fromaddress))
$frm = trim($h->fromaddress);
}
else
if (isset($msgHeader->fromaddress))
$frm = trim($msgHeader->fromaddress);

if (isset($msgHeader->toaddress))
$to = trim($msgHeader->toaddress);
else
$to = "未知";


if (isset($msgHeader->subject))
$sub = trim($this->decode_mime_string($msgHeader->subject));
if ($sub == "")
$sub = "无主题"; 
if (isset($msgHeader->Size))
$msg_size = ($msgHeader->Size > 1024) ? sprintf("%.0f kb", $msgHeader->Size / 1024) : $msgHeader->Size;
//if (strlen($frm) > 50)
// $frm = substr($frm, 0, 50) . '...';
if (strlen($sub) > 50)
$sub = substr($sub, 0, 50) . '...';
if ($msgHeader->Unseen == "U")
$newmail = "未读";
else
$newmail = "已读";
echo "<tr>\n";
echo "<td align=center>$newmail</td><td align=\"center\"></td>\n";
echo '<td>'.$frm.'</td><td><a href="mail_read.php?msg='.$msg_no.'">'.$sub.'</a></td><td width=125>'.$date.'</td><td width=50>'.$msg_size.'</td>';
echo "</tr>\n";
}}
echo "</table>\n";
echo "<table border=0 width=100% cellspacing=4 cellpadding=4><tr>\n";
if ($page == 0)
echo "<td>第一页</td>\n";
else
echo "<td><a href=\"mail_list.php?page=0\">第一页</a></td>\n";
if (($prev_page = $page-1) < 0)
echo "<td>前一页</td>\n";
else
echo "<td><a href=\"mail_list.php?page=$prev_page\">前一页</a></td>\n";

if (($next_page = $page + 1) >= $last_page)
echo "<td>后一页</td>\n";
else
echo "<td><a href=\"mail_list.php?page=$next_page\">后一页</a></td>\n";
$last_page --;
if ( $last_page < $next_page)
echo "<td>最末页</td>\n";
else
echo "<td><a href=\"mail_list.php?page=$last_page\">最末页</a></td>\n";
echo "</tr></table>\n";
}

function decode_mime_string ($string)
{
$pos = strpos($string, '=?');
if (!is_int($pos))
{
return $string;
}

$preceding = substr($string, 0, $pos); // save any preceding text

$search = substr($string, $pos+2, 75); // the mime header spec says this is the longest a single encoded word can be
$d1 = strpos($search, '?');
if (!is_int($d1))
{
return $string;
}

$charset = substr($string, $pos+2, $d1);
$search = substr($search, $d1+1);

$d2 = strpos($search, '?');
if (!is_int($d2))
{
return $string;
}

$encoding = substr($search, 0, $d2);
$search = substr($search, $d2+1);

$end = strpos($search, '?=');
if (!is_int($end))
{
return $string;
}

$encoded_text = substr($search, 0, $end);
$rest = substr($string, (strlen($preceding . $charset . $encoding . $encoded_text)+6));

switch ($encoding)
{
case 'Q':
case 'q':
$encoded_text = str_replace('_', '%20', $encoded_text);
$encoded_text = str_replace('=', '%', $encoded_text);
$decoded = urldecode($encoded_text);
break;

case 'B':
case 'b':
$decoded = urldecode(base64_decode($encoded_text));
break;

default:
$decoded = '=?' . $charset . '?' . $encoding . '?' . $encoded_text . '?=';
break;
}

return $preceding . $decoded . $this->decode_mime_string($rest);
}


Function display_toaddress ($user, $server, $from)
{
return is_int(strpos($from, $this->get_barefrom($user, $server)));
}

Function get_barefrom($user, $server)
{
$barefrom = "$user@$real_server";

return $barefrom;
}

Function get_structure($msg_num)
{
$structure=imap_fetchstructure($this->inStream,$msg_num);
//echo gettype($structure);
return $structure;
}


Function proc_structure($msg_part, $part_no, $msg_num)
{
if ($msg_part->ifdisposition)
{
// See if it has a disposition, The only thing I know of that this, would be used for would be an attachment
// Lets check anyway
if ($msg_part->disposition == "attachment")
{
$att_name = "unknown";
for ($lcv = 0; $lcv < count($msg_part->parameters); $lcv++)
{
$param = $msg_part->parameters[$lcv];

if ($param->attribute == "name")
{
$att_name = $param->value;
break;
}
}

$att_name = $this->decode_mime_string($att_name);

$att_path = $this->username."\\".$att_name;

$this->attach[$this->num_of_attach]=$att_name; //登记附件列表
$this->num_of_attach ++; //登记附件数量
/*
$att_path = $this->username."\\".$this->decode_mime_string($att_name);
if ($this->attach=="")
$this->attach = $att_name;
else
$this->attach .= ";".$att_name;
*/
if (!is_dir($this->username))
mkdir($this->username,0700); 
$fp=fopen($att_path,"w");
switch ($msg_part->encoding)
{
case 3: // base64
fputs($fp,imap_base64(imap_fetchbody($this->inStream,$msg_num,$part_no)));
break;
case 4: // QP
fputs($fp,imap_qprint(imap_fetchbody($this->inStream,$msg_num,$part_no)));
break;
default:
fputs($fp,imap_fetchbody($this->inStream,$msg_num,$part_no));
break;
}
fclose($fp); 

//if ($msg_part->type=="5"){
// echo "<p align=center><hr align=center>\n";
// echo "<img src=\"$att_path\" align=center></p>\n";
//}
} // END IF ATTACHMENT
else //NOT ifdisposition
{
// I guess it is used for something besides attachments????
}
}
else
{
// Not an attachment, lets see what this part is...
switch ($msg_part->type)
{
case 0:
$mime_type = "text";
break;
case 1:
$mime_type = "multipart";
// Hey, why not use this function to deal with all the parts
// of this multipart part 
$this->num_msg_parts = count($msg_part->parts);
for ($i = 0; $i < $this->num_msg_parts; $i++)
{
if ($part_no != "")
{
$part_no = $part_no.".";
}
for ($i = 0; $i < count($msg_part->parts); $i++)
{
$this->proc_structure($msg_part->parts[$i], $part_no.($i + 1), $msg_num);
}
}
break;
case 2:
$mime_type = "message";
break;
case 3:
$mime_type = "application";
break;
case 4:
$mime_type = "audio";
break;
case 5:
$mime_type = "image";
break;
case 6:
$mime_type = "video";
break;
case 7:
$mime_type = "model";
break;
default:
$mime_type = "unknown";
// hmmm....
}

$full_mime_type = $mime_type."/".$msg_part->subtype;
$full_mime_type = strtolower($full_mime_type);


// Decide what you what to do with this part
// If you want to show it, figure out the encoding and echo away

switch ($msg_part->encoding)
{

case 0:
case 1:
if ($this->num_msg_parts == 0){
echo ereg_replace("\r\n","<br>\r\n",imap_body($this->inStream,$msg_num));

}
else{
if ($part_no!=""){
echo ereg_replace("\r\n","<br>\r\n",imap_fetchbody($this->inStream,$msg_num,$part_no));

}
}
break;
case 3: //BASE64

if ($full_mime_type=="text/plain"){

if ($this->num_msg_parts == 0){
$content=imap_base64(imap_body($this->inStream,$msg_num));
}
else{
$content = imap_base64(imap_fetchbody($this->inStream,$msg_num,$part_no));
$att_path = $this->username . "\\文本内容.txt";
$fp = fopen($att_path,"w");
fputs($fp,$content);
fclose($fp);
$this->attach[$this->num_of_attach]="文本内容.txt";
$this->num_of_attach++; 
}

echo $content;

}

if ($full_mime_type=="text/html"){
$att_path = $this->username . "\\超文本内容.htm";
$fp = fopen($att_path,"w");
fputs($fp,imap_base64(imap_fetchbody($this->inStream,$msg_num,$part_no)));
fclose($fp);
$this->attach[$this->num_of_attach]="超文本内容.htm";
$this->num_of_attach++;
}
break;
case 4: //QPRINT
// use imap_qprint to decode
if ($this->num_msg_parts == 0){
echo ereg_replace("\n","<br>",imap_qprint(imap_body($this->inStream,$msg_num)));

}
else{
echo ereg_replace("\n","<br>",imap_qprint(imap_fetchbody($this->inStream,$msg_num,$part_no)));

}
if ($full_mime_type=="text/html"){
$att_path = $this->username . "\\qp超文本内容.htm";
$fp = fopen($att_path,"w");
fputs($fp,imap_base64(imap_fetchbody($this->inStream,$msg_num,$part_no)));
fclose($fp);
$this->attach[$this->num_of_attach]="qp超文本内容.htm";
$this->num_of_attach++;
} 
break;
case 5:
// not sure if this needs decoding at all
echo ereg_replace("\n","<br>",imap_fetchbody($this->inStream,$msg_num));
break;
default:
//echo ereg_replace("\n","<br>",imap_fetchbody($this->inStream,$msg_num,$part_no));
break;
}
}
}
};

?>

myimap的扩展类，及读取一封邮件的例子(mail_read.php) 
<?
require("myimap.php");

class myimap_ext extends myimap {

function get_mail_subject($msg_no){
$msgHeader = @imap_header($this->inStream, $msg_no);
if (isset($msgHeader->subject))
$sub = trim($this->decode_mime_string($msgHeader->subject));
if ($sub == "")
$sub = "无主题";
return "Fw:".$sub; 
}
function print_attaches(){
for ($i=0;$i<count($this->attach);$i++){
echo "<a target=_blank href=\"".$this->username."\\".$this->attach[$i]."\">".$this->attach[$i]."<br/>";
}
}
function list_attaches(){
for ($i=0;$i<count($this->attach);$i++){
if ($i==0) 
$attaches = $this->attach[$i];
else
$attaches .= ";".$this->attach[$i];
}
return $attaches;
}
}

$imap=new myimap_ext;
$imap->hostname="localhost";
$imap->port=143;
$imap->username="name";
$imap->userpwd="password";

$imap->open();

$mail_structure=$imap->get_structure($msg);
$imap->proc_structure($mail_structure,"",$msg);
if ($imap->num_of_attach > 0){
$imap->print_attaches();
}
@$imap->close();
?>

myimap的例子(mail_list.php) 
<?
require("myimap.php");

$imap=new myimap;
$imap->hostname="localhost";
$imap->port=143;
$imap->username="name";
$imap->userpwd="password";

$imap->open();
if ($page=="") $page=0;
$imap->CheckMailBox(10,$page);
@$imap->close();
?>

如何发送附件（转） 
我经常听到这样一个问题："我有一个从网站发来的合同。我如何给通过表单发送的电子邮件增加一个附件呢？" 
首先我要说的是要做到这个没有什么简单的办法。你要很好的理解PHP或
其它的服务器端的脚本语言。当然你还要一个真正支持PHP的网站的账号。如果满足了这个前提，在你读完了本章后就可以用PHP发送带附件的电子邮件了。 

1. 附件是如何工作的 

如果你曾经在PHP的手册中搜索过"附件"函数，那么结果可能是什么都没有（至少在我写本文的时间还没有）。后来你就要花很多时间来了解这方面的知识。 

你也许会想当你给某个人发送一封带附件的电子邮件时，附件是和邮件一起放到收件人的信箱里的（比如，如果你给他/她发了一个PNG的图片文件，他/她的信箱里会包含一个txt文件（电子邮件）和一个.png文件（附件））。但这不是它的工作原理。当你加入一个附件时，你的邮件程序把附件转换成纯文本文件，并在你写的内容（实际的电子邮件）后面插入这个文本块。这个，当你把所有的东西发出来后，收件人的信箱里只有一个纯文本文件--一个同时包含附件和实际电子邮件内容的文件。 

下面是一个带附件（一个HTML文件）电子邮件的例子。我已经标注了其中重要的几行： 

Return-Path: <someone@example.com> 
Date: Mon, 22 May 2000 19:17:29 +0000 
From: Someone <someone@example.com> 
To: Person <person@eksempel.dk> 
Message-id: <83729KI93LI9214@example.com> 
Content-type: multipart/mixed; boundary="396d983d6b89a" 
Subject: Here's the subject 

--396d983d6b89a 
Content-type: text/plain; charset=iso-8859-1 
Content-transfer-encoding: 8bit 

This is the body of the email. 

--396d983d6b89a 
Content-type: text/html; name=attachment.html 
Content-disposition: inline; filename=attachment.html 
Content-transfer-encoding: 8bit 

<html> 
<head> 
<title>The attachment</title> 
</head> 
<body> 
<h2>This is the attached HTML file</h2> 
</body> 
</html> 

--396d983d6b89a-- 



前面的7行是邮件的头，其中值得注意的是Content-type头部分。这个头告诉邮件程序电子邮件是由一个以上的部分组成的。不含附件的邮件只有一个部分：消息本身。带附件的电子通常至少由两部分组成：消息和附件。这样，带两个附件的邮件由三部分组成：消息，第一个附件和第二个附件。 

带附件的电子邮件的不同部分之间用分界线来分隔。分界线在Content-type头中定义。邮件的每个新部分以两个连字号（--）和分界线开始。最后一个分界线后也有两个连字号，表示这个邮件中没有其它的部分了。 

在每个分界线后有一些行，用来告诉邮件程序这个部分的内容的类型。比如，看看上面例子中第一个分界线后面的两行--以Content-type: text/plain开头的行。这些行说明后面的部分是ISO-8859-1字符集的纯文本。跟在第二个分界线后的行告诉邮件程序现在的部分是一个HTML文件，它的名字是"attachment.html"。 

Content-disposition这持告诉邮件程序如果可能就以内嵌的方式显示附件。现在新的邮件程序会在消息后显示HTML的内容。如果Content-disposition被设为attachment，那么邮件程序就不会显示HTML文件的内容，而是显示一个连接到文件的图标（或其它的类似的东西）。收件人要看附件的内容，必须点击这个图标。一般情况下，如果附件是一些文本（包含HTML），Content-disposition会被设为inline，这是因为现在大部分邮件程序能够不借助其它浏览器而直接显示附件（文本）的内容。如果附件不是文本（比如图片或其它类似的内容），Content-disposition就设为attachment。 

2. 用PHP生成带附件的电子邮件 

这里一个例子，告诉你如果把一个定义好的HTML文件加为邮件的附件： 

<?php 
# 我们首先写实际的消息内容 
$emailBody = "This is text that goes into the body of the email."; 

# 然后我们要作为附件的HTML文件 
$attachment = "<html> 
<head> 
<title>The attached file</title> 
</head> 
<body> 
<h2>This is the attached HTML file</h2> 
</body> 
</html>"; 

# 建立在邮件中分隔不同部分的分界线。 
# 基本上，分界线可以是任意的字符串。 
# 但是重要的一点是确定一个写邮件的人 
# 这会随意写出的字符串，所以我们用 
# uniqid函数来产生一个随机的字符串。 
$boundary = uniqid( ""); 

# 现在我们要建立邮件头。不要忘了插入 
# Content-type头来说明这个邮件包含一个或更多的附件。 
$headers = "From: someone@example.com 
Content-type: multipart/mixed; boundary=\"$boundary\""; 

# 好，现在我们已经有了邮件的所有内容。 
# 下一件事是修改邮件的主体。 
$emailBody = "--$boundary 
Content-type: text/plain; charset=iso-8859-1 
Content-transfer-encoding: 8bit 

$emailBody 

--$boundary 
Content-type: text/html; name=attachment.html 
Content-disposition: inline; filename=attachment.html 
Content-transfer-encoding: 8bit 

$attachment 

--$boundary--"; 

# 现在可以把邮件发出去了 
mail( "person@eksempel.dk", "The subject", $emailBody, $headers); 
?> 



3. 把用户上传的文件作为附件 

你也许会觉得上面的例子难以理解，但下面...。在下面的例子中事情更难了，因为我们要用一个表单让用户上传他们的文件，并把这个文件作为我们要发的邮件的附件。麻烦的是我们不能预先知道文件的MIME类型。在前面的例子中，我们已经知道该它是一个HTML文件，所以给这个附件设置Content-type头是很简单的。在下面的例子中，MIME类型可能是任意的，因为用户可能会上传一个HTML文件，一个PNG文件，一个vCard文件，或者其它的东西。让我们来看看例子： 

<?php 
# 现在我们来生成表单。在产生可以上传文件的表单时， 
# 不要忘了把<form>标签的"enctype"属性设为"multipart/form-data". 
echo "<form action='$PHP_SELF' enctype='multipart/form-data' method='post'>\n"; 
echo "<input type='text' name='from'><br>\n"; 
echo "<input type='text' name='to'><br>\n"; 
echo "<input type='text' name='subject'><br>\n"; 
echo "<input type='file' name='attachment'><br>\n"; 
echo "<textarea name='body'></textarea><br>\n"; 
echo "<input type='submit' name='send' value='Send'>\n"; 
echo "</form>\n"; 

# 如果用户已经按了"Send"按钮" 
if ($send) { 
# 定义分界线 
$boundary = uniqid( ""); 

# 生成邮件头 
$headers = "From: $from 
Content-type: multipart/mixed; boundary=\"$boundary\""; 

# 确定上传文件的MIME类型 
if ($attachment_type) $mimeType = $attachment_type; 
# 如果浏览器没有指定文件的MIME类型， 
# 我们可以把它设为"application/unknown". 
else $mimeType = "application/unknown"; 

# 确定文件的名字 
$fileName = $attachment_name; 

# 打开文件 
$fp = fopen($attachment, "r"); 
# 把整个文件读入一个变量 
$read = fread($fp, filesize($attachment)); 

# 好，现在变量$read中保存的是包含整个文件内容的文本块。 
# 现在我们要把这个文本块转换成邮件程序可以读懂的格式 
# 我们用base64方法把它编码 
$read = base64_encode($read); 

# 现在我们有一个用base64方法编码的长字符串。 
# 下一件事是要把这个长字符串切成由每行76个字符组成的小块 
$read = chunk_split($read); 

# 现在我们可以建立邮件的主体 
$body = "--$boundary 
Content-type: text/plain; charset=iso-8859-1 
Content-transfer-encoding: 8bit 

$body 

--$boundary 
Content-type: $mimeType; name=$fileName 
Content-disposition: attachment; filename=$fileName 
Content-transfer-encoding: base64 

$read 

--$boundary--"; 

# 发送邮件 
mail($to, $subject, $body, $headers); 
} 
?>

