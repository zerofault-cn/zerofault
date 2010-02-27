<?php
class FeedbackAction extends BaseAction{
	public function index(){
		//右侧分类列表
		$base['status'] = array('gt', 0);
		$order = 'sort';
		$category_list = M('Category')->where($base)->order($order)->select();
		$this->assign('category_list',$category_list);

		$this->assign('content','index');
		$this->display('Layout:Index_layout');
	}
	public function get_feedback(){
		$dao = M('Feedback');
		$where['status'] = 1;
		$order = 'id desc';
		$count = $dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$p = new Paginator($count,5);
		$rs = $dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();

		foreach($rs as $item){
			echo '<dt><i>'.$item['addtime'].'</i>'.(''==$item['nickname']?'匿名网友':$item['nickname']).'</dt>';
			echo '<dd>'.nl2br($item['message']).'</dd>';
			echo '<dd style="padding-left:30px"><fieldset style="border:1px dashed red;"><legend style="color:red;">管理员回复</legend>'.nl2br($item['reply']).'</fieldset></dd>';
		}
		echo '<div style="padding-top:10px;">'.$p->showJsNavi().'</div>';
	}

	public function submit() {
		if (!empty($_POST['submit'])) {
			if($_SESSION['verify']!=md5(trim($_REQUEST['verify']))) {
				self::_error('验证码错误!');
			}
			$data = array(
				'nickname' => trim($_REQUEST['nickname']),
				'email'    => trim($_REQUEST['email']),
				'subject'  => trim($_REQUEST['subject']),
				'message'  => trim($_REQUEST['message']),
				'ip'       => $_SERVER['REMOTE_ADDR'],
				'addtime'  => date('Y-m-d H:i:s'),
				'status'   => 0
				);

			if (''==$data['nickname']) {
				self::_error('请输入您的昵称！');
			}
			if (strlen($data['message'])<4) {
				self::_error('留言内容太短！');
			}
			if (M('Feedback')->add($data)) {
				self::_success('感谢您的热心支持，请等待审核!');
			}
			else {
				self::_error('提交失败');
			}
		}
	}
}
?>