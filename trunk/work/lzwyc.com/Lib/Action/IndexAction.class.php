<?php
class IndexAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
		$this->assign('MODULE_TITLE', '首页');
	}

	public function index(){

		$this->assign('district_opts', self::genOptions(M('Region')->where("pid=2")->getField('id,name')));

		$this->assign('marquee', F('Index-marquee'));
		$this->assign('focus', F('Index-focus'));
		$this->assign('case_list', F('Index-case_list'));
		$this->assign('company', F('Index-company'));
		$this->assign('statistic', F('Index-statistic'));
		$this->assign('knowledge', F('Index-knowledge'));

		$rs = M('Article')->where("category_id=2 and status>0")->order("id desc")->limit(12)->select();
		$this->assign('knowledge_list', $rs);

		$rs = M('Invite')->where("status>0")->order("id desc")->limit(5)->select();
		foreach ($rs as $i=>$row) {
			$rs[$i]['budget_num'] = $row['budget']*10000;
			$rs[$i]['region'] = M('Region')->where("id=".$row['district'])->getField('name');
			$rs[$i]['type_str'] = $options['type'][$row['type']];
			$rs[$i]['space_str'] = $options['space'][$row['space']];
			$rs[$i]['room_str'] = $options['room'][$row['room']];
			$rs[$i]['tender_count'] = M('Tender')->where("invite_id=".$row['id']." and status>0")->count();
		}
		$this->assign('invite_list', $rs);

		$rs = M('Company')->where("status>0")->order("sort, id desc")->limit(9)->select();
		$this->assign('company_list', $rs);

		$this->assign('tips', F('Index-tips'));

		$options = C('_options_');
		$rs = M('Designer')->where("status>0")->order("sort, id desc")->limit(8)->select();
		foreach ($rs as $i=>$row) {
			empty($row['qq']) && ($rs[$i]['qq'] = array_shift($this->setting));
		}
		$this->assign('designer_list', $rs);

		//网站公告
		$rs = M('Article')->where("category_id=1 and status>0")->order("sort, id desc")->limit(12)->select();
		$this->assign('announcement_list', $rs);

		$this->assign('brand', F('Index-brand'));
		$this->assign('flink', F('Index-flink'));

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

}
?>