<?php

/**
* Project:     MagpieRSS: a simple RSS integration tool
* File:        rss_parse.inc  - parse an RSS or Atom feed
*               return as a simple object.
*
* Handles RSS 0.9x, RSS 2.0, RSS 1.0, and Atom 0.3
*
* The lastest version of MagpieRSS can be obtained from:
* http://magpierss.sourceforge.net
*
* For questions, help, comments, discussion, etc., please join the
* Magpie mailing list:
* magpierss-general@lists.sourceforge.net
*
* @author           Kellan Elliott-McCrea <kellan@protest.net>
* @version          0.7a
* @license          GPL
*/

define('RSS', 'RSS');
define('ATOM', 'Atom');
define('MAGPIE_DEBUG', false);  // 是否出于调试状态

/**
* 内容解释器: 将一个RSS转换成一个简单的对象
*/
class MagpieRSS {
    
    var $parser;    
    var $current_item   = array();  // item currently being parsed
    var $items          = array();  // collection of parsed items
    var $channel        = array();  // hash of channel fields
    var $textinput      = array();
    var $image          = array();
    var $feed_type;
    var $feed_version;
    var $encoding       = '';       // output encoding of parsed rss
    
    var $_source_encoding = '';     // only set if we have to parse xml prolog
    
    var $ERROR = "";
    var $WARNING = "";
    
    // define some constants    
    var $_CONTENT_CONSTRUCTS = array('content', 'summary', 'info', 
                                     'title', 'tagline', 'copyright');
    var $_KNOWN_ENCODINGS    = array('UTF-8', 'US-ASCII', 'ISO-8859-1');

    // parser variables, useless if you're not a parser, treat as private
    var $stack              = array(); // parser stack
    var $inchannel          = false;
    var $initem             = false;
    var $incontent          = false; // if in Atom <content mode="xml"> field 
    var $intextinput        = false;
    var $inimage            = false;
    var $current_field      = '';
    var $current_namespace  = false;    

    /**
    *  Set up XML parser, parse source, and return populated RSS object..
    *  设置XML解释器, 分析来源, 返回RSS对象
    *  @param string $source 将要被解释的RSS内容 
    *  @param string $output_encoding  输出字符的字符集编码ISO-8859-1
    *  @param string $input_encoding   转换前的字符集
    *  @param bool   $detect_encoding  是否检查来源的字符集
    */
    function MagpieRSS ($source, $output_encoding='ISO-8859-1', 
                        $input_encoding=null, $detect_encoding=true) {
        
        // 如果PHP的XML解释器没有编译，终止执行
        if (!function_exists('xml_parser_create')) {
            $this->error( "Failed to load PHP's XML Extension. " . 
                          "http://www.php.net/manual/en/ref.xml.php",
                           E_USER_ERROR );
        }
        
        $source = trim($source);
        $source = preg_replace("/<![CDATA[[[:space:]]]+/","<![CDATA[",$source);
        $source = preg_replace("/[[:space:]]+]]>/","]]>",$source);
        $source = preg_replace("/>[[:space:]]+/",">",$source);
        
        // 创建解释器
        list($parser, $source) = $this->create_parser($source, 
                $output_encoding, $input_encoding, $detect_encoding);
        if (!is_resource($parser)) {
            $this->error( "Failed to create an instance of PHP's XML parser. " .
                          "http://www.php.net/manual/en/ref.xml.php",
                          E_USER_ERROR );
        }
        $this->parser = $parser;
        
        # pass in parser, and a reference to this object
        # setup handlers
        xml_set_object( $this->parser, $this );
        xml_set_element_handler($this->parser, 
                'feed_start_element', 'feed_end_element' );                        
        xml_set_character_data_handler( $this->parser, 'feed_cdata' ); 
    
        $status = xml_parse( $this->parser, $source );
        
        if (! $status ) {
            $errorcode = xml_get_error_code( $this->parser );
            if ( $errorcode != XML_ERROR_NONE ) {
                $xml_error = xml_error_string( $errorcode );
                $error_line = xml_get_current_line_number($this->parser);
                $error_col = xml_get_current_column_number($this->parser);
                $errormsg = "$xml_error at line $error_line, column $error_col";
                if (DEBUG) $this->error( $errormsg );
            }
        }
        xml_parser_free( $this->parser );
        $this->normalize();
    }
    
