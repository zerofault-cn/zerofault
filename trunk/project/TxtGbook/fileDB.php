<?
class fileDB
{
//数据库系统工作的基本目录;
var $dbdir;
//数据库主文件;
var $dbfile;
//数据库辅助文件，用于存放数据属性和主键已经他们在主文件中的指针情况;
var $dbfilelist;
//数据库用户文件，存放数据库用户名和密码;
var $dbuserfile;
//数据库名;
var $database;
//表的主文件名;
var $tablefile;
//表的辅文件名;
var $tableman;
//表的删除空间管理文件名;
var $tabledel;
//整个数据库的用户名;
var $user;
//用户的密码;
var $pw;
//用户是否连接到数据库;
var $isConnectDB;
//用户是否连接到表;
var $isConnectTable;
//用户是否登陆;
var $isLogin;
//用户函数;
////////////////////////////////////////////////////////////////////////////////////////
function fileDB()
{
$this->dbdir="./fileDatabase/";
$this->dbuserfile=$this->dbdir."admin.fdb";
echo "
欢迎使用 File Database 2.0 版本
所有版权归麦唐工作室所有
leeo开发。


"; 
}
//用户初始化，包括建立基本数据库工作目录，建立用户文件，写入用户名和用户密码;
//用户名和密码最长不能超过20位;
function init($user,$pw)
{
$this->user=$user;
$this->pw=$pw;
if(!is_dir($this->dbdir))
{
mkdir($this->dbdir,0700);
$this->formatdata("a",20,$this->user);
$this->formatdata("z",20,$this->pw);
$this->encrypt($this->user);
$this->encrypt($this->pw);
$fp=fopen($this->dbuserfile,"w");
fwrite($fp,$this->user);
fwrite($fp,$this->pw);
fclose($fp);
}
}
//判断是否合法用户登陆;
function login($user,$pw)
{
$this->formatdata("a",20,$user);
$this->formatdata("z",20,$pw);
$this->encrypt($user);
$this->encrypt($pw);
$fp=fopen($this->dbuserfile,"r");
$fuser=fread($fp,20);
$fpw=fread($fp,20);
fclose($fp);
if(strcmp($fuser,$user)!=0)
{
echo "此用户不存在!
";
$this->isLogin=false;
return;
}
if(strcmp($pw,$fpw)!=0)
{
echo "密码错误!
";
$this->isLogin=false;
return;
}
$this->isLogin=true;
}
//建立数据库，即在基本目录中建立一个以数据库名命名的文件夹;
function createDB($database)
{
if($this->isLogin!=true)
{
echo "用户登陆错误!
";
return false;
}
$database=$this->dbdir.$database;
if(is_dir($database))
{
echo basename($this->database)."数据库已经存在!
";
return false;
}
mkdir($database,0700);
return true;
}
//返回当前操作的数据库名;
function getDatabase()
{
if($this->isConnectDB!=true)
{
echo "目前没有连接到任何数据库!
";
return false;
}
$database=basename($this->database);
return $database;
}
//连接到数据库;
function connectDB($database)
{
if($this->isLogin!=true)
{
echo "用户登陆错误!
";
return false;
}
$this->database=$this->dbdir.$database;

if($this->isDatabase($this->database))
$this->isConnectDB=true;
else
{
echo "连接数据库错误!
";
$this->isConnectDB=false;
}
}

//关闭数据库;
function closeDB()
{
$this->database=false; 
$this->isConnectDB=false;
$this->isLogin=false;
}
//删除数据库;
//删除数据库时必须保证其中没有任何表;
function dropDB()
{
if(!$this->isConnectDB)
return false;
if(rmdir($this->database)==0)
{
echo "当前库下还有表或者用户不具备相应权限!
";
return false;
}
$this->closeDB();
return true;
}
//在给出的数据库$database下建一个表$table。
//$ele为数组形式的属性项，$elesize为数组形式的属性项大小，和$ele是对应的。
//$table辅文件中第一位为0表示本表未锁，为1表示本表以锁，
//2~4三位表示本表中属性项的个数，
//4~7四位表示本表中元组的个数，
//其中属性项为20位，属性项大小描述的为5位，一个属性描述总长为25位。
function createTable($table,$tuple,$tupleSize)
{
if($this->isLogin!=true)
{
echo "用户登陆错误!
";
return false;
}
if($this->isConnectDB!=true)
{
echo "用户连接数据库错误!
";
return false;
}
$tablefile=$this->database."/".$table.".fdb";
$tableman=$this->database."/".$table."_man.fdb";
$tabledel=$this->database."/".$table."_del.fdb";
if(is_file($tablefile))
{
echo basename($tablefile)."表已经存在!
";
return false;
}
//判断提供的属性和属性大小数组变量是否合法。
if(!is_array($tuple))
{
echo "提供的属性项不是数组形式!
";
return false;
}
if(!is_array($tupleSize))
{
echo "提供的属性项大小不是数组形式!
";
return false;
}
//判断属性和属性大小数组是否匹配。
if(count($tuple)!=count($tupleSize))
{
echo "属性数组和属性大小数组不匹配!
";
return false;
}
//取得属性数组中元素个数;
else
{
$elenum=count($tuple);
$this->formatdata("0",3,$elenum);
}
$fp=fopen($tablefile,"w");
fclose($fp);
$fp=fopen($tabledel,"w");
$fp=fopen($tableman,"w");
fwrite($fp,"0");
fwrite($fp,$elenum);
fwrite($fp,"0000");
for($i=0;$i<$elenum;$i++)
{
$this->formatdata(" ",20,$tuple[$i]);
$this->formatdata("0",5,$tupleSize[$i]);
fwrite($fp,$tuple[$i]);
fwrite($fp,$tupleSize[$i]);
}
fclose($fp);
}

--------------------------------------------------------------------------------

这是源程序02：
//返回目前操作的表名;
function getTable()
{
if($this->isConnectTable!=true)
{
echo "目前没有连接到任何表!
";
return false;
}
$table=basename($this->tablefile);
$table=substr($table,0,strlen($table)-4);
return $table;
}
//返回数据库中所有的表;
function tableList()
{
if(!$this->isConnectDB)
{
echo "连接数据库错误!
";
return false;
}
$base=dir($this->database);
for($i=0;$t[$i]=$base->read();$i++)
{
if($i>1)
{
if(!strpos($t[$i],"_"))
if(!strpos($t[$i],"bak"))
$table[$i-2]=$t[$i];
}
}
$base->close();
return $table;
}
//连接到表
function connectTable($table)
{
if($this->isConnectDB!=true)
{
echo "用户还未连接到数据库!
";
return false;
}
$this->tablefile=$this->database."/".$table.".fdb";
$this->tableman=$this->database."/".$table."_man.fdb";
$this->tabledel=$this->database."/".$table."_del.fdb";
if($this->isTable($this->tableman))
$this->isConnectTable=true;
else
$this->isConnectTable=false;
}
//关闭表;
function closeTable()
{
$this->tablefile=false;
$this->tableman=false;
$this->tabledel=false;
$this->isConnectTable=false;
}
//删除表;
//删除表后会关闭数据库连接，如果要进行其他操作需重新连接数据库和表;
//要彻底删除一个表要删除它的备份，然后删除它本身;
function dropTable()
{
if(!$this->isConnectTable)
{
echo "还未连接到表!
";
return false;
}
if($this->seeLock()!=0)
$this->wait();
unlink($this->tablefile);
unlink($this->tableman);
unlink($this->tabledel);
$this->closeTable();
$this->isConnectTable=false;
}
//删除备份表;
function dropTablebak()
{
if(!$this->isConnectTable)
{
echo "还未连接到表!
";
return false;
}
if($this->seeLock()==1)
$this->wait();
unlink($this->tablefile.".bak");
unlink($this->tableman.".bak");
unlink($this->tabledel.".bak");
}
//返回表中元组的个数;
function countTuple()
{
if(!$this->isConnectTable)
{
echo "还未连接到表!
";
return false;
}
if($this->seeLock()==1)
$this->wait();
$size=filesize($this->tableman);
$attrNum=$this->countAttr();
$count=($size-8-25*$attrNum)/8/$attrNum;
return $count;
}
//统计表中的属性个数;
function countAttr()
{
if(!$this->isConnectTable)
{
echo "还未连接到表!
";
return false;
}
if($this->seeLock()==1)
$this->wait();
$fp=fopen($this->tableman,"r");
fseek($fp,1);
$elenum=(int)fread($fp,3);
fclose($fp);
return $elenum;
}
//以数组形式返回表中各属性项大小;
function tableAttrsize()
{
if($this->seeLock()==1)
$this->wait();
$fp=fopen($this->tableman,"r");
fseek($fp,8);
$num=$this->countAttr();
for($i=0;$i<$num;$i++)
{
fseek($fp,ftell($fp)+20);
$eleSize[$i]=(int)fread($fp,5);
}
return $eleSize;
}
//取得表中的属性项，并以数组的形式输出;
function selectAttr()
{
if(!$this->isConnectTable)
{
echo "还未连接到表!
";
return false;
}
if($this->seeLock()==1)
$this->wait();
if(!$this->isConnectTable)
return false;
$fp=fopen($this->tableman,"r");
fseek($fp,8);
for($i=0;$i<$this->countAttr();$i++)
{
$Attr[$i]=trim(fread($fp,20));
fseek($fp,ftell($fp)+5);
}
return $Attr;
}
//给表插入数据，$table是要操作的表名，$ele是数组形式要插入的数据名;
//一次只能插入一行数据，即数组中元素个数要与表中属性项个数相等;
//每个元组用8位记载本元组在$tablefile里的起始地址;
//本函数执行时先给$tableman加锁防止其他操作读写本文件，当插入操作结束时解本表的锁;
function insertTable($tuple)
{ 
$check=$this->insertTuplecheck($tuple);
if($check==0)
return false;
$attrNum=$this->countAttr();
$tupleSize=$this->tableAttrsize();
$assNum=filesize($this->tabledel)/8/3;
if($this->seeLock()!=0)
$this->wait();
$this->loginStart();
$this->tableBak();
$this->xLock();
$mp=fopen($this->tableman,"a");
if($check==1)
{ 
for($i=0;$i<$attrNum;$i++)
{
$this->formatdata(" ",$tupleSize[$i],$tuple[$i]);
if($assNum>0)
{
$fp=fopen($this->tablefile,"r+");
$dp=fopen($this->tabledel,"r");
$ap=(int)fread($dp,8);
fseek($fp,$ap);
$dplast=fread($dp,filesize($this->tabledel));
fclose($dp);
$dp=fopen($this->tabledel,"w");
fwrite($dp,$dplast);
fclose($dp);
}
else
$fp=fopen($this->tablefile,"a");
fwrite($fp,$tuple[$i]);
$tupleOr=ftell($fp)-strlen($tuple[$i]);
$this->formatdata("0",8,$tupleOr);
fwrite($mp,$tupleOr);
fclose($fp);
}
}
if($check==2)
{
if(count($tuple)>$assNum)
{
$b=$assNum-1;
$goon=true;
}
else
{
$b=count($tuple)-1;
$goon=false;
}
if($assNum>0)
{
$fp=fopen($this->tablefile,"r+");
$dp=fopen($this->tabledel,"r"); 
for($i=0;$i<$b;$i++)
{ 
for($j=0;$j<$attrNum;$j++)
{ 
$this->formatdata(" ",$tupleSize[$j],$tuple[$i][$j]);
$sp=fread($dp,8);
fseek($fp,(int)$sp);
fwrite($fp,$tuple[$i][$j]);
fwrite($mp,$sp);
}
}
$dlast=fread($dp,filesize($this->tabledel));
fclose($dp);
$dp=fopen($this->tabledel,"w");
fwrite($dp,$dlast);
fclose($dp);
fclose($fp);
}
if($assNum<=0||$goon==true)
{
$fp=fopen($this->tablefile,"a");
if($goon==true)
$s=$assNum;
else
$s=0;
for($i=$s;$i {
for($j=0;$j<$attrNum;$j++)
{
$this->formatdata(" ",$tupleSize[$j],$tuple[$i][$j]);
fwrite($fp,$tuple[$i][$j]);
$tupleOr=ftell($fp)-strlen($tuple[$i][$j]);
$this->formatdata("0",8,$tupleOr); 
fwrite($mp,$tupleOr);
}
}
fclose($fp);
}
}
fclose($mp);
$this->unLock();
$this->loginEnd();
return true;
}

--------------------------------------------------------------------------------

这是源程序03：
//取得表中顺序从$from到$to的元组;
//返回值以数组形式返回;
function selectTable($from,$to)
{
if(!$this->isConnectTable)
return false;
if(!$this->selectTablecheck($from,$to))
return false;
$attrCount=$this->countAttr();
$tupleSize=$this->tableAttrsize();
$sp=8+25*$attrCount+$from*$attrCount*8;
if($this->seeLock()==1)
$this->wait();
$this->loginStart();
$this->sLock();
$fp=fopen($this->tablefile,"r");
$mp=fopen($this->tableman,"r");
fseek($mp,$sp);
for($u=0,$i=$from;$i<=$to;$i++)
{ 
for($k=0;$k<$attrCount;$k++,$u++)
{
$ep=fread($mp,8);
fseek($fp,$ep);
$tuple[$u]=trim(fread($fp,$tupleSize[$k]));
}
}
fclose($fp);
fclose($mp);
$this->unLock();
$this->loginEnd();
return $tuple;
}
//把相应属性列的数据项以数组形式返回。参数代表元组的序号。失败返回false。
function selectTableByAttr($Attr,$from,$to)
{
if(!$this->isConnectTable)
{
echo "连接表错误!
";
return false;
}
$attr=$this->selectAttr();
$attrNum=$this->countAttr();
for($i=0;$i<$attrNum;$i++)
{
if($Attr==$attr[$i])
{
$have=true;
$attrOrd=$i;
}
}
if(!$have)
{
echo "表中没有 ".$Attr." 这个属性!
";
return false;
}
if(!$this->selectTablecheck($from,$to))
return false;
$sp=8+25*$attrNum+$from*$attrNum*8;
$dis=$attrOrd*8;
$tupleSize=$this->tableAttrsize();
if($this->seeLock()==1)
$this->wati();
$this->loginStart();
$this->sLock();
$fp=fopen($this->tablefile,"r");
$mp=fopen($this->tableman,"r");
fseek($mp,$sp);
for($u=0,$i=$from;$i<=$to;$i++,$u++)
{ 
fseek($mp,ftell($mp)+$dis);
$ep=fread($mp,8);
fseek($fp,$ep);
$tuple[$u]=trim(fread($fp,$tupleSize[$attrOrd]));
}
fclose($fp);
fclose($mp);
$this->unLock();
$this->loginEnd();
return $tuple;
}
//删除表中的元组，从$from到$to范围，参数代表元组在表中的序号。
function dropTuple($from,$to)
{
if(!$this->isConnectTable)
return false;
if(!$this->selectTablecheck($from,$to))
return false;
$attrCount=$this->countAttr();
$eleSize=$this->tableAttrsize();
$sp=8+25*$attrCount+$from*$attrCount*8;
if($this->seeLock()!=0)
$this->wait();
$this->tableBak();
$this->loginStart();
$this->xLock();
$mplen=$attrCount*8*($to-$from+1);
$mp=fopen($this->tableman,"r+");
$dp=fopen($this->tabledel,"r+");
fseek($mp,$sp);
for($i=$from;$i<=$to;$i++)
{
for($k=0;$k<$attrCount;$k++)
{
$ep=fread($mp,8);
fwrite($dp,$ep);
}
}
fclose($mp);
fclose($dp);
$mp=fopen($this->tableman,"r");
$mp1=fread($mp,$sp);
fseek($mp,$sp+$mplen);
$mp2=fread($mp,filesize($this->tableman));
fclose($mp);
unlink($this->tableman);
$mp=fopen($this->tableman,"w");
fwrite($mp,$mp1);
fwrite($mp,$mp2);
fclose($mp);
$this->unLock();
$this->loginEnd();
}
//修改元组其中某个数据项，$tuple是元组在表中的序号，$order是该元组的第几个数据项。
function alterTuple($tuple,$order,$content)
{
if(!$this->isConnectTable)
{
echo "还未连接到表!
";
return false;
}
$attrNum=$this->countAttr();
$tupleNum=$this->countTuple();
$attrSize=$this->tableAttrsize();
if($tuple>=$tupleNum||$tuple<0)
{
echo "表中没有这个元组!
";
return false;
}
if($order>=$attrNum||$order<0)
{
echo "元组中没有这个数据项!
";
return false;
}
$start=8+25*$attrNum+$tuple*$attrNum*8+$order*8;
if(strlen($content)>$attrSize[$order])
{
echo "插入的内容和这个数据项的长度要求不符!
";
return false;
}
$this->formatdata(" ",$attrSize[$order],$content);
if($this->seeLock()!=0)
$this->wait();
$this->tableBak();
$this->loginStart();
$this->xLock();
$mp=fopen($this->tableman,"r");
$fp=fopen($this->tablefile,"r+");
fseek($mp,$start);
$cp=fread($mp,8);
fseek($fp,$cp);
fwrite($fp,$content);
fclose($mp);
fclose($fp);
$this->unLock();
$this->loginEnd();
}
//内部函数
////////////////////////////////////////////////////////////////////////////////////////////////
//操作开始写操作日志;
function loginStart()
{
$lp=fopen($this->tablefile.".log","w");
$time=date("YmdHis");
fwrite($lp,$time);
fclose($lp);
}
//操作结束后删除日志;
function loginEnd()
{
unlink($this->tablefile.".log");
}
//等待函数，判断此时表是否加锁，如果加的锁和要进行的操作不相容，等待。
function wait()
{
$away=false;
while($away!=true)
{
if(is_file($this->tablefile.".log"))
{
$now=date("YmdHis");
$lp=fopen($this->tablefile.".log","r");
$time=fread($lp,14);
fclose($lp);
if(($now-$time)>15)
{
$this->tableResume(1);
$away=true;
}
}
else
$away=true;
}
}
//测试表是否被锁;
function seeLock()
{
$fp=fopen($this->tableman,"r");
$lock=fread($fp,1);
fclose($fp);
return $lock;
}
//X锁表;
function xLock()
{
$fp=fopen($this->tableman,"r+");
fwrite($fp,"1");
fclose($fp);
}
?>