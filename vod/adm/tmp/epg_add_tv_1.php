<!-- ��ӵ���Ƶ��-1 -->
<script language="javascript">
function check()
{
	
	if(window.document.add.station_name.value=="")
	{
		alert("��������������");
		document.add.station.focus();
		return false;
	}
	if(window.document.add.sdp_file.value=="")
	{
		alert("����������·��");
		document.add.sdp_file.focus();
		return false;
	}
	sdp_file=window.document.add.sdp_file.value;
	sdp_file_ext=sdp_file.substring(sdp_file.lastIndexOf("."));
	if(sdp_file_ext!='.sdp'&&sdp_file_ext!='.SDP')
	{
		alert("��ѡ��Ĳ���SDP�ļ�");
		window.document.add.sdp_file.focus();
		return false;
	}
	return true;
}
</script>
<form action="epg_add_tv_2.php" method=post ENCTYPE="multipart/form-data" name=add onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=1 bgcolor=black>
<caption>��ӵ���̨SDP(<span style="color:red">*</span>Ϊ����)</caption>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>����:</td>
	<td><input type=text name=station_name>(�����ӽ�Ŀ����)</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>ѡ��SDP�ļ�:</td>
	<td><input type=file name=sdp_file>(��׺������.sdp)</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>��������:</td>
	<td><select name=pubtype>
		<option value="0" 
		<?
		$pubtype=2;//Ĭ��ֵ
		if($pubtype==0)
			echo " selected";
		?>
		>Ӳ������</option>
		<option value="1" 
		<?
		if($pubtype==1)
			echo " selected";
		?>
		>�������</option>
		<option value="2" 
		<?
		if($pubtype==2)
			echo " selected";
		?>
		>VLC1��ʽ</option>
		<option value="3" 
		<?
		if($pubtype==3)
			echo " selected";
		?>
		>VLC3��ʽ</option>
		<option value="4" 
		<?
		if($pubtype==4)
			echo " selected";
		?>
		>VLC5��ʽ</option>
		</select>
		</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>֡��:</td>
	<td><input type=text name=fps size=5 value=25></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>�Ƿ���Ҫ����:</td>
	<td><select name=zoom_flag>
	<option value=1>����</option>
	<option value=0>������</option>
	</select>(����Ƶ��СΪ640*480ʱ����Ҫ������,��������Ҫ)</td>
</tr>
<tr bgcolor=white>
	<td align=right>��Ŀ����ַ</td>
	<td><input type=text name=schedule_url size=50>(����Ϊ��)</td>
</tr>
<tr bgcolor=white>
	<td><input type=hidden name=type value=tv><input type=hidden name=force_flag value=1><input type=hidden name=del_flag value=1></td>
	<td><input type=submit value=�ύ�ϴ�></td>
</tr>
</table>
</form>
