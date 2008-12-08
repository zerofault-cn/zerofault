<?php
/**
* ActionServer.cls.php
* @copyright bokee dot com
* @version 0.1
*/
require_once('lang/Assert.cls.php');
require_once('mvc/ActionError.cls.php');
require_once('mvc/Cache.cls.php');
require_once('mod/User.cls.php');
require_once('com/Html.cls.php');
/**
* ActionServer
* @version 0.1
*/
class ActionServer {
    
    /**
    * 请求的数据
    * @access public
    */
    var $request = null;
    /**
    * 存放表单提交的数据
    * @access public
    */
    var $form = null;
    /**
    * 返回给用户，用于页面显示的数据
    * @access public
    */
    var $response = null;
    /**
    * ActionError 对象
    * @access public 
    */
    var $actionError = null;
    /**
    * ActionMap 对象
    * @access private
    */
    var $actionMap = null;
    /**
    * forward config 数组
    * @access private
    */
    var $forwardConfig = null;
    /**
    * formBean
    * @access private
    */
    var $formBean = null;
    
    /**
    * 初始化, 主要是初始化请求的内容和映射关系
    * @access public
    * @param ActionMap &$actionMap ActionMap object
    * @param array &$request
    */
    function init( &$actionConfig, $request, $post=null ){
        // 配置映射环境
        $this->actionMap = $actionConfig->getActionMap();
        // 取请求内容
        $this->request = $request;
        // 这里的$_POST,$_REQUEST数据最高是二维的，三维的比较少见，因此没有采用递归方式。
        foreach ($request as $k=>$v){
        	if (is_array($v)){
        		foreach ($v as $kk=>$vv){
        			$this->request[$k][$kk] = urldecode(trim($vv));
        		}
        	}else {
        		$this->request[$k] = urldecode(trim($v));
        	}
        } 
        if (is_array($post)){
			foreach ($post as $k=>$v){
				if (is_array($v)){
					foreach ($v as $kk=>$vv){
						$this->form[$k][$kk] = trim($vv);
					}					
				}else {
					$this->form[$k] = trim($v);
				}
			}
		}
        $u = new User;
        $auth = $u->ValidatePerm($request);
        //log::Append("request:" . print_r($request, true));
        if (!$auth) {
                Html::jump("authError.html");
        }

    }
    /**
    * 处理请求
    * @access public
    */
    function process(){
        
        // 如果需要验证提交的数据，则调用相应的ActionForm::validate()验证数据.
        // 无论验证是否通过，validate()都将返回一个ActionError对象,在这里收到这个对象，
        // 可以调用ActionError->isEmpty()方法，判断是否有错误发生.
        // 这个 ActionError 对象将会传递给 Action子类对象.
        // Action::exec 进行事务操作，并取到相应的数据用户页面显示，根据结果交给指定的
        // tpl进行处理，并输出页面
        
        // -------- 进行第一阶段的缓存处理 ---------
        // 主要任务：
        // 判断是否属于自动更新的 path，如果否，则使用缓存，如果是则继续
        // 根据 path 确定 cacheTime
        // 判断缓存是否过期，否,则使用缓存,是，则继续
        $cache = new Cache($this->actionMap,PATH_PAGE_CACHE);
        $cache->setCurrentUri( ereg_replace('&cacheRefresh=/\d/','',$_SERVER['REQUEST_URI']) );
        // 判断是否要求执行强制刷新，如果是设置 cache 的状态 为强制刷新（1）
        if ( array_key_exists('cacheRefresh',$this->request) ){
            // 根据cacheRefresh的,设置状态值
            $cache->setDemand($this->request['cacheRefresh']);
            $cache->start();
        } else {
            // 判断是否使用缓存
            if ( $cache->isUse() ){
                // y ， 判断缓存是否存在，判断缓存是否过期
                if ( $cache->isExist() && !$cache->isExpire()){
                    // y( 文件存在，并没过期 ) ，使用缓存输出页面，并中止程序的执行
                    $cache->open();
                    $cache->output();
                    return;
                } else {
                    // n( 文件不存在，或者已经过期 ) ， 设置状态要求值为刷新
                    $cache->setDemand(1);
                    $cache->start();
                }
            } else {
                // n ， 设置 cache 的状态为关闭（0），即不需要使用缓存
                $cache->setDemand(0);
            }
        }
        // -------- 第一阶段的缓存处理结束 ---------
        
        // validate form 
        if ($this->actionMap->getProp('validate') === true 
            && $this->form != null) {
            $this->formBean = $this->actionMap->getBean();
            Assert::condition(!empty($this->formBean),'FormBean is\'t defined');
//            Assert::condition(file_exists(PATH_CLASS.'/'.$this->formBean['type'].'.cls.php'),
//                              'FormBean class file '.$this->formBean['type'].
//                              '.cls.php does not exists');
        	include_once($this->formBean['type'].'.cls.php');
        	$bean = new $this->formBean['type'];
        	$this->actionError = $bean->validate($this->request,$this->form);
        }
    	if ($this->actionError == null){
    	    $this->actionError = new ActionError();
    	}
       
        // process action
        $className = $this->actionMap->getProp('type');
        Assert::condition($className != null,'className is empty at '.__CLASS__ . 
                          ' ' .__FILE__.' '.__LINE__);
//        Assert::condition(file_exists(PATH_CLASS.'/'.$className.'.cls.php'),
//                          'File '.$className.'.cls.php does nnot exists');

        include_once($className.'.cls.php');
        $action = new $className;
        $this->forwardConfig = $action->execute($this->actionMap,$this->actionError,
                                                $this->request,$this->response,
                                                $this->form);
        if ($this->forwardConfig == null){
            $response =& $this->response;
//            Assert::condition(file_exists(PATH_TPL.'/'.$this->actionMap->getProp('input')),
//                              'TPL file '.$this->actionMap->getProp('input').
//                              ' does not exists');
            $response =& $this->response;
            $response['action_error'] = $this->actionError == null ? 
                                        null : $this->actionError->getAllProp();
            $input_file_name = $this->actionMap->getProp('input');
            if( !empty( $input_file_name ) )
            {
            	include_once($input_file_name);
            }
        }
        // dispatch
        // 处理tpl
        
        // 如果是重定向到其他已声明页面
        elseif ($this->forwardConfig['redirct']===true) {
        	// 只有使用Html::jump() 或者 JS::jump()
        	//JS::jump($this->forwardConfig['path']);
        	// include_once('com/JS.cls.php');
        	
        	
        	$jumpParam = '';
        	if (array_key_exists('parameters', $this->forwardConfig) 
        	   && is_array($this->forwardConfig['parameters']) 
        	   && count($this->forwardConfig['parameters']>0)) {
        	   
        	   // 添加参数
        	   foreach ($this->forwardConfig['parameters'] as $k=>$v){
        	       $jumpParam .= '&'.$k.'='.$v;
        	   }
        	   if (strstr($this->forwardConfig['path'],'?') == false){
        	       $jumpParam = '?jump=1'.$jumpParam;
        	   }
        	}
        	Html::jump($this->forwardConfig['path'].$jumpParam);
        } 
        // 如果是重定向到没有声明的页面
        elseif ( is_string($this->forwardConfig) ){
            Html::jump($this->forwardConfig);
        }
        else {
            $response =& $this->response;
            $response['action_error'] = $this->actionError == null ? 
                                        null : $this->actionError->getAllProp();
            include_once($this->forwardConfig['path']);
        }
        // --------------- 进行第二阶段的缓存处理 ----------------
        // 主要任务：
        // 输出缓存，生成缓存文件
        if ( 0 !=  $cache->demand ){
            $cache->stop();
            $cache->save();
        }
        if ( DEBUG ){
            print 'Cache State:'.$cache->demand.'; ';
        }
        // --------------- 第二阶段的缓存处理结束 ----------------
    }
}
?>
