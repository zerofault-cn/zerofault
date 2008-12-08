<?php
/**
 * LoginForm.cls.phps
 * @copyright bokee dot com
 * @version  0.1
 */

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

/**
 * LoginForm
 * @author yudunde@bokee.com
 * @version 0.1
 */
class LoginForm extends ActionForm {
    
    /**
    * 登录表单信息检查
    */
    function validate( $req, $form ){
        
        $error = new ActionError();
        
        if (empty($form['username'])){
            $error->add('action_error_username','* 用户名不能为空');
        }
        elseif (strlen($form['username']) > 20){
            $error->add('action_error_username','* 用户名的长度不能超过20个字符');
        }
        if (empty($form['password'])){
            $error->add('action_error_password','* 密码不能为空');
        }
        return $error;
    }
}
?>