<?php
class IndexAction extends BaseAction{

	public function index(){
		$this->assign('MODULE_NAME', MODULE_NAME);
		$this->assign('MODULE_TITLE', '首页');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}


	public function cate(){
		$cate_id = $_REQUEST['id'];
		$dCategory = M('Category');
		$cate_info = $dCategory->find($cate_id);
		$this->assign('cate_info', $cate_info);

		$dWebsite = M('Website');
		$where['cate_id'] = $cate_id;
		$where['status'] = array('gt',0);
		$count = $dWebsite->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);
		//$p->setConfig('show_num',7);//设定连续显示的页码个数，这里使用默认值7
		//$p->setConfig('side_num',2);//设定两遍保留显示的页码个数，这里使用默认值2
		$p->setConfig('first','<img src="'.APP_PUBLIC_PATH.'/Images/first.gif" align="absbottom" alt="First"/>');
		$p->setConfig('prev','<img src="'.APP_PUBLIC_PATH.'/Images/prev.gif" align="absbottom" alt="Prev"/>');
		$p->setConfig('next','<img src="'.APP_PUBLIC_PATH.'/Images/next.gif" align="absbottom" alt="Next"/>');
		$p->setConfig('last','<img src="'.APP_PUBLIC_PATH.'/Images/last.gif" align="absbottom" alt="Last"/>');

		$site_list = $dWebsite->where(array('cate_id'=>$cate_id, 'status'=>array('gt',0)))->order('sort')->limit($p->offset.','.$p->limit)->select();
		$this->assign('page', $p->showMultiNavi());
		$this->assign('site_list', $site_list);

		$base['status'] = array('gt', 0);
		$order = 'sort';
		$category_list = $dCategory->where($base)->order($order)->select();
		$this->assign('category_list',$category_list);

		$where = $base + array('cate_id'=>$cate_id);
		$hot_list = $dWebsite->where($where)->order('view desc')->limit(10)->select();
		$new_list = $dWebsite->where($where)->order('id desc')->limit(10)->select();
		$this->assign('hot_list', $hot_list);
		$this->assign('new_list', $new_list);

		$this->assign('content','cate');
		$this->display('Layout:Index_layout');
	}

	public function site(){
		$site_id = $_REQUEST['id'];

		$dWebsite = M('Website');
		$site_info = $dWebsite->find($site_id);
		$dWebsite->view = array('exp','(view+1)');
		$dWebsite->save();

		$site_info['vote_count'] = M('Vote')->where(array('site_id'=>$site_id))->count();
		$site_info['vote'] = sprintf("%.1f", M('Vote')->where(array('site_id'=>$site_id))->avg('vote'));
		$site_info['vote_width'] = 10*floor($site_info['vote']);

		$dCategory = M('Category');
		$site_info['cate_info'] = $dCategory->find($site_info['cate_id']);
		$this->assign('site_info', $site_info);

		$base['status'] = array('gt', 0);
		$order = 'sort';
		$category_list = $dCategory->where($base)->order($order)->select();
		$this->assign('category_list',$category_list);

		$where = $base + array('cate_id'=>$site_info['cate_id']);
		$hot_list = $dWebsite->where($where)->order('view desc')->limit(10)->select();
		$new_list = $dWebsite->where($where)->order('id desc')->limit(10)->select();
		$this->assign('hot_list', $hot_list);
		$this->assign('new_list', $new_list);

		$this->assign('content','site');
		$this->display('Layout:Index_layout');
	}
	public function vote(){
		$site_id = $_REQUEST['site_id'];
		$vote = $_REQUEST['vote'];

		$dao = M('Vote');
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
			$tmp_rs = $dao->where(array('site_id'=>$site_id))->field('vote')->select();
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
		$dao = M('Website');
		$rs = $dao->find($site_id);
		$dao->hit = array('exp','(hit+1)');
		$dao->save();
		redirect($rs['url']);
	}
	public function verify() {
		import("@.Image");
		Image::buildImageVerify();
	}
	public function get_comment(){
		$dao = M('Comment');
		$where['site_id'] = $_REQUEST['site_id'];
		$where['status'] = array('gt',0);
		$order = 'id desc';
		$count = $dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$p = new Paginator($count,5);
		$rs = $dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();

		foreach($rs as $item){
			echo '<dt><i>'.$item['addtime'].'</i>'.(''==$item['name']?'匿名':$item['name']).'</dt>';
			echo '<dd>'.nl2br($item['content']).'</dd>';
		}
		echo $p->showJsNavi();
	}
	public function add_comment() {
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
		$data['status'] = 1;
		if($dao->add($data)) {
			die('<script>parent.myAlert("发表成功");parent.myOK(1500);parent.get_comment(0);</script>');
		}
		else{
			die('<script>parent.myAlert("'.$_REQUEST['verify'].'发生错误啦，请稍后再试！");</script>');
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