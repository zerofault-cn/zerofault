<?php
$menu = array();

$menu['网站设置'] = array(
	'网站参数' => array('System', 'setting'),
	'栏目头图' => array('System', 'image'),
	'友情链接' => array('System', 'flink')
	);

$menu['文章管理'] = array(
	'foreach' => array('Article', 'index', 'Article_Category'),
	'添加内容' => array('Article', 'form'),
	'回收站' => array('Article', 'index', array('status',-1))
	);

$menu['作品管理'] = array(
	'foreach' => array('Album', 'index', 'Album_Category'),
	'作品分类' => array('Album', 'category'),
	'添加相册' => array('Album', 'form'),
	'回收站' => array('Album', 'index', array('status',-1))
	);

$menu['顾客特照'] = array(
	'图片列表' => array('Photo', 'index'),
	'添加图片' => array('Photo', 'form', array('category_id', 3))
	);

$menu['客户管理'] = array(
	'客户列表' => array('Client', 'index'),
	'已归档' => array('Client', 'archived'),
	'项目步骤' => array('Client', 'project'),
	);

$menu['预约管理'] = array(
	'待处理' => array('Reserve', 'index', array('status', 0)),
	'已处理' => array('Reserve', 'index', array('status', 1))
	);

$menu['留言管理'] = array(
	'未审核' => array('Feedback', 'index', array('status', 0)),
	'已审核' => array('Feedback', 'index', array('status', 1))
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