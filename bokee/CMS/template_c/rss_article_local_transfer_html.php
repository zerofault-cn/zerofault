<html>
<style type="text/css">
<!--
table {
font-size: 12px;
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
<head>
  <title>选择要转向的栏目</title>
<script language="javascript">
function validator(){
	var tag = 0;
	var frm = document.form_rss_article_transfer;
  	for(var ii=0;ii<frm.elements.length;ii++){
    	var e=frm.elements[ii];
       	if( e.type == 'checkbox' ){
       		if(e.checked){
       			tag = 1;
       		}
       	}
    }  	
    if( 0 == tag ){
    	alert("请先选择栏目!");
    	return(false);
    }
    else{
    	return(true);
    }
}
</script>
</head>
<body bgcolor="#FFFFFF" text="#000000">

<form action="main.php?do=rss_article_local_do_transfer" name="form_rss_article_transfer" method="post" onSubmit="return validator()">
<table width="100%" border="1" align="center" cellpadding="20" bordercolor="C1D7F4">
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
          <td><table width="100%"  border="0" cellpadding="10" cellspacing="1" bgcolor="C1D7F4">
            <tr align="center" bgcolor="FFFFFF">
              <td></td>
              <td>栏目列表</td>         
            </tr>
            
            
              <tr bgcolor="#F0F4FF" align="center"> 
                <td></td>
                <td align="left"><?php
echo $_obj['subject_list'];
?>
</td>
              </tr>
            
	
	   <tr bgcolor="#F0F4FF">
	    <td align="center">级别</td>
	    <td align="left">
		<?php
if (!empty($_obj['mark'])){
if (!is_array($_obj['mark']))
$_obj['mark']=array(array('mark'=>$_obj['mark']));
$_tmp_arr_keys=array_keys($_obj['mark']);
if ($_tmp_arr_keys[0]!='0')
$_obj['mark']=array(0=>$_obj['mark']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['mark'] as $rowcnt=>$mark) {
$mark['ROWCNT']=$rowcnt;
$mark['ALTROW']=$rowcnt%2;
$mark['ROWBIT']=$rowcnt%2;
$_obj=&$mark;
?>
		<input name="radio_mark" type="radio" value="<?php
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
	</td>
	  </tr>	
		
			 </table></td>
        </tr>
        <tr colspan="2" align="center"><td><input name="submit" value="提交" type="submit"></td></tr>
      </table></td>
  </tr>
</table>
<input type="hidden" name="id" value=<?php
echo $_obj['id'];
?>
>
<input type="hidden" name="channel_name" value=<?php
echo $_obj['channel_name'];
?>
>
</form>
</body>
</html>

