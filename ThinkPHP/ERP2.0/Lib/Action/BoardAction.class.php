<?php
/**
*
* 板子资料
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class BoardAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		Session::set('top', 'Basic Data');
		Session::set('sub', MODULE_NAME);
		$this->dao = D('Product');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Board');
	}

	public function index(){
		$this->assign('ACTION_TITLE', 'List');
		import("@.Paginator");
		$limit = 4;

		$this->assign('category_opts', self::genOptions(M('Category')->select(), $_REQUEST['category_id']) );
		$this->assign('status_opts', self::genOptions(M('Options')->where(array('type'=>'status'))->order('sort')->select(), $_REQUEST['status_id']));

		$where = array();
		$where['_string'] = "(type='Board' or fixed=1)";
		if(!empty($_POST['submit'])) {
			(''!=$_REQUEST['category_id']) && ($where['category_id'] = intval($_REQUEST['category_id']));
			(''!=trim($_REQUEST['Internal_PN'])) && ($where['Internal_PN'] = array('like', '%'.trim($_REQUEST['Internal_PN']).'%'));
			(''!=trim($_REQUEST['description'])) && ($where['description'] = array('like', '%'.trim($_REQUEST['description']).'%'));
			(''!=trim($_REQUEST['manufacture'])) && ($where['manufacture'] = array('like', '%'.trim($_REQUEST['manufacture']).'%'));
			(''!=trim($_REQUEST['MPN'])) 		 && ($where['MPN'] 		   = array('like', '%'.trim($_REQUEST['MPN']).'%'));
			(''!=trim($_REQUEST['value'])) 		 && ($where['value'] 	   = trim($_REQUEST['value']));
			(''!=trim($_REQUEST['project'])) 	 && ($where['project'] 	   = array('like', '%'.trim($_REQUEST['project']).'%'));
			if (''!=$_REQUEST['status_id']) {
				$where['_string'] = "type='Board'";
				$where['status_id'] = intval($_REQUEST['status_id']);
			}
			if (count($where) > 1) {
				$limit = 1000;
			}
		}
		$rs = $this->dao->where($where)->group('type,description')->select();
		$count = count($rs);
		$p = new Paginator($count,$limit);

		$rs = $this->dao->where($where)->field('id,type,description')->group('type,description')->order('id desc')->limit($p->offset.','.$p->limit)->select();
		empty($rs) && ($rs = array());
		$result = array();
		foreach ($rs as $val) {
			if ('Board' == $val['type']) {
				$result[str_replace(array(' ','"',"'"), '', $val['description'])] = $this->dao->relation(true)->where(array('type'=>'Board', 'description'=>$val['description']))->order('Internal_PN')->select();
			}
			else {
				$result[str_replace(array(' ','"',"'"), '', $val['description'])] = $this->dao->relation(true)->where('id='.$val['id'])->select();
			}
		}
		
		$this->assign('request', $_REQUEST);
		$this->assign('result',$result);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content','Board:index');
		$this->display('Layout:ERP_layout');
	}
	public function form() {
		$this->assign('ACTION_TITLE', 'Add New Board');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->find($id);
			$this->assign('ACTION_TITLE', 'Edit '.ucfirst($info['type']).' Data');
			$info['category_opts'] = self::genOptions(M('Category')->where(array('type'=>ucfirst($info['type'])))->select(), $info['category_id'], 'name');
			$info['supplier_opts'] = self::genOptions(D('Supplier')->select());
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id']);
			$info['unit_opts'] = self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select(), $info['unit_id']);
			$info['status_opts'] = self::genOptions(M('Options')->where(array('type'=>'status'))->order('sort')->select(), $info['status_id']);
			$code = $info['code'];
		}
		else {
			$info = array(
				'id' => 0,
				'fixed' => 1,
				'category_opts' => self::genOptions(M('Category')->where(array('type'=>'Board'))->select()),
				'supplier_opts' => self::genOptions(D('Supplier')->select()),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select()),
				'unit_opts' => self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select()),
				'status_opts' => self::genOptions(M('Options')->where(array('type'=>'status'))->order('sort')->select())
				);
			$max_code = $this->dao->where(array('type'=>'Board'))->max('code');
			empty($max_code) && ($max_code = 'B'.sprintf("%09d",0));
			$code = ++ $max_code;
		}
		$this->assign('code', $code);
		$this->assign('info', $info);
		$this->assign('MAX_FILE_SIZE', self::MAX_FILE_SIZE());
		$this->assign('upload_max_filesize', min(ini_get('memory_limit'), ini_get('post_max_size'), ini_get('upload_max_filesize')));
		$this->assign('content', 'Board:form');
		$this->display('Layout:ERP_layout');
	}

	public function submit() {
		if(empty($_POST['submit1']) && empty($_POST['submit2'])) {
			return;
		}
		$PN = trim($_REQUEST['PN']);
		$description = trim($_REQUEST['description']);
		!$description && self::_error('Borad name required');
		empty($_REQUEST['category_id']) && self::_error('Category must be specified!');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$rs = $this->dao->where(array('Internal_PN'=>$PN, 'description'=>$description, 'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Board Code: '.$PN.' has been used by another board!');
			}
			$this->dao->find($id);
		}
		else {
			$rs = $this->dao->where(array('Internal_PN'=>$PN, 'description'=>$description))->find();
			if($rs && sizeof($rs)>0){
				self::_error('The board: '.$description.' with code: '.$PN.' has been added!');
			}
			$max_code = $this->dao->where(array('type'=>'Board'))->max('code');
			empty($max_code) && ($max_code = 'B'.sprintf("%09d",0));
			$this->dao->code = ++ $max_code;
			$this->dao->type = 'Board';
		}
		$this->dao->fixed = $_REQUEST['fixed'];
		$this->dao->Internal_PN = $PN;
		$this->dao->description = $description;
		$this->dao->manufacture = $_REQUEST['manufacture'];
		$this->dao->MPN = $_REQUEST['MPN'];
		$this->dao->value = $_REQUEST['value'];
		$this->dao->category_id = $_REQUEST['category_id'];
		$this->dao->status_id = $_REQUEST['status_id'];
		$this->dao->unit_id = $_REQUEST['unit_id'];
		$this->dao->RoHS = $_REQUEST['Rohs'];
		$this->dao->LT_days = $_REQUEST['LT_days'];
		$this->dao->MOQ = $_REQUEST['MOQ'];
		$this->dao->SPQ = $_REQUEST['SPQ'];
		$this->dao->MSL = $_REQUEST['MSL'];
		$this->dao->project = $_REQUEST['project'];
		$this->dao->inventory_limit = $_REQUEST['inventory_limit'];
		$this->dao->currency_id = $_REQUEST['currency_id'];
		$this->dao->price = $_REQUEST['price'];
		$this->dao->accessories = $_REQUEST['accessories'];
		$file = $_FILES['attachment'];
		if($file['size']>0) {
			$file_path = 'Attach/Product/';
			$file_name = $this->dao->description.'.'.pathinfo($file['name'], PATHINFO_EXTENSION);
			if(!move_uploaded_file($file['tmp_name'], $file_path.$file_name)) {
				self::_error('Attachment upload fail!');
			}
			$this->dao->attachment = $file_path.$file_name;
		}
		$this->dao->remark = $_REQUEST['remark'];
		if ($id>0) {
			if(false !== $this->dao->save()){
				if (!empty($_POST['submit2'])) {
					die('<script>parent.clear();parent.direct_input('.$id.');</script>');
				}
				self::_success('Board information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			if($id = $this->dao->add()) {
				if (!empty($_POST['submit2'])) {
					die('<script>parent.clear();parent.direct_input('.$id.');</script>');
				}
				self::_success('Add board data success!',__URL__);
			}
			else{
				self::_error('Add board data fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function import() {
		//define header
		$header_arr = array(
			'Board Code',
			'Board Name',
			'Manufacture',
			'Series Number',
			'Value/Package',
			'Unit',
			'Category',
			'Fixed Assets',
			'Board Status',
			'RoHS',
			'LT days',
			'MOQ',
			'MSL',
			'Project',
			'Currency',
			'Price',
			'Accessories',
			'Attachment',
			'Remark'
			);
		//define the map of csv_field=>table_column
		$fields_arr = array(
			'Internal_PN',
			'description',
			'manufacture',
			'MPN',
			'value',
			'unit_name',
			'category_name',
			'Fixed',
			'status_name',
			'Rohs',
			'LT_days',
			'MOQ',
			'MSL',
			'project',
			'currency_name',
			'price',
			'accessories',
			'attachment',
			'remark'
			);
		//do upload
		if (empty($_FILES['file']) || $_FILES['file']['size']==0) {
			self::_error('Please select a file to upload.');
		}
		$confirm = $_REQUEST['confirm'];

		$file = $_FILES['file'];
		$file_name = $file['name'];
		$fp = fopen($file['tmp_name'], "r");
		$i=0;
		$values_arr = array();//to save the validated line array
		while($value_arr = fgetcsv($fp)) {
			if (empty($value_arr)) {
				continue;
			}
			if ($i == 0) {
				if ($value_arr != $header_arr) {
					echo '<script>parent.document.Import.file.value="";</script>';
					self::_error('The imported file\'s header isn\'t right.');
				}
			}
			else {
				if (count($value_arr) != count($header_arr)) {
					echo '<script>parent.document.Import.file.value="";</script>';
					self::_error('The imported file isn\'t well-formatted. (Line:'.($i+1).')');
				}
				$values_arr[$i] = array_combine($fields_arr, $value_arr);
			}
			$i++;
		}
		//validate upload data
		if (empty($values_arr)) {
			echo '<script>parent.document.Import.file.value="";</script>';
			self::_error('There is no record in the file.');
		}
		if (empty($confirm)) {
			//confirm once
			self::_confirm2('Import board basic data into the system?<br /><br />Record count: <i>'.($i-1).'</i> ;<br />The repeated record will be ignored.', 1);
		}
		else {
		}
		$duplicated = 0;
		$imported = 0;
		$failure_line_arr = array();
		foreach ($values_arr as $i=>$value_arr) {
			//check repeat
			$where = array();
			$where['type'] = 'Board';
			$where['Internal_PN'] = $value_arr['Internal_PN'];
			$where['description'] = $value_arr['description'];
			$where['manufacture'] = $value_arr['manufacture'];
			$where['MPN'] = $value_arr['MPN'];
			if ($this->dao->where($where)->count()>0) {
				$duplicated ++;
				continue;
			}
			//parse field: unit_name,category_name,Fixed,status_name,currency_name
			$unit_data = array('type'=>'unit','name'=>$value_arr['unit_name']);
			if(!($unit_id = M('Options')->where($unit_data)->getField('id'))) {
				$unit_data['code'] = '';
				$unit_data['sort'] = M('Options')->where("type='unit'")->max('sort')+1;
				$unit_id = M('Options')->add($unit_data);
			}
			unset($value_arr['unit_name']);
			$value_arr['unit_id'] = $unit_id;

			$category_data = array('type'=>'Board','name'=>$value_arr['category_name']);
			if(!($category_id = M('Category')->where($category_data)->getField('id'))) {
				$max_code = M('Category')->max('code');
				empty($max_code) && ($max_code = 'P'.sprintf("%03d",0));
				$category_data['code'] = ++ $max_code;
				$category_id = M('Category')->add($category_data);
			}
			unset($value_arr['category_name']);
			$value_arr['category_id'] = $category_id;

			$value_arr['fixed'] = 0;
			if ('YES' == strtoupper($value_arr['Fixed']) || 'Y'== strtoupper($value_arr['Fixed'])) {
				$value_arr['fixed'] = 1;
			}
			unset($value_arr['Fixed']);
			
			$status_data = array('type'=>'status','name'=>$value_arr['status_name']);
			if(!($status_id = M('Options')->where($status_data)->getField('id'))) {
				$status_data['code'] = '';
				$status_data['sort'] = M('Options')->where("type='status'")->max('sort')+1;
				$status_id = M('Options')->add($status_data);
			}
			unset($value_arr['status_name']);
			$value_arr['status_id'] = $status_id;

			$currency_data = array('type'=>'currency','code'=>$value_arr['currency_name']);
			if(!($currency_id = M('Options')->where($currency_data)->getField('id'))) {
				$currency_data['name'] = $value_arr['currency_name'];
				$currency_data['sort'] = M('Options')->where("type='currency'")->max('sort')+1;
				$currency_id = M('Options')->add($currency_data);
			}
			unset($value_arr['currency_name']);
			$value_arr['currency_id'] = $currency_id;

			//do insert
			$max_code = $this->dao->where(array('type'=>'Board'))->max('code');
			empty($max_code) && ($max_code = 'B'.sprintf("%09d",0));
			$value_arr['code'] = ++ $max_code;
			$value_arr['type'] = 'Board';
			if (!$this->dao->add($value_arr)) {
				$failure_line_arr[] = $i;
				echo $this->dao->getLastSql()."\n";
			}
			else {
				$imported ++;
			}
		}
		$msg  = 'The result of Board Basic Data importing:<br />';
		$msg .= 'Total records: '.(count($values_arr)-1).'<br />';
		$msg .= 'Imported records: '.$imported.'<br />';
		$msg .= 'Duplicated records: '.($duplicated>0 ? '<i>'.$duplicated.'</i>' : 0).'<br />';
		$msg .= 'Failure records: '.(count($failure_line_arr)>0 ? '<i>'.count($failure_line_arr).'</i>' : 0);
		count($failure_line_arr)>0 && ($msg .= ' <i>(Line: '.implode(', ', $failure_line_arr).')</i>.');
		
		self::_success($msg, '', 5000);
		exit;
		//import end
	}
	public function delete() {
		//判断是否已被使用
		$id = $_REQUEST['id'];
		$rs = M('ProductFlow')->where(array('product_id'=>$id))->select();
		if(!empty($rs) && sizeof($rs)>0) {
			self::_error('It\'s in use, can\'t be deleted!');
		}
		else{
			self::_delete();
		}
	}
}
?>