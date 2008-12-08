<?
/*
------------------------------------------------------------------------------------
类名:Lwgupload
说明:多文件上传类
作者:龙卫国
网络user:lwg888
邮箱:lwg888@163.com
使用、修改、传播请保留作者信息
------------------------------------------------------------------------------------
*/

class Lwgupload{
//-------------可以设置值的变量------------------------
var $uploadfield;//上传文件的字段名
var $maxsize;//限制上传文件的大小 
var $file_old;//需要删除的旧文件   
var $uploadpath;//文件的上传路径   
var $ftype;//限制上传文件的类型  
var $debug=true;//是否显示调试或错误信息

//------------用来获取值的变量---------------------------
var $uploadfile;//上传后的临时文件
var $file_name;//文件名
var $file_size;//文件的大小
var $file_size_format;//格式化后的$file_size 
var $file_type;//文件类型
var $debugstr="";//记录调试信息  
var $err="";//记录错误信息

//构造函数
//$uploadfield  上传文件的字段名，上传多个文件时可以是数组 
//$uploadpath 文件的上传路径，不能为数组  
//$maxsize 限制上传文件的大小，上传多个文件时可以是数组，为不同的文件限制不同大小 
//$ftype 限制上传文件的类型，上传多个文件时可以是数组，为不同的文件限制不同类型   
//$ftype 为‘all’时为不限制类型
//使用时可以将$ftype的值设为array('jpg,gif,png','swf','all')表示为三个上传文件限制类型。第一个文件必须是jpg或gif或png，第二个必须是swf,第三个为任意类型
function Lwgupload($uploadfield="",$uploadpath="",$maxsize="",$ftype="all"){
    $this->uploadfield=$uploadfield;
    $this->uploadpath=$uploadpath;
    $this->maxsize=$maxsize;
    $this->ftype=$ftype;
}

//test()用来测试能否全部上传，否则一个也不要上传
//$oldfile表示要删除的文件，用在更新中，删除旧的上传新的
function test($oldfile=''){ 
    if ($this->uploadfield=="")return; 
    if (empty($this->uploadpath))$this->uploadpath=dirname($_SERVER['PATH_TRANSLATED'])."/Upload";
    if (empty($this->maxsize))$this->maxsize=1048576;
    if (!is_array($this->uploadfield))$this->uploadfield=array($this->uploadfield);
    //如果不为数组改为数组，便于后面代码的简化
    $total_upload=count($this->uploadfield);//获得总字段数
    
    if (!is_array($this->maxsize))$this->maxsize=array($this->maxsize);//如果不为数组改为数组，便于后面代码的简化
    if (!is_array($this->ftype))$this->ftype=array($this->ftype);//同上    
    
    //如果没有相应路径则建立之
    if (!file_exists($this->uploadpath)){ 
        if (!mkdir($this->uploadpath,0700))return output("错误！请手动建立有效路径。"); 
    }
    
    //include_once(dirname(__FILE__)."/Lwgfiletype.inc.php"); 
    //该文件包含了数组变量$filetype，记录大多数文件类型对应的扩展名
    
    Set_time_limit(60);//设置超时为60秒 
    
    $needupload=array();//经测试可以上传的文件 
    
    for ($i=0;$i<$total_upload;$i++){
        $this->uploadfile[$i]=$this->uploadfield[$i]['tmp_name']; //临时文件
        $this->file_name[$i]=$this->uploadfield[$i]['name']; //文件名
        $this->file_type[$i]=$this->uploadfield[$i]['type']; //类型 
        $this->file_lname[$i]=strtolower(substr( strrchr($this->file_name[$i], "." ), 1 ));  //扩展名
        $this->file_size[$i]=$this->uploadfield[$i]['size']; //大小
        $this->file_old[$i]=$_POST[$this->uploadfield[$i].'_old']; //需要删除的文件
        $this->newfile[$i]=$this->uploadpath."/".$this->file_name[$i];//上传后的地址  
        
        $maxsize=(!empty($this->maxsize[$i]) && $this->maxsize[$i]>0)?$this->maxsize[$i]:$this->maxsize[0];
    
        $maxsize_value=$this->format_maxsize($maxsize);//将$maxsize格式化
        
        $thetype=(!empty($this->ftype[$i]))?$this->ftype[$i]:$this->ftype[0]; 
        $ftype=array();
        $lname=array();
        if ($thetype!="all"){
          $tmp_type=explode(",",$thetype);
          for ($n=0;$n<sizeof($tmp_type);$n++){
            $tmp_t=trim($tmp_type[$n]);
            if (!empty($tmp_t)){
                $s_tmp=strtolower($tmp_t);
                $ftype[]=$filetype[$s_tmp];
                $lname[]=$s_tmp;
            }
          }
        }
        //分析限制当前类型的参数

        if (($this->file_size[$i]==0)||($this->uploadfile[$i]=="")){ 
            return $this->output($this->uploadfield[$i]."上传了无效文件或0字节文件。");
        }
        
        if ($thetype!="all" && !in_array($this->file_type[$i],$ftype) && !in_array($this->file_lname[$i],$lname)){
            return $this->output("对不起！上传文件格式只能是'".$thetype."'。");
        }
        
        if ($this->file_size[$i] > $maxsize){ 
            return $this->output("对不起！文件'".$this->file_name[$i]."'大于'".$maxsize_Value."',上传失败。\n请减小文件到".$maxsize_Value."之内，然后再试。");
        }
        
        if (file_exists($this->newfile[$i])){
            if ($oldfile=="" || ($oldfile!="" && !in_array($this->newfile[$i],$oldfile)))return $this->output("对不起！文件'".$this->file_name[$i]."'已经存在,上传失败。请更改文件名，然后再试。");
            //$oldfile表示要删除的文件,虽然要上传的文件存在，但它将要被删除，因此还是可以上传
        }
        
        if (in_array($this->file_name[$i],$needupload)){
            //如果两个以上的上传字段上传相同的文件是不允许的
            return $this->output("对不起！文件'".$this->file_name[$i]."'重复,上传失败。请更改文件名，然后再试。");
        }
        $needupload[]=$this->file_name[$i];
    }
    Set_time_limit(30);//设置超时为30秒
    return true;
}


//测试过关后可以上传
function upload(){
    if ($this->uploadfield=="")return false;
    $total_upload=count($this->uploadfield);
    
    for ($i=0;$i<$total_upload;$i++){
        $this->file_size_format[$i]=$this->format_maxsize($this->file_size[$i]);
                    
        if (@move_uploaded_file($this->uploadfile[$i],$this->newfile[$i]))
            $this->debugstr.="文件'".$this->file_name[$i]."'(".$this->file_size_format[$i].")上传成功。<br>";
        else {
            if ($i>0)$this->err_del(($i-1),$this->newfile); 
            //如果有一个上传失败，则删除所有已上传的文件   
            return $this->output("对不起！文件'".$this->file_name[$i]."'上传失败。请重试。");
        }
    }
    return true;
}

//格式化文件大小数字
function format_maxsize($value){
    if ($value<1024)$maxsize_Value = $value."字节";
    elseif ($value<1024*1024)$maxsize_Value = number_format((double)($value/1024),2)."kb";
    else $maxsize_Value = number_format((double)($value/(1024*1024)),2)."mb";
    return $maxsize_Value;
}

//出错后删除已上传的文件 
function err_del($i,$thefile){
    while ($i>=0){
        if (@unlink($thefile[$i])!=false)$this->debugstr.="文件'".$thefile[$i]."'删除成功 <br>";
        $i--;
    }
}

//记录和输出错误信息 
function output($msg){
    if ($msg!="")$this->err=$msg;
    if ($this->debug)echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert(\"".$msg."\");history.go(-1)</script>";
    return false;
}
}

/*
----------------使用方法-----------------------------------------------
$obj=Lwgupload("image1","",1024*2,"all");
if ($obj->test())$obj->upload();
-------------------------------------------------------------------------
*/
?>
