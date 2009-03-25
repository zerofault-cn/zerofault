<?php
function smarty_function_MyCascade($params, &$smarty)
{
	while ( list($key, $value) = each($params) ) 
	{
		if(trim($value)!='')
		{
			$$key = $value ;
		}
	}


//$CascadeLayer = 'CL' . $SelName[0] ;

	for($i=0;$i<count($Mother[Value]);$i++)
	{
		$script .= $CascadeLayer . '.forValue("'.$Mother[Value][$i].'").addOptionsTextValue(';
		for($j=0;$j<count($Child[$i][Value]);$j++)
		{
			$script .= '"'.$Child[$i][Data][$j].'","' .$Child[$i][Value][$j]. '"';
			if($j < (count($Child[$i][Value])-1))
			{
				$script .= ','	;
			}
		}
		$script .= ");\n";

	}

	//reset ($Mother);
	//reset ($Child);
	$start1 = $Init[0];
	$start2 = $Init[1];

	for($i=0;$i<count($Mother[Value]);$i++)
	{
		$childoption .= '<option value="' .$Mother[Value][$i]. '" ';
		if($Init[0]==$Mother[Value][$i])
		{
			$childoption .= ' selected ';
		}

		$childoption .= '>'.$Mother[Data][$i]. '</option>' ."\n";

	}

	$L1 = $SelName[0];
	$L2 = $SelName[1];



	if(isset($start2)&&trim($start2)!='')
	{
		$other .= $CascadeLayer . '.forField("'.$L2.'").setValues('.$start2.');';
	}

// <script src="Include/javascript/DynamicOptionList.js"></script>


echo <<<end
<script>
var $CascadeLayer = new DynamicOptionList("$L1","$L2");
$script
$other
</script>
<select name="$L1" >
$childoption
</select>

<select name="$L2"><script>$CascadeLayer.printOptions("$L2")</script></select>
<script>initDynamicOptionLists();</script>
end;

}

?>