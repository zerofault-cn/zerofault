<?php

	/**
	* SmartTemplate Extension dateformatgrid
	* Changes Dateformat
	*
	* @author Engelbert Turczyk
	*/
	function smarttemplate_extension_dateformatgrid ( $param, $format = 'd.m.Y' )
	{
		list($month,$day,$year,$hour,$minute,$second) = split("[-:T\.]", $param);
		
		// handle empty values
		if (! $hour) { $hour = "00"; }
		if (! $minute) { $minute = "00"; }
		if (! $second) { $second = "00"; }

		return date( $format, mktime($hour, $minute, $second, $month, $day, $year));
	}

?>