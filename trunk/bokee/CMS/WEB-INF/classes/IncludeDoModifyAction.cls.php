<?php
/**
* IncludeDoModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');
require_once('com/FTP.cls.php');

class IncludeDoModifyAction extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] 中
        // 给forward增加参数(在进行页面跳转时使用)
        // $actionMap->addForwardParam('key_test','value_test','name_test');
        // 返回的forward是一个数组
        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError');   
      
        // 对先前的错误进行处理
        if ( !$actionError->isEmpty() ){
            // 是系统错误吗？
            if ($actionError->getProp('sysError') != false){
                return $actionMap->findForward('sysError');
            }
            $response['form']=$form;
            return $actionMap->findForward('failure');
        }        
		
	   $channel_name = $request['channel_name'];
       $response['channel_name'] = $channel_name;
       	
        $filename = $request['filename'];
        $file=PATH_HTML_ROOT."/cms_".$channel_name."/include/".$filename; 
        unlink($file);//删除文件
        $str1=$form['content'];
        $str=(!get_magic_quotes_gpc()) ? $str1 : stripslashes($str1) ;
        $filepoint=fopen($file,"a+"); //打开一个文件，若无则创建之，并记录其指针
        rewind($filepoint); //重置开档的读写位置指针。
       	fputs($filepoint,$str);
       	
       	
       	$filetxtname = $request['filename'].".txt";
        $filetext=PATH_HTML_ROOT."/cms_".$channel_name."/include/".$filetxtname; 
        @unlink($filetext);//删除文件
        $str2=$form['filedes'];
        $str3=(!get_magic_quotes_gpc()) ? $str2 : stripslashes($str2) ;

        $filepoint=fopen($filetext,"a+"); //打开一个文件，若无则创建之，并记录其指针
        rewind($filepoint); //重置开档的读写位置指针。
        fputs($filepoint,$str3);  
       	
        $file1="/html/cms_".$channel_name."/include/".$filename; 
        $ftp = new FTP($channel_name);
        if($ftp->Put($file, $file1)) 
			return "main.php?do=include_list&channel_name=$channel_name";
        else       
       	   return $actionMap->findForward('sysError');  
        		
      }  
}
?>