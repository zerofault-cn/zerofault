<?php
/**
* String.cls.php
* @copyright bokee dot com
* @version 0.1
*/
class String {
    
    /**
    * 特殊字符替换函数
    *
    * @access public
    * @param string $C_char 待替换的字符串
    * @return string
    */
    function replaceChar($C_char) {
        $C_char=HTMLSpecialChars($C_char); //将特殊字元转成 HTML 格式。
        $C_char=nl2br($C_char); //将回车替换为<br>
        $C_char=str_replace(" ","&nbsp;",$C_char); //替换空格替换为&nbsp;
        $C_char=str_replace("<? ","< ?",$C_char); //替换PHP标记
        return $C_char;
    }
}
?>