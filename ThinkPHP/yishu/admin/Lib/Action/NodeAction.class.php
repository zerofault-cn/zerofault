<?php
class NodeAction extends BaseAction{
	/**
	*
	* 节点列表
	*/
	public function index(){
		$topnavi[]=array(
			'text'=> '节点管理',
			'url' => __APP__.'/Node/'
			);
		$topnavi[]=array(
			'text'=> '节点列表',
			);

		$base_class = 'BaseAction';
		$base_obj   = new $base_class;
		$base_method_arr = get_class_methods($base_obj);

		$dNode = D('Node');
		$where['name'] = APP_NAME;
		$where['pid'] = 0;
		$app = $dNode->where($where)->find();
		if(empty($app)) {
			$app = array(
				'id' => 0,
				'name'=>APP_NAME,
				'title'=>'',
				'descr'=>''
				);
		}
		$modules = array();
		$i = 0;
		
		$dir = LIB_PATH.'Action/';
		$handle=opendir($dir);
		while($file=readdir($handle))
		{
			if(!is_file($dir.$file)) {
				continue;
			}
			$class_name = substr($file,0,-10);
			if($class_name == $base_class) {
				continue;
			}
			$module_name = substr($class_name,0,-6);
			if(empty($app['id'])) {
				$modules[$i] = array(
					'id'=>0,
					'name'=>$module_name,
					'title'=>'',
					'descr'=>''
					);
			}
			else {
				$where['name'] = $module_name;
				$where['pid']  = $app['id'];
				$module = $dNode->where($where)->find();
				$modules[$i] = $module ? $module : array(
					'id'=>0,
					'name'=>$module_name,
					'title'=>'',
					'descr'=>''
					);
			}

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
						'title'=>'',
						'descr'=>''
						);
				}
				else {
					$where['name'] = $action_name;
					$where['pid']  = $module['id'];
					$action = $dNode->where($where)->find();
					
					$modules[$i]['action'][] = $action ? $action : array(
						'id'=>0,
						'name'=>$action_name,
						'title'=>'',
						'descr'=>''
						);
				}
			}
			$i++;
		}
		//dump($modules);

		$this->assign("topnavi", $topnavi);
		$this->assign('app', $app);
		$this->assign('modules', $modules);
		$this->assign('content','Node:index');
		$this->display('Layout:Admin_layout');
	}

	public function update() {
		$id   = intval($_REQUEST['id']);
		$pid  = intval($_REQUEST['pid']);
		$name = $_REQUEST['name'];
		$title= $_REQUEST['title'];
		$descr= $_REQUEST['descr'];
		$level= intval($_REQUEST['level']);

		$dNode = D('Node');

		$data['pid']  = $pid;
		$data['name'] = $name;
		$data['title']= $title;
		$data['descr']= $descr;
		$data['level']= $level;
		if($id>0) {
			//已有纪录
			$data['id'] = $id;
			if($dNode->save($data)) {
				die('1:'.$id);
			}
			else {
				die('sql:'.$dao->getLastSql());
			}
		}
		else {
			//新建纪录
			if($id=$dNode->add($data)) {
				die('1:'.$id);
			}
			else {
				die('sql:'.$dao->getLastSql());
			}
		}
	}
}
?>