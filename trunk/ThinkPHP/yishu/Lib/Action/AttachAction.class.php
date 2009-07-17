<?php
class AttachAction extends Action{
	public function upload(){
		dump($_REQUEST);
		dump($_FILES);
	}
}
?>