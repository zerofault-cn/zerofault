<?php
class IndexAction extends Action{
	public function index(){
		$dao = D('category');
		$rs = $dao->where(array('flag'=>array('gt',-1)))->order('flag desc, sort')->select();
		//dump($rs);
		$this->assign('new_cate_sort',$rs[sizeof($rs)-1]['sort']+10);

		$dao = D('website');
		foreach($rs as $key=>$val){
			$list[$val['id']] = $val;
			$list[$val['id']]['site_list'] = array();
			$list[$val['id']]['new_site_sort'] = 10;
			$rs2 = $dao->where(array('cate_id'=>$val['id'],'flag'=>array('gt',-1)))->order('flag desc, sort')->select();
			foreach($rs2 as $key2=>$val2){
				$list[$val['id']]['site_list'][$val2['id']] = $val2;
				$list[$val['id']]['new_site_sort'] = $val2['sort']+10;
			}
		}
		//dump($list);
		$this->assign('list',$list);
		$this->display();
	}
	public function loader(){
		$this->display();
	}
}
?>