<?php
/**
* TemplateDoModifyForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

class TemplateDoModifyForm extends ActionForm {
	/**
    * @abstract 添加验证
    */
    function validate( $req, $form ){
       $error = new ActionError();
       
        if (strlen($form['name'])<2){
            $error->add('action_error_template_name',' * 模板名不能小于2个字符');
        }
        if (strlen($form['file_name'])<5){
            $error->add('action_error_template_file_name',' * 文件名不能小于5个字符');
        }
        if (strlen($form['content'])<5){
            $error->add('action_error_template_content',' * 模板内容小于5个字符');
        }
        return $error;
	}
}
?>