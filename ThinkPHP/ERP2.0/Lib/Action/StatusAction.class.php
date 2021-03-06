<?php
class StatusAction extends BaseAction{

	protected $dao, $config, $status_arr, $RevArray;

	public function _initialize() {
		if ('Node'!= MODULE_NAME) {
			Session::set('top', 'Board Status');
		}
		$this->dao = D('StatusFlow');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Board Status');
		$this->status_arr = array(
			'-1' => 'TBD',
			'0' => 'Ongoing',
			'1' => 'Pass',
			'2' => 'Failed',
			'8' => 'Ignore',
			'9' => 'Pass*'
		);
		$this->assign('status_arr', $this->status_arr);
		$this->RevArray = array(
			'Software' => 'Software Rev',
			'Logic' => 'Logic Rev',
			'FCT' => 'FCT Rev',
			'Host' => 'Host Rev'
		);
	}

	public function index() {
		Session::set('sub', MODULE_NAME);

		$this->assign('request', $_REQUEST);
		//load template
		$this->assign('template_opts', self::genOptions(M('StatusTemplate')->order('id')->select()));

		$where = array();
		if (!empty($_REQUEST['flow_name'])) {
			$flow_name = trim($_REQUEST['flow_name']);
			if (strlen($flow_name)>0) {
				$where['name'] = array('like', '%'.$flow_name.'%');
			}
		}
		if (isset($_REQUEST['creator_id'])) {
			$creator_id = intval($_REQUEST['creator_id']);
		}
		$creator_arr = $this->dao->join("Inner Join erp_staff on erp_staff.id=erp_status_flow.creator_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('creator_opts', self::genOptions($creator_arr, $creator_id, 'realname'));
		if (!empty($creator_id)) {
			$where['creator_id'] = $creator_id;
		}

		$board_where = array();
		if (!empty($_REQUEST['board_name'])) {
			$board_name = trim($_REQUEST['board_name']);
			if (strlen($board_name)>0) {
				$board_where['name'] = array('like', '%'.$board_name.'%');
			}
		}
		if (!empty($_REQUEST['board_info'])) {
			$board_info = trim($_REQUEST['board_info']);
			if (strlen($board_info)>0) {
				$board_where['info'] = array('like', '%'.$board_info.'%');
			}
		}
		if (isset($_REQUEST['owner_id'])) {
			$owner_id = intval($_REQUEST['owner_id']);
		}
		$owner_arr = M('StatusBoard')->join("Inner Join erp_staff on erp_staff.id=erp_status_board.owner_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('owner_opts', self::genOptions($owner_arr, $owner_id, 'realname'));
		if (!empty($owner_id)) {
			$board_where['owner_id'] = $owner_id;
		}

		import("@.Paginator");
		$limit = 20;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$total = $this->dao->where($where)->count();
		$p = new Paginator($total,$limit);

		$rs = $this->dao->relation(true)->where($where)->order('id desc')->limit($p->offset.','.$p->limit)->select();
		empty($rs) && ($rs = array());
		$result = array();
		foreach ($rs as $i=>$row) {
			$result[$i] = $row;
			$board_where['flow_id'] = $row['id'];
			$result[$i]['board_list'] = D('StatusBoard')->relation(true)->where($board_where)->order('name')->select();
			foreach ($result[$i]['board_list'] as $j=>$board) {
				if ($board['owner_id'] < 0) {
					$result[$i]['board_list'][$j]['owner'] = array(
						'realname' => '['.M('Location')->where("id=".abs($board['owner_id']))->getField('name').']'
						);
				}
			}
		}
		$this->assign('result', $result);

		$this->assign('page', $p->showMultiNavi());

		$this->assign('ACTION_TITLE', 'Flow List');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	public function form() {
		Session::set('sub', MODULE_NAME);
		//load item
		$this->assign('item_list', D('StatusItem')->order('sort')->select());
		//gen staff options
		$this->assign('staff_opts', self::genOptions(M('Staff')->where(array('status'=>1))->select(), 0, 'realname'));

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->find($id);
			$item_arr = explode(',', $info['item_ids']);
			$owner_arr = explode(',', $info['owner_ids']);
		}
		else {
			$info = array(
				'id' => 0,
				'name' => '',
				'item_list' => array()
			);
			$item_arr = array();
			$template_id = empty($_REQUEST['template_id']) ? 0 : intval($_REQUEST['template_id']);
			if ($template_id>0) {
				$template_info = M('StatusTemplate')->find($template_id);
				$item_arr = explode(',', $template_info['item_ids']);
				$owner_arr = explode(',', $template_info['owner_ids']);
			}
		}
		foreach ($item_arr as $i=>$item_id) {
			$item = M('StatusItem')->find($item_id);
			$info['item_list'][] = array(
				'id' => $item_id,
				'name' => $item['name'],
				'owner_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $owner_arr[$i], 'realname'),
				'reminder' => M('StatusRemind')->where("flow_id=".$id." and item_id=".$item_id)->find()
			);
		}
		$this->assign('info', $info);

		$this->assign('ACTION_TITLE', 'Flow Form');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function get_owner($name='') {
		$return = false;
		if ('' != $name) {
			$return = true;
		}
		else {
			$name = $_REQUEST['name'];
		}
		$product_id = M('Product')->where("Internal_PN='".$name."'")->getField('id');
		if (empty($product_id)) {
			if ($return) {
				return '0';
			}
			die('0');
		}
		$location_rs = M('LocationProduct')->where("product_id=".$product_id." and chg_quantity>0")->field('type,location_id')->select();
		if (empty($location_rs)) {
			$staff_id = 0;
		}
		foreach ($location_rs as $location) {
			$staff_id = $location['location_id'];
			if ($location['type'] == 'staff') {
				break;
			}
			elseif ($location['type'] == 'location') {
				$staff_id *= -1;
			}
		}
		if ($return) {
			return $staff_id;
		}
		die($staff_id);
	}
	public function sync_owner() {
		$board_rs = D('StatusBoard')->relation(true)->select();
		foreach ($board_rs as $board) {
			$product_id = M('Product')->where("Internal_PN='".$board['name']."'")->getField('id');
			if (empty($product_id)) {
				$product_id = 0;
			}
			$location_rs = M('LocationProduct')->where("product_id=".$product_id." and chg_quantity>0")->field('type,location_id')->select();
			if (empty($location_rs)) {
				$staff_id = 0;
			}
			foreach ($location_rs as $location) {
				$staff_id = $location['location_id'];
				if ($location['type'] == 'staff') {
					break;
				}
				elseif ($location['type'] == 'location') {
					$staff_id *= -1;
				}
			}
		//	echo $product_id.':'.$staff_id."\n";
			if ($board['owner_id'] == $staff_id) {
				continue;
			}
			if (false !== M('StatusBoard')->where("id=".$board['id'])->setField(array('owner_id', 'update_time'), array($staff_id, date('Y-m-d H:i:s')))) {
				if ($staff_id >= 0) {
					$owner_name = M('Staff')->where("id=".$staff_id)->getField('realname');
				}
				else {
					$owner_name = M('Location')->where("id=".abs($staff_id))->getField('name');
				}
				if ($board['owner_id'] < 0) {
					$board['owner']['realname'] = M('Location')->where("id=".abs($board['owner_id']))->getField('name');
				}
				$debug = "Change Board(".$board['id'].": ".$board['name'].") Owner from [".$board['owner']['realname']."] to [".$owner_name."]";
				echo $debug."\n";
				self::write_log('Automatically', $debug);
			}
		}
	}

	public function submit() {
		if (empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('Flow name required!');
		empty($_REQUEST['item_id']) && self::_error('You must add at least one test item!');
		empty($_REQUEST['owner_id'][0]) && self::_error('You must specify an owner to the first test item!');
		if ($id>0) {
			$this->dao->find($id);
			$old_item_ids = $this->dao->item_ids;
		}
		else {
			$this->dao->creator_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date('Y-m-d H:i:s');

			$board_name = trim($_REQUEST['board_name']);
			empty($board_name) && self::_error('Board name required!');
			if (M('StatusBoard')->where("name='".$board_name."'")->count() > 0) {
				self::_error('The board name: '.$board_name.' is exists!');
			}
		}
		$this->dao->name = $name;
		$this->dao->item_ids = implode(',', $_REQUEST['item_id']);
		$this->dao->owner_ids = implode(',', $_REQUEST['owner_id']);
		$this->dao->update_time = date('Y-m-d H:i:s');
		if ($id>0) {
			if(false !== $this->dao->save()) {
				$item_ids_diff = array_diff(explode(',', $old_item_ids), $_REQUEST['item_id']);
				if (!empty($item_ids_diff)) {
					$item_deleted = M('StatusItem')->where(array('id'=>array('in', $item_ids_diff)))->getField('id,name');
					self::write_log('Manually', 'Remove Test Items ['.implode('/', $item_deleted).'] from the Test Flow('.$id.': '.$this->dao->name.').');
				}
				//update all status
				M('StatusStatus')->where("flow_id=".$id." and item_id not in (".implode(',', $_REQUEST['item_id']).")")->delete();
				//load board list in the flow
				$board_rs = M('StatusBoard')->where("flow_id=".$id)->select();
				$last_owner_id = $_REQUEST['owner_id'][0];
				foreach ($_REQUEST['item_id'] as $i=>$item_id) {
					if (empty($_REQUEST['owner_id'][$i])) {
						$owner_id = $last_owner_id;
					}
					else {
						$owner_id = intval($_REQUEST['owner_id'][$i]);
						$last_owner_id = $owner_id;
					}
					$tmp_rs = D('StatusStatus')->relation(true)->where("flow_id=".$id." and item_id=".$item_id)->find();
					if (empty($tmp_rs)) {
						self::write_log('Manually', 'Add Test Item['.M('StatusItem')->where("id=".$item_id)->getField('name').'] to the Test Flow('.$id.': '.$this->dao->name.').');
						//add new item for all board
						foreach ($board_rs as $board) {
							$status_data = array(
								'flow_id' => $id,
								'board_id' => $board['id'],
								'item_id' => $item_id,
								'owner_id' => $owner_id,
								'substitute_id' => 0,
								'sort' => $i,
								'status' => -1,
								'mail_time' => 0
							);
							if (!M('StatusStatus')->add($status_data)) {
								self::_error('Add status fail!'.$this->dao->getLastSql());
							}
						}
					}
					else {
						//update the exists item
						M('StatusStatus')->where("flow_id=".$id." and item_id=".$item_id)->setField(array('owner_id', 'substitute_id', 'sort'), array($owner_id, 0, $i));
						if ($tmp_rs['owner_id'] != $owner_id) {
							self::write_log('Manually', 'Change the default owner of Item('.$item_id.': '.$tmp_rs['item']['name'].') from ['.$tmp_rs['owner']['realname'].'] to ['.M('Staff')->where("id=".$owner_id)->getField('realname').']');
						}
					}
					//set reminder
					$tmp_rs = M('StatusRemind')->where("flow_id=".$id." and item_id=".$item_id)->find();
					if (empty($tmp_rs)) {
						if ($_REQUEST['costTime'][$i] > 0) {
							//add
							$data = array(
								'flow_id' => $id,
								'item_id' => $item_id,
								'costTime' => intval($_REQUEST['costTime'][$i]),
								'remindInterval' => intval($_REQUEST['remindInterval'][$i])
								);
							M('StatusRemind')->data($data)->add();
							dump($this->dao->getLastSql());
						}
					}
					else {
						if ($_REQUEST['costTime'][$i] > 0) {
							//update
							M('StatusRemind')->where("id=".$tmp_rs['id'])->setField(array('costTime', 'remindInterval'), array(intval($_REQUEST['costTime'][$i]), intval($_REQUEST['remindInterval'][$i])));
						}
						else {
							//delete
							M('StatusRemind')->where("id=".$tmp_rs['id'])->delete();
						}
					}
				}
				//check each board status
				foreach ($board_rs as $board) {
					$status_count = M('StatusStatus')->where("board_id=".$board['id'])->group('status')->getField('status,count(*)');
					if ($status_count[2] > 0) {
						//有Fail
						$value = 2;//设为Fail
					}
					else {
						//没有Fail
						if ($status_count[0] > 0) {
							//有Ongoing
							$value = 0;//设为Ongoing
						}
						else {
							//没有Pending
							if ($status_count[-1] > 0) {
								//有TBD
								if ($status_count[1]>0) {
									//有Pass
									$value = 0;//设为Ongoing
								}
								else {
									//全部TBD，或还有Ignore
									$value = -1;//设为TBD
								}
							}
							else {
								//没有TBD，只剩Pass和Ignore
								if ($status_count[8]>0) {
									//有Ignore
									$value = 9;//设为Pass*
								}
								else {
									//全部Pass
									$value = 1;//设为Pass
								}
							}
						}
					}
					if ($board['status'] != $value) {
						M('StatusBoard')->where("id=".$board['id'])->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
						self::write_log('Automatically', 'Change Board('.$board['id'].': '.$board['name'].') finnal status from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[$value].']');
					}
				}
				self::_success('Flow updated!',__URL__);
			}
			else {
				self::_error('Update fail!'.$this->dao->getLastSql());
			}
		}
		else {
			if($id = $this->dao->add()) {
				$board_data = array(
					'flow_id' => $id,
					'name' => $board_name,
					'info' => trim($_REQUEST['board_info']),
					'owner_id' => !empty($_REQUEST['board_owner_id'])?intval($_REQUEST['board_owner_id']):self::get_owner($board_name),
					'create_time' => date('Y-m-d H:i:s'),
					'update_time' => date('Y-m-d H:i:s'),
					'status' => -1
				);
				if (!$board_id=M('StatusBoard')->add($board_data)) {
					self::_error('Add board fail!'.$this->dao->getLastSql());
				}
				//add item status
				$last_owner_id = $_REQUEST['owner_id'][0];
				foreach ($_REQUEST['item_id'] as $i=>$item_id) {
					if (empty($_REQUEST['owner_id'][$i])) {
						$owner_id = $last_owner_id;
					}
					else {
						$owner_id = intval($_REQUEST['owner_id'][$i]);
						$last_owner_id = $owner_id;
					}
					$status_data = array(
						'flow_id' => $id,
						'board_id' => $board_id,
						'item_id' => $item_id,
						'owner_id' => $owner_id,
						'substitute_id' => 0,
						'sort' => $i,
						'status' => -1,
						'mail_time' => 0
					);
					if (!M('StatusStatus')->add($status_data)) {
						self::_error('Add status fail!'.$this->dao->getLastSql());
					}
					//set reminder
					if ($_REQUEST['costTime'][$i] > 0) {
						//add
						$data = array(
							'flow_id' => $id,
							'item_id' => $item_id,
							'costTime' => intval($_REQUEST['costTime'][$i]),
							'remindInterval' => intval($_REQUEST['remindInterval'][$i])
							);
						M('StatusRemind')->add($data);
					}
				}
				self::_mail('board', $board_id);
				self::_success('Create flow success!',__URL__);
			}
			else {
				self::_error('Create flow fail!'.$this->dao->getLastSql());
			}
		}
	}

	public function flow() {
		Session::set('sub', MODULE_NAME);

		$this->assign('request', $_REQUEST);

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$board_where = array(
			'flow_id' => $id
			);
		if (!empty($_REQUEST['board_name'])) {
			$board_name = trim($_REQUEST['board_name']);
			if (strlen($board_name)>0) {
				$board_where['name'] = array('like', '%'.$board_name.'%');
			}
		}
		if (!empty($_REQUEST['board_info'])) {
			$board_info = trim($_REQUEST['board_info']);
			if (strlen($board_info)>0) {
				$board_where['info'] = array('like', '%'.$board_info.'%');
			}
		}
		if (isset($_REQUEST['board_status'])) {
			$board_status = intval($_REQUEST['board_status']);
			if ($board_status>-2) {
				$board_where['status'] = $board_status;
			}
		}
		if (isset($_REQUEST['owner_id'])) {
			$owner_id = intval($_REQUEST['owner_id']);
		}
		$owner_arr = M('StatusBoard')->join("Inner Join erp_staff on erp_staff.id=erp_status_board.owner_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('owner_opts', self::genOptions($owner_arr, $owner_id, 'realname'));
		if (!empty($owner_id)) {
			$board_where['owner_id'] = $owner_id;
		}

		$flow_info = $this->dao->find($id);

		$board_list = D('StatusBoard')->relation(true)->where($board_where)->order('id')->select();
		$board_ids = array();
		foreach ($board_list as $i=>$board) {
			$board_list[$i]['comment'] = D('Comment')->relation(true)->where(array('model_name'=>'StatusBoard', 'model_id'=>$board['id']))->order('id')->select();
			$board_list[$i]['last_comment'] = M('Comment')->where(array('model_name'=>'StatusBoard', 'model_id'=>$board['id']))->order('id desc')->find();
			$board_ids[] = $board['id'];
		}

		$owner_arr = explode(',', $flow_info['owner_ids']);
		$item_board_status = array();
		$board_ext = "";
		if (count($board_where)>1) {
			//using board filter
			if (count($board_ids)==1) {
				$board_ext = " and board_id=".$board_ids[0];
			}
			else {
				$board_ext = " and board_id in (".implode(',', $board_ids).")";
			}
		}
		foreach (explode(',', $flow_info['item_ids']) as $i=>$item_id) {
			$board_status = D('StatusStatus')->relation(true)->where("flow_id=".$id." and item_id=".$item_id." and sort=".$i.$board_ext)->order("board_id")->select();
			foreach ($board_status as $j=>$status) {
				$board_status[$j]['comment'] = D('Comment')->relation(true)->where(array('model_name'=>'StatusStatus', 'model_id'=>$status['id']))->order('id')->select();
				$board_status[$j]['last_comment'] = M('Comment')->where(array('model_name'=>'StatusStatus', 'model_id'=>$status['id']))->order('id desc')->find();
				//load revision as title
				$tmp_rs = M('StatusRevision')->where("status_id=".$status['id'])->order('sort')->select();
				empty($tmp_rs) && ($tmp_rs = array());
				$tmp_result = array(
					'System' => array_fill_keys(array_keys($this->RevArray), ''),
					'User' => array()
					);
				foreach ($tmp_rs as $row) {
					if (array_key_exists($row['field'], $tmp_result['System'])) {
						$tmp_result['System'][$this->RevArray[$row['field']]] = $row['value'];
					}
					else {
						$tmp_result['User'][$row['field']] = $row['value'];
					}
				}
				$title = '';
				foreach ($tmp_result as $tmp_arr1) {
					foreach ($tmp_arr1 as $tmp_key=>$tmp_val) {
						if(''==trim($tmp_val)) {
							continue;
						}
						$title .= '<b>'.$tmp_key.': </b>'.$tmp_val.'<br />';
					}
				}
				$board_status[$j]['title'] = $title;
			}
			$item_board_status[$i] = array(
				'item_info' => M('StatusItem')->find($item_id),
				'owner' => M('Staff')->where("id=".$owner_arr[$i])->getField('realname'),
				'board_status' => $board_status
			);
		}
		$op = empty($_REQUEST['op']) ? '' : trim($_REQUEST['op']);
		if ('export' == $op) {
			include_once (LIB_PATH.'PHPExcel.php');
			$COLS = array();
			$last_col = 'A';
			for ($i=0; $i<count($board_list)+4; $i++) {
				$COLS[] = $last_col;
				$last_col ++;
			}
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
				->setTitle('Board Status Test Flow: '.$flow_info['name'])
				->setSubject('Board Status Test Flow: '.$flow_info['name']);
			$objPHPExcel->setActiveSheetIndex(0);

			$Style_BoardTH = new PHPExcel_Style();
			$Style_BoardTH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CCCCFF'
						)
					)
				)
			);
			$Style_BoardTD = new PHPExcel_Style();
			$Style_BoardTD->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '0000FF')
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CCFFFF'
						)
					)
				)
			);
			$Style_BoardInfo = new PHPExcel_Style();
			$Style_BoardInfo->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CCFFFF'
						)
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_TOP,
						'wrap' => true
					)
				)
			);
			$Style_ItemTH = new PHPExcel_Style();
			$Style_ItemTH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => '9999CC'
						)
					)
				)
			);
			$Style_StatusTH = new PHPExcel_Style();
			$Style_StatusTH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CC99FF'
						)
					)
				)
			);
			$Style_Status_None = new PHPExcel_Style();
			$Style_Status_None->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '808080')
					)
				)
			);
			$Style_Status_Pass = new PHPExcel_Style();
			$Style_Status_Pass->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '339900')
					)
				)
			);
			$Style_Status_Pending = new PHPExcel_Style();
			$Style_Status_Pending->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '0000FF')
					)
				)
			);
			$Style_Status_Failed = new PHPExcel_Style();
			$Style_Status_Failed->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => 'FF0000')
					)
				)
			);

			$Style_BoardStatusTH = new PHPExcel_Style();
			$Style_BoardStatusTH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => '9999CC'
						)
					)
				)
			);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Board Name: ');
			$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Board Information: ');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_BoardTH, 'A1:C2');
			$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(50);

			foreach ($board_list as $i=>$board) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($COLS[3+$i])->setWidth(15);
				$objPHPExcel->getActiveSheet()->setCellValue($COLS[3+$i].'1', $board['name']);
				$objPHPExcel->getActiveSheet()->setCellValue($COLS[3+$i].'2', $board['info']);
			}
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_BoardTD, 'D1:'.$COLS[3+$i].'1');
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_BoardInfo, 'D2:'.$COLS[3+$i].'2');

			$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Board Status');
			$objPHPExcel->getActiveSheet()->mergeCells('D3:'.$COLS[3+$i].'3');
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_StatusTH, 'D3:'.$COLS[3+$i].'3');

			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
			$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Test Item');
			$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Default Test Owner');
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_ItemTH, 'A3:C3');

			foreach ($item_board_status as $j=>$item) {
				$objPHPExcel->getActiveSheet()->setCellValue('A'.(4+$j), $j+1);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.(4+$j), $item['item_info']['name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.(4+$j), $item['owner']);
				foreach ($item['board_status'] as $k=>$status) {
					$objPHPExcel->getActiveSheet()->setCellValue($COLS[3+$k].(4+$j), $this->status_arr[$status['status']]);
					switch ($status['status']) {
						case '-1':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_None, $COLS[3+$k].(4+$j));
							break;
						case '0':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pending, $COLS[3+$k].(4+$j));
							break;
						case '1':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pass, $COLS[3+$k].(4+$j));
							break;
						case '2':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Failed, $COLS[3+$k].(4+$j));
							break;
						default:
							//
					}
					empty($status['comment']) && $status['comment']=array();
					foreach ($status['comment'] as $comment) {
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->setAuthor($comment['staff']['realname']);
						$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->getText()->createTextRun('['.$comment['staff']['realname'].']@'.$comment['create_time'].':');
						$objCommentRichText->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->getText()->createTextRun("\r\n");
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->getText()->createTextRun($comment['content']."\r\n");
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->setWidth('180pt');
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->setHeight('180pt');
					}
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.(4+$j).':'.$COLS[3+$k].(4+$j))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle('A'.(4+$j).':'.$COLS[3+$k].(4+$j))->getFill()->getStartColor()->setRGB($j%2?'CCCCCC':'EEEEEE');
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A'.(5+$j), 'Board Final Status: ');
			$objPHPExcel->getActiveSheet()->mergeCells('A'.(5+$j).':C'.(5+$j));
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_BoardStatusTH, 'A'.(5+$j).':C'.(5+$j));
			foreach ($board_list as $i=>$board) {
				$objPHPExcel->getActiveSheet()->setCellValue($COLS[3+$i].(5+$j), $this->status_arr[$board['status']]);
				switch ($board['status']) {
					case '-1':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_None, $COLS[3+$i].(5+$j));
						break;
					case '0':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pending, $COLS[3+$i].(5+$j));
						break;
					case '1':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pass, $COLS[3+$i].(5+$j));
						break;
					case '2':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Failed, $COLS[3+$i].(5+$j));
						break;
					default:
						//
				}
				empty($board['comment']) && $board['comment']=array();
				foreach ($board['comment'] as $comment) {
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->setAuthor($comment['staff']['realname']);
					$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->getText()->createTextRun('['.$comment['staff']['realname'].']@'.$comment['create_time'].':');
					$objCommentRichText->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->getText()->createTextRun("\r\n");
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->getText()->createTextRun($comment['content']."\r\n");
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->setWidth('180pt');
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->setHeight('180pt');
				}
			}
			$objPHPExcel->getActiveSheet()->getStyle('D'.(5+$j).':'.$COLS[3+$i].(5+$j))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle('D'.(5+$j).':'.$COLS[3+$i].(5+$j))->getFill()->getStartColor()->setRGB('99CCFF');


			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$flow_info['name'].'.xls"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;

		}

		$this->assign('flow_info', $flow_info);
		$this->assign('board_list', $board_list);
		$this->assign('item_board_status', $item_board_status);

		$this->assign('ACTION_TITLE', 'Flow Detail');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function flow2() {
		Session::set('sub', MODULE_NAME);

		$this->assign('request', $_REQUEST);

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$board_where = array(
			'flow_id' => $id
			);
		if (!empty($_REQUEST['board_name'])) {
			$board_name = trim($_REQUEST['board_name']);
			if (strlen($board_name)>0) {
				$board_where['name'] = array('like', '%'.$board_name.'%');
			}
		}
		if (!empty($_REQUEST['board_info'])) {
			$board_info = trim($_REQUEST['board_info']);
			if (strlen($board_info)>0) {
				$board_where['info'] = array('like', '%'.$board_info.'%');
			}
		}
		if (isset($_REQUEST['board_status'])) {
			$board_status = intval($_REQUEST['board_status']);
			if ($board_status>-2) {
				$board_where['status'] = $board_status;
			}
		}
		if (isset($_REQUEST['owner_id'])) {
			$board_owner_id = intval($_REQUEST['owner_id']);
		}
		$owner_arr = M('StatusBoard')->join("Inner Join erp_staff on erp_staff.id=erp_status_board.owner_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('owner_opts', self::genOptions($owner_arr, $board_owner_id, 'realname'));
		if (!empty($board_owner_id)) {
			$board_where['owner_id'] = $board_owner_id;
		}
		$selected_item_id = 0;
		$selected_item_index = -1;
		if (!empty($_REQUEST['item_id'])) {
			$selected_item_id = intval($_REQUEST['item_id']);
		}

		$flow_info = $this->dao->find($id);

		$flow_item_arr = array();
		$item_ids = explode(',', $flow_info['item_ids']);
		foreach ($item_ids as $i=>$item_id) {
			if ($selected_item_id == $item_id) {
				$selected_item_index = $i;
			}
			$item_list[$i] = M('StatusItem')->find($item_id);
			$item_list[$i]['status_count'] = M('StatusStatus')->where("flow_id=".$id." and item_id=".$item_id." and update_time>'0000-00-00 00:00:00'")->count();
			$flow_item_arr[$i] = $item_list[$i];
			$flow_item_arr[$i]['name'] = ($i+1).'.&nbsp;'.$flow_item_arr[$i]['name'];
		}
		$owner_ids = explode(',', $flow_info['owner_ids']);
		foreach ($owner_ids as $i=>$owner_id) {
			$owner_list[$i] = M('Staff')->where("id=".$owner_id)->getField('realname');
		}
		if ($selected_item_id > 0) {
			$item_ids = array($item_ids[$selected_item_index]);
			$tmp_arr = $item_list;
			unset($item_list);
			$item_list = array($selected_item_index => $tmp_arr[$selected_item_index]);
			$owner_list = array($owner_list[$selected_item_index]);
		}
		$this->assign('flow_item_opts', self::genOptions($flow_item_arr, $selected_item_id));

		$board_list = D('StatusBoard')->relation(true)->where($board_where)->order('id')->select();
		foreach ($board_list as $i=>$board) {
			if ($board['owner_id'] < 0) {
				$board_list[$i]['owner'] = array(
					'realname' => '['.M('Location')->where("id=".abs($board['owner_id']))->getField('name').']'
					);
			}
			$board_item = array();
			foreach ($item_ids as $j=>$item_id) {
				$status = M('StatusStatus')->where("board_id=".$board['id']." and flow_id=".$id." and item_id=".$item_id)->find();
				$board_item[$j] = array(
					'status_id' => $status['id'],
					'status' => $status['status'],
					'last_comment' => M('Comment')->where(array('model_name'=>'StatusStatus', 'model_id'=>$status['id']))->order('id desc')->find()
					);

				//load revision as title
				$tmp_rs = M('StatusRevision')->where("status_id=".$status['id'])->order('sort')->select();
				empty($tmp_rs) && ($tmp_rs = array());
				$tmp_result = array(
					'System' => array_fill_keys(array_keys($this->RevArray), ''),
					'User' => array()
					);
				foreach ($tmp_rs as $row) {
					if (array_key_exists($row['field'], $tmp_result['System'])) {
						$tmp_result['System'][$this->RevArray[$row['field']]] = $row['value'];
					}
					else {
						$tmp_result['User'][$row['field']] = $row['value'];
					}
				}
				$title = '';
				foreach ($tmp_result as $tmp_arr1) {
					foreach ($tmp_arr1 as $tmp_key=>$tmp_val) {
						if(''==trim($tmp_val)) {
							continue;
						}
						$title .= '<b>'.$tmp_key.': </b>'.$tmp_val.'<br />';
					}
				}
				$board_item[$j]['title'] = $title;
			}
		//	dump($board_item);
			$board_list[$i]['board_item'] = $board_item;
			$board_list[$i]['comment'] = D('Comment')->relation(true)->where(array('model_name'=>'StatusBoard', 'model_id'=>$board['id']))->order('id')->select();
			$board_list[$i]['last_comment'] = M('Comment')->where(array('model_name'=>'StatusBoard', 'model_id'=>$board['id']))->order('id desc')->find();
		}


		$op = empty($_REQUEST['op']) ? '' : trim($_REQUEST['op']);
		if ('export' == $op) {
			include_once (LIB_PATH.'PHPExcel.php');
			$COLS = array();
			$last_col = 'A';
			for ($i=0; $i<count($item_list)+6; $i++) {
				$COLS[] = $last_col;
				$last_col ++;
			}
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
				->setTitle('Board Status Test Flow: '.$flow_info['name'])
				->setSubject('Board Status Test Flow: '.$flow_info['name']);
			$objPHPExcel->setActiveSheetIndex(0);

			$Style_ItemTH = new PHPExcel_Style();
			$Style_ItemTH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CCCCFF'
						)
					)
				)
			);
			$Style_ItemTD = new PHPExcel_Style();
			$Style_ItemTD->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CCCCFF'
						)
					)
				)
			);
			$Style_TH = new PHPExcel_Style();
			$Style_TH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => '9999CC'
						)
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					)
				)
			);

			$Style_Status_TBD = new PHPExcel_Style();
			$Style_Status_TBD->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '808080')
					)
				)
			);
			$Style_Status_Pass = new PHPExcel_Style();
			$Style_Status_Pass->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '009900')
					)
				)
			);
			$Style_Status_Ongoing = new PHPExcel_Style();
			$Style_Status_Ongoing->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '0000FF')
					)
				)
			);
			$Style_Status_Failed = new PHPExcel_Style();
			$Style_Status_Failed->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => 'FF0000')
					)
				)
			);
			$Style_Status_Ignore = new PHPExcel_Style();
			$Style_Status_Ignore->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '0099FF')
					)
				)
			);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Test Item: ');
			$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Default Test Owner: ');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_ItemTH, 'A1:E2');

			foreach ($item_list as $i=>$item) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($COLS[5+$i])->setWidth(15);
				$objPHPExcel->getActiveSheet()->setCellValue($COLS[5+$i].'1', $item['name']);
				$objPHPExcel->getActiveSheet()->setCellValue($COLS[5+$i].'2', $owner_list[$i]);
				$objPHPExcel->getActiveSheet()->setCellValue($COLS[5+$i].'3', 'Status');
			}
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_ItemTD, 'E1:'.$COLS[5+$i].'2');

			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Board Name');
			$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Board Owner');
			$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Information');
			$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Final Status');
			$objPHPExcel->getActiveSheet()->setCellValue('E3', 'Board Remark');

			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_TH, 'A3:'.$COLS[5+$i].'3');

			foreach ($board_list as $j=>$board) {
				$objPHPExcel->getActiveSheet()->setCellValue('A'.(4+$j), $board['name']);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.(4+$j), $board['owner']['realname']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.(4+$j), $board['info']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.(4+$j), $this->status_arr[$board['status']]);
				switch ($board['status']) {
					case '-1':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_TBD, 'D'.(4+$j));
						break;
					case '0':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Ongoing, 'D'.(4+$j));
						break;
					case '1':
					case '9':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pass, 'D'.(4+$j));
						break;
					case '2':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Failed, 'D'.(4+$j));
						break;
					case '8':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Ignore, 'D'.(4+$j));
						break;
					default:
						//
				}
				$objPHPExcel->getActiveSheet()->setCellValue('E'.(4+$j), $board['remark']);
				foreach ($board['board_item'] as $k=>$item) {
					$objPHPExcel->getActiveSheet()->setCellValue($COLS[5+$k].(4+$j), $this->status_arr[$item['status']]);
					switch ($item['status']) {
						case '-1':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_TBD, $COLS[5+$k].(4+$j));
							break;
						case '0':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Ongoing, $COLS[5+$k].(4+$j));
							break;
						case '1':
						case '9':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pass, $COLS[5+$k].(4+$j));
							break;
						case '2':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Failed, $COLS[5+$k].(4+$j));
							break;
						case '8':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Ignore, $COLS[5+$k].(4+$j));
							break;
						default:
							//
					}
					empty($item['comment']) && $item['comment']=array();
					foreach ($item['comment'] as $comment) {
						$objPHPExcel->getActiveSheet()->getComment($COLS[5+$k].(4+$j))->setAuthor($comment['staff']['realname']);
						$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment($COLS[5+$k].(4+$j))->getText()->createTextRun('['.$comment['staff']['realname'].']@'.$comment['create_time'].':');
						$objCommentRichText->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getComment($COLS[5+$k].(4+$j))->getText()->createTextRun("\r\n");
						$objPHPExcel->getActiveSheet()->getComment($COLS[5+$k].(4+$j))->getText()->createTextRun($comment['content']."\r\n");
						$objPHPExcel->getActiveSheet()->getComment($COLS[5+$k].(4+$j))->setWidth('180pt');
						$objPHPExcel->getActiveSheet()->getComment($COLS[5+$k].(4+$j))->setHeight('180pt');
					}
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.(4+$j).':'.$COLS[5+$k].(4+$j))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle('A'.(4+$j).':'.$COLS[5+$k].(4+$j))->getFill()->getStartColor()->setRGB($j%2?'CCCCCC':'EEEEEE');
			}


			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$flow_info['name'].'.xls"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;
		}

		$this->assign('flow_info', $flow_info);
		$this->assign('item_list', $item_list);
		$this->assign('owner_list', $owner_list);

		$this->assign('board_list', $board_list);

		$this->assign('ACTION_TITLE', 'Flow Detail');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	public function board() {
		Session::set('sub', MODULE_NAME);
		$dao = D('StatusBoard');

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if (!empty($_POST['submit'])) {
			$board_name = trim($_REQUEST['board_name']);
			!$board_name && self::_error('Board name required!');

			$flow_id = intval($_REQUEST['flow_id']);
			/*
			$rs = $dao->where("flow_id=".$flow_id)->order("name desc")->find();
			if (!empty($rs)) {
				$max_name = $rs['name'];
				$board_name = ++$max_name;
			}
			else {
				$board_name .= sprintf("%03d", 1);
			}
			*/
			$dao->id = 0;
			$dao->flow_id = $flow_id;
			$dao->name = $board_name;
			$dao->info = trim($_REQUEST['board_info']);
			$dao->owner_id = !empty($_REQUEST['board_owner_id'])?intval($_REQUEST['board_owner_id']):self::get_owner($board_name);
			$dao->create_time = date('Y-m-d H:i:s');
			$dao->status = -1;
			if($board_id = $dao->add()) {
				//add item status
				$flow_info = $this->dao->find($flow_id);
				$item_ids = explode(',', $flow_info['item_ids']);
				$owner_ids = explode(',', $flow_info['owner_ids']);
				$last_owner_id = $owner_ids[0];
				foreach ($item_ids as $i=>$item_id) {
					if (empty($owner_ids[$i])) {
						$owner_id = $last_owner_id;
					}
					else {
						$owner_id = $owner_ids[$i];
						$last_owner_id = $owner_id;
					}
					$status_data = array(
						'flow_id' => $flow_id,
						'board_id' => $board_id,
						'item_id' => $item_id,
						'owner_id' => $owner_id,
						'substitute_id' => 0,
						'sort' => $i,
						'status' => -1,
						'mail_time' => 0
					);
					if (!M('StatusStatus')->add($status_data)) {
						self::_error('Add status fail!'.$this->dao->getLastSql());
					}
				}
				self::_success('Add board success!',__URL__);
			}
			else{
				self::_error('Add board fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
		elseif (!empty($_REQUEST['op'])) {
			$op = trim($_REQUEST['op']);

			if ('delete' == $op) {
				//delete status
				M('StatusStatus')->where(array('board_id'=>$id))->delete();

				$this->dao = $dao;
				self::_delete();
			}
			elseif ('add' == $op) {
				$flow_id = intval($_REQUEST['flow_id']);
				$this->assign('flow_info', $this->dao->relation(true)->find($flow_id));

				$rs = $dao->where("flow_id=".$flow_id)->order("name desc")->find();
				$name = '';
				$name_ext = '';
				$info = '';
				if (!empty($rs)) {
					$max_name = $rs['name'];
					$name_ext = ++$max_name;
					$name = substr($max_name, 0, -3);
					$info = $rs['info'];
				}
				$info = array(
					'name' => $name,
					'name_ext' => $name_ext,
					'info' => $info,
					'owner_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->select(), 0, 'realname')
				);
				$this->assign('info', $info);

				$this->assign('content', ACTION_NAME.'_add');
				$this->display('Layout:content');
			}
		}
		else {
			$info = $dao->relation(true)->find($id);
			if ($info['owner_id'] < 0) {
				$info['owner'] = array(
					'realname' => '['.M('Location')->where("id=".abs($info['owner_id']))->getField('name').']'
					);
			}
			$info['owner_opts'] = self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $info['owner_id'], 'realname');

			$status_list = D('StatusStatus')->relation(true)->where(array('flow_id'=>$info['flow_id'], 'board_id'=>$id))->order('sort')->select();
			foreach ($status_list as $i=>$status) {
				$status_list[$i]['owner_opts'] = self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $status['owner_id'], 'realname');
				$status_list[$i]['substitute_opts'] = self::genOptions(M('Staff')->where(array('status'=>1, 'id'=>array('neq', $status['owner_id'])))->order('realname')->select(), $status['substitute_id'], 'realname');
			}
			$info['status_list'] = $status_list;
			$info['comment'] = D('Comment')->relation(true)->where(array('model_name'=>'StatusBoard', 'model_id'=>$id, 'status'=>1))->order('id')->select();
			$this->assign('info', $info);
			$this->assign('ACTION_TITLE', 'Board Detail');
			$this->assign('content', ACTION_NAME);
			$this->display('Layout:ERP_layout');
		}
	}

	public function revision() {
		$RevArray = array(
			'Software' => 'Software Rev',
			'Logic' => 'Logic Rev',
			'FCT' => 'FCT Rev',
			'Host' => 'Host Rev'
		);
		$RevSort = array(
			'Software' => 1,
			'Logic' => 2,
			'FCT' => 3,
			'Host' => 4
		);
		$this->assign('RevArray', $RevArray);
		$status_id = empty($_REQUEST['status_id']) ? 0 : intval($_REQUEST['status_id']);
		$this->assign('status_id', $status_id);
		$board_id = empty($_REQUEST['board_id']) ? 0 : intval($_REQUEST['board_id']);
		$this->assign('board_id', $board_id);
		$flow_id = empty($_REQUEST['flow_id']) ? 0 : intval($_REQUEST['flow_id']);
		$this->assign('flow_id', $flow_id);
		$item_id = empty($_REQUEST['item_id']) ? 0 : intval($_REQUEST['item_id']);
		$this->assign('item_id', $item_id);

		if (!empty($_POST['submit'])) {
			//flow_id>0 and item_id>0 means batch mode
			if ($flow_id>0 && $item_id>0) {
				//get all board_id
				$board_arr = M('StatusStatus')->where("flow_id=".$flow_id." and item_id=".$item_id)->getField('id,board_id');
				$status_id = 99999;
			}
			else {
				$board_arr = array($status_id=>$board_id);
			}
			if (!empty($_REQUEST['field'])) {
				//user added field
				foreach ($_REQUEST['field'] as $i=>$field) {
					if (''==trim($field) || ''==trim($_REQUEST['value'][$i])) {
						continue;
					}
					if (array_key_exists(trim($field), $RevArray)) {
						self::_error('The field name: "'.$field.'" is not allowed');
					}
					foreach ($board_arr as $status_id=>$board_id) {
						$data = array(
							'board_id' => $board_id,
							'status_id' => $status_id,
							'field' => $field,
							'value' => trim($_REQUEST['value'][$i]),
							'sort' => 10,
							'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
							'update_time' => date('Y-m-d H:i:s')
						);
						if (!M('StatusRevision')->add($data)) {
							self::_error('Add ext revision entry fail!<br />'.$this->dao->getLastSql());
						}
						if ($board_id > 0) {
							self::write_log('Manually', 'Set extended Revision['.$field.'='.trim($_REQUEST['value'][$i]).'] for Board('.$board_id.': '.M('StatusBoard')->where("id=".$board_id)->getField('name').')');
						}
						elseif($status_id > 0) {
							$status_info = M('StatusStatus')->where("id=".$status_id)->find();
							self::write_log('Manually', 'Set extended Revision['.$field.'='.trim($_REQUEST['value'][$i]).'] for Item('.$status_info['item_id'].': '.M('StatusItem')->where("id=".$status_info['item_id'])->getField('name').') of Board('.$status_info['board_id'].': '.M('StatusBoard')->where("id=".$status_info['board_id'])->getField('name').')');
						}
					}
				}
			}
			if (!empty($_REQUEST['_field'])) {
				//system field
				foreach ($_REQUEST['_field'] as $i=>$field) {
					if (''==trim($_REQUEST['_value'][$i])) {
						continue;
					}
					foreach ($board_arr as $status_id=>$board_id) {
						$data = array(
							'board_id' => $board_id,
							'status_id' => $status_id,
							'field' => $field,
							'value' => trim($_REQUEST['_value'][$i]),
							'sort' => $RevSort[$field],
							'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
							'update_time' => date('Y-m-d H:i:s')
						);
						if (!M('StatusRevision')->add($data)) {
							self::_error('Add revision entry fail!<br />'.$this->dao->getLastSql());
						}
						if ($board_id > 0) {
							self::write_log('Manually', 'Set Revision['.$field.'='.trim($_REQUEST['_value'][$i]).'] for Board('.$board_id.': '.M('StatusBoard')->where("id=".$board_id)->getField('name').')');
						}
						elseif($status_id > 0) {
							$status_info = M('StatusStatus')->where("id=".$status_id)->find();
							self::write_log('Manually', 'Set Revision['.$field.'='.trim($_REQUEST['_value'][$i]).'] for Item('.$status_info['item_id'].': '.M('StatusItem')->where("id=".$status_info['item_id'])->getField('name').') of Board('.$status_info['board_id'].': '.M('StatusBoard')->where("id=".$status_info['board_id'])->getField('name').')');
						}
					}
				}
			}
			if (!empty($_REQUEST['_id'])) {
				//edit exists field, not available in batch mode
				foreach ($_REQUEST['_id'] as $id=>$value) {
					if (empty($id)) {
						continue;
					}
					$dao = M('StatusRevision');
					$dao->find($id);
					if (''==trim($value)) {
						//delete the entry
						$dao->delete();
						if ($board_id > 0) {
							self::write_log('Manually', 'Delete Revision['.$dao->field.'='.$dao->value.'] of Board('.$board_id.': '.M('StatusBoard')->where("id=".$board_id)->getField('name').')');
						}
						elseif($status_id > 0) {
							$status_info = M('StatusStatus')->where("id=".$status_id)->find();
							self::write_log('Manually', 'Delete Revision['.$dao->field.'='.$dao->value.'] of Item('.$status_info['item_id'].': '.M('StatusItem')->where("id=".$status_info['item_id'])->getField('name').') of Board('.$status_info['board_id'].': '.M('StatusBoard')->where("id=".$status_info['board_id'])->getField('name').')');
						}
					}
					else {
						if ($dao->value == trim($value)) {
							continue;
						}
						$old_value = $dao->value;
						$dao->value = trim($value);
						$dao->update_time = date('Y-m-d H:i:s');
						if (false === $dao->save()) {
							self::_error('Update revision entry fail!<br />'.$this->dao->getLastSql());
						}
						if ($board_id > 0) {
							self::write_log('Manually', 'Change Revision['.$dao->field.'] of Board('.$board_id.': '.M('StatusBoard')->where("id=".$board_id)->getField('name').') from ['.$old_value.'] to ['.trim($value).']');
						}
						elseif($status_id > 0) {
							$status_info = M('StatusStatus')->where("id=".$status_id)->find();
							self::write_log('Manually', 'Change Revision['.$dao->field.'] of Item('.$status_info['item_id'].': '.M('StatusItem')->where("id=".$status_info['item_id'])->getField('name').') of Board('.$status_info['board_id'].': '.M('StatusBoard')->where("id=".$status_info['board_id'])->getField('name').') from ['.$old_value.'] to ['.trim($value).']');
						}
					}
				}
			}
			$value = intval($_REQUEST['status']);
			if (0==$flow_id && 0==$item_id && $board_id > 0) {
				//改变Board状态
				$dao = M('StatusBoard');
				$info = $dao->find($board_id);
				if ($info['status'] != $value) {
					$dao->where('id='.$board_id)->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
					self::write_log('Manually', 'Change finnal status of Board('.$info['id'].': '.$info['name'].') from ['.$this->status_arr[$info['status']].'] to ['.$this->status_arr[$value].']');
				}
			}
			elseif ($status_id > 0) {
				//改变Status状态
				foreach ($board_arr as $status_id=>$board_id) {
					$value = intval($_REQUEST['status']);
					$dao = M('StatusStatus');
					$info = $dao->find($status_id);
					$item = M('StatusItem')->find($info['item_id']);
					$board = M('StatusBoard')->find($info['board_id']);
					if ($info['status'] != $value) {
						$dao->where("id=".$status_id)->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
						self::write_log('Manually', 'Change status of Item('.$item['id'].': '.$item['name'].') of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$info['status']].'] to ['.$this->status_arr[$value].']');
					}

					$status_count = M('StatusStatus')->where("board_id=".$board['id'])->group('status')->getField('status,count(*)');
					if ($status_count[2] > 0) {
						//有Fail
						$value = 2;//设为Fail
					}
					else {
						//没有Fail
						if ($status_count[0] > 0) {
							//有Ongoing
							$value = 0;//设为Ongoing
						}
						else {
							//没有Pending
							if ($status_count[-1] > 0) {
								//有TBD
								if ($status_count[1]>0) {
									//有Pass
									$value = 0;//设为Ongoing
								}
								else {
									//全部TBD，或还有Ignore
									$value = -1;//设为TBD
								}
							}
							else {
								//没有TBD，只剩Pass和Ignore
								if ($status_count[8]>0) {
									//有Ignore
									$value = 9;//设为Pass*
								}
								else {
									//全部Pass
									$value = 1;//设为Pass
								}
							}
						}
					}
					if ($board['status'] != $value) {
						M('StatusBoard')->where("id=".$board['id'])->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
						self::write_log('Automatically', 'Change Board('.$board['id'].': '.$board['name'].') finnal status from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[$value].']');
					}
				}
			}
			self::_success('Revision and Status updated!');
		}

		$result = array();
		if (!empty($flow_id) && !empty($item_id)) {
			$rs = array();
			$info = $this->dao->find($flow_id);
			$item_arr = explode(',', $info['item_ids']);
			$owner_arr = explode(',', $info['owner_ids']);
			foreach($item_arr as $key=>$val) {
				if ($item_id == $val) {
					$result['Status']['owner_id'] = $owner_arr[$key];
				}
			}
		}
		else {
			if (!empty($status_id)) {
				$where = "status_id=".$status_id;
				$result['Status'] = D('StatusStatus')->relation(true)->find($status_id);
			}
			if (!empty($board_id)) {
				$where = "board_id=".$board_id;
				$result['Status'] = D('StatusBoard')->relation(true)->find($board_id);
			}
			$rs = M('StatusRevision')->where($where)->order('sort')->select();
			empty($rs) && ($rs = array());
		}

		$result['System'] = array_fill_keys(array_keys($RevArray), '');
		$result['User'] = array();
		foreach ($rs as $i=>$row) {
			if (array_key_exists($row['field'], $RevArray)) {
				$result['System'][$row['field']] = $row;
			}
			else {
				$result['User'][$row['field']] = $row;
			}
		}
		$this->assign('result', $result);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:content');
	}
	public function status() {
		$flow_id = empty($_REQUEST['flow_id']) ? 0 : intval($_REQUEST['flow_id']);
		$this->assign('flow_id', $flow_id);
		$item_id = empty($_REQUEST['item_id']) ? 0 : intval($_REQUEST['item_id']);
		$this->assign('item_id', $item_id);

		if (!empty($_POST['submit'])) {
			$dao = M('StatusStatus');
			foreach ($_REQUEST['status'] as $status_id=>$value) {
				//改变Status状态
				$info = $dao->find($status_id);
				$item = M('StatusItem')->find($info['item_id']);
				$board = M('StatusBoard')->find($info['board_id']);
				if ($info['status'] != $value) {
					$dao->where("id=".$status_id)->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
					self::write_log('Manually', 'Change status of Item('.$item['id'].': '.$item['name'].') of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$info['status']].'] to ['.$this->status_arr[$value].']');
				}

				//自动更新Board Status
				$status_count = M('StatusStatus')->where("board_id=".$board['id'])->group('status')->getField('status,count(*)');
				if ($status_count[2] > 0) {
					//有Fail
					$value = 2;//设为Fail
				}
				else {
					//没有Fail
					if ($status_count[0] > 0) {
						//有Ongoing
						$value = 0;//设为Ongoing
					}
					else {
						//没有Pending
						if ($status_count[-1] > 0) {
							//有TBD
							if ($status_count[1]>0) {
								//有Pass
								$value = 0;//设为Ongoing
							}
							else {
								//全部TBD，或还有Ignore
								$value = -1;//设为TBD
							}
						}
						else {
							//没有TBD，只剩Pass和Ignore
							if ($status_count[8]>0) {
								//有Ignore
								$value = 9;//设为Pass*
							}
							else {
								//全部Pass
								$value = 1;//设为Pass
							}
						}
					}
				}
				if ($board['status'] != $value) {
					M('StatusBoard')->where("id=".$board['id'])->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
					self::write_log('Automatically', 'Change Board('.$board['id'].': '.$board['name'].') finnal status from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[$value].']');
				}
			}
			self::_success('All Boards\' Status updated!');
		}

		$result = array();
		$where = array(
			'flow_id' => $flow_id,
			'item_id' => $item_id
			);
		$result = D('StatusStatus')->relation(true)->where($where)->select();
		$this->assign('result', $result);
		$this->assign('item_info', M('StatusItem')->find($item_id));

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:content');
	}

	public function update() {
		$board_id = empty($_REQUEST['board_id']) ? 0 : intval($_REQUEST['board_id']);
		$status_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$field = $_REQUEST['f'];
		$value = trim($_REQUEST['v']);
		$rs = true;
		if ($board_id > 0) {
			//更新Board表记录
			$dao = D('StatusBoard');
			$info = $dao->relation(true)->find($board_id);
			if ($info[$field] != $value) {
				if ('name' == $field) {
					if (M('StatusBoard')->where("id!=".$board_id." and name='".$value."'")->count() > 0) {
						self::_error('The board name: '.$value.' is exists!');
					}
					$owner_id = self::get_owner($value);
					$dao->where('id='.$board_id)->setField(array($field, 'owner_id', 'update_time'), array($value, $owner_id, date('Y-m-d H:i:s')));
					if ($owner_id != $info['owner_id']) {
						if ($info['owner_id'] < 0) {
							$info['owner']['realname'] = M('Location')->where("id=".abs($info['owner_id']))->getField('name');
						}
						if ($owner_id < 0) {
							$owner_name = M('Location')->where("id=".abs($owner_id))->getField('name');
						}
						else {
							$owner_name = M('Staff')->where("id=".abs($owner_id))->getField('realname');
						}
						self::write_log('Automatically', "Change Board(".$info['id'].": ".$value.") Owner from [".$info['owner']['realname']."] to [".$owner_name."]");
					}
				}
				else {
					$dao->where('id='.$board_id)->setField(array($field, 'update_time'), array($value, date('Y-m-d H:i:s')));
				}

			}
		}
		elseif ($status_id > 0) {
			//更新Status表记录
			$dao = M('StatusStatus');
			$info = $dao->find($status_id);
			$old_value = $info[$field];
			if ($info[$field] != $value) {
				$dao->where("id=".$status_id)->setField(array($field, 'update_time'), array($value, date('Y-m-d H:i:s')));
				if ('owner_id'==$field || 'substitute_id'==$field) {
					$old_owner = M('Staff')->where("id=".$old_value)->getField('realname');
					$new_owner = M('Staff')->where("id=".$value)->getField('realname');
					$item = M('StatusItem')->find($info['item_id']);
					$board = M('StatusBoard')->find($info['board_id']);
					self::write_log('Manually', 'Change the '.str_replace('_id', '', $field).' of Item('.$item['id'].': '.$item['name'].') of Board('.$board['id'].': '.$board['name'].') from ['.$old_owner.'] to ['.$new_owner.']');
				}
			}

		}
		if(false !== $rs) {
			if ('POST' == strtoupper($_SERVER["REQUEST_METHOD"])) {
				die('Update success!');
			}
			self::_success('Update success!');
		}
		else {
			if ('POST' == strtoupper($_SERVER["REQUEST_METHOD"])) {
				die('Update fail!'.(C('APP_DEBUG')? $dao->getLastSql() : ''));
			}
			self::_error('Update fail!'.(C('APP_DEBUG')? $dao->getLastSql() : ''));
		}
	}
	public function template() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$dao = D('StatusTemplate');

		if (!empty($_POST['submit'])) {
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			$name = trim($_REQUEST['name']);
			!$name && self::_error('Template name required');
			empty($_REQUEST['item_id']) && self::_error('You must add at least one item!');
			if ($id>0) {
				$dao->find($id);
			}
			else {
				$dao->create_time = date('Y-m-d H:i:s');
			}
			$dao->name = $name;
			$dao->item_ids = implode(',', $_REQUEST['item_id']);
			$dao->owner_ids = implode(',', $_REQUEST['owner_id']);
			$dao->creator_id = $_SESSION[C('USER_AUTH_KEY')];
			$dao->update_time = date('Y-m-d H:i:s');
			if ($id>0) {
				if(false !== $dao->save()){
					self::_success('Template information updated!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				if($dao->add()) {
					self::_success('Template defined success!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Template defined fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
		}
		elseif (!empty($_REQUEST['op'])) {
			$op = trim($_REQUEST['op']);

			if ('form' == $op) {
				$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
				if ($id>0) {
					$info = $dao->find($id);
					$item_arr = explode(',', $info['item_ids']);
					$owner_arr = explode(',', $info['owner_ids']);
					$info['item_list'] = array();
					foreach ($item_arr as $i=>$item_id) {
						$item = D('StatusItem')->find($item_id);
						$info['item_list'][] = array(
							'id' => $item_id,
							'name' => $item['name'],
							'staff_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $owner_arr[$i], 'realname')
						);
					}
				}
				else {
					$info = array(
						'id' => 0,
						'name' => '',
						'item_list' => array()
					);
				}
				$this->assign('info', $info);
				//load item
				$this->assign('item_list', D('StatusItem')->order('sort')->select());
				$this->assign('content', ACTION_NAME.'_form');
			}
			elseif ('get_item' == $op) {
				$id = intval($_REQUEST['id']);
				$item = D('StatusItem')->find($id);
				$arr = array(
					'id' => $id,
					'name' => $item['name'],
					'staff_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $item['owner_id'], 'realname')
				);
				die(json_encode($arr));
			}
			elseif ('delete' == $op) {
				if (!empty($_REQUEST['id'])) {
					$id = intval($_REQUEST['id']);
					$this->dao = $dao;
					self::_delete();
				}
			}
		}
		else {
			$result = $dao->relation(true)->order('id')->select();
			$this->assign('result', $result);
			$this->assign('content', ACTION_NAME);
		}
		$this->assign('ACTION_TITLE', 'Flow Template');
		$this->display('Layout:ERP_layout');
	}

	public function item() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);

		$dao = D('StatusItem');
		if (!empty($_POST['submit'])) {
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			$name = trim($_REQUEST['name']);
			!$name && self::_error('Item name required');
			$type = $_REQUEST['type'];
			if ($id>0) {
				$rs = $dao->where(array('type'=>$type, 'name'=>$name, 'id'=>array('neq',$id)))->find();
				if($rs && sizeof($rs)>0){
					self::_error('The item: \''.$name.'\' already exists!');
				}
				$dao->find($id);
			}
			else {
				$rs = $dao->where(array('type'=>$type, 'name'=>$name))->find();
				if($rs && sizeof($rs)>0){
					self::_error('The item: \''.$name.'\' already exists!');
				}
			}
			$dao->name = $name;
			$dao->description = trim($_REQUEST['description']);
			$dao->owner_id = intval($_REQUEST['owner_id']);
			$dao->type = 'radio';
			$dao->sort = max(1, intval($_REQUEST['sort']));
			if ($id>0) {
				if(false !== $dao->save()){
					self::_success('Test item updated!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				if($dao->add()) {
					self::_success('Add item success!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Add item fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
		}
		elseif (!empty($_REQUEST['id'])) {
			$id = intval($_REQUEST['id']);
			$count = M('StatusTemplate')->where(array('_string'=>"item_ids like '".$id.",%' OR item_ids like '%,".$id.",%' OR item_ids like '%,".$id."'"))->count();
			if ($count > 0) {
				self::_error('It\'s used in template, can\'t be deleted!');
			}
			$count = M('StatusFlow')->where(array('item_id'=>$id))->count();
			if($count > 0) {
				self::_error('It\'s used in flow, can\'t be deleted!');
			}
			else{
				$this->dao = $dao;
				self::_delete();
			}
		}

		$this->assign('staff_opts', self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), '', 'realname'));

		$result = $dao->relation(true)->order('sort')->select();
		$this->assign('result', $result);

		$this->assign('ACTION_TITLE', 'Test Item');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function delete() {
		$id = $_REQUEST['id'];

		//delete board
		M('StatusBoard')->where(array('flow_id'=>$id))->delete();
		//delete status
		M('StatusStatus')->where(array('flow_id'=>$id))->delete();

		self::_delete();
	}

	public function list_comment() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$this->assign('id', $id);
		$model = empty($_REQUEST['model']) ? 'StatusStatus' : trim($_REQUEST['model']);
		$this->assign('model', $model);
		$this->assign('comment', D('Comment')->relation(true)->where(array('model_name'=>$model, 'model_id'=>$id, 'status'=>1))->order('id')->select());
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:content');
	}

	public function comment() {
		if (!empty($_GET['id'])) {
			die(M('Comment')->where('id='.$_GET['id'])->getField('content'));
		}
		if (empty($_POST['submit'])) {
			return;
		}
		$dao = D('Comment');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$model_name = empty($_REQUEST['model_name']) ? MODULE_NAME : trim($_REQUEST['model_name']);
		empty($_REQUEST['model_id']) && self::_error('No board id specified!');
		$model_id = intval($_REQUEST['model_id']);
		$content = trim($_REQUEST['content']);
		!$content && self::_error('Comment can\'t be empty!');
		if ($id>0) {
			$dao->find($id);
		}
		else {
			$dao->model_name = $model_name;
			$dao->model_id = $model_id;
			$dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$dao->create_time = date('Y-m-d H:i:s');
			$dao->status = 1;
		}
		$dao->content = $content;
		if ($id>0) {
			if(false !== $dao->save()) {
				$html  = '<script language="JavaScript" type="text/javascript">';
				$html .= 'parent.myAlert("Update comment success!");';
				$html .= 'parent.myOK(500);';
				$html .= 'parent.show_comment('.$id.', "'.str_replace(array("\r\n", "\n"), '<br />', $content).'");';
				$html .= '</script>';
				die($html);
			}
			else{
				self::_error('Update comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
		else {
			if($id=$dao->add()) {
				$html  = '<script language="JavaScript" type="text/javascript">';
				$html .= 'parent.myAlert("Post comment success!");';
				$html .= 'parent.myOK(500);';
				$html .= 'parent.show_comment('.$id.', "'.str_replace(array("\r\n", "\n"), '<br />', $content).'");';
				$html .= '</script>';
				die($html);
			}
			else{
				self::_error('Post comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
	}
	public function delete_comment() {
		$id = intval($_REQUEST['id']);
		$dao = D('Comment');
		$info = $dao->find($id);
		if($id>0 && $dao->where("id=".$id)->delete()) {
			$html  = '<script language="JavaScript" type="text/javascript">';
			$html .= 'parent.myAlert("Delete comment success!");';
			$html .= 'parent.myOK(500);';
			$html .= 'parent.remove_comment('.$id.');';
			$html .= '</script>';
			die($html);
		}
		else {
			self::_error('Delete comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
		}
	}
	public function _mail($type='board', $id='') {
		if (!defined('APP_ROOT')) {
			define('APP_ROOT', 'http://'.$_SERVER['SERVER_ADDR'].__APP__);
		}
		$smtp_config = C('_smtp_');
		include_once (LIB_PATH.'class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
	//	$mail->SMTPDebug  = 1;  // 2 = messages only
		$mail->Host       = $smtp_config['host'];
		$mail->Port       = $smtp_config['port'];
		$mail->SetFrom($smtp_config['from_mail'], 'ERP System');

		switch ($type) {
			case 'flow':
				$flow = M('StatusFlow')->find($id);

				$style = '<style>'."\n";
				$style .= 'strong.TBD{color: #808080;}'."\n";
				$style .= 'strong.Pass, strong.PassX{color: #009900;}'."\n";
				$style .= 'strong.Ongoing{color: #0000FF;}'."\n";
				$style .= 'strong.Failed{color: #FF0000;}'."\n";
				$style .= 'strong.Ignore{color: #0099FF;}'."\n";
				$style .= 'th{font-weight:bold;}'."\n";
				$style .= '</style>'."\n";
				$body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>'."\n";
				$body .= '<table cellpadding="5" border="1" style="border-collapse:collapse;border:1px solid #666666;">'."\n";
				$body .= '<tr bgcolor="#9999cc"><th>Board Name</th><th>Board Infomation</th><th>Board Status</th><th>Board Owner</th><th>Create Time</th><th>Last Update Time</th></tr>'."\n";

				$body2 = '</table>'."\n";
				$body2 .= '<br /><br />For more information, please visit <a target="_blank" href="'.APP_ROOT.'/Status">ERP System -> Board Status</a>';
				$body2 .= '<br /><br />Best Regards,<br />'.C('ERP_TITLE');
				$body2 .= '</body></html>';

				$rs = D('StatusStatus')->where("flow_id=".$id." and status<=0")->field('if(substitute_id,substitute_id, owner_id) as staff_id, group_concat(distinct board_id) as board_ids')->group('staff_id')->select();
				empty($rs) && ($rs = array());
				foreach ($rs as $row) {
					$staff = M('Staff')->find($row['staff_id']);
					$subject = '[Board Status]: ['.$flow['name'].'] need ['.$staff['realname'].'] to update the test status';

					$header = 'Hi '.$staff['realname'].',<br />'."\n";
					$header .= '&nbsp;&nbsp;These boards in the below list need you to update.<br />'."\n";

					$board_arr = D('StatusBoard')->relation(true)->where("id in (".$row['board_ids'].")")->select();
					$table = '';
					foreach ($board_arr as $i=>$board) {
						if ($i%2) {
							$table .= '<tr bgcolor="#CCCCCC">'."\n";
						}
						else {
							$table .= '<tr bgcolor="#EEEEEE">'."\n";
						}
						$table .= '<td><a href="'.APP_ROOT.'/Status/board/id/'.$board['id'].'" target="_blank">'.$board['name'].'</a></td>'."\n";
						$table .= '<td>'.nl2br($board['info']).'</td>'."\n";
						$table .= '<td><strong class="'.$this->status_arr[$board['status']].'">'.$this->status_arr[$board['status']].'</strong></td>'."\n";
						$table .= '<td>'.$board['owner']['realname'].'</td>'."\n";
						$table .= '<td>'.$board['create_time'].'</td>'."\n";
						$table .= '<td>'.$board['update_time'].'</td>'."\n";
						$table .= '</tr>'."\n";
					}
					$mail->ClearAddresses();
					$mail->AddAddress($staff['email'], $staff['realname']);
					$mail->Subject = $subject;
					$mail->MsgHTML($style.$header.$body.$table.$body2);
					$debug = 'type='.$type.', flow_id='.$id.', staff_id='.$row['staff_id'];
					if(!$mail->Send()) {
						Log::Write('Mail status Error: '.$debug."\n".$mail->ErrorInfo, LOG::ERR);
					}
					else {
						Log::Write('Mail status Success: '.$debug, LOG::INFO);
					}
				}
				break;

			case 'board':
				$board = D('StatusBoard')->relation(true)->find($id);
				//to board owner
				$rs = M('Staff')->find($board['owner_id']);

				//to all item owner
				$status = D('StatusStatus')->relation(true)->where("board_id=".$id)->select();

				$style = '<style>'."\n";
				$style .= 'strong.TBD{color: #808080;}'."\n";
				$style .= 'strong.Pass, strong.PassX{color: #009900;}'."\n";
				$style .= 'strong.Ongoing{color: #0000FF;}'."\n";
				$style .= 'strong.Failed{color: #FF0000;}'."\n";
				$style .= 'strong.Ignore{color: #0099FF;}'."\n";
				$style .= '</style>'."\n";
				$body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>'."\n";
				$body .= '<table cellpadding="5" border="1" style="border-collapse:collapse;border:1px solid #666666;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n";
				$body .= '<td colspan="2">Board Status Detail</td>'."\n";
				$body .= '</tr>'."\n";
				$body .= '<tr><td width="120">Flow Name:</td><td><a href="'.APP_ROOT.'/Status/flow2/id/'.$board['flow_id'].'" target="_blank">'.$board['flow']['name'].'</a></td></tr>'."\n";
				$body .= '<tr><td>Board Name:</td><td><a href="'.APP_ROOT.'/Status/board/id/'.$board['id'].'" target="_blank">'.$board['name'].'</a></td></tr>'."\n";
				$body .= '<tr><td>Board Information:</td><td>'.nl2br($board['info']).'</td></tr>'."\n";
				$body .= '<tr><td>Owner:</td><td>'.$board['owner']['realname'].'</td></tr>'."\n";
				$body .= '<tr><td>Create Time:</td><td>'.$board['create_time'].'</td></tr>'."\n";
				$body .= '<tr><td>Item Status:</td><td>'."\n";
				$body .= '<table cellpadding="3" border="1" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#DDDDDD"><th>No.</th><th>Test Item</th><th>Owner</th><th>Status</th></tr>'."\n";
				foreach ($status as $i=>$row) {
					$body .= '<tr';
					if ($row['status'] < 1) {
						$body .= ' class="staff_'.(empty($row['substitute_id'])?$row['owner_id']:$row['substitute_id']).'"';
					}
					$body .= '>'."\n";
					$body .= '<td align="center">'.($i+1).'</td>'."\n";
					$body .= '<td nowrap="nowrap">'.$row['item']['name'].'</td>'."\n";
					$body .= '<td nowrap="nowrap">'.$row['owner']['realname'];
					if (!empty($row['substitute_id'])) {
						$body .= '<img src="'.APP_ROOT.'/../..'.APP_PUBLIC_PATH.'/Images/105.png" alt=" -> " align="absmiddle"/>'.$row['substitute']['realname'];
					}
					$body .= '</td>';
					$body .= '<td><strong class="'.$this->status_arr[$row['status']].'">'.$this->status_arr[$row['status']].'</strong></td></tr>'."\n";
				}
				$body .= '</table>'."\n";
				$body .= '</td></tr></table>'."\n";
				$body .= '<br /><br />For more information, please visit <a target="_blank" href="'.APP_ROOT.'/Status">ERP System -> Board Status</a>';
				$body .= '<br /><br />Best Regards,<br />'.C('ERP_TITLE');
				$body .= '</body></html>';
				foreach ($status as $i=>$row) {
					if ($row['status'] >= 0) {
						continue;
					}
					$subject = '[Board Status]: ['.$board['flow']['name'].'] need ['.(empty($row['substitute_id'])?$row['owner']['realname']:$row['substitute']['realname']).'] to update the test status';
					$style2 = '<style>.staff_'.(empty($row['substitute_id'])?$row['owner_id']:$row['substitute_id']).'{background-color:#ffff66;}</style>';
					$header = 'Hi '.(empty($row['substitute_id'])?$row['owner']['realname']:$row['substitute']['realname']).',<br />'."\n";
					$header .= '&nbsp;&nbsp;The below rows in yellow need you to update.<br />'."\n";

					$mail->ClearAddresses();
					if (empty($row['substitute_id'])) {
						$mail->AddAddress($row['owner']['email'], $row['owner']['realname']);
					}
					else {
						$mail->AddAddress($row['substitute']['email'], $row['substitute']['realname']);
					}
					$mail->Subject = $subject;
					$mail->MsgHTML($style.$style2.$header.$body);
					$debug = 'type='.$type.', board_id='.$id.', item_id='.$row['item_id'].', owner_id='.$row['owner_id'].', substitute_id='.$row['substitute_id'];
					if(!$mail->Send()) {
						Log::Write('Mail status Error: '.$debug."\n".$mail->ErrorInfo, LOG::ERR);
					}
					else {
						//update mail_time
						M('StatusStatus')->where("id=".$row['id'])->setField('mail_time', time());
						Log::Write('Mail status Success: '.$debug, LOG::INFO);
					}
				}
				break;

			case 'status':
				$status_info = D('StatusStatus')->relation(true)->find($id);

				$board = D('StatusBoard')->relation(true)->find($status_info['board_id']);
				//to board owner
				$rs = M('Staff')->find($board['owner_id']);

				//to all item owner
				$status = D('StatusStatus')->relation(true)->where("board_id=".$status_info['board_id'])->select();

				$style = '<style>'."\n";
				$style .= 'strong.TBD{color: #808080;}'."\n";
				$style .= 'strong.Pass, strong.PassX{color: #009900;}'."\n";
				$style .= 'strong.Ongoing{color: #0000FF;}'."\n";
				$style .= 'strong.Failed{color: #FF0000;}'."\n";
				$style .= 'strong.Ignore{color: #0099FF;}'."\n";
				$style .= '</style>'."\n";
				$body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>'."\n";
				$body .= '<table cellpadding="5" border="1" style="border-collapse:collapse;border:1px solid #666666;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n";
				$body .= '<td colspan="2">Board Status Detail</td>'."\n";
				$body .= '</tr>'."\n";
				$body .= '<tr><td width="120">Flow Name:</td><td><a href="'.APP_ROOT.'/Status/flow2/id/'.$board['flow_id'].'" target="_blank">'.$board['flow']['name'].'</a></td></tr>'."\n";
				$body .= '<tr><td>Board Name:</td><td><a href="'.APP_ROOT.'/Status/board/id/'.$board['id'].'" target="_blank">'.$board['name'].'</a></td></tr>'."\n";
				$body .= '<tr><td>Board Information:</td><td>'.nl2br($board['info']).'</td></tr>'."\n";
				$body .= '<tr><td>Owner:</td><td>'.$board['owner']['realname'].'</td></tr>'."\n";
				$body .= '<tr><td>Create Time:</td><td>'.$board['create_time'].'</td></tr>'."\n";
				$body .= '<tr><td>Item Status:</td><td>'."\n";
				$body .= '<table cellpadding="3" border="1" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#DDDDDD"><th>No.</th><th>Test Item</th><th>Owner</th><th>Status</th></tr>'."\n";
				foreach ($status as $i=>$row) {
					$body .= '<tr';
					if ($row['status'] < 1) {
						$body .= ' class="staff_'.(empty($row['substitute_id'])?$row['owner_id']:$row['substitute_id']).'"';
					}
					$body .= '>'."\n";
					$body .= '<td align="center">'.($i+1).'</td>'."\n";
					$body .= '<td nowrap="nowrap">'.$row['item']['name'].'</td>'."\n";
					$body .= '<td nowrap="nowrap">'.$row['owner']['realname'];
					if (!empty($row['substitute_id'])) {
						$body .= '<img src="'.APP_ROOT.'/../..'.APP_PUBLIC_PATH.'/Images/105.png" alt=" -> " align="absmiddle"/>'.$row['substitute']['realname'];
					}
					$body .= '</td>';
					$body .= '<td><strong class="'.$this->status_arr[$row['status']].'">'.$this->status_arr[$row['status']].'</strong></td></tr>'."\n";
				}
				$body .= '</table>'."\n";
				$body .= '</td></tr></table>'."\n";
				$body .= '<br /><br />For more information, please visit <a target="_blank" href="'.APP_ROOT.'/Status">ERP System -> Board Status</a>';
				$body .= '<br /><br />Best Regards,<br />'.C('ERP_TITLE');
				$body .= '</body></html>';

				//send mail to one staff
				$subject = '[Board Status]: ['.$board['flow']['name'].'] need ['.(empty($status_info['substitute_id'])?$status_info['owner']['realname']:$status_info['substitute']['realname']).'] to update the test status';
				$style2 = '<style>.staff_'.(empty($status_info['substitute_id'])?$status_info['owner_id']:$status_info['substitute_id']).'{background-color:#ffff66;}</style>';
				$header = 'Hi '.(empty($status_info['substitute_id'])?$status_info['owner']['realname']:$status_info['substitute']['realname']).',<br />'."\n";
				$header .= '&nbsp;&nbsp;The below rows in yellow need you to update.<br />'."\n";

				$mail->ClearAddresses();
				if (empty($status_info['substitute_id'])) {
					$mail->AddAddress($status_info['owner']['email'], $tatus_info['owner']['realname']);
				}
				else {
					$mail->AddAddress($status_info['substitute']['email'], $status_info['substitute']['realname']);
				}
				$mail->Subject = $subject;
				$mail->MsgHTML($style.$style2.$header.$body);
				$debug = 'type='.$type.', status_id='.$id.', item_id='.$status_info['item_id'].', owner_id='.$status_info['owner_id'].', substitute_id='.$status_info['substitute_id'];
				if(!$mail->Send()) {
					Log::Write('Mail status Error: '.$debug."\n".$mail->ErrorInfo, LOG::ERR);
				}
				else {
					//update mail_time
					M('StatusStatus')->where("id=".$id)->setField('mail_time', time());
					echo $debug."\n";
					Log::Write('Mail status Success: '.$debug, LOG::INFO);
				}
				break;

			default :
				//
		}
	}
	public function send_mail() {
		$type=$_REQUEST['type'];
		$id = $_REQUEST['id'];
		self::_mail($type, $id);
	}
	public function remind_mail() {
		$rs = M('StatusRemind')->select();
		empty($rs) && ($rs = array());
		echo "There are ".count($rs)." reminder\n";
		foreach ($rs as $row) {
			$status_rs = M('StatusStatus')->where("flow_id=".$row['flow_id']." and item_id=".$row['item_id']." and status=-1")->select();
			empty($status_rs) && ($status_rs = array());
			foreach ($status_rs as $status) {
				if ($status['mail_time'] <= 0) {
					$create_time = M('StatusBoard')->where("id=".$status['board_id'])->getField('create_time');
					if (time() > strtotime($create_time)+$row['costTime']*86400) {
						//first remind
						self::_mail('status', $status['id']);
					}
				}
				else {
					if ($row['remindInterval']>0 && time()>$status['mail_time']+$row['remindInterval']*86400) {
						//remind again
						self::_mail('status', $status['id']);
					}
				}
			}
		}
	}
	public function write_log($type, $content) {
		$data = array(
			'type' => $type,
			'action_time' => date('Y-m-d H:i:s'),
			'staff_id' => empty($_SESSION[C('USER_AUTH_KEY')]) ? 1 : $_SESSION[C('USER_AUTH_KEY')],
			'content' => $content
			);
		if (!M('StatusLog')->add($data)) {
			self::_error('Add log fail!<br />'.$this->dao->getLastSql());
		}
	}
	public function read_log() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$dao = D('StatusLog');

		$this->assign('request', $_REQUEST);

		import("@.Paginator");
		$limit = 50;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$where = array();
		if (isset($_REQUEST['staff_id'])) {
			$staff_id = intval($_REQUEST['staff_id']);
		}
		$staff_arr = $dao->join("Inner Join erp_staff on erp_staff.id=erp_status_log.staff_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('staff_opts', self::genOptions($staff_arr, $staff_id, 'realname'));
		if (!empty($staff_id)) {
			$where['staff_id'] = $staff_id;
		}

		!empty($_REQUEST['from']) && ($where['action_time'] = array('egt', $_REQUEST['from']));
		!empty($_REQUEST['to']) && ($where['action_time'] = array('lt', $_REQUEST['to']));
		if (!empty($_REQUEST['keyword']) && ''!=trim($_REQUEST['keyword'])) {
			$where['content'] = array('like', '%'.trim($_REQUEST['keyword']).'%');
		}

		$count = $dao->where($where)->getField('count(*)');
		$p = new Paginator($count,$limit);

		$rs = $dao->relation(true)->where($where)->order('id desc')->limit($p->offset.','.$p->limit)->select();

		$this->assign('result', $rs);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content', ACTION_NAME);

		$this->assign('ACTION_TITLE', 'Operation Log');
		$this->display('Layout:ERP_layout');

	}
}
?>