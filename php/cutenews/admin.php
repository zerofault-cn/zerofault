<?PHP
require_once("./inc/functions.inc.php");
//#################
$PHP_SELF = "admin.php";
error_reporting (E_ALL ^ E_NOTICE);
$cutepath 					= ".";
$config_path_image_upload	= "./images/upimages/";

$config_use_cookies		= TRUE;
$config_use_sessions	= TRUE;

//#################


// Check if CuteNews is not installed
$check_users = file("./inc/users.db.php");
$check_users[1] = trim($check_users[1]);
if(!$check_users[1] or $check_users[1] == "" or $check_users[0] == "not-installed" ) { require("./inc/install.mdu"); die(); }

require_once("./inc/config.php");
require_once("./skins/${config_skin}.skin.php");

if($HTTP_SERVER_VARS['QUERY_STRING'] == "debug"){ debug(); }

if($config_use_sessions){
@session_start();
@header("Cache-control: private");
}

if($action == "logout")
{
    setcookie("md5_password","");
	setcookie("username","");

    if($config_use_sessions){
    	@session_destroy();
	    @session_unset();
	}
    msg("info", "�ǳ�", "�������Ѿ��ǳ�ϵͳ��<a href=\"admin.php\">��¼</a><br /><br>");
}


$is_loged_in = FALSE;
$cookie_logged = FALSE;
$session_logged = FALSE;

// Check if The User is Identified

if($config_use_cookies == TRUE){
/* Login Authorization using COOKIES */

if(isset($username))
{
    if(!isset($HTTP_COOKIE_VARS["md5_password"]))	{ $cmd5_password = md5($password); }
    else											{ $cmd5_password = $HTTP_COOKIE_VARS["md5_password"]; }

    if(check_login($username, $cmd5_password))
    {
        $cookie_logged = TRUE;
        setcookie("lastusername", $username, time()+1012324305);
        setcookie("username", $username);
        setcookie("md5_password", $cmd5_password);

    }else{
    	$result = "<font color=red>�û������������</font>";
        $cookie_logged = FALSE;
   }
}
/* END Login Authorization using COOKIES */
}

if($config_use_sessions == TRUE){
/* Login Authorization using SESSIONS */
	if(isset($HTTP_X_FORWARDED_FOR)){ $ip = $HTTP_X_FORWARDED_FOR; }
	elseif(isset($HTTP_CLIENT_IP))	{ $ip = $HTTP_CLIENT_IP; }
	if($ip == "")				    { $ip = $REMOTE_ADDR; }
	if($ip == "")					{ $ip = "û�м�⵽";}

if($action == "dologin")
{
	$md5_password = md5($password);
    if(check_login($username, $md5_password)){
		$session_logged = TRUE;

		@session_register('username');
		@session_register('md5_password');
		@session_register('ip');

		$_SESSION['username']		= "$username";
		$_SESSION['md5_password'] 	= "$md5_password";
		$_SESSION['ip']				= "$ip";

	}else{
		$result = "<font color=red>�û�����/���������</font>";
		$session_logged = FALSE;
	}
}elseif(isset($_SESSION['username'])){ // Check the if member is using valid username/password
    if(check_login($_SESSION['username'], $_SESSION['md5_password'])){
        if($_SESSION['ip'] != $ip){ $session_logged = FALSE; $result = "�Ự�е�IP�����IP��ƥ��"; }
        else{ $session_logged = TRUE; }
	}else{
		$result = "<font color=red>�û�����/��������󣡣���</font>";
		$session_logged = FALSE;
	}
}

if(!$username){ $username = $_SESSION['username']; }
/* END Login Authorization using SESSIONS */
}

###########################

if($session_logged == TRUE or $cookie_logged == TRUE){ $is_loged_in = TRUE; }

###########################

// If User is Not Logged In, Display The Login Page
if($is_loged_in == FALSE)
{
	if($config_use_sessions){
    	@session_destroy();
	    @session_unset();
	}
    setcookie("username","");
    setcookie("password","");
    setcookie("md5_password","");
	echoheader("user","���¼");

    echo "
    <table leftmargin=0 marginheight=0 marginwidth=0 topmargin=0 border=0 height=100% cellspacing=0>
     <form  name=login action=\"$PHP_SELF\" method=post>
      <tr>
       <td width=80>�û����� </td>
       <td><input tabindex=1 type=text name=username value='$lastusername' style=\"width:134\"></td>
      </tr>
      <tr>
       <td>���룺</td>
       <td><input type=password name=password style=\"width:134\"></td>
      </tr>
      <tr>
       <td></td>
       <td ><input accesskey=\"s\" type=submit style=\"width:134; background-color: #F3F3F3;\" value='      ��¼����      '></td>
      </tr>
      <tr>
       <td align=center colspan=3>$result</td>
      </tr>
     <input type=hidden name=action value=dologin>
     </form>
    </table>";

   echofooter();
}
elseif($is_loged_in == TRUE)
{
// ********************************************************************************
// Include System Module
// ********************************************************************************
                            //name of mod   //access
    $system_modules = array('addnews'  		=> 'user',
    			    'editnews'	 	=> 'user',
                            'main'	   	=> 'user',
                            'options'  		=> 'user',
                            'images'   		=> 'user',
                            'editusers'		=> 'admin',
                            'editcomments'	=> 'admin',
                            'tools'		=> 'admin',
                            'ipban'		=> 'admin',
                            'about'		=> 'user',
                            'preview'		=> 'user',
                            'categories'	=> 'admin',
                            );


    if($mod == ""){ require("./inc/main.mdu"); }
    elseif( $system_modules[$mod] )
    {
    	if($system_modules[$mod] == "user"){ require("./inc/". $mod . ".mdu"); }
        elseif($system_modules[$mod] == "admin" and $member_db[1] == 1){ require("./inc/". $mod . ".mdu"); }
        elseif($system_modules[$mod] == "admin" and $member_db[1] != 1){ msg("error", "�ܾ�����", "ֻ��admin(����Ա)�ܷ��ʱ�ģ��"); exit;}
        else{ die("ģ�����Ȩ��Ҫ���ó�<b>user(��ͨ�û�)</b>��<b>admin(����Ա)</b>"); }
    }
    else{ die("$mod����һ����Ч��ģ��"); }
}

function debug(){
    global $config_version_name, $config_version_id, $config_http_script_dir;
	echo"<center><b>CuteNews������Ϣ��</b><hr><br />";
    echo"�ű��汾/ID��&nbsp&nbsp;$config_version_name / $config_version_id<br />";
    echo"\$config_http_script_dir��&nbsp;&nbsp;$config_http_script_dir<br /><BR>";
    echo"<hr>";
	phpinfo();
    echo"<hr><textarea cols=85 rows=24>";
    print_r(ini_get_all());
    echo"</textarea>";

exit();
}
?>