<?php
///////////////////////////////////////////////////
//事先 应包含的文件 ： ./inc/inc.php
require_once("./inc/inc.php");

//获取用户信息 返回$userinfo 数组
function getUserInfo($strEmail)
{
	global	$userauth_config_file;
	global 	$xml_database_comname;
	global 	$primary_domain;
	
	$userinfo = array();
	
	$user_conf_file = $userauth_config_file;

	if (!file_exists($user_conf_file)) 
		return false;
	
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("user") || ($xml->GetTagName() == "user"))
	{
		$xml->IntoElem();
			
		do 
		{
			if ($xml->GetTagName() == "item") 
			{
				$strUser = "";
				$strDomain = "";

				$xml->ResetChildPos();	
				do {
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					switch(strtolower($strTagName)){
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
				}while($xml->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;

				if (strtolower($strUser) == strtolower($strEmail)) {
					$xml->ResetChildPos();	
					do
					{
						$strTagName = trim($xml->GetChildTagName());
						$strTagValue = $xml->GetChildData();
						
						$userinfo[strtolower($strTagName)] = $strTagValue;
					}while($xml->FindChildElem(""));
					
					return $userinfo;
				}
			}
		}while($xml->FindElem(""));
	}
	
	return false;
}

// 根据$userinfo数组修改帐号 返回值是布尔量 TRUE:成功 False:失败
function modifyUserInfo($userinfo)
{
	global	$userauth_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;

	if (!file_exists($user_conf_file)) 
		return false;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("user") || ($xml->GetTagName() == "user")){
		$xml->IntoElem();
	
		do {
			if ($xml->GetTagName() == "item") 
			{
				$strUser = "";
				$strDomain = "";
				
				$xml->ResetChildPos();	
				do 
				{
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					switch(strtolower($strTagName))
					{
						case 'name':
							$strUser = $strTagValue;
							break;
						case 'domain':
							$strDomain = $strTagValue;
							break;
					}
				}while($xml->FindChildElem(""));
					
				if (!empty($strDomain))
					$strUser = $strUser.'@'.$strDomain;

				if (strtolower($strUser) == strtolower($userinfo['user'])) 
				{
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("fullname"))
						$xml->SetChildData($userinfo["fullname"]);
					else
						$xml->AddChildElem("fullname", $userinfo["fullname"]);
					
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("description"))
						$xml->SetChildData($userinfo["description"]);
					else
						$xml->AddChildElem("description", $userinfo["description"]);
					
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("publicinfo"))
						$xml->SetChildData($userinfo["publicinfo"]);
					else
						$xml->AddChildElem("publicinfo", $userinfo["publicinfo"]);
					
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("homeaddress"))
						$xml->SetChildData($userinfo["homeaddress"]);
					else
						$xml->AddChildElem("homeaddress", $userinfo["homeaddress"]);
					
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("homephone"))
						$xml->SetChildData($userinfo["homephone"]);
					else
						$xml->AddChildElem("homephone", $userinfo["homephone"]);
					
					$xml->ResetChildPos();	
					if ($xml->FindChildElem("mobile"))
						$xml->SetChildData($userinfo["mobile"]);
					else
						$xml->AddChildElem("mobile", $userinfo["mobile"]);
					
					$xml->ResetChildPos();
					if ($xml->FindChildElem("organizationunit"))
						$xml->SetChildData($userinfo["organizationunit"]);
					else
						$xml->AddChildElem("organizationunit", $userinfo["organizationunit"]);
					
					$xml->ResetChildPos();
					if ($xml->FindChildElem("jobtitle"))
						$xml->SetChildData($userinfo["jobtitle"]);
					else
						$xml->AddChildElem("jobtitle", $userinfo["jobtitle"]);
					
					$xml->ResetChildPos();
					if ($xml->FindChildElem("office"))
						$xml->SetChildData($userinfo["office"]);
					else
						$xml->AddChildElem("office", $userinfo["office"]);
					
					$xml->ResetChildPos();
					if ($xml->FindChildElem("officephone"))
						$xml->SetChildData($userinfo["officephone"]);
					else
						$xml->AddChildElem("officephone", $userinfo["officephone"]);
				
					return $xml->WriteDB($user_conf_file);
				}
			}
		}while($xml->FindElem(""));
	}
	
	return false;
}

function getPrimaryDomain()
{
	global $domain_config_file;
	global $xml_database_comname;
	
	$filename = $domain_config_file;

	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($filename);
	$xml->ResetPos();
	
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("domain") || ($xml->GetTagName() == "domain")){
		$xml->IntoElem();
	
		do {
			if ($xml->GetTagName() == "item") {
				 
				$strDomain = "";
				$iDomainType = 0;
				 
				$xml->ResetChildPos();	
				do {
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
					
					switch(strtolower($strTagName)){
						case "domain":
							$strDomain = strtolower($strTagValue);
							break;
						case "type":
							if ($strTagValue == 1)
								$iDomainType = 1;
							else
								$iDomainType = 0;
							break;
					}
					
					if ($iDomainType == 1)
						return $strDomain;
						
				}while($xml->FindChildElem(""));
			}
		}while($xml->FindElem(""));
	}
	
	return "";
}

