<?php
require_once(PATH_Include .'paginator.php'); 

class Paginator_html extends Paginator { 
	//outputs a link set like this 1 of 4 of 25 First | Prev | Next | Last |              
	function firstLast() {
		
		if (eregi("\?", $this->getPageName())) { $this->pagename = $this->getPageName()."&"; }
		else { $this->pagename = $this->getPageName()."?"; }
	
		if($this->getCurrent()==1) { $first = "first | "; }
		else{ $first="<a href=\"" .  $this->pagename . "page=" . $this->getFirst() . "\">first</a> |"; }  
		
		if($this->getPrevious()) { $prev = "<a href=\"" .  $this->pagename . "page=" . $this->getPrevious() . "\">prev</a> | "; }
		else{ $prev="prev | "; }
		
		if($this->getNext()) { $next = "<a href=\"" . $this->pagename . "page=" . $this->getNext() . "\">next</a> | "; }
		else{ $next="next | ";  }
		
		if($this->getLast()) { $last = "<a href=\"" . $this->pagename . "page=" . $this->getLast() . "\">last</a>"; }
		else{ $last="last"; }
		//echo $this->getFirstOf() . " of " .$this->getSecondOf() . " of " . $this->getTotalItems() . " ";
		return $first . " " . $prev . " " . $next . " " . $last;
	} 

	//outputs a link set like this Previous 1 2 3 4 5 6 Next   
	function previousNext() {
		$Page_Str='';
		
		if (eregi("\?", $this->getPageName())) { $this->pagename = $this->getPageName()."&"; }
		else { $this->pagename = $this->getPageName()."?"; }
	
		if($this->getPrevious()) { $Page_Str.="<a href=\"" . $this->pagename . "page=" . $this->getPrevious() . "\">prev</a> "; }
		$links = $this->getLinkArr();
		foreach($links as $link) { 
			if($link == $this->getCurrent()) { $Page_Str.=" [ $link ] "; }
			else { $Page_Str.="<a href=\"" . $this->pagename . "page=$link\">[ " . $link . " ]</a> "; }
		}
	
		if($this->getNext()) { $Page_Str.="<a href=\"" . $this->pagename . "page=" . $this->getNext() . "\">next</a> "; }
		
		return $Page_Str;
	}

	function fourtypes() {
		$Page_Str='';
		
		if (eregi("\?", $this->getPageName())) { $this->pagename = $this->getPageName()."&"; }
		else { $this->pagename = $this->getPageName()."?"; }
	
		$Page_Str.="<table border=0 cellspacing=0 cellpadding=0><tr>";
		if($this->getCurrent()==1) { $Page_Str.="<td width=15><div align=center><img src=\"./images/arrow1.gif\"></div></td><td width=15><div align=center><img src=\"./images/arrow3.gif\"></div></td>"; }
		else { $Page_Str.="<td width=15><div align=center><a href=\"" .  $this->pagename . "page=" . $this->getFirst() . "\"><img src=./images/arrow1.gif border=0></a></div></td>"; }
		
		if($this->getPrevious()) { $Page_Str.="<td width=15><div align=center><a href=\"" . $this->pagename . "page=" . $this->getPrevious() . "\"><img src=\"./images/arrow3.gif\" border=0></a></div></td>"; }
		
		$links = $this->getLinkArr();
		$Page_Str.="<td><div align=center>";
		foreach($links as $link) {
			if($link == $this->getCurrent()) { $Page_Str.="<font color=0000FF>$link</font> "; }
			else { $Page_Str.="<a href=\"" . $this->pagename . "page=$link\">" . $link . "</a> "; }
		}
		$Page_Str.="</div></td>";
	
		if($this->getNext()) { $Page_Str.="<td width=15><div align=center><a href=" . $this->pagename . "page=" . $this->getNext() . "><img src=\"./images/arrow4.gif\" border=0></a></div></td>"; }
		
		if($this->getLast()) { $Page_Str.="<td width=15><div align=center><a href=\"" . $this->pagename . "page=" . $this->getLast() . "\"><img src=\"./images/arrow2.gif\" border=0></a></div></td>"; }
		else { $Page_Str.="<td width=15><div align=center><img src=\"./images/arrow4.gif\"></div></td><td width=15><div align=center><img src=\"./images/arrow2.gif\"></div></td>"; }
		$Page_Str.="</tr></table>";
		
		return $Page_Str;
	}
	
