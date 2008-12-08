<?php 

// @author Liao Yu Lei <[email]daut@dualface.com[/email]> 
// @version $Id: template.php,v 1.2 2005/07/27 10:17:49 cvs Exp $ 

require_once ('PEAR.php'); 

class Application extends PEAR 
{ 
   // private 
   var $_db = null; 

   // public 
   function Application() { 
      $this->PEAR(); 
      // 设置PEAR的错误处理方式，这样可以减少很多错误判断代码 
      PEAR::setErrorHandling(PEAR_ERROR_DIE); 
   } 
    
   function _Application() { 
      if ($this->_db !== null) { 
         $this->_db->disconnect(); 
      } 
   } 
    
   function getAction() { 
      $action = ($_GET['action']); 
      if (empty($action)) { 
         $action = CFG_DEFAULT_ACTION; 
      } 
      return $action; 
   } 

   function & initTemplate() { 
      require_once(APPROOT . '/smarty/Smarty.class.php'); 
      $tpl = & new Smarty(); 
      $tpl->template_dir  = APPROOT . CFG_TEMPLATE_LIB; 
      $tpl->compile_dir   = APPROOT . CFG_SMARTY_TEMPLATES_C; 
      $tpl->config_dir    = APPROOT . CFG_SMARTY_CONFIGS; 
      $tpl->cache_dir     = APPROOT . CFG_SMARTY_CACHE; 
      $tpl->cache       = true; 
      return $tpl; 
   } 
    
   function & connectDatabase() { 
      require_once(APPROOT . '/pear/DB.php'); 
      $dsn = CFG_DB_TYPE . '://' . CFG_DB_USER . ':' . CFG_DB_PASS . '@' . 
           CFG_DB_HOST . '/' . CFG_DB_NAME; 
      $db = & DB::connect($dsn); 
      if (DB::isError($db)) { 
         die ($db->toString()); 
      } 
      if (!method_exists($db, 'quoteSmart')) { 
         // quoteSmart是PEAR::DB 1.6.0版本以后的新功能，用以替换quote函数 
         // Function available since: PEAR:DB Release 1.6.0 
         $db->disconnect(); 
         die ('PEAR:DB 必须升级到 1.6.0 以上版本'); 
      } 
      // 设置PEAR::DB的默认数据提取模式 
      $db->setFetchMode(DB_FETCHMODE_ASSOC); 
      $this->_db = & $db; 
      return $db; 
   } 
    
   function & getDb() { 
      return $this->_db; 
   } 

   function run() { 
      $action = strtolower($this->getAction()); 
      $page_class_name = ucfirst($action) . 'Page'; 
      $page_class_file = APPROOT . '/includes/class_' . $action . '.php'; 
      @include_once($page_class_file); 
      if (!class_exists($page_class_name)) { 
         die ("需要的 class(${page_class_name}) 没有定义<BR>类定义文件 \"" . 
              $page_class_path . "\" 无法找到"); 
      } 
      $page = & new $page_class_name($this); 
      $page->execute(); 
      exit (); 
   } 
} 
?> 

Applcation类继承于PEAR（为了获得析构函数功能），然后在构造函数中修改了PEAR的默认错误处理方式。getAction()很简单，获得$_GET['action']的值，如果没有设置则使用默认值（我的程序里是Welcome）。initTemplate()初始化模版引擎（我用的是Smarty）。connectDatabase()初始化数据库联接，返回一个PEAR-DB对象的引用（需要一些常量来完成数据库连接，可以在inc_config.php中定义）。getDb()获得已经初始化的PEAR-DB对象。 
Application类的入口就是run()。run()根据获得的action，载入对应的.php文件，并new一个对应class出来，然后执行这个class的execute()方法。 


3、Page类分析 

[code]
<?php 

// @author Liao Yu Lei <[email]daut@dualface.com[/email]> 
// @version $Id: template.php,v 1.2 2005/07/27 10:17:49 cvs Exp $ 

class Page 
{ 
   // private 
   var $_app       = null; 
   var $_action    = null; 
   var $_SES_NAME  = '_SES_POST_DATA_'; 
    
   // public 
   function Page(& $app) { 
      $this->_app    = & $app; 
      $this->_action    = $this->_app->getAction(); 
      session_start(); 
      if (array_key_exists($this->$_SES_NAME, $_SESSION)) { 
         $array = $_SESSION[$this->$_SES_NAME]; 
         unset($_SESSION[$this->$_SES_NAME]); 
         if (count($array) > 0) { 
            $_POST = & array_merge($_POST, $array); 
         } 
      } 
   } 

   function execute() 
   { 
      die ('只能够调用继承类的 execute 方法'); 
   } 

   // protected 
   function _defaultTemplateVariables() { 
      return array(); 
   } 

   function _redisplay() { 
      $this->_redirect('?action=' . $this->_action); 
   } 
    
   function _display($template_file, $title = 'Noname', & $values = array()) { 
      $tpl = $this->_app->initTemplate(); 
      $default_variables = $this->_defaultTemplateVariables(); 
      foreach($default_variables as $key => $value) { 
         $tpl->assign($key, $value); 
      } 
      foreach($values as $key => $value) { 
         $tpl->assign($key, $value); 
      } 
      $tpl->assign('title', $title); 
      $tpl->display($template_file); 
   } 

   function _redirect($url, & $params = array()) { 
      $_SESSION[$this->$_SES_NAME] = & $params; 
      header("Location: $url"); 
   } 
} 
?> 

