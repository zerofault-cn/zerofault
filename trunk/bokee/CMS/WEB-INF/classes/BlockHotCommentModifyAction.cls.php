<?php
/**
* BlockHotCommentModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class BlockHotCommentModifyAction extends Action {
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
        $response['data']['id'] = $id;
		$subject_id = intval($request['subject_id']);
        $channel_name = $request['channel_name'];
        $db = "cms_" . $channel_name;
		$dao = DAO::CreateInstance();
        $dao->SetCurrentSchema($db);
        $sql = "select * from template_block where id=" . $id;
        $row = $dao->GetRow($sql);
        $selected_subject_id = $row['selected_subject_id'];

		$content = $row['content'];

		$html_radio_is_group = "<select name='radio_is_group' size=1>";
		if( strpos( $content,"GROUP BY" ) )
		{
			$html_radio_is_group .= "<option value=1 selected>组文显示(只显示每个组文中的一篇文章)</option>";
			$html_radio_is_group .= "<option value=0>非组文显示(显示所有组文文章)</option>";
		}
		else
		{
			$html_radio_is_group .= "<option value=1>组文显示(只显示每个组文中的一篇文章)</option>";
			$html_radio_is_group .= "<option value=0 selected>非组文显示(显示所有文文章)</option>";
		}
		$html_radio_is_group .= "</select>";

		if( !strpos( $content,"rss_entry_attach" ) )
			$html_source="<input name='radio_source' type='radio' value='cms' checked>本站(CMS)
			<input name='radio_source' type='radio' value='rss'>外部RSS源";
		else
			$html_source="<input name='radio_source' type='radio' value='cms'>本站(CMS)
			<input name='radio_source' type='radio' value='rss' checked>外部RSS源";

        $response['data']['options'] = $this->getSubjectList($dao, 0, "", $selected_subject_id);
        if($selected_subject_id==0)
        	$response['data']['options'] = "<option value=\"0\" selected>频道所有栏目</option>\n" . $response['data']['options'];
        else 
        	$response['data']['options'] = "<option value=\"0\">频道所有栏目</option>\n" . $response['data']['options'];
        $response['data']['subject_id'] = $subject_id;
        $response['data']['channel_name'] = $channel_name;
        $response['data']['name'] = $row['name'];
        $response['data']['limit'] = $row['num'];
        $response['data']['format'] = $row['format'];
        $response['data']['time'] = $row['time'];
		if( strlen( $row['start_id'] ) == 0 )
			$row['start_id'] = 0;
		$response['data']['start_id'] = $row['start_id'];
		$response['data']['radio_is_group'] = $html_radio_is_group;
		$response['data']['html_source'] = $html_source;

		$str_title_length = "<tr><td>标题长度  是否限制：";
		if( $row['title_length'] == 0 )
		{
			$str_title_length .= "是<input type='radio' name='is_limit_title_length' value='1' onclick='document.forms[0].title_length.disabled=false'>";
			$str_title_length .= "否<input type='radio' name='is_limit_title_length' value='0' onclick='document.forms[0].title_length.disabled=true' checked>";
			$str_title_length .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 长度：<input name='title_length' disabled='true' value='' size='5'>";
		}
		else
		{
			$str_title_length .= "是<input type='radio' name='is_limit_title_length' value='1' onclick='document.forms[0].title_length.disabled=false' checked>";
			$str_title_length .= "否<input type='radio' name='is_limit_title_length' value='0' onclick='document.forms[0].title_length.disabled=true'>";
			$str_title_length .= "长度：<input name='title_length' value=". $row['title_length'] . " size=5>";
			
		}
		$str_title_length .= "</td></tr>";
		$response['data']['str_title_length'] = $str_title_length;
        
	}
	
	function getSubjectList($dao, $parent_id = 0, $prefix="", $selected_subject_id)
	{
		$sql = "SELECT id,name FROM subject WHERE parent_id = ".$parent_id." ORDER BY id,parent_id DESC";
		$rows = $dao->GetPlan($sql);
		$rows_num = count($rows);
		for($i=0;$i<$rows_num;$i++)
		{
			if($rows[$i]['id'] == $selected_subject_id)
			{
				$subject .= "<option value=\"" . $rows[$i]['id'] .  "\" selected>" . $prefix . $rows[$i]['name'] . "</option>\n";
			}
			else 
			{
				$subject .= "<option value=\"" . $rows[$i]['id'] .  "\">" . $prefix . $rows[$i]['name'] . "</option>\n";
			}
			$subject .= $this->getSubjectList($dao, $rows[$i]['id'],$prefix . "--", $selected_subject_id);
		}
		return $subject;
	}
}
?>