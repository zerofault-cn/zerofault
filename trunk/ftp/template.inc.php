<?php
/*
 * Session Management for PHP3
 *
 * (C) Copyright 1999-2000 NetUSE GmbH
 *                    Kristian Koehntopp
 *
 * $Id: template.inc,v 1.5 2000/07/12 18:22:35 kk Exp $
 *
 */ 

class Template {
  var $classname = "Template";

  /* If set, Echo assignments */
  var $debug     = false;

  /* $file[handle] = "filename"; */
  var $file  = array();

  /* relative filenames are relative to this pathname */
  var $root   = "";

  /* $varkeys[key] = "key"; $varvals[key] = "value"; */
  var $varkeys = array();
  var $varvals = array();

  /* "remove"  => remove undefined variables
   * "comment" => replace undefined variables with comments
   * "keep"    => keep undefined variables
   */
  var $unknowns = "remove";
  
  /* "Yes" => halt, "report" => report error, Continue, "no" => ignore error quietly */
  var $halt_on_error  = "Yes";
  
  /* last error message is retained here */
  var $Last_error     = "";


  /***************************************************************************/
  /* public: Constructor.
   * root:     template directory.
   * unknowns: how to handle unknown variables.
   */
  Function Template($root = ".", $unknowns = "remove") {
    $this->set_root($root);
    $this->set_unknowns($unknowns);
  }

  /* public: setroot(pathname $root)
   * root:   new template directory.
   */  
  Function set_root($root) {
    If (!is_dir($root)) {
      $this->halt("set_root: $root is not a directory.");
      Return false;
    }
    
    $this->root = $root;
    Return true;
  }

  /* public: set_unknowns(enum $unknowns)
   * unknowns: "remove", "comment", "keep"
   *
   */
  Function set_unknowns($unknowns = "keep") {
    $this->unknowns = $unknowns;
  }

  /* public: set_file(array $filelist)
   * filelist: array of handle, filename pairs.
   *
   * public: set_file(string $handle, string $filename)
   * handle: handle for a filename,
   * filename: name of template file
   */
  Function set_file($handle, $filename = "") {
    If (!is_array($handle)) {
      If ($filename == "") {
        $this->halt("set_file: For handle $handle filename is empty.");
        Return false;
      }
      $this->file[$handle] = $this->filename($filename);
    } else {
      reset($handle);
      while(list($h, $f) = each($handle)) {
        $this->file[$h] = $this->filename($f);
      }
    }
  }

  /* public: set_block(string $parent, string $handle, string $name = "")
   * extract the template $handle from $parent, 
   * place variable {$name} instead.
   */
  Function set_block($parent, $handle, $name = "") {
    If (!$this->loadfile($parent)) {
      $this->halt("subst: unable to load $parent.");
      Return false;
    }
    If ($name == "")
      $name = $handle;

    $str = $this->get_var($parent);
    $reg = "/<!--\s+BEGIN $handle\s+-->(.*)\n\s*<!--\s+END $handle\s+-->/sm";
    preg_match_all($reg, $str, $m);
    $str = Preg_Replace($reg, "{" . "$name}", $str);
    $this->Set_Var($handle, $m[1][0]);
    $this->Set_Var($parent, $str);
  }
  
  /* public: Set_Var(array $values)
   * values: array of variable name, value pairs.
   *
   * public: Set_Var(string $varname, string $value)
   * varname: name of a variable that is to be defined
   * value:   value of that variable
   */
  Function Set_Var($varname, $value = "") {
    If (!is_array($varname)) {
      If (!empty($varname))
        If ($this->debug) print "scalar: set *$varname* to *$value*<br>\n";
        $this->varkeys[$varname] = "/".$this->varname($varname)."/";
        $this->varvals[$varname] = $value;
    } else {
      reset($varname);
      while(list($k, $v) = each($varname)) {
        If (!empty($k))
          If ($this->debug) print "array: set *$k* to *$v*<br>\n";
          $this->varkeys[$k] = "/".$this->varname($k)."/";
          $this->varvals[$k] = $v;
      }
    }
  }

  /* public: subst(string $handle)
   * handle: handle of template where variables are to be substituted.
   */
  Function subst($handle) {
    If (!$this->loadfile($handle)) {
      $this->halt("subst: unable to load $handle.");
      Return false;
    }

    $str = $this->get_var($handle);
    $str = @Preg_Replace($this->varkeys, $this->varvals, $str);
    Return $str;
  }
  
  /* public: psubst(string $handle)
   * handle: handle of template where variables are to be substituted.
   */
  Function psubst($handle) {
    print $this->subst($handle);
    
    Return false;
  }

