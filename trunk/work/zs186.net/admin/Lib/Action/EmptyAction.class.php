<?php
Class EmptyAction extends BaseAction {

	public function index() {
		echo	$alias = MODULE_NAME;
		echo '|'.$_REQUEST['id'];
	}
}
?>
