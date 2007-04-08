<?php
function loginCookie($type = 1)
{
	$user_info = isset($_COOKIE['bokie']) ? $_COOKIE['bokie'] : '';
	if($user_info != '')
	{
		$user_d = $user_info;//echo "user_d:".$user_d."<br>";
		$user_code = base64_decode($user_d);	
		$user_a = substr($user_code, 0, -33);//echo "user_a:".$user_a."<br>";
		$user_c = substr($user_code, -32);//echo "user_c:".$user_c."<br>";
		$user_b = 'bokeebsp';
		$test = md5($user_a.",".$user_b);//echo "test:".$test."<br>";
		if($type == 1)
		{	
			if($test == $user_c)
				return 1;
			else 
				return 0;
		}
		else if ($type == 2)
		{
			return $user_a;
		}
	}
	else 
		return 0;
}
?>
