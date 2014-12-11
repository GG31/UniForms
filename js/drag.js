hideAll();
var label = ["value"];
var textbox = ["required"];
var inputList = [];
var elementList = [];
var ids = 0;
var currentElement;
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
      decX = datas[1]-500;
      decY = datas[2]-100;
      dup.style.position = "absolute";
      dup.style.top = "" + decY + "px";
      dup.style.left = "" + decX + "px";
      //dup.setAttribute("onchange", "onChange("+ids+",this.value)");
      dup.setAttribute("name", "element_"+ids);
      dup.setAttribute("draggable", "true");
      dup.firstChild.id = "child_" + ids;
     
         //dup.firstChild.attr("name",dup.firstChild.id);
      
      //inputList["element_"+ids] = dup.innerHTML;
      //inputList[] = dup.id;
      inputList.push(dup.id);
      var newElement = new Object();
      newElement.id = "child_" + ids;
      elementList[newElement.id] = newElement;
      currentElement = newElement.id;
      dup.addEventListener("dragstart", drag, false);
      // On l'ajoute
      ev.target.appendChild(dup);
      ids = ids + 1;
      updatePanelDetail();
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

function onChange(ev, value) {
   ev.currentTarget.innerHTML = "lol";
   //alert(ev.currentTarget.value + " " + value);
   //ev.setAttribute("value", value);
   //alert(value);
}

$( "#panneau" ).click(function(e) {
//alert( "Handler for .click() called." );
   var el= e.target||e.srcElement;
   //alert (el.id);
   //alert ($('#child_0').attr('type'));
   currentElement = el.id;
   //alert($("#"+el.id).is("input"));
   //alert ($("#"+el.id).attr('type'));
   updatePanelDetail();
});

$( "#checkboxRequired" ).click(function(e) {
   elementList[currentElement].required = $('#checkboxRequired').is(':checked');
});

$('#inputValue').change(function() {
   $("#"+currentElement).text($('#inputValue').val());
   elementList[currentElement].value = $('#inputValue').val();
});

$('#moreRadio').click(function() {
   var nb = $("input[name="+currentElement+"]").length;
   var newTextBoxDiv = $('<br><div><input type="Text" class="radioValue" id="radioValue_'+currentElement+'_'+$("input[name="+currentElement+"]").length+'" onchange="radioValueChange('+nb+')"></div>');
	$("#radioGroup").append(newTextBoxDiv);
	
    var te = $('<br><input type="radio" name="'+currentElement+'"> <span>radio<span>');
	$("#"+elementList[currentElement].id).append(te);
});

function radioValueChange(nb) {
   //alert("change "+currentElement + " "+ nb + " " +$('#radioValue_'+currentElement+'_'+nb).val());
   elementList[currentElement].value[nb] = $('#radioValue_'+currentElement+'_'+nb).val();
}

$('#inputNumberMin').change(function() {
   //alert($("#"+currentElement).next().text("haha"));
   elementList[currentElement].min = $('#inputNumberMin').val();
});
$('#inputNumberMax').change(function() {
   //alert($("#"+currentElement).next().text("haha"));
   elementList[currentElement].max = $('#inputNumberMax').val();
});

function hideAll() {
   $('#inputValueGroup').hide();
   $('#checkboxRequiredGroup').hide();
   $('#radioGroup').hide();
   $('#inputNumberGroup').hide();
}

function updatePanelDetail() {
   hideAll();
   //alert(currentElement);
   if($("#"+currentElement).is("fieldset")){
      $('#radioGroup').show();
      $("#"+currentElement).children().attr("name", currentElement);
      $("#radioValue_0").attr("id", 'radioValue_'+currentElement+'_0');
      alert(currentElement);
      if(!elementList[currentElement].hasOwnProperty("value")) {
         elementList[currentElement].value = [];
         elementList[currentElement].value[0] = "";
      }
      $(".radioValue").next().remove();
      $(".radioValue").remove();
      for (var i = 0; i<elementList[currentElement].value.length; i++) {
         var newTextBoxDiv = $('<input type="Text" class="radioValue" id="radioValue_'+currentElement+'_'+i+'" onchange="radioValueChange('+$("input[name="+currentElement+"]").length+')" value="'+elementList[currentElement].value[i]+'"><br>');
	      $("#radioGroup").append(newTextBoxDiv);
	      //$("#"+currentElement).child(i).next().text(elementList[currentElement].value[i]);
	      
      }
   } else if($("#"+currentElement).is("textarea")){//Ne marche pas
      $('#checkboxRequiredGroup').show();
      $("#"+currentElement).children().attr("name", currentElement);
      $('#checkboxRequired').prop('checked', elementList[currentElement].required);
   }
   else if($("#"+currentElement).is("input")) {
      // Si input
      if ($("#"+currentElement).attr('type') == 'text') {
         // Si Textbox
         $('#checkboxRequiredGroup').show();
         $('#checkboxRequired').prop('checked', elementList[currentElement].required);
      } else if($("#"+currentElement).attr('type') == 'radio') {
         //Si radio button
         //$('#radioGroup').show();
         //alert("oo");
         
      } else if($("#"+currentElement).attr('type') == 'number') {
         //Si radio button
         $('#inputNumberGroup').show();
         $('#inputNumberMin').val(elementList[currentElement].min);
         $('#inputNumberMax').val(elementList[currentElement].max);
      }
   }else if($("#"+currentElement).is("span")) {
      // Si label
      $('#inputValueGroup').show();
      $('#inputValue').val(elementList[currentElement].value);
   }
}
