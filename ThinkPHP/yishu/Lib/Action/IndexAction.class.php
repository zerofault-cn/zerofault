<?php
class IndexAction extends Action{
	public function index(){
		$dao = D('Category');
		$rs = $dao->where(array('flag'=>array('gt',-1)))->order('flag desc, sort')->select();
		//dump($rs);
		$this->assign('new_cate_sort',$rs[sizeof($rs)-1]['sort']+10);

		$dao = D('Website');
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

	public function cate(){
		$cate_id = $_REQUEST['id'];
		$dao = D('Category');
		$rs = $dao->find($cate_id);
		$this->assign('cate_info', $rs);
		$dao = D('Website');
		$rs = $dao->where(array('cate_id'=>$cate_id, 'flag'=>array('gt',0)))->order('sort')->select();
		
		$this->assign('site_list', $rs);
		$this->display();
	}

	public function site(){
		$site_id = $_REQUEST['id'];
		$dao = D('Website');
		$rs = $dao->find($site_id);

		$dao = D('Category');
		$rs['cate_info'] = $dao->find($rs['cate_id']);
		$this->assign('site_info', $rs);
		$this->display();
	}
}
?>