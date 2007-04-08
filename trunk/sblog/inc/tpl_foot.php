<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	ob_start();
	
?>
<a href="http://servous.se/" rel="external" title="Powered by sBLOG"><img src="img/sblog_80x15.png" alt="Powered by sBLOG" /></a> <a href="http://www.sblog.cn/" rel="external"><img src="img/inso.png" alt="中文支持:inso" /></a> <a href="http://validator.w3.org/check?verbose=1&amp;uri=<?php echo $conf_web_root . basename($_SERVER['PHP_SELF']); ?>" rel="external" title="Valid XHTML 1.0 Strict"><img src="img/xhtml10.png" alt="XHTML 1.0 Strict" /></a> <a href="http://php.net/" rel="external" title="Powered by PHP"><img src="img/php.png" alt="PHP" /></a> <a href="http://jigsaw.w3.org/css-validator/validator?profile=css2&amp;warning=2&amp;uri=<?php echo $conf_web_root; ?>" rel="external" title="Valid CSS"><img src="img/css.png" alt="CSS" /></a><br />
		Powered by <a href="http://servous.se/" rel="external" class="sblog_copy">sBLOG</a> &copy; 2005 Servous<br />
		Version <?php echo $conf_current_version; ?> (Build <?php echo $conf_current_build; ?>)
<?php

	$tpl_temp = trim(ob_get_contents());
	$tpl_main = str_replace('<sblog_copy>', $tpl_temp, $tpl_main);
	
	ob_end_clean();

?>