    function feed_start_element($p, $element, &$attrs) {
        
        $el = $element = strtolower($element);
        $attrs = array_change_key_case($attrs, CASE_LOWER);
        
        // check for a namespace, and split if found
        $ns = false;
        if ( strpos( $element, ':' ) ) {
            list($ns, $el) = split( ':', $element, 2); 
        }
        if ( $ns and $ns != 'rdf' ) {
            $this->current_namespace = $ns;
        }
            
        # if feed type isn't set, then this is first element of feed
        # identify feed from root element
        if (!isset($this->feed_type) ) {
            if ( $el == 'rdf' ) {
                $this->feed_type = RSS;
                $this->feed_version = '1.0';
            }
            elseif ( $el == 'rss' ) {
                $this->feed_type = RSS;
                $this->feed_version = $attrs['version'];
            }
            elseif ( $el == 'feed' ) {
                $this->feed_type = ATOM;
                $this->feed_version = $attrs['version'];
                $this->inchannel = true;
            }
            return;
        }
    
        if ( $el == 'channel' ) 
        {
            $this->inchannel = true;
        }
        elseif ($el == 'item' or $el == 'entry' ) 
        {
            $this->initem = true;
            if ( isset($attrs['rdf:about']) ) {
                $this->current_item['about'] = $attrs['rdf:about']; 
            }
        }
        
        // if we're in the default namespace of an RSS feed,
        //  record textinput or image fields
        elseif ( 
            $this->feed_type == RSS and 
            $this->current_namespace == '' and 
            $el == 'textinput' ) {
            $this->intextinput = true;
        }
        
        elseif (
            $this->feed_type == RSS and 
            $this->current_namespace == '' and 
            $el == 'image' ) {
            $this->inimage = true;
        }
        
        # handle atom content constructs
        elseif ( $this->feed_type == ATOM and in_array($el, $this->_CONTENT_CONSTRUCTS) ) {
            // avoid clashing w/ RSS mod_content
            if ($el == 'content' ) {
                $el = 'atom_content';
            }
            
            $this->incontent = $el;
        }
        
        // if inside an Atom content construct (e.g. content or summary) 
        // field treat tags as text
        elseif ($this->feed_type == ATOM and $this->incontent ) {
            // if tags are inlined, then flatten
            $attrs_str = join(' ', 
                    array_map('map_attrs', 
                    array_keys($attrs), 
                    array_values($attrs) ) );
            
            $this->append_content( "<$element $attrs_str>"  );
                    
            array_unshift( $this->stack, $el );
        }
        
        // Atom support many links per containging element.
        // Magpie treats link elements of type rel='alternate'
        // as being equivalent to RSS's simple link element.
        //
        elseif ($this->feed_type == ATOM and $el == 'link' ) {
            if ( isset($attrs['rel']) and $attrs['rel'] == 'alternate' ) 
            {
                $link_el = 'link';
            }
            else {
                $link_el = 'link_' . $attrs['rel'];
            }
            
            $this->append($link_el, $attrs['href']);
        }
//        elseif ( $el = 'enclosure'  && $this->initem) {
//            print_r($this->current_item);exit;
//            $this->current_item['enclosure'] = $attrs;
//        }
        // set stack[0] to current element
        else {
            array_unshift($this->stack, $el);
        }
    }
    /**
    * 
    * @access public
    */
    function feed_cdata ($p, $text) {        
        if ($this->feed_type == ATOM and $this->incontent) {
            $this->append_content( $text );
        }
        else {
            $current_el = join('_', array_reverse($this->stack));
            $this->append($current_el, $text);
        }
    }
    /**
    * 
    * @access public
    */
    function feed_end_element ($p, $el) {
        
        $el = strtolower($el);
        
        if ( $el == 'item' or $el == 'entry' ) 
        {
            $this->items[] = $this->current_item;
            $this->current_item = array();
            $this->initem = false;
        }
        elseif ($this->feed_type == RSS and $this->current_namespace == '' and $el == 'textinput' ) 
        {
            $this->intextinput = false;
        }
        elseif ($this->feed_type == RSS and $this->current_namespace == '' and $el == 'image' ) 
        {
            $this->inimage = false;
        }
        elseif ($this->feed_type == ATOM and in_array($el, $this->_CONTENT_CONSTRUCTS) )
        {   
            $this->incontent = false;
        }
        elseif ($el == 'channel' or $el == 'feed' ) 
        {
            $this->inchannel = false;
        }
        elseif ($this->feed_type == ATOM and $this->incontent  ) {
            // balance tags properly
            // note:  i don't think this is actually neccessary
            if ( $this->stack[0] == $el ) 
            {
                $this->append_content("</$el>");
            }
            else {
                $this->append_content("<$el />");
            }

            array_shift( $this->stack );
        }
        else {
            array_shift( $this->stack );
        }
        
        $this->current_namespace = false;
    }
    
