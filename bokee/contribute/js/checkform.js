function checkAddForm()
{
  if(!((document.addForm.article_title.value!="") && (document.addForm.article_title.value!=" ")))
  { 
     alert("���������±��⣡");
     document.addForm.article_title.focus();
     return false;
   }  
  else if(!((document.addForm.article_link.value!="") && (document.addForm.article_link.value!=" ")))
  {
     alert("�������������ӵ�ַ��");
     document.addForm.article_link.focus();
     return false;
  }
  else if(!((document.addForm.blog_name.value!="") && (document.addForm.blog_name.value!=" ")))
  {
     alert("�����벩�����ƣ�");
     document.addForm.blog_name.focus();
     return false;
  }
  else if(!((document.addForm.blog_link.value!="") && (document.addForm.blog_link.value!=" ")))
  {
     alert("�����벩�����ӵ�ַ��");
     document.addForm.blog_link.focus();
     return false;
  }
  else
     return true;

}
