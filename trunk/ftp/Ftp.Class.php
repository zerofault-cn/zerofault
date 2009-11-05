<?php

//传送入文件数组，包括文件夹和文件，返回文件夹和文件的个数
Function File_Folder_Len($Forlde_File_Array){
$Len=Count($Forlde_File_Array);
$Child_Folder_Count=0;
$Child_File_Count=0;
for($u=0; $u<$Len; $u++) Eregi("^d",$Forlde_File_Array[$u])?$Child_Folder_Count++:"";

for($u=0; $u<$Len; $u++) Eregi("^-",$Forlde_File_Array[$u])?$Child_File_Count++:"";

$Len=array($Child_Folder_Count,$Child_File_Count);

Return $Len;
}

Function Set_Error_Message($m='',$d='') {
global $t,$start_sec,$start_usec,$Dir;
if($m==0){
	$t->Set_Var("错误",$d?$d:"<font color=red>对文件操作失败！可能是没有权限/文件是否存在</font>");
	$t->Parse("Out","ftp");
	$t->p("Out");
	//计算运行时间
	List($End_Usec, $End_Sec) = Explode(" ",microtime());
	$Last=Sprintf("%.5f",$End_Sec+$End_Usec-$start_sec-$start_usec);
	Echo '页面执行时间'.$Last."秒</center><p>&nbsp;<p></body></html>";
	Exit;
}
$t->Set_Var("提示","<tr>	<td bgcolor=\"#023266\"   colspan=\"8\" align=\"center\">操作成功<a href=\"?dir=".urlencode($Dir)."\">点击这里刷新</td></tr>");
}

?>


<?php

class My_Ftp {

