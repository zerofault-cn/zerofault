<?
class fileDB
{
//���ݿ�ϵͳ�����Ļ���Ŀ¼;
var $dbdir;
//���ݿ����ļ�;
var $dbfile;
//���ݿ⸨���ļ������ڴ���������Ժ������Ѿ����������ļ��е�ָ�����;
var $dbfilelist;
//���ݿ��û��ļ���������ݿ��û���������;
var $dbuserfile;
//���ݿ���;
var $database;
//������ļ���;
var $tablefile;
//��ĸ��ļ���;
var $tableman;
//���ɾ���ռ�����ļ���;
var $tabledel;
//�������ݿ���û���;
var $user;
//�û�������;
var $pw;
//�û��Ƿ����ӵ����ݿ�;
var $isConnectDB;
//�û��Ƿ����ӵ���;
var $isConnectTable;
//�û��Ƿ��½;
var $isLogin;
//�û�����;
////////////////////////////////////////////////////////////////////////////////////////
function fileDB()
{
$this->dbdir="./fileDatabase/";
$this->dbuserfile=$this->dbdir."admin.fdb";
echo "
��ӭʹ�� File Database 2.0 �汾
���а�Ȩ�����ƹ���������
leeo������


"; 
}
//�û���ʼ�������������������ݿ⹤��Ŀ¼�������û��ļ���д���û������û�����;
//�û�������������ܳ���20λ;
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
//�ж��Ƿ�Ϸ��û���½;
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
echo "���û�������!
";
$this->isLogin=false;
return;
}
if(strcmp($pw,$fpw)!=0)
{
echo "�������!
";
$this->isLogin=false;
return;
}
$this->isLogin=true;
}
//�������ݿ⣬���ڻ���Ŀ¼�н���һ�������ݿ����������ļ���;
function createDB($database)
{
if($this->isLogin!=true)
{
echo "�û���½����!
";
return false;
}
$database=$this->dbdir.$database;
if(is_dir($database))
{
echo basename($this->database)."���ݿ��Ѿ�����!
";
return false;
}
mkdir($database,0700);
return true;
}
//���ص�ǰ���������ݿ���;
function getDatabase()
{
if($this->isConnectDB!=true)
{
echo "Ŀǰû�����ӵ��κ����ݿ�!
";
return false;
}
$database=basename($this->database);
return $database;
}
//���ӵ����ݿ�;
function connectDB($database)
{
if($this->isLogin!=true)
{
echo "�û���½����!
";
return false;
}
$this->database=$this->dbdir.$database;

if($this->isDatabase($this->database))
$this->isConnectDB=true;
else
{
echo "�������ݿ����!
";
$this->isConnectDB=false;
}
}

