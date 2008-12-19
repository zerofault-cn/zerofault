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
function smarty_function_MyGraph($params,&$smarty)
{
	$PATH_ROOT = $_SERVER[DOCUMENT_ROOT];
	$jpgraph_path = $_SERVER[DOCUMENT_ROOT] . '/Include/jpgraph/';

	$MyData = '';
	$Type = 'pie';	
	$FilePATH = 'Files/jpgraph/';
	$FileName = 'tmp.jpg';
	$message = 'Graph is not create!';
    
    
    foreach($params as $key=>$val)
    {
        switch($key)
        {
            case 'MyData':

				if($val != '' && count($val) > 0)
				{
					$$key = (array)$val;
				}else{
					$smarty->trigger_error("[MyGraph] $key must have Data", E_USER_WARNING);
					exit;
				}

                break;

            case 'Type':
			case 'FilePATH':
			case 'FileName':
			case 'message':

				if($val != '')
				{
					$$key = (string)$val;
				}else{
				}

                break;

            default:
                $smarty->trigger_error("[MyGraph] unknown parameter $key", E_USER_WARNING);
				exit;
        }
    }


	require_once $smarty->_get_plugin_filepath('shared','graph');
	require_once ($jpgraph_path . 'jpgraph.php');
	
	
	


	if(!is_dir($FilePATH))
	{
		mkdir($FilePATH, 0777);
	}else{
		//dir is exist
	}

	$imgPATH = $FilePATH . $FileName;

	
	if($Type == 'pie')
	{
		require_once ($jpgraph_path . 'jpgraph_pie.php');

		GraphPie($MyData, $imgPATH);

	}elseif($Type == 'bar'){

		require_once ($jpgraph_path . 'jpgraph_bar.php');

		GraphBar($MyData, $imgPATH);

	}elseif($Type == 'line'){
		
		require_once ($jpgraph_path . 'jpgraph_line.php');

		GraphLine($MyData, $imgPATH);

	}else{
		//not do any thing
	}


	if(file_exists($imgPATH))
	{
		$img = '<img src="' . $FilePATH . $FileName . '">';

		return $img;
	}else{
		return $message;
	}
}
?>