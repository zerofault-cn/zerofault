<?php
/**
* ArticleDeleteForm.cls.php
* @copyright bokee dot com
* @author yudunde@bokee.com
* @version 0.1
*/

require_once('mvc/ActionForm.cls.php');
require_once('mvc/ActionError.cls.php');
require_once('mod/Article.cls.php');

class ArticleDeleteForm extends ActionForm {
	/**
    * @abstract 文章删除验证
    */
    function validate( $req, $form ){
       $error = new ActionError();
      
	// 改变文章状态为隐藏

	// $sql = 'UPDATE article SET status="hide" WHERE id=""';

	// 执行 $sql

	// 如果出错添加入错误信息
 
        if (strlen($form['content'])<10){
            $error->add('action_error_content','* 内容不能少于10个字');
        }
      
        return $error;
	}
}
?>
