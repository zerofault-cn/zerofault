shell> groupadd mysql
shell> useradd -g mysql mysql
shell> gunzip < mysql-VERSION.tar.gz | tar -xvf 
shell> cd mysql-VERSION
shell> ./configure --prefix=/usr/local/mysql
shell> make
shell> make install
shell> cd /usr/local/mysql
shell> ./bin/mysql_install_db
shell> chown -R root:mysql  /usr/local/mysql
shell> chown -R mysql:mysql /usr/local/mysql/var
shell> cp ./share/mysql/my-medium.cnf /etc/my.cnf

����MySQL:
for mysql-4.*:
	/usr/local/mysql/bin/mysqld_safe --user=mysql &
for mysql-3.*:
	/usr/local/mysql/bin/safe_mysqld --user=mysql &

���ϵͳ�û�:
shell>/usr/local/mysql/bin/mysql
mysql>grant all privileges on *.* to username@'localhost' identified by 'passwd' with grant option;
mysql>grant all privileges on *.* to username@'%' identified by 'passwd' with grant option;
(���ӿ��Դ��κεط����ӷ�������һ����ȫ�ĳ����û�username��
mysql>\q���˳�mysql���ӣ�

#mysqladmin reload�����²�����Ȩ�ޱ�


grant all privileges on *.* to root@'10.10.4.34' identified by '10y9c2U5' with grant option;
flush privileges;
update user set password=old_password('bokee') where host='218.249.35.66'