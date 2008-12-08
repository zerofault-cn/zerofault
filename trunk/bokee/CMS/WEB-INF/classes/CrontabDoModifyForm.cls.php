<?php
/**
* CrontabDoModifyForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

class CrontabDoModifyForm extends ActionForm {
	/**
    * @abstract 文目添加证验证
    */
    function validate( $req, $form ){
       $error = new ActionError();
       
        if (empty($form['content'])){
            $error->add('action_error_crontab_content','* 内容不能为空');
        }
        
        return $error;
	}
}
?>