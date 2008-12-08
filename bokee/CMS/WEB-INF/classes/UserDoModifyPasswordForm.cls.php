<?php
/**
* UserDoModifyPasswordForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');
require_once('mod/User.cls.php');

class UserDoModifyPasswordForm extends ActionForm {
	/**
    * @abstract 创建新用户表单验证
    */
    function validate( $req, $form ){
       $error = new ActionError();
       
       session_start();
       $id = intval($_SESSION['user']['id']);
       $user = new User();
       $user->GetByID($id);
       
       if ($user->GetPassword() != md5($form['password'])) {
			$error->add('action_error_password','* 密码与原密码不匹配');
       }
       if(strlen($form['password_new'])<6)
       {
       		 $error->add('action_error_password_new','* 密码不能少于6个字');
       }
       if($form['password_new'] != $form['password_new_re'])
       {
       		 $error->add('action_error_password_new_re','* 两次输入密码不一致');
       }
        return $error;
	}
}
?>