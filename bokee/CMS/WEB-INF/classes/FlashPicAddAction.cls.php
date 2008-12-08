<?php
/**
* FlashPicAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');

class FlashPicAddAction extends Action {
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
        
		//设置flash最大显示图片数
        $MAX_PIC_NUM = 6;

		$channel_name = $request['channel_name'];
        
        $db = "cms_" . $channel_name;
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
     
		//读取文件内容,判断是否图片到达最大数量
		$path = PATH_HTML_ROOT . "/" . $db . "/" . $request['path'];
        $xml = file_get_contents($path);
        $count_pics = preg_match_all("/<pic>(.*?)<\/pic>/i", $xml, $pics);

		if( $count_pics >= $MAX_PIC_NUM )
			die(" 图片已经达到最大数量! ");

        $response['flash_path'] = $request['path'];
		$response['channel_name'] = $channel_name;
		$response['flash_id'] = $request['flash_id'];
    }
    
 
}
?>