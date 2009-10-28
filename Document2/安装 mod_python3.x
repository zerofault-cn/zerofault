安装 mod_python3.x
今天自己编译安装了mod_python3.2.8，有几点注意事项记录下来：
 
1、mod_python目前只支持 apache2.0，所以必须用apache2.0
2、ports安装apache2用 WITH_THREADS，手工编译用 --enable-threads，否则会出现 Cannot load /usr/local/libexec/apache2/mod_python.so into server: /usr/local/libexec/apache2/mod_python.so: Undefined symbol "pthread_attr_init"

 
INSTALL Mod_python:
./configure --with-python=/usr/local/bin/python --with-apxs=/usr/local/sbin/apxs
make && make install
 
httpd.conf:
LoadModule python_module /usr/local/libexec/apache2/mod_python.so
