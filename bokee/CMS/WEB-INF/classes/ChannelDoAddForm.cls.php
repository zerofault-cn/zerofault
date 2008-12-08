<?php
/**
* ChannelDoAddForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

class ChannelDoAddForm extends ActionForm {
	/**
    * @abstract 创建新频道表单验证
    */
    function validate( $req, $form ){
       $error = new ActionError();
       
        if (strlen($form['name'])<2){
            $error->add('action_error_name','* 名称不能少于2个字');
        }
        if (strlen($form['dir_name'])<2){
            $error->add('action_error_dir_name','* 目录名不能少于2个字');
        }
      
        return $error;
	}
}
?>