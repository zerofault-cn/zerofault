<?php
class PublicAction extends Action{
	public function variable() {
		echo '__ROOT__:'.__ROOT__.'<br />';// 网站根目录地址 
		echo '__APP__:'.__APP__ .'<br />';// ： 当前项目（入口文件）地址 
		echo '__GROUP__:'.__GROUP__.'<br />';//：当前分组地址
		echo '__URL__:'.__URL__.'<br />';//  ： 当前模块地址 
		echo '__ACTION__:'.__ACTION__.'<br />';// ： 当前操作地址 
		echo '__SELF__:'.__SELF__.'<br />';//  ： 当前 URL 地址 
		echo '__CURRENT__:'.__CURRENT__.'<br />';//  ： 当前模块的模板目录
		echo 'ACTION_NAME:'.ACTION_NAME.'<br />';// ： 当前操作名称 
		echo 'APP_PATH:'.APP_PATH.'<br />';// ： 当前项目目录 
		echo 'APP_NAME:'.APP_NAME.'<br />';// ： 当前项目名称 
		echo 'APP_TMPL_PATH:'.APP_TMPL_PATH.'<br />';// ： 项目模板目录
		echo 'APP_PUBLIC_PATH ：'.APP_PUBLIC_PATH.'<br />';//项目公共文件目录 
		echo 'CACHE_PATH ：'.CACHE_PATH.'<br />';// 项目模版缓存目录 
		echo 'CONFIG_PATH ：'.CONFIG_PATH.'<br />';//'.项目配置文件目录 
		echo 'COMMON_PATH ：'.COMMON_PATH.'<br />';// 项目公共文件目录
		echo 'DATA_PATH ：'.DATA_PATH.'<br />';// 项目数据文件目录 
		echo 'GROUP_NAME ：'.GROUP_NAME.'<br />';//当前分组名称 
		echo 'HTML_PATH ：'.HTML_PATH.'<br />';// 项目静态文件目录
		echo 'IS_APACHE ：'.IS_APACHE.'<br />';// 是否属于 Apache (2.1版开始已取消)
		echo 'IS_CGI ：'.IS_CGI.'<br />';//是否属于 CGI模式 
		echo 'IS_IIS ：'.IS_IIS.'<br />';//是否属于 IIS  (2.1版开始已取消)
		echo 'IS_WIN ：'.IS_WIN.'<br />';//是否属于Windows 环境 
		echo 'LANG_SET ：'.LANG_SET.'<br />';// 浏览器语言 
		echo 'LIB_PATH ：'.LIB_PATH.'<br />';// 项目类库目录 
		echo 'LOG_PATH ：'.LOG_PATH.'<br />';// 项目日志文件目录 
		echo 'LANG_PATH ：'.LANG_PATH.'<br />';// 项目语言文件目录
		echo 'MODULE_NAME ：'.MODULE_NAME.'<br />';//当前模块名称 
		echo 'MEMORY_LIMIT_ON ：'.MEMORY_LIMIT_ON.'<br />';// 是否有内存使用限制 
		echo 'MAGIC_QUOTES_GPC ：'.MAGIC_QUOTES_GPC.'<br />';// MAGIC_QUOTES_GPC 
		echo 'TEMP_PATH  ：'.TEMP_PATH.'<br />';//项目临时文件目录 
		echo 'TMPL_PATH ：'.TMPL_PATH.'<br />';// 项目模版目录 
		echo 'THINK_PATH ：'.THINK_PATH.'<br />';// ThinkPHP 系统目录 
		echo 'THINK_VERSION ：'.THINK_VERSION.'<br />';//ThinkPHP版本号 
		echo 'TEMPLATE_NAME ：'.TEMPLATE_NAME.'<br />';//当前模版名称 
		echo 'TEMPLATE_PATH ：'.TEMPLATE_PATH.'<br />';//当前模版路径 
		echo 'VENDOR_PATH ：'.VENDOR_PATH.'<br />';// 第三方类库目录 
		echo 'WEB_PUBLIC_PATH ：'.WEB_PUBLIC_PATH.'<br />';//网站公共目录 
		echo 'TAPP_CACHE_NAME ：'.TAPP_CACHE_NAME.'<br />';// 系统缓存文件名  2.1版本新增
		echo 'PHP_FILE: '.PHP_FILE.'<br />';
	}
}