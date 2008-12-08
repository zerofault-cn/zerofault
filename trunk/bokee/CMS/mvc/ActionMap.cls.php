<?php
/**
* ActionConfig.cls.php
* @abstract 配置文件
* @copyright bokee dot com
* @version 0.1
*/
class ActionMap {
    
    var $prop = null;
    var $bean = null;
    
    /**
    * ActionCofig Constructor
    * @access public
    * @param array &$prop
    */
    function ActionMap(&$prop,&$bean){
        $this->prop = $prop;
        $this->bean = $bean;
    }
    
    /**
    * 取配置的一个属性, 失败返回null
    * @access public
    * @param string $key
    * @return mixed
    */
    function getProp($key){
        return array_key_exists($key,$this->prop) ? $this->prop[$key] 
                                                  : null;
    }    
    
    /**
    * 找一个转向
    * @access public
    * @param string $name forward name
    * @return array|null
    */
    function findForward($name){
        if (is_array($this->prop) 
            && array_key_exists($name,$this->prop['forwards'])) {
        	return $this->prop['forwards'][$name];
        } else {
            return null;
        }
    }
    /**
    * 增加 forward 参数
    * @access public
    * @param string $key
    * @param mixed $value
    * @param string $name
    */
    function addParam2Forward($key,$value,$name){
        $this->prop['forwards'][$name]['parameters'][$key] = $value;
    }
    /**
    * 取Bean
    * @access public
    */
    function getBean(){
        return $this->bean;
    }
}
?>