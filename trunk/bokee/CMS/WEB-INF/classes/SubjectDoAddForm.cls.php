<?php
/**
* ArticleDoAddForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

class SubjectDoAddForm extends ActionForm {
	/**
    * @abstract 文目添加证验证
    */
    function validate( $req, $form ){
       $error = new ActionError();
       
        if (empty($form['name'])){
            $error->add('action_error_subject_name','* 栏目不能为空');
        }
        if (empty($form['dir_name'])){
            $error->add('action_error_subject_dir','*路径不能为空');
        }
        if (empty($form['channel_name'])){
            $error->add('action_error_subject_dir','*频道不能为空');
        }
        return $error;
	}
}
?>