<?php

	require_once "class.portlet_sites.php";

	/**
	* SmartTemplate Extension select_site
	* Add 'Select Site' Drop-Down-Portlet
	*
	* Usage Example:
	* Content:  No Assignment required
	* Template: {select_site:}
	* Result:   Drop-Down-Portlet with available sites
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_select_site ()
	{
    	$config   =  array(
    					'width'		=>	200,
    					"template"	=>	"portlet_table_layer.html",
    				 );
    	$portlet  =  new portlet_sites( $config );
    	return $portlet->create();
	}

?>