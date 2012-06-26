<?php

class IndexAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
	}

	public function index(){
		$topnavi[]=array(
			"text"=>"欢迎"
			);
		$this->assign("topnavi",$topnavi);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function setting() {
		if (!empty($_POST['submit'])) {
			$data = array(
				'title' => trim($_REQUEST['title']),
				'keywords' => str_replace(array("\r\n", "\n"), ' ', trim($_REQUEST['keywords'])),
				'description' => str_replace(array("\r\n", "\n"), ' ', trim($_REQUEST['description'])),
				'phone' => trim($_REQUEST['phone']),
				'fax' => trim($_REQUEST['fax']),
				'qq' => trim($_REQUEST['qq']),
				'email' => trim($_REQUEST['email']),
				'url' => trim($_REQUEST['url']),
				'address' => trim($_REQUEST['address']),
				'address_en' => trim($_REQUEST['address_en']),
				);

			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '网站参数设置',
			);
		$this->assign("topnavi", $topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				'title' => '宜昌致尚会务会展有限公司',
				'keywords' => '宜昌市，活力，竞争，专业，全程，会务会展团队',
				'description' => '宜昌致尚会务会展有限公司是一家以现代化企业管理理念组建、专门为会议会展提供“一条龙”服务的专业化公司。专业承接政府及企业单位举办的工作年会、研讨会、经销商会、产品推广会、新闻发布会以及培训、销售、奖励等各种形式的会议。公司拥有一支经验丰富、业务过硬的高素质会议会展服务队伍；凭借良好的沟通协调能力，丰富的会务会展承办经验，专业的行业操作规范，遵循“精致策划，时尚设计，追求卓越”的经营宗旨，为客户提供全方位细致周到的专业服务。'
				);
		}
		$this->assign('data', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function flink() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['img0'] as $i=>$img0) {
				if($_FILES['img']['size'][$i] > 0) {
					$path = 'html/Attach/flink/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['img']['name'][$i], PATHINFO_EXTENSION));
					if (!move_uploaded_file($_FILES['img']['tmp_name'][$i], $path)) {
						self::_error('上传图片出错！');
					}
				}
				else {
					$path = $img0;
				}
				$data[] = array(
					'img' => $path,
					'name' => $_REQUEST['name'][$i],
					'url' => $_REQUEST['url'][$i]
					);
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '友情链接管理',
			);
		$this->assign("topnavi",$topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				array(
					'img' => 'Tpl/default/Public/Images/ruit_logo.gif',
					'name' => '睿腾网络',
					'url' => 'http://www.ycruit.com/'
					)
				);
		}
		$this->assign('list', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
}
?>