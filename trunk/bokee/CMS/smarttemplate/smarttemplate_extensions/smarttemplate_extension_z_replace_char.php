<?php
/**
* 
* @author zczhong
* @date Tue Mar 08 16:33:12 CST 2005
*/
    function smarttemplate_extension_z_replace_char($C_char) {
        //$C_char=HTMLSpecialChars($C_char); //将特殊字元转成 HTML 格式。
        $C_char=nl2br($C_char); //将回车替换为<br>
        $C_char=str_replace("<? ","< ?",$C_char); //替换PHP标记
        return $C_char;
    }




?>