<?php
/**
* BlockModifyAction.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/Action.cls.php');
require_once('mod/TemplateA.cls.php');
require_once('sql/DAO.cls.php');

class BlockModifyAction extends Action {
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
        $response['data']['options'] = $this->getSubjectList($dao, 0, "", $selected_subject_id);
        if($selected_subject_id==0)
        {
        	$response['data']['options'] = "<option value=0 selected>频道所有栏目</option>" . $response['data']['options'];
        }
        else 
        {
        	$response['data']['options'] = "<option value=0>频道所有栏目</option>" . $response['data']['options'];
    	}
        $response['data']['subject_id'] = $subject_id;
        $response['data']['channel_name'] = $channel_name;
        $response['data']['name'] = $row['name'];
		$response['data']['start_id'] = $row['start_id'];
        $response['data']['limit'] = $row['num'];
        $response['data']['format'] = $row['format'];
		$html_radio_is_group = "<select name='radio_is_group' size=1>";
		if( strpos( $content,"GROUP BY" ) )
		{
			$html_radio_is_group .= "<option value=1 selected>组图显示(只显示每个组图中的一张图片)</option>";
			$html_radio_is_group .= "<option value=0>非组图显示(显示所有组图图片)</option>";
		}
		else
		{
			$html_radio_is_group .= "<option value=1>文章组显示(只显示每个文章组中的一篇文章)</option>";
			$html_radio_is_group .= "<option value=0 selected>非文章组显示(显示所有文章组的文章)</option>";
		}
		$html_radio_is_group .= "</select>";
		$response['data']['radio_is_group'] = $html_radio_is_group;
		$str_title_length = "<tr><td>标题长度</td><td>是否限制：";
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

        $mark = "";
        for($i=1;$i<=5;$i++)
        {
        	if($i==$row['mark'])
        	{
        		$mark .= "<option value=$i selected>$i</option>\n";
        	}
        	else 
        	{
        		$mark .= "<option value=$i>$i</option>\n";
        	}
        }
		$response['data']['mark'] = $mark;
        $source = "";
        if(strpos($row['source'], 'cms'))
        {
        	$source .= "<input name=source[] type='checkbox' value='cms' checked>CMS ";
        }
        else 
        {
        	$source .= "<input name=source[] type='checkbox' value='cms'>CMS ";
        }
        if(strpos($row['source'], 'rss'))
        {
        	$source .= "<input name=source[] type='checkbox' value='rss' checked>RSS ";
        }
        else 
        {
        	$source .= "<input name=source[] type='checkbox' value='rss'>RSS ";
        }
        if(strpos($row['source'], 'blog'))
        {
        	$source .= "<input name=source[] type='checkbox' value='blog' checked>博客 ";
        }
        else 
        {
        	$source .= "<input name=source[] type='checkbox' value='blog'>博客 ";
        }
        if(strpos($row['source'], 'column'))
        {
        	$source .= "<input name=source[] type='checkbox' value='column' checked>专栏 ";
        }
        else 
        {
        	$source .= "<input name=source[] type='checkbox' value='column'>专栏 ";
        }
        if(strpos($row['source'], 'blogmark'))
        {
        	$source .= "<input name=source[] type='checkbox' value='blogmark' checked>博采 ";
        }
        else 
        {
        	$source .= "<input name=source[] type='checkbox' value='blogmark'>博采 ";
        }
		if(strpos($row['source'], 'bbs'))
        {
        	$source .= "<input name=source[] type='checkbox' value='bbs' checked>论坛 ";
        }
        else 
        {
        	$source .= "<input name=source[] type='checkbox' value='bbs'>论坛 ";
        }
        $response['data']['source'] = $source;
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