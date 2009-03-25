<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_head} function plugin
 *
 * Type:     function<br>
 * Name:     html_head<br>
 * Date:     Oct 11, 2006<br>
 * Purpose:  make an html head from an array of data<br>
 * Input:<br>
 *         - loop = array to loop through
 *           - title = <title> name </title>
 *           - metaEquivName = META HTTP-EQIIV Name
 *           - metaEquivContent = META HTTP-EQIIV Content
 *           - metaName = META Name
 *           - metaContent = META Content
 *           - cssLinkURL = Include CSS Link
 *           - cssStyle = CSS
 *           - scriptLinkURL = Include Javascript Link
 *           - scriptFunction = Javascript
 *
 *
 * Examples:
 * [PHP]
 * $loop[title] = 'UserTest';
 * $loop[meta_eqname] = array('Content-Type');
 * $loop[meta_eqcontent] = array('text/html; charset=UTF-8');
 * $loop[meta_name] = array('Generator');
 * $loop[meta_content] = array('NetObjects Fusion 8 for Windows');
 * $loop[css_link] = array('../../../style.css','../../../site.css');
 * $loop[css_style] = '
   <style type="text/css">.Dio_Page { font-size: 20px; text-transform: capitalize; color: rgb(255,0,0); font-weight: bold;}</style>';
 * $loop[script_link] = array();
 * $loop[script_function] = '';
 * 
 * [HTML]
 * <pre>
 * <html>
 * <!--{html_head loop=$loop}-->
 * <body>
 * </body>
 * </html>
 * </pre>
 * @author   Dio [dio@mdtech.com.tw]
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_html_head($params, &$smarty)
{
    $Head_Title = 'Title';

    $Meta_Charset = 'UTF-8';
    $Meta_Keywords = '';
    $Meta_Description = '';

    $Meta_Equiv[0][Name] = '';
    $Meta_Equiv[0][Value] = '';

    $Meta_Name[0][Name] = '';
    $Meta_Name[0][Value] = '';

    $CSS[0][Domain] = '';
    $CSS[0][Filepath] = '';
    $CSS[0][Filename] = '';

    $CSS_INS[0][Name] = '';
    $CSS_INS[0][Description] = '';

    $SCRIPT_Filename = array();

    $SCRIPT_INS = array();
    

    if (!isset($params['loop'])) {
        $smarty->trigger_error("html_head: missing 'loop' parameter");
        return;
    }


    foreach ($params[loop] as $_key=>$_value) {
        switch ($_key) {
            case 'Head_Title':
            case 'Meta_Charset':
            case 'Meta_Keywords':
            case 'Meta_Description':
                if(trim($_value) != '')
                {
                    $$_key = (string)$_value;
                }
                break;
                        
            case 'Meta_Equiv':
            case 'Meta_Name':
            case 'CSS':
            case 'CSS_INS':
            case 'SCRIPT_Filename':
            case 'SCRIPT_INS':
                $$_key = $_value;
                break;
        }
    }
    
    $output = "<head>\n";
    $output .= "<title>" . $Head_Title . "</title>\n";
    
    //Meta HTTP-EQUIV Charset
    $output .= '<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=' . $Meta_Charset . '">'."\n";

    //Other Meta HTTP-EQUIV
    $count = count($Meta_Equiv);
    for($i=0; $i<$count; $i++)
    {
        $output .= '<META HTTP-EQUIV="' . $Meta_Equiv[$i][Name] . '" CONTENT="' . $Meta_Equiv[$i][Value] . '">'."\n";
    }
    

    //Meta Meta Name Keywords / Description
    $output .= '<META NAME="Keywords" CONTENT="' . $Meta_Keywords . '">'."\n";
    $output .= '<META NAME="Description" CONTENT="' . $Meta_Description . '">'."\n";

    //Other Meta Name
    $count = count($Meta_Name);
    for($i=0; $i<$count; $i++)
    {
        $output .= '<META NAME="' . $Meta_Name[$i][Name] . '" CONTENT="' . $Meta_Name[$i][Value] . '">'."\n";
    }
    
    //CSS Link
    $count = count($CSS);
    for($i=0; $i<$count; $i++)
    {
        if(trim($CSS[$i][Filename]) != '')
        {
            $output .= '<link rel="stylesheet" type="text/css" href="';
            
            if(trim($CSS[$i][Domain]) != '')
            {
                $output .= 'http://';
            }

            $output .= $CSS[$i][Domain] . $CSS[$i][Filepath] . $CSS[$i][Filename] . '">'."\n";
        }
    }
    
    //CSS
    $count = count($CSS_INS);
    $strcss = '';
    for($i=0; $i<$count; $i++)
    {
        if(trim($CSS_INS[$i][Name]) != '')
        {
            $strcss .= "." . $CSS_INS[$i][Name] . "{" . $CSS_INS[$i][Description] . "}" . "\n";
        }else{
        }
    }

    if(trim($strcss) != '')
    {
        $output .= "<style type='text/css'>\n" . $strcss . "</style>\n";
    }

    //Javascript Link
    $count = count($SCRIPT_Filename);
    for($i=0; $i<$count; $i++)
    {
        if(trim($SCRIPT_Filename[$i]) != '')
        {
            $output .= '<script src="';
            
            $output .= 'js.inc.php?jsitem=' . $SCRIPT_Filename[$i] . '"></script>'."\n";
        }
    }
    
    //Javascript
    $count = count($SCRIPT_INS);
    $strscript = '';
    for($i=0; $i<$count; $i++)
    {
        if(trim($SCRIPT_INS[$i]) != '')
        {
            $strscript .= $SCRIPT_INS[$i] . "\n";
        }
    }

    if(trim($strscript) != '')
    {
        $output .= "<script language='javascript'>\n" . $strscript . "</script>\n";
    }

    $output .= "</head>\n";
    
    return $output;
}

/* vim: set expandtab: */

?>