	var $Ftp_Host="";
	var $Ftp_User="anonymous";
	var $Ftp_Pass="";
	var $Ftp_Port="21";
	var $Con;//连接标志


//初始化所有变量
Function My_Ftp($Ftp_Host='',$Ftp_User='',$Ftp_Pass='',$Ftp_Port='') {
@set_time_limit(0)?"":print("主机不支持set_time_limit函数,注释掉Ftp.Class.php的第48行<br>");
if(!$_COOKIE['FTP']){
$Ftp_Function = @Get_Defined_Functions();
if(!@In_Array("ftp_connect",$Ftp_Function[internal])){
	die("<font color=red>可怜的人，此服务器不支持FTP函数库~!</font>");
}
SetCookie("FTP","1",Time()+3600);
}
	$this->Ftp_Host=$Ftp_Host;
	$this->Ftp_User=$Ftp_User;
	$this->Ftp_Pass=$Ftp_Pass;
	$this->Ftp_Port=$Ftp_Port;
}


//检查服务器类型,错误，不使用
Function Server_Type() {
Return @Ftp_Systype($this->Con);
}



//连接ftp主机,返回连接号
Function Link_Ftp() {

$Con=@Ftp_Connect($this->Ftp_Host,$this->Ftp_Port); 

$this->Con=$Con;
if(!$Con){
	$Message[0]=0;
	$Message[1]="<font color=red>无法连接主机：$this->Ftp_Host <br><a href='index.php'>点击这里</a><br>返回登陆界面</font>";
	Return $Message;
	}

$Login=@Ftp_Login($Con,$this->Ftp_User,$this->Ftp_Pass); 

if(!$Login)
	{
	$Message[0]=0;
	$Message[1]="<font color=red>用户名或密码错误 <br><a href='index.php'>点击这里</a><br>返回登陆界面</font>";
	Return $Message;
	}

$Message[0]=1;
$Message[1]=$this->Con;
Return $Message;
}




//返回目录下的文件
Function List_Ftp($Dir='') {
	$A_Message=@Ftp_Rawlist($this->Con, $Dir);
	
	$A_Len=Count($A_Message);


//处理有空格的文件名	

	for($i=0; $i<$A_Len; $i++){
	$p[$i]=Preg_Replace("/([a-zA-Z|\-]+)([ ]+)([0-1])([ ]+)([a-zA-Z0-9]+)([ ]+)([a-zA-Z0-9]+)([ ]+)([a-zA-Z0-9]+)([ ]+)([a-zA-Z0-9]+)([ ]+)([a-zA-Z0-9|\:]+)([ ]+)([a-zA-Z0-9|\:]+)([ ]+)(.*)/","$17",$A_Message[$i]);
	$A_Message[$i]=Preg_Replace("/([a-zA-Z|\-]+)([ ]+)([0-1])([ ]+)([a-zA-Z0-9]+)([ ]+)([a-zA-Z0-9]+)([ ]+)([a-zA-Z0-9]+)([ ]+)([a-zA-Z0-9]+)([ ]+)([a-zA-Z0-9|\:]+)([ ]+)([a-zA-Z0-9|\:]+)([ ]+)(.*)/","$1|$3|$5|$7|$9|$11|$13|$15|$17",$A_Message[$i]);

	}

for($i=0; $i<$A_Len; $i++){
if($p[$i]!="."&&$p[$i]!=".."){
$k[]=$A_Message[$i];
}
}

 Return $k;
}



//切换目录
Function Chdir_Ftp($Dir='') {

if(!@Ftp_Chdir($this->Con,$Dir)){
Return 0;
}
Return 1;
}

//建立目录
Function Folder_Ftp($Dir='空目录') {
$New_Dir=@Ftp_Mkdir($this->Con,$Dir);
if($New_Dir)
Return 1;
Return 0;

}

//重命名文件,移动文件
Function Rename_Ftp($File_From,$File_To) {
$Re_Move=@Ftp_Rename($this->Con,$File_From,$File_To);
if ($Re_Move)
Return 1;
Return 0;
}



//删除文件
Function Del_File_Ftp($File) {
$Del=@Ftp_Delete($this->Con,$File);
if($Del)
Return 1;
Return 0;

}


//删除目录
Function Del_Folder_Ftp($Dir) {
$Del=@Ftp_Rmdir($this->Con,$Dir);
if($Del)
Return 1;
Return 0;

}

//上传处理
Function Up_Load_Ftp($Server_File,$Source_File,$Up_Type="FTP_BINARY") {
$Server_File==""?$Server_File="/":"";
$Up_Type=="FTP_BINARY"?$upload =@Ftp_Put($this->Con,$Server_File,$Source_File,FTP_BINARY):$upload =@Ftp_Put($this->Con,$Server_File,$Source_File,FTP_ASCII);;
if ($upload){

Return 1;
}
return 0;

}

//下载文件
Function Down_Ftp($File_name) {

$down_name=Substr(Strrchr($File_name, "/"), 1);
$File_dir ="ftp://".$this->Ftp_User.":".$this->Ftp_Pass."@".$this->Ftp_Host.":".$this->Ftp_Port.$File_name;

$file =@Fopen($File_dir,"r");   

if (!$file) { 
Return 0;
} else { 
Ob_End_Clean();
Header("Content-type: application/octet-stream"); 
Header("Content-disposition: attachment; filename=" . $down_name);
header("Cache-control: private");
while (!Feof ($file)) { 
Echo readfile($file,4096); 
} 
Fclose ($file); 
exit;
}

}

//cookie处理
Function Cookie_Ftp() {
Setcookie("Ftp_Host",$this->Ftp_Host,time()+3600);
Setcookie("Ftp_User",$this->Ftp_User,time()+3600);
Setcookie("Ftp_Pass",$this->Ftp_Pass,time()+3600);
Setcookie("Ftp_Port",$this->Ftp_Port,time()+3600);
Setcookie("Have_Login","Yes",time()+3600);

}

//退出
Function Quite_Ftp() {

	ftp_quit($this->Con);
}

}
/*
类结束
*/
?>
