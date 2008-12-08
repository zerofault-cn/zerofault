<?php
/**
* Cache.cls.php
* @copyright bokee dot com
* @version 0.1
*/
require_once('com/File.cls.php');
/**
*
* Cache
* @version 0.1
*/
class Cache {
    
    /**
    * 时间显示，缺省是30秒
    * @var integer
    */
    var $timeLimit;
    
    /**
    * 对缓存的要求: 为 1 时，需执行强制刷新 ， 为 0 时，不需要使用缓存
    * @var integer
    */
    var $demand;
    
    /**
    * 当前的REQUEST_URI
    */
    var $currentUri;
    
    /**
    * 缓存的内容
    */
    var $content;
    
    /**
    * 缓存的保存路径
    * @access public
    */
    var $path;
    /**
    * 缓存的水平
    * @var integer
    */
    var $level;
    
    /**
    * 缓存文件
    * @var string
    */
    var $filePath;
    
    /**
    * Construct
    * @access public
    * @param ActionMap &$actionMap
    * @param string $path
    */
    function Cache( &$actionMap, $path ){
        $this->timeLimit = $actionMap->getProp('cacheTimeLimit');
        $this->path = $path;
    }
    /**
    * 开始缓存网页内容
    * @access public
    */
    function start(){
        ob_start();
        $this->level = ob_get_level();
    }
    /**
    * 停止缓存内容，并根据demand的值来判断是否要输出缓存的内容    
    * @access public
    */
    function stop(){        
        if ( 1 == $this->demand ){
            $this->content = ob_get_flush();
        } elseif ( 2 == $this->demand ){
            $this->content = ob_get_clean();
        }
    }
    
    /**
    * 判断是否使用缓存
    * @access public
    */
    function isUse(){
        return ($this->timeLimit === null || $this->timeLimit < 0) ? false : true;
    }
    
    /**
    * 判断 cache 是否过期
    * @access public
    */
    function isExpire(){
        return (time() - filemtime($this->filePath) > $this->timeLimit) ? true : false;
    }
    /**
    * 输出缓存
    * @access public
    */
    function output(){
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Expires: " .gmdate ("D, d M Y H:i:s", time() + 900 ). " GMT");
        print $this->content;
    }
    /**
    * 设置要求的值
    * @access public
    * @param integer $value
    */
    function setDemand($value){
        $this->demand = $value;
    }
    /**
    * 判断缓存是否存在
    * @access public
    */
    function isExist(){
        return file_exists($this->filePath);
    }
    /**
    * 保存缓存
    * @access public
    */
    function save(){
        File::writeContent($this->content,$this->filePath,'w');
    }
    /**
    * 打开缓存
    * @access public
    */
    function open(){
        $this->content = file_get_contents($this->filePath);
    }
    /**
    * 设置当前的REQUEST_URI
    * @access public
    * @param string $uri
    */
    function setCurrentUri( $uri ){
        $this->currentUri = $uri;
        $subDir = $this->path.'/'.date("Ymd");
        if (!file_exists($subDir)){
            mkdir($subDir);
        }
        $this->filePath = $subDir.'/'.md5($this->currentUri);
        
    }
    /**
    * 取得当前的REQUEST_URI
    * @access public
    */
    function getCurrentUri(){
        return $this->currentUri;
    }
}
?>