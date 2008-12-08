<?php
/**
* CoopMediaiDoModifyForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

class CoopMediaDoModifyForm extends ActionForm {
	/**
    * @abstract 文目添加证验证
    */
    function validate( $req, $form ){
       $error = new ActionError();
       
        if (empty($form['name'])){
            $error->add('action_error_coopmedia_name','* 媒体名称不能为空');
        }
        if (empty($form['url'])){
            $error->add('action_error_coopmedia_url','*链接地址不能为空');
        }
        return $error;
	}
}
?>