	
function newFormModel () {
var
	elt;
	
	elt= document.getElementById("x");
	elt.addEventListener("dragstart", drag, false);
}

function newActions () {
	alert("hello");
}

function valideNF (ev) {
var
	n;
var
	elt;

alert(ev.target.id);
	n=ev.target.id.substring(2);
	elt= document.getElementById("nomForm" + n);
	alert(elt.nodeValue);
	if (elt.nodeValue == "") {
		alert("vide");
	} else {
		alert("ok");
	}
	return false;
}

function drag(ev)
{
  var
     x, y;
  var
     s;
  x= ev.clientX - ev.target.offsetLeft;
  y= ev.clientY - ev.target.offsetTop;
  s= ev.target.id + "/" + x + "/" + y;
  ev.dataTransfer.setData("Text", s);
}

function allowDrop(ev)
{
  ev.preventDefault();
}

function drop(ev)
{
	var 
		datas;
	var	decX= 0;
	var decY= 0;
	var	elt;
	var dup;
	var id;
	
  // On empeche l'action par défaut du drop, ouvrir un lien
  ev.preventDefault();
  // On récupère l'information transmise par le drop, ici l'id de l'élément dragger
  datas=ev.dataTransfer.getData("Text");
  datas=datas.split("/");
// On récupère l'élément dragger
  elt= document.getElementById(datas[0]);
  if (elt) {
  	// Elt de la fenetre de depart
// On le duplique
  	dup= elt.cloneNode(true);
// On met un nouvel id à ce nouveau noeud
  	dup.id="new";
  	decX= ev.clientX - datas[1];
  	decY= ev.clientY - datas[2];
  	dup.style.position="absolute";
  	dup.style.top= "" + decY + "px";
  	dup.style.left= "" + decX + "px";
  	dup.setAttribute("draggable", "true");
  	dup.addEventListener("dragstart", drag, false);
	// On l'ajoute
  	ev.target.appendChild(dup);
  } else {
  	// DnD dans la fenetre de construction
  	elt= document.getElementById(datas[0]);
  	decX= ev.clientX - datas[1];
  	decY= ev.clientY - datas[2];
  	elt.style.position="absolute";
  	elt.style.top= "" + decY + "px";
  	elt.style.left= "" + decX + "px";
  }
}

function send () {
var 
	form;
var
	newElt;
	
	newElt= document.createElement("input");
	newElt.setAttribute("type", "hidden");
	newElt.setAttribute("id", "info");
	newElt.nodeValue=document.getElementById("panneau").innerHTML;
	
	form= document.getElementById("send");
	form.appendChild(newElt);
	form.submit();
}