function isInArray($arrList, $strValue)
{
	$iSize = count($arrList);
	
	for ($i = 0; $i < $iSize; $i++){
		if (strtolower($strValue) == strtolower($arrList[$i]))
			return true;
	}
	
	return false;
}

function convertList($arrList, $strDomain)
{
	$arrResult = array();
	$iSize = count($arrList);
	
	for ($i = 0; $i < $iSize; $i++){
		$pos = strpos($arrList[$i], "@");
		
		if ($pos === false)
			$arrResult[$i] = $arrList[$i]."@".$strDomain;
		else
			$arrResult[$i] = $arrList[$i];
	}
	
	return $arrResult;
}

////////////////////////////////////////////////
// 取得用户有权限发信的组列表 以数组形式返回
////////////////////////////////////////////////
function getGroupList($uidmail)
{
	global	$userauth_config_file;
	global 	$xml_database_comname;
	
	$primary_domain = getPrimaryDomain();
	
	$uidmail = strtolower(trim($uidmail));
	$glist = array();
	
	$user_conf_file = $userauth_config_file;

	if (!file_exists($user_conf_file)) 
		return false;
	
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("group") || ($xml->GetTagName() == "group"))
	{
		$xml->IntoElem();
		
		$i = 0;
		do 
		{
			if ($xml->GetTagName() == "item") 
			{
				//初始化变量
				$name = "";
				$domain = "";
				$description = "";
				$memberlist = "";
				$mailright = "";
				$sendmailmemberlist = "";
				$gid = "";
				
				$xml->ResetChildPos();	
				do	{
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
						
					switch(strtolower($strTagName))	{
						case 'name':
							$name = strtolower($strTagValue);
							break;
						case 'domain':
							$domain = $strTagValue;						
							break;
						case 'description':		
							$description = $strTagValue;					
							break;
						case 'memberlist':		
							$memberlist = strtolower($strTagValue);					
							break;
						case 'sendmailright':
							$mailright = $strTagValue;
							break;
						case 'sendmailmember':
							$sendmailmemberlist = strtolower($strTagValue);
							break;				
					}
				}while($xml->FindChildElem(""));

				/////////////////////////////////
				// 数据转换 非主域的添加上域名
				/////////////////////////////////
				if($domain == "")
					$gid = $name."@".$primary_domain;
				else
					$gid = $name."@".$domain;
				
				if($mailright == 0)	{
					$glist[$i]["gid"] = $gid;
					$glist[$i]["description"]= $description;
					
					$i++;
				}
				else if($mailright == 1){
					$arrList = explode(";", $memberlist);
					
					if(isInArray($arrList, $uidmail))
					{
						$glist[$i]["gid"] = $gid;
						$glist[$i]["description"]= $description;
						
						$i++;
					}
				}
				else if($mailright == 2){
					$arrList = explode(";", $sendmailmemberlist);
					
					if(isInArray($arrList, $uidmail))
					{
						$glist[$i]["gid"] = $gid;
						$glist[$i]["description"]= $description;
						
						$i++;
					}
				}
			}		
			
		}while($xml->FindElem(""));
	}
		
	return $glist;
}

///////////////////////////////////////////////////
// 获取给定组的所有成员，给出的是一个 邮件地址数组
//////////////////////////////////////////////////

function getGroupMemberList($groupmail)
{
	global	$userauth_config_file;
	global 	$xml_database_comname;
	
	$primary_domain = getPrimaryDomain();

	$groupmail = strtolower(trim($groupmail));
	$mlist = array();
	
	$user_conf_file = $userauth_config_file;

	if (!file_exists($user_conf_file)) 
		return false;
	
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);
	$xml->ResetPos();
		
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("group") || ($xml->GetTagName() == "group"))
	{
		$xml->IntoElem();
		
		$i = 0;
		do 
		{
			if ($xml->GetTagName() == "item") 
			{
				//初始化变量
				$name = "";
				$domain = "";
				$memberlist = "";
				$gid = "";
				
				$xml->ResetChildPos();	
				do
				{
					$strTagName = $xml->GetChildTagName();
					$strTagValue = $xml->GetChildData();
						
					switch(strtolower($strTagName))
					{
						case 'name':
							$name = strtolower($strTagValue);
							break;
						case 'domain':
							$domain = $strTagValue;						
							break;
						case 'memberlist':		
							$memberlist = strtolower($strTagValue);					
							break;
					}
				}while($xml->FindChildElem(""));

				if($domain == "")
					$gid = $name."@".$primary_domain;
				else
					$gid = $name."@".$domain;
				
				if($groupmail == $gid)
				{
					$arrMemberList = explode(";", $memberlist);
					return convertList($arrMemberList, $primary_domain);
				}
			}
		}while($xml->FindElem(""));
	}

	return false;
}

?>