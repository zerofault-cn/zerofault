<?php
/**
*����id��ȡmm_info�е��ض��е�ֵ
*��������mm_comment��mm_info������Ӳ�ѯ
*/
function getField($mm_id,$mm_field,$table='mm_info')
{
	global $db;
	$sql0="select ".$mm_field." from ".$table." where id=".$mm_id;
	$result0=$db->sql_query($sql0);
	$value=$db->sql_fetchfield(0,0,$result0);
//	$db->sql_freeresult($result0);
	return $value;
}
function getOrder($mm_id)
{
	global $db;
	$sql="select id from mm_info where pass=1 order by allvote desc,id";
	$result=$db->sql_query($sql);
	while($row=$db->sql_fetchrow($result))
	{
		$order++;
		if($mm_id==$row['id'])
		{
			break;
		}
	}
	return $order;
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
function format2($text) {
	$text=str_replace(";","",$text);
	$text=htmlspecialchars($text);
	$text=addslashes($text);
}
function mailto($email,$subject,$info_arr,$id)
{
	global $root_path;
	include_once($root_path."includes/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->setPluginDir($root_path."includes/");//����includeĿ¼���Լ���ԭʼclass������ӵ�
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

function mailtohb($id,$bokeeurl,$email)
{
	global $root_path;
	include_once($root_path."includes/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->setPluginDir($root_path."includes/");//����includeĿ¼���Լ���ԭʼclass������ӵ�
	$mail->IsSMTP(); // set mailer to use SMTP
	$mail->CharSet = 'gb2312';
	$mail->Encoding = 'base64';
	$mail->From = 'cxmtian@163.com';
	$mail->FromName = 'mm.bokee.com';
	$mail->Host = 'smtp.163.com';
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->Username = $mail->From;
	$mail->Password = "198105048154";
	
	$mail->addAddress($email);
	$mail->setSender('haoranzhang@bokee-inc.com');//����return_path�����ظ���ַ,��ĳЩ�ʼ�����������
	$mail->AddReplyTo('haoranzhang@bokee-inc.com', '������'); //���gmail���ã�gmail��In-Reply-To:��phpmailerĬ�����ɵ���Reply-to:
	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->Subject ='�ڶ�����Ů���ʹ������ǿռ�԰�û�Ҳ�����ϴ���Ƶ��';
	$html=file_get_contents("../mail3.inc.php");
	$html=str_replace('{UPLOADURL}','http://my.bobo.com.cn/bokee/zhong.php?flag=up&userid='.$id.'&bokeeURL='.$bokeeurl,$html);
	$mail->Body = $html;

	if(!$mail->Send())
	{
		return false;
	}
	else
	{
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
	if(strrpos($ip,',')>0)
	{
		$ip=substr($ip,0,strrpos($ip,','));//��ȡ��ʵIP��ȥ������IP
	}
	return($ip);
}

/*
�����յ��Ķ��Ų������浽�ļ���
*/
function writeLog($filename,$str,$info)
{
	$fp=fopen($filename,"r+");
	$time=date("Y-m-d H:i:s");
	fseek($fp,filesize($filename));
	fwrite($fp,$time."|".$str."|".$info."\r\n");
	fclose($fp);
}

/*
��xmlת��Ϊ����
*/
function makeXMLTree($data)
{
	$ret = array();
	$parser = xml_parser_create();
	xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
	xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);
	xml_parse_into_struct($parser,$data,$values,$tags);
	xml_parser_free($parser);

	$hash_stack = array();

	foreach ($values as $key => $val)
	{
		switch ($val['type'])
		{
			case 'open':
				array_push($hash_stack, $val['tag']);
				break;
			case 'close':
				array_pop($hash_stack);
				break;
			case 'complete':
				array_push($hash_stack, $val['tag']);
				eval("\$ret[" . implode($hash_stack, "][") . "] = '{$val[value]}';");
				array_pop($hash_stack);
			break;
		}
	}
	return $ret;
}
function has_str($haystack,$needle,$offset=0)
{ 
	//Ѱ���ַ���haystack��needle�Ƿ���� 
	//�÷���strpos��ͬ��myStrPos(string haystack��string needle��int [offset]); 
	$lenSource=strlen($haystack); 
	$lenKey=strlen($needle); 
	$find=0; 
	for($i=$offset;$i<($lenSource-$lenKey+1);$i++) 
	{
		if(substr($haystack,$i,$lenKey)==$needle)
		{ 
			$find=1;//�ҵ��˳�ѭ�� 
			break; 
		} 
	}
	if($find)
		return 1; //�ҵ��򷵻�1
	else 
		return 0;//û�ҵ��ͷ���0 
}

function checkLogin($blogurl)
{
	$bokie=split(',',base64_decode($_COOKIE['bokie']));
	$cBlogID=substr($bokie[1],0,strpos($bokie[1],'.'));
	$blogID=substr($blogurl,7,strpos($blogurl,'.')-7);
	if(''!=$cBlogID && ''!=$blogID && $cBlogID==$blogID)
	{
		return true;
	}
	else
	{
		return false;
	}
}
function checkIP($ip)
{
	$ip_arr=split(".",$ip);
	if(ereg("^222.43.(192|193|194|195|196|197|198|199|201).[0-9]+$",$ip))
	{
		header("HTTP/1.1 404 Not Found");
		exit;//ID:0096,date:2007-03-21
	}
	if(ereg("^210.240.106.[0-9]+$",$ip))
	{
		header("HTTP/1.1 404 Not Found");
		exit;//ID:0204,date:2007-03-20
	}
	if(ereg("^60.0.(216|217|218|219|220|221|222|223).[0-9]+$",$ip))
	{
		header("HTTP/1.1 404 Not Found");
		exit;//ID:0283,date:2007-03-18
	}
	if(ereg("^58.210.(112|113|114|115|116|117).[0-9]+$",$ip))
	{
		header("HTTP/1.1 404 Not Found");
		exit;//ID:1225,date:2007-03-21
	}
	if(ereg("^221.200.(100|101|102|170|204|205|206|207).[0-9]+$",$ip))
	{
		header("HTTP/1.1 404 Not Found");
		exit;//ID:1354,date:2007-03-23
	}
	if(ereg("^202.105.(100|101|102).[0-9]+$",$ip) || ereg("^61.141.(168|169).[0-9]+$",$ip))
	{
		header("HTTP/1.1 404 Not Found");
		exit;//ID:0663,date:2007-03-23
	}
	if(ereg("^124.226.(48|49|50|51|53|54|56|57).[0-9]+$",$ip) || ereg("^125.73.(16|17|18|19|20|21|22|23|3|4|5|6|7).[0-9]+$",$ip) || ereg("^218.65.(180|181).[0-9]+$",$ip))
	{
		header("HTTP/1.1 404 Not Found");
		exit;//ID:0853,date:2007-03-25
	}
	if(ereg("^208.53.(138|131).[0-9]+$",$ip))
	{
		header("HTTP/1.1 404 Not Found");
		exit;//ID:0798,date:2007-03-26
	}

}
?>