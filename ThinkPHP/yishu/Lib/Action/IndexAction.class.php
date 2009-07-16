<?php
class IndexAction extends Action{
	public function index(){
		if(S('list')) {
			$list = S('list');
			$hot_list = S('hot_list');
			$mark_list = S('mark_list');
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
				$limit = 5;
				$rs2 = $dao->where($where)->order($order)->limit($limit)->select();
				!$rs2 && $rs2 = array();
				foreach($rs2 as $key2=>$val2){
					$list[$val['id']]['site_list'][$val2['id']] = $val2;
				}
			}
			$hot_list = $dao->where(array('flag'=>array('gt',0)))->order('view desc')->limit(10)->select();
			$mark_list = $dao->where(array('flag'=>array('gt',0),'mark'=>array('gt',0)))->limit(12)->select();
			S('list',$list);
			S('hot_list',$hot_list);
			S('mark_list',$mark_list);
		}
	//	dump($list);
		$this->assign('hot_list', $hot_list);
		$this->assign('mark_list', $mark_list);
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
		$dao->view = array('exp','(view+1)');
		$dao->save();

		$rs['thumb'] = self::get_thumb($rs['url']);
		
		$dao = D('Vote');
		$tmp_rs = $dao->where(array('site_id'=>$site_id))->getFields('vote');
		$rs['vote_count'] = sizeof($tmp_rs);
		$rs['vote'] = sprintf("%.1f", array_sum($tmp_rs) / sizeof($tmp_rs));
		$rs['vote_width'] = 10*floor($rs['vote']);
		

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
	public function vote(){
		$site_id = $_REQUEST['site_id'];
		$vote = $_REQUEST['vote'];

		$dao = D('Vote');
		$data['site_id'] = $site_id;
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['addtime'] = array('lt',date("Y-m-d",time()+86400));
		$rs = $dao->where($data)->find();
		if($rs && sizeof($rs)>0){
			die('-1');
		}
		$data['site_id'] = $site_id;
		$data['vote'] = $vote;
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['addtime'] = date("Y-m-d H:i:s");
		$data['session'] = '';
		if($dao->add($data)) {
			$tmp_rs = $dao->where(array('site_id'=>$site_id))->getFields('vote');
			$vote_count = sizeof($tmp_rs);
			$vote = sprintf("%.1f", array_sum($tmp_rs) / $vote_count);
			$vote_width = 10*floor($vote);
			die($vote_count.'|'.$vote.'|'.$vote_width);
		}
		else{
			die('0');
		}
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
	public function get_comment(){
		header("Content-Type:text/html; charset=utf-8");
		$dao = D('Comment');
		$where['site_id'] = $_REQUEST['site_id'];
		$where['flag'] = array('gt',0);
		$order = 'id desc';
		$count = $dao->where($where)->getField('count(*)');

		import("ORG.Util.Page");
		$listRows = 10;
		$p = new Page($count, $listRows);
		$rs = $dao->where($where)->order($order)->limit($p->firstRow.','.$p->listRows)->select();

		foreach($rs as $item){
			echo '<dt>'.(''==$item['name']?'匿名':$item['name']).' 发表于 '.$item['addtime'].'</dt>';
			echo '<dd>'.nl2br($item['content']).'</dd>';
		}
	}
	public function add_comment() {
		header("Content-Type:text/html; charset=utf-8");
		if($_SESSION['verify']!=md5(trim($_REQUEST['verify']))) {
			die('<script>parent.myAlert("验证码错误!");</script>');
		}
		$dao = D('Comment');
		$data['site_id'] = $_REQUEST['site_id'];
		$data['content'] = $_REQUEST['content'];
		$data['name'] = $_REQUEST['name'];
		$data['email'] = $_REQUEST['email'];
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['addtime'] = date("Y-m-d H:i:s");
		$data['flag'] = 1;
		if($dao->add($data)) {
			die('<script>parent.myAlert("发表成功");parent.myOK(1200);parent.get_comment(0);</script>');
		}
		else{
			die('<script>parent.myAlert("发生错误啦，请稍后再试！");</script>');
		}
	}
	public function get_thumb($url) {
		import("@.AppSTW");

		$args["Size"] = "xlg";

		if (isset($_POST["Size"]) && $_POST["Size"])
			$args["Size"] = $_POST["Size"];
		if (isset($_POST["xmax"]) && $_POST["xmax"])
			$args["xmax"] = $_POST["xmax"];
		if (isset($_POST["ymax"]) && $_POST["ymax"])
			$args["ymax"] = $_POST["ymax"];
		if (isset($_POST["scale"]) && $_POST["scale"])
			$args["scale"] = $_POST["scale"];
		if (isset($_POST["full"]) && $_POST["full"])
			$args["full"] = 1;
		if (isset($_POST["embed"]) && $_POST["embed"])
			$args["embed"] = $_POST["embed"];

	//	showImage("Direct Call Example", AppSTW::queryRemoteThumbnail($url, $args, true));
	//	showImage("Cached Call Example", AppSTW::getThumbnail($url, $args));
	//	showImage("Large Scaled Image", AppSTW::getLargeThumbnail($url, true, true));
	//	showImage("Small Scaled Image", AppSTW::getSmallThumbnail($url, true, true));
	//	showImage("Scaled Image", AppSTW::getScaledThumbnail($url, 640, 480));
		return AppSTW::queryRemoteThumbnail($url, $args, false);
	}

}
?>