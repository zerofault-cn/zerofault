<?php

	require_once "class.textbutton.php";
	require_once "smarttemplate_extensions/textbutton_config.php";

	/**
	* SmartTemplate Extension textbutton
	* Creates labelled images
	* Requires class.textbutton.php (Can be downloaded at http;//www.smartphp.net/download/)
	*
	* Usage Example I:
	* Content:  $template->assign('TITLE', 'Tankstellen Peildaten');
	* Template: {textbutton:TITLE}
	* Result:   <IMG SRC="/images/buttons/button_e7a48a3414b689e7ab8000c51703d314.png" WIDTH="286" HEIGHT="36" TITLE="Tankstellen Peildaten" ALIGN="absmiddle" BORDER="0">
	*
	* Usage Example II:
	* Content:  $template->assign('TITLE', 'Tankstellen Peildaten');
	* Template: {textbutton:TITLE,'menu'}
	* Result:   <IMG SRC="/images/buttons/button_a26b811464e710f537bdb7aa7002b5dd.png" WIDTH="170" HEIGHT="22" TITLE="Tankstellen Peildaten" ALIGN="absmiddle" BORDER="0">
	*
	* @author Philipp v. Criegern philipp@criegern.com
	*/
	function smarttemplate_extension_textbutton ( $param, $type = 'default' )
	{
		global $smarttemplate_textbutton;

		//	Convert all HTML entities to their applicable characters
		if(is_int(strpos($param, '&')))
		{
			$param  =  strtr($param, array_flip(get_html_translation_table(HTML_ENTITIES)));
			$param  =  preg_replace("/&#([0-9]+);/me", "chr('\\1')", $param);
		}
		if (!$smarttemplate_textbutton[$type])
		{
			$smarttemplate_textbutton[$type]  =  new Textbutton(textbutton_config($type));
		}
		return $smarttemplate_textbutton[$type]->create_tag($param);
	}

?>