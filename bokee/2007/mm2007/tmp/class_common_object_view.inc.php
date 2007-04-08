<?php
    /**********************************************************************/
    /* �ļ�����class_common_object_view.inc.php                           */
    /* ���ܣ�  ͨ�ö������ͼ������                                       */
    /* �汾��  0.1                                                        */
    /* ���ڣ�  2005-8-29                                                  */
    /* ���ߣ�  �콭��                                                     */
    /* ��Ȩ��  ��������ʱ����Ϣ�������޹�˾                               */
    /**********************************************************************/

if (!defined('CLASS_COMMON_OBJECT_VIEW_INC_PHP'))
{
    define('CLASS_COMMON_OBJECT_VIEW_INC_PHP', true);
    
    include_once($root_path."includes/template.php"); //Ӧ��ģ�壻����template.php�ļ���

    
    /**********************************************************************/
    /* ������CommonObjectView                                             */
    /* ���ܣ���ʾͨ�ö������ͼ�Լ���صĲ�������                         */
    /**********************************************************************/
    class CommonObjectView
    {

        var $params = array();                          // �����б�

        var $tpl;					// ģ��

        var $tplRoot;		 		        // ģ��ĸ�λ��

        /******************************************************************/
        /* ������CommonObjectView                                         */
        /* ������                                                         */
        /* ���ܣ����캯��                                                 */
        /* ����ֵ��                                                       */
        /******************************************************************/
        function CommonObjectView($tpl_root)
        {
            $this->tplRoot = $tpl_root;
            $this->tpl = new template($this->tplRoot);//����ģ�����
        }

        /******************************************************************/
        /* ������SetVars                                                  */
        /* ������varnameΪ�������ƣ�������Ϊ��ͨ���͵Ĳ�����Ҳ����Ϊ����  */
        /*       ��ʽ����Ϊ��������ʱ��varval��ʾ�ñ�����ֵ������Ϊ������ */
        /*       ʽʱ�������е�keyΪ�������ƣ�valΪ����ֵ����ʱvarval���� */
        /*       ����                                                     */
        /* ���ܣ�������ͼ������������BLOCK�еĲ�����                      */
        /* ����ֵ��                                                       */
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
        /* ������PrintResult                                              */
        /* ������                                     					*/
        /* ���ܣ���ӡ������                                             */
        /* ����ֵ��                                                       */
        /******************************************************************/
        function PrintResult()
        {
            echo "<BR>Please derive other view class from CommonObjectView class".
                " and override function PrintResult()!<BR>";
        }
    }
}
?>
