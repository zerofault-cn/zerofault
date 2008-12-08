<?php

    function textbutton_config( $type = 'default' )
    {
        $config  =  array(
            'small'  =>  array(
	            'width'         => 180,
	            'height'        => 22,
	            'top'           => 16,
	            'left'          => 0,
	            'color'         => "000033",
	            'bgcolor'       => "ffffff",
	            'font-type'     => "verdana.ttf",
	            'font-size'     => 12,
	            'extension'     => 'png',
	        ),
            'big'  =>  array(
                'width'         => 480,
                'height'        => 40,
                'top'           => 32,
                'left'          => 0,
                'color'         => "000066",
                'bgcolor'       => "ffffff",
                'font-type'     => "verdana.ttf",
                'font-size'     => 24,
                'extension'     => 'png',
            ),
            'default'  =>  array(
                'width'         => 200,
                'height'        => 20,
                'top'           => 10,
                'left'          => 0,
                'color'         => "000000",
                'bgcolor'       => "ffffff",
                'font-type'     => 2,
                'extension'     => 'png',
            ),
        );
        if (empty($config[$type]))
        {
        	$type  =  'default';
        }
       	return $config[$type];
	}

?>