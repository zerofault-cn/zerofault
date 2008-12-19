<?php
function smarty_function_MyTree($params, &$smarty)
{
	$MyID = 'tableTree';
	$MyTreeTitleArray = array('Name'=>'Tree','URL'=>'','Target'=>'');
	$MyTreeArray = '';
	$MyThemeProperty = 'ctThemeXP1';
	$MyThemePrefix = 'ThemeXP';
	$Branch = '1';
	$Expand = '0';


	foreach ($params as $_key=>$_value)
	{
        switch ($_key) {
			case 'MyTreeTitleArray':
			case 'MyTreeArray':
			if(isset($_key) && trim($_value) != '')
                {
                    $$_key = $_value;
                }
                break;

            case 'MyID':
            case 'MyThemeProperty':
            case 'MyThemePrefix':
               if(isset($_key) && trim($_value) != '')
                {
                    $$_key = (string)$_value;
                }
                break;

			case 'Branch':
			case 'Expand':
				if(isset($_key) && trim($_value) != '')
                {
                    $$_key = (int)$_value;
                }
                break;

            default:
                $smarty->trigger_error("[popup] unknown parameter $_key", E_USER_WARNING);
        }
    }

	if(trim($MyTreeTitleArray[Name]) == '')
	{
		$MyTreeTitleArray[Name] = 'None';
	}else{
		//not do anything
	}

	if(trim($MyTreeTitleArray[Target]) == '')
	{
		$strTarget = '';
	}else{
		$strTarget = ' target="' . $MyTreeTitleArray[Target] . '"';
	}

	if(trim($MyTreeTitleArray[URL]) != '')
	{
		$strTitle = '<a href="' . $MyTreeTitleArray[URL] . '"' . $strTarget . '>' . $MyTreeTitleArray[Name] . '</a>';
	}else{
		$strTitle = $MyTreeTitleArray[Name];
	}

echo <<<END

<table>
<tr><td>$strTitle</td></tr>
<tr><td id="$MyID"></td></tr>
</table>

<SCRIPT LANGUAGE="JavaScript" >
var MyTreeArray = [$MyTreeArray] ;
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript"><!--
ctDraw ("$MyID", MyTreeArray , $MyThemeProperty, "$MyThemePrefix", $Branch, $Expand);
--></SCRIPT>
END;

}

?>