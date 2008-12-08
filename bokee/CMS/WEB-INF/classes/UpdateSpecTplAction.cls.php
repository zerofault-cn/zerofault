<?php
/**
* UpdateSpecTplAction.cls.php
* @copyright bokee dot com
* @author liangbiquan@bokee.com
* @version 0.1
*/
require_once('mvc/Action.cls.php');
require_once('sql/DAO.cls.php');
require_once('mod/TemplateA.cls.php');

class UpdateSpecTplAction extends Action {
	/**
    * 
    * @access public
    * @param array &$request
    * @param array &$files
    */
    function execute(&$actionMap,&$actionError,$request,&$response,$form){
		  
		//定义需要更新的频道名称及模版id
		$arr = Array( Array(1 => "sports", 2 => 283),
		  Array(1 => "lady", 2 => 94),
		  Array(1 => "cul", 2 => 58),
		  Array(1 => "ent", 2 => 110),
		  Array(1 => "sex", 2 => 109),
		  Array(1 => "life", 2 => 68),
		  Array(1 => "travel", 2 => 43),
		  Array(1 => "media", 2 => 51),
		  Array(1 => "game", 2 => 108),
		  Array(1 => "edu", 2 => 224),
		  Array(1 => "mobile",2 => 43),
		  Array(1 => "finance",2 => 193),
		  );

		for( $i=0;$i<count($arr);$i++ )
		{
			$db = "cms_" . $arr[$i][1];
			$tpl = new TemplateA( $db );
			$tpl->GetTemplateById( $arr[$i][2] );
			$tpl->Publish();
			echo "channel:" . $arr[$i][1] . " is ok <br>";

		}
	}
}
?>