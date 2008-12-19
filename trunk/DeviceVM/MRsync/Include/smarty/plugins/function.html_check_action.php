<?php
/*
#          File :   ""
#          Type :   ""
#          Name :   ""
#       Version :   "1.0"
#  Created Date :   "June 1, 2005"
# Modified Date :   "June 1, 2005"
#        Config :   ""
#       Include :   ""
#   Global Vars :   ""
#      Template :   ""
#        Author :   "Verdi <verdi@xodtec.com>"
#        Others :   
#    
*/

function smarty_function_html_check_action($params, &$smarty)
{
	require_once $smarty->_get_plugin_filepath('function','html_checkboxes');
	require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');

	$name = 'checkbox';
    $values = null;
    $selected = null;
    $separator = '';
    $labels = true;
    $output = null;

    $extra = '';

	$type = '';											//Action, Check , CheckAll , Choose
	$id = 'myCheck';
	$childname = 'chk[]';
	$momname = 'myCheck';
	$first = '';
	$end = '';
	$rang = 0;
	$checkall = '';

    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'name':
            case 'separator':
			case 'type':
			case 'id':
			case 'childname':
			case 'momname':
			case 'first':
			case 'end':
			case 'rang';
			case 'checkall':
                $$_key = $_val;
                break;

            case 'labels':
                $$_key = (bool)$_val;
                break;

            case 'options':
                $$_key = (array)$_val;
                break;

            case 'values':
            case 'output':
                $$_key = array_values((array)$_val);
                break;

            case 'checked':
            case 'selected':
                $selected = array_map('strval', array_values((array)$_val));
                break;

            case 'checkboxes':
                $smarty->trigger_error('html_checkboxes: the use of the "checkboxes" attribute is deprecated, use "options" instead', E_USER_WARNING);
                $options = (array)$_val;
                break;

            case 'assign':
                break;

            default:
                if(!is_array($_val)) {
                    $extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';
                } else {
                    $smarty->trigger_error("html_checkboxes: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }


	if($checkall != '')
	{
		$checkall .= '_0';
	}


	if($type == 'Choose')
	{
		$_html_result = '<input name="' . $name . '[]" id="' . $id . '_0" size="2" type="text"> TO
		<input name="' . $name . '[]" id="' . $id . '_1" size="2" type="text"><input onclick="moveNumbers(\'' . $momname . '[]\',\'' . $childname . '[]\', \'' . $id . '_0\', \'' . $id . '_1\', ' . $rang . ', \'' . $checkall . '\')" value="Send" type="button">';

		return $_html_result;
	}else{
		if (!isset($options) && !isset($values))
		{
			return ''; /* raise error here? */
		}

		settype($selected, 'array');
		$_html_result = array();

		

		if($type == 'Action')
		{
			$_extraOnClick = ' onclick="checkRecurrence(this.name, \'' . $childname . '[]\', this.checked, \'' . $first . '\', \'' . $end . '\');"';
		}elseif($type == 'Check'){
			$_extraOnClick = ' onclick="checkCenle(\'' . $momname . '_0\',this.name ,\'' . $first . '\',\'' . $end . '\', \'' . $checkall . '\');"';
		}elseif($type == 'CheckAll'){
			$_extraOnClick = ' onclick="checkAll(\'' . $momname . '[]\', \'' . $childname . '[]\', this.checked);"';
		}else{
			$_extraOnClick = '';
		}


		if (isset($options))
		{		
			$_i = 0;
			foreach ($options as $_key=>$_val)
			{
				$_id = 'id="' . $id . '_' . $_i++ . '"';
				$_childname = $childname . '[]';


				if($type == 'Action')
				{
					$_extra = $extra . $_id . " onclick=\"checkRecurrence(this.name, '" . $_childname . "', this.checked, '" . $first . "', '" . $end . "');\"";

				}elseif($type == 'Check'){
					$_extra = $extra . $_id . ' onclick="checkCenle(\'' . $momname . '_0\',this.name ,\'' . $first . '\',\'' . $end . '\', \'' . $checkall . '\');"';
				}elseif($type == 'CheckAll'){
					$_extra = $extra . $_id . ' onclick="checkAll(\'' . $momname . '[]\', \'' . $childname . '[]\', this.checked);"';
				}else{
					$_extra = $extra . $_id . '';
				}



				$_html_result[] = smarty_function_html_checkboxes_output($name, $_key, $_val, $selected, $_extra, $separator, $labels);

				if($first != '')
				{
					$first++;
				}
			}


		} else {
			foreach ($values as $_i=>$_key)
			{			
				$_id = 'id="' . $id . '_' . $_i . '"';
				$_childname = $childname . '[]';

				if($type == 'Action')
				{
					$_extra = $extra . $_id . " onclick=\"checkRecurrence(this.name, '" . $_childname . "', this.checked, '" . $first . "', '" . $end . "');\"";

				}elseif($type == 'Check'){
					$_extra = $extra . $_id . ' onclick="checkCenle(\'' . $momname . '_0\',this.name ,\'' . $first . '\',\'' . $end . '\', \'' . $checkall . '\');"';
				}elseif($type == 'CheckAll'){
					$_extra = $extra . $_id . ' onclick="checkAll(\'' . $momname . '[]\', \'' . $childname . '[]\', this.checked);"';
				}else{
					$_extra = $extra . $_id . '';
				}

				$_val = isset($output[$_i]) ? $output[$_i] : '';
				$_html_result[] = smarty_function_html_checkboxes_output($name, $_key, $_val, $selected, $_extra, $separator, $labels);

				if($first != '')
				{
					$first++;
				}
			}

		}


		if(!empty($params['assign']))
		{
			$smarty->assign($params['assign'], $_html_result);
		} else {
			return implode("\n",$_html_result);
		}
	}    
}
?>