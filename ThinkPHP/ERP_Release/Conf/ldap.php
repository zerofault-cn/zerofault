<?php
return array(
	'auth_method'	=> 'DB',
	'ldap_host'		=> 'localhost',
	'ldap_domain'	=> 'my-domain',
	'ldap_binddn'	=> 'cn=Manager,dc=my-domain,dc=com',
	'ldap_bindpwd'	=> 'secret',
	'ldap_rootdn'	=> 'dc=my-domain,dc=com',
	'ldap_searchattr' => 'cn',
	'ldap_fname'	=> 'givenname',
	'ldap_lname'	=> 'sn',
	'ldap_uname'	=> 'samaccountname',
	'ldap_email_add' => 'mail',
	'ldap_office'	=> 'physicaldeliveryofficename',
	'ldap_phone'	=> 'telephonenumber',
	'ldap_context'	=> 'dn'
	);
?>