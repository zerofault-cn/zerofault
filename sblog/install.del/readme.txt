/**************************************************************
	sBLOG中文版安装说明
	Project	sBLOG <http://sblog.sourceforge.net>
	Author	Servous <servous@gmail.com>
	License	GPL
	中文版支持: inso (http://www.sblog.cn)
			 (http://www.shi8.com)
**************************************************************/

需要环境:
PHP+MYSQL(10M以上PHP空间,5M以上MySQL更佳,MySQL具有一般的drop,insert等权限)
推荐FreeBSD,Linux类空间,当然inso在PHP 5.0.0,MySQL 4.0.20d,Apache 2.0.50,Windows Sever 2000下调试也没问题.


升级安装请上传所有文件和目录,设置好属性后按照下面的步骤进行升级安装.

安装:
1. 上传所有文件到服务器.
2. 更改upload目录和tn目录属性CHMOD为777.
3. 浏览器里输入: http://your.domain.com/<sblog>/install
<sblog>表示sblog的安装目录.根据安装向导提示进行安装.
3. 根据安装向导的最后一步提示,把那段代码复制下来,保存为config.php(可以用记事本,然后粘贴上那个代码,最后文件另存为,选全部文件,输入文件名,config.php),上传到sBLOG的根目录下.删除install目录.记得哦.
4.这样就可以用啦.

技术支持:http://www.sblog.cn (sBLOG官方认可中文站点)

