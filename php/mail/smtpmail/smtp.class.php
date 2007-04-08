<?
set_time_limit(120);
class smtp_mail
{
var $host;          //����
var $port;          //�˿� һ��Ϊ25
var $user;          //SMTP��֤���ʺ�
var $pass;          //��֤����
var $debug = false;   //�Ƿ���ʾ�ͷ������Ự��Ϣ��
var $conn;
var $result_str;      //���
var $in;          //�ͻ������͵�����
var $from_r;          //��ʵ��Դ����,һ����smtp���������û���һ���������������smtp�����������ö����Ͳ��ɹ�
var $mailformat=0; //�ʼ���ʽ 0=��ͨ�ı� 1=html�ʼ�
function smtp_mail($host,$port,$user,$pass,$debug=false)
{
$this->host   = 'ssl://'.$host;
$this->port   = $port;
$this->user   = base64_encode($user);
$this->pass   = base64_encode($pass);
$this->debug  = $debug;
$this->socket = socket_create (AF_INET, SOCK_STREAM, SOL_TCP);  //�����÷���ο��ֲ�
if($this->socket)
{
$this->result_str  =  "����SOCKET:".socket_strerror(socket_last_error());
$this->debug_show($this->result_str);
}
else
{
exit("��ʼ��ʧ�ܣ����������������ӺͲ���");
}
$this->conn = socket_connect($this->socket,$this->host,$this->port);
if($this->conn)
{
$this->result_str  =  "����SOCKET����:".socket_strerror(socket_last_error());
$this->debug_show($this->result_str);
}
else
{
exit("��ʼ��ʧ�ܣ����������������ӺͲ���");
}
$this->result_str = "������Ӧ��<font color=#cc0000>".socket_read ($this->socket, 1024)."</font>";
$this->debug_show($this->result_str);
}
function debug_show($str)
{
if($this->debug)
{
echo $str."<p>\r\n";
}
}
function send($from,$to,$subject,$body)
{
if($from == "" || $to == "")
{
exit("�����������ַ");
}
if($subject == "") $sebject = "�ޱ���";
if($body    == "") $body    = "������";
$All          = "From:".$from."\r\n";
$All          .= "To:".$to."\r\n";
$All          .= "Subject:".$subject."\r\n";
if($this->mailformat==1) $All.= "Content-Type: text/html;\r\n";
else $All .= "Content-Type: text/plain;\r\n";
$All          .= "charset=gb2312\r\n\r\n";
$All          .= $body;
/*
�����$All�������ټӴ����Ϳ���ʵ�ַ���MIME�ʼ���
��������Ҫ�Ӻܶ����
*/
//�����Ǻͷ������Ự
$this->in       =  "EHLO HELO\r\n";
$this->docommand();
$this->in       =  "AUTH LOGIN\r\n";
$this->docommand();
$this->in       =  $this->user."\r\n";
$this->docommand();
$this->in       =  $this->pass."\r\n";
$this->docommand();
if(!eregi("235",$this->result_str)){
$this->result_str = "smtp ��֤ʧ��";
$this->debug_show($this->result_str);
return 0;
}
$this->in       =  "MAIL FROM:".$from."\r\n";
$this->docommand();
$this->in       =  "RCPT TO:".$to."\r\n";
$this->docommand();
$this->in       =  "DATA\r\n";
$this->docommand();
$this->in       =  $All."\r\n.\r\n";
$this->docommand();
if(!eregi("250",$this->result_str)){
$this->result_str = "�ʼ�����ʧ��";
$this->debug_show($this->result_str);
return 0;
}
$this->in       =  "QUIT\r\n";
$this->docommand();
//�������ر�����
return 1;
}
function docommand()
{
socket_write ($this->socket, $this->in, strlen ($this->in));
$this->debug_show("�ͻ������".$this->in);
$this->result_str = "������Ӧ��<font color=#cc0000>".socket_read ($this->socket, 1024)."</font>";
$this->debug_show($this->result_str);
}
} //end class
?>