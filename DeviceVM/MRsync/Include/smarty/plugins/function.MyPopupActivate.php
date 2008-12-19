<?php
function smarty_function_MyPopupActivate($params, &$smarty)
{
	//array('SpanID','AnchorID','HiddenName','URL','PopupWindowID','PopupWindowWidth','PopupWindowHeight');
	$MyData		= '';
	$MyForm		= 'myForm';
	$LinkName	= 'Choose';

    foreach ($params as $_key=>$_value)
	{
        switch ($_key) {
			case 'MyData':
				while ( list($key, $value) = each($params[$_key]) ) 
				{
					if(trim($value)!='')
					{
						$$key = (string)($value);
					}
				}
				break;
			
			case 'MyForm':
			case 'LinkName':
               if(isset($_key) && trim($_value) != '')
                {
                    $$_key = (string)$_value;
                }
                break;

            default:
                $smarty->trigger_error("[popup] unknown parameter $_key", E_USER_WARNING);
        }
    }

echo <<<end
<INPUT TYPE="hidden" NAME="$HiddenName" ID="$HiddenName" VALUE="$HiddenValue">
<div id="$SpanID" >$SpanValue</div>
<a id="$AnchorID" 
onclick="MyPopupActivate(document.$MyForm.$HiddenName,'$URL','$SpanID','$MyForm','$HiddenName','$PopupWindowID','$AnchorID','$PopupWindowWidth','$PopupWindowHeight'); return false;" href="#">$LinkName</a>
end;
}

?>