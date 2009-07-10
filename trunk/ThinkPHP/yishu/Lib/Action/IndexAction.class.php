<?php
class IndexAction extends Action{
	public function index(){
		if(S('list')) {
			$list = S('list');
		}
		else {
			$dao = D('Category');
			$where['flag'] = array('gt', 0);
			$order = 'sort';
			$rs = $dao->where($where)->order($order)->select();
			!$rs && $rs = array();
			$dao = D('Website');
			foreach($rs as $key=>$val){
				$list[$val['id']] = $val;
				$list[$val['id']]['site_list'] = array();
				$where['cate_id'] = $val['id'];
				$where['flag'] = array('gt', 0);
				$order = 'sort';
				$rs2 = $dao->where($where)->order($order)->select();
				!$rs2 && $rs2 = array();
				foreach($rs2 as $key2=>$val2){
					$list[$val['id']]['site_list'][$val2['id']] = $val2;
				}
			}
			S('list',$list);
		}
	//	dump($list);
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

		$this->assign('content','cate');
		$this->display('Layout:List_layout');
	}

	public function site(){
		$site_id = $_REQUEST['id'];
		$dao = D('Website');
		$rs = $dao->find($site_id);

		$dao = D('Category');
		$rs['cate_info'] = $dao->find($rs['cate_id']);
		
		$dao = D('Comment');
		$where['site_id'] = $site_id;
		$where['flag'] = array('gt', 0);
		$rs['comment_list'] = $dao->where($where)->select();

		$this->assign('site_info', $rs);
		$this->assign('content','site');
		$this->display('Layout:List_layout');
	}
	public function goto(){
		$site_id = $_REQUEST['id'];
		$dao = D('Website');
		$rs = $dao->find($site_id);
		$dao->hit = array('exp','(hit+1)');
		$dao->save();
		redirect($rs['url']);
	}
	public function verify() {
		import("ORG.Util.Image");
		Image::buildImageVerify(); 
	}
	public function comment_add() {
		header("Content-Type:text/html; charset=utf-8");
		if($_SESSION['verify']!=md5(trim($_REQUEST['verify']))) {
			die('<script>parent.alert("验证码错误!");</script>');
		}
		$dao = D('Comment');
		$data['site_id'] = $_REQUEST['site_id'];
		$data['content'] = $_REQUEST['content'];
		$data['user_id'] = 0;
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['addtime'] = date("Y-m-d H:i:s");
		$data['flag'] = 1;
		if($dao->add($data)) {
			header("Content-Type:text/html; charset=utf-8");
			die('<script>parent.alert("发表成功");parent.location.href=parent.location.href;</script>');
		}
		else{
			header("Content-Type:text/html; charset=utf-8");
			die('<script>parent.alert("发生错误啦，请稍后再试！");</script>');
		}
	}

}
?>