  /* public: Parse(string $target, string $handle, boolean append)
   * public: Parse(string $target, array  $handle, boolean append)
   * target: handle of variable to generate
   * handle: handle of template to substitute
   * append: append to target handle
   */
  Function Parse($target, $handle, $append = false) {
    If (!is_array($handle)) {
      $str = $this->subst($handle);
      If ($append) {
        $this->Set_Var($target, $this->get_var($target) . $str);
      } else {
        $this->Set_Var($target, $str);
      }
    } else {
      reset($handle);
      while(list($i, $h) = each($handle)) {
        $str = $this->subst($h);
        $this->Set_Var($target, $str);
      }
    }
    
    Return $str;
  }
  
  Function pParse($target, $handle, $append = false) {
    print $this->Parse($target, $handle, $append);
    Return false;
  }
  
  /* public: get_vars()
   */
  Function get_vars() {
    reset($this->varkeys);
    while(list($k, $v) = each($this->varkeys)) {
      $result[$k] = $this->varvals[$k];
    }
    
    Return $result;
  }
  
  /* public: get_var(string varname)
   * varname: name of variable.
   *
   * public: get_var(array varname)
   * varname: array of variable names
   */
  Function get_var($varname) {
    If (!is_array($varname)) {
      Return $this->varvals[$varname];
    } else {
      reset($varname);
      while(list($k, $v) = each($varname)) {
        $result[$k] = $this->varvals[$k];
      }
      
      Return $result;
    }
  }
  
  /* public: get_undefined($handle)
   * handle: handle of a template.
   */
  Function get_undefined($handle) {
    If (!$this->loadfile($handle)) {
      $this->halt("get_undefined: unable to load $handle.");
      Return false;
    }
    
    preg_match_all("/\{([^}]+)\}/", $this->get_var($handle), $m);
    $m = $m[1];
    If (!is_array($m))
      Return false;

    reset($m);
    while(list($k, $v) = each($m)) {
      If (!isset($this->varkeys[$v]))
        $result[$v] = $v;
    }
    
    If (count($result))
      Return $result;
    else
      Return false;
  }

  /* public: finish(string $str)
   * str: string to finish.
   */
  Function finish($str) {
    switch ($this->unknowns) {
      case "keep":
      break;
      
      case "remove":
        $str = Preg_Replace('/{[^ \t\r\n}]+}/', "", $str);
      break;

      case "comment":
        $str = Preg_Replace('/{([^ \t\r\n}]+)}/', "<!-- Template $handle: Variable \\1 undefined -->", $str);
      break;
    }
    
    Return $str;
  }

  /* public: p(string $varname)
   * varname: name of variable to print.
   */
  Function p($varname) {
    print $this->finish($this->get_var($varname));
  }

  Function get($varname) {
    Return $this->finish($this->get_var($varname));
  }
    
  /***************************************************************************/
  /* private: filename($filename)
   * filename: name to be completed.
   */
  Function filename($filename) {
    If (substr($filename, 0, 1) != "/") {
      $filename = $this->root."/".$filename;
    }
    
    If (!file_exists($filename))
      $this->halt("filename: file $filename does not exist.");

    Return $filename;
  }
  
  /* private: varname($varname)
   * varname: name of a replacement variable to be protected.
   */
  Function varname($varname) {
    Return preg_quote("{".$varname."}");
  }

  /* private: loadfile(string $handle)
   * handle:  load file defined by handle, If it is not loaded yet.
   */
  Function loadfile($handle) {
    If (isset($this->varkeys[$handle]) and !empty($this->varvals[$handle]))
      Return true;

    If (!isset($this->file[$handle])) {
      $this->halt("loadfile: $handle is not a valid handle.");
      Return false;
    }
    $filename = $this->file[$handle];

    $str = implode("", @file($filename));
    If (empty($str)) {
      $this->halt("loadfile: While loading $handle, $filename does not exist or is empty.");
      Return false;
    }

    $this->Set_Var($handle, $str);
    
    Return true;
  }

  /***************************************************************************/
  /* public: halt(string $msg)
   * msg:    error message to show.
   */
  Function halt($msg) {
    $this->last_error = $msg;
    
    If ($this->halt_on_error != "no")
      $this->haltmsg($msg);
    
    If ($this->halt_on_error == "Yes")
      die("<b>Halted.</b>");
    
    Return false;
  }
  
  /* public, override: haltmsg($msg)
   * msg: error message to show.
   */
  Function haltmsg($msg) {
    printf("<b>Template Error:</b> %s<br>\n", $msg);
  }
}
?>
