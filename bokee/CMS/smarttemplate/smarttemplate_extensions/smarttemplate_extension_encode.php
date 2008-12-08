<?php

	/**
	* SmartTemplate Extension encode
	* Encodes String (ris_encode)
	*
	* Usage Example:
	* Content:  $template->assign('ID', 123);
	* Template: <a href="delete.php?id={encode:ID}">delete</a>
	* Result:   <a href="delete.php?id=7B600B6476167773626A">delete</a>
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/

	require_once "lib_crypt.php";

	function smarttemplate_extension_encode ( $param )
	{
		return ris_encode( $param );
	}

?>