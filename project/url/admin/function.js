$(document).ready(function(){  //������Ǵ�˵��ready,ҳ��������ɼ�ִ��
	$("div#addCateForm").hide("fast");//������ӷ���ı�

	$("input#toAddCate").click(function(){//�����Ӱ�ť,���ش˰�ť,��ʾ��ӷ���ı�
		$(this).hide('slow');
		$("div#addCateForm").show("slow");
	});

	$("input#cancel_addCate").click(function(){//���ȡ����ť,������ӷ���ı�,��ʾ��Ӱ�ť
		$("div#addCateForm").hide("slow");
		$("input#toAddCate").show('slow');
	});

	$("input#submit_addCate").click(function(){//����ύ
		submit_addCate(this);
	});

	$("ol.cate_list>li>div").mouseover(function(){//����ڷ�����ʱ�л��б���
		$(this).css("background-color","#B4B9F5");
	}).mouseout(function(){
		$(this).css("background-color","");
	});
	$("ol.site_list>li").mouseover(function(){//�������ַ�б���ʱ�л��б���
		$(this).css("background-color","#CCE7CB");
	}).mouseout(function(){
		$(this).css("background-color","");
	});

	$("ol.site_list").each(function(i){
		hideOverflowSite(this,i);
	});
	$("a.toShowSite").each(function(i){
		showHideAllSite(this,i);
	});

	$(".cate_info>label").each(function(i){//���÷������ƵĿɱ༭����
		setCateNameEditable(this,i);
	});

	$(".cate_info>a.toAddSite").each(function(i){//��������վ,��ʾ�����վ�ı�
		showAddSiteForm(this,i);
	});

	$(".cate_func>label").each(function(i){//���÷�����������ֵĿɱ༭����
		setSortEditable(this,i,'url_category');
	});

	$(".cate_func a.show").each(function(i){//���÷������ʾ�����ع���
		setShowFlagFunc(this,i,'url_category');
	});

	$(".cate_func a.delete").each(function(i){//���÷����ɾ������
		setDeleteFunc(this,i,'url_category');
	});

	$(".site_func>label").each(function(i){//������ַ���������ֵĿɱ༭����
		setSortEditable(this,i,'url_website');
	});
	$(".site_func a.show").each(function(i){//������ַ����ʾ�����ع���
		setShowFlagFunc(this,i,'url_website');
	});
	$(".site_func a.mark").each(function(i){//������ַ��ͻ����ǹ���
		if($(this).attr("value")==0)
		{
			$(this).addClass('red');
		}
		setShowFlagFunc(this,i,'url_website');
	});

	$(".site_func a.delete").each(function(i){//������ַɾ������
		setDeleteFunc(this,i,'url_website');
	});

	$(".site_info>a.toEditSite").each(function(i){
		setSiteEditable(this,i);
	});
});

function submit_addCate() {//�ύ�µķ���
	if(''==$("input#cate_name").val())
	{
		alert('�������Ʋ���Ϊ��');
		$("input#cate_name").focus();
		return false;
	}
	$.post("?action=add",{
		'name': $("input#cate_name").val(),
		'sort': $("input#cate_sort").val(),
		'descr':$("input#cate_descr").val()
	},function(str){
			if(str=='-1')
			{
				alert("����Ŀ�Ѿ���ӹ���!");
			}
			else if(str=='1')
			{
				location.reload();
			//	addsite('.$id.');
			}
			else
			{
				alert(str);
			}
		});
}
function setCateNameEditable(obj,n){//���÷������ƿɱ༭����
	$(obj).mouseover(function(){
		$(this).addClass("editable");
	}).mouseout(function(){
		$(this).removeClass("editable");
	}).click(function(){
		html0=$(this).html();
		html1='<span><input tyle="text" value="'+html0+'" size="'+2*html0.length+'"> <i class="submit">�ύ</i>/<i class="cancel">ȡ��</i></span>';
		$(this).after(html1).hide();
		$(this).next().children("input").select().keydown(function(e){
			var keyCode=e.keyCode ||window.event.keyCode;
			if(keyCode==13)//�س���
			{
				submit_cateName(this,n);
			}
			else if(keyCode==27)//ȡ����
			{
				cancel_cateName(this,n);
			}
		});
		$(this).next().children(".submit").css("cursor","pointer").click(function(){
			submit_cateName(this,n);
		});
		$(this).next().children(".cancel").css("cursor","pointer").click(function(){
			cancel_cateName(this,n);
		});
	});
}
function submit_cateName(obj,n){//�ύ�µķ�������
	$.post("?action=modify",{
		'table'	:'url_category',
		'id'	:$(obj).parent().prev().attr('id'),
		'field'	:'name',
		'value'	:$(obj).parent().children("input").val()
	},function(str){
			if(str==1)
			{
			//	alert('�޸ĳɹ�');
				$(obj).parent().prev().html($(obj).parent().children("input").val()).show();
				$(obj).parent().remove();
			}
			else
			{
				alert(str);
			}
		});
}
function cancel_cateName(obj,n){//ȡ���޸ķ�������
	$(obj).parent().prev().show();
	$(obj).parent().remove();
}

