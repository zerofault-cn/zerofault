<html>
<body bgcolor="#FFFFFF" text="#000000">
<input type="button" onClick="javascript:window.open('main.php?do=flash_pic_add&channel_name=<?php
echo $_obj['channel_name'];
?>
&path=<?php
echo $_obj['path'];
?>
&flash_id=<?php
echo $_obj['flash_id'];
?>
','add_pic','width=400,height=400')" value="添加新图片">
<br><br>
<form action="main.php?do=flash_do_edit" name="subject_form" method="post" enctype='multipart/form-data'>
        <table width="90%" border="0" cellspacing="1" cellpadding="10" bgcolor="#CCCCCC">
<?php
if (!empty($_obj['images'])){
if (!is_array($_obj['images']))
$_obj['images']=array(array('images'=>$_obj['images']));
$_tmp_arr_keys=array_keys($_obj['images']);
if ($_tmp_arr_keys[0]!='0')
$_obj['images']=array(0=>$_obj['images']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['images'] as $rowcnt=>$images) {
$images['ROWCNT']=$rowcnt;
$images['ALTROW']=$rowcnt%2;
$images['ROWBIT']=$rowcnt%2;
$_obj=&$images;
?>
          <tr bgcolor="#FFFFFF"> 
            <td> 
<img src="<?php
echo $_obj['img_src'];
?>
"> 
<br>
<input type="button" onClick="javasript:if(confirm('确定要删除吗?')){location.href='main.php?do=flash_pic_delete&pic_id=<?php
echo $_obj['pic_id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
&path=<?php
echo $_obj['path'];
?>
&flash_id=<?php
echo $_obj['flash_id'];
?>
'}" value="删除此图片">
<br><br>
<input type='file' name='file<?php
echo $_obj['id'];
?>
'>
<input name="name<?php
echo $_obj['id'];
?>
" type="text" size="50" maxlength="100" value="<?php
echo $_obj['name'];
?>
">
<input name="url<?php
echo $_obj['id'];
?>
" type="text" size="50" maxlength="100" value="<?php
echo $_obj['url'];
?>
">
<input type="hidden" name="img_src<?php
echo $_obj['id'];
?>
" value="<?php
echo $_obj['img_src'];
?>
">
            </td>
          </tr>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
        </table>
        <input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
        <input type="hidden" name="id" value="<?php
echo $_obj['id'];
?>
">
        <input type="hidden" name="path" value="<?php
echo $_obj['root_path'];
?>
">
        <input type="hidden" name="num" value="<?php
echo $_obj['num'];
?>
">
        <input name="Submit" type="submit" id="Submit" value="保存">
      </form>
</body>
</html>
