<?php
class PublicAction extends Action{
	public function variable() {
		echo '__ROOT__:'.__ROOT__.'<br />';// ��վ��Ŀ¼��ַ 
		echo '__APP__:'.__APP__ .'<br />';// �� ��ǰ��Ŀ������ļ�����ַ 
		echo '__GROUP__:'.__GROUP__.'<br />';//����ǰ�����ַ
		echo '__URL__:'.__URL__.'<br />';//  �� ��ǰģ���ַ 
		echo '__ACTION__:'.__ACTION__.'<br />';// �� ��ǰ������ַ 
		echo '__SELF__:'.__SELF__.'<br />';//  �� ��ǰ URL ��ַ 
		echo '__CURRENT__:'.__CURRENT__.'<br />';//  �� ��ǰģ���ģ��Ŀ¼
		echo 'ACTION_NAME:'.ACTION_NAME.'<br />';// �� ��ǰ�������� 
		echo 'APP_PATH:'.APP_PATH.'<br />';// �� ��ǰ��ĿĿ¼ 
		echo 'APP_NAME:'.APP_NAME.'<br />';// �� ��ǰ��Ŀ���� 
		echo 'APP_TMPL_PATH:'.APP_TMPL_PATH.'<br />';// �� ��Ŀģ��Ŀ¼
		echo 'APP_PUBLIC_PATH ��'.APP_PUBLIC_PATH.'<br />';//��Ŀ�����ļ�Ŀ¼ 
		echo 'CACHE_PATH ��'.CACHE_PATH.'<br />';// ��Ŀģ�滺��Ŀ¼ 
		echo 'CONFIG_PATH ��'.CONFIG_PATH.'<br />';//'.��Ŀ�����ļ�Ŀ¼ 
		echo 'COMMON_PATH ��'.COMMON_PATH.'<br />';// ��Ŀ�����ļ�Ŀ¼
		echo 'DATA_PATH ��'.DATA_PATH.'<br />';// ��Ŀ�����ļ�Ŀ¼ 
		echo 'GROUP_NAME ��'.GROUP_NAME.'<br />';//��ǰ�������� 
		echo 'HTML_PATH ��'.HTML_PATH.'<br />';// ��Ŀ��̬�ļ�Ŀ¼
		echo 'IS_APACHE ��'.IS_APACHE.'<br />';// �Ƿ����� Apache (2.1�濪ʼ��ȡ��)
		echo 'IS_CGI ��'.IS_CGI.'<br />';//�Ƿ����� CGIģʽ 
		echo 'IS_IIS ��'.IS_IIS.'<br />';//�Ƿ����� IIS  (2.1�濪ʼ��ȡ��)
		echo 'IS_WIN ��'.IS_WIN.'<br />';//�Ƿ�����Windows ���� 
		echo 'LANG_SET ��'.LANG_SET.'<br />';// ��������� 
		echo 'LIB_PATH ��'.LIB_PATH.'<br />';// ��Ŀ���Ŀ¼ 
		echo 'LOG_PATH ��'.LOG_PATH.'<br />';// ��Ŀ��־�ļ�Ŀ¼ 
		echo 'LANG_PATH ��'.LANG_PATH.'<br />';// ��Ŀ�����ļ�Ŀ¼
		echo 'MODULE_NAME ��'.MODULE_NAME.'<br />';//��ǰģ������ 
		echo 'MEMORY_LIMIT_ON ��'.MEMORY_LIMIT_ON.'<br />';// �Ƿ����ڴ�ʹ������ 
		echo 'MAGIC_QUOTES_GPC ��'.MAGIC_QUOTES_GPC.'<br />';// MAGIC_QUOTES_GPC 
		echo 'TEMP_PATH  ��'.TEMP_PATH.'<br />';//��Ŀ��ʱ�ļ�Ŀ¼ 
		echo 'TMPL_PATH ��'.TMPL_PATH.'<br />';// ��Ŀģ��Ŀ¼ 
		echo 'THINK_PATH ��'.THINK_PATH.'<br />';// ThinkPHP ϵͳĿ¼ 
		echo 'THINK_VERSION ��'.THINK_VERSION.'<br />';//ThinkPHP�汾�� 
		echo 'TEMPLATE_NAME ��'.TEMPLATE_NAME.'<br />';//��ǰģ������ 
		echo 'TEMPLATE_PATH ��'.TEMPLATE_PATH.'<br />';//��ǰģ��·�� 
		echo 'VENDOR_PATH ��'.VENDOR_PATH.'<br />';// ���������Ŀ¼ 
		echo 'WEB_PUBLIC_PATH ��'.WEB_PUBLIC_PATH.'<br />';//��վ����Ŀ¼ 
		echo 'TAPP_CACHE_NAME ��'.TAPP_CACHE_NAME.'<br />';// ϵͳ�����ļ���  2.1�汾����
		echo 'PHP_FILE: '.PHP_FILE.'<br />';
	}
}