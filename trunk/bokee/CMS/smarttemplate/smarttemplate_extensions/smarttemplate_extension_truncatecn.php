<?PHP

	function smarttemplate_extension_truncatecn($str,$strlen=10,$other=true) {
		$j = 0;
	    for( $i=0; $i<$strlen; $i++)
	      if( ord(substr($str,$i,1)) > 0xa0 ) $j++;
	    if( $j%2!=0 ) $strlen++;
	    $rstr=substr($str,0,$strlen);
	    if (strlen($str)>$strlen && $other) {$rstr.='...';}
	    return $rstr;
	}


?>