<?
function getBrowser() 
{
	$Agent=$_SERVER['HTTP_USER_AGENT'];
	if(eregi("(opera) ([0-9]{1,2}.[0-9]{1,3}){0,1}",$Agent,$match) || eregi("(opera/)([0-9]{1,2}.[0-9]{1,3}){0,1}",$Agent,$match)) 
	{
		$BName = "Opera"; 
		$BVersion=$match[2]; 
	}
	elseif(eregi("(konqueror)/([0-9]{1,2}.[0-9]{1,3})",$Agent,$match)) 
	{
		$BName = "Konqueror"; 
		$BVersion=$match[2]; 
	}
	elseif(eregi("(lynx)/([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})",$Agent,$match)) 
	{
		$BName = "Lynx "; 
		$BVersion=$match[2]; 
	}
	elseif(eregi("(links) ([0-9]{1,2}.[0-9]{1,3})",$Agent,$match)) 
	{ 
		$BName = "Links "; 
		$BVersion=$match[2]; 
	} 
	elseif(eregi("(msie) ([0-9]{1,2}.[0-9]{1,3})",$Agent,$match)) 
	{ 
		$BName = "Internet Explorer"; 
		$BVersion=$match[2]; 
	} 
	elseif(eregi("(netscape6)/(6.[0-9]{1,3})",$Agent,$match)) 
	{ 
		$BName = "Netscape "; 
		$BVersion=$match[2]; 
	} 
	elseif(eregi("mozilla/5",$Agent)) 
	{ 
		$BName = "mozilla"; 
		$BVersion="Unknown"; 
	} 
	elseif(eregi("(mozilla)/([0-9]{1,2}.[0-9]{1,3})",$Agent,$match)) 
	{ 
		$BName = "Netscape "; 
		$BVersion=$match[2]; 
	} 
	elseif(eregi("w3m",$Agent)) 
	{ 
		$BName = "w3m"; 
		$BVersion="Unknown"; 
	} 
	else
	{
		$BName = "Unknown"; 
		$BVersion="Unknown";
	} 
	return $BName;
}
function getOS() //操作系统简单信息
{
	$os=""; 
	$Agent = $_SERVER['HTTP_USER_AGENT']; 
	if (eregi('windows',$Agent)) 
	{
		$os="Windows"; 
	} 
	elseif (eregi('linux',$Agent)) 
	{
		$os="Linux"; 
	}
	elseif (eregi('unix',$Agent)) 
	{
		$os="Unix"; 
	}
	elseif (eregi('sun',$Agent) && eregi('os',$Agent))
	{
		$os="SunOS"; 
	}
	elseif (eregi('ibm',$Agent) && eregi('os',$Agent)) 
	{
		$os="IBM OS/2"; 
	}
	elseif (eregi('Mac',$Agent) && eregi('PC',$Agent)) 
	{
		$os="Macintosh"; 
	}
	elseif (eregi('PowerPC',$Agent))
	{
		$os="PowerPC"; 
	} 
	elseif (eregi('AIX',$Agent)) 
	{
		$os="AIX"; 
	}
	elseif (eregi('HPUX',$Agent)) 
	{
		$os="HPUX"; 
	}
	elseif (eregi('NetBSD',$Agent)) 
	{
		$os="NetBSD"; 
	} 
	elseif (eregi('BSD',$Agent)) 
	{
		$os="BSD"; 
	}
	elseif (ereg('OSF1',$Agent)) 
	{
		$os="OSF1"; 
	}
	elseif (ereg('IRIX',$Agent)) 
	{
		$os="IRIX"; 
	}
	elseif (eregi('FreeBSD',$Agent)) 
	{
		$os="FreeBSD"; 
	}
	if ($os=='') 
		$os = "Unknown"; 
	return $os; 
} 
function getOperation() //操作系统详细信息
{
	$os=""; 
	$Agent = $_SERVER['HTTP_USER_AGENT'];
	if (eregi('win',$Agent) && strpos($Agent, '95')) 
	{
		$os="Windows 95"; 
	} 
	elseif (eregi('win 9x',$Agent) && strpos($Agent, '4.90'))
	{
		$os="Windows ME"; 
	} 
	elseif (eregi('win',$Agent) && ereg('98',$Agent))
	{
		$os="Windows 98"; 
	} 
	elseif (eregi('win',$Agent) && eregi('nt 5\.0',$Agent)) 
	{
		$os="Windows 2000";  
	}
	elseif (eregi('win',$Agent) && eregi('nt 5.1',$Agent)) 
	{
		$os="Windows XP";  
	}
	elseif (eregi('win',$Agent) && eregi('nt',$Agent))
	{
		$os="Windows NT"; 
	}
	elseif (eregi('win',$Agent) && ereg('32',$Agent))
	{
		$os="Windows 32"; 
	}
	elseif (eregi('linux',$Agent)) 
	{
		$os="Linux"; 
	}
	elseif (eregi('unix',$Agent)) 
	{
		$os="Unix"; 
	}
	elseif (eregi('sun',$Agent) && eregi('os',$Agent))
	{
		$os="SunOS"; 
	}
	elseif (eregi('ibm',$Agent) && eregi('os',$Agent)) 
	{
		$os="IBM OS/2"; 
	}
	elseif (eregi('Mac',$Agent) && eregi('PC',$Agent)) 
	{
		$os="Macintosh"; 
	}
	elseif (eregi('PowerPC',$Agent))
	{
		$os="PowerPC"; 
	} 
	elseif (eregi('AIX',$Agent)) 
	{
		$os="AIX"; 
	}
	elseif (eregi('HPUX',$Agent)) 
	{
		$os="HPUX"; 
	}
	elseif (eregi('NetBSD',$Agent)) 
	{
		$os="NetBSD"; 
	} 
	elseif (eregi('BSD',$Agent)) 
	{
		$os="BSD"; 
	}
	elseif (ereg('OSF1',$Agent)) 
	{
		$os="OSF1"; 
	}
	elseif (ereg('IRIX',$Agent)) 
	{
		$os="IRIX"; 
	}
	elseif (eregi('FreeBSD',$Agent)) 
	{
		$os="FreeBSD"; 
	}
	if ($os=='') 
		$os = "Unknown"; 
	return $os; 
}
//$ip=$_SERVER["REMOTE_ADDR"];
//$part=3;//表示返回的地址格式,"1"代表只返回{国家)省(市),2表示只返回城市,3表示都返回
function getAddr($ip,$part)
{ 
	$ipfolder="../include/iptable"; 
	if(!file_exists($ipfolder))
	{
		return 'no iptable';
	}
	$ipa=split("[.]",$ip); 
	$ips=$ipa[0]*1000000000+$ipa[1]*1000000+$ipa[2]*1000+$ipa[3]; 
	$ipa[0]=intval($ipa[0]);
	if(file_exists($ipfolder.'/'.$ipa[0].'.txt'))
	{
		$datafile=$ipfolder.'/'.$ipa[0].'.txt'; 
	} 
	else
	{ 
		$datafile=$ipfolder.'/0.txt';
	} 
	$ipdata=file($datafile); 
	for($i=0;$i<count($ipdata);$i++) 
	{
		$ipb=split("[|]",$ipdata[$i]); 
		$ipc=split("[.]",$ipb[0]); 
		$ipd=split("[.]",$ipb[1]); 
		$from1=$ipb[2]; 
		$from2=$ipb[3]; 
		$ipbegin =$ipc[0]*1000000000+$ipc[1]*1000000+$ipc[2]*1000+$ipc[3]; 
		$ipend =$ipd[0]*1000000000+$ipd[1]*1000000+$ipd[2]*1000+$ipd[3]; 
		if($ips<=$ipend && $ips>=$ipbegin)
		{
			if($part==3)
			{
				$from=$from1.$from2;
				break;
			}
			elseif($part==2)
			{
				$from=$from2;
				break;
			}
			elseif($part==1)
			{
				$from=$from1;
				break;
			}
		} 
	} 
	if ($from=="") 
		$from="未知区域"; 
	return trim($from); 
}
?>