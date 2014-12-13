hideAll();
var type = "radio";
var elementList = {};
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
   //alert(currentElement + " " + datas[0]);
   if (datas[0]<=elt) {
      // DnD dans la fenetre de construction
      elt = document.getElementById(datas[0]);
      decX = ev.clientX - datas[1];
      decY = ev.clientY - datas[2];
      elt.style.position="absolute";
      elt.style.top= "" + decY + "px";
      elt.style.left= "" + decX + "px";
      currentElement = elt.firstChild.id;
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
      dup.setAttribute("name", "element_"+ids);
      dup.setAttribute("draggable", "true");
      dup.firstChild.id = "child_" + ids;

      var newElement = new Object();
      newElement.id = "child_" + ids;
      elementList[newElement.id] = newElement;
      currentElement = newElement.id;
      dup.addEventListener("dragstart", drag, false);
      // On l'ajoute
      ev.target.appendChild(dup);
      ids = ids + 1;
   }
   elementList[currentElement].posX = decX;
   elementList[currentElement].posY = decY;
   //alert(elementList[currentElement].posX+" "+elementList[currentElement].posY);
   updatePanelDetail();
}

function sendJson() {
	document.getElementById("info").value = JSON.stringify(elementList);
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
   //alert(currentElement+" "+elementList[currentElement].required);
});

$('#inputValue').change(function() {
   $("#"+currentElement).text($('#inputValue').val());
   elementList[currentElement].value = $('#inputValue').val();
});

$('#moreValues').click(function() {
   var nb = $("input[name="+currentElement+"]").length;
   var newTextBoxDiv = $('<br><div><input type="Text" class="valueItem" id="valueItem_'+currentElement+'_'+$("input[name="+currentElement+"]").length+'" onchange="valueItemChange('+nb+')"></div>');
	$("#valuesGroup").append(newTextBoxDiv);
	
    var te = $('<br><input type="'+type+'" name="'+currentElement+'"> <span><span>');
	$("#"+elementList[currentElement].id).append(te);
	
	elementList[currentElement].value[nb] = "";
});

function valueItemChange(nb) {
   elementList[currentElement].value[nb] = $('#valueItem_'+currentElement+'_'+nb).val();
   $("#"+currentElement).children('input').eq(nb).next().text(elementList[currentElement].value[nb]);
   
}

$('#inputNumberMin').change(function() {
   elementList[currentElement].min = $('#inputNumberMin').val();
});
$('#inputNumberMax').change(function() {
   elementList[currentElement].max = $('#inputNumberMax').val();
});

function hideAll() {
   $('#inputValueGroup').hide();
   $('#checkboxRequiredGroup').hide();
   $('#valuesGroup').hide();
   $('#inputNumberGroup').hide();
}

function updatePanelDetail() {
   hideAll();
   if($("#"+currentElement).is("fieldset")){
      hasRequired();
      type = $("#"+currentElement).children('input').attr("type");
      hasSeveralValues();
   } /*else if($("#"+currentElement).is("textarea")){//Ne marche pas
      $('#checkboxRequiredGroup').show();
      $("#"+currentElement).children().attr("name", currentElement);
      $('#checkboxRequired').prop('checked', elementList[currentElement].required);
   }*/
   else if($("#"+currentElement).is("input")) {
      // Si input
      if ($("#"+currentElement).attr('type') == 'text') {
         // Si Textbox
         hasRequired();
      } else if($("#"+currentElement).attr('type') == 'number') {
         //Si radio button
         hasRequired();
         hasMinMax();
      }
   }else if($("#"+currentElement).is("span")) {
      // Si label
      hasValueText();
   }
}

function hasRequired() {
   $('#checkboxRequiredGroup').show();
   if(!elementList[currentElement].hasOwnProperty("required")) {
      elementList[currentElement].required = false;
   }
   $('#checkboxRequired').prop('checked', elementList[currentElement].required);
}

function hasMinMax() {
   $('#inputNumberGroup').show();
   $('#inputNumberMin').val(elementList[currentElement].min);
   $('#inputNumberMax').val(elementList[currentElement].max);
}

function hasValueText() {
   $('#inputValueGroup').show();
   $('#inputValue').val(elementList[currentElement].value);
}

function hasSeveralValues() {
   $('#valuesGroup').show();
   $("#"+currentElement).children().attr("name", currentElement);
   $("#valueItem_0").attr("id", 'valueItem_'+currentElement+'_0');
   //alert(currentElement);
   if(!elementList[currentElement].hasOwnProperty("value")) {
      elementList[currentElement].value = {};
      elementList[currentElement].value[0] = "";
   }
   $(".valueItem").next().remove();
   $(".valueItem").remove();
   
   for (var i = 0; i<Object.keys(elementList[currentElement].value).length; i++) {
      var newTextBoxDiv = $('<input type="Text" class="valueItem" id="valueItem_'+currentElement+'_'+i+'" onchange="valueItemChange('+i+')" value="'+elementList[currentElement].value[i]+'"><br>');
      $("#valuesGroup").append(newTextBoxDiv);
      $("#"+currentElement).children('input').eq(i).next().text(elementList[currentElement].value[i]);
   }
}


