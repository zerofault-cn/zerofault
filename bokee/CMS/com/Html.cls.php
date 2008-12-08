<?php
/**
* Html.cls.php
* @copyright bokee dot com
* @version 0.1
*/
class Html {
    
    /**
    * 页面跳转
    * @static
    * @access public
    * @param string $url
    */
    function jump($url){
        header("Location: $url");
    }
}
?>