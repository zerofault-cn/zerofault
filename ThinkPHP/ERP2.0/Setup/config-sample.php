<?php
return $config = array(
	'ERP_TITLE'		=> 'AGIGA Tech ERP System', //����ϵͳ���⣬��������
	'DB_TYPE'		=> 'mysql',
	'DB_HOST'		=> 'localhost',  //����MySQL��������ַ
	'DB_NAME'		=> 'ERP',        //����ERP���õ�Database
	'DB_USER'		=> 'root',       //��������MySQL���û���
	'DB_PWD'		=> '',           //��������MySQL������
	'DB_PREFIX'		=> 'erp_',

	'APP_CONFIG_LIST'	=> array('menu'),

	'USER_AUTH_ON'		=> true,
	'USER_AUTH_TYPE'	=> 1,
	'USER_AUTH_MODEL'	=> 'Staff',
	'USER_AUTH_KEY'		=> 'authId',
	'STAFF_AUTH_NAME'	=> 'staff',         //�����¼�û�����Ϣ��Ϊ�������ϵͳ���ֿ������޸�Ϊ��ͬ��ֵ
	'MANAGER_AUTH_NAME'	=> 'manager',       //��������Ա����Ϣ��Ϊ�������ϵͳ���ֿ������޸�Ϊ��ͬ��ֵ
//	'ADMIN_AUTH_KEY'	=> 'administrator', //ԭADMIN_AUTH_KEY����ΪADMIN_AUTH_NAME
	'ADMIN_AUTH_NAME'	=> 'administrator', //���泬������Ա����Ϣ��Ϊ�������ϵͳ���ֿ������޸�Ϊ��ͬ��ֵ
	'SUPER_ADMIN_ID'	=> array(1),        //�趨��������Ա��Ĭ��staff.IDΪ1��������Ӷ������Ӣ�Ķ��ŷָ�
	'USER_AUTH_GATEWAY'	=> '/Public/login',
	'RBAC_ROLE_TABLE'	=> 'erp_role',
	'RBAC_USER_TABLE'	=> 'erp_staff_role',
	'RBAC_ACCESS_TABLE'	=> 'erp_role_node',
	'RBAC_NODE_TABLE'	=> 'erp_node',
	'NOT_AUTH_MODULE'	=> 'Index,Public,Script,Asset,Inventory',
	'IFRAME_AUTH_ACTION'	=> array('update', 'delete', 'edit', 'submit', 'confirm', 'select','import')
	);
?>