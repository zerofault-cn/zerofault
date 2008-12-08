<?php
/**
 * FTP.cls.php
 * @author  yudunde@bokee.com
 * @copyright bokee dot com
 * created at 9-11 01:11
 */

require_once('com/Log.cls.php');

class FTP
{
	var $_host;
	var $_port;
	var $_username;
	var $_password;
	var $_conn_id;
	var $_login_result;
	
	function FTP($channel_name)
	{		
		if($this->connect($channel_name))
			return true;
		else 
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。");
			return false;
		}
	}
	
	function connect($channel_name)
	{
		global $FTP_CONFIGS;
		$FTP_CONFIGS = array(
					'ftpServer1'=>array( 
					'host'		=>  '218.16.119.43',
					'port'		=>  '21',
					'username'	=>  'haozhanwangcom',
					'password'	=>  '34468811',
					'channel'	=> array('2008','sports', 'blog', 'talk', 'tech', 'dachu', 'pic', 'www', 'bkj', 'mo', 'lady','cul', 'ent', 'sex', 'life', 'xz', 'travel', 'media', 'music', 'game', 'movie', 'auto', 'finance', 'tele', 'house', 'digi', 'dc', 'edu', 'column', 'bbs', 'photo', 'podcast', 'mobile', 'qybk', 'news', 'bmovie', 'uu', 'cms_renwu', 'chajian', 'joke','zone','like',  'zt', 'rw', 'sls', 'friend','group','mm' , 'keji','piccenter','book','mall')
					),
		);
		$ftpInfo = array();
		for($i=0; $i<count($FTP_CONFIGS);$i++)
		{
			$j = "ftpServer".($i + 1);
			if(in_array($channel_name,$FTP_CONFIGS[$j]["channel"]))
			{
				$ftpInfo["host"] = $FTP_CONFIGS[$j]["host"];
				$ftpInfo["port"] = $FTP_CONFIGS[$j]["port"];
				$ftpInfo["username"] = $FTP_CONFIGS[$j]["username"];
				$ftpInfo["password"] = $FTP_CONFIGS[$j]["password"];
				$this->_host = $ftpInfo["host"];
				$this->_port = $ftpInfo["port"];
				$this->_username = $ftpInfo["username"];
				$this->_password = $ftpInfo["password"];
				continue;
			}
		}
		if(count($ftpInfo) == 0)
		{
			die("此频道没有建立文件发布服务器,请联系技术部!!");
		}


		$this->_conn_id = ftp_connect($this->_host, $this->_port);
		$this->_login_result = ftp_login($this->_conn_id, $this->_username, $this->_password);
		if ((!$this->_conn_id) || (!$this->_login_result)) {
    		return false;
		}
		return true;
	}
	
	function ListDir($dir, $type)
	{
		$arr = array();
		switch ($type)
		{
			case "rawlist":
			$arr = ftp_rawlist($this->_conn_id, $dir);
			break;
			case "n":
			default:
			$arr = ftp_nlist($this->_conn_id, $dir);
			break;
		}
		return $arr;
	}
	
	/**
	* @abstract 使用二进制模式上传文件
	*/
	function BinPut($source_file, $destination_file)
	{
		$pos = strrpos('/', $destination_file);
		$dir = substr($destination_file, 0, $pos);
		if(!ftp_chdir($this->_conn_id, $dir))
		{
			$this->Mkdir($dir);
		}
		ftp_put($this->_conn_id, $destination_file, $source_file, FTP_BINARY);
	}
	
	/**
	* @abstract 使用文本模式上传文件
	*/
	function Put($source_file, $destination_file)
	{
		$pos = strrpos($destination_file, '/');
		$dir = substr($destination_file, 0, $pos);
		if(!@ftp_chdir($this->_conn_id, $dir))
		{
			if(!$this->FtpMkdir($dir))
			{
				Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 FTP创建目录 出错。");
				return false;
			}
		}
		ftp_pasv($this->_conn_id, true);
		if(!ftp_put($this->_conn_id, $destination_file, $source_file, FTP_BINARY))
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近 上传文件 出错。");
			return false;
		}
		else 
			return true;
	}
	
	function FtpMkdir($dir)
	{
		$dir = trim($dir, '/');
		$dir_array = split('/', $dir);
		$dir_array_depth = count($dir_array);
		ftp_chdir($this->_conn_id, "/");
		for($i=0;$i<$dir_array_depth;$i++)
		{
			$dir = $dir_array[$i];
			//echo $dir;
			if(!@ftp_chdir($this->_conn_id, $dir))
			{
				ftp_mkdir($this->_conn_id, $dir);
				ftp_chdir($this->_conn_id, $dir);
			}
		}
		return true;
	}
	
	/**
	* @param $mode 输模式参数 mode 只能为 FTP_ASCII（文本模式）或 FTP_BINARY（二进制模式）。 
	*/
	function Get($local_file, $server_file, $mode)
	{
		return ftp_get($this->_conn_id, $local_file, $server_file, $mode);
	}
	
	function Delete($path)
	{
		return ftp_delete($this->_conn_id, $path);
	}
	
	function Chdir($dir)
	{
		return ftp_chdir($this->_conn_id, $dir);
	}
	
	function Mkdir($dir)
	{
		return ftp_mkdir($this->_conn_id, $dir);
	}
	
	function Rmdir($dir)
	{
		return ftp_rmdir($this->_conn_id, $dir);
	}
	
	function Size($path)
	{
		return ftp_site($this->_conn_id, $path);
	}
	
	function Mdtm($path)
	{
		return ftp_mdtm($this->_conn_id, $path);
	}
	
	function Pwd()
	{
		return ftp_pwd($this->_conn_id);
	}
	
	function Rename($from, $to)
	{
		return ftp_rename($this->_conn_id, $from, $to);
	}
		
	function Close()
	{
		ftp_close($this->_conn_id);
	}
}