	function todotypes() {
		$Page_Str='';
		
		if (eregi("\?", $this->getPageName())) { $this->pagename = $this->getPageName()."&"; }
		else { $this->pagename = $this->getPageName()."?"; }
		
		$Page_Str.="<span id=\"page_link_t\">\n";
		
		if($this->getCurrent()>1) { $Page_Str.="<a href=\"" . $this->pagename . "page=" . $this->getFirst() . "\" title=\"First Page\"><<</a> "; }
		if($this->getPrevious()) { $Page_Str.="<a href=\"" . $this->pagename . "page=" . $this->getPrevious() . "\" title=\"Previous Page\"><</a> "; }
		
		$links = $this->getLinkArr();
		$i=0;
		
		foreach($links as $link) {
			if($i!=0) { $Page_Str.=", "; }
			if($link == $this->getCurrent()) { $Page_Str.="<label id=\"current\">$link</label>"; }
			else { $Page_Str.="<a href=\"" . $this->pagename . "page=$link\">" . $link . "</a>"; }
			$i++;
		}
	
		if($this->getNext()) { $Page_Str.=" <a href=\"" . $this->pagename . "page=" . $this->getNext() . "\" title=\"Next Page\">></a>"; }
		if($this->getLast()) { $Page_Str.=" <a href=\"" . $this->pagename . "page=" . $this->getLast() . "\" title=\"Last Page\">>></a>"; }
		
		$Page_Str.="</span>";
		
		return $Page_Str;
	}
	
	function gamingtypes() {
		global $NG_First_Page, $NG_Previous_Page, $NG_Next_Page, $NG_Last_Page;
		$Page_Str='';
		
		if (eregi("\?", $this->getPageName())) { $this->pagename = $this->getPageName()."&"; }
		else { $this->pagename = $this->getPageName()."?"; }
		
		$Page_Str.="<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" id=\"page_link_t\">\n<tr>";
		
		if($this->getCurrent()>1) { $Page_Str.="<td><a href=\"" . $this->pagename . "page=" . $this->getFirst() . "\" title=\"".$NG_First_Page."\"><img src=\"./images/page_first.png\" border=\"0\"></a>&nbsp;</td>"; }
		else { $Page_Str.="<td><img src=\"./images/page_first_u.png\" border=\"0\">&nbsp;</td>"; }
		if($this->getPrevious()) { $Page_Str.="<td><a href=\"" . $this->pagename . "page=" . $this->getPrevious() . "\" title=\"".$NG_Previous_Page."\"><img src=\"./images/page_prev.png\" border=\"0\"></a>&nbsp;</td>"; }
		else { $Page_Str.="<td><img src=\"./images/page_prev_u.png\" border=\"0\">&nbsp;</td>"; }
		
		if($Page_Str!='') { $Page_Str.="<td>&nbsp;</td>"; }
		
		$links = $this->getLinkArr();
		$i=0;
		foreach($links as $link) {
			$Page_Str.="<td>";
			if($i!=0) { $Page_Str.=", "; }
			if($link == $this->getCurrent()) { $Page_Str.="<label id=\"current\">$link</label>"; }
			else { $Page_Str.="<a href=\"" . $this->pagename . "page=$link\">" . $link . "</a>"; }
			$Page_Str.="&nbsp;</td>";
			$i++;
		}
		
		if($Page_Str!='') { $Page_Str.="<td>&nbsp;</td>"; }
	
		if($this->getNext()) { $Page_Str.="<td><a href=\"" . $this->pagename . "page=" . $this->getNext() . "\" title=\"".$NG_Next_Page."\"><img src=\"./images/page_next.png\" border=\"0\"></a>&nbsp;</td>"; }
		else { $Page_Str.="<td><img src=\"./images/page_next_u.png\" border=\"0\">&nbsp;</td>"; }
		if($this->getLast()) { $Page_Str.="<td><a href=\"" . $this->pagename . "page=" . $this->getLast() . "\" title=\"".$NG_Last_Page."\"><img src=\"./images/page_last.png\" border=\"0\"></a>&nbsp;</td>"; }
		else { $Page_Str.="<td><img src=\"./images/page_last_u.png\" border=\"0\">&nbsp;</td>"; }
		
		$Page_Str.="</tr></table>\n";
		
		return $Page_Str;
	}
	
	function pageListStype() {
		$Page_Str='';
		
		if (eregi("\?", $this->getPageName())) { $this->pagename = $this->getPageName()."&"; }
		else { $this->pagename = $this->getPageName()."?"; }
	
		$Page_Str.="<table border=0 cellspacing=0 cellpadding=0><tr>";
		if($this->getCurrent()>1) { $Page_Str.="<td width=15><a href=\"" . $this->pagename . "page=" . $this->getFirst() . "\">First</a></td>"; }
		
		if($this->getPrevious()) { $Page_Str.="<td width=15><a href=\"" . $this->pagename . "page=" . $this->getPrevious() . "\">Prev</a></td>"; }
		
		$links = $this->getLinkArr();
		$Page_Str.="<td>";
		foreach($links as $link) {
			if($link == $this->getCurrent()) { $Page_Str.="<font color=0000FF>$link</font> "; }
			else { $Page_Str.="<a href=\"" . $this->pagename . "page=$link\">" . $link . "</a> "; }
		}
		$Page_Str.="</td>";
	
		if($this->getNext()) { $Page_Str.="<td width=15><a href=" . $this->pagename . "page=" . $this->getNext() . ">Next</a></td>"; }
		
		if($this->getLast()) { $Page_Str.="<td width=15><a href=\"" . $this->pagename . "page=" . $this->getLast() . "\">Last</a></td>"; }
		$Page_Str.="</tr></table>";
		
		return $Page_Str;
	}
}//ends class
?>