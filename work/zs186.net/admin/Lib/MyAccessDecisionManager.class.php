<?php 
// +----------------------------------------------------------------------
// | ThinkPHP                                                             
// +----------------------------------------------------------------------
// | Copyright (c) 2008 http://thinkphp.cn All rights reserved.      
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>                                  
// +----------------------------------------------------------------------
// $Id$

/**
 +------------------------------------------------------------------------------
 * 访问决策管理器
 +------------------------------------------------------------------------------
 * @category   ORG
 * @package  ORG
 * @subpackage  RBAC
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class MyAccessDecisionManager extends Think
{//类定义开始

	public $roleTable    ;
	public $roleUserTable  ;
	public $roleAccessTable;
	public $roleNodeTable;


	/**
	 +----------------------------------------------------------
	 * 架构函数
	 * 
	 +----------------------------------------------------------
	 * @static
	 * @access public 
	 +----------------------------------------------------------
	 */
	public function __construct()
	{
		import("Think.Db.Db");
		$this->roleTable = C('DB_PREFIX').'role';
		$this->roleUserTable  =  C('DB_PREFIX').'admin_role';
		$this->roleAccessTable=   C('DB_PREFIX').'role_node';
		$this->roleNodeTable    =   C('DB_PREFIX').'node';
	}

	/**
	 +----------------------------------------------------------
	 * 决策认证
	 * 检查是否具有当前的操作权限
	 +----------------------------------------------------------
	 * @param integer $authId 认证id
	 * @param string $app 项目名
	 * @param string $module 模块名
	 * @param string $action 操作名
	 +----------------------------------------------------------
	 * @access public 
	 +----------------------------------------------------------
	 */
	public function decide($authId,$app=APP_NAME,$module=MODULE_NAME,$action=ACTION_NAME)
	{
		//决策认证号是否具有当前模块权限
		$db     =   DB::getInstance();
		$sql    =   "select role.id from ".
					$this->roleTable." as role,".
					$this->roleUserTable." as admin_role,".
					$this->roleAccessTable." as role_node,".
					$this->roleNodeTable." as node ".
					"where admin_role.admin_id={$authId} and admin_role.role_id=role.id and role_node.role_id=role.id and role.status=1 and role_node.node_id=node.id and ( (node.name='".$module."' and node.level=2) or ( node.name='".$action."' and node.level=3 ) or ( node.name='".$app."' and node.level=1) )";
		$rs =   $db->query($sql);
		if($rs->count()>0) {
			return true;
		}else {
			return false;
		}
	}

	/**
	 +----------------------------------------------------------
	 * 取得当前认证号的所有权限列表
	 +----------------------------------------------------------
	 * @param string $appPrefix 数据库前缀
	 +----------------------------------------------------------
	 * @access public 
	 +----------------------------------------------------------
	 */
	public function getAccessList($authId)
	{
		// 读取项目权限
		$db     =   DB::getInstance();
		$sql    =   "select node.id, node.name from ".
					$this->roleTable." as role,".
					$this->roleUserTable." as admin_role,".
					$this->roleAccessTable." as role_node,".
					$this->roleNodeTable." as node ".
					"where admin_role.admin_id={$authId} and admin_role.role_id=role.id ".
					"and role_node.role_id=role.id and role.status=1 ".
					"and role_node.node_id=node.id and node.level=1 ";
		$apps =   $db->query($sql);
		$access =  array();
		foreach($apps as $key=>$app) {
			$app	=	(array)$app;
			$appId	=	$app['id'];
			$appName	 =	 $app['name'];
			// 读取项目的模块权限
			$access[strtoupper($appName)]   =  array();
			$sql = "select node.id, node.name from ".
					$this->roleTable." as role,".
					$this->roleUserTable." as admin_role,".
					$this->roleAccessTable." as role_node,".
					$this->roleNodeTable." as node ".
					"where admin_role.admin_id={$authId} and admin_role.role_id=role.id ".
					"and role_node.role_id=role.id and role.status=1 ".
					"and role_node.node_id=node.id and node.level=2 ".
					"and node.pid={$appId}";
			$modules =   $db->query($sql);
			foreach($modules as $key=>$module) {
				$module	=	(array)$module;
				$moduleId	 =	 $module['id'];
				$moduleName = $module['name'];
				$sql = "select node.id, node.name from ".
					$this->roleTable." as role,".
					$this->roleUserTable." as admin_role,".
					$this->roleAccessTable." as role_node,".
					$this->roleNodeTable." as node ".
					"where admin_role.admin_id={$authId} and admin_role.role_id=role.id ".
					"and role_node.role_id=role.id and role.status=1 ".
					"and role_node.node_id=node.id and node.level=3 ".
					"and node.pid={$moduleId}";
				$rs =   $db->query($sql);
				$action = array();
				foreach ($rs as $a){
					$a	 =	 (array)$a;
					$action[$a['name']] = $a['id'];
				}
				$access[strtoupper($appName)][strtoupper($moduleName)]   =  array_change_key_case($action,CASE_UPPER);
			}
		}
		//dump($access);
		return $access;
	}

}//类定义结束
?>