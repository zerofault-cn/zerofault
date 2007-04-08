var url=window.location.href;

if(url.indexOf("localhost")>=0)
{
	document.write("<script language='javascript' src='http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAGIXjiA0k2uINv-bo5flFdBT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQ698TTKEkLwZu9kXehGWWG9vRn1w'></script>");
}
else if(url.indexOf('zerofault.8866.org')>=0)
{
	document.write('<script src="http://maps.google.com/maps?file=api&v=2&key=ABQIAAAAGIXjiA0k2uINv-bo5flFdBRa2nuN09Sdo3rTXtaS3oieFFC-ZhTHAHjMT1wtFJxIMD9KFHaPcNo3bg" type="text/javascript"></script>');
}