    function concat (&$str1, $str2="") {
        if (!isset($str1) ) {
            $str1="";
        }
        $str1 .= $str2;
    }
    
    
    
    function append_content($text) {
        if ( $this->initem ) {
            $this->concat( $this->current_item[ $this->incontent ], $text );
        }
        elseif ( $this->inchannel ) {
            $this->concat( $this->channel[ $this->incontent ], $text );
        }
    }
    
    // smart append - field and namespace aware
    function append($el, $text) {
        if (!$el) {
            return;
        }
        if ( $this->current_namespace ) 
        {
            if ( $this->initem ) {
                $this->concat(
                    $this->current_item[ $this->current_namespace ][ $el ], $text);
            }
            elseif ($this->inchannel) {
                $this->concat(
                    $this->channel[ $this->current_namespace][ $el ], $text );
            }
            elseif ($this->intextinput) {
                $this->concat(
                    $this->textinput[ $this->current_namespace][ $el ], $text );
            }
            elseif ($this->inimage) {
                $this->concat(
                    $this->image[ $this->current_namespace ][ $el ], $text );
            }
        }
        else {
            if ( $this->initem ) {
                $this->concat(
                    $this->current_item[ $el ], $text);
            }
            elseif ($this->intextinput) {
                $this->concat(
                    $this->textinput[ $el ], $text );
            }
            elseif ($this->inimage) {
                $this->concat(
                    $this->image[ $el ], $text );
            }
            elseif ($this->inchannel) {
                $this->concat(
                    $this->channel[ $el ], $text );
            }
            
        }
    }
    
    function normalize () {
        // if atom populate rss fields
        if ( $this->is_atom() ) {
            $this->channel['description'] = $this->channel['tagline'];
            for ( $i = 0; $i < count($this->items); $i++) {
                $item = $this->items[$i];
                if ( isset($item['summary']) )
                    $item['description'] = $item['summary'];
                if ( isset($item['atom_content']))
                    $item['content']['encoded'] = $item['atom_content'];
                
                $atom_date = (isset($item['issued']) ) ? $item['issued'] : $item['modified'];
                if ( $atom_date ) {
                     $epoch = @parse_w3cdtf($atom_date);
                    if ($epoch and $epoch > 0) {
                        $item['date_timestamp'] = $epoch;
                    }
                } else
					$item['date_timestamp'] = time();
                
                $this->items[$i] = $item;
            }       
        }
        elseif ( $this->is_rss() ) {
            $this->channel['tagline'] = $this->channel['description'];
            for ( $i = 0; $i < count($this->items); $i++) {
                $item = $this->items[$i];
                if ( isset($item['description']))
                    $item['summary'] = $item['description'];
                if ( isset($item['content']['encoded'] ) )
                    $item['atom_content'] = $item['content']['encoded'];
                
                if (isset($item['dc']['date']) ) {
                    $epoch = @parse_w3cdtf($item['dc']['date']);
                    if ($epoch and $epoch > 0)
                    {
                        $item['date_timestamp'] = $epoch;
              	    }
                } 
                elseif ( isset($item['pubdate']) ) {
                    	$epoch = @strtotime($item['pubdate']);
                    	if ($epoch > 0) {
                       		$item['date_timestamp'] = $epoch;
                    	}
               	} 
		/* Modified by Jing Xiang
		   get enough of the empty links */

		else if ( (!isset($item['url'])) && (isset($item['guid'])) ) {
			$item['url'] = $item ['guid'];
		}
		/* end of modification */
	
               	$this->items[$i] = $item;
            }
        	
        }
    }
    
