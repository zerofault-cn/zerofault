<?php
/**
*
* 节点管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class NodeAction extends BaseAction{
	protected $dao;
	
	public function _initialize() {
		$this->dao = D('Node');
		parent::_initialize();
	}

	public function index(){
		$base_class = 'BaseAction';
		$base_obj   = new $base_class;
		$base_method_arr = get_class_methods($base_obj);
		//不需进入节点管理的module
		$skip_modules = C('NOT_AUTH_MODULE');
		$skip_modules[] = 'Base';

		$modules = array();
		$i = 0;
		
		$dir = LIB_PATH.'Action/';
		foreach (glob($dir.'*.php') as $file) {
			if(!is_file($file)) {
				continue;
			}
			$file = basename($file);
			$class_name = substr($file,0,-10);
			$module_name = substr($file,0,-16);
			if(in_array($module_name, $skip_modules)) {
				continue;
			}
			$where['name'] = $module_name;
			$where['pid']  = 0;
			$module = $this->dao->where($where)->find();
			$modules[$i] = $module ? $module : array(
				'id'=>0,
				'name'=>$module_name,
				'title'=>''
				);

			$obj = new $class_name;
			$obj_method = array_diff(get_class_methods($obj),$base_method_arr);
			if(empty($obj_method)) {
				$modules[$i]['action'][] = array('title'=>'*');
			}
			foreach($obj_method as $action_name) {
				if(empty($module)) {
					$modules[$i]['action'][] = array(
						'id'=>0,
						'name'=>$action_name,
						'title'=>''
						);
				}
				else {
					$where['name'] = $action_name;
					$where['pid']  = $module['id'];
					$action = $this->dao->where($where)->find();
					
					$modules[$i]['action'][] = $action ? $action : array(
						'id'=>0,
						'name'=>$action_name,
						'title'=>''
						);
				}
			}
			$i++;
		}
		//dump($modules);
		//Session::set('top', 'System');//top由最后一个Action来决定
		Session::set('sub', 'Node');
		$this->assign('MODULE_TITLE', 'System Node');
		$this->assign('ACTION_TITLE', 'Definition');
		$this->assign('modules', $modules);
		$this->assign('content','Node:index');
		$this->display('Layout:ERP_layout');
	}

	public function update() {
		$id   = intval($_REQUEST['id']);
		$pid  = intval($_REQUEST['pid']);
		$name = $_REQUEST['name'];
		$title= $_REQUEST['title'];

		$data['pid']  = $pid;
		$data['name'] = $name;
		$data['title']= $title;
		if($id>0) {
			//已有纪录
			$data['id'] = $id;
			if(false !== $this->dao->save($data)) {
				die('1:'.$id);
			}
			else {
				die('Save fail!');
			}
		}
		else {
			//新建纪录
			if($id=$this->dao->add($data)) {
				die('1:'.$id);
			}
			else {
				die('Add fail');
			}
		}
	}
}
?>