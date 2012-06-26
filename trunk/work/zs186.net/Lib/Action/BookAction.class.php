<?php
class BookAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Book');
		parent::_initialize();
	}

	public function index() {
	}

	public function confirm() {
		if (empty($_POST)) {
			//非iframe
			$_REQUEST = Session::getLocal('request');
			$this->assign('request', $_REQUEST);
			$this->assign('category', M('Category')->find(intval($_REQUEST['category_id'])));
			$this->assign('region', M('Region')->where('id='.$_REQUEST['region_id'])->getField('name'));
			if (!empty($_REQUEST['hotel_id'])) {
				$this->assign('hotel', D('Hotel')->relation(true)->find(intval($_REQUEST['hotel_id'])));
			}
			$this->assign('content', ACTION_NAME);
			$this->display('Layout:main');
		}
		else {
			//iframe动作
			$hotel_id = intval($_REQUEST['hotel_id']);
			if (empty($hotel_id)) {
				$region_id = intval($_REQUEST['region_id']);
				empty($region_id) && self::_error('请先选择区域！', 'book_message_box');

				$keyword = trim($_REQUEST['keyword']);
				(empty($keyword) || '如：桃花岭饭店'==$keyword) && self::_error('请输入酒店关键字！', 'book_message_box');
			}
			else {
				$region_id = M('Hotel')->where('id='.$hotel_id)->getField('region_id');
				$_REQUEST['region_id'] = $region_id;
			}
			
			$begin_date = trim($_REQUEST['begin_date']);
			empty($begin_date) && self::_error(('meeting'==$alias?'入住':'宴会').'日期必须填写！', 'book_message_box');
			if (isset($_REQUEST['end_date'])) {
				$end_date = trim($_REQUEST['end_date']);
				empty($end_date) && self::_error('退房日期必须填写！', 'book_message_box');
			}
			
			$alias = trim($_REQUEST['alias']);
			$number = intval($_REQUEST['number']);
			empty($number) && self::_error(('meeting'==$alias?'会议人数':'宴会桌数').'必须填写！', 'book_message_box');
			Session::setLocal('request', $_REQUEST);
			die('<script>parent.location=document.location;</script>');
		}
	}
	public function query() {
		//根据酒店关键字查询酒店ID
		$category_id = intval($_REQUEST['category_id']);
		$region_id = intval($_REQUEST['region_id']);
		$keyword = trim($_REQUEST['keyword']);
		$where = "category_id=".$category_id." and status>0 and (name like '%".$keyword."%' or address like '%".$keyword."%')";
		!empty($region_id) && ($where .= " and region_id=".$region_id);
		$rs = D('Hotel')->relation(true)->where($where)->select();
		empty($rs) && ($rs = array());
		die(json_encode($rs));
	}

	public function submit() {
		if (empty($_POST)) {
			return ;
		}
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('请填写您的姓名称呼！');
		$phone = trim($_REQUEST['phone']);
		empty($phone) && self::_error('请填写您的联系电话！');

		
		$this->dao->category_id = intval($_REQUEST['category_id']);
		$this->dao->region_id = intval($_REQUEST['region_id']);
		$this->dao->hotel_id = intval($_REQUEST['hotel_id']);
		$this->dao->hotel_keyword = empty($_REQUEST['keyword'])?'':trim($_REQUEST['keyword']);
		$this->dao->begin_date = empty($_REQUEST['begin_date'])?date('Y-m-d'):$_REQUEST['begin_date'];
		$this->dao->end_date = empty($_REQUEST['end_date'])?'0000-00-00':$_REQUEST['end_date'];
		$this->dao->number = intval($_REQUEST['number']);
		$this->dao->level = empty($_REQUEST['level'])?'':$_REQUEST['level'];
		$this->dao->name = trim($_REQUEST['name']);
		$this->dao->phone = trim($_REQUEST['phone']);
		$this->dao->demand = trim($_REQUEST['demand']);
		$this->dao->create_time = date('Y-m-d H:i:s');
		$this->dao->status = 0;
		if($this->dao->add()) {
			self::_success('预订成功！', __APP__.'/'.$_REQUEST['type'].'/'.$_REQUEST['alias'].(empty($_REQUEST['id'])?'':('/id/'.$_REQUEST['id'])));
		}
		else {
			self::_error('预定出错！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}
}
?>