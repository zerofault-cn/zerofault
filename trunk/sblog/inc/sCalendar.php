<?php

	/**************************************************

		Project	sBLOG <http://sblog.sourceforge.net>
		Author	Servous <servous@gmail.com>
		License	GPL
		中文版支持: inso (http://www.sblog.cn)
	 **************************************************/

	class sCalendar {
		
		var $year;
		var $month;
		var $day;

		// set variables
		function sCalendar() {
			global $year, $month;
			
			if(isset($year) && strlen($year) == 4) {
				$this->year = (int)$year;
			}
			else {
				$this->year = date('Y');
			}
			
			if(isset($month)){
				$this->month = (int)$month;
			}
			else {
				$this->month = date('n');
			}
			
			if(isset($day)){
				$this->day = (int)$day;
			}
			else {
				$this->day = date('j');
			}
		}
		
		// days in month
		function daysInMonth() {
			if(!extension_loaded('calendar')) {
				// quick-fix if calendar not is loaded! do NOT support leap-year!
				switch($this->month) {
					case 2:
						return 28;
						break;
					case 4:
						return 30;
						break;
					case 6:
						return 30;
						break;
					case 9:
						return 30;
						break;
					case 11:
						return 30;
						break;
					default:
						return 31;
						break;
				}
			}
			else {
				return cal_days_in_month(CAL_GREGORIAN, $this->month, $this->year);
			}
		}

		// previous year
		function prevYear() {
			return $this->year - 1;
		}
		
		// this year
		function thisYear() {
			return $this->year;
		}
		
		// next year
		function nextYear() {
			return $this->year + 1;
		}
		
		// previous month
		function prevMonth() {
			if($this->month == 1) {
				return 12;
			}
			else {
				return $this->month - 1;
			}
		}
		
		// this month
		function thisMonth() {
			return $this->month;
		}
		
		//next month
		function nextMonth() {
			if($this->month == 12) {
				return 1;
			}
			else {
				return $this->month + 1;
			}
		}
		
		// render array
		function render() {
			$tmp	= null;
			$c		= 0;
			$week	= 0;
			$d		= 0;

			// set monday as start day
			switch($a = date('w', mktime(0, 0, 0, $this->month, 1, $this->year))) {
				case 0:
					$today = 6;
					break;
				default:
					$today = $a - 1;
					break;
			}

			// pad days before monday
			for($c = 0; $c < $today; $c++) {
				$tmp[$week][$c] = null;
				$d++;
			}
			
			// days
			for($i = 1; $i <= $this->daysInMonth(); $i++) {
				if($d > 6) {
					$week++;
					$d = 0;
				}
				$tmp[$week][$c] = $i;
				$c++;
				$d++;
			}
			
			// pad days after last day
			for($i = $d; $i < 7; $i++) {
				$tmp[$week][$c] = null;
				$c++;
				$d++;
			}
			
			return $tmp;
		}
		
	}

?>