<?php

import('AdvModel');
class WebsiteModel extends AdvModel{
	// 自动验证设置
	protected $_validate = array(
		array('name','require','网站名称必必须填写！',2),
		array('url','require','网站链接地址必须填写！',3),
		array('name','','该名称已经存在',0,'unique',self::INSERT_STATUS),
		);
}

?>