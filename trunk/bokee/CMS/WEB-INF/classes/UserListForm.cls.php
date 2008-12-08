<?php
/**
* UserListForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

class UserListForm extends ActionForm {
	/**
    * @abstract 文章发表验证
    */
    function validate( $req, $form ){
       	$error = new ActionError();
       	return $error;
	}
}
?>