    /**
    * 判断是否RSS
    * @access private
    * @return 
    */
    function is_rss () {
        if ( $this->feed_type == RSS ) {
            return $this->feed_version; 
        }
        else {
            return false;
        }
    }
    
    function is_atom() {
        if ( $this->feed_type == ATOM ) {
            return $this->feed_version;
        }
        else {
            return false;
        }
    }

    /**
    * return XML parser, and possibly re-encoded source
    *
    */
    function create_parser($source, $out_enc, $in_enc, $detect) {
        if ( substr(phpversion(),0,1) == 5) {
            $parser = $this->php5_create_parser($in_enc, $detect);
        }
        else {
            list($parser, $source) = $this->php4_create_parser($source, $in_enc, $detect);
        }
        if ($out_enc) {
            $this->encoding = $out_enc;
            xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, $out_enc);
        }
        
        return array($parser, $source);
    }
    
    /**
    * 在PHP5下初始化一个XML解释器
    * @access public
    * @param string $in_enc
    * @param boolean $detect
    */
    function php5_create_parser($in_enc, $detect) {        
        // 缺省情况下，php能自动检查输入内容的字符集编码
        if( !$detect && $in_enc ) {
            return xml_parser_create($in_enc);
        }
        else {
            return xml_parser_create('');
        }
    }
    
    /**
    * 在PHP4环境中初始化一个XML解释器
    * @param string $source 将要被解释的来源
    * @param string $in_enc 来源的原字符集编码
    * @parma boolean 是否检查来源的字符集编码
    * @return array 成功返回一个数组（包含xml解释器和转换字符集编码后的来源字符串）
    */
    function php4_create_parser($source, $in_enc, $detect) {
        
        // 如果不需要检查来源的编码，直接返回
        if ( !$detect ) {
            return array(xml_parser_create($in_enc), $source);
        }
        
        // 如果没有定义来源的编码，则检查来源de编码
        // 如果无法检查到，则使用 UTF-8字符集编码
        if (!$in_enc) {
            if (preg_match('/<?xml.*encoding=[\'"](.*?)[\'"].*?>/m', $source, $m)) {
                $in_enc = strtoupper($m[1]);
                $this->source_encoding = $in_enc;
            }
            else {
                $in_enc = 'UTF-8';
            }
        }
        
        // 如果定义的来源编码已经在解释器明白的字符集编码中，则返回
        if ($this->known_encoding($in_enc)) {
            return array(xml_parser_create($in_enc), $source);
        }
        
        // 如果检查到的 来源编码并非已知，则使用编码转换
        if ( function_exists('iconv') )  {
            $t = explode(' ',$source);
            $encoded_source  = '';
            foreach ($t as $k=>$v){
                $encoded_source .= iconv($in_enc,'UTF-8', $v).' ';
            }
                        
            if ($encoded_source) {
                return array(xml_parser_create('UTF-8'), $encoded_source);
            }
        }
        
        // 如果iconv不能用 ，尝试 mb_convert_encoding
        if( function_exists('mb_convert_encoding') ) {
            $encoded_source = mb_convert_encoding($source, 'UTF-8', $in_enc );
            if ($encoded_source) {
                return array(xml_parser_create('UTF-8'), $encoded_source);
            }
        }
        // 如果没有方法实现编码转换，则触发一个错误
        else { 
            $this->error("Feed is in an unsupported character encoding. ($in_enc) " .
                     "You may see strange artifacts, and mangled characters.",
                     E_USER_NOTICE);
        }
        return array(xml_parser_create(), $source);
    }
    /**
    * 判断解释器是否认识输入的字符集编码
    * @access public
    * @param string $enc 字符集编码
    * @return string|false 成功返回原来输入的字符集编码字符串，失败返回false
    */
    function known_encoding($enc) {
        $enc = strtoupper($enc);
        if ( in_array($enc, $this->_KNOWN_ENCODINGS) ) {
            return $enc;
        }
        else {
            return false;
        }
    }
    /**
    * 错误处理
    * 用于处理分析过程中产生的错误
    * @access public
    * @param string $errormsg 错误信息
    * @parma integer $lvl 错误级别
    */
    function error ($errormsg, $lvl=E_USER_WARNING) {
        
        // 如果track_errors的功能打开， 追加一个错误信息
        if ( isset($php_errormsg) ) { 
            $errormsg .= " ($php_errormsg)";
        }
        
        // 如果调试功能打开，则触发一个错误
        if ( MAGPIE_DEBUG ) {
            trigger_error( $errormsg, $lvl);
        }
        // 否则，发送一个错误信息给PHP的日志记录
        else {            
            error_log( $errormsg, 0);
        }
        
        $notices = E_USER_NOTICE|E_NOTICE;        
        if ( $lvl&$notices ) {
            $this->WARNING = $errormsg;
        } else {
            $this->ERROR = $errormsg;
        }
    }
} // end class RSS

