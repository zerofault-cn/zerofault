<?
class timer 
{
	var $StartTime = 0; 
	var $StopTime = 0; 
	var $TimeSpent = 0; 

	function start()
	{
		$this->StartTime = microtime(); 
	} 

	function stop()
	{
		$this->StopTime = microtime(); 
	} 

	function spent() 
	{
		if ($this->TimeSpent) 
		{
			return $this->TimeSpent;
		}
		else 
		{
			$StartMicro = substr($this->StartTime,0,10); 
			$StartSecond = substr($this->StartTime,11,10); 
			$StopMicro = substr($this->StopTime,0,10); 
			$StopSecond = substr($this->StopTime,11,10); 
			$start = doubleval($StartMicro) + $StartSecond; 
			$stop = doubleval($StopMicro) + $StopSecond; 
			$this->TimeSpent = $stop - $start; 
			return substr($this->TimeSpent,0,4); 
		}
	} // end function spent(); 
} //end class timer; 

/********************************************************************
/ ������һ���򵥵����ӣ� 
$timer = new timer; 
$timer->start(); 
$temp=0; 
for($i=0;$i<1000;$i++) 
mysql_query (insert into ........); //�����ݿ��в����¼ 
$timer->stop(); 
echo "�� �����ݿ��в���$temp ����¼������ʱ��Ϊ ".$timer->spent()."�룬ƽ��ÿ����¼��ʱ".$timer->spent/$temp."��"; 
**************************************************************************/
$timer=new timer;
$timer->start();
?>
<div id='float' style='right:30px;position:absolute;top:220px;'>
<a href='javascript:location.reload();' title='ˢ�±�ҳ'><span style="color:green">��ˢ�±�ҳ��</span></a>
</div>
<script language="JavaScript">
<!--
var lastScrollY = 0;
function floatRefresh() {
	diffY = document.documentElement.scrollTop;
	percent =.1*(diffY-lastScrollY);
	if(percent>0){
		percent = Math.ceil(percent);
	}else{
		percent = Math.floor(percent);
	}
	document.all.float.style.pixelTop += percent;
	lastScrollY = lastScrollY + percent;

}
window.setInterval("floatRefresh()",1);
//-->
</script>

<div id="logo"><img src="<?=$phpbbs_root_path?>/image/logo1.jpg" height="90" width="758"></div>
<!-- <a href="#" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('http://zerofault.8866.org');">��Ϊ��ҳ</a>
<a href="javascript:window.external.AddFavorite('http://zerofault.8866.org','����һɫ��ӭ��');">�����ղ�</a> -->
<div id="topNavi" style="width:758px;background-color:#3399cc;text-align:right;padding:2px;">
<a href='<?=$phpbbs_root_path?>/index.php'>Home</a> |
<a href='<?=$phpbbs_root_path?>/music/index.php'>Music</a> |
<a href='<?=$phpbbs_root_path?>/download/index.php'>Download</a> |
<a href='/pictures/index.php'>Pictures</a> |
<a href='/java/java_source/'>JAVA</a> |
<a href='/sblog/index.php'>Blog</a> |
<a href='/phpbb2/index.php'>BBS</a> |
<a href='<?=$phpbbs_root_path?>/mobile/index.php'>MobileLocator</a></div>