<?PHP
/*
#          File :   "smarty_function_tab_table.php"
#          Type :   "tab_table function"
#          Name :   "lang"
#       Version :   "1.0"
#  Created Date :   "May 05, 2005"
# Modified Date :   "May 11, 2005"
#       Include :   function.html_table.php
#   Global Vars :   
#      Template :   
#        Author :   "Dio Hsu <dio@xodtec.com>"
#
#        Others :
*/
function smarty_function_html_tab($params, &$smarty)
{
	require_once $smarty->_get_plugin_filepath('function','html_table');
	
	/* Default values. */
	$table_attr = 'border="1" cellspacing="0" cellpadding="0"';             //table 設定
    $tr_attr = '';                                                          //各tr設定
    $td_attr = '';                                                          //各td設定
    $cols = null;                                                           //欄位數
    $rows = 1;                                                              //列位數
    $trailpad = '&nbsp;';                                                   
    $vdir = 'down';
    $hdir = 'right';
    $inner = 'cols';
    $ModName = 'Mod';
    $selected = '';                                                         //選擇的變數
    $color = 'yellow';                                                      //選擇至該項目的欄位顏色
    $var_name = 'selected';                                                 //變數名
    $path = '';                                                             //欲連結位址
    $target = '';                                                           //連結的target
    $imgpath = 'Template/default/images/';                          //圖片路徑           
    $image = array();                                                       //前置圖片檔名
    $bgimage = array();                                                     //底圖
    $bgcolor = array();                                                     //底的顏色
    $type = 'A';                                                            //顯示類別 A[橫式/純文字]
                                                                            //         B[橫式/底圖為圖片/上一欄為圖片]
                                                                            //         C[橫式/底圖為顏色]
                                                                            //         D[橫式/前有圖片]
                                                                            //         E[直式/純文字]
                                                                            //         F[直式/前有圖片,後為文字]
                                                                            //         G[直式/底圖為顏色]
                                                                            //         H[直式/底圖為圖片/上一欄為圖片]
																			//		   I[橫式/圖片切換]
	$space = '';   

   
    foreach ($params as $_key=>$_value) {
        switch ($_key) {
            case 'loop':
           
                $$_key = (array)$_value;
                break;
            
            case 'cols':
            case 'rows':
				
				if(trim($_value) != '')
				{
					$$_key = (int)$_value;
				}
                break;

            case 'table_attr':
            case 'trailpad':
            case 'hdir':
            case 'vdir':
            case 'inner':
            case 'td_attr':
            case 'selected':
            case 'var_name':
            case 'path':
            case 'target':
            case 'type':
            case 'ModName':
            case 'imgpath':
			case 'space':
			case 'color':
				
				if(trim($_value) != '')
				{
					$$_key = (string)$_value;
				}
                break;

            case 'tr_attr':
				
				if(trim($_value) != '')
				{
					$$_key = $_value;
				}
                break;
            
            default:
				
				$smarty->trigger_error("[html_tab] unknown parameter $_key", E_USER_WARNING);
		}
	}

	if (!isset($params['loop'])) {
        $smarty->trigger_error("html_tab: missing 'loop' parameter");
        return;
    }else{
        foreach($loop as $key=>$val){
            switch($key)
            {
                case 'input_id':
                case 'input_name':
                case 'alt':
                case 'url':
                case 'image':
				case 'image2':
                case 'bgimage':
                case 'bgcolor':
                    
                    $$key = (array)$val;
                    break;
                    
                default:
                
                    $smarty->trigger_error("[loop] unknow parameter $key[$i]", E_USER_WARNING);		
            }
        }
    }


    if(trim($selected) == '')
    {
        if(!isset($input_id) || !is_array($input_id))
        {
            $selected = $input_name[0];
        }else{
            $selected = $input_id[0];
        }
    }


    mb_parse_str($_SERVER[QUERY_STRING]); 
    
    if(trim($Mod) != '')
    {
        $Module = $ModName . '=' . $Mod;
    }else{
	}


    if($target != '')
    {
        $_target = "target='" . $target . "'";
    }else{
	}

    if($path != '')
    {
        list($str_url,$str_get) = explode('?',$path);


        if($str_get !='')
        {
			$patterns[0] = '/[&]*'.$ModName.'=[\w+]*/';
			$patterns[1] = '/[&]*'.$var_name.'=[\w+]*/';

			$replacements[0] = '';
			$replacements[1] = '';

			$path = preg_replace($patterns, $replacements, $str_get);
            //$path = preg_replace('/[&]*'.$ModName.'=[\w+]*/','',$str_get);
            
            if(substr($path,0,1) != '&')
            {
                $path = '&' . $path;
            }else{
			}
        }
    }else{
        $str_url = $_SERVER[PHP_SELF];
    }



    $strUrl = $str_url . '?' . $Module . $path;


    $data = array();

    switch($type)
    {
        case 'A':
        case 'E':

            for($i=0; $i<count($input_name); $i++)
            {
                if(!isset($input_id) || !is_array($input_id))
                {
                    $_value = $input_name[$i];
                }else{
                    $_value = $input_id[$i];
                }
                
                if($url[$i] != '')
                {
                    $data[] = '<a href="' . $url[$i] .'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }else{
                    $data[] = '<a href="' . $strUrl . '&' . $var_name . '='.$_value.'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }
				

                if($selected == $_value)
                {
                    $selbgcolor[] = 'bgcolor="' . $color . '" align="center"';
                }else{
                    $selbgcolor[] = $td_attr . ' align="center"';
                }

				if(trim($space) != '' && $i+1 < count($input_name))
				{
					$data[] = $space;
					$selbgcolor[] = $td_attr . ' align="center"';
				}else{
				}
            }


            if($type == 'A')
            {
                $rows = 1;
                $td_attr = $selbgcolor;
            }elseif($type == 'E'){
                $rows = count($input_name);
                $tr_attr = $selbgcolor;
            }            
            
            break;

        case 'B':            
            for($i=0; $i<count($input_name); $i++)
            {
                $data[] = '<img src="' . $imgpath . $image[$i] . '">';
            }

            for($i=0; $i<count($input_name); $i++)
            {
                if(!isset($input_id) || !is_array($input_id))
                {
                    $_value = $input_name[$i];
                }else{
                    $_value = $input_id[$i];
                }

                if($url[$i] != '')
                {
                    $data[] = '<a href="' . $url[$i] .'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }else{
                    $data[] = '<a href="' . $strUrl . '&' . $var_name . '='.$_value.'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }

                

                $arrTD[] = ' width="86" background="' . $imgpath . $bgimage[$i] . '" align="center"';
            }
            
            $rows = 2;
            $td_attr = $arrTD;

            
            break;
		case 'H':
            for($i=0; $i<count($input_name); $i++)
            {
				$data[] = '<img src="' . $imgpath . $image[$i] . '">';

                if(!isset($input_id) || !is_array($input_id))
                {
                    $_value = $input_name[$i];
                }else{
                    $_value = $input_id[$i];
                }

                if($url[$i] != '')
                {
                    $data[] = '<a href="' . $url[$i] .'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }else{
                    $data[] = '<a href="' . $strUrl . '&' . $var_name . '='.$_value.'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }

                

                $arrTD[] = ' width="86" background="' . $imgpath . $bgimage[$i] . '" align="center"';
            }


			 $rows = count($input_name) * 2;
			$tr_attr = $arrTD;

            
            break;

        case 'C':
		case 'G';
            
            for($i=0; $i<count($input_name); $i++)
            {
                if(!isset($input_id) || !is_array($input_id))
                {
                    $_value = $input_name[$i];
                }else{
                    $_value = $input_id[$i];
                }

                if($url[$i] != '')
                {
                    $data[] = '<a href="' . $url[$i] .'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }else{
                    $data[] = '<a href="' . $strUrl . '&' . $var_name . '='.$_value.'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }

                $arrTD[] = ' bgcolor="' . $bgcolor[$i] . '" align="center"';
            }
			
			if($type == 'C')
            {
                $rows = 1;
                $td_attr = $arrTD;
            }elseif($type == 'G'){
                $rows = count($input_name);
                $tr_attr = $arrTD;
            }  
            //$rows = 1;
            //$td_attr = $arrTD;

            
            break;
		
		case 'D':
        case 'F':
            
            for($i=0; $i<count($input_name); $i++)
            {
                if(!isset($input_id) || !is_array($input_id))
                {
                    $_value = $input_name[$i];
                }else{
                    $_value = $input_id[$i];
                }

				if($image[$i] != '')
				{
					$data[] = '<img src="' . $imgpath . $image[$i] . '" border="0">';
					$selbgcolor[] = $td_attr . ' align="center"';
				}else{
				}

                if($url[$i] != '')
                {
                    $data[] = '<a href="' . $url[$i] .'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }else{
                    $data[] = '<a href="' . $strUrl . '&' . $var_name . '='.$_value.'" title="' . $alt[$i] . '" ' . $_target . '>' . $input_name[$i] . '</a>';
                }


				if($selected == $_value)
                {
                    $selbgcolor[] = 'bgcolor="' . $color . '" align="center"';
                }else{
                    $selbgcolor[] = $td_attr . ' align="center"';
                }

            }


			if($type == 'D')
            {
                $rows = 1;
                $td_attr = $selbgcolor;
            }elseif($type == 'F'){
                $rows = count($input_name);
                $tr_attr = $selbgcolor;
            }  
            
			break;
		case 'I':


			for($i=0; $i<count($input_name); $i++)
            {
                if(!isset($input_id) || !is_array($input_id))
                {
                    $_value = $input_name[$i];
                }else{
                    $_value = $input_id[$i];
                }


				if($selected == $_value)
                {
                    $strImage = '<img src="' . $imgpath . $image2[$i] . '" border="0">';
                }else{
                    $strImage = '<img src="' . $imgpath . $image[$i] . '" border="0">';
                }
				
                
                if($url[$i] != '')
                {
                    $data[] = '<a href="' . $url[$i] .'" title="' . $alt[$i] . '" ' . $_target . '>' . $strImage . '</a>';
                }else{
                    $data[] = '<a href="' . $strUrl . '&' . $var_name . '='.$_value.'" title="' . $alt[$i] . '" ' . $_target . '>' . $strImage . '</a>';
                }

            }

            $rows = 1;        
            
            break;
    }


    
    $table_result = smarty_function_html_table(array('loop'     	=> $data,
													 'cols'			=> $cols,
													 'rows'			=> $rows,
													 'inner'		=> $inner,
													 'table_attr'	=> $table_attr,
													 'tr_attr'		=> $tr_attr,
													 'td_attr'		=> $td_attr,
													 'trailpad'		=> $trailpad,
													 'hdir'			=> $hdir,
													 'vdir'			=> $vdir),
													 $smarty);

	return $table_result;
}
?>    