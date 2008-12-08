<?php
/*
* $Header: /cvsroot/CMS/mvc/utils/FileUtils.cls.php,v 1.1 2005/07/12 11:48:24 cvs Exp $
* $Revision: 1.1 $
* $Date: 2005/07/12 11:48:24 $
*
* ====================================================================
*
* License:	GNU Lesser General Public License (LGPL)
*
* Copyright (c) 2002, 2003 John C.Wildenauer.  All rights reserved.
*
* This file is part of the php.MVC Web applications framework
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2.1 of the License, or (at your option) any later version.

* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.

* You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


/**
* File utlity methods
* 
* @author John C. Wildenauer
* @version $Revision: 1.1 $
* @public
*/
class FileUtils {

	/** 
	* Check if specified file is on the local server
	*   Returns False if the file name specifies a TCP protocol 
	*   or the file is not owned by the userID
	*   Eg: 'http://evilserver.com/myfile.php'
	*
	* @param string	The file to open
	* @public
	* @returns boolean
	*/
	function trustedFile($file) {
		// only trust local files owned by ourselves
		if (!eregi("^([a-z]+)://", $file) 
				&& fileowner($file) == getmyuid() ) {
			return True;
		}
		return False;
	}


	/**
	* Calculates current microtime
	* @public
	* @returns string
	*/
	function utime() {
		// microtime() = current UNIX timestamp with microseconds
		$time	= explode( ' ', microtime());
		$usec	= (double)$time[0];
		$sec	= (double)$time[1];
		return $sec + $usec;
	} 


	/**
	* Delete temporary files.<br>
	* Returns True if success, or False if the operation failed.
	*
	* @param		string	The target directory (Eg: './tmp')
	* @param		integer	The file time-to-live in seconds (Eg: 3600 secs)
	* @public
	* @returns boolean
	*/
	function zapTmpFiles($targetDir, $fileTTL) {
		$handle=opendir($targetDir);
		while( False !== ($file = readdir($handle)) ) {
			if($file != "." && $file != ".."){
				$timeNow = time();
				$timeFile = filemtime("$targetDir/$file");
				if(($timeNow - $timeFile) >= $fileTTL){	// if file is older than TTL
					if(!unlink("$targetDir/$file")){			// nuke the stale files
						$error = '';
						return False;
					}
				}
			}
		}
		
		closedir($handle);
		return True;
	}



	/**
	* Save an object to persistent storage.<br>
	*
	* @param		string	The target file and path. Eg: './tmp/xxx.tmp'.
	* @param		object	The object instance to serialise and save.
	* @public
	* @returns void
	*/
	function saveObject($sessFile, $obj) {
		// Serialise the config data
		$strObj = serialize($obj);
		$fp = fopen($sessFile, 'w');
		fputs($fp, $strObj);
		fclose($fp);
	}



	/**
	* Restore an object from persistent storage.<br>
	* Returns the object from the given file.
	*
	* @param		string	The target file and path. Eg: './tmp/xxx.tmp'.
	* @public
	* @returns object
	*/
	function restoreObject($sessFile) {
		// Unserialise	the object
		$obj = NULL;
		if( file_exists( $sessFile ) ) {
			$strObj = implode('', @file($sessFile));
			$obj = unserialize($strObj);
			return $obj;
		} else {
			touch ( $sessFile );
			return $obj;
		}
	}

}
?>