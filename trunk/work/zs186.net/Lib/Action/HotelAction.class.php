<?php
class HotelAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Hotel');
		parent::_initialize();
	}
	public function _empty() {
		$id = intval($_REQUEST['id']);
		$alias = ACTION_NAME;
		$this->assign('alias', $alias);
		//酒店区域选项
		$this->assign('region_options', self::genOptions(M('Region')->where('pid=2')->order('sort')->getField('id,name')));
		if (empty($id)) {
			$category = M('Category')->where("alias='".$alias."'")->find();
			$this->assign('category', $category);
			$this->assign('MODULE_TITLE', $category['name']);
			$this->index($category['id']);
		}
		else {
			$this->detail();
		}
	}
	public function index($id=0) {
		$this->assign('region_list', M('Region')->where('pid=2')->order('sort')->getField('id,name'));
		$this->assign('district_list', M('District')->where('pid=2')->order('sort')->getField('id,name'));
		$level_arr = M('Level')->order('sort')->getField('id,name');
		$this->assign('level_list', $level_arr);
		if('meeting' == ACTION_NAME) {
			$capacity_split = array(60, 150, 300);
			$unit = '人';
		}
		else {
			$capacity_split = array(30, 50, 80);
			$unit = '桌';
		}
		$capacity_arr = array();
		foreach ($capacity_split as $k=>$v) {
			if (0==$k) {
				$capacity_arr['0-'.$v] = $v.$unit.'以下';
			}
			else {
				$capacity_arr[$last_v.'-'.$v] = $last_v.'-'.$v.$unit;
			}
			$last_v = $v;
		}
		$capacity_arr[$last_v] = $last_v.$unit.'以上';
		$this->assign('capacity_list', $capacity_arr);

		$where = array(
			'category_id' => $id,
			'status' => array('gt', 0)
			);
		!empty($_REQUEST['r_id']) && ($where['region_id'] = intval($_REQUEST['r_id']));
		!empty($_REQUEST['d_id']) && ($where['district_id'] = intval($_REQUEST['d_id']));
		!empty($_REQUEST['l_id']) && ($where['level_id'] = intval($_REQUEST['l_id']));
		if (!empty($_REQUEST['cc'])) {
			$temp_arr = explode('-', trim($_REQUEST['cc']));
			$where['capacity'] = array(array('egt', intval($temp_arr[0])));
			!empty($temp_arr[1]) && $where['capacity'][] = array('elt', intval($temp_arr[1]));
		}
		//获取各星级的酒店数量
		$level_number = array();
		$level_where = $where;
	//	unset($level_where['level_id']);
	//	$level_number[0] = $this->dao->where($level_where)->count();
		foreach ($level_arr as $key=>$val) {
			$level_where['level_id'] = $key;
			$level_number[$key] = $this->dao->where($level_where)->count();
		}
		$this->assign('level_number', $level_number);

		$order = 'sort, id desc';
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 9;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', 'index');
		$this->display('Layout:main');
	}

	public function detail() {
		$id = intval($_REQUEST['id']);
		$this->dao->setInc('view', 'id='.$id);

		$info = $this->dao->find($id);
		$this->assign('ACTION_TITLE', $info['name']);
		$this->assign('info', $info);

		$category = M('Category')->find($info['category_id']);
		$this->assign('category', $category);

		//获取上一篇，下一篇
		$rel_link = array();
		$rs = $this->dao->where("category_id=".$info['category_id']." and (sort=".$info['sort']." and id<".$id." or sort<".$info['sort'].")")->order('sort desc, id desc')->find();
		if (!empty($rs) && count($rs)>0) {
			$rel_link['prev'] = $rs;
		}
		$rs = $this->dao->where("category_id=".$info['category_id']." and (sort=".$info['sort']." and id>".$id." or sort>".$info['sort'].")")->order('sort, id')->find();
		if (!empty($rs) && count($rs)>0) {
			$rel_link['next'] = $rs;
		}
		$this->assign('rel_link', $rel_link);

		$this->assign('content', 'detail');
		$this->display('Layout:main');
	}
}
?>