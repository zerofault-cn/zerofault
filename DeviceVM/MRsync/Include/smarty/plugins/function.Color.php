<?php
function smarty_function_Color($params, &$smarty)
{
	$LinkID = 'anchor1xx';					//a link  ID
	$LinkName = 'Pick';						//a link Show Name
	$MyForm = 'myForm';						//form name
	$InputName = 'Color';					//hidden name
	$selected = '';							//default
    $FontTag = False;
	$div_id = 'show_1';

    foreach ($params as $_key=>$_value) {
        switch ($_key) {
			case 'LinkID':
            case 'LinkName':
            case 'InputName':
            case 'MyForm':
            case 'div_id':
            case 'selected':
                if(isset($_key) && $_value != '')
                {
                    $$_key = (string)$_value;
                }
                break;
            case 'FontTag':
                if(isset($_key) && $_value != '')
                {
                    $$_key = (bool)$_value;
                }
                break;

            default:
                $smarty->trigger_error("[popup] unknown parameter $_key", E_USER_WARNING);
        }
    }


    if(!isset($MyForm) || $MyForm == '')
    {
        $smarty->trigger_error("popup_calendar: attribute 'form_name' can't not Null");
        return false;
    }

    if(!isset($selected) || $selected == '')
    {
        $selected = 'FFFFFF';
    }else{
	}

	

    if(!$FontTag)
    {
        $FontTag = '<span id="'.$InputName.'_F" style="position: absolute; visibility: hidden;"> </span>';
    }else{
        $FontTag = '<span id="'.$InputName.'_1" style="position: absolute; visibility: hidden;"> </span>';
    }



//checkvar($_SERVER);
echo <<<END

<input name="$InputName" size="20" value="$selected" type="hidden">
$FontTag
<a href="#" onclick="cp.select(document.$MyForm.$InputName,'$LinkID');return false;" name="$LinkID" id="$LinkID">$LinkName</a>
<span id="colorPickerDiv" style="position: absolute; visibility: hidden;"> </span>

END;

}
?>