<?php
class PublicAction extends Action{

	public function verify() {
		import("@.Image");
		Image::buildImageVerify();
	}
}