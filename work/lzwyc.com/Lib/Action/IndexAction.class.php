<?php
class IndexAction extends BaseAction{

	public function index(){
		$this->assign('MODULE_TITLE', '首页');

		$this->assign('district_opts', self::genOptions(M('Region')->where("pid=2")->getField('id,name')));

		$rs = M('Tender')->where("status=2")->order("id desc")->select();
		$this->assign('tender_list', $rs);

		$rs = M('Invite')->where("status>0")->order("id desc")->limit(6)->select();
		foreach ($rs as $i=>$row) {
			$rs[$i]['budget_num'] = $row['budget']*10000;
			$rs[$i]['region'] = M('Region')->where("id=".$row['district'])->getField('name');
			$rs[$i]['type_str'] = $options['type'][$row['type']];
			$rs[$i]['space_str'] = $options['space'][$row['space']];
			$rs[$i]['room_str'] = $options['room'][$row['room']];
		}
		$this->assign('invite_list', $rs);

		$rs = M('Company')->where("status>0")->order("sort, id desc")->limit(9)->select();
		$this->assign('company_list', $rs);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

}
?>