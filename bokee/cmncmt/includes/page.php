<?php
if(!function_exists(pageft))
{
	function pageft($totle,$pageitem)
	{
		global $page;//接受的变量
		global $offset,$pagenav;//输出的变量
		if(!$page) 
		{
			$page=1;
		}
	
		$lastpg=ceil($totle/$pageitem); //最后页，也是总页数
		$page=min($lastpg,$page);
		$prepg=$page-1; //上一页
		$nextpg=($page==$lastpg ? 0 : $page+1); //下一页
		$offset=($page-1)*$pageitem;
		$pagenav="显示第 <b>".($totle?($offset+1):0)."</b>—<b>".min($offset+$pageitem,$totle)."</b> 条记录，共 <b>".$totle."</b> 条记录<br>";
		if($lastpg<=1) 
		{
			return false;
		}
		$pagenav.=' <a href="javascript:page=1;getData();" target="_self">首页</a> ';
		if($prepg) 
		{
			$pagenav.=' <a href="javascript:page='.$prepg.';getData();" target="_self">上一页</a> ';
		}
		else
		{
			$pagenav.=" 上一页 ";
		}
		if($nextpg) 
		{
			$pagenav.=' <a href="javascript:page='.$nextpg.';getData();" target="_self">下一页</a> ';
		}
		else
		{
			$pagenav.=" 下一页 ";
		}
		$pagenav.=' <a href="javascript:page='.$lastpg.';getData();" target="_self">尾页</a> ';
		
	}
}
?>