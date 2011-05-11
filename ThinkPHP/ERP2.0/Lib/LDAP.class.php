<?php

class LDAP extends Think {
	static public function authenticate($id, $password)
	{
		//Get LDAP Config values
		$ldap			= C('_ldap_');
		$ldap_host		= $ldap["ldap_host"];
		$ldap_domain	= $ldap["ldap_domain"];
		$ldap_binddn	= $ldap["ldap_binddn"];
		$ldap_bindpwd	= $ldap["ldap_bindpwd"];
		$ldap_searchattr= $ldap["ldap_searchattr"];
		$ldap_fname		= $ldap["ldap_fname"];
		$ldap_lname		= $ldap["ldap_lname"];
		$ldap_uname		= $ldap["ldap_uname"];
		$ldap_email_add	= $ldap["ldap_email"];
		$ldap_context	= $ldap["ldap_context"];
		$ldap_rootdn	= $ldap["ldap_rootdn"];
		$default_level  = $ldap["default_level"];
		
		$connection = ldap_connect($ldap_host) or die('Could not connect to LDAP server.');
		ldap_set_option ($connection, LDAP_OPT_PROTOCOL_VERSION, 3); 
		ldap_set_option ($connection, LDAP_OPT_REFERRALS, 0); 
		
		//Connection made -- bind and get dn for username
		$ldapbind = ldap_bind($connection, $ldap_binddn, $ldap_bindpwd);
		
		//Check to make sure we are bound
		if (!$ldapbind) {
			ldap_close($connection);
			$LDAPInfo['passed'] = false;
			return $LDAPInfo;
		}
		
		$filter	= $ldap_searchattr.'='.$id;
		$sr		= ldap_search($connection, $ldap_rootdn, $filter);

		//Make sure only ONE result was returned
		if (ldap_count_entries($connection,$sr) != 1) {
			ldap_close($connection);
			$LDAPInfo['passed'] = false;
			return $LDAPInfo;
		}
		
		$info = ldap_get_entries($connection, $sr);

		//Now, try to rebind with their full dn and password
		if (($auth_method == 'AD') || ($auth_method == 'HYBRID_AD')) {
			$userbind = $id.'@'.$ldap_domain;
		}
		else {
			$userbind= $info[0][$ldap_context];
		}
		//Make sure a password was sent
		if (!isset($password) || $password != '') {
			$ldapbind = ldap_bind($connection, $userbind, $password);
			
			if (!$ldapbind) {
				ldap_close($connection);
				$LDAPInfo['passed'] = false;
				return $LDAPInfo;
			}
			
			$LDAPInfo['passed'] 	= true;
			$LDAPInfo['name'] 		= $info[0][$ldap_fname][0];
			$LDAPInfo['lname']		= $info[0][$ldap_lname][0];
			$LDAPInfo['uname']		= $info[0][$ldap_uname][0];
			$LDAPInfo['email']		= $info[0][$ldap_email_add][0];
			$LDAPInfo['password']	= md5($password);
			$LDAPInfo['office']		= $info[0][$ldap_office][0];
			$LDAPInfo['phone']		= $info[0][$ldap_phone][0];
			$LDAPInfo['default_level']= $default_level;
			return $LDAPInfo;
		}
		else
		{
			ldap_close($connection);
			$LDAPInfo["passed"] = false;
			return $LDAPInfo;
		}
	}
}
?>