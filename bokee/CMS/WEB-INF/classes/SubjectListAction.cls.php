<?php
/**
* SubjectListAction.cls.php
* @copyright bokee dot com
* @author zhangfang@bokee.com
* @version 0.1
*/
require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/Subject.cls.php');
require_once('mod/User.cls.php');

class SubjectListAction extends Action {
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
        
         //基本变量设置 
         //$GLOBALS["ID"] =1; //用来跟踪下拉菜单的ID号 
         //$layer=1; //用来跟踪当前菜单的级数 

         $channel_name = $request['channel_name'];
         $db = "cms_" . $channel_name;
         $response['channel_name'] = $channel_name;

		//根据信息生成{op}

		 $u = new User;
		 $r = array();
		 $r['channel_name'] = $channel_name;
		 $response['data']['op'] = "";

		 $r['do'] = 'subject_add';
		 if($u->ValidatePerm($r))
		 {
		 	$response['data']['op'] .= " <a href=main.php?do=subject_add&channel_name=$channel_name&parent_id=0&sort=1 target=_self>添加新栏目</a>";
		 }
		 $r['do'] = 'block_list';
		 if($u->ValidatePerm($r))
		 {
		 	$response['data']['op'] .= " <a href=main.php?do=block_list&channel_name=$channel_name&subject_id=0 target=_self>区块列表</a>";
		 }
		 $r['do'] = 'template_list';
		 if($u->ValidatePerm($r))
		 {
		 	$response['data']['op'] .= " <a href=main.php?do=template_list&channel_name=$channel_name&subject_id=0 target=_self>模板列表</a>";
		 }
		 $r['do'] = 'header_list';
		 if($u->ValidatePerm($r))
		 {
		 	$response['data']['op'] .= " <a href=main.php?do=header_list&channel_name=$channel_name&subject_id=0 target=_self>头条列表</a>";
		 }		
		 $r['do'] = 'header_add';		 
		 if($u->ValidatePerm($r))
		 {
		 	$response['data']['op'] .= " <a href=main.php?do=header_add&channel_name=$channel_name&subject_id=0 target=_self>添加头条</a>";
		 }	
		 $r['do'] = 'flash_add_new';		 
		 if($u->ValidatePerm($r))
		 {
		 	$response['data']['op'] .= " <a href=main.php?do=flash_add_new&channel_name=$channel_name&subject_id=0 target=_self>添加flash头条</a></p>";
		 }	
		 
		 $r['do'] = 'subject_delete';
		 if($u->ValidatePerm($r))
		 {
		 	$delop = true;
		 }
		 $r['do'] = 'subject_modify';
		 if($u->ValidatePerm($r))
		 {
		 	$modifyop = true;
		 }
		 $r['do'] = 'subject_add';
		 if($u->ValidatePerm($r))
		 {
		 	$addop = true;
		 }

		 //开始列表栏目
		 
		 $subject = new Subject($db);
	     $subject_arr = $subject->GetSubjectArray(0);
		 $subject_arr_num = count($subject_arr);
		
		 for($i=0;$i<$subject_arr_num;$i++)
		 {
		 	$subject_arr[$i]['operations'] = "";
		 	if($delop)
		 	{
		 		$subject_arr[$i]['operations'] .= " <a href='main.php?do=subject_delete&channel_name=$channel_name&id=" . $subject_arr[$i]['id'] . "&dirname=" . $subject_arr[$i]['dir_name'] . "' onClick=\"javascript:return window.confirm('确定删除？');\">删除</a> ";
		 	}
		 	if($modifyop)
		 	{
		 		$subject_arr[$i]['operations'] .= "  <a href='main.php?do=subject_modify&channel_name=$channel_name&id=" . $subject_arr[$i]['id'] . "'>修改</a> ";
		 	}
		 	if($addop)
		 	{
		 		$subject_arr[$i]['operations'] .= " <a href=main.php?do=subject_add&channel_name=$channel_name&id=" . $subject_arr[$i]['id'] . ">添加</a> ";
		 	}
		 }
		 $response['data']['subjects'] = $subject_arr;
			
//         $sql="select * from subject where parent_id=0 and sort=1"; //提取一级栏目
//         $arr = $dao->GetPlan($sql);
//         //print_r($arr);
//         $arr_num = count($arr);
//         $resonse_arr = array();
//         for($i=0;$i<$arr_num;$i++)
//         {  
//         	$temp_arr = array();
//         	
//         	$temp_arr['id']=$arr[$i]['id'];	//取一级栏目ID号
//         	$temp_arr['parent_id']=$arr[$i]['parent_id'];//取一级栏目PARENT_ID号
//         	$temp_arr['name']=$arr[$i]['name'];//取一级栏目名称
//         	$temp_arr['dir_name']=$arr[$i]['dir_name'];//取一级栏目路径
//
//       	         	
//         	$sql="select * from subject where parent_id=" . $temp_arr['id'] . " and sort=2";//提取二级栏目
//         	$child=$dao->GetPlan($sql);
//         	$child_num = count($child);
//         	$childs = array();
//         	for($j=0;$j<$child_num;$j++)
//         	{
//         		  $child_arr = array();
//         	      $child_arr['id']=$child[$j]['id'];//取三级栏目ID号
//         	      $child_arr['parent_id']=$child[$j]['parent_id'];//取三级栏目PARENT_ID号
//         	      $child_arr['name']=$child[$j]['name'];//取三级栏目名称
//         	      $child_arr['dir_name']=$child[$j]['dir_name'];//取三级栏目路径
//
//         	      $sql1="select * from subject where parent_id=" . $child_arr['id'] . " and sort=3";//提取三级栏目
//         	      $child1=$dao->GetPlan($sql1);
//         	      $child_num1 = count($child1);
//         	      $childs1 = array();
//         	      for($k=0;$k<$child_num1;$k++)
//         	     {
//         		      $child_arr1 = array();
//         	          $child_arr1['id']=$child1[$k]['id'];//取四级栏目ID号
//         	          $child_arr1['parent_id']=$child1[$k]['parent_id'];//取四级栏目PARENT_ID号
//         	          $child_arr1['name']=$child1[$k]['name'];//取四级栏目名称
//         	          $child_arr1['dir_name']=$child1[$k]['dir_name'];//取四级栏目路径
//         	      
//         	          $sql2="select * from subject where parent_id=" . $child_arr1['id'] . " and sort=4";//提取四级栏目
//         	          $child2=$dao->GetPlan($sql2);
//         	
//         	          $child_num2 = count($child2);
//         	          $childs2 = array();
//         	          for($m=0;$m<$child_num2;$m++)
//         	          {
//         		            $child_arr2 = array();
//         	                $child_arr2['id']=$child2[$m]['id'];//取二级栏目ID号
//         	                $child_arr2['parent_id']=$child2[$m]['parent_id'];//取二级栏目PARENT_ID号
//         	                $child_arr2['name']=$child2[$m]['name'];//取二级栏目名称
//         	                $child_arr2['dir_name']=$child2[$m]['dir_name'];//取二级栏目路径 
//         	                $childs2[]=$child_arr2;    
//              	 
//         	    }         	
//         	      $child_arr1['childs']=$childs2;
//         	      $childs1[] =$child_arr1;        	                      
//         	}
//         	 $child_arr['childs']=$childs1;
//         	 $childs[] = $child_arr;
//         	}  
//         	$temp_arr['childs'] = $childs;
//         	$resonse_arr[] = $temp_arr;
//         }
//        //print_r($resonse_arr);
//         //exit;
//         $response['menu'] = $resonse_arr;
         
    }
}   
?>
