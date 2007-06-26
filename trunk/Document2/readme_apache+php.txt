这里是静态编译apache的方法
$ gunzip -c apache_1.3.x.tar.gz | tar xf -

$ cd apache_1.3.x

$ ./configure

$ cd ..


$ gunzip -c php-4.x.y.tar.gz | tar xf -

$ cd php-4.x.y

$ ./configure --with-mysql --with-apache=../apache_1.3.x --with-gd --with-zlib --with-jpeg-dir=../jpeg-6b/ --with-png-dir=../libpng-1.2.16 --with-freetype-dir=../freetype-2.3.2 --enable-gd-native-ttf --with-ttf --enable-mbstring --with-iconv

$ make

$ make install


$ cd ../apache_1.3.x
$ ./configure --prefix=/usr/local/apache --enable-module=rewrite --activate-module=src/modules/php4/libphp4.a

(The above line is correct!  Yes, we know libphp4.a does not exist at this
  stage.  It isn't supposed to.  It will be created.)

$ make
 
$ make install
$ cd ../php-4.x.y

$ cp php.ini-recommended /usr/local/lib/php.ini
然后根据需要编辑/usr/local/lib/php.ini

编辑/usr/local/apache/conf/httpd.conf
查找<IfModule mod_mime.c>

在此范围添加

AddType application/x-httpd-php .php
AddType application/x-httpd-php-source .phps


+---------------------------------------------+
DSO动态编译的方法：

首先编译安装apache

tar zvxf apache_1.3.29
cd apache_1.3.29
./configure --prefix=/usr/local/apache --enable-module=so --enable-module=rewrite 
make
make install

so模块用来提供DSO支持的apachehe核心模块，rewrite是地址重写的模块，如果不需要可以不编译

安装php之前先要下载并安装以下软件包(同版本或者更高)

jpegsrc.v6b.tar.gz
#./configure
#make
#make test
#make install

zlib-1.2.3.tar.gz
#./configure
#make
#make test
#make install

libpng-1.2.16.tar.gz
#cp scripts/makefile.linux makefile
#make test
#pngtest pngnow.png
#make install

freetype-2.3.2.tar.gz
#./configure --prefic=/usr/local
#make
#make install

gd-2.0.28.tar.gz
#./configure
#make
#make install

libxml2-2.6.26
#./configure
#make
#make install

(支持SQL Server2000）
freetds-stable.tgz
#tar zxvf freetds-stable.tgz
#./configure --prefix=/usr/local/freetds --with-tdsver=7.0
#make
#make install
然后编译php

#tar zvxf php4.3.4.tar.gz
#cd php4.3.4
#./configure --prefix=/usr/local/php --with-apxs=/usr/local/apache/bin/apxs --with-mysql=/usr/local/mysql --with-gd --with-zlib --with-jpeg-dir=../jpeg-6b/ --with-png-dir=../libpng-1.2.16 --with-freetype-dir=../freetype-2.3.2 --enable-gd-native-ttf --with-ttf --enable-mbstring --with-iconv --with-mssql=/usr/local/freetds
#make
#make install
#cp php.ini-recommended /usr/local/php/lib/php.ini
然后根据需要编辑/usr/local/php/lib/php.ini

然后修改httpd.conf，方法同静态编译的方法

