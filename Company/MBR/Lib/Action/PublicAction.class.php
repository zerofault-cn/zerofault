<?php
class PublicAction extends Action{

	Public function _empty(){ 
		//�Ҳ�����б�
		$base['status'] = array('gt', 0);
		$order = 'sort';
		$category_list = M('Category')->where($base)->order($order)->select();
		$this->assign('category_list',$category_list);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:Index_layout');
	}

	public function verify() {
		import("@.Image");
		Image::buildImageVerify(); 
	}
}