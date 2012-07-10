<?php

class SystemAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
	}

	public function setting() {
		if (!empty($_POST['submit'])) {
			$data = array(
				'title' => trim($_REQUEST['title']),
				'keywords' => str_replace(array("\r\n", "\n"), ' ', trim($_REQUEST['keywords'])),
				'description' => str_replace(array("\r\n", "\n"), ' ', trim($_REQUEST['description'])),
				'qq' => trim($_REQUEST['qq']),
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
				'title' => '',
				'keywords' => '',
				'description' => ''
				);
		}
		$this->assign('data', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function flink() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['name'] as $i=>$title) {
				$data[] = array(
					'name' => $title,
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