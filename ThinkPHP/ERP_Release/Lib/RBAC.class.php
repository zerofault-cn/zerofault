<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

/**
 +------------------------------------------------------------------------------
 * 基于角色的数据库方式验证类
 +------------------------------------------------------------------------------
 * @category   ORG
 * @package  ORG
 * @subpackage  Util
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
// 配置文件增加设置
// USER_AUTH_ON 是否需要认证
// USER_AUTH_TYPE 认证类型
// USER_AUTH_KEY 认证识别号
// REQUIRE_AUTH_MODULE  需要认证模块
// NOT_AUTH_MODULE 无需认证模块
// USER_AUTH_GATEWAY 认证网关
/*
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `think_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `think_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `think_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `think_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
*/
class RBAC extends Think
{
    // 认证方法
    static public function authenticate($map,$model='')
    {
        if(empty($model)) $model =  C('USER_AUTH_MODEL');
        //使用给定的Map进行认证
        return M($model)->where($map)->find();
    }

    //用于检测用户权限的方法,并保存到Session中
    static function saveAccessList($authId=null)
    {
        if(null===$authId)   $authId = $_SESSION[C('USER_AUTH_KEY')];
        // 如果使用普通权限模式，保存当前用户的访问权限列表
        // 对管理员开发所有权限
        if(C('USER_AUTH_TYPE') !=2 && !$_SESSION[C('ADMIN_AUTH_NAME')] )
            $_SESSION['_ACCESS_LIST']	=	RBAC::getAccessList($authId);
        return ;
    }

	// 取得模块的所属记录访问权限列表 返回有权限的记录ID数组
	static function getRecordAccessList($authId=null,$module='') {
        if(null===$authId)   $authId = $_SESSION[C('USER_AUTH_KEY')];
        if(empty($module))  $module	=	MODULE_NAME;
        //获取权限访问列表
        $accessList = RBAC::getModuleAccessList($authId,$module);
        return $accessList;
	}

    //检查当前操作是否需要认证
    static function checkAccess($ModuleName=MODULE_NAME,$ActionName=ACTION_NAME)
    {
        //如果项目要求认证，并且当前模块需要认证，则进行权限认证
        if( C('USER_AUTH_ON') ){
			$_module	=	array();
			$_action	=	array();
            if("" != C('REQUIRE_AUTH_MODULE')) {
                //需要认证的模块
                $_module['yes'] = explode(',',strtoupper(C('REQUIRE_AUTH_MODULE')));
            }else {
                //无需认证的模块
                $_module['no'] = explode(',',strtoupper(C('NOT_AUTH_MODULE')));
            }
            //检查当前模块是否需要认证
            if((!empty($_module['no']) && !in_array(strtoupper($ModuleName),$_module['no'])) || (!empty($_module['yes']) && in_array(strtoupper($ModuleName),$_module['yes']))) {
				if("" != C('REQUIRE_AUTH_ACTION')) {
					//需要认证的操作
					$_action['yes'] = explode(',',strtoupper(C('REQUIRE_AUTH_ACTION')));
				}else {
					//无需认证的操作
					$_action['no'] = explode(',',strtoupper(C('NOT_AUTH_ACTION')));
				}
				//检查当前操作是否需要认证
				if((!empty($_action['no']) && !in_array(strtoupper($ActionName),$_action['no'])) || (!empty($_action['yes']) && in_array(strtoupper($ActionName),$_action['yes']))) {
					return true;
				}else {
					return false;
				}
            }else {
                return false;
            }
        }
        return false;
    }

	// 登录检查
	static public function checkLogin() {
        //检查当前操作是否需要认证
        if(RBAC::checkAccess()) {
            //检查认证识别号
            if(!$_SESSION[C('USER_AUTH_KEY')]) {
                if(C('GUEST_AUTH_ON')) {
                    // 开启游客授权访问
                    if(!isset($_SESSION['_ACCESS_LIST']))
                        // 保存游客权限
                        RBAC::saveAccessList(C('GUEST_AUTH_ID'));
                }else{
                    // 禁止游客访问跳转到认证网关
                    redirect(PHP_FILE.C('USER_AUTH_GATEWAY'));
                }
            }
        }
        return true;
	}

