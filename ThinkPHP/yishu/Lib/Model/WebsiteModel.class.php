<?php

import('AdvModel');
class WebsiteModel extends AdvModel{
	// �Զ���֤����
	protected $_validate = array(
		array('name','require','��վ���Ʊر�����д��',2),
		array('url','require','��վ���ӵ�ַ������д��',3),
		array('name','','�������Ѿ�����',0,'unique',self::INSERT_STATUS),
		);
}

?>