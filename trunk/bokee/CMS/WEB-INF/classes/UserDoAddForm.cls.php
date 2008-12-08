<?php
/**
* UserDoAddForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

class UserDoAddForm extends ActionForm {
	/**
    * @abstract 创建新用户表单验证
    */
    function validate( $req, $form ){
       $error = new ActionError();
       
        if (strlen($form['username'])<4)
  		{
            $error->add('action_error_username','* 用户名不能少于4个字');
        }
        if (strlen($form['password'])<4)
        {
            $error->add('action_error_password','* 密码不能少于4个字');
        }
        if ($form['password'] != $form['password_re'])
        {
        	$error->add('action_error_password_diff','* 两次输入密码不一致');
        }
        if (strlen($form['real_name'])<2)
        {
            $error->add('action_error_real_name','* 真实姓名不能少于2个字');
        }
        if (strlen($form['email'])<6)
        {
            $error->add('action_error_email','* email不能少于6个字');
        }
        if (strlen($form['cellphone'])<8)
        {
            $error->add('action_error_cellphone','* 手机不能少于8位');
        }
      
        return $error;
	}
}
?>