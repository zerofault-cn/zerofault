<?
if(!defined("_UTF7")){
   define("_UTF7",1,1);


define ("NUMBYTES",256,1);
define ("CHARSIZE",16,1);

/* character classes */
define ("BASE64",0x01,1);
define ("SAFE",0x02,1);
define ("OPTIONAL",0x04,1);
define ("SPACE",0x08,1);

/* ASCII subsets */

function invert($ori = false)
{
	global $base64;
	global $safe;
	global $optional;
	global $space;
	global $inv_base64;
	global $char_type;
	
	$base64 = Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N",
		"O","P","Q","R","S","T","U","V","W","X","Y","Z",
		"a","b","c","d","e","f","g","h","i","j","k","l","m","n",
		"o","p","q","r","s","t","u","v","w","x","y","z",
		"0","1","2","3","4","5","6","7","8","9","+",","); //, => /
	$safe = Array("'","(",")",",","-",".","/",":","?");
	$optional = Array("!","\"","#","$","%","&","*",";","<","=",
		">","@","[","]","^","_","`","{","|","}");
	$space = Array(" ","\t","\n","\r");
	$inv_base64 = array();
	$char_type = array();

	$i = 0;
	$s = 0;
	
	if ($ori)
		$base64[count($base64)-1] = '/';

	for ($i = 0; $i < NUMBYTES; $i++)
		$char_type[$i] = 0;
	$arrCount = count($base64);
	for ($i = 0; $i < $arrCount; $i++) {
		$s = ord($base64[$i]);
		$char_type[$s] |= BASE64;
		$inv_base64[$s] = $i;
	}
	$arrCount = count($safe);
	for ($i = 0; $i < $arrCount; $i++) {
		$s = ord($safe[$i]);
		$char_type[$s] |= SAFE;
	}
	$arrCount = count($optional);
	for ($i = 0; $i < $arrCount; $i++) {
		$s = ord($optional[$i]);
		$char_type[$s] |= OPTIONAL;
	}
	$arrCount = count($space);
	for ($i = 0; $i < $arrCount; $i++) {
		$s = ord($space[$i]);
		$char_type[$s] |= SPACE;
	}
}

function utf7togb($strutf, $ori = false)
{
	include ('./inc/gb_out.php');
	
	global $inv_base64;
	global $char_type;

	$c = 0;
	$strosi = '';
	$in_base64 = false;
	$bit_buffer = 0;
	$nbits = 0;
	$length = strlen($strutf);
	if ($length <= 0) return '';
	
	invert($ori);
	if ($ori) $prefChar = '+';
	else $prefChar = '&';

	for ($i = 0; $i < $length; $i++) {
		$c = ord(substr($strutf,$i,1));
		if (! $in_base64) {
			if (chr($c) != $prefChar){
				$strosi .= chr($c);
				continue;
			}
			if (($i+1) < $length){
				$i++;
				$c = ord(substr($strutf,$i,1));
			}else 
				continue;
			
			if (chr($c) == '-'){
				$strosi .= $prefChar;
				continue;
			}else {
				$in_base64 = true;
				$nbits = 0;
			}
		}
		/* now we're in Base64 mode */
		while ($char_type[$c]&BASE64) {
			$bit_buffer <<= 6;
			$bit_buffer |= $inv_base64[$c];
			$nbits += 6;
			if ($nbits >= 16) {
				$nbits -= 16;
				$temp = (($bit_buffer >> $nbits) & 0xffff);
				if (($temp) < 0x80)
					$strosi .= chr($temp);
				else {
					$gb = $gb_out[$temp];
					$strosi .= chr(($gb >> 8) & 0xff);
					$strosi .= chr($gb & 0xff);
				}
			}
			if (($i+1) < $length){
				$i++;
				$c = ord(substr($strutf,$i,1));
			} else 
				return $strosi;
		}
		$in_base64 = false;
		if (chr($c) != '-')
			$strosi .= chr($c);
	}

	return $strosi;
}

function gbtoutf7($strosi, $ori = false)
{
	include ('./inc/gb_in.php');
	
	global $base64;
	global $inv_base64;
	global $char_type;

	$c = 0;
	$strutf = '';
	$in_base64 = false;
	$bit_buffer = 0;
	$nbits = 0;
	$length = strlen($strosi);
	if ($length <= 0) return '';

	invert($ori);
	if ($ori) $prefChar = '+';
	else $prefChar = '&';

	for ($i = 0; $i < $length; $i++) {
		$c1 = ord(substr($strosi,$i,1));
		
		if (($c1&0x80) == 0){
		       $c = $c1;
		}
		else{
			if (($i+1) < $length){
				$i++;
				$c2 = ord(substr($strosi,$i,1));
				$c = $gb_in[($c1 - 0xa1)*94 + ($c2&0x7f) - 0x21];
			}else 
				break;
		}

		if ($c <= 0x7f && ($char_type[$c] & (BASE64|SAFE|SPACE))) {
			if ($in_base64) {
				if ($nbits > 0)
					$strutf .= $base64[( $bit_buffer << ( 6 - $nbits)) & 0x3f];
//				if (($char_type[$c] & BASE64) || chr($c) == '-')
				$strutf .= '-';
				$in_base64 = false;
			}
			$strutf .= chr($c);
			if (chr($c) == $prefChar)
				$strutf .= '-';
		}else {
			if (! $in_base64) {
				$strutf .= $prefChar;
				$in_base64 = true;
				$nbits = 0;
			}
			$bit_buffer <<= CHARSIZE;
			$bit_buffer |= $c;
			$nbits += CHARSIZE;
			while ($nbits >= 6) {
				$nbits -= 6;
				$strutf .= $base64[($bit_buffer >> $nbits)&0x3f];
			}
		}
	}
	if ($in_base64){
		if ($nbits > 0)
			$strutf .= $base64[( $bit_buffer << ( 6 - $nbits)) & 0x3f];
		$strutf .= '-';
	}
	return $strutf;
}

