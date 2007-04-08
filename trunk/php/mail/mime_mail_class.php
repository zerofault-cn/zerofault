<?
/*****************************************
**MIME 邮件发送(2000.12)
**avatar@peoplemail.com.cn
**
**Thanks to : Dan Potter and Tony
*****************************************/
//-------------------------------------
//类的调用方法
//-------------------------------------
//include("mime_mail_class.php");
//$message=new MIMEMail();
//$message->to="tony@sequoiasoft.com";
//$message->subject="Hello!";
//$message->headers["Reply-To"]="webmaster@www.somedomain.net";
//$message->headers["From"]="avatar@peoplemail.com.cn";
//$message->attachments[0]="images/flower.gif";
//$message->attachments[1]="document.zip";
//$message->disposition[0]="inline";
//$message->disposition[1]="attachment";
//$message->MIMEType[0]="image/gif";
//$message->MIMEType[1]="application/zip";
//$message->body="Thank you very much!";
//$message->CharSet="gb2312";
//$message->SendMail();
//
//说明：
//headers[]为自定义邮件头格式，可省略。
//disposition[]为附件的显示方式，默认为attachment
//MIMEType[]为附件文件的MIME类型，可以不指定，程序会自动判断。
//CharSet 为邮件字符编码 默认为gb2312
//-------------------------------------

class MIMEMail
{
var $to;//收信人邮件地址
var $subject;//主题
var $headers;//邮件头信息
var $attachments;//附件
var $body;//正文
var $warning="这是一封MIME邮件的首部,如果以下部分无法读取,请与发信者联系!";//MIME 说明
var $boundary="--==thismimemailclassiswritedwithphpbyavatar==--";//分界符
var $MIMEType;//使用者指定的MIME类型
var $disposition;//指定附件方式:attachment(附加形式)或者inline(正文显示附件)
var $CharSet;//字符编码

//-------------------------------------
//定义初始值类型函数
//-------------------------------------
function MIMEMmail()
{
$this->to="";
$this->subject="";
$this->headers=array();
$this->attachments=array();
$this->body="";
$this->MIMEType=array();
$this->disposition=array();
$this->CharSet="";
}
//-------------------------------------

//-------------------------------------
//取得附件的MIME类型
//-------------------------------------
function GetMIMEType($FileName)
{
$FileName=basename($FileName);
if(!strrchr($FileName,"."))
{
return("application/octet-stream");
}
$ext=strrchr($FileName,".");
switch($ext)
{
case ".gif":
return "image/gif";
break;

case ".jpg":
return "image/jpeg";
break;

case ".bmp":
return "image/bmp";
break;

case ".png":
return "image/png";
break;

case ".mp3":
return "audio/mpeg";
break;

case ".mpga":
return "audio/mpeg";
break;

case ".txt":
return "text/plain";
break;

case ".html":
return "text/html";
break;

case ".htm":
return "text/html";
break;

case ".pdf":
return "application/pdf";
break;

case ".zip":
return "application/zip";
break;

case ".gz":
return "application/x-gzip";
break;

case ".tar":
return "application/x-tar";
break;

default:
return "application/octet-stream";
break;
}
}
//-------------------------------------

//-------------------------------------
//发送邮件函数
//-------------------------------------
function SendMail()
{
$SendBody=$this->GetBody($this->body);
$SendHeaders=$this->GetHeaders($this->headers);
mail($this->to,$this->subject,$SendBody,$SendHeaders);
}
//-------------------------------------

//-------------------------------------
//处理邮件头函数
//-------------------------------------
function GetHeaders($headers)
{
//处理使用者指定的邮件头.如:headers["Reply-To"],headers["X-Extra-Header"]
if(count($headers)>0)
{
reset($headers);
while(list($HeaderKey,$Headervalues)=each($headers))
{
$TempHeaders.=$HeaderKey.":".$Herdervalues."
";
}
}

//有附件的MIME邮件头
if(count($this->attachments)>0)
{
$TempHeaders.="MIME-Version:1.0\n";
$TempHeaders.="Content-Type:multipart/mixed;";
$TempHeaders.="boundary=".$this->boundary."\n
";
$TempHeaders.=$this->warning;
}

return $TempHeaders;
}
//-------------------------------------

//-------------------------------------
//处理邮件正文函数
//-------------------------------------
function GetBody($body)
{
//有附件的邮件正文部分
if(count($this->attachments)>0)
{
//如果没有指定字符编码,默认为gb2312
if(empty($this->CharSet))
{
$this->CharSet="gb2312";
}
$TempBody.="--".$this->boundary."\n
";
$TempBody.="Content-Type:text/plain;charset=".$this->CharSet."\n

";
}
$TempBody.=$body."

";

//处理附件
if(count($this->attachments)>0)
{
for($i=0;$i<count($this->attachments);$i++)
{
$TempBody.="--".$this->boundary."
";

//如果没有指定附件的MIME类型
if(empty($this->MIMEType[$i]))
{
$TempBody.="Content-Type:".$this->GetMIMEType($this->attachments[$i]).";";
$TempBody.="name=".basename($this->attachments[$i])."
";
$TempBody.="Content-Transfer-Encoding:base64
";

//检查是否指定附件的显示方式,默认为attachment
if(empty($this->disposition))
{
$this->disposition="attachment";
}
$TempBody.="Content-disposition:".$this->disposition.";";
$TempBody.="filename=".basename($this->attachments[$i])."

";
$TempBody.=$this->EncodeFile($this->attachments[$i])."
";
}
}
$TempBody.="--".$this->boundary."--
";
}

return $TempBody;
}
//-------------------------------------

//-------------------------------------
//对文件进行编码
//-------------------------------------
function EncodeFile($FileName)
{
if(is_readable($FileName))
{
$fp=fopen($FileName,"r");
$contents=fread($fp,filesize($FileName));
$encode=$this->ChunkSplit(base64_encode($contents));
fclose($fp);
}

return $encode;
}
//-------------------------------------

//-------------------------------------
//以每行76个字符分离邮件正文
//-------------------------------------
function ChunkSplit($string)
{
$StrLen=strlen($string);
while($StrLen>0)
{
if($StrLen>76)
{
$TempString.=substr($string,0,76)."
";
$string=substr($string,76);
$StrLen=$StrLen-76;
}
else
{
$TempString.=$string."
";
$StrLen=0;
}
}

return $TempString;
}
//-------------------------------------

}
?>


