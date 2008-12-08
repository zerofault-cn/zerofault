<?php
/**
* TemplateModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class TemplateModifyLookAction extends Action {
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
        $id = intval($request['id']);
		$db = "cms_".$request['channel_name'];
        $channel_name=$request['channel_name'] ;

        $subject_id = empty($request['subject_id'])?0:$request['subject_id'];
        $special_id = empty($request['special_id'])?0:$request['special_id'];
        $special_subject_id = empty($request['special_subject_id'])?0:$request['special_subject_id'];
		$result['subject_id']=$subject_id;
		$result['db']=$request['channel_name'];;
		$result['id']=$id;
		$result['template_id']=$request['template_id'];


		$dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $sql = "select * from template_slash where id=" . $id . " order by taxis,id asc";
        $rows = $dao->query($sql);
		$result = $dao->fa($rows);
        	if($result['category']=="image")
        	{
        		$result['edit'] = "<textarea name=content cols=80 rows=12 id=content>" . $result['content'] . "</textarea><br><input type=file name=image id=image>";
        	}
        	else 
        	{
        		$result['edit'] = "<textarea name=content cols=80 rows=15 id=content>" . $result['content'] . "</textarea>";
        	}
        	if($result['category'] == "block")
        	{
        		$sql1 = "select name from template_block where id=" . $result['block_id'];
        		$row1 = $dao->GetRow($sql1);
        		if(strpos($row1['name'], "*@*@*") !== false)
				{
					$result['category'] = "<a href=# onclick=window.open('main.php?do=block_hotcomment_modify&id=" . $result['block_id'] . "&channel_name=$channel_name&subject_id=$subject_id','block_modify','width=800,height=400')" . ">" . $result['category'] . "</a>";
				}
				else if(strpos($row1['name'], "@*@*@") !== false)
				{
					$result['category'] = "<a href=# onclick=window.open('main.php?do=block_photo_modify&id=" . $result['block_id'] . "&channel_name=$channel_name&subject_id=$subject_id','block_modify','width=800,height=400')" . ">" . $result['category'] . "</a>";
				}
				else 
				{
					$result['category'] = "<a href=# onclick=window.open('main.php?do=block_modify&id=" . $result['block_id'] . "&channel_name=$channel_name&subject_id=$subject_id','block_modify','width=800,height=400')" . ">" . $result['category'] . "</a>";
				}
        	}
		$result['channel_name']=$request['channel_name'];;
		$result['subject_id']=$subject_id;
       $response['slashes'] = $result;
	}
}
?>