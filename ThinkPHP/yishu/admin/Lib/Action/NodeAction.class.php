<?php
class NodeAction extends PublicAction{
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
		$dNode = D('Node');
		//获取App节点
		$where['pid'] = 0;
		$rs_app = $dNode->where($where)->select();
		$n1=$n2=$n3=0;
		$nodes = array();
		if(!$rs_app){
			$rs_app = array();
		}
		foreach($rs_app as $node){
			$nodes[$n1] = array(
				'info' => array(
					'id'    => $node['id'],
					'name'  => $node['name'],
					'title' => $node['title'],
					'descr' => $node['descr'],
					'status'=> $node['status'],
					),
				'count'  => 0,
				'module' => array()
				);
			//获取Module节点
			$where['pid'] = $node['id'];
			$rs_module = $dNode->where($where)->select();
			if(!$rs_module){
				//未定义Module节点
				$rs_module = array();
				$nodes[$n1]['count'] = 1;
				$nodes[$n1]['module'][$n2] = array(
					'info' => array(
						'title' => '*',
						),
					'count' => 1,
					'action'=> array(
						array(
							'title' => '*'
							)
						)
					);
			}
			foreach($rs_module as $node){
				$nodes[$n1]['module'][$n2] = array(
					'info' => array(
						'id'    => $node['id'],
						'name'  => $node['name'],
						'title' => $node['title'],
						'descr' => $node['descr'],
						'status'=> $node['status'],
						),
					'count'  => 0,
					'action' => array()
					);
				//获取Action节点
				$where['pid'] = $node['id'];
				$rs_action = $dNode->where($where)->select();
				if(!$rs_action){
					$rs_action = array();
					$nodes[$n1]['count'] += 1;
					$nodes[$n1]['module'][$n2]['count'] += 1;
					$nodes[$n1]['module'][$n2]['action'][$n3] = array(
						'title'  => '*'
						);
				}
				foreach($rs_action as $node){
					$nodes[$n1]['count'] += 1;
					$nodes[$n1]['module'][$n2]['count'] += 1;
					$nodes[$n1]['module'][$n2]['action'][$n3] = array(
						'id'    => $node['id'],
						'name'  => $node['name'],
						'title' => $node['title'],
						'descr' => $node['descr'],
						'status'=> $node['status'],
						);
					$n3++;
				}
				$n2++;
			}
			$n1++;
		}
		//echo '<pre>';
		//print_r($nodes);
		//echo '</pre>';


		$this->assign("topnavi",$topnavi);
		$this->assign('list',$nodes);
		$this->assign('content','Node:index');
		$this->display('Layout:Admin_layout');
	}

}
?>