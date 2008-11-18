<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty lower modifier plugin
 *
 * Type:     modifier<br>
 * Name:     lower<br>
 * Purpose:  convert string to lowercase
 * @link http://smarty.php.net/manual/en/language.modifier.lower.php
 *          lower (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_marquee($string='',$align='MIDDLE',$behavior='SCROLL',$bgcolor='#FFFFFF',$direction='LEFT',$loop='-1',$scrolldelay='50',$scrollamount='',$height='',$width='',$vspace='',$hspace='')
{
	$output = "<MARQUEE ALIGN='" . $align . "' BEHAVIOR='" . $behavior . "' BGCOLOR='" . $bgcolor . "' DIRECTION='" . $direction . "' SCROLLDELAY='" . $scrolldelay . "'";

	if(trim($scrollamount) != '')
	{
		$output .= " SCROLLAMOUNT='" . $scrollamount . "'";
	}

	if(trim($height) != '')
	{
		$output .= " HEIGHT='" . $height . "'";
	}

	if(trim($width) != '')
	{
		$output .= " WIDTH='" . $width . "'";
	}

	if(trim($vspace) != '')
	{
		$output .= " VSPACE='" . $vspace . "'";
	}

	if(trim($hspace) != '')
	{
		$output .= " HSPACE='" . $hspace . "'";
	}

	$output .= ">\n";
	$output .= $string . "\n";
	$output .= "</MARQUEE>\n";

    return $output;
}

?>
