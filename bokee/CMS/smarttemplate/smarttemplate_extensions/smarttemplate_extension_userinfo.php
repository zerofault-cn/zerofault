<?php

	/**
	*
	* @author freeman@php.net
	*/
	function smarttemplate_extension_userinfo ()
	{
		global $dbh;
		
		$mobile = $_SESSION['phone_num'];	
		$pwd    = $_SESSION['session_auth'];
		if(!$mobile || !$pwd){
			$tpl = new SmartTemplate("login_form.html");
			return $tpl ->result();
		}
		$user = $dbh ->getRow("SELECT * FROM user WHERE phone_num='$mobile'");
		if(!$user){
			$tpl = new SmartTemplate("login_form.html");
			return $tpl ->result();
		}
		if($pwd == $user['passwd']){
			$tpl = new SmartTemplate("userinfo.html");
			$tpl ->assign($user);
			return $tpl ->result();
		}
	}

?>