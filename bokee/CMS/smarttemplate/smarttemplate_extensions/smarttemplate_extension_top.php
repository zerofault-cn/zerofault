<?php

	/**
	* б
	*
	* @author freeman
	*/
	function smarttemplate_extension_top ($class_id, $num, $c="#FF8724")
	{
		global $main;
		$string = '<table width="95%"  border="0" cellspacing="0" cellpadding="2">';
		$content_list = $main ->getTop($class_id, $num);
		
		$i = 1;
		foreach($content_list as $content){
			if($i %2 == 0){
				$color = "bgcolor=\"$c\"";
			}else{
				$color = '';
			}
			$name = csubstr($content[content_name], 14, false);
			$string .= "<tr $color>"
			          ."<td width=\"19%\">$i</td>"
			          ."<td width=\"81%\"><a href=\"#\" onClick=\"send('$content[content_id]')\"\" title=\"$content[description]\">$name</td>"
			          .'</tr>'
			          .' <tr align="center">    
						    <td height="1" colspan="2" background="/images/line.gif"></td>
						 </tr>
			          '; 
			 $i++;
		}
  		$string .= '</table>';
		return $string;
	}

?>