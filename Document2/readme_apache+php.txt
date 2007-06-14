这里是静态编译apache的方法
$ gunzip -c apache_1.3.x.tar.gz | tar xf -

$ cd apache_1.3.x

$ ./configure

$ cd ..


$ gunzip -c php-4.x.y.tar.gz | tar xf -

$ cd php-4.x.y

$ ./configure --with-mysql --with-apache=../apache_1.3.x

$ make

$ make install


$ cd ../apache_1.3.x
 (./configure --prefix=/usr/local/apache --enable-shared=max --enable-module=most
)
$ ./configure --prefix=/usr/local/apache --activate-module=src/modules/php4/libphp4.a

(The above line is correct!  Yes, we know libphp4.a does not exist at this
  stage.  It isn't supposed to.  It will be created.)

$ make
 
$ make install
$ cd ../php-4.x.y

$ cp php.ini-recommended /usr/local/lib/php.ini
然后根据需要编辑/usr/local/lib/php.ini
若apache服务器出现302的错误,则将php.ini中的register_global置为on

编辑/usr/local/apache/conf/httpd.conf
查找<IfModule mod_mime.c>

在此范围添加

AddType application/x-httpd-php .php
AddType application/x-httpd-php-source .phps




我们再来讲讲DSO动态编译的方法：

首先编译安装apache

tar zvxf apache_1.3.29
cd apache_1.3.29
./configure --prefix=/usr/local/apache --enable-module=so \
--enable-module=rewrite --enable-shared=max &&
make &&
make install

so模块用来提供DSO支持的apachehe核心模块，rewrite是地址重写的模块，如果不需要可以不编译
enable－shared＝max是指除了so以外的所有标准模块都编译成DSO模块。


然后编译php

tar zvxf php4.3.4.tar.gz
cd php4.3.2
./configure --prefix=/usr/local/php --with-mysql=/usr/local/mysql \
--with-apxs=/usr/local/apache/bin/apxs &&
make &&
make install

然后修改httpd.conf，方法同静态编译的方法



启动命令:
/usr/local/apache/bin/apachectl start


启动opengk命令:
/opt/openh323gk/bin/gnugk -c /opt/openh323gk/etc/complete.ini &

启动Helix的命令:
/opt/Helix302/Bin/rmserver /opt/Helix302/rmserver.cfg &


红帽子Linux系统自带apache的版本是Apache-2.0.44
配置文件路径
/etc/httpd/conf/httpd.conf
需要修改的地方:
listen 80
DocumentRoot "/var/www/html"

在适当位置添加:
AddLanguage  zh-cn  .cn  
AddCharset GB2312      .gb2312 .gb 
修改：  
#AddDefaultCharset  ISO-8859-1  为  AddDefaultCharset  GB2312  


自带PHP的版本为4.2.2
配置文件在/etc/php.ini


自带的MySQL版本为3.23.54
需要修改的地方
修改/etc/my.cnf
在[mysqld]里加入:
skip-innodb

data目录是/var/lib/mysql
chown -R mysql /var/lib/mysql
chgrp -R mysql /var/lib/mysql

启动命令:
safe_mysqld --user=mysql &