    //权限认证的过滤器方法
    static public function AccessDecision($ModuleName=MODULE_NAME,$ActionName=ACTION_NAME)
    {
        //检查是否需要认证
        if(RBAC::checkAccess($ModuleName,$ActionName)) {
            //存在认证识别号，则进行进一步的访问决策
			$appName = APP_NAME;
            $accessGuid   =   md5($appName.$ModuleName.$ActionName);
            if(empty($_SESSION[C('ADMIN_AUTH_NAME')])) {
                if(C('USER_AUTH_TYPE')==2) {
                    //加强验证和即时验证模式 更加安全 后台权限修改可以即时生效
                    //通过数据库进行访问检查
                    $accessList = RBAC::getAccessList();
                }else {
                    // 如果是管理员或者当前操作已经认证过，无需再次认证
                    if( $_SESSION[$accessGuid]) {
                        return true;
                    }
                    //登录验证模式，比较登录后保存的权限访问列表
                    $accessList = $_SESSION['_ACCESS_LIST'];
                }
                //判断是否为组件化模式，如果是，验证其全模块名
                $module = defined('P_MODULE_NAME')?  P_MODULE_NAME   :   $ModuleName;
                if(!isset($accessList[strtoupper($module)][strtoupper($ActionName)])) {
                    $_SESSION[$accessGuid]  =   false;
                    return false;
                }
                else {
                    $_SESSION[$accessGuid]	=	true;
                }
            }else{
                //管理员无需认证
				return true;
			}
        }
        return true;
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
    static public function getAccessList($authId=null)
    {
        // Db方式权限数据
        $db     =   Db::getInstance();
		if(null===$authId)   $authId = $_SESSION[C('USER_AUTH_KEY')];
		$table = array('role'=>C('RBAC_ROLE_TABLE'),'user'=>C('RBAC_USER_TABLE'),'access'=>C('RBAC_ACCESS_TABLE'),'node'=>C('RBAC_NODE_TABLE'));
        $access =  array();
            // 读取项目的模块权限
            $sql    =   "select node.id,node.name from ".
                    $table['role']." as role,".
                    $table['user']." as user,".
                    $table['access']." as access,".
                    $table['node']." as node ".
                    "where user.staff_id={$authId} and user.role_id=role.id ".
					"and access.role_id=role.id and role.status=1 ".
					"and access.node_id=node.id and node.pid=0";
           			$modules =   $db->query($sql);
			foreach($modules as $key=>$module) {
				$module     = (array)$module;
				$moduleId   = $module['id'];
				$moduleName = $module['name'];
				$sql = "select node.id, node.name from ".
					$table['role']." as role,".
					$table['user']." as user,".
					$table['access']." as access,".
					$table['node']." as node ".
					"where user.staff_id={$authId} and user.role_id=role.id ".
					"and access.role_id=role.id and role.status=1 ".
					"and access.node_id=node.id ".
					"and node.pid={$moduleId}";
				$rs =   $db->query($sql);
				$action = array();
				foreach ($rs as $a){
					$a	 =	 (array)$a;
					$action[$a['name']] = $a['id'];
				}
				$access[strtoupper($moduleName)] =  array_change_key_case($action,CASE_UPPER);
			}
		return $access;
    }

	// 读取模块所属的记录访问权限
	static public function getModuleAccessList($authId,$module) {
        // Db方式
        $db     =   DB::getInstance();
        $table = array('role'=>C('RBAC_ROLE_TABLE'),'user'=>C('RBAC_USER_TABLE'),'access'=>C('RBAC_ACCESS_TABLE'));
        $sql    =   "select access.node_id from ".
                    $table['role']." as role,".
                    $table['user']." as user,".
                    $table['access']." as access ".
                    "where user.user_id='{$authId}' and user.role_id=role.id and ( access.role_id=role.id  or (access.role_id=role.pid and role.pid!=0 ) ) and role.status=1 and  access.module='{$module}' and access.status=1";
        $rs =   $db->query($sql);
        $access	=	array();
        foreach ($rs as $node){
            $access[]	=	$node['node_id'];
        }
		return $access;
	}
}//end class
?>