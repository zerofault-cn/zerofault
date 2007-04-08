<?php
    /**********************************************************************/
    /* 文件名：class_common_object_view.inc.php                           */
    /* 功能：  通用对象的视图管理类                                       */
    /* 版本：  0.1                                                        */
    /* 日期：  2005-8-29                                                  */
    /* 作者：  朱江敏                                                     */
    /* 版权：  北京博客时代信息技术有限公司                               */
    /**********************************************************************/

if (!defined('CLASS_COMMON_OBJECT_VIEW_INC_PHP'))
{
    define('CLASS_COMMON_OBJECT_VIEW_INC_PHP', true);
    
    include_once($root_path."includes/template.php"); //应用模板；引用template.php文件。

    
    /**********************************************************************/
    /* 类名：CommonObjectView                                             */
    /* 功能：显示通用对象的视图以及相关的参数设置                         */
    /**********************************************************************/
    class CommonObjectView
    {

        var $params = array();                          // 参数列表

        var $tpl;					// 模板

        var $tplRoot;		 		        // 模板的根位置

        /******************************************************************/
        /* 函数：CommonObjectView                                         */
        /* 参数：                                                         */
        /* 功能：构造函数                                                 */
        /* 返回值：                                                       */
        /******************************************************************/
        function CommonObjectView($tpl_root)
        {
            $this->tplRoot = $tpl_root;
            $this->tpl = new template($this->tplRoot);//创建模板对象；
        }

        /******************************************************************/
        /* 函数：SetVars                                                  */
        /* 参数：varname为变量名称，它可以为普通类型的参数，也可以为数组  */
        /*       形式，当为单个参数时，varval表示该变量的值，当它为数组形 */
        /*       式时，数组中的key为变量名称，val为变量值，此时varval不起 */
        /*       作用                                                     */
        /* 功能：设置视图参数（不包括BLOCK中的参数）                      */
        /* 返回值：                                                       */
        /******************************************************************/
        function SetVars($varname, $varval = "")
        {
        		if (!is_array($varname))
            {
            		//if (array_key_exists($varname, $params))
                		$this->params[$varname] = $varval;
            }
            else
            {
            		foreach($varname as $key => $val)
                {
                    $this->params[$key] = $val;
                }
            }
        }

        /******************************************************************/
        /* 函数：PrintResult                                              */
        /* 参数：                                     					*/
        /* 功能：打印输出结果                                             */
        /* 返回值：                                                       */
        /******************************************************************/
        function PrintResult()
        {
            echo "<BR>Please derive other view class from CommonObjectView class".
                " and override function PrintResult()!<BR>";
        }
    }
}
?>
