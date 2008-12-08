<?php

/* role.inc.php
 * 一些用户权限的定义图，每一行为一个role设置
 * 可按照格式添加新的设置
 * 将被User.cls.php 取用
 * 保存在用户User表中的role字段含义
 * 前两位为屏道编号，00为全站范围，99为模板
 * 后两位权限映射于此图
 * preset action: all  所有动作
 *                view 可打开
 *                add  添加 delete 删除 modify 修改 draft 草稿 (此操作包括将draft发表为正式文章)
 *                approve 许可（此操作包括将正式文章放回draft）
 */

$ROLE_SETTINGS = array (

		0 => array ( 
			'name'   => '系统管理员', 
			'master'  => 1,
			'deny_action' => array ('none'), 
			),

		1 => array ( 	
			'name'   => '总编',
			'master'  => 1,
			'deny_action' => array ('none'),
			),
        2 => array (
            'name'   => '主编',
            'master'  => 0,
            'deny_action' => array ('none'),
            ),
		3 => array ( 
			'name'   => '编辑',
			'master'  => 0,
			'deny_action' => array ('user_add','user_list','block_list','template_add', 'subject_add', 'subject_modify', 'subject_delete', 'template_new_add', 'template_delete', 'template_modify'),
			),
       4 => array (
            'name'   => '广告',
            'master'  => 0,
            'deny_action' => array ('user_add','user_list','block_list','template_add', 'subject_add', 'subject_modify', 'subject_delete', 'template_new_add', 'template_delete', 'template_modify'),
            )
		);


// TESTING
/*
$role_id=3304;
print_r (getRoleProp($role_id));

        function getRoleProp ($role_id) {
                global $ROLE_SETTINGS;
                $_perm = $role_id%100;  // role_id的后两位是它的权限
                $_active_channel = floor($role_id/100);
                                        // role_id的前两位是它的活动屏道
                $role_perm = $ROLE_SETTINGS[$_perm];
                $role_perm['active_channel'] = $_active_channel;
		return $role_perm;
        }

*/
?>
