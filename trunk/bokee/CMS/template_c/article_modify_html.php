<html>
<script language="javascript" type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		theme : "advanced",
		mode : "specific_textareas",
		language : "zh-cn",
		ask : true,
		save_callback : "customSave",
		debug : false
	});

	// Custom insert link callback, extends the link function
	function customInsertLink(href, target) {
		var result = new Array();

		alert("customInsertLink called href: " + href + " target: " + target);

		result['href'] = "http://www.sourceforge.net";
		result['target'] = '_blank';

		return result;
	}

	// Custom insert image callback, extends the image function
	function customInsertImage(src, alt, border, hspace, vspace, width, height, align) {
		var result = new Array();

		var debug = "CustomInsertImage called:\n"
		debug += "src: " + src + "\n";
		debug += "alt: " + alt + "\n";
		debug += "border: " + border + "\n";
		debug += "hspace: " + hspace + "\n";
		debug += "vspace: " + vspace + "\n";
		debug += "width: " + width + "\n";
		debug += "height: " + height + "\n";
		debug += "align: " + align + "\n";
		alert(debug);

		result['src'] = "logo.jpg";
		result['alt'] = "test description";
		result['border'] = "2";
		result['hspace'] = "5";
		result['vspace'] = "5";
		result['width'] = width;
		result['height'] = height;
		result['align'] = "right";

		return result;
	}

	// Custom save callback, gets called when the contents is to be submitted
	function customSave(id, content) {
		id + "=" + content;
	}
</script>
<script language="javascript">

function init_upload()
{
	num = document.getElementById('select_upload').value;
	for(i=1;i<=num;i++)
	{
		document.getElementById('image'+i).style.visibility = 'visible';
		document.getElementById('text_image'+i).style.visibility = 'visible';
		//alert('image'+i);
	}

	num1 = Number(num)+1;
	for(i=num1;i<=6;i++)
	{
		document.getElementById('image'+i).style.visibility = 'hidden';
		document.getElementById('text_image'+i).style.visibility = 'hidden';
	}
}

function coop_media_search()
{
	key = document.getElementById('text_coop_media_s').value;
	options = document.getElementById('select_coop_media').options;
	length = options.length;
	for(i=0;i<length;i++)
	{
		if(options[i].text.indexOf(key)>-1)
		{
			options.selectedIndex  = i;
		}
	}
}

