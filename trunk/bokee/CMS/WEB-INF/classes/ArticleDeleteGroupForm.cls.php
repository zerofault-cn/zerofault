<?php
/**
* ArticleDoAddForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

class ArticleDeleteGroupForm extends ActionForm {
	/**
    *  @abstract   删除文章验证
    */
	function validate( $req, $form ){
		$error = new ActionError();
		
		if (count($_POST['article_id'])<1){
			$error->add('action_error_content','* 没有选中要删除的');
		}
		
		return $error;
	}
}
?>