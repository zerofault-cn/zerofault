<html>
  <head>
  	<title>文章发布时间修改</title>
  </head>
  <body>
  	<br><br>
  	<center>修改发布时间<br><br>
  	<form action="main.php?do=article_time_do_modify" method="post" name="article_time_modify">
  		年月日：
		<select name="year" size="1">
			<?php
if (!empty($_obj['year'])){
if (!is_array($_obj['year']))
$_obj['year']=array(array('year'=>$_obj['year']));
$_tmp_arr_keys=array_keys($_obj['year']);
if ($_tmp_arr_keys[0]!='0')
$_obj['year']=array(0=>$_obj['year']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['year'] as $rowcnt=>$year) {
$year['ROWCNT']=$rowcnt;
$year['ALTROW']=$rowcnt%2;
$year['ROWBIT']=$rowcnt%2;
$_obj=&$year;
?>
				<option value="<?php
echo $_obj['value'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['name'];
?>
</option>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</select>年
		<select name="month" size="1">
			<?php
if (!empty($_obj['month'])){
if (!is_array($_obj['month']))
$_obj['month']=array(array('month'=>$_obj['month']));
$_tmp_arr_keys=array_keys($_obj['month']);
if ($_tmp_arr_keys[0]!='0')
$_obj['month']=array(0=>$_obj['month']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['month'] as $rowcnt=>$month) {
$month['ROWCNT']=$rowcnt;
$month['ALTROW']=$rowcnt%2;
$month['ROWBIT']=$rowcnt%2;
$_obj=&$month;
?>
				<option value="<?php
echo $_obj['value'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['name'];
?>
</option>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</select>月
		<select name="day" size="1">
			<?php
if (!empty($_obj['day'])){
if (!is_array($_obj['day']))
$_obj['day']=array(array('day'=>$_obj['day']));
$_tmp_arr_keys=array_keys($_obj['day']);
if ($_tmp_arr_keys[0]!='0')
$_obj['day']=array(0=>$_obj['day']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['day'] as $rowcnt=>$day) {
$day['ROWCNT']=$rowcnt;
$day['ALTROW']=$rowcnt%2;
$day['ROWBIT']=$rowcnt%2;
$_obj=&$day;
?>
				<option value="<?php
echo $_obj['value'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['name'];
?>
</option>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</select>日&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
		时分秒：
		<select name="hour" size="1">
			<?php
if (!empty($_obj['hour'])){
if (!is_array($_obj['hour']))
$_obj['hour']=array(array('hour'=>$_obj['hour']));
$_tmp_arr_keys=array_keys($_obj['hour']);
if ($_tmp_arr_keys[0]!='0')
$_obj['hour']=array(0=>$_obj['hour']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['hour'] as $rowcnt=>$hour) {
$hour['ROWCNT']=$rowcnt;
$hour['ALTROW']=$rowcnt%2;
$hour['ROWBIT']=$rowcnt%2;
$_obj=&$hour;
?>
				<option value="<?php
echo $_obj['value'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['name'];
?>
</option>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</select>时
		<select name="minute" size="1">
			<?php
if (!empty($_obj['minute'])){
if (!is_array($_obj['minute']))
$_obj['minute']=array(array('minute'=>$_obj['minute']));
$_tmp_arr_keys=array_keys($_obj['minute']);
if ($_tmp_arr_keys[0]!='0')
$_obj['minute']=array(0=>$_obj['minute']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['minute'] as $rowcnt=>$minute) {
$minute['ROWCNT']=$rowcnt;
$minute['ALTROW']=$rowcnt%2;
$minute['ROWBIT']=$rowcnt%2;
$_obj=&$minute;
?>
				<option value="<?php
echo $_obj['value'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['name'];
?>
</option>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</select>分
		<select name="second" size="1">
			<?php
if (!empty($_obj['second'])){
if (!is_array($_obj['second']))
$_obj['second']=array(array('second'=>$_obj['second']));
$_tmp_arr_keys=array_keys($_obj['second']);
if ($_tmp_arr_keys[0]!='0')
$_obj['second']=array(0=>$_obj['second']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['second'] as $rowcnt=>$second) {
$second['ROWCNT']=$rowcnt;
$second['ALTROW']=$rowcnt%2;
$second['ROWBIT']=$rowcnt%2;
$_obj=&$second;
?>
				<option value="<?php
echo $_obj['value'];
?>
" <?php
echo $_obj['selected'];
?>
><?php
echo $_obj['name'];
?>
</option>
			<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
		</select>秒
		<input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
		<input type="hidden" name="r_id" value="<?php
echo $_obj['r_id'];
?>
">
		<input type="hidden" name="article_id" value="<?php
echo $_obj['article_id'];
?>
">
		<br><br><br>

		<input name="submit" type="submit" value="修改">
  	</form>
  	</center>
  </body>
</html>
