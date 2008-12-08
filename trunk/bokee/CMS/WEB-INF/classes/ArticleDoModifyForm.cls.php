<?php
/**
 * ArticleDoModifyForm.cls.php
 * aug 25th 2005
 * 
 */

require_once ('mvc/ActionForm.cls.php');
require_once ('mvc/ActionError.cls.php');

class ArticleDoModifyForm extends ActionForm {
	/** 
	 * 文章修改验证
	 */

	// 检验$form数据
	function validate ($req, $form) {
		$error = new ActionError();
		if( 0 == $form['radio_is_jump'] && $form['channel_name']!='group'){
			if ( !isset($form[id]) ) 
				$error->add('action_error_id',
					    '＊没有文章编号！');
	
			if (isset($form['title']) &&
			    strlen($form['title']) < 5) {
				$error->add('action_error_title', 
					    '＊标题不能少于5个字');
			}
			if (isset($form['keyword']) &&
			    strlen($form['keyword'])<2){
				$error->add('action_error_keyword',
	                                    '* 关键词不能少于2个字');
			}
			if (isset($form['description']) &&
			    strlen($form['description'])<10){
				$error->add('action_error_description',
	                                    '* 内容描述不能少于10个字');
			}
	
			if (isset($form['content']) &&
			    strlen($form['content'])<10){
				$error->add('action_error_content',
	                                    '* 内容不能少于10个字');
			}
		}
		elseif($form['channel_name']!='group'){
			if (strlen($form['title'])<5){
		            $error->add('action_error_title','* 标题不能少于5个字');
		        }
		}      		
		return $error;
		
	}
}
?>
