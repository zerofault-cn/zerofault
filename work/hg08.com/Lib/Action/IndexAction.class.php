<?php
class IndexAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
	}

	public function index() {

		$rs = M('Article')->where("category_id=2 and status>0")->order("sort, id desc")->limit(8)->select();
		$this->assign('news_list', $rs);

		$album_category = M('Category')->where('pid=4 and status>0 and id!=5')->order('sort')->select();
		$this->assign('album_category', $album_category);

		$album_list = array();
		foreach ($album_category as $i=>$row) {
			$rs = M('Album')->where('category_id='.$row['id'].' and status>1')->order('sort, id desc')->limit(4)->select();
			if (!empty($rs) && count($rs)>0) {
				$album_list[$row['id']] = $rs;
				$album_category[$i]['count'] = count($rs);
			}
		}
		$this->assign('album_list', $album_list);

		$this->assign('wedding_list', M('Album')->where('category_id=5 and status>1')->order('sort, id desc')->limit(6)->select());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	
	public function gallery_xml() {
		header("Content-Type:text/xml; charset=utf-8");
		$xml = new XMLWriter();
		$xml->openUri("php://output");
		$xml->setIndentString('  ');
		$xml->setIndent(true);
		$xml->startDocument('1.0', 'utf-8');
		$xml->startElement('root');
		$xml->writeAttribute('imageWidth', '680');
		$xml->writeAttribute('imageHeight', '345');

		$where = array(
			'category_id' => 3,
			'status' => array('gt', 1)
			);
		$order = 'sort, id desc';
		$rs = M('Photo')->where($where)->order($order)->select();
		empty($rs) && ($rs = array());
		foreach ($rs as $row) {
			$xml->startElement('menu');
			$xml->writeAttribute('url', __APP__.'/Album/photo');
			$xml->writeAttribute('frame', '_blank');
			$xml->writeAttribute('imageUrl', __APP__.'/../'.$row['thumb']);
			$xml->endElement();
		}
		$xml->endElement();
		$xml->endDocument();
		$xml->flush();
	}
}
?>