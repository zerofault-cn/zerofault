��װ mod_python3.x
�����Լ����밲װ��mod_python3.2.8���м���ע�������¼������
 
1��mod_pythonĿǰֻ֧�� apache2.0�����Ա�����apache2.0
2��ports��װapache2�� WITH_THREADS���ֹ������� --enable-threads���������� Cannot load /usr/local/libexec/apache2/mod_python.so into server: /usr/local/libexec/apache2/mod_python.so: Undefined symbol "pthread_attr_init"

 
INSTALL Mod_python:
./configure --with-python=/usr/local/bin/python --with-apxs=/usr/local/sbin/apxs
make && make install
 
httpd.conf:
LoadModule python_module /usr/local/libexec/apache2/mod_python.so
