<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/
	
	// do not declare truncate() more than once!
	if(!function_exists('truncate')) {
		require('inc/func_truncate.php');
	}

?>
			<!-- START OF TPL_BAR_CALENDAR -->
			<div class="sblog_block">
				<div class="sblog_block_topic">
					<h2 class="sblog_block_topic_text"><?php echo lang('Calendar'); ?></h2>
				</div>
<?php

	if(isset($_REQUEST['date']) && strlen($_REQUEST['date']) == 6 || isset($_REQUEST['date']) && strlen($_REQUEST['date']) == 8) {
		$year		= substr($_REQUEST['date'], 0, 4);
		$month	= substr($_REQUEST['date'], 4, 2);
		$day		= substr($_REQUEST['date'], 6, 2);
	}
	else if(isset($_REQUEST['date']) && strlen($_REQUEST['date']) == 6 || isset($_REQUEST['date']) && strlen($_REQUEST['date']) == 8) {
		$year		= substr($_REQUEST['date'], 0, 4);
		$month	= substr($_REQUEST['date'], 4, 2);
		$day		= null;
	}
	else {
		$year		= date('Y');
		$month	= date('m');
		$day		= null;
	}
	
	$queryCalendar = 'SELECT SUBSTRING(date_created, 1, 10) AS date, COUNT(id) AS n FROM ' . $conf_mysql_prefix . 'data WHERE SUBSTRING(date_created, 1, 7)=\'' . $year . '-' . $month . '\' GROUP BY date';
	$qCalendar = mysql_query($queryCalendar);
	$nCalendar = mysql_num_rows($qCalendar);

	$posts = array();
	
	while($rCalendar = mysql_fetch_assoc($qCalendar)) {
		$posts[$rCalendar['date']] = $rCalendar['n'];
	}

	require('sCalendar.php');
	
	$cal = new sCalendar();
	
	$calendar = $cal->render();
	
	$mktime = mktime(0, 0, 0, $cal->thisMonth(), 1, $cal->thisYear());
	
	echo "\t\t\t\t" . '<table cellspacing="0" cellpadding="0" border="0" class="sblog_cal">' . "\n";
	echo "\t\t\t\t\t" . '<tr>' . "\n";
	echo "\t\t\t\t\t\t" . '<td class="sblog_cal_header">' . "\n";
	
	if($cal->prevMonth() == 12) {
		echo "\t\t\t\t\t\t\t" . '<a href="index.php?date=' . $cal->prevYear() . str_pad($cal->prevMonth(), 2, '0', STR_PAD_LEFT) . '">&laquo;</a>' . "\n";
	}
	else {
		echo "\t\t\t\t\t\t\t" . '<a href="index.php?date=' . $cal->thisYear() . str_pad($cal->prevMonth(), 2, '0', STR_PAD_LEFT) . '">&laquo;</a>' . "\n";
	}
	
	echo "\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t\t" . '<td colspan="5" class="sblog_cal_header">' . "\n";
	echo "\t\t\t\t\t\t\t" . '<a href="index.php?date=' . $cal->thisYear() . str_pad($cal->thisMonth(), 2, '0', STR_PAD_LEFT) . '">' . strftime('%Y年%m月', $mktime) . '</a>' . "\n";
	echo "\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t\t" . '<td class="sblog_cal_header">' . "\n";
	
	if($cal->nextMonth() == 1) {
		echo "\t\t\t\t\t\t\t" . '<a href="index.php?date=' . $cal->nextYear() . str_pad($cal->nextMonth(), 2, '0', STR_PAD_LEFT) . '">&raquo;</a>' . "\n";
	}
	else {
		echo "\t\t\t\t\t\t\t" . '<a href="index.php?date=' . $cal->thisYear() . str_pad($cal->nextMonth(), 2, '0', STR_PAD_LEFT) . '">&raquo;</a>' . "\n";
	}
	
	echo "\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t" . '</tr>' . "\n";
	echo "\t\t\t\t\t" . '<tr>' . "\n";
	echo "\t\t\t\t\t\t" . '<td class="sblog_cal">' . "\n";
	echo "\t\t\t\t\t\t\t" . strftime('一', strtotime('Monday')) . "\n";
	echo "\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t\t" . '<td class="sblog_cal">' . "\n";
	echo "\t\t\t\t\t\t\t" . strftime('二', strtotime('Tuesday')) . "\n";
	echo "\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t\t" . '<td class="sblog_cal">' . "\n";
	echo "\t\t\t\t\t\t\t" . strftime('三', strtotime('Wednesday')). "\n";
	echo "\t\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t\t" . '<td class="sblog_cal">' . "\n";
	echo "\t\t\t\t\t\t\t" . strftime('四', strtotime('Thursday')). "\n";
	echo "\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t\t" . '<td class="sblog_cal">' . "\n";
	echo "\t\t\t\t\t\t\t" . strftime('五', strtotime('Friday')). "\n";
	echo "\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t\t" . '<td class="sblog_cal">' . "\n";
	echo "\t\t\t\t\t\t\t" . strftime('六', strtotime('Saturday')). "\n";
	echo "\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t\t" . '<td class="sblog_cal">' . "\n";
	echo "\t\t\t\t\t\t\t" . strftime('日', strtotime('Sunday')) . "\n";
	echo "\t\t\t\t\t\t" . '</td>' . "\n";
	echo "\t\t\t\t\t" . '</tr>' . "\n";

	foreach($calendar as $w) {
		echo "\t\t\t\t\t" . '<tr>' . "\n";
		foreach($w as $d) {
			if($year == date('Y') && $month == date('m') && $d == date('d')) {
				$class = 'sblog_cal_today';
			}
			else if($year == $cal->thisYear() && $month == $cal->thisMonth() && $d == $day && $d != null) {
				$class = 'sblog_cal_active';
			}
			else if($d != null) {
				$class = 'sblog_cal_day';
			}
			else {
				$class = 'sblog_cal_empty';
			}
			
			echo "\t\t\t\t\t\t" . '<td class="' . $class . '">' . "\n";
			
			$today = $cal->thisYear() . '-' . str_pad($cal->thisMonth(), 2, '0', STR_PAD_LEFT) . '-' . str_pad($d, 2, '0', STR_PAD_LEFT);
			
			if(array_key_exists($today, $posts)) {
				echo "\t\t\t\t\t\t\t" . '<a href="index.php?date=' . str_replace('-', '', $today) . '" title="' . $posts[$today] . ' ' . lang('post(s)') . '">' . $d . '</a>' . "\n";
			}
			else {
				echo "\t\t\t\t\t\t\t" . $d . "\n";
			}
			
			echo "\t\t\t\t\t\t" . '</td>' . "\n";
		}
		echo "\t\t\t\t\t" . '</tr>' . "\n";
	}
	echo "\t\t\t\t" . '</table>' . "\n";

?>
			</div>
			<!-- END OF TPL_BAR_CALENDAR -->