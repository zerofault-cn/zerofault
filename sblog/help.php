<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	require('inc/auth.php');
	
	require('inc/tpl_header_help.php');
	require('inc/tpl_menu.php');
	
	// include blocks
	require('inc/block_custom.php');			// custom blocks
	
	// check for received variables
	if(array_key_exists('id', $_POST)) {
		$id = intval($_POST['id']);
	}
	else {
		$id = null;
	}
	
	if(array_key_exists('ref', $_POST)) {
		$ref = htmlspecialchars($_POST['ref']);
	}
	else {
		$ref = null;
	}
	
	if(array_key_exists('date_created', $_POST)) {
		$date_created = $_POST['date_created'];
	}
	else {
		$date_created = null;
	}
	
	if(array_key_exists('category_id', $_POST)) {
		$category_id = intval($_POST['category_id']);
	}
	else {
		$category_id = 1;
	}
	
	if(array_key_exists('topic', $_POST)) {
		$topic = htmlspecialchars(stripslashes($_POST['topic']));
	}
	else {
		$topic = null;
	}
	
	if(array_key_exists('text', $_POST)) {
		$text = htmlspecialchars(stripslashes($_POST['text']));
	}
	else {
		$text = null;
	}
	
	if(array_key_exists('silent', $_POST)) {
		$silent = intval($_POST['silent']);
	}
	else {
		$silent = null;
	}

	/* start <sblog_main> */
	ob_start();

?>
			<form id="help" method="post" action="edit.php">
				<fieldset>
					<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
					<input type="hidden" name="ref" id="ref" value="<?php echo $ref; ?>" />
					<input type="hidden" name="date_created" id="date_created" value="<?php echo $date_created; ?>" />
					<input type="hidden" name="category_id" id="category_id" value="<?php echo $category_id; ?>" />
					<input type="hidden" name="topic" id="topic" value="<?php echo $topic; ?>" />
					<input type="hidden" name="text" id="text" value="<?php echo $text; ?>" />
					<input type="hidden" name="silent" id="silent" value="<?php echo $silent; ?>" />
					<legend><?php echo lang('Options'); ?></legend>
					<input type="submit" value="<?php echo lang('Go back'); ?>" class="sblog_button" />
				</fieldset>
			</form><br />
			
			<div class="sblog_post">
				<div class="sblog_post_topic">
					<h2 class="sblog_post_topic_text"><?php echo lang('Text formatting'); ?></h2>
				</div>
				<div class="sblog_post_text">
					[b]加粗[/b] -&gt; <b>加粗</b><br />
					[i]斜体[/i] -&gt; <i>斜体</i><br />
					[u]下划线[/u] -&gt; <span style="text-decoration: underline;">下划线</span><br />
					[del]删除线[/del] -&gt; <span style="text-decoration: line-through;">删除线</span><br />
					[s]删除线[/s] -&gt; <span style="text-decoration: line-through;">删除线</span><br />
					[color=red]彩色文字[/color] -&gt; <span style="color: red;">彩色文字</span><br />
					[color=#FF0000]彩色文字[/color] -&gt; <span style="color: #FF0000;">彩色文字</span>
				</div>
			</div><br />

			<div class="sblog_post">
				<div class="sblog_post_topic">
					<h2 class="sblog_post_topic_text"><?php echo lang('Links'); ?></h2>
				</div>
				<div class="sblog_post_text">
					[url=<?php echo $conf_web_root; ?>]<?php echo $conf_page_title; ?>[/url] -&gt; <a href="<?php echo $conf_web_root; ?>" rel="external"><?php echo $conf_page_title; ?></a><br />
					[email=john.doe@test.com]John Doe[/email] -&gt; <a href="mailto:john.doe@test.com">John Doe</a>
				</div>
			</div><br />

			<div class="sblog_post">
				<div class="sblog_post_topic">
					<h2 class="sblog_post_topic_text"><?php echo lang('Images'); ?></h2>
				</div>
				<div class="sblog_post_text">
					[img]<?php echo $conf_web_root; ?>img/php.png[/img] -&gt; <img src="<?php echo $conf_web_root; ?>img/php.png" alt="<?php echo $conf_web_root; ?>img/php.png" />
				</div>
			</div><br />

			<div class="sblog_post">
				<div class="sblog_post_topic">
					<h2 class="sblog_post_topic_text"><?php echo lang('Smilies'); ?></h2>
				</div>
				<div class="sblog_post_text">
					:) -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/smile.png" alt=":)" /><br />
					:| -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/neutral.png" alt=":|" /><br />
					:( -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/sad.png" alt=":(" /><br />
					:D -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/big_smile.png" alt=":D" /><br />
					:o -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/yikes.png" alt=":o" /><br />
					;) -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/wink.png" alt=";)" /><br />
					=/ -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/hmm.png" alt="=/" /><br />
					:P -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/tongue.png" alt=":P" /><br />
					:lol: -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/lol.png" alt=":lol:" /><br />
					:mad: -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/mad.png" alt=":mad:" /><br />
					:roll: -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/roll.png" alt=":roll:" /><br />
					:cool: -&gt; <img src="<?php echo $conf_web_root; ?>img/smilies/cool.png" alt=":cool:" />
				</div>
			</div><br />

			<div class="sblog_post">
				<div class="sblog_post_topic">
					<h2 class="sblog_post_topic_text"><?php echo lang('Miscellaneous'); ?></h2>
				</div>
				<div class="sblog_post_text">
					[quote]引用[/quote] -&gt;<br />
					<div class="sblog_quote">引用</div><br />
					[code]代码[/code] -&gt;<br />
					<pre class="sblog_code">代码</pre>
					[line] -&gt;<br />
					<div class="sblog_line"></div><br />
				</div>
			</div>
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_main>', $tpl_temp, $tpl_main);
	
	ob_end_clean();
	
	/* end <sblog_main> */
	
	require('inc/tpl_foot.php');
	
	echo $tpl_main;

?>