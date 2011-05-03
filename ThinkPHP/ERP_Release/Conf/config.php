<?php
$config = array(
	//����ģʽ��Ĭ��false
	'APP_DEBUG'			=> false,

	//��չ�����ļ�
	'APP_CONFIG_LIST'	=> array('menu', 'absence', 'smtp', 'test'),
	
	//��ǩǶ�׼���Ĭ��Ϊ3
	'TAG_NESTED_LEVEL'	=> 6,

	//���ݿ����
	'DB_TYPE'			=> 'mysql',
	'DB_HOST'			=> 'localhost',
	'DB_NAME'			=> 'ERP2',
	'DB_USER'			=> 'root',
	'DB_PWD'			=> '',
	'DB_PREFIX'			=> 'erp_',

	//��ʾ���⣬�������ֲ�ͬ��ERP site
	'ERP_TITLE'			=> 'AGIGA Tech ERP System',

	//�û�session��������������ͬһվ�������ֲ�ͬĿ¼�µ�ERPϵͳ
	'STAFF_AUTH_NAME'   => 'staff',
	'MANAGER_AUTH_NAME' => 'location_manager',
	'ADMIN_AUTH_NAME'	=> 'administrator',
	
	//��������Ա��ID���飬��Ӣ�Ķ��ŷָ�
	'SUPER_ADMIN_ID'	=> array(1),
	//Absence����Ա(HR)��ID����
	'ABSENCE_ADMIN_ID'	=> array(1),
	//Task����Ա��ID����
	'TASK_ADMIN_ID'		=> array(1),

	//�ʲ�����ʱ������֪ͨ�ʼ�����ⷢ�͸���Щ�ʼ��ʺţ���Ӣ�ĵ����Ű�����Ӣ�Ķ��ŷָ�
	'NOTIFICATION_MAILTO' => array(),

	//Ȩ����֤����������벻Ҫ�������
	'USER_AUTH_ON'		=> true,
	//Ȩ����֤ģʽ��Ĭ��Ϊ1����¼ʱ��֤һ�Σ�2��ʵʱ��֤
	'USER_AUTH_TYPE'	=> 1,
	'USER_AUTH_MODEL'	=> 'Staff',
	'USER_AUTH_KEY'		=> 'authId',
	'USER_AUTH_GATEWAY' => '/Public/login',
	'RBAC_ROLE_TABLE'	=> 'erp_role',
	'RBAC_USER_TABLE'	=> 'erp_staff_role',
	'RBAC_ACCESS_TABLE'	=> 'erp_role_node',
	'RBAC_NODE_TABLE'	=> 'erp_node',

	//����ģ�鲻��ҪȨ����֤����Ĭ�����������Staff�ʺŶ����Է���
	'NOT_AUTH_MODULE'	=> 'Index,Public,Script,Asset,Inventory,Absence,Task,Attachment',
	//��iframe�д������󣬲��Ե�����Ϣ��ʽ��ʾ��������Action��
	'IFRAME_AUTH_ACTION' => array('update','delete','edit','submit','confirm','select','import','create')
	);

return $config;
?>