function special_search()
{
	key = document.getElementById('text_special_s').value;
	options = document.getElementById('select_special').options;
	length = options.length;
	for(i=0;i<length;i++)
	{
		if(options[i].text.indexOf(key)>-1)
		{
			options.selectedIndex  = i;
		}
	}
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

var special_subject=new Array(
	<?php
if (!empty($_obj['special_subject'])){
if (!is_array($_obj['special_subject']))
$_obj['special_subject']=array(array('special_subject'=>$_obj['special_subject']));
$_tmp_arr_keys=array_keys($_obj['special_subject']);
if ($_tmp_arr_keys[0]!='0')
$_obj['special_subject']=array(0=>$_obj['special_subject']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['special_subject'] as $rowcnt=>$special_subject) {
$special_subject['ROWCNT']=$rowcnt;
$special_subject['ALTROW']=$rowcnt%2;
$special_subject['ROWBIT']=$rowcnt%2;
$_obj=&$special_subject;
?>
	new Array("<?php
echo $_obj['id'];
?>
","<?php
echo $_obj['name'];
?>
"),
	<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
	<?php
if (!empty($_obj['special_subject_last'])){
if (!is_array($_obj['special_subject_last']))
$_obj['special_subject_last']=array(array('special_subject_last'=>$_obj['special_subject_last']));
$_tmp_arr_keys=array_keys($_obj['special_subject_last']);
if ($_tmp_arr_keys[0]!='0')
$_obj['special_subject_last']=array(0=>$_obj['special_subject_last']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['special_subject_last'] as $rowcnt=>$special_subject_last) {
$special_subject_last['ROWCNT']=$rowcnt;
$special_subject_last['ALTROW']=$rowcnt%2;
$special_subject_last['ROWBIT']=$rowcnt%2;
$_obj=&$special_subject_last;
?>
new Array("<?php
echo $_obj['id'];
?>
","<?php
echo $_obj['name'];
?>
")
	<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
	);

function load_special_subject(code)
{
	special_code = get_number_str(code);
	count=0;
	for(i=0;i<special_subject.length;i++)
    {
        if(special_subject[i][0].toString().substring(0,3) == special_code)
        {
            //selCity.options[count]=new Option(Citys[i][1],Citys[i][0]);
            document.getElementById('select_special_subject').options[count]=new Option(special_subject[i][1],special_subject[i][0]);
            count=count+1;
        }
    }
    document.getElementById('select_special_subject').options[0].selected=true;
    document.getElementById('select_special_subject').length=count;
}

function prepare_special_subject(key)
{
	options = document.getElementById('select_special_subject').options;
	length = options.length;
	for(i=0;i<length;i++)
	{
		if(Number(options[i].value.toString().substring(3,6)) == key)
		{
			options.selectedIndex  = i;
		}
	}
}

function init()
{
	init_upload();
	<?php
echo $_obj['script'];
?>

}
</script>
<style type="text/css">
<!--
table {
	font-size: 14px;
}
input {
	height:20px;
}
.error {
color: red;
}
-->
</style>
<body onLoad="init()">
<form action="main.php?do=article_do_modify" name="article_form" method="post" enctype='multipart/form-data'>
<table width="100%" border="0" cellpadding="2" cellspacing="2" bgcolor="#eeeeee">
  <tr>
    <td nowrap>文章标题</td>
    <td colspan="2"><input name="title" type="text" id="title" size="50" maxlength="50" value="<?php
echo $_obj['title'];
?>
" onkeyup="sNum.innerText=this.value.length"> <div class="error"><?php
echo $_obj['action_error_title'];
?>
</div><input type="hidden" name="id" value="<?php
echo $_obj['id'];
?>
"><input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
"></td>
  </tr>
  <tr>
    <td nowrap>副标题</td>
    <td colspan="2"><input name="sub_title" type="text" id="sub_title" size="50" maxlength="50" value="<?php
echo $_obj['sub_title'];
?>
"></td>
  </tr>
  <tr>
    <td nowrap>作者</td>
    <td colspan="2"><input name="author" type="text" id="author" size="15" maxlength="15" value="<?php
echo $_obj['author'];
?>
"></td>
  </tr>
  <tr>
    <td nowrap>媒体名称</td>
    <td colspan="2">
      <select name="select_coop_media" id="select_coop_media">
        <option value="0">合作媒体</option>
		<?php
if (!empty($_obj['coop_media'])){
if (!is_array($_obj['coop_media']))
$_obj['coop_media']=array(array('coop_media'=>$_obj['coop_media']));
$_tmp_arr_keys=array_keys($_obj['coop_media']);
if ($_tmp_arr_keys[0]!='0')
$_obj['coop_media']=array(0=>$_obj['coop_media']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['coop_media'] as $rowcnt=>$coop_media) {
$coop_media['ROWCNT']=$rowcnt;
$coop_media['ALTROW']=$rowcnt%2;
$coop_media['ROWBIT']=$rowcnt%2;
$_obj=&$coop_media;
?>
	 <option value="<?php
echo $_obj['id'];
?>
_<?php
echo $_obj['name'];
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
      </select>
      <input name="text_coop_media_s" type="text" id="text_coop_media_s" size="10" maxlength="10">
      <input type="button" name="Submit_coop_media_s" value="查找" onClick="coop_media_search()">
      其它媒体 <input name="text_coop_media" type="text" id="text_coop_media" size="20" maxlength="10" value="<?php
echo $_obj['text_coop_media'];
?>
">
      </td>
  </tr>
  <tr>
    <td nowrap>栏目</td>
    <td colspan="2"> <select name="subject_id" id="subject_id"><?php
echo $_obj['subject_options'];
?>

     </select>
    </td>
  </tr>
  <tr>
    <td nowrap>级别</td>
    <td colspan="2">      
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
　　 (1首页焦点，2首页二屏，3首页列表，4一级栏目首页，5二级栏目首页）</td>
  </tr>
  <tr>
    <td nowrap>关键词</td>
    <td colspan="2"><input name="keyword" type="text" id="keyword" size="50" maxlength="25" value="<?php
echo $_obj['keyword'];
?>
">
    (必填!用于选取相关文章)<div class="error"><?php
echo $_obj['action_error_keyword'];
?>
</div></td>
  </tr>
  <tr>
    <td height="182" nowrap>摘要</td>
    <td width="20%"><textarea name="description" cols="73" rows="9" id="description" mce_editable = "true"><?php
echo $_obj['description'];
?>
</textarea>
    <div class="error"><?php
echo $_obj['action_error_description'];
?>
</div></td>
  </tr>
  <tr>
  <td width="69%" valign="top"><p>上传图片：图片数量:
        <select name="select_upload" onChange="init_upload()" id="select_upload">
          <option value="0" selected>无</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
        </select>
</td>
<td>
<input type='file' name='image1' id="image1">
	<input name="text_image1" type="text" id="text_image1" size="15" maxlength="30">
	<br>
	<input type='file' name='image2' id="image2">
	<input name="text_image2" type="text" id="text_image2" size="15" maxlength="30">
    <br>
	<input type='file' name='image3' id="image3">
	<input name="text_image3" type="text" id="text_image3" size="15" maxlength="30">
    <br>
	<input type='file' name='image4' id="image4">
	<input name="text_image4" type="text" id="text_image4" size="15" maxlength="30">
    <br>
	<input type='file' name='image5' id="image5">
	<input name="text_image5" type="text" id="text_image5" size="15" maxlength="30">
    <br>
	<input type='file' name='image6' id="image6">
	<input name="text_image6" type="text" id="text_image6" size="15" maxlength="30">
    <br>
	</p></td>
  </tr>
  <tr>
    <td nowrap>正文</td>
    <td colspan="2"><textarea name="content" cols="73" rows="20" id="content" mce_editable = "true"><?php
echo $_obj['content'];
?>
</textarea>
    <div class="error"><?php
echo $_obj['action_error_content'];
?>
</div></td>
  </tr>
  <tr>
    <td nowrap>专题</td>
    <td colspan="2"><select name="select_special" id="select_special" onChange="load_special_subject(this.value)">
      <option value="0">选择专题</option>
	  <?php
if (!empty($_obj['special'])){
if (!is_array($_obj['special']))
$_obj['special']=array(array('special'=>$_obj['special']));
$_tmp_arr_keys=array_keys($_obj['special']);
if ($_tmp_arr_keys[0]!='0')
$_obj['special']=array(0=>$_obj['special']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['special'] as $rowcnt=>$special) {
$special['ROWCNT']=$rowcnt;
$special['ALTROW']=$rowcnt%2;
$special['ROWBIT']=$rowcnt%2;
$_obj=&$special;
?>
	  <option value="<?php
echo $_obj['id'];
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
      </select>
      <input name="text_special_s" type="text" id="text_special_s" size="10" maxlength="10">
      <input type="button" name="Submit_special_s" value="查找" onClick="special_search()"></td>
  </tr>
  <tr>
    <td nowrap>专题子栏目</td>
    <td colspan="2"><select name="select_special_subject" id="select_special_subject">
      <option value="0" selected>专题子栏目</option>
      </select></td>
  </tr>
  <tr>
    <td nowrap>是否增加留言板</td>
    <td colspan="2">     
	 <?php
if (!empty($_obj['comment'])){
if (!is_array($_obj['comment']))
$_obj['comment']=array(array('comment'=>$_obj['comment']));
$_tmp_arr_keys=array_keys($_obj['comment']);
if ($_tmp_arr_keys[0]!='0')
$_obj['comment']=array(0=>$_obj['comment']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['comment'] as $rowcnt=>$comment) {
$comment['ROWCNT']=$rowcnt;
$comment['ALTROW']=$rowcnt%2;
$comment['ROWBIT']=$rowcnt%2;
$_obj=&$comment;
?>
	 <input name="radio_is_comment" type="radio" value="<?php
echo $_obj['value'];
?>
" <?php
echo $_obj['checked'];
?>
><?php
echo $_obj['name'];
?>

	  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
	</td>
  </tr>
  <tr>
    <td nowrap>是否增加广告</td>
    <td colspan="2">      
	<?php
if (!empty($_obj['ad'])){
if (!is_array($_obj['ad']))
$_obj['ad']=array(array('ad'=>$_obj['ad']));
$_tmp_arr_keys=array_keys($_obj['ad']);
if ($_tmp_arr_keys[0]!='0')
$_obj['ad']=array(0=>$_obj['ad']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['ad'] as $rowcnt=>$ad) {
$ad['ROWCNT']=$rowcnt;
$ad['ALTROW']=$rowcnt%2;
$ad['ROWBIT']=$rowcnt%2;
$_obj=&$ad;
?>
	 <input name="radio_is_ad" type="radio" value="<?php
echo $_obj['value'];
?>
" <?php
echo $_obj['checked'];
?>
><?php
echo $_obj['name'];
?>

	  <?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
	  </td>
  </tr>
  <tr>
    <td nowrap>相关CMS文章</td>
    <td colspan="2">      
	<textarea name="rel_cms_content" cols="73" rows="10" id="content" mce_editable = "true"><?php
echo $_obj['rel_cms_content'];
?>
</textarea>
	  </td>
  </tr>
  <tr>
    <td nowrap>相关博客文章</td>
    <td colspan="2">      
	<textarea name="rel_blog_content" cols="73" rows="10" id="content" mce_editable = "true"><?php
echo $_obj['rel_blog_content'];
?>
</textarea>
	  </td>
  </tr>
  <tr>
    <td nowrap>相关RSS文章</td>
    <td colspan="2">      
	<textarea name="rel_rss_content" cols="73" rows="10" id="content" mce_editable = "true"><?php
echo $_obj['rel_rss_content'];
?>
</textarea>
	  </td>
  </tr>
  <tr>
    <td nowrap>&nbsp;</td>
    <td colspan="2">&nbsp;
    <input name="radio_is_jump" type="hidden" value="<?php
echo $_obj['jump_value'];
?>
">
    </td>
  </tr>

<tr>
    <td nowrap>是否发至组文/组图</td>
    <td colspan="2">
	<input name="radio_is_group" type="radio" value="1" onclick="javascript:document.article_form.select_group_id.disabled=false" <?php
echo $_obj['group_checked'];
?>
>是
	 <input name="radio_is_group" type="radio" value="0" <?php
echo $_obj['group_not_checked'];
?>
 onclick="javascript:document.article_form.select_group_id.disabled=true">否
	　

	</td>
  </tr>
    <tr>
    
    <td nowrap>选择组文/组图</td>
    <td colspan="2">
		<select name="select_group_id" size="1" <?php
echo $_obj['is_group_disabled'];
?>
>
			<option value="0">请选择组文/组图</option>
			<?php
if (!empty($_obj['group_list'])){
if (!is_array($_obj['group_list']))
$_obj['group_list']=array(array('group_list'=>$_obj['group_list']));
$_tmp_arr_keys=array_keys($_obj['group_list']);
if ($_tmp_arr_keys[0]!='0')
$_obj['group_list']=array(0=>$_obj['group_list']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['group_list'] as $rowcnt=>$group_list) {
$group_list['ROWCNT']=$rowcnt;
$group_list['ALTROW']=$rowcnt%2;
$group_list['ROWBIT']=$rowcnt%2;
$_obj=&$group_list;
?>
			<option value="<?php
echo $_obj['id'];
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
		</select>
    
	</td>
  </tr>

  <tr>
    
    <td nowrap>是否设置自动翻页</td>
    <td colspan="2">
		<?php
echo $_obj['html_auto_redirect'];
?>

	</td>
  </tr>

  <tr>
	<td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td nowrap>&nbsp;</td>
    <td colspan="2"><input name="Submit_pub" type="submit" id="Submit_pub" value="修改文章">
      <input name="Submit_reset" type="reset" id="Submit_reset" value="重置"></td>
  </tr>
</table>
<div id=count style="position:absolute;top:25px;left:600;width:100px" align=right><span  id=sNum><?php
echo $_obj['title_num'];
?>
</span>个字</div>
<script>
document.getElementById("count").style.left=document.body.offsetWidth-140
</script>
</form>
</body>
</html>
