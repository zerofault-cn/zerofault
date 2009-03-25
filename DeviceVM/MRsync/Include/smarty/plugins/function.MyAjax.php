<?php
/*
#          File :   ""
#          Type :   ""
#          Name :   ""
#       Version :   "1.0"
#  Created Date :   "May 12, 2005"
# Modified Date :   "May 12, 2005"
#       Include :   ""
#   Global Vars :   ""
#      Template :   ""
#        Author :   "Dio <dio@xodtec.com>"
#        Others :   
#    
*/
function smarty_function_MyAjax($params,&$smarty)
{
	$FormMethod = 'GET';
	$URL = '';	
	$JSMethod = 'OnBlur';    
	$errMessage = "You don't keyin URL!!";
    
    foreach($params as $key=>$val)
    {
        switch($key)
        {
			case 'URL':
            case 'FormMethod':			
			case 'JSMethod':

				if(trim($val) != '')
				{
					$$key = (string)trim($val);
				}

                break;

            default:
                $smarty->trigger_error("[MyGraph] unknown parameter $key", E_USER_WARNING);
				exit;
        }
    }

	
	if($URL != '')
	{
		$val = $JSMethod . '="process(\'' . $FormMethod . '\', ' . $URL . ');"';

	}else{

		$val = '<font color="red"><b>' . $errMessage . '<b></font>';
	}


	return $val;
}
?>