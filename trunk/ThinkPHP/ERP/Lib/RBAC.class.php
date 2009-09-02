<?php
// +----------------------------------------------------------------------
// | ThinkPHP
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
 * 基于角色的验证类
 +------------------------------------------------------------------------------
 * @category   ORG
 * @package  ORG
 * @subpackage  RBAC
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
class RBAC extends Base
{

    //委托身份认证方法
    static function authenticate($map,$model='',$provider='')
    {
        //调用委托管理器进行身份认证
        include_once dirname(__FILE__).'/ProviderManager.class.php';
        if(empty($provider)) {
            $provider	=	C('USER_AUTH_PROVIDER');
        }
        if(empty($model)) {
            $model	=	C('USER_AUTH_MODEL');
        }
        $authProvider   =   ProviderManager::getInstance($provider);
        //使用给定的Map进行认证
        if($authProvider->authenticate($map,$model)) {
            $authInfo   =   $authProvider->data;
            return $authInfo;
        }else {
            //认证失败
            return false;
        }
    }

    //用于检测用户权限的方法,并保存到Session中
    static function saveAccessList($authId=null)
    {
        // 如果使用普通权限模式，保存当前用户的访问权限列表
        // 对管理员开发所有权限
        if(C('USER_AUTH_TYPE') !=2 && !$_SESSION[C('ADMIN_AUTH_KEY')] ) {
            $_SESSION['_ACCESS_LIST']	=	RBAC::getAccessList($authId);
        }
        return ;
    }

    // 获取决策访问管理方式
    private static function getAccessDecsionManager($type) {
        $class = ucwords($type).'AccessDecisionManager';
        if(is_file(dirname(__FILE__).'/'.$class.'.class.php')) {
            include_once dirname(__FILE__).'/'.$class.'.class.php';
            $accessManager = new $class();
            return $accessManager;
        }else{
            throw_exception(L('系统暂时不支持决策管理方式: ') .$type);
        }
    }

    //取得用户的授权列表
    static function getAccessList($authId=null,$type='')
    {
        if(null===$authId) {
            $authId = $_SESSION[C('USER_AUTH_KEY')];
        }
        if(empty($type)) {
            $type = C('USER_AUTH_DECISION');
        }
        //获取权限访问列表
        $accessManager  =  RBAC::getAccessDecsionManager($type);
        $accessList = $accessManager->getAccessList($authId);
        return $accessList;
    }

	// 取得模块的所属记录访问权限列表 返回有权限的记录ID数组
	static function getRecordAccessList($authId=null,$module='',$type='') {
        if(null===$authId) {
            $authId = $_SESSION[C('USER_AUTH_KEY')];
        }
        if(empty($module)) {
            $module	=	MODULE_NAME;
        }
        if(empty($type)) {
            $type = C('USER_AUTH_DECISION');
        }
        //获取权限访问列表
        $accessManager  =  RBAC::getAccessDecsionManager($type);
        $accessList = $accessManager->getModuleAccessList($authId,$module);
        return $accessList;
	}

    //检查当前操作是否需要认证
    static function checkAccess()
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
            if((!empty($_module['no']) && !in_array(strtoupper(MODULE_NAME),$_module['no'])) || (!empty($_module['yes']) && in_array(strtoupper(MODULE_NAME),$_module['yes']))) {
				if("" != C('REQUIRE_AUTH_ACTION')) {
					//需要认证的操作
					$_action['yes'] = explode(',',strtoupper(C('REQUIRE_AUTH_ACTION')));
				}else {
					//无需认证的操作
					$_action['no'] = explode(',',strtoupper(C('NOT_AUTH_ACTION')));
				}
				//检查当前操作是否需要认证
				if((!empty($_action['no']) && !in_array(strtoupper(ACTION_NAME),$_action['no'])) || (!empty($_action['yes']) && in_array(strtoupper(ACTION_NAME),$_action['yes']))) {
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
	static function checkLogin() {
        //检查当前操作是否需要认证
        if(RBAC::checkAccess()) {
            //检查认证识别号
            if(!$_SESSION[C('USER_AUTH_KEY')]) {
                if(C('GUEST_AUTH_ON')) {
                    // 开启游客授权访问
                    if(!isset($_SESSION['_ACCESS_LIST'])) {
                        // 保存游客权限
                        RBAC::saveAccessList(C('GUEST_AUTH_ID'));
                    }
                }else{
                    // 禁止游客访问跳转到认证网关
                    redirect(PHP_FILE.C('USER_AUTH_GATEWAY'));
                }
            }
        }
        return true;
	}

    //权限认证的过滤器方法
    static function AccessDecision($appName=APP_NAME)
    {
        //检查是否需要认证
        if(RBAC::checkAccess()) {
            //存在认证识别号，则进行进一步的访问决策
            $accessGuid   =   md5($appName.MODULE_NAME.ACTION_NAME);
            if(empty($_SESSION[C('ADMIN_AUTH_KEY')])) {
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
                $module = defined('C_MODULE_NAME')?  C_MODULE_NAME   :   MODULE_NAME;
                if(!isset($accessList[strtoupper($appName)][strtoupper($module)][strtoupper(ACTION_NAME)])) {
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
}//end class
?>