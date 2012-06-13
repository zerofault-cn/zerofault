<?php
/**
*
* 供命令行或crontab调用的操作
* 本类中的所有操作均不需RBAC认证（在config中设置）
* 调用格式：php script.php Script hello
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class ScriptAction extends Action{
    public function test(){
        echo APP_NAME .'->'. MODULE_NAME .'->' .ACTION_NAME ;
    }
	public function hello(){
		echo "Hello World!\r\n";
	}
}
?>