<html>
  <head>
  	<title>RSS文章名称修改</title>
  	<script language="javascript">
	
	function Validator( a )
	{
		if( "" == a.rss_title.value )
		{
			alert( "名称能为空!" );
			a.rss_title.focus();
			return( false );
		}
		else
			return( true );
	}
	
  	</script>
  </head>
  <body>
  	<br>
  	<center>
  	<form action="main.php?do=article_rss_title_do_modify" method="post" name="article_rss_title_modify" onSubmit="return Validator(this)">
  		标题：<input name="rss_title" type="text" size="50" value="<?php
echo $_obj['rss_title'];
?>
"> 
		<br>
  		<input name="channel_name" type="hidden"  value="<?php
echo $_obj['channel_name'];
?>
"> <br>
  		<input name="rss_id" type="hidden" value="<?php
echo $_obj['rss_id'];
?>
"> <br>
		星级：
		<?php
if (!empty($_obj['rss_mark'])){
if (!is_array($_obj['rss_mark']))
$_obj['rss_mark']=array(array('rss_mark'=>$_obj['rss_mark']));
$_tmp_arr_keys=array_keys($_obj['rss_mark']);
if ($_tmp_arr_keys[0]!='0')
$_obj['rss_mark']=array(0=>$_obj['rss_mark']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['rss_mark'] as $rowcnt=>$rss_mark) {
$rss_mark['ROWCNT']=$rowcnt;
$rss_mark['ALTROW']=$rowcnt%2;
$rss_mark['ROWBIT']=$rowcnt%2;
$_obj=&$rss_mark;
?>
			<input name="rss_mark" type="radio" value="<?php
echo $_obj['value'];
?>
" <?php
echo $_obj['checked'];
?>
> <?php
echo $_obj['value'];
?>

		<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		<br><br>
		<input name="submit" type="submit" value="修改">
  	</form>
  	</center>
  </body>
</html>