function map_attrs($k, $v) {
    return "$k=\"$v\"";
}
/*======================================================================*\
    Function: parse_w3cdtf
    Purpose:  parse a W3CDTF date into unix epoch

	NOTE: http://www.w3.org/TR/NOTE-datetime
\*======================================================================*/

function parse_w3cdtf ( $date_str ) {
	
	# regex to match wc3dtf
	$pat = "/(\d{4})-(\d{2})-(\d{2})(?:T(\d{2}):(\d{2})(:(\d{2}))?(?:([-+])(\d{2}):?(\d{2})|(Z))?)?/";
	if ( preg_match( $pat, $date_str, $match ) ) {
		list( $year, $month, $day, $hours, $minutes, $seconds) = 
			array( $match[1], $match[2], $match[3], $match[4], $match[5], $match[6]);
		# calc epoch for current date assuming GMT
		$epoch = gmmktime( $hours, $minutes, $seconds, $month, $day, $year);
		
		$offset = 0;
		if ( $match[10] == 'Z' ) {
			# zulu time, aka GMT
		}
		else {
			list( $tz_mod, $tz_hour, $tz_min ) =
				array( $match[8], $match[9], $match[10]);
			
			# zero out the variables
			if ( ! $tz_hour ) { $tz_hour = 0; }
			if ( ! $tz_min ) { $tz_min = 0; }
		
			$offset_secs = (($tz_hour*60)+$tz_min)*60;
			
			# is timezone ahead of GMT?  then subtract offset
			#
			if ( $tz_mod == '+' ) {
				$offset_secs = $offset_secs * -1;
			}
			
			$offset = $offset_secs;	
		}
		$epoch = $epoch + $offset;
		return $epoch;
	}
	else {
		return -1;
	}
}

// ------------------------ test ------------------ //
//$xmlstr = file_get_contents('http://jjgod.3322.org/feed/');
//$rss = new MagpieRSS($xmlstr,'UTF-8',null,ture);
//print_r($rss);
?>