//�ر����ݿ�;
function closeDB()
{
$this->database=false; 
$this->isConnectDB=false;
$this->isLogin=false;
}
//ɾ�����ݿ�;
//ɾ�����ݿ�ʱ���뱣֤����û���κα�;
function dropDB()
{
if(!$this->isConnectDB)
return false;
if(rmdir($this->database)==0)
{
echo "��ǰ���»��б�����û����߱���ӦȨ��!
";
return false;
}
$this->closeDB();
return true;
}
//�ڸ��������ݿ�$database�½�һ����$table��
//$eleΪ������ʽ�������$elesizeΪ������ʽ���������С����$ele�Ƕ�Ӧ�ġ�
//$table���ļ��е�һλΪ0��ʾ����δ����Ϊ1��ʾ����������
//2~4��λ��ʾ������������ĸ�����
//4~7��λ��ʾ������Ԫ��ĸ�����
//����������Ϊ20λ���������С������Ϊ5λ��һ�����������ܳ�Ϊ25λ��
function createTable($table,$tuple,$tupleSize)
{
if($this->isLogin!=true)
{
echo "�û���½����!
";
return false;
}
if($this->isConnectDB!=true)
{
echo "�û��������ݿ����!
";
return false;
}
$tablefile=$this->database."/".$table.".fdb";
$tableman=$this->database."/".$table."_man.fdb";
$tabledel=$this->database."/".$table."_del.fdb";
if(is_file($tablefile))
{
echo basename($tablefile)."���Ѿ�����!
";
return false;
}
//�ж��ṩ�����Ժ����Դ�С��������Ƿ�Ϸ���
if(!is_array($tuple))
{
echo "�ṩ���������������ʽ!
";
return false;
}
if(!is_array($tupleSize))
{
echo "�ṩ���������С����������ʽ!
";
return false;
}
//�ж����Ժ����Դ�С�����Ƿ�ƥ�䡣
if(count($tuple)!=count($tupleSize))
{
echo "������������Դ�С���鲻ƥ��!
";
return false;
}
//ȡ������������Ԫ�ظ���;
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

����Դ����02��
//����Ŀǰ�����ı���;
function getTable()
{
if($this->isConnectTable!=true)
{
echo "Ŀǰû�����ӵ��κα�!
";
return false;
}
$table=basename($this->tablefile);
$table=substr($table,0,strlen($table)-4);
return $table;
}
//�������ݿ������еı�;
function tableList()
{
if(!$this->isConnectDB)
{
echo "�������ݿ����!
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
//���ӵ���
function connectTable($table)
{
if($this->isConnectDB!=true)
{
echo "�û���δ���ӵ����ݿ�!
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
//�رձ�;
function closeTable()
{
$this->tablefile=false;
$this->tableman=false;
$this->tabledel=false;
$this->isConnectTable=false;
}
//ɾ����;
//ɾ������ر����ݿ����ӣ����Ҫ�������������������������ݿ�ͱ�;
//Ҫ����ɾ��һ����Ҫɾ�����ı��ݣ�Ȼ��ɾ��������;
function dropTable()
{
if(!$this->isConnectTable)
{
echo "��δ���ӵ���!
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
//ɾ�����ݱ�;
function dropTablebak()
{
if(!$this->isConnectTable)
{
echo "��δ���ӵ���!
";
return false;
}
if($this->seeLock()==1)
$this->wait();
unlink($this->tablefile.".bak");
unlink($this->tableman.".bak");
unlink($this->tabledel.".bak");
}
//���ر���Ԫ��ĸ���;
function countTuple()
{
if(!$this->isConnectTable)
{
echo "��δ���ӵ���!
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
//ͳ�Ʊ��е����Ը���;
function countAttr()
{
if(!$this->isConnectTable)
{
echo "��δ���ӵ���!
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
//��������ʽ���ر��и��������С;
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
//ȡ�ñ��е�����������������ʽ���;
function selectAttr()
{
if(!$this->isConnectTable)
{
echo "��δ���ӵ���!
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
//����������ݣ�$table��Ҫ�����ı�����$ele��������ʽҪ�����������;
//һ��ֻ�ܲ���һ�����ݣ���������Ԫ�ظ���Ҫ�����������������;
//ÿ��Ԫ����8λ���ر�Ԫ����$tablefile�����ʼ��ַ;
//������ִ��ʱ�ȸ�$tableman������ֹ����������д���ļ����������������ʱ�Ȿ�����;
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

����Դ����03��
//ȡ�ñ���˳���$from��$to��Ԫ��;
//����ֵ��������ʽ����;
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
//����Ӧ�����е���������������ʽ���ء���������Ԫ�����š�ʧ�ܷ���false��
function selectTableByAttr($Attr,$from,$to)
{
if(!$this->isConnectTable)
{
echo "���ӱ����!
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
echo "����û�� ".$Attr." �������!
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
//ɾ�����е�Ԫ�飬��$from��$to��Χ����������Ԫ���ڱ��е���š�
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
//�޸�Ԫ������ĳ�������$tuple��Ԫ���ڱ��е���ţ�$order�Ǹ�Ԫ��ĵڼ��������
function alterTuple($tuple,$order,$content)
{
if(!$this->isConnectTable)
{
echo "��δ���ӵ���!
";
return false;
}
$attrNum=$this->countAttr();
$tupleNum=$this->countTuple();
$attrSize=$this->tableAttrsize();
if($tuple>=$tupleNum||$tuple<0)
{
echo "����û�����Ԫ��!
";
return false;
}
if($order>=$attrNum||$order<0)
{
echo "Ԫ����û�����������!
";
return false;
}
$start=8+25*$attrNum+$tuple*$attrNum*8+$order*8;
if(strlen($content)>$attrSize[$order])
{
echo "��������ݺ����������ĳ���Ҫ�󲻷�!
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
//�ڲ�����
////////////////////////////////////////////////////////////////////////////////////////////////
//������ʼд������־;
function loginStart()
{
$lp=fopen($this->tablefile.".log","w");
$time=date("YmdHis");
fwrite($lp,$time);
fclose($lp);
}
//����������ɾ����־;
function loginEnd()
{
unlink($this->tablefile.".log");
}
//�ȴ��������жϴ�ʱ���Ƿ����������ӵ�����Ҫ���еĲ��������ݣ��ȴ���
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
//���Ա��Ƿ���;
function seeLock()
{
$fp=fopen($this->tableman,"r");
$lock=fread($fp,1);
fclose($fp);
return $lock;
}
//X����;
function xLock()
{
$fp=fopen($this->tableman,"r+");
fwrite($fp,"1");
fclose($fp);
}
?>