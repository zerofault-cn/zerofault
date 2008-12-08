<?php
/**
* UserDoAddAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/User.cls.php');

class UserDoAddAction extends Action {
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
            $dao = DAO::CreateInstance();
            $sql = "select * from channel";
            $channel = $dao->GetPlan($sql);
		    for($i=0;$i<count($channel);$i++)
		    {
			     $j=$i+1;
			     if($j%5 ==0)
			     {
				     $channel[$i]['br'] = "<br>";
			     }
		    }            
            $response['channel'] = $channel;
            session_start();
		    $user = $_SESSION['user'];		
		    $response['user'] = $user;
		

		    $u = new User();
		    $u->GetByID($user['id']);		
		    if($user['role_id']==0)//系统管理员	        
			    $role = array (
		                  0 => array ( 
		                           'id' => '0',
			                       'name'   => '系统管理员', 
			                                               ),
                          1 => array ( 	
                                   'id' => '1',
			                       'name'   => '总编',
			                      	                       ),
			              2 => array (
			                      'id' => '2',
                                  'name'   => '主编',
                                                           ),
		                  3 => array ( 
		                          'id' => '3',
		                          'name'   => '编辑',
		                                                   ),
		                  4 => array ( 
		                          'id' => '4',
		                          'name'   => '广告',
		                                                   )		                                                   
		               );
		      elseif($user['role_id']==1)//总编
			    $role = array (
			              0 => array (
			                      'id' => '2',
                                  'name'   => '主编',
                                                           ),
		                  1 => array ( 
		                          'id' => '3',
		                          'name'   => '编辑',
		                                                   ),
		                  2 => array ( 
		                          'id' => '4',
		                          'name'   => '广告',
		                                                   )	
		               );		

             $response['role'] = $role;             
             $response['form'] = $form;
             return $actionMap->findForward('failure');
        }
			
        //添加用户处理
        
		$user = new User();
		$user->SetName($form['username']);
		$user->SetRealName($form['real_name']);
		$user->SetPassword(md5($form['password']));
		$user->SetCellphone($form['cellphone']);
		$user->SetCreateTime(date('Y-m-d H:i:s'));
		$user->SetRoleId($form['role_name']);
		$user->SetEmail($form['email']);
		
	    $select_channel = $request['select_channel'];
		if($user->Insert($select_channel) == -1)
		{
			return $actionMap->findForward('sysError');
		}
		else 
        	return $actionMap->findForward('success');
	}

}
?>