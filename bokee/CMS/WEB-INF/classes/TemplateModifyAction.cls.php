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

class TemplateModifyAction extends Action {
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
		$channel_name = $request['channel_name'];
        $db = "cms_" . $channel_name;
        $response['channel_name'] = $channel_name;
        $id = intval($request['id']);
        
        $subject_id = empty($request['subject_id'])?0:$request['subject_id'];
        $special_id = empty($request['special_id'])?0:$request['special_id'];
        $special_subject_id = empty($request['special_subject_id'])?0:$request['special_subject_id'];
        
        $template = new TemplateA($db);
        $template->GetTemplateById($id);
        $template->_row['channel_name'] = $channel_name; 
      
        $dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $sql = "select * from template_slash where template_id=" . $id . " order by taxis,id asc";
        $rows = $dao->GetPlan($sql);
        $rows_num = count($rows);
        for($i=0;$i<$rows_num;$i++)
        {
        	$rows[$i]['channel_name'] = $channel_name;
        	$rows[$i]['subject_id'] = $subject_id;
        	if($rows[$i]['category']=="image")
        	{
        		$rows[$i]['edit'] = "<textarea name=content cols=80 rows=2 id=content>" . $rows[$i]['content'] . "</textarea><br><input type=file name=image id=image>";
        	}
        	else 
        	{
        		$rows[$i]['edit'] = "<textarea name=content cols=80 rows=5 id=content>" . $rows[$i]['content'] . "</textarea>";
        	}
        	if($rows[$i]['category'] == "block")
        	{
        		$sql1 = "select name from template_block where id=" . $rows[$i]['block_id'];
        		$row1 = $dao->GetRow($sql1);
        		if(strpos($row1['name'], "*@*@*") !== false)
				{
					$rows[$i]['category'] = "<a href=# onclick=window.open('main.php?do=block_hotcomment_modify&id=" . $rows[$i]['block_id'] . "&channel_name=$channel_name&subject_id=$subject_id','block_modify','width=1000,height=600')" . ">" . $rows[$i]['category'] . "</a>";
				}
				else if(strpos($row1['name'], "@*@*@") !== false)
				{
					$rows[$i]['category'] = "<a href=# onclick=window.open('main.php?do=block_photo_modify&id=" . $rows[$i]['block_id'] . "&channel_name=$channel_name&subject_id=$subject_id','block_modify','width=1000,height=600')" . ">" . $rows[$i]['category'] . "</a>";
				}
				else 
				{
					$rows[$i]['category'] = "<a href=# onclick=window.open('main.php?do=block_modify&id=" . $rows[$i]['block_id'] . "&channel_name=$channel_name&subject_id=$subject_id','block_modify','width=1000,height=600')" . ">" . $rows[$i]['category'] . "</a>";
				}
        	}
    	}
        $response['data']['slashes'] = $rows;
        
        $sql = "select * from template_block where subject_id=" . $subject_id;
        $rows_block = $dao->GetPlan($sql);
        $rows_block_num = count($rows_block);
        $options = "";
        for($i=0;$i<$rows_block_num;$i++)
        {
        	$options .= "<option value=" . $rows_block[$i]['id'] . ">" . $rows_block[$i]['name'] . "</option>\n";
        }
        $response['data']['options'] = $options;
        
       
        if($template->_row['is_default']=="Y")
        {
        	 $defaulttlist = array (
                            "0"  => array ( "id" => "Y",                                                                             "selected"=>"selected"                                                                        ),
                            "1"  => array ( "id" => "N" ),
                );
        }
        else
        {
        	 $defaulttlist = array (
                            "0"  => array ( "id" => "Y"),
                            "1"  => array ( "id" => "N" ,
                                            "selected"=>"selected"  
                                            ),
                );
        }
 
        $response['defaulttlist'] = $defaulttlist;   

		if($template->_row['is_more']=="Y")
        {
        	 $is_more = array (
                            "0"  => array ( "id" => "Y",                                                                             "selected"=>"selected"                                                                        ),
                            "1"  => array ( "id" => "N" ),
                );
        }
        else
        {
        	 $is_more = array (
                            "0"  => array ( "id" => "Y"),
                            "1"  => array ( "id" => "N" ,
                                            "selected"=>"selected"  
                                            ),
                );
        }
 
        $response['is_more'] = $is_more;   
        $response['template'] = $template->_row;
		$response['template']['content'] = htmlspecialchars( $template->_content );
	}
}
?>