function utf7tobig5($strutf, $ori = false)
{
	include ('./inc/big5_out.php');
	
	global $inv_base64;
	global $char_type;

	$c = 0;
	$strosi = '';
	$in_base64 = false;
	$bit_buffer = 0;
	$nbits = 0;
	$length = strlen($strutf);
	if ($length <= 0) return '';
	
	invert($ori);
	if ($ori) $prefChar = '+';
	else $prefChar = '&';

	for ($i = 0; $i < $length; $i++) {
		$c = ord(substr($strutf,$i,1));
		if (! $in_base64) {
			if (chr($c) != $prefChar){
				$strosi .= chr($c);
				continue;
			}
			if (($i+1) < $length){
				$i++;
				$c = ord(substr($strutf,$i,1));
			}else 
				continue;
			
			if (chr($c) == '-'){
				$strosi .= $prefChar;
				continue;
			}else {
				$in_base64 = true;
				$nbits = 0;
			}
		}
		/* now we're in Base64 mode */
		while ($char_type[$c]&BASE64) {
			$bit_buffer <<= 6;
			$bit_buffer |= $inv_base64[$c];
			$nbits += 6;
			if ($nbits >= 16) {
				$nbits -= 16;
				$temp = (($bit_buffer >> $nbits) & 0xffff);
				if (($temp) < 0x80)
					$strosi .= chr($temp);
				else {
					$big5 = $big5_out[$temp];
					$strosi .= chr(($big5 >> 8) & 0xff);
					$strosi .= chr($big5 & 0xff);
				}
			}
			if (($i+1) < $length){
				$i++;
				$c = ord(substr($strutf,$i,1));
			} else 
				return $strosi;
		}
		$in_base64 = false;
		if (chr($c) != '-')
			$strosi .= chr($c);
	}

	return $strosi;
}

function big5toutf7($strosi, $ori = false)
{
	include ('./inc/big5_in.php');
	
	global $base64;
	global $inv_base64;
	global $char_type;

	$c = 0;
	$strutf = '';
	$in_base64 = false;
	$bit_buffer = 0;
	$nbits = 0;
	$length = strlen($strosi);
	if ($length <= 0) return '';

	invert($ori);
	if ($ori) $prefChar = '+';
	else $prefChar = '&';
	
	for ($i = 0; $i < $length; $i++) {
		$c1 = ord(substr($strosi,$i,1));
		
		if (($c1&0x80) == 0){
		       $c = $c1;
		}
		else{
			if (($i+1) < $length){
				$i++;
				$c2 = ord(substr($strosi,$i,1));
				$c2 -= ($c2 >= 0xa1) ? (0xa1 - 63) : 0x40;
				$c = $big5_in[($c1 - 0xa1)*157 + $c2];
			}else 
				break;
		}

		if ($c <= 0x7f && ($char_type[$c] & (BASE64|SAFE|SPACE))) {
			if ($in_base64) {
				if ($nbits > 0)
					$strutf .= $base64[( $bit_buffer << ( 6 - $nbits)) & 0x3f];
//				if (($char_type[$c] & BASE64) || chr($c) == '-')
				$strutf .= '-';
				$in_base64 = false;
			}
			$strutf .= chr($c);
			if (chr($c) == $prefChar)
				$strutf .= '-';
		}else {
			if (! $in_base64) {
				$strutf .= $prefChar;
				$in_base64 = true;
				$nbits = 0;
			}
			$bit_buffer <<= CHARSIZE;
			$bit_buffer |= $c;
			$nbits += CHARSIZE;
			while ($nbits >= 6) {
				$nbits -= 6;
				$strutf .= $base64[($bit_buffer >> $nbits)&0x3f];
			}
		}
	}
	if ($in_base64){
		if ($nbits > 0)
			$strutf .= $base64[( $bit_buffer << ( 6 - $nbits)) & 0x3f];
		$strutf .= '-';
	}
	return $strutf;
}


function utf7_decode($strutf, $charset, $ori = false)
{
	if (strcasecmp($charset, 'gb2312') == 0)
		return utf7togb($strutf, $ori);
	else if (strcasecmp($charset, 'big5') == 0)
		return utf7tobig5($strutf, $ori);
	else
		return $strutf;
}

function utf7_encode($strutf, $charset, $ori = false)
{
	if (strcasecmp($charset, 'gb2312') == 0)
		return gbtouf7($strutf, $ori);
	else if (strcasecmp($charset, 'big5') == 0)
		return big5toutf7($strutf, $ori);
	else
		return $strutf;
}

}
?>