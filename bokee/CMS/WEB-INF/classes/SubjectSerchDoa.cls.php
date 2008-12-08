<?php 
/**
* SubjectSerchDo.cls.php
* @copyright bokee dot com
* @author Tom@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');
require_once('mod/User.cls.php');

class SubjectSerchDoa extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
        // 事务处理
        // 将需要显示给用户的错误注入到 $response['action_erros'] �?
        // 给forward增加参数(在进行页面跳转时使用)
        // $actionMap->addForwardParam('key_test','value_test','name_test');
        // 返回的forward是一个数�?
        //return $actionMap->findForward('success');
        //return $actionMap->findForward('sysError'); 
        
         //基本变量设置 
         //$GLOBALS["ID"] =1; //用来跟踪下拉菜单的ID�?
         //$layer=1; //用来跟踪当前菜单的级�?

        $channel_name = $_REQUEST['channel_name'];
        $db = "cms_" . $channel_name;
		
		$contact = trim($_REQUEST['serch_contact']);
		$type = $_REQUEST['select'];
//echo $contact."<br/>".$type;
		if(1==$type){
			$type_select = "title";
		}
		elseif(2==$type){
			$type_select = "url";
		}

		$dao = DAO::CreateInstance();
		$dao->SetCurrentSchema($db);

		function GetNameBySubjectId($id){
			$sql_get = "select * from subject where id = '".$id."' ";
			//echo "<br>";
			$result_get = mysql_query($sql_get);
			$fetch_get = mysql_fetch_array($result_get);
			//return $fetch_get['name'];			

			if(0 == $fetch_get['parent_id']){
				return $fetch_get['name'];
			}
			
			else{
				$path = GetNameBySubjectId($fetch_get['parent_id']);
				return $path."->".$fetch_get['name'];
			}

		}		
		
		$sql = "SELECT title,datetime,subject_id FROM `rel_article_subject` WHERE ".$type_select." = '$contact' "; 
//echo $sql;
		$result = mysql_query($sql);
		
		$num = mysql_num_rows($result);
		
		if($num==0){echo "没找到结�?br>";exit;}	
		
		while($fetch = mysql_fetch_array($result)){
			$test[] = $fetch;
		}
		
		for ($i=0;$i<count($test);$i++){
			$arr[$i]['title'] = $test[$i]['title'];
			$time_format = explode('.', chunk_split($test[$i]['datetime'], 2, '.'));
			$arr[$i]['datetime'] = $time_format[0]. $time_format[1] . '-' . $time_format[2] . '-' . $time_format[3]."  ".$time_format[4].":".$time_format[5];	
			$arr[$i]['path'] = GetNameBySubjectId($test[$i]['subject_id']);
	    }
	    $response['data']['subjects'] = $arr;
    }   	
}   
?>
