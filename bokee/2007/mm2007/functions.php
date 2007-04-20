<?php
/**
*根据id读取mm_info中的特定列的值
*用来避免mm_comment与mm_info表的连接查询
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
*转换字符编码的函数
*因为从20.36上提交的表单中的变量都是utf-8编码的,存入数据库前要先转为gb2312
*只有包含中文字符的需要转换,数字和英文不需要转换
*/
function conv($str)
{
	return mb_convert_encoding($str,"gbk","utf-8,gbk,gb2312");
}

/**
*字符串截取函数，
*保证得到的字符串中没有半个汉字的情况
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
*添加留言时用到
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
	$mail->setPluginDir($root_path."includes/");//设置include目录，自己在原始class里面另加的
	$mail->IsSMTP(); // set mailer to use SMTP
	$mail->CharSet = 'gb2312';
	$mail->Encoding = 'base64';
//	$mail->From = 'zerofault@gmail.com';
	$mail->From = 'cxmtian@163.com';
	$mail->FromName = 'mm.bokee.com';
//	$mail->Host = 'ssl://smtp.gmail.com';
//	$mail->Host = 'ssl://webmail.bokee-inc.com';//因证书问题，无法使用
//	$mail->Host = 'mx1.bokee.com';
	$mail->Host = 'smtp.163.com';
//	$mail->Port = 465; //default is 25, gmail is 465 or 587
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->Username = $mail->From;
	$mail->Password = "198105048154";
	
	$mail->addAddress($email);
	$mail->setSender('haoranzhang@bokee-inc.com');//设置return_path，即回复地址,对某些邮件服务器有用
	$mail->AddReplyTo('haoranzhang@bokee-inc.com', '博客网'); //针对gmail无用，gmail是In-Reply-To:，phpmailer默认生成的是Reply-to:
	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	//生成html格式邮件内容
	if(is_array($info_arr) && sizeof($info_arr)>0)
	{
		$html=file_get_contents("mail1.inc.php");
		for($i=0;$i<sizeof($info_arr);$i++)
		{
			$body.='<div><span class="label">'.$info_arr[$i][0].'：</span><span class="value">'.$info_arr[$i][1].'</span></div>'."\r\n";
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
	$mail->setPluginDir($root_path."includes/");//设置include目录，自己在原始class里面另加的
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
	$mail->setSender('haoranzhang@bokee-inc.com');//设置return_path，即回复地址,对某些邮件服务器有用
	$mail->AddReplyTo('haoranzhang@bokee-inc.com', '博客网'); //针对gmail无用，gmail是In-Reply-To:，phpmailer默认生成的是Reply-to:
	$mail->WordWrap = 50;
	$mail->IsHTML(true);
	$mail->Subject ='第二届美女博客大赛：星空家园用户也可以上传视频了';
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
*将十进制ip转换为十六进制，并去掉“.”
*/
function encode_ip($dotquad_ip)
{
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}
/**
*将十六进制ip还原显示
*/
function decode_ip($int_ip)
{
	$hexipbang = explode('.', chunk_split($int_ip, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}
/**
*获取用户IP
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
		$ip=substr($ip,0,strrpos($ip,','));//截取真实IP，去掉代理IP
	}
	return($ip);
}

/*
将接收到的短信参数保存到文件中
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
将xml转换为数组
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
	//寻找字符串haystack中needle是否存在 
	//用法和strpos相同即myStrPos(string haystack，string needle，int [offset]); 
	$lenSource=strlen($haystack); 
	$lenKey=strlen($needle); 
	$find=0; 
	for($i=$offset;$i<($lenSource-$lenKey+1);$i++) 
	{
		if(substr($haystack,$i,$lenKey)==$needle)
		{ 
			$find=1;//找到退出循环 
			break; 
		} 
	}
	if($find)
		return 1; //找到则返回1
	else 
		return 0;//没找到就返回0 
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