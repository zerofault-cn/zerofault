<html>
<style type="text/css">
<!--
table {
font-size: 14px;
}
.wraper {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	width:160px;
	border:1px solid black;
	padding:20px 10px;
}
-->
</style>
<SCRIPT LANGUAGE="javascript" type="text/javascript">
function Checkform(){
	var frm = document.coopMediaListForm;
    var jj=0;
	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
        if (e.name != 'chkall'){
		    if (e.checked)  jj++;
	    }
    }
	if (jj){
		frm.action="main.php?do=include_delete";
		return window.confirm("确定删除？");
	}else{
		window.alert("没有选择条目");
    	return false;
	}
}
//
function CheckAll(){
	var frm = document.coopMediaListForm;
  	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
    	if (e.name != 'chkall')
       		e.checked = frm.chkall.checked;
  }
}
</script>
<body bgcolor="#FFFFFF" text="#000000">
<?php
echo $_obj['pagebar'];
?>

<p>&nbsp;</p>
<table width="90%" border="1" align="center" cellpadding="20" bordercolor="C1D7F4">
  <tr>
    <td><table width="98%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10">&nbsp;</td>
        <td width="100" bgcolor="C1D7F4" align="center">列表</td>
        <td >&nbsp;</td>
      </tr>
      <tr bgcolor="C1D7F4">
        <td height="1"></td>
        <td height="1"></td>
        <td height="1"></td>
      </tr> 
    </table>
	  <table width="98%"  border="0" cellspacing="0" cellpadding="20">
        <tr align="center">
          <td><form method="post" name="coopMediaListForm" onSubmit="return Checkform()">
		  <table width="100%"  border="0" cellpadding="10" cellspacing="1" bgcolor="C1D7F4">
            <tr align="center" bgcolor="FFFFFF">
                  <td>&nbsp;</td>
                  <td>头条名</td>
				  <td>所属栏目名</td>
				  <td>是否设置为当前头条</td>				  
				  <td>操作</td>
   
            </tr>
            <?php
if (!empty($_obj['headers'])){
if (!is_array($_obj['headers']))
$_obj['headers']=array(array('headers'=>$_obj['headers']));
$_tmp_arr_keys=array_keys($_obj['headers']);
if ($_tmp_arr_keys[0]!='0')
$_obj['headers']=array(0=>$_obj['headers']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['headers'] as $rowcnt=>$headers) {
$headers['ROWCNT']=$rowcnt;
$headers['ALTROW']=$rowcnt%2;
$headers['ROWBIT']=$rowcnt%2;
$_obj=&$headers;
?>
                <tr bgcolor="#F0F4FF" align="center">
                  <td><input type="checkbox" name="include[]" value="<?php
echo $_obj['id'];
?>
"></td>
                  <td><a href="<?php
echo $_obj['url'];
?>
" target="_blank"><?php
echo $_obj['name'];
?>
</a></td>
                  <td><?php
echo $_obj['subject_name'];
?>
</td>
				  <td><?php
echo $_obj['choice'];
?>
</td>
                <td><a href="main.php?do=header_delete&id=<?php
echo $_obj['id'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
" onClick="javascript:return window.confirm('确定删除？');">删除</a> <a href="main.php?do=header_modify&id=<?php
echo $_obj['id'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
">修改</a>  <a href="main.php?do=header_publish&id=<?php
echo $_obj['id'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
">发布</a></td>
              </tr>
			  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
             </table>
			 <table width="98%"  border="0" cellspacing="0" cellpadding="0">
             <tr>
                <td>&nbsp;</td>
				<td>&nbsp;</td>
             </tr>
             <tr>
               <td><INPUT TYPE="checkbox" NAME="chkall" onclick="CheckAll()"> 全选/取消</td>
               <td><INPUT TYPE="hidden" NAME="channel_name" value="<?php
echo $_obj['channel_name'];
?>
"><input type="submit" name="Submit" value="删除选中"></td>
             </tr>
            </table>
          </form></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
echo $_obj['pagebar'];
?>

<form action="main.php?do=coop_media_list&p=<?php
echo $_obj['p'];
?>
" method="post" style="text-align:right;">
  <label for="jumpage">到
  <input type="text" name="p" id="p" value="" style="border: 1px solid #7F9DB9;width: 2em; " />
  页</label>
  <input type="submit" value="go" style="width: 20px;border: 0; " />
</form>
</body>
</html>