function showAddSiteForm(obj,n){//��ʾ�����վ�ı�
	$(obj).click(function(){
		if($(this).attr('value')=='0')
		{
			$(this).html('ȡ�����');
			$(this).attr('value',1);
			$(this).parent().parent().next().children(".addSiteForm").show("slow");

			$(this).parent().parent().next().children(".addSiteForm").children(".submit").click(function(){
				submit_addSite(this,n);
			});
			$(this).parent().parent().next().children(".addSiteForm").children(".cancel").click(function(){
				cancel_addSite(this,n);
			});
		}
		else
		{
			cancel_addSite(this,n);
		}
	});
}

function submit_addSite(obj,n) {//�ύ�µ���վ
//	alert($(obj).prev().prev().val());
//	return false;
	if(''==$(obj).prev().prev().val())
	{
		alert('��վ���Ʋ���Ϊ��');
		$(obj).prev().prev().focus();
		return false;
	}
	if(''==$(obj).next().next().next().val())
	{
		alert('��ַ����Ϊ��');
		$(obj).next().next().next().focus();
		return false;
	}

	$.post("?action=add",{
		'table'	:'url_website',
		'cate_id':$(obj).parent().attr("id"),
		'name'	:$(obj).prev().prev().val(),
		'url'	:$(obj).next().next().next().val(),
		'sort'	:$(obj).prev().val(),
		'descr'	:$(obj).next().next().next().next().next().val()
	},function(str){
			if(str=='-1')
			{
				alert("����Ŀ�Ѿ���ӹ���!");
			}
			else if(str=='1')
			{
				location.reload();
			//	addsite('.$id.');
			}
			else
			{
				alert(str);
			}
		});
}
function cancel_addSite(obj,n){//ȡ�������վ
	$(obj).html('�����վ');
	$(obj).attr('value',0);
	$(obj).parent().parent().next().children(".addSiteForm").hide("slow");
}
function hideOverflowSite(obj,n){//���س���10������վ
	site_num=$(obj).children("li").size();
	if(site_num>10)
	{
		$(obj).children('li').slice(0,site_num-10).hide();
		$(obj).children('li:eq(0)').before('<div><a href="javascript:void(0)" class="show_hiddenSite">�������������˸�'+(site_num-10)+'������</a></div>');
		$(obj).children("div:eq(1)").click(function(){
			$(this).hide();
			$(obj).children('li').show();
			$(obj).prev().find('a.toShowSite').attr('id',1).html('[��ʾ�������]');
		})
	}
}
function showHideAllSite(obj,n){//������ʾ�����س���10�е�վ���б�Ĺ���
	$(obj).click(function(){
		if($(this).attr('id')==0)
		{
			$(this).attr('id',1);
			$(this).html('[��ʾ�������]');
			$(this).parent().parent().next().children('li').show();
			$(this).parent().parent().next().children('div:eq(1)').hide();
		}
		else if($(this).attr('id')==1)
		{
			$(this).attr('id',0);
			site_num=$(this).parent().parent().next().children('li').size();
			$(this).html('[��ʾȫ��'+site_num+'����վ]');
			$(this).parent().parent().next().children('li').slice(0,site_num-10).hide();
			$(this).parent().parent().next().children('div:eq(1)').show();
		}
	});
}
function setSortEditable(obj,n,table){//���÷����������ֿɱ༭����,����
	$(obj).mouseover(function(){
		$(this).addClass("editable");
	}).mouseout(function(){
		$(this).removeClass("editable");
	}).click(function(){
		html0=$(this).html();
		html1='<span><input tyle="text" value="'+html0+'" size="'+html0.length+'"> <i class="submit">�ύ</i>/<i class="cancel">ȡ��</i></span>';
		$(this).after(html1).hide();
		$(this).next().children("input").select().keydown(function(e){
			var keyCode=e.keyCode ||window.event.keyCode;
			if(keyCode==13)//�س���
			{
				submit_sort(this,n,table);
			}
			else if(keyCode==27)//ȡ����
			{
				cancel_sort(this,n,table);
			}
		});
		$(this).next().children(".submit").css("cursor","pointer").click(function(){
			submit_sort(this,n,table);
		});
		$(this).next().children(".cancel").css("cursor","pointer").click(function(){
			cancel_sort(this,n,table);
		});

	});
}
function submit_sort(obj,n,table){//�ύ�µķ�������,����
//	alert($(obj).parent().prev().attr('id'));
//	return false;
	$.post("?action=modify",{
		'table'	:table,
		'id'	:$(obj).parent().prev().attr('id'),
		'field'	:'sort',
		'value'	:$(obj).parent().children("input").val()
	},function(str){
			if(str==1)
			{
			//	alert('�޸ĳɹ�');
			//	location.reload();
				$(obj).parent().prev().html($(obj).parent().children("input").val()).show();
				$(obj).parent().remove();
			}
			else
			{
				alert(str);
			}
		});
}
function cancel_sort(obj,n){//ȡ�����ķ�������,����
//	alert($(obj).html());
//	return false;
	$(obj).parent().prev().show();
	$(obj).parent().remove();

}
function setShowFlagFunc(obj,n,table){//������ʾ�����ع���,����
	$(obj).click(function(){
		$.post("?action=modify",{
			'table'	:table,
			'id'	:$(obj).attr('id'),
			'field'	:($(obj).attr('class')=='show'?'show_flag':'mark'),
			'value'	:$(obj).attr('value')
		},function(str){
				if(str==1)//��̨����ɹ�
				{
					if($(obj).attr('value')==0)//��ǰ�����������/��ͨ
					{
						$(obj).attr("value",1);
						if($(obj).attr('class')=='show')
						{
							$(obj).html('��ʾ');
							$(obj).parent().parent().parent().addClass('gray');
						}
						else if($(obj).attr('class')=='mark')
						{
							$(obj).html('ͻ��');
							$(obj).parent().removeClass('red');
							$(obj).parent().parent().next().children(":first").removeClass("red");
						}
					}
					else//��ǰ���������ʾ/ͻ��
					{
						$(obj).attr("value",0);
						if($(obj).attr('class')=='show')
						{
							$(obj).html('����');
							$(obj).parent().parent().parent().removeClass('gray');
						}
						else if($(obj).attr('class')=='mark')
						{
							$(obj).html('��ͨ');
							$(obj).parent().addClass('red');
							$(obj).parent().parent().next().children(":first").addClass("red");
						}
					}
				//	location.reload();
				}
				else
				{
					alert(str);
				}
			});
	});
}

