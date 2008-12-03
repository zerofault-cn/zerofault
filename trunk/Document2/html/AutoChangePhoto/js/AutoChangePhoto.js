
var currslid = 0;
var slidint;
function setfoc(id){
	document.getElementById("focpic").src = picarry[id];
	document.getElementById("foclnk").href = lnkarry[id];
	document.getElementById("fttltxt").innerHTML = '<a href="'+lnkarry[id]+'" target="_blank">'+ttlarry[id]+'</a>';
	currslid = id;
	for(i=0;i<4;i++){
		document.getElementById("tmb"+i).className = "thubpic";
	};
	document.getElementById("tmb"+id).className ="thubpiccur";
	focpic.style.visibility = "hidden";
	focpic.filters[0].Apply();
	if (focpic.style.visibility == "visible") {
		focpic.style.visibility = "hidden";
		focpic.filters.revealTrans.transition=23;
	}
	else {
		focpic.style.visibility = "visible";
		focpic.filters[0].transition=23;
	}
	focpic.filters[0].Play();
	stopit();
}

function playnext(){
	if(currslid==3){
		currslid = 0;
	}
	else{
		currslid++;
	};
	setfoc(currslid);
	playit();
}
function playit(){
	slidint = setTimeout(playnext,4500);
}
function stopit(){
	clearTimeout(slidint);
	}
window.onload = function(){
	playit();
}