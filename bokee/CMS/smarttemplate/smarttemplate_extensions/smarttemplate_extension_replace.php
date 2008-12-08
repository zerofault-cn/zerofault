<?php

	/**
	* SmartTemplate Extension replace
	* String Replace
	*
	* Usage Example:
	* Content:  $template->assign('PATH', $path_tranlated);  //  C:\Apache\htdocs\php\test.php
	* Template: Script Name: {replace:PATH,'\\','/'}
	* Result:   Script Name: C:/Apache/htdocs/php/test.php
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_replace ( $param, $pattern, $replace )
	{
		return str_replace( $pattern, $replace, $param );
	}

?>