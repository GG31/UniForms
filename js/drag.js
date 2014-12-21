var type = "radio";
var elementList = {};
var ids = 0;
var currentElement;
var elt;

function init() {
   hideAll();

   $("#infoFormName").val("NULL");
   elt = document.getElementsByClassName("draggable");
   for (i = 0; i < elt.length; i++) {
      elt[i].addEventListener("dragstart", drag, false);
   }
   for(i = 0; i<elems.length; i++) {
      elementList[elems[i].id] = elems[i];
      var newNode = document.createElement("div");
      newNode.id = ids;
      newNode.style.position = "absolute";
      newNode.style.top = "" + elems[i].posY + "px";
      newNode.style.left = "" + elems[i].posX + "px";
      newNode.setAttribute("name", "element_"+ids);
      newNode.setAttribute("draggable", "true");
      newNode.addEventListener("dragstart", drag, false);
      
      newNode.appendChild(elems[i].element.get(0));
      // On l'ajoute
      document.getElementById("panneau").appendChild(newNode);
      ids = ids + 1;
   }

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
   elt = document.getElementById(datas[0]);

   if (datas[0]<=ids) {
      // DnD dans la fenetre de construction
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
      decX = 0;
      decY = 0;
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
      if($("#"+currentElement).is("textarea")){
         elementList[currentElement].type = "TextArea";
      }else if($("#"+currentElement).is("fieldset")){
         if($("#"+currentElement).children('input').attr("type") == 'radio') {
            elementList[currentElement].type = 'RadioButton';
         } else if($("#"+currentElement).children('input').attr("type") == 'checkbox') {
            elementList[currentElement].type = 'Checkbox';
         }
         
      } else if($("#"+currentElement).is("input")) {
         if ($("#"+currentElement).attr('type') == 'text') {
            elementList[currentElement].type = "InputText";
         } else if ($("#"+currentElement).attr('type') == 'number') {
            elementList[currentElement].type = "InputNumber";
         } else if ($("#"+currentElement).attr('type') == 'time') {
            elementList[currentElement].type = "InputTime";
         } else if ($("#"+currentElement).attr('type') == 'date') {
            elementList[currentElement].type = "InputDate";
         } else if ($("#"+currentElement).attr('type') == 'tel') {
            elementList[currentElement].type = "InputPhone";
         }
      } else if($("#"+currentElement).is("span")){
         elementList[currentElement].type = "Span";
      }
   }
   elementList[currentElement].posX = decX;
   elementList[currentElement].posY = decY;
   updatePanelDetail();
}

function sendJson() {
	document.getElementById("info").value = JSON.stringify(elementList);
}

$( "#panneau" ).click(function(e) {
   var el= e.target||e.srcElement;
   currentElement = el.id;
   updatePanelDetail();
});


$( "#checkboxRequired" ).click(function(e) {
   elementList[currentElement].required = $('#checkboxRequired').is(':checked');
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
	
	elementList[currentElement].values[nb] = "";
});

function valueItemChange(nb) {
   elementList[currentElement].values[nb] = $('#valueItem_'+currentElement+'_'+nb).val();
   $("#"+currentElement).children('input').eq(nb).next().text(elementList[currentElement].values[nb]);
   
}

$('#inputNumberMin').change(function() {
   elementList[currentElement].min = $('#inputNumberMin').val();
});
$('#inputNumberMax').change(function() {
   elementList[currentElement].max = $('#inputNumberMax').val();
});
$('#inputdefaultValue').change(function() {
   elementList[currentElement].defaultValue = $('#inputdefaultValue').val();
});
$('#inputLabelValue').change(function() {
   elementList[currentElement].label = $('#inputLabelValue').val();
});

function hideAll() {
   $('#inputValueGroup').hide();
   $('#checkboxRequiredGroup').hide();
   $('#valuesGroup').hide();
   $('#inputNumberGroup').hide();
   $('#defaultValueGroup').hide();
   $('#labelGroup').hide();
}

function updatePanelDetail() {
   hideAll();
   if($("#"+currentElement).is("fieldset")){
      hasLabel()
      hasRequired();
      type = $("#"+currentElement).children('input').attr("type");
      hasSeveralValues();
   } else if($("#"+currentElement).is("textarea")){
      hasLabel()
      hasRequired();
   } else if($("#"+currentElement).is("input")) {
      // Si input
      if ($("#"+currentElement).attr('type') == 'text') {
         // Si Textbox
         hasLabel()
         hasRequired();
         hasDefaultValueText();
      } else if ($("#"+currentElement).attr('type') == 'number') {
         hasLabel()
         hasRequired();
         hasMinMax();
      } else if ($("#"+currentElement).attr('type') == 'date') {
         hasLabel()
         hasRequired();
      } else if ($("#"+currentElement).attr('type') == 'time') {
         hasLabel()
         hasRequired();
      } else if ($("#"+currentElement).attr('type') == 'tel') {
         hasLabel()
         hasRequired();
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

function hasDefaultValueText() {
   $('#defaultValueGroup').show();
   $('#inputdefaultValue').val(elementList[currentElement].defaultValue);
}

function hasLabel() {
   $('#labelGroup').show();
   $('#inputLabelValue').val(elementList[currentElement].label);
}

function hasSeveralValues() {
   $('#valuesGroup').show();
   $("#"+currentElement).children().attr("name", currentElement);
   $("#valueItem_0").attr("id", 'valueItem_'+currentElement+'_0');
   if(!elementList[currentElement].hasOwnProperty("values")) {
      elementList[currentElement].values = {};
      elementList[currentElement].values[0] = "";
   }
   $(".valueItem").next().remove();
   $(".valueItem").remove();
   
   for (var i = 0; i<Object.keys(elementList[currentElement].values).length; i++) {
      var newTextBoxDiv = $('<input type="Text" class="valueItem" id="valueItem_'+currentElement+'_'+i+'" onchange="valueItemChange('+i+')" value="'+elementList[currentElement].values[i]+'"><br>');
      $("#valuesGroup").append(newTextBoxDiv);
      $("#"+currentElement).children('input').eq(i).next().text(elementList[currentElement].values[i]);
   }
}

$("#formName").focusout(function() {
   if($("#formName").text() == '') {
      $("#formName").text("NULL");
   }
   $("#infoFormName").val($("#formName").text());
});

function getTypeElement(element) {

}
