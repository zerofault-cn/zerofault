<?php
$menu = array();

$menu['网站设置'] = array(
	'网站参数' => array('Index', 'setting'),
	'酒店分类' => array('Category', 'Hotel'),
	'内容分类' => array('Category', 'Article'),
	'行政区域' => array('Region', 'index'),
	'商业区域' => array('District', 'index'),
	'酒店星级' => array('Level', 'index'),
	'友情链接' => array('Index', 'flink')
	);

$menu['酒店管理'] = array(
	'foreach' => array('Hotel', 'index', 'Hotel_Category'),
	'添加酒店' => array('Hotel', 'form'),
	'回收站' => array('Hotel', 'index', array('status',-1))
	);

$menu['内容管理'] = array(
	'foreach' => array('Article', 'index', 'Article_Category'),
	'添加内容' => array('Article', 'form'),
	'回收站' => array('Article', 'index', array('status',-1))
	);

$menu['预订管理'] = array(
	'待处理' => array('Book', 'index'),
	'已处理' => array('Book', 'index', array('status', 1))
	);

$menu['留言管理'] = array(
	'待处理' => array('Feedback', 'index'),
	'已处理' => array('Feedback', 'index', array('status', 1))
	);

$menu['管理员管理'] = array(
	'管理员列表' => array('Admin', 'index'),
	);
$menu['权限管理'] = array(
	'节点列表' => array('Node', 'index'),
	'角色列表' => array('Role', 'index')
	);

return $menu;
?>