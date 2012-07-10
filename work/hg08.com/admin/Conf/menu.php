<?php
$menu = array();

$menu['网站设置'] = array(
	'网站参数' => array('System', 'setting'),
	'友情链接' => array('System', 'flink')
	);

$menu['文章管理'] = array(
	'foreach' => array('Article', 'index', 'Article_Category'),
	'添加内容' => array('Article', 'form'),
	'回收站' => array('Article', 'index', array('status',-1))
	);

$menu['作品管理'] = array(
	'foreach' => array('Album', 'index', 'Album_Category'),
	'作品分类' => array('Category', 'Album'),
	'添加内容' => array('Album', 'form'),
	'回收站' => array('Album', 'index', array('status',-1))
	);

$menu['预约管理'] = array(
	'待处理' => array('Reserve', 'index'),
	'已处理' => array('Reserve', 'index', array('status', 1))
	);

$menu['留言管理'] = array(
	'留言列表' => array('Feedback', 'index'),
	'回收站' => array('Feedback', 'index', array('status', -1))
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