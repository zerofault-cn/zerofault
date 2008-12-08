<?php
/**
* Action Error
* @copyright bokee dot com
* @version 0.1
*/
class ActionError {
    
    /**
    * 错误信息, 一个二维数组，array(array($key,$value))
    * @access   private
    */
    var $prop = array();
    
    /**
    * 取一个错误信息的值
    * @access   public
    * @param    string $key
    * @return   array|false
    */
    function getProp($key){
        return array_key_exists($key, $this->prop) ? 
               $this->prop[$key] : false;
    }
    /**
    * 增加一个元素
    * @access   public
    * @param    mixed $key
    * @param    string $value
    * @return   boolean
    */
    function add($key, $value=''){
        
        if (array_key_exists($key,$this->prop)) {
        	return false;
        } else {
            $this->prop[$key] = $value;
            return true;
        }
    }
    /**
    * 判断有没有错误信息
    * @access   public
    * @return   boolean
    */
    function isEmpty(){
        return count($this->prop) > 0 ? false : true;
    }
    /**
    * 重置
    * @access   public
    */
    function reset(){
        $this->prop = null;
    }
    /**
    * 取所有错误信息
    * @access public
    * @return array
    */
    function getAllProp(){
        return $this->prop;
    }
}
?>