PHP SMTP�� 
<?
/*********************************** 
PHP MIME��SMTP ver 1.0 Powered by Boss_ch�� Unigenius soft ware co. Ltd 
All rights reserved, Copyright 2000 ;
�����á�PHP��ͨ����smtp ��sock �������͡�MIME ���͵��ʼ������Է��� 
HTML ��ʽ�����ġ����������á�base64 ���� 
���汾����Ը��˵ķ��ͣ������Ⱥ���汾��ͬ���ǣ�ÿ���͵�һ���ˣ������½���һ�α��룬�ڽ��ն˵��û�������ֻ�Ƿ��͸���һ���˵ġ� 
��Զ���Ⱥ���������ֻ����һ�Σ�ͨ�������RCPT��TO������͵���ͬ���������У� 
˵���� 
��ѡ�$hostname ��Ϊ����Ȩ�޵ġ�Ĭ�ϡ�smtp �����������ڡ�new ʱָ�� 
�ѡ�$charset �ĳ����Ĭ�ϡ��ַ��� 
Html ����������ͼƬ�����þ���·�������á�"httP://host/path/image.gif";
���������������Ա�֤�����ܶ�ȡ��ͼƬ��������Ϣ 
�����ͨ�����ύ�����ġ�Html ���ģ������á�StripSlashes($html_body)�����������ݽ���Ԥ���� 
����Html ���õ�����ʽ���ļ����벻Ҫ�á�<link >֮�ࡡ�����ã�ֱ�Ӱ���ʽ������� 
<style></style>��ǩ�� 

ת���뱣���˰�Ȩ��Ϣ����Bugs Report : boss_ch@china.com 
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
$this->err_str="û�����ӵ��κη�������������������";
return false;
}
if ($this->debug) 
$this->outdebug(">>> $command");
if (!fputs($this->connection,"$command \r\n")) 
{
$this->err_str="�޷���������".$command;
return false;
}
else 
{
$resp=fgets($this->connection,256);
if($this->debug) 
$this->outdebug("$resp");
if (substr($resp,0,$return_lenth)!=$return_code) 
{
$this->err_str=$command." ���������������Ч:".$resp;
return false;
}
else 
return true;
}
}


Function open() 
{
if($this->hostname=="") 
{$this->err_str="��Ч��������!!";
return false;
}

if ($this->debug) echo "$this->hostname,$this->port,&$err_no, &$err_str, $this->timeout<BR>";
if (!$this->connection=fsockopen($this->hostname,$this->port,&$err_no, &$err_str, $this->timeout)) 
{
$this->err_str="���ӵ���SMTP ������ʧ��,������Ϣ��".$err_str."����ţ�".$err_no;
return false;
}
else 
{
$resp=fgets($this->connection,256);
if($this->debug) 
$this->outdebug("$resp");
if (substr($resp,0,1)!="2") 
{$this->err_str="������������Ч����Ϣ��".$resp."����SMTP�������Ƿ���ȷ";
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
// ��ͼƬ���ݶ��������浽һ�����ݣ� 

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

}// �����Ƿ� text ���� �� html���� ��û�У����в�ͬ�� MIME ͷ 
if (!$hava_att) $this->body.="This is a multi-part message in MIME format.\r\n\r\n";
// ���ı�ʶ��������Ѿ��и����ı��룬�������� �в���Ҫ��һ�� 
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
}//���ı��룬�л�û�С�text ���֣���ɲ�ͬ�ĸ�ʽ�� 
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
else // �л�û��ͼƬ����������ͼƬ�Ĵ���������û��ͼƬ�Ĵ��� 
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
}//���ı��룬�л�û�С�text ���֣���ɲ�ͬ�ĸ�ʽ�� 

}// end else 
}
else // ���û�С�html ���ģ�ֻ�С�text ���ġ� 
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
if (null==$att or (@count($att)==0)) //���û�и������鿴���ĵ����͡��� 
{
$encode_level=0;
$this->build_content($encode_level,$text_body,$html_body);
}// ���û�и����� 
// ******************************************************** 
else //����и����� 
{
$bound_level=0;
$this->body.="Content-Type: multipart/mixed;
\tboundary=\"";
$bound_level++;

$this->body.=$this->bound_begin.$bound_level.$this->bound_end."\"\r\n\r\n";
$this->body.="This is a multi-part message in MIME format.\r\n\r\n";
$this->body.="--".$this->bound_begin.$bound_level.$this->bound_end."\r\n";
$this->build_content($bound_level,$text_body,$html_body,true);// �������Ĳ��� 

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
$this->err_str="û��ָ����ȷ���ʼ���ַ:�����ˣ�".$from_mail."�����ˣ�".$to_mail;
return false;
}

if (gettype($to_mail)!="array") 
$to_mail=split(",",$to_mail);//����������飬ת�������飬����ֻ��һ�����Ͷ���;
if (gettype($to_name)!="array") 
$to_name=split(",",$to_name);//����������飬ת�������飬����ֻ��һ�����Ͷ���;

$this->Buildbody($text_body,$html_body,$att);
// �����ż���������һ���ģ�����ֻ��һ�Σ������ڲ�ͬ�������ˣ���Ҫ��ͬ�ġ�Head 


if (!$this->open()) return false;
if (!$this->command("HELO $this->hostname",3,"250")) return false;
// ��������������� 
if (!$this->open()) return false;
if (!$this->command("HELO $this->hostname",3,"250")) return false;

for ($i=0;$i<count($to_mail);$i++) 
{
$this->Buildhead($from_name,$to_name[$i],$from_mail,$to_mail[$i],$subject);
if (!$this->command("RSET",3,"250")) return false;
if (!$this->command("MAIL FROM:".$from_mail,3,"250")) return false;
if (!$this->command("RCPT TO:".$to_mail[$i],3,"250")) return false;
if (!$this->command("DATA",3,"354")) return false;
// ׼�������ʼ� 
if ($this->debug) $this->outdebug("sending subject;");
if (!fputs($this->connection,$this->subject)) {$this->err_str="�����ʼ�ͷʱ����";return false;}
if ($this->debug) $this->outdebug("sending body;");
if (!fputs($this->connection,$this->body)) {$this->err_str="��������ʱ����";return false;}
if (!fputs($this->connection,".\r\n")) {$this->err_str="��������ʱ����";return false;}//���ķ�����ϣ��˳��� 
$resp=fgets($this->connection,256);
if($this->debug)
$this->outdebug("$resp");
if (substr($resp,0,1)!="2")
{
$this->err_str="������󣬷�����û����Ӧ����";
return false;
}
// �����ʼ� 
}
if (!$this->command("QUIT",3,"221")) return false;
$this->close();
return true;
}

}//end class define 
}//end if(!isset($__smtp_class__)) 
?>

PHP SMTP��ʹ�÷��� 
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
$extra_subject = "To:".$to_mail." ����:".$subject;

if (!$mail->send($sender_name,$to_name,$sender_mail,$to_mail,$extra_subject,$content,false,$att))
$err = 1;
?>

�����ļ���MIME���͵ĺ���guessMIMEType() 
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

���Email��ַ�ĺ���IsValidEmail() 
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

һ��MIME MAIL�࣬����ע����ι���һ���ʼ��� 
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

myimap�࣬��ȡ�ʼ� 
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
var $connection=0; //�Ƿ�����
var $state="DISCONNECTED"; //����״̬
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
//echo "�û���$this->username ���������ӳɹ���<br>";
return $inStream;
}
else
{
echo "�û���$this->username ����������ʧ�ܡ�<br>";
return 0;
}
}

Function close()
{
if(imap_close($this->inStream))
{
//echo "<hr>�Ѿ�������� $this->hostname �Ͽ����ӡ�";
return 1;
}
else
{
//echo "<hr>������� $this->hostname �Ͽ�����ʧ�ܡ�";
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
//echo "�����䣺".$mboxinfo->Mailbox."<br>";
echo $this->username."@wells.com���ռ����ﹲ���ʼ�����".$mboxinfo->Nmsgs."<br>\n";
echo "δ���ʼ�����".$mboxinfo->Unread."��";
echo "���ʼ�����".$mboxinfo->Recent." ";
echo "�ܹ�ռ�ÿռ䣺".$mboxinfo->Size."�ֽ�<br>\n";
$last_page = ceil($mboxinfo->Nmsgs/$page_size);
$cur_page = $page +1;
$num_page = $last_page;
echo "��".$cur_page."ҳ����".$last_page."ҳ��\n";
}
else
{
echo "����������û���ʼ���<br><hr>\n";
}
else
{
echo '<font color="#ff0000">�����޷���ȡ�ռ������Ϣ��</font>';
return 0;
}
echo "<table border=1 width=100% cellpadding=2 cellspacing=0 bordercolorlight=#000080 bordercolordark=#ffffff style=\"font:9pt Tahoma,����\">\n";
echo "<tr bgcolor=#ffffd8><td width=24>״̬</td><td width=24> </td><td>������</td><td>����</td><td>ʱ��</td><td>��С</td></tr>\n";
$sortby="SORTDATE";
$sort_reverse=1;
$sorted = imap_sort($this->inStream, $sortby, $sort_reverse, SE_UID);

for ($i=0;$i<$mboxinfo->Nmsgs;$i++)
{
if (($i>=$page*$page_size) and ($i<$page*$page_size+$page_size)){
$msg_no = @imap_msgno($this->inStream, $sorted[$i]);
$msgHeader = @imap_header($this->inStream, $msg_no);
//����

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
$to = "δ֪";


if (isset($msgHeader->subject))
$sub = trim($this->decode_mime_string($msgHeader->subject));
if ($sub == "")
$sub = "������"; 
if (isset($msgHeader->Size))
$msg_size = ($msgHeader->Size > 1024) ? sprintf("%.0f kb", $msgHeader->Size / 1024) : $msgHeader->Size;
//if (strlen($frm) > 50)
// $frm = substr($frm, 0, 50) . '...';
if (strlen($sub) > 50)
$sub = substr($sub, 0, 50) . '...';
if ($msgHeader->Unseen == "U")
$newmail = "δ��";
else
$newmail = "�Ѷ�";
echo "<tr>\n";
echo "<td align=center>$newmail</td><td align=\"center\"></td>\n";
echo '<td>'.$frm.'</td><td><a href="mail_read.php?msg='.$msg_no.'">'.$sub.'</a></td><td width=125>'.$date.'</td><td width=50>'.$msg_size.'</td>';
echo "</tr>\n";
}}
echo "</table>\n";
echo "<table border=0 width=100% cellspacing=4 cellpadding=4><tr>\n";
if ($page == 0)
echo "<td>��һҳ</td>\n";
else
echo "<td><a href=\"mail_list.php?page=0\">��һҳ</a></td>\n";
if (($prev_page = $page-1) < 0)
echo "<td>ǰһҳ</td>\n";
else
echo "<td><a href=\"mail_list.php?page=$prev_page\">ǰһҳ</a></td>\n";

if (($next_page = $page + 1) >= $last_page)
echo "<td>��һҳ</td>\n";
else
echo "<td><a href=\"mail_list.php?page=$next_page\">��һҳ</a></td>\n";
$last_page --;
if ( $last_page < $next_page)
echo "<td>��ĩҳ</td>\n";
else
echo "<td><a href=\"mail_list.php?page=$last_page\">��ĩҳ</a></td>\n";
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

$this->attach[$this->num_of_attach]=$att_name; //�ǼǸ����б�
$this->num_of_attach ++; //�ǼǸ�������
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
$att_path = $this->username . "\\�ı�����.txt";
$fp = fopen($att_path,"w");
fputs($fp,$content);
fclose($fp);
$this->attach[$this->num_of_attach]="�ı�����.txt";
$this->num_of_attach++; 
}

echo $content;

}

if ($full_mime_type=="text/html"){
$att_path = $this->username . "\\���ı�����.htm";
$fp = fopen($att_path,"w");
fputs($fp,imap_base64(imap_fetchbody($this->inStream,$msg_num,$part_no)));
fclose($fp);
$this->attach[$this->num_of_attach]="���ı�����.htm";
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
$att_path = $this->username . "\\qp���ı�����.htm";
$fp = fopen($att_path,"w");
fputs($fp,imap_base64(imap_fetchbody($this->inStream,$msg_num,$part_no)));
fclose($fp);
$this->attach[$this->num_of_attach]="qp���ı�����.htm";
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

myimap����չ�࣬����ȡһ���ʼ�������(mail_read.php) 
<?
require("myimap.php");

class myimap_ext extends myimap {

function get_mail_subject($msg_no){
$msgHeader = @imap_header($this->inStream, $msg_no);
if (isset($msgHeader->subject))
$sub = trim($this->decode_mime_string($msgHeader->subject));
if ($sub == "")
$sub = "������";
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

myimap������(mail_list.php) 
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

��η��͸�����ת�� 
�Ҿ�����������һ�����⣺"����һ������վ�����ĺ�ͬ������θ�ͨ�������͵ĵ����ʼ�����һ�������أ�" 
������Ҫ˵����Ҫ�������û��ʲô�򵥵İ취����Ҫ�ܺõ����PHP��
�����ķ������˵Ľű����ԡ���Ȼ�㻹Ҫһ������֧��PHP����վ���˺š�������������ǰ�ᣬ��������˱��º�Ϳ�����PHP���ʹ������ĵ����ʼ��ˡ� 

1. ��������ι����� 

�����������PHP���ֲ���������"����"��������ô���������ʲô��û�У���������д���ĵ�ʱ�仹û�У����������Ҫ���ܶ�ʱ�����˽��ⷽ���֪ʶ�� 

��Ҳ����뵱���ĳ���˷���һ��������ĵ����ʼ�ʱ�������Ǻ��ʼ�һ��ŵ��ռ��˵�������ģ����磬��������/������һ��PNG��ͼƬ�ļ�����/��������������һ��txt�ļ��������ʼ�����һ��.png�ļ����������������ⲻ�����Ĺ���ԭ���������һ������ʱ������ʼ�����Ѹ���ת���ɴ��ı��ļ���������д�����ݣ�ʵ�ʵĵ����ʼ��������������ı��顣�������������еĶ������������ռ��˵�������ֻ��һ�����ı��ļ�--һ��ͬʱ����������ʵ�ʵ����ʼ����ݵ��ļ��� 

������һ����������һ��HTML�ļ��������ʼ������ӡ����Ѿ���ע��������Ҫ�ļ��У� 

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



ǰ���7�����ʼ���ͷ������ֵ��ע�����Content-typeͷ���֡����ͷ�����ʼ���������ʼ�����һ�����ϵĲ�����ɵġ������������ʼ�ֻ��һ�����֣���Ϣ�����������ĵ���ͨ����������������ɣ���Ϣ�͸������������������������ʼ�����������ɣ���Ϣ����һ�������͵ڶ��������� 

�������ĵ����ʼ��Ĳ�ͬ����֮���÷ֽ������ָ����ֽ�����Content-typeͷ�ж��塣�ʼ���ÿ���²������������ֺţ�--���ͷֽ��߿�ʼ�����һ���ֽ��ߺ�Ҳ���������ֺţ���ʾ����ʼ���û�������Ĳ����ˡ� 

��ÿ���ֽ��ߺ���һЩ�У����������ʼ�����������ֵ����ݵ����͡����磬�������������е�һ���ֽ��ߺ��������--��Content-type: text/plain��ͷ���С���Щ��˵������Ĳ�����ISO-8859-1�ַ����Ĵ��ı������ڵڶ����ֽ��ߺ���и����ʼ��������ڵĲ�����һ��HTML�ļ�������������"attachment.html"�� 

Content-disposition��ָ����ʼ�����������ܾ�����Ƕ�ķ�ʽ��ʾ�����������µ��ʼ����������Ϣ����ʾHTML�����ݡ����Content-disposition����Ϊattachment����ô�ʼ�����Ͳ�����ʾHTML�ļ������ݣ�������ʾһ�����ӵ��ļ���ͼ�꣨�����������ƵĶ��������ռ���Ҫ�����������ݣ����������ͼ�ꡣһ������£����������һЩ�ı�������HTML����Content-disposition�ᱻ��Ϊinline��������Ϊ���ڴ󲿷��ʼ������ܹ������������������ֱ����ʾ�������ı��������ݡ�������������ı�������ͼƬ���������Ƶ����ݣ���Content-disposition����Ϊattachment�� 

2. ��PHP���ɴ������ĵ����ʼ� 

����һ�����ӣ������������һ������õ�HTML�ļ���Ϊ�ʼ��ĸ����� 

<?php 
# ��������дʵ�ʵ���Ϣ���� 
$emailBody = "This is text that goes into the body of the email."; 

# Ȼ������Ҫ��Ϊ������HTML�ļ� 
$attachment = "<html> 
<head> 
<title>The attached file</title> 
</head> 
<body> 
<h2>This is the attached HTML file</h2> 
</body> 
</html>"; 

# �������ʼ��зָ���ͬ���ֵķֽ��ߡ� 
# �����ϣ��ֽ��߿�����������ַ����� 
# ������Ҫ��һ����ȷ��һ��д�ʼ����� 
# �������д�����ַ��������������� 
# uniqid����������һ��������ַ����� 
$boundary = uniqid( ""); 

# ��������Ҫ�����ʼ�ͷ����Ҫ���˲��� 
# Content-typeͷ��˵������ʼ�����һ�������ĸ����� 
$headers = "From: someone@example.com 
Content-type: multipart/mixed; boundary=\"$boundary\""; 

# �ã����������Ѿ������ʼ����������ݡ� 
# ��һ�������޸��ʼ������塣 
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

# ���ڿ��԰��ʼ�����ȥ�� 
mail( "person@eksempel.dk", "The subject", $emailBody, $headers); 
?> 



3. ���û��ϴ����ļ���Ϊ���� 

��Ҳ���������������������⣬������...�����������������������ˣ���Ϊ����Ҫ��һ�������û��ϴ����ǵ��ļ�����������ļ���Ϊ����Ҫ�����ʼ��ĸ������鷳�������ǲ���Ԥ��֪���ļ���MIME���͡���ǰ��������У������Ѿ�֪��������һ��HTML�ļ������Ը������������Content-typeͷ�Ǻܼ򵥵ġ�������������У�MIME���Ϳ���������ģ���Ϊ�û����ܻ��ϴ�һ��HTML�ļ���һ��PNG�ļ���һ��vCard�ļ������������Ķ��������������������ӣ� 

<?php 
# �������������ɱ����ڲ��������ϴ��ļ��ı�ʱ�� 
# ��Ҫ���˰�<form>��ǩ��"enctype"������Ϊ"multipart/form-data". 
echo "<form action='$PHP_SELF' enctype='multipart/form-data' method='post'>\n"; 
echo "<input type='text' name='from'><br>\n"; 
echo "<input type='text' name='to'><br>\n"; 
echo "<input type='text' name='subject'><br>\n"; 
echo "<input type='file' name='attachment'><br>\n"; 
echo "<textarea name='body'></textarea><br>\n"; 
echo "<input type='submit' name='send' value='Send'>\n"; 
echo "</form>\n"; 

# ����û��Ѿ�����"Send"��ť" 
if ($send) { 
# ����ֽ��� 
$boundary = uniqid( ""); 

# �����ʼ�ͷ 
$headers = "From: $from 
Content-type: multipart/mixed; boundary=\"$boundary\""; 

# ȷ���ϴ��ļ���MIME���� 
if ($attachment_type) $mimeType = $attachment_type; 
# ��������û��ָ���ļ���MIME���ͣ� 
# ���ǿ��԰�����Ϊ"application/unknown". 
else $mimeType = "application/unknown"; 

# ȷ���ļ������� 
$fileName = $attachment_name; 

# ���ļ� 
$fp = fopen($attachment, "r"); 
# �������ļ�����һ������ 
$read = fread($fp, filesize($attachment)); 

# �ã����ڱ���$read�б�����ǰ��������ļ����ݵ��ı��顣 
# ��������Ҫ������ı���ת�����ʼ�������Զ����ĸ�ʽ 
# ������base64������������ 
$read = base64_encode($read); 

# ����������һ����base64��������ĳ��ַ����� 
# ��һ������Ҫ��������ַ����г���ÿ��76���ַ���ɵ�С�� 
$read = chunk_split($read); 

# �������ǿ��Խ����ʼ������� 
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

# �����ʼ� 
mail($to, $subject, $body, $headers); 
} 
?>

