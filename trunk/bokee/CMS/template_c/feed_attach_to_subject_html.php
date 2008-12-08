<html>
<head>
<title>附加内容源到栏目</title>
<script language="javascript">
var subjects=new Array(
		<?php
echo $_obj['subjects_array'];
?>

		);
function load_subject(code)
{
	special_code = get_number_str(code);
	count=0;
	for(i=0;i<subjects.length;i++)
    {
        if(subjects[i][0].toString().substring(0,3) == special_code)
        {
            document.getElementById('subject_list').options[count]=new Option(subjects[i][1],subjects[i][0]);
            count=count+1;
        }
    }
    document.getElementById('subject_list').options[0].selected=true;
    document.getElementById('subject_list').length=count;
}
function get_number_str(number)
{
	number = Number(number);
	if(number<10)
		return "00"+number;
	if(number<100)
		return "0"+number;
	return number;
}
function init()
{
	options = document.getElementById('select_channel').options;
	options.selectedIndex = 0;
	load_subject(options[0].value);
}
</script>
</head>
<body onload="init()">
<form action="main.php?do=feed_do_attach_to_subject&feed_id=<?php
echo $_obj['feed_id'];
?>
" name="feedAttachToSubjectForm" method="post">
<center>
<select name="select_channel" id="select_channel" onChange="load_subject(this.value)">
<?php
if (!empty($_obj['channels'])){
if (!is_array($_obj['channels']))
$_obj['channels']=array(array('channels'=>$_obj['channels']));
$_tmp_arr_keys=array_keys($_obj['channels']);
if ($_tmp_arr_keys[0]!='0')
$_obj['channels']=array(0=>$_obj['channels']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['channels'] as $rowcnt=>$channels) {
$channels['ROWCNT']=$rowcnt;
$channels['ALTROW']=$rowcnt%2;
$channels['ROWBIT']=$rowcnt%2;
$_obj=&$channels;
?>
<option value="<?php
echo $_obj['id'];
?>
" ><?php
echo $_obj['name'];
?>
</option>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
</select>
<br><br>
<select name="subject_list" id="subject_list" style="WIDTH: 200px" multiple size=16 > 
</select>
<br><br>
<font size=2>外部rss源</font>:
<br>
<input name=source type='radio' value='cms'><font size=2>CMS </font><input name=source type='radio' value='rss' checked><font size=2>RSS</font> <input name=source type='radio' value='blogmark'><font size=2>博采</font> <input name=source type='radio' value='column'><font size=2>专栏</font> <input name=source type='radio' value='blog'><font size=2>博客</font> <input name=source type='radio' value='bbs'><font size=2>论坛</font>
<br><br>
<input name="Submit" type="submit" id="Submit" value="确定">
</center>
</form>
</body> 
</html>