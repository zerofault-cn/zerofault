<?php
/**
 * BlockPhotoModifyAction.cls.php
 * @copyright bokee dot com
 * @author yudunde@bokee.com
 * @version 0.1
 */
require_once('mvc/Action.cls.php');
require_once('mod/Template.cls.php');
require_once('sql/DAO.cls.php');

class BlockPhotoModifyAction extends Action {
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
		$response['data']['id'] = $request['id'];
		$id = $request['id'];
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
			$html_radio_is_group .= "<option value=1 selected>组图显示(只显示每个组图中的一张图片)</option>";
			$html_radio_is_group .= "<option value=0>非组图显示(显示所有组图图片)</option>";
		}
		else
		{
			$html_radio_is_group .= "<option value=1>组图显示(只显示每个组图中的一张图片)</option>";
			$html_radio_is_group .= "<option value=0 selected>非组图显示(显示所有组图图片)</option>";
		}
		$html_radio_is_group .= "</select>";

		$response['data']['options'] = $this->getSubjectList($dao, 0, "", $selected_subject_id);
		if($selected_subject_id==0)
        	$response['data']['options'] = "<option value=\"0\" selected>根栏目</option>\n" . $response['data']['options'];
        else 
        	$response['data']['options'] = "<option value=\"0\">根栏目</option>\n" . $response['data']['options'];

		$response['data']['radio_is_group'] = $html_radio_is_group;
		$response['data']['channel_name'] = $channel_name;
		$response['data']['subject_id'] = $request['subject_id'];
        $response['data']['limit'] = $row['num'];
        $response['data']['format'] = $row['format'];
		$response['data']['start_id'] = $row['start_id'];
		$response['data']['title_length'] = $row['title_length'];

		$str_title_length = "<tr><td>标题长度:是否限制：";
		if( $row['title_length'] == 0 )
		{
			$str_title_length .= "是<input type='radio' name='is_limit_title_length' value='1' onclick='document.block_modify_form.title_length.disabled=false'>";
			$str_title_length .= "否<input type='radio' name='is_limit_title_length' value='0' onclick='document.block_modify_form.title_length.disabled=true' checked>";
			$str_title_length .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 长度：<input name='title_length' disabled='true' value='' size='5'>";
		}
		else
		{
			$str_title_length .= "是<input type='radio' name='is_limit_title_length' value='1' onclick='document.block_modify_form.title_length.disabled=false' checked>";
			$str_title_length .= "否<input type='radio' name='is_limit_title_length' value='0' onclick='document.block_modify_form.title_length.disabled=true'>";
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
