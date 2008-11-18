<?php

function utf8wordchop($str, $length=1, $symbol='')
{
    if(strlen($str) < $length)
    {
        return $str;
    }

	for($i=$length-1;$i>=0;$i--) //length
	{
		if(substr($str,$i,1) == "\n" || substr($str,$i,1) == "\r")
		{
			$end = substr($str,0,$i+2);
			return $end.$symbol;
		}else{
			$code = ord(substr($str,$i,1));
			$code2 = ord(substr($str,$i-1,1));
			if($code<=32)
			{
				$end = substr($str,0,$i).$symbol;
				return $end;
				
			}elseif($code2>=192 and $code2<=253){
				$code3 = ord(substr($str,$i,1));
				if($code3 >=128 and $code3 <= 191)
				{
					$end = substr($str,0,$i+2);
					return $end.$symbol;
				}			
			}elseif($i === 0){
				return substr($str, 0, $length).$symbol;
			}
		}
	}
	
}

?>