<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		���İ�֧��: inso (http://www.sblog.cn)
	 **************************************************/

	// admin only!
	require('inc/auth.php');
	
	// filenames
	$file = stripslashes(str_replace('\/', '', $_GET['file']));
	$filename	= 'upload/' . $file;
	$thumbnail	= 'upload/tn/' . $file;

	// remove image and thumbnail
	@unlink($filename);
	@unlink($thumbnail);
	
	// send back user to 'ikmages'
	header('Location: image.php');
	exit;	

?>