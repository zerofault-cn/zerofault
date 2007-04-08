<?
/*****************************************
**MIME �ʼ�����(2000.12)
**avatar@peoplemail.com.cn
**
**Thanks to : Dan Potter and Tony
*****************************************/
//-------------------------------------
//��ĵ��÷���
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
//˵����
//headers[]Ϊ�Զ����ʼ�ͷ��ʽ����ʡ�ԡ�
//disposition[]Ϊ��������ʾ��ʽ��Ĭ��Ϊattachment
//MIMEType[]Ϊ�����ļ���MIME���ͣ����Բ�ָ����������Զ��жϡ�
//CharSet Ϊ�ʼ��ַ����� Ĭ��Ϊgb2312
//-------------------------------------

class MIMEMail
{
var $to;//�������ʼ���ַ
var $subject;//����
var $headers;//�ʼ�ͷ��Ϣ
var $attachments;//����
var $body;//����
var $warning="����һ��MIME�ʼ����ײ�,������²����޷���ȡ,���뷢������ϵ!";//MIME ˵��
var $boundary="--==thismimemailclassiswritedwithphpbyavatar==--";//�ֽ��
var $MIMEType;//ʹ����ָ����MIME����
var $disposition;//ָ��������ʽ:attachment(������ʽ)����inline(������ʾ����)
var $CharSet;//�ַ�����

//-------------------------------------
//�����ʼֵ���ͺ���
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
//ȡ�ø�����MIME����
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
//�����ʼ�����
//-------------------------------------
function SendMail()
{
$SendBody=$this->GetBody($this->body);
$SendHeaders=$this->GetHeaders($this->headers);
mail($this->to,$this->subject,$SendBody,$SendHeaders);
}
//-------------------------------------

//-------------------------------------
//�����ʼ�ͷ����
//-------------------------------------
function GetHeaders($headers)
{
//����ʹ����ָ�����ʼ�ͷ.��:headers["Reply-To"],headers["X-Extra-Header"]
if(count($headers)>0)
{
reset($headers);
while(list($HeaderKey,$Headervalues)=each($headers))
{
$TempHeaders.=$HeaderKey.":".$Herdervalues."
";
}
}

//�и�����MIME�ʼ�ͷ
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
//�����ʼ����ĺ���
//-------------------------------------
function GetBody($body)
{
//�и������ʼ����Ĳ���
if(count($this->attachments)>0)
{
//���û��ָ���ַ�����,Ĭ��Ϊgb2312
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

//������
if(count($this->attachments)>0)
{
for($i=0;$i<count($this->attachments);$i++)
{
$TempBody.="--".$this->boundary."
";

//���û��ָ��������MIME����
if(empty($this->MIMEType[$i]))
{
$TempBody.="Content-Type:".$this->GetMIMEType($this->attachments[$i]).";";
$TempBody.="name=".basename($this->attachments[$i])."
";
$TempBody.="Content-Transfer-Encoding:base64
";

//����Ƿ�ָ����������ʾ��ʽ,Ĭ��Ϊattachment
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
//���ļ����б���
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
//��ÿ��76���ַ������ʼ�����
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


