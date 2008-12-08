<?php
	/**
	* MyDirectory Class
	* 
	* Reads Directories into an array structure
	*
	*
	* Usage Example I:
	*
	* $dir    =  new MyDirectory( './' );
	* $files  =  $dir->read();
	* print_r ( $files );
	*
	* Usage Example II:
	*
	* $dir    =  new MyDirectory( './' );
	* $dir->include_folders  =  false;
	* $dir->include_extensions  =  array('htm','html');
	* $files  =  $dir->read();
	* print_r ( $files );
	*
	* @author Philipp v. Criegern philipp@criegern.com
	* @version 1.04 21.07.2002
	*/
	class MyDirectory
	{
		/**
		* Whether to recurse into subfolders or not
		*
		* @access public
		*/
		var $recursive			=	false;

		/**
		* Whether to List Folders
		*
		* @access public
		*/
		var $include_folders	=	true;

		/**
		* Whether to List Files
		*
		* @access public
		*/
		var $include_files		=	true;

		/**
		* Include only Files with the following Extensions
		* If include_extensions is filled, exclude_extensions is ignored
		*
		* @access public
		*/
		var $include_extensions	=	array();

		/**
		* Exclude Files with the following Extensions
		*
		* @access public
		*/
		var $exclude_extensions	=	array();

		/**
		* @access private
		*/
		var $path				=	'./';

		/**
		* @access private
		*/
		var $files				=	array();

		/**
		* MyDirectory Constructor
		*
		* @access public
		* @param string $path Directory to be read
		* @param bool $recursive Whether to recurse into subfolders or not
		*/
		function MyDirectory ( $path = '',  $recursive = false )
		{
			if ($path)
			{
				$this->path  =  $path;
			}
			$this->recursive  =  $recursive;
		}

		/**
		* Read Entire Directory Tree (if opted)
		*
		* @access public
		* @param string $path Directory to be read
		* @return array Directory Structure
		* @desc Read Entire Directory Tree
		*/
		function read ( $path = '' )
		{
			if ($path)
			{
				$this->path  =  $path;
			}
			if (!is_array($this->include_extensions))
			{
				$this->include_extensions  =  explode(',',  $this->include_extensions);
			}
			if (!is_array($this->exclude_extensions))
			{
				$this->exclude_extensions  =  explode(',',  $this->exclude_extensions);
			}
			$this->files  =  $this->scan ( $this->path );
			return $this->files;
		}

		/**
		* Read each single folder, core function
		*
		* @access private
		* @param string $path Directory to be read
		* @return array Directory Structure
		*/
		function scan ( $path )
		{
			$thisdir  =  array();
			$folders  =  array();
			$files    =  array();
			if ($handle  =  opendir($path))
			{
				//	Read all directory entries
				while ($filename  =  readdir($handle))
				{
					//	Exclude Files with a leading '.' (. / .. / .htaccess ...)
					if (substr($filename,  0,  1) != ".")
					{
						//	Store Folders and Files in different arrays (for sort purpose)
						if (is_dir("$path/$filename"))
						{
							$folders[]  =  $filename;
						}
						else
						{
							$files[]  =  $filename;
						}
					}
				}
				closedir($handle);
				//	Add Directories to the Output List
				if ($this->include_folders)
				{
					sort($folders);
					foreach ($folders as $filename)
					{
						if ($this->recursive)
						{
							$thisdir[]  =  $this->scan( "$path/$filename" );
						}
						else
						{
							$thisdir[]  =  array(
												"NAME"		=>	$filename,
												"TYPE"		=>	'Folder',
											);
						}
					}
				}
				//	Add Files to the Output List
				if ($this->include_files)
				{
					sort($files);
					foreach ($files as $filename)
					{
						$extension  =  strtolower(substr( strrchr($filename, '.') , 1));
						if (!empty($this->include_extensions))
						{
							$include  =  in_array($extension,  $this->include_extensions);
						}
						elseif (!empty($this->exclude_extensions))
						{
							$include  =  !in_array($extension,  $this->exclude_extensions);
						}
						else
						{
							$include  =  true;
						}
						if ($include)
						{
							$mtime  =  filemtime("$path/$filename");
							$size   =  filesize("$path/$filename");
							$thisdir[]  =  array(
												"NAME"		=>	$filename,
												"EXT"		=>	$extension,
												"TYPE"		=>	'File',
												"BYTE"		=>	$size,
												"KB"		=>	ceil($size/1024),
												"SIZE"		=>	ceil($size/1024) . ' KB',
												"MTIME"		=>	$mtime,
												"CHANGED"	=>	date('d.m.Y H:i', $mtime),
											);
						}
					}
				}
			}
			return $thisdir;
		}

	}
?>