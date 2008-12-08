<?php
/**
* IncludeDeleteAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/CoopMedia.cls.php');
require_once('mod/User.cls.php');
require_once('com/FTP.cls.php');


class IncludeDeleteAction extends Action {
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

		if(!User::Authorize())
		{
			return $actionMap->findForward('login');
		}
		$request['p'] = empty($request['p'])?1:$request['p'];
		
	   $channel_name = $request['channel_name'];
       
        $include=$_REQUEST['include'];
        $num=sizeof($include);
		if (!empty($form['include'])){
			for ($i=0;$i<$num;$i++){
				$filename = $include[$i];
				$file=PATH_HTML_ROOT."/cms_".$channel_name."/include/".$filename; 
				$filetxt=PATH_HTML_ROOT."/cms_".$channel_name."/include/".$filename.".txt";				    unlink($file);//删除文件
			    @unlink($filetxt);//删除文件				
			}
			return "main.php?do=include_list&channel_name=$channel_name";
		}else {
			 //删除单个合作媒体
			$filename = ($request['filename']);
	        $file=PATH_HTML_ROOT."/cms_".$channel_name."/include/".$filename; 
	        $filetxt=PATH_HTML_ROOT."/cms_".$channel_name."/include/".$filename.".txt";		
			@unlink($filetxt);//删除文件	
            unlink($file);//删除文件		
		   return "main.php?do=include_list&channel_name=$channel_name";
		}
	}	       
}
?>