<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// include some nice stuff
	require('inc/config.php');

	// send header
	header('Content-type: image/jpeg');

	// get filenames
	$img = $_GET['img'];
	
	// include the resize function
	require('inc/sImageResize.php');
	
	// echo out image
	sImageResize('upload/' . $img, null, 120, 100);

?>