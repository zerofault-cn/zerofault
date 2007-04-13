<?php
/**
*����id��ȡmm_info�е��ض��е�ֵ
*��������mm_comment��mm_info������Ӳ�ѯ
*/
function getField($id,$field)
{
	global $db;
	$sql0="select ".$field." from user_info where id=".$id;
	$result0=$db->sql_query($sql0);
	$row=$db->sql_fetchrow($result0);
	$value=$row[$field];
	$db->sql_freeresult($result0);
	return $value;
}

/**
*ת���ַ�����ĺ���
*��Ϊ��20.36���ύ�ı��еı�������utf-8�����,�������ݿ�ǰҪ��תΪgb2312
*ֻ�а��������ַ�����Ҫת��,���ֺ�Ӣ�Ĳ���Ҫת��
*/
function conv($str)
{
	return mb_convert_encoding($str,"gbk","utf-8,gbk,gb2312");
}

/**
*�ַ�����ȡ������
*��֤�õ����ַ�����û�а�����ֵ����
*/
function substr_cut($str_cut,$length = 10)
{
	if (strlen($str_cut) > $length)
	{
		for($i=0; $i < $length; $i++)
		{
			if (ord($str_cut[$i]) > 128)
			{
				$i++;
			}
		}
	$str_cut = substr($str_cut,0,$i);
	}
	return $str_cut;
}
/**
*�������ʱ�õ�
*/
function format($text)
{
	$text=htmlspecialchars($text);
	$text=str_replace(" ","&nbsp;",$text);
	$text=nl2br($text);
//	$text=str_replace("\r\n","",$text);
//	$text=str_replace("\n","",$text);
//	$text=addslashes($text);
	return $text;
}

function mailto($email,$subject,$info_arr,$id)
{
	global $php_path;
	include_once($php_path."includes/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->setPluginDir($php_path."includes/");//����includeĿ¼���Լ���ԭʼclass������ӵ�
	$mail->IsSMTP(); // set mailer to use SMTP
	$mail->CharSet = 'gb2312';
	$mail->Encoding = 'base64';
//	$mail->From = 'zerofault@gmail.com';
	$mail->From = 'cxmtian@163.com';
	$mail->FromName = 'mm.bokee.com';
//	$mail->Host = 'ssl://smtp.gmail.com';
//	$mail->Host = 'ssl://webmail.bokee-inc.com';//��֤�����⣬�޷�ʹ��
//	$mail->Host = 'mx1.bokee.com';
	$mail->Host = 'smtp.163.com';
//	$mail->Port = 465; //default is 25, gmail is 465 or 587
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->Username = $mail->From;
	$mail->Password = "198105048154";
	
	$mail->addAddress($email);
	$mail->setSender('haoranzhang@bokee-inc.com');//����return_path�����ظ���ַ,��ĳЩ�ʼ�����������
	$mail->AddReplyTo('haoranzhang@bokee-inc.com', '������'); //���gmail���ã�gmail��In-Reply-To:��phpmailerĬ�����ɵ���Reply-to:
	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	//����html��ʽ�ʼ�����
	if(is_array($info_arr) && sizeof($info_arr)>0)
	{
		$html=file_get_contents("mail1.inc.php");
		for($i=0;$i<sizeof($info_arr);$i++)
		{
			$body.='<div><span class="label">'.$info_arr[$i][0].'��</span><span class="value">'.$info_arr[$i][1].'</span></div>'."\r\n";
		}
		$html=str_replace('<!-- INFO -->',$body,$html);
	}
	else
	{
		$html=file_get_contents("../mail2.inc.php");
		$html=str_replace('{ID}',$id,$html);
	}
	$mail->Body = $html;

	if(!$mail->Send())
	{
//		echo "Mail send failed.\r\n";
//		echo "Error message: ". $mail->ErrorInfo ."\r\n";
		return false;
	}
	else
	{
//		echo("Send to <".$email."> successed.\r\n");
		return true;
	}
}
/**
*��ʮ����ipת��Ϊʮ�����ƣ���ȥ����.��
*/
function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}
/**
*��ʮ������ip��ԭ��ʾ
*/
function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}
/**
*��ȡ�û�IP
*/
function GetIP()
{
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
	{
		$ip = getenv("HTTP_CLIENT_IP");
	}
	elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
	{
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	}
	elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
	{
		$ip = getenv("REMOTE_ADDR");
	}
	elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
	{
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	else
	{
		$ip = "unknown";
	}
	$ip=substr($ip,0,strpos($ip,','));
	return($ip);
}
?>