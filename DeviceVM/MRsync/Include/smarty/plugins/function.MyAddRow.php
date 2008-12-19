<?php
function smarty_function_MyAddRow($params, &$smarty)
{
	$MyTemplate = 'myTemplate_1';
	$MyTable	= 'myTable';
	$InputName	= 'UploadFiles[]';
	$InputType	= 'file';
	$LinkName	= 'Add Row';
	$Type		= 'normal';												//normal , tpl

    foreach ($params as $_key=>$_value)
	{
        switch ($_key) {
			case 'MyTemplate':
            case 'MyTable':
            case 'InputName':
			case 'InputType':
            case 'LinkName':
			case 'Type':
               if(isset($_key) && $_value != '')
                {
                    $$_key = (string)$_value;
                }
                break;

            default:
                $smarty->trigger_error("[popup] unknown parameter $_key", E_USER_WARNING);
        }
    }


if($Type == 'normal')
{
echo <<<end
<script type="text/javascript" src="Include/javascript/function.js"></script>


<table border="0" id="$MyTable">
<tr><td><input type="$InputType" name="$InputName"></td><td><input type="button" name="Action" value="$LinkName" onclick="insertRow('$MyTable');"></td></tr>
</table>

end;

}else{

echo <<<end
<script type="text/javascript" src="Include/javascript/function.js"></script>

<input type="button" name="Action" value="$LinkName" onclick="addRow('$MyTemplate','$MyTable');">
end;
}
}

?>