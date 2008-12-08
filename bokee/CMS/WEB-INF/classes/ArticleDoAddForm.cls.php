<?php
/**
* ArticleDoAddForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');

class ArticleDoAddForm extends ActionForm {
	/**
    * @abstract 文章发表验证
    */
    function validate( $req, $form ){
       $error = new ActionError();
       if( 0 == $form['radio_is_jump'] ){
	        if (strlen($form['title'])<5){
	            $error->add('action_error_title','* 标题不能少于5个字');
	        }
	        if (strlen($form['keyword'])<2){
	            $error->add('action_error_keyword','* 关键词不能少于2个字');
	        }
	        if (strlen($form['description'])<10){
	            $error->add('action_error_description','* 内容描述不能少于10个字');
	        }
	        if (strlen($form['content'])<10){
	            $error->add('action_error_content','* 内容不能少于10个字');
	        }
	}
	elseif($form['channel_name']!='group')
	{
		if (strlen($form['title'])<5){
	            $error->add('action_error_title','* 标题不能少于5个字');
	        }
		 if ( strlen( $form['text_jump_url'] )<2 ){
	            $error->add('action_jump_url','* 跳转URL地址长度不能少于２个字');
	        }
	}      
        return $error;
	}
}
?>