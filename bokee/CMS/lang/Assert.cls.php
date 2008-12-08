<?php
/**
* Assert.cls.php
* @copyright bokee dot com
*/

if ( !defined('DEBUG') ) define('DEBUG', false);

/**
* Assert ： 断言
* @version 0.1
*/
class Assert {
    /**
    * 前置条件判断, 如果条件不成立，终止程序的执行，并输出相应的信息
    * @access public
    * @param boolean $condition
    * @param string $message
    */
    function pre($condition, $message){
        if ( DEBUG &&!$condition) {
        	exit('Assert pre : '.$message."\n");
        }
    }
    /**
    * 后置条件判断，如果条件不成立，终止程序的执行，并输出相应的信息
    * @access public
    * @param boolean $condition
    * @param string $message
    */
    function post($condition, $message){
        if ( DEBUG && !$condition) {
        	exit('Assert post : '.$message."\n");
        }
    }
    /**
    * 一般条件的判断，如果条件不成立，终止程序的执行，并输出相应的信息
    * @access public
    * @param boolean $condition
    * @param string $message
    */
    function condition($condition, $message){
        if ( DEBUG && !$condition) {
        	exit('Assert condition : '.$message."\n");
        }
    }
    /**
    * 断言失败
    * @access public
    * @param string $message
    */
    function fail($message){
        if ( DEBUG ) {
        	exit('Assert fail : '.$message."\n");
        }
    }
}

?>