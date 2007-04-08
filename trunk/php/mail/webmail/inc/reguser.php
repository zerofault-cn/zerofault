<?
function add_user($info, $need_affirm)
{
	$iRet = judge_user($info['email']);
	if ($iRet != 0)
		return $iRet;

	global	$userauth_config_file;
	global 	$xml_database_comname;
	global 	$register_user_total;


	$user_conf_file = $userauth_config_file;
	
	if (!file_exists($user_conf_file)) 
		return -1;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);

	$xml->ResetPos();
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("user") || ($xml->GetTagName() == "user")) {
		$usercount = 0;
		while($xml->FindChildElem("item"))
			$usercount++;
			
		if ($register_user_total != 0 && $usercount >= $register_user_total)
			return 4;

		$xml->AddChildElem("item", "");
		$xml->IntoElem();

		$xml->AddChildElem("name", $info['user']);
		$xml->AddChildElem("domain", $info['domain']);
		$xml->AddChildElem("password", $info['password']);
		if (empty($info['fullname']))
			$xml->AddChildElem("fullname", "");
		else
			$xml->AddChildElem("fullname", $info['fullname']);
		if (empty($info['description']))
			$xml->AddChildElem("description", "");
		else
			$xml->AddChildElem("description", $info['description']);

		if ($need_affirm)
			$xml->AddChildElem("accoutstatus", "2");
		else
			$xml->AddChildElem("accoutstatus", "0");
			
		$xml->AddChildElem("authtype", "0");
		$xml->AddChildElem("remotecontrol", "0");
		$xml->AddChildElem("sendcontrol", "0");
		$xml->AddChildElem("recvcontrol", "0");
		if (empty($info['mailquota']))
			$xml->AddChildElem("mailquota", "0");
		else
			$xml->AddChildElem("mailquota", $info['mailquota']);
		if (empty($info['mailquota']))
			$xml->AddChildElem("mailtotallimit", "0");
		else
			$xml->AddChildElem("mailtotallimit", $info['mailtotal']);
		$xml->AddChildElem("warninglimit", "0");
		$xml->AddChildElem("autoreplystatus", "0");
		$xml->AddChildElem("forwardaddr", "");
		$xml->AddChildElem("savecopy", "0");
		$xml->AddChildElem("lastvisittime", time());
		
		//ldap begin
		if (empty($info['publicinfo']))
			$xml->AddChildElem("publicinfo", "0");
		else
			$xml->AddChildElem("publicinfo", "1");
		if (empty($info['homeaddress']))
			$xml->AddChildElem("homeaddress", "");
		else
			$xml->AddChildElem("homeaddress", $info['homeaddress']);		
		if (empty($info['homephone']))
			$xml->AddChildElem("homephone", "");
		else
			$xml->AddChildElem("homephone", $info['homephone']);		
		if (empty($info['mobile']))
			$xml->AddChildElem("mobile", "");
		else
			$xml->AddChildElem("mobile", $info['mobile']);
		if (empty($info['organizationunit'] ))
			$xml->AddChildElem("organizationunit", "");
		else
			$xml->AddChildElem("organizationunit", $info['organizationunit']);
		if (empty($info['jobtitle'] ))
			$xml->AddChildElem("jobtitle", "");
		else
			$xml->AddChildElem("jobtitle", $info['jobtitle']);
		if (empty($info['office'] ))
			$xml->AddChildElem("office", "");
		else
			$xml->AddChildElem("office", $info['office']);
		if (empty($info['officephone'] ))
			$xml->AddChildElem("officephone", "");
		else
			$xml->AddChildElem("officephone", $info['officephone']);
		
		//ldap end
		if ($xml->WriteDB($user_conf_file))
			return 0;
		else
			return -1;
	}
	
	return -1;
}

function judge_user($strEmail, $judgeuser = true, $judgealias = true, $judgegroup = true)
{
	global	$userauth_config_file;
	global 	$xml_database_comname;

	$user_conf_file = $userauth_config_file;
	
	if (!file_exists($user_conf_file)) 
		return -1;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($user_conf_file);

	if ($judgeuser) {
		$xml->ResetPos();
		$bRet = $xml->FindElem("database");
		$xml->IntoElem();
	
		if ($xml->FindElem("user") || ($xml->GetTagName() == "user")){
			$xml->IntoElem();
		
			do {
				if ($xml->GetTagName() == "item") {
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
						return 1;
					}
				}
			}while($xml->FindElem(""));
		}
	}
	
	if ($judgealias) {
		$xml->ResetPos();
		$bRet = $xml->FindElem("database");
		$xml->IntoElem();
	
		if ($xml->FindElem("useralias") || ($xml->GetTagName() == "useralias")){
			$xml->IntoElem();
		
			do {
				if ($xml->GetTagName() == "item") {
					$strUser = "";
					$strDomain = "";
			
					$xml->ResetChildPos();	
					do {
						$strTagName = $xml->GetChildTagName();
						$strTagValue = $xml->GetChildData();
						
						switch(strtolower($strTagName)){
							case 'aliasname':
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
						return 2;
					}
				}
			}while($xml->FindElem(""));
		}
	}
	
	if ($judgegroup) {
		$xml->ResetPos();
			
		$bRet = $xml->FindElem("database");
		$xml->IntoElem();
	
		if ($xml->FindElem("group") || ($xml->GetTagName() == "group")){
			$xml->IntoElem();
		
			do {
				if ($xml->GetTagName() == "item") {
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
						return 3;
					}
				}
			}while($xml->FindElem(""));
		}
	}
	
	return 0;
}

function add_domain_usedstorage($info)
{
	global	$domain_config_file;
	global 	$xml_database_comname;

	$domain_conf_file = $domain_config_file;
	
	if (!file_exists($domain_conf_file)) 
		return -1;
		
	$xml = new COM($xml_database_comname) or die ("create com instance error");
	$xml->ReadDB($domain_conf_file);

	$xml->ResetPos();
	$bRet = $xml->FindElem("database");
	$xml->IntoElem();

	if ($xml->FindElem("domain") || ($xml->GetTagName() == "domain")) {
		$xml->IntoElem();
	
		do {
			if ($xml->GetTagName() == "item") {
				$xml->ResetChildPos();
				
				if ($xml->FindChildElem("domain"))
					$strTagValue = $xml->GetChildData();
				
				if (strtolower($strTagValue) == strtolower($info['domain'])){
					$xml->ResetChildPos();
					if ($xml->FindChildElem("usedmailboxstorage")){
						$strTagValue = $xml->GetChildData();
						$strTagValue += $info['mailquota'] / 1024;
						$xml->SetChildData($strTagValue);
					}
					else{
						$xml->AddChildElem("usedmailboxstorage", $info['mailquota'] / 1024);
					}
					
					$xml->ResetChildPos();
					if ($xml->FindChildElem("usedmailboxtotal")){
						$strTagValue = $xml->GetChildData();
						$strTagValue += 1;
						$xml->SetChildData($strTagValue);
					}
					else{
						$xml->AddChildElem("usedmailboxtotal", "1");
					}
					
					if ($xml->WriteDB($domain_conf_file))
						return 0;
					else
						return -1;
				}
			}
		}while($xml->FindElem(""));
	}
	
	return -1;
}

?>