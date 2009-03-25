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
function smarty_function_symbollist($params, &$smarty)
{
	$name = 'MENU';
	$type = 'DISC';

	if (!isset($params['loop'])) {
        $smarty->trigger_error("html_frame: missing 'loop' parameter");
        return;
    }

	foreach ($params as $_key=>$_value) {
        switch ($_key) {
            case 'loop':
                $$_key = (array)$_value;
                break;

            case 'name':
			case 'type':

				if($_value != '')
				{
					$$_key = (string)$_value;
				}

                break;
        }
    }

	$output = "<" . $name . " TYPE='" . $type . "'>\n";

	$loop_count = count($loop);
	for($i=0; $i<$loop_count; $i++)
	{
		if(trim($loop[$i]) != '')
		{
			$output .= "<LI>" . $loop[$i] . "\n";
		}
	}

	$output .= "</" . $name . ">\n";
	
    return $output;
}

?>
