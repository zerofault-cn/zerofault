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
Ȼ�������Ҫ�༭/usr/local/lib/php.ini
��apache����������302�Ĵ���,��php.ini�е�register_global��Ϊon

�༭/usr/local/apache/conf/httpd.conf
����һ��:
AddType application/x-httpd-php .php

�޸���������:
DocumentRoot "/jbproject/tomcat/goldsoft/php-vod"

<Directory "/jbproject/tomcat/goldsoft/php-vod">

��������:
/usr/local/apache/bin/apachectl start


����opengk����:
/opt/openh323gk/bin/gnugk -c /opt/openh323gk/etc/complete.ini &

����Helix������:
/opt/Helix302/Bin/rmserver /opt/Helix302/rmserver.cfg &


��ñ��Linuxϵͳ�Դ�apache�İ汾��Apache-2.0.44
�����ļ�·��
/etc/httpd/conf/httpd.conf
��Ҫ�޸ĵĵط�:
listen 80
DocumentRoot "/var/www/html"

���ʵ�λ�����:
AddLanguage  zh-cn  .cn  
AddCharset GB2312      .gb2312 .gb 
�޸ģ�  
#AddDefaultCharset  ISO-8859-1  Ϊ  AddDefaultCharset  GB2312  


�Դ�PHP�İ汾Ϊ4.2.2
�����ļ���/etc/php.ini


�Դ���MySQL�汾Ϊ3.23.54
��Ҫ�޸ĵĵط�
�޸�/etc/my.cnf
��[mysqld]�����:
skip-innodb

dataĿ¼��/var/lib/mysql
chown -R mysql /var/lib/mysql
chgrp -R mysql /var/lib/mysql

��������:
safe_mysqld --user=mysql &
