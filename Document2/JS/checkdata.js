//去左空格; 
function ltrim(s){ 
 return s.replace( /^\s*/, ""); 
} 
//去右空格; 
function rtrim(s){ 
 return s.replace( /\s*$/, ""); 
} 
//去左右空格; 
function trim(s){ 
 return rtrim(ltrim(s)); 
} 
//是否为空值; 
function IsEmpty(_str){ 
 var tmp_str = trim(_str); 
 return tmp_str.length == 0; 
} 
//是否有效的Email; 
function IsMail(_str){ 
 var tmp_str = trim(_str); 
 var pattern = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$/; 
 return pattern.test(tmp_str);   
} 
//是否有效的数字; 
function IsNumber(_str){ 
 var tmp_str = trim(_str); 
 var pattern = /^[0-9]/; 
 return pattern.test(tmp_str);   
} 
//是否有效的颜色值; 
function IsColor(color){ 
 var temp=color; 
 if (temp=="") return true; 
 if (temp.length!=7) return false; 
 return (temp.search(/\#[a-fA-F0-9]{6}/) != -1); 
} 
//是否有效的链接; 
function IsURL(url){ 
 var sTemp; 
 var b=true; 
 sTemp=url.substring(0,7); 
 sTemp=sTemp.toUpperCase(); 
 if ((sTemp!="HTTP://")||(url.length<10)){ 
  b=false; 
 } 
 return b; 
} 
//是否有效的手机号码; 
function IsMobile(_str){ 
 var tmp_str = trim(_str); 
 var pattern = /13\d{9}/; 
 return pattern.test(tmp_str);   
}