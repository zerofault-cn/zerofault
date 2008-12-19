<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {popup_init} function plugin
 *
 * Type:     function<br>
 * Name:     popup_init<br>
 * Purpose:  initialize overlib
 * @link http://smarty.php.net/manual/en/language.function.popup.init.php {popup_init}
 *          (Smarty online manual)
 * @param array
 * @param Smarty
 * @return string
 *	Tommy edit
 */
function smarty_function_JS_init($params, &$smarty)
{
	$JSPlugin = '';						//Unique, Color, MyCascade, MyAddRow, MyPoputActivity
	$JSPluginOther = '';
	$JSInclude = '';
	$JSCustom = '';

	foreach ($params as $_key=>$_value)
	{
        switch ($_key)
		{
            case 'JSPlugin':
			case 'JSPluginOther':
			case 'JSInclude':
            case 'JSCustom':
                if(isset($_key) && $_value != '')
                {
                    $$_key = (array)$_value;
                }
                break;

            default:
                $smarty->trigger_error("[popup] unknown parameter $_key", E_USER_WARNING);
        }
    }

	
	$script = '';
	if(trim($JSInclude) != '' && count($JSInclude) > 0)
	{
		$JSInclude = array_unique ($JSInclude);

		for($i=0; $i<count($JSInclude); $i++)
		{
			$script .= "<script type='text/javascript' language='JavaScript' src='" . $JSInclude[$i] . "'></script>\n";
		}
	}else{
		//no custom include
	}


	if(trim($JSCustom) != '' && count($JSCustom) > 0)
	{
		for($i=0; $i<count($JSCustom); $i++)
		{
			$script .= "<script type='text/javascript' language='JavaScript'>\n" . $JSCustom[$i] . "</script>\n";
		}
	}else{
		//no custom include
	}

	if(trim($JSPlugin) != '' && count($JSPlugin) > 0)
	{
		$JSPlugin = array_unique ($JSPlugin);

		for($i=0; $i<count($JSPlugin); $i++)
		{
			if($JSPlugin[$i] == 'Unique')
			{
				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/uniquechange.js\"></script>\n";

			}elseif($JSPlugin[$i] == 'Color'){

				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/AnchorPosition.js\"></script>\n";
				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/PopupWindow.js\"></script>\n";
				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/ColorPicker.js\"></script>\n";

				$script .= "<script type=\"text/javascript\" language=\"JavaScript\">\n";
				$script .= "document.write('<div id=\"div_id\" style=\"position: absolute; background-color: white; visibility: hidden;\"><\/div>');\n";
				$script .= "var cp = new ColorPicker();\n";
				$script .= "</script>\n";

			}elseif($JSPlugin[$i] == 'MyCascade'){

				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/DynamicOptionList.js\"></script>";
			
			}elseif($JSPlugin[$i] == 'MyAjax'){

				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/ajax.js\"></script>\n";

			}elseif($JSPlugin[$i] == 'MyPoputActivity'){
				if(trim($JSPluginOther[MyPoputActivity][PopupWindowID]) != '')
				{
					$PoputWindowID = $JSPluginOther[MyPoputActivity][PopupWindowID];
				}else{
					$PoputWindowID = 'MyPoputActivityWindowID';
				}
				
				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/PopupWindow.js\"></script>\n";
				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/AnchorPosition.js\"></script>\n";
				
				$script .= "<script type=\"text/javascript\" language=\"JavaScript\">\n";
				$script .= "document.write('<div id=\"" . $PoputWindowID . "\"  style=\"VISIBILITY: hidden; POSITION: absolute; background-color:#FFFFFF; \"><\/div>');\n";
				$script .= "var MyPopup = new PopupWindow('" . $PoputWindowID . "');\n";
				$script .="</script>\n";

				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/PopupActivate.js\"></script>\n";
			}elseif($JSPlugin[$i] == 'check_action'){
				$script .= "<script type=\"text/javascript\" language=\"JavaScript\" src=\"Include/javascript/check.js\"></script>";
			}else{
			}
		}
	}else{
		//no include Plugin
	}
	

	
	return $script;
}

/* vim: set expandtab: */

?>
