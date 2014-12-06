var inputList = [];
var ids = 0;
var
	elt;
	
	//elt= document.getElementById("x");
	//elt.addEventListener("dragstart", drag, false);
	elt = document.getElementsByClassName("draggable");
	for (i = 0; i < elt.length; i++) {
      elt[i].addEventListener("dragstart", drag, false);
   }

function newActions () {
	alert("hello");
}

function valideNF (ev) {
   var n;
   var elt;

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
   var datas;
   var decX= 0;
   var decY= 0;
   var elt;
   var dup;
   var id;

   // On empeche l'action par défaut du drop, ouvrir un lien
   ev.preventDefault();
   // On récupère l'information transmise par le drop, ici l'id de l'élément dragger
   datas = ev.dataTransfer.getData("Text");
   //document.write("datas " + datas + "<br>");
   datas = datas.split("/");
   //document.write("data split " + datas + "<br>");
   // On récupère l'élément dragger
   elt= document.getElementById(datas[0]);
   //document.write("data[0] " + datas[0] + "<br>");
   if (datas[0]<=elt) {
      // DnD dans la fenetre de construction
      elt = document.getElementById(datas[0]);
      //decX = ev.clientX - datas[1];
      //decY = ev.clientY - datas[2];
      decX = ev.clientX - datas[1];
      decY = ev.clientY - datas[2];
      elt.style.position="absolute";
      elt.style.top= "" + decY + "px";
      elt.style.left= "" + decX + "px";
      inputList[elt.getAttribute("name")] = elt.innerHTML;
   } else {
      // Elt de la fenetre de depart
      // On le duplique
      dup = elt.cloneNode(true);
      // On met un nouvel id à ce nouveau noeud
      dup.id = ids;
      decX = ev.clientX - datas[1];
      decY = ev.clientY - datas[2];
      dup.style.position = "absolute";
      dup.style.top = "" + decY + "px";
      dup.style.left = "" + decX + "px";
      dup.setAttribute("name", "element_"+ids);
      dup.setAttribute("draggable", "true");
      
      //inputList["element_"+ids] = dup.innerHTML;
      //inputList[] = dup.id;
      inputList.push(dup.id);
      
      dup.addEventListener("dragstart", drag, false);
      // On l'ajoute
      ev.target.appendChild(dup);
      ids = ids + 1;
   }
   //document.getElementById("info").value = inputList.toString();
   send();
}

function send () {
var 
	e;
	
	//newElt= document.createElement("input");
	//newElt.setAttribute("type", "hidden");
	//newElt.setAttribute("id", "info");
	//newElt.setAttribute("name", "info");
	/*var chaine = "";
	for(var valeur in inputList){
	   chaine = chaine + '{' + valeur + '$' + inputList[valeur] + '}';
     //document.write(valeur + ' : ' + inputList[valeur] + '  ');
   }*/
   /*var chaine = "";
   for (i = 0; i < inputList.length; i++) {
      e = document.getElementById(inputList[i]);
      chaine = chaine + '{' + e.getAttribute("name") + "$" + e.innerHTML + '}';
   }*/
	document.getElementById("info").value = document.getElementById("panneau").innerHTML;//document.getElementById("panneau").innerHTML;
	
	//form= document.getElementById("send");
	//form.appendChild(newElt);
	//form.submit();
}

