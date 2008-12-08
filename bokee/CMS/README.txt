Bokee.com
CMS系统说明

于敦德
创建于:2005-7-14

-----------------------------------------------------------------------


目录结构：

cache			缓存目录
/
|------	com				通用类文件
|------	CVS				CVS目录
|------	images				CMS系统图片目录
|------	index.shtml			首页
|------	lang				语法相关类目录
|------	main.php			主控制器
|------	mvc				mvc库目录
|------	smarttemplate			smart模板库目录
|------	sql				sql代码类目录
|------	web				网站发布目录
|------	WEB-INF				模板，逻辑控制器，类等系统目录
	|------	classes			业务处理类
	|------	tpls			模板php
	|------	html			smart template模板
		|------	templates	网站模板(首页，专题，文章等)

系统架构：

系统使用mvc架构，mvc库存放于/mvc中。主控制器为main.php，负责接收所有请求并调用相关程序进行处理。逻辑处理映射表放置于/WEB-INF/mvc_config.inc.php，使用数组对业务逻辑关系进行存储。
系统配置存放于/WEB-INF/config.inc.php，对系统运行环境变量进行定义。
Win系统配置文件：config.inc.php
Linux系统配置文件：config.linux.inc.php

处理过程分为几步：
1、主控制器(main.php)接收请求。
2、到业务逻辑映射表中查找相应处理方法，处理方法分为两种，包括FormAction与不包含FormAction。包含FormAction的业务需要在FORM_BEANS里添加相对应的处理类，此处理类由ActionForm派生，重写validate方法，对传入的表单数据进行验证，并将出错信息保存在action_error当中，然后返回。

建库脚本：
CREATE_DB_CMS.sql
CREATE_DB_CMS_LIFE.sql