<?php

//�������ļ����飬�����ļ��к��ļ��������ļ��к��ļ��ĸ���
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
	$t->Set_Var("����",$d?$d:"<font color=red>���ļ�����ʧ�ܣ�������û��Ȩ��/�ļ��Ƿ����</font>");
	$t->Parse("Out","ftp");
	$t->p("Out");
	//��������ʱ��
	List($End_Usec, $End_Sec) = Explode(" ",microtime());
	$Last=Sprintf("%.5f",$End_Sec+$End_Usec-$start_sec-$start_usec);
	Echo 'ҳ��ִ��ʱ��'.$Last."��</center><p>&nbsp;<p></body></html>";
	Exit;
}
$t->Set_Var("��ʾ","<tr>	<td bgcolor=\"#023266\"   colspan=\"8\" align=\"center\">�����ɹ�<a href=\"?dir=".urlencode($Dir)."\">�������ˢ��</td></tr>");
}

?>


<?php

class My_Ftp {

	var $Ftp_Host="";
	var $Ftp_User="anonymous";
	var $Ftp_Pass="";
	var $Ftp_Port="21";
	var $Con;//���ӱ�־


//��ʼ�����б���
Function My_Ftp($Ftp_Host='',$Ftp_User='',$Ftp_Pass='',$Ftp_Port='') {
@set_time_limit(0)?"":print("������֧��set_time_limit����,ע�͵�Ftp.Class.php�ĵ�48��<br>");
if(!$_COOKIE['FTP']){
$Ftp_Function = @Get_Defined_Functions();
if(!@In_Array("ftp_connect",$Ftp_Function[internal])){
	die("<font color=red>�������ˣ��˷�������֧��FTP������~!</font>");
}
SetCookie("FTP","1",Time()+3600);
}
	$this->Ftp_Host=$Ftp_Host;
	$this->Ftp_User=$Ftp_User;
	$this->Ftp_Pass=$Ftp_Pass;
	$this->Ftp_Port=$Ftp_Port;
}


//������������,���󣬲�ʹ��
Function Server_Type() {
Return @Ftp_Systype($this->Con);
}



//����ftp����,�������Ӻ�
Function Link_Ftp() {

$Con=@Ftp_Connect($this->Ftp_Host,$this->Ftp_Port); 

$this->Con=$Con;
if(!$Con){
	$Message[0]=0;
	$Message[1]="<font color=red>�޷�����������$this->Ftp_Host <br><a href='index.php'>�������</a><br>���ص�½����</font>";
	Return $Message;
	}

$Login=@Ftp_Login($Con,$this->Ftp_User,$this->Ftp_Pass); 

if(!$Login)
	{
	$Message[0]=0;
	$Message[1]="<font color=red>�û������������ <br><a href='index.php'>�������</a><br>���ص�½����</font>";
	Return $Message;
	}

$Message[0]=1;
$Message[1]=$this->Con;
Return $Message;
}




//����Ŀ¼�µ��ļ�
Function List_Ftp($Dir='') {
	$A_Message=@Ftp_Rawlist($this->Con, $Dir);
	
	$A_Len=Count($A_Message);


//�����пո���ļ���	

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



//�л�Ŀ¼
Function Chdir_Ftp($Dir='') {

if(!@Ftp_Chdir($this->Con,$Dir)){
Return 0;
}
Return 1;
}

//����Ŀ¼
Function Folder_Ftp($Dir='��Ŀ¼') {
$New_Dir=@Ftp_Mkdir($this->Con,$Dir);
if($New_Dir)
Return 1;
Return 0;

}

//�������ļ�,�ƶ��ļ�
Function Rename_Ftp($File_From,$File_To) {
$Re_Move=@Ftp_Rename($this->Con,$File_From,$File_To);
if ($Re_Move)
Return 1;
Return 0;
}



//ɾ���ļ�
Function Del_File_Ftp($File) {
$Del=@Ftp_Delete($this->Con,$File);
if($Del)
Return 1;
Return 0;

}


//ɾ��Ŀ¼
Function Del_Folder_Ftp($Dir) {
$Del=@Ftp_Rmdir($this->Con,$Dir);
if($Del)
Return 1;
Return 0;

}

//�ϴ�����
Function Up_Load_Ftp($Server_File,$Source_File,$Up_Type="FTP_BINARY") {
$Server_File==""?$Server_File="/":"";
$Up_Type=="FTP_BINARY"?$upload =@Ftp_Put($this->Con,$Server_File,$Source_File,FTP_BINARY):$upload =@Ftp_Put($this->Con,$Server_File,$Source_File,FTP_ASCII);;
if ($upload){

Return 1;
}
return 0;

}

//�����ļ�
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

//cookie����
Function Cookie_Ftp() {
Setcookie("Ftp_Host",$this->Ftp_Host,time()+3600);
Setcookie("Ftp_User",$this->Ftp_User,time()+3600);
Setcookie("Ftp_Pass",$this->Ftp_Pass,time()+3600);
Setcookie("Ftp_Port",$this->Ftp_Port,time()+3600);
Setcookie("Have_Login","Yes",time()+3600);

}

//�˳�
Function Quite_Ftp() {

	ftp_quit($this->Con);
}

}
/*
�����
*/
?>
