var leftTree_base, leftTree_temp, leftTree_cookieArray, leftTree_cookieCount;
var cookie_name = "lezhuang_leftTree_state";
function initiate(){
	leftTree_cookieCount=0;
	leftTree_cookieArray = new Array();
	if(document.cookie) {
		var tmp_cookieArray=document.cookie.split(";");
		for(i in tmp_cookieArray){
			if ("string"==typeof(tmp_cookieArray[i]) && cookie_name==tmp_cookieArray[i].split("=")[0].replace(/ /g,"")) {
				leftTree_cookieArray = tmp_cookieArray[i].split("=")[1].replace(/ /g,"").split(",");
			}
		}
	}
	leftTree_base=document.getElementById("containerul");
	for(var o=0;o<leftTree_base.getElementsByTagName("li").length;o++){
		if(leftTree_base.getElementsByTagName("li")[o].getElementsByTagName("ul").length>0){
			leftTree_temp= document.createElement("span");
			leftTree_temp.className= "symbols";
			leftTree_temp.style.backgroundImage=(leftTree_cookieArray.length>0)?((leftTree_cookieArray[leftTree_cookieCount]=="true")?"url("+IMAGE_FOLDER+"minus.png)":"url("+IMAGE_FOLDER+"plus.png)"):"url("+IMAGE_FOLDER+"plus.png)";
			leftTree_temp.onclick=function(){
				showhide(this.parentNode);
				writeCookie();
			}
			leftTree_base.getElementsByTagName("li")[o].insertBefore(leftTree_temp,leftTree_base.getElementsByTagName("li")[o].firstChild)
			leftTree_base.getElementsByTagName("li")[o].getElementsByTagName("ul")[0].style.display = "none";
			if(leftTree_cookieArray[leftTree_cookieCount]=="true") {
				showhide(leftTree_base.getElementsByTagName("li")[o]);
			}
			leftTree_cookieCount++;
		}
		else{
			leftTree_temp				= document.createElement("span");
			leftTree_temp.className			= "symbols";
			leftTree_temp.style.backgroundImage	= "url("+IMAGE_FOLDER+"page.png)";
			leftTree_base.getElementsByTagName("li")[o].insertBefore(leftTree_temp,leftTree_base.getElementsByTagName("li")[o].firstChild);
		}
	}
}

function showhide(el){
	el.getElementsByTagName("ul")[0].style.display=(el.getElementsByTagName("ul")[0].style.display=="block")?"none":"block";
	el.getElementsByTagName("span")[0].style.backgroundImage=(el.getElementsByTagName("ul")[0].style.display=="block")?"url("+IMAGE_FOLDER+"minus.png)":"url("+IMAGE_FOLDER+"plus.png)";
}

// Runs through the menu and puts the "states" of each nested list into an array, the array is then joined together and assigned to a cookie.
function writeCookie(){
	leftTree_cookieArray=new Array()
	for(var q=0;q<leftTree_base.getElementsByTagName("li").length;q++){
		if(leftTree_base.getElementsByTagName("li")[q].childNodes.length>0){
			if(leftTree_base.getElementsByTagName("li")[q].childNodes[0].nodeName=="SPAN" && leftTree_base.getElementsByTagName("li")[q].getElementsByTagName("ul").length>0){
				leftTree_cookieArray[leftTree_cookieArray.length]=(leftTree_base.getElementsByTagName("li")[q].getElementsByTagName("ul")[0].style.display=="block");
			}
		}
	}
	document.cookie = cookie_name+"="+leftTree_cookieArray.join(",")+";expires="+new Date(new Date().getTime() + 365*24*60*60*1000).toGMTString()+";path=/";
}
initiate();