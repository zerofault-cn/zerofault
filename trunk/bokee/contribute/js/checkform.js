function checkAddForm()
{
  if(!((document.addForm.article_title.value!="") && (document.addForm.article_title.value!=" ")))
  { 
     alert("请输入文章标题！");
     document.addForm.article_title.focus();
     return false;
   }  
  else if(!((document.addForm.article_link.value!="") && (document.addForm.article_link.value!=" ")))
  {
     alert("请输入文章链接地址！");
     document.addForm.article_link.focus();
     return false;
  }
  else if(!((document.addForm.blog_name.value!="") && (document.addForm.blog_name.value!=" ")))
  {
     alert("请输入博客名称！");
     document.addForm.blog_name.focus();
     return false;
  }
  else if(!((document.addForm.blog_link.value!="") && (document.addForm.blog_link.value!=" ")))
  {
     alert("请输入博客链接地址！");
     document.addForm.blog_link.focus();
     return false;
  }
  else
     return true;

}