function setDeleteFunc(obj,n,table){//����ɾ������,����
	$(obj).click(function(){
		if(confirm('ȷ��ɾ����'))
		{
			$.post("?action=del",{
					table:table,
					id:$(obj).attr('id')
				},function(str){
					if(str==-1)
					{
						alert('�˷����»��м�¼������ɾ����');
					}
					else if(str==1)
					{
						$(obj).parent().parent().parent().remove();
					}
					else
					{
						alert(str);
					}
				});
		}
		else
		{
			return false;
		}
	});
}

function setSiteEditable(obj,n){
	$(obj).click(function(){
		name=$(this).prev().html();
		url=$(this).prev().attr('href');
		descr=$(this).prev().attr('title');
		html='<span>��վ��<input type="text" value="'+name+'" size="10"> <input type="button" value="�ύ" class="submit"> <input type="button" value="ȡ��" class="cancel"><br />��ַ��<input type="text" value="'+url+'" size="20"><br />��飺<input type="text" value="'+descr+'" size="40">';
		$(this).prev().before(html).hide().nextAll().hide();
		$(this).prev().prev().children(".submit").click(function(){
			submit_siteInfo(this,n);
		});
		$(this).prev().prev().children(".cancel").click(function(){
			cancel_siteInfo(this,n);
		});
	});
}
function submit_siteInfo(obj,n){
	var name=$(obj).prev().val();
	var id=$(obj).parent().parent().parent().attr("id");
	var url=$(obj).next().next().next().val();
	var descr=$(obj).next().next().next().next().next().val();
	$.post("?action=add",{
		'table'	:'url_website',
		'name'	:name,
		'site_id':id,
		'url'	:url,
		'descr'	:descr
	},function(str){
			if(str==-1)
			{
				alert('��������ͻ');
			}
			else if(str==1)
			{
				$(obj).parent().next().attr("href",url).attr("title",descr).html($(obj).prev().val()).show().next().show();
				$(obj).parent().remove();
			}
			else
			{
				alert(str);
			}
		});
}
function cancel_siteInfo(obj,n){
	$(obj).parent().next().show().next().show();
	$(obj).parent().remove();
}
function copy(url){
	clipboardData.setData('Text',url);
	alert('�����Ѹ��Ƶ�������');
}
