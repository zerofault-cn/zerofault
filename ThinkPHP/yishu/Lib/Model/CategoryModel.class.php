<?php

import('AdvModel');
class CategoryModel extends AdvModel{
	// �Զ���֤����
	protected $_validate = array(
		array('name','require','��վ���Ʊر�����д��',2),
		array('name','','�������Ѿ�����',0,'unique',self::INSERT_STATUS),
		);
}

?>