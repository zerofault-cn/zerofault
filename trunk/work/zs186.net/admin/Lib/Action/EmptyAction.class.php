<?php
Class EmptyAction extends BaseAction {

	public function index() {
		echo	$alias = MODULE_NAME;
		echo '|'.$_REQUEST['id'];
	}
	public function add() {
		echo ACTION_NAME;
	}
}
?>
