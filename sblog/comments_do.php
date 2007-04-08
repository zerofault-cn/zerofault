<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	// import some important stuff
	require('inc/config.php');

	// define variables
	$blog_id			= $_POST['blog_id'];
	$username		= mysql_escape_string($_POST['username']);
	$email			= mysql_escape_string($_POST['email']);
	$homepage		= mysql_escape_string(str_replace('http://', '', $_POST['homepage']));
	$comment			= mysql_escape_string($_POST['comment']);

	// add comment	
	if($username != '' && $comment != '') {
		require('inc/mysql.php');

		$query = 'INSERT INTO ' . $conf_mysql_prefix . 'comments SET blog_id=\'' . $blog_id . '\', date_created=NOW(), username=\'' . $username . '\', email=\'' . $email . '\', homepage=\'' . $homepage . '\', comment=\'' . $comment . '\'';

		mysql_query($query);
		$id = mysql_insert_id();
		mysql_close();
	}
	
	// send mail to admin
	if(isset($conf_comments_email) && $conf_comments_email == 1) {
		
		// include function for stripping out bbcodes
		require('inc/func_truncate.php');
		require('inc/func_bbcode_strip.php');
		
		// import mail template
		$tpl = implode('', file($conf_doc_root . 'template/mail/comment.tpl'));
		
		// define url var
		$url = $conf_web_root . 'blog.php?id=' . $blog_id . '#' . $id;
		
		$pattern	=	array(
							'<name>',
							'<email>',
							'<comment>',
							'<url>'
						);
		
		$replace	=	array(
							$username,
							'<' . $email . '>',
							str_replace('<br />', '', bbcode_strip($_POST['comment'])),
							$url
						);
		
		// define mail vars
		$to		= $conf_admin_email;
		$subject	= $conf_page_title . ': 新评论';
		$body		= str_replace($pattern, $replace, $tpl);
		$from		= 'From: ' . $conf_page_title . '<sblog-mailer@' . $_SERVER['HTTP_HOST'] . '>' . "\r\n";
		
		// send mail to admin
		mail($to, $subject, $body, $from);
	}
	
	header("Location: comments.php?id=$blog_id");
	exit;

?>