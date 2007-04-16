/**********************************************************************/
/* 文件名：contribute.js                                              	      */
/* 功能：  博客文章分类投稿操作、检验脚本                             */
/* 版本：  0.1                                                        */
/* 日期：  2006-3-14                                                  */
/* 作者：  朱江敏                                                     */
/* 版权：  北京博客时代信息技术有限公司                               */
/**********************************************************************/
/**********************************************************************/
/* 函数：checkAddForm                                          	      */
/* 参数：                                                             */
/* 功能：检测用户信息的完整性                                         */
/* 返回值：检测结果的有效性                                           */
/**********************************************************************/
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
