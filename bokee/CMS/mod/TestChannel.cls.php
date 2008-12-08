<?php

require_once('mod/Channel.cls.php');
require_once('PHPUnit.php');

class ChannelTest extends PHPUnit_TestCase {
	function setUp()
	{
		$this->c = new Channel();
	}

	function testSetName()
	{
		$this->c->SetName('yudunde');
		$this->assertTrue($this->c->GetName() == 'yudunde');
	}
}


?>