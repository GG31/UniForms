var type = "radio";
var elementList = {};
var ids = 0;
var currentElement;
var elt;
var elementsCode = {
   draggableLabel:'<span>Label</span>', 
   draggableNumber:'<input type="number">', 
   draggableDate:'<input type="text" placeholder="jj/mm/aaaa"/>',
   draggableTime:'<input type="time" placeholder="hh:mm"/>',
   draggableTextarea:'<textarea rows="4" cols="40"></textarea>',
   draggableTel:'<input type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" placeholder="06xxxxxxxx">',
   draggableText:'<input type="text"/>',
   draggableRadio:'<fieldset><input type="radio"> <span class="0"><span></fieldset>',
   draggableCheckbox:'<fieldset><input type="checkbox"> <span class="0"><span></fieldset>'
}; 

function init() {
   hideAll();
   $("#formName").text(formname);
   $("#infoFormName").val(formname);
   
   for(i = 0; i<elems.length; i++) {
      elementList[elems[i].id] = elems[i];
      var newNode = $('<div class="draggable" draggable="true"></div>');
      newNode.id = ids;
      newNode.css('position', "absolute");
      newNode.css('top', elems[i].posY + "px");
      newNode.css('left', elems[i].posX + "px");
      newNode.attr("name", "element_"+ids);
      newNode.attr("draggable", "true");
      newNode.append(constructSpan(elems[i].label));
      newNode.append(elems[i].element.get(0));
      // On l'ajoute
      $("#panneau").append(newNode);
      $("#"+elems[i].id).width(elems[i].width);
      $("#"+elems[i].id).height(elems[i].height);
      ids = ids + 1;
   }
}

$(".draggable").draggable({
    helper:"clone",
    opacity:0.7
});


$('#panneau').droppable(
   {
      drop: function (e, ui) {
         posX = e.pageX-$('#panneau').offset().left;
         posY = e.pageY-$('#panneau').offset().top;
         if ($(ui.draggable).attr("id").split('_')[0] == 'child' || $(ui.draggable).attr("id").split('_')[0] == 'elem') {
            currentElement = $(ui.draggable).attr("id");
         } else {
            el = $('<div class="draggable" draggable="true"></div>');
            el.attr("id", ids);
            el.css({
               position: "absolute",
               left: posX + "px",
               top: posY + "px"
            });
            el.attr("name", "element_"+ids);
            el.attr("draggable", "true");
            elChild = $(elementsCode[$(ui.draggable).attr("id")]);
            elChild.attr("id", "child_" + ids);
            
            var newElement = new Object();
            newElement.id = elChild.attr("id");
            elementList[newElement.id] = newElement;
            currentElement = newElement.id;
            setType(elChild);
             
            /*elChild.resizable({
               containment: "element_"+ids
            });*/
            
            el.append(constructSpan(""));
            el.append(elChild);
            el.appendTo($(this));
            el.draggable({ cancel: null });
            elementList[currentElement].width = Math.round($("#"+currentElement).width());
            elementList[currentElement].height= Math.round($("#"+currentElement).height());
            ids = ids + 1;
         }
         elementList[currentElement].posX = posX;
         elementList[currentElement].posY = posY;
         updatePanelDetail();
      }
   }
);

constructSpan = function(value) {
   span = $('<span id="label_' + currentElement + '">'+value+'</span>');
   return span;
}

setType = function(node) {
   if(node.is("textarea")){
      elementList[node.attr("id")].type = "TextArea";
   }else if(node.is("fieldset")){
      if(node.children('input').attr("type") == 'radio') {
         elementList[node.attr("id")].type = 'RadioButton';
      } else if(node.children('input').attr("type") == 'checkbox') {
         elementList[node.attr("id")].type = 'Checkbox';
      }
   } else if(node.is("input")) {
      if (node.attr('type') == 'text') {
         elementList[node.attr("id")].type = "InputText";
      } else if (node.attr('type') == 'number') {
         elementList[node.attr("id")].type = "InputNumber";
      } else if (node.attr('type') == 'time') {
         elementList[node.attr("id")].type = "InputTime";
      } else if (node.attr('type') == 'date') {
         elementList[node.attr("id")].type = "InputDate";
      } else if (node.attr('type') == 'tel') {
         elementList[node.attr("id")].type = "InputPhone";
      }
   } else if(node.is("span")){
      elementList[node.attr("id")].type = "Span";
   }
}

sendJson = function() {
	document.getElementById("info").value = JSON.stringify(elementList);
}

$( "#panneau" ).click(function(e) {
   var el= e.target||e.srcElement;
   currentElement = el.id;
   if (currentElement.split('_')[0]=='label') {
      currentElement = currentElement.split('_')[1] + "_" + currentElement.split('_')[2];
   }
   if($('#checkboxRemove').is(':checked') && el.id != "panneau") {
      //Delete currentElement
      $('#'+currentElement).parent().remove();
      delete elementList[currentElement];
   } else {
      updatePanelDetail();
   }
   
});

$('#panneau').hover(function() {
   if($('#checkboxRemove').is(":checked"))
   {
      $(this).css('cursor','crosshair');
   } else {
      $(this).css('cursor','auto');
   }
});

$( "#checkboxRequired" ).click(function(e) {
   elementList[currentElement].required = $('#checkboxRequired').is(':checked');
});

$('#moreValues').click(function() {
   alert(type);
   var nb = parseInt($("input[name="+currentElement+"]:last+span").attr("class")) + 1;
   var id = 'valueItem_'+currentElement+'_'+nb;
   //var nb = elementList[currentElement].values.length;
   var newTextBoxDiv = $('<div id="div'+id+'"><input type="Text" class="valueItem" id='+id+' onchange="valueItemChange('+nb+')">'+buttonLess(nb)+'</div>');
	$("#valuesGroup").append(newTextBoxDiv);
	
    var te = $('<div id="item'+id+'"><input type="'+type+'" name="'+currentElement+'"> <span class="'+nb+'"><span></div>');
	$("#"+elementList[currentElement].id).append(te);
	
	elementList[currentElement].values["v"+nb] = "";
});

onpressLessButton = function(nb) {
   if (parseInt(nb) == 0) {
      $('input[name="'+currentElement+'"]+span[class="'+nb+'"]:first').remove();
      $('input[name="'+currentElement+'"]:first').remove();
      $('#valueItem_'+currentElement+'_'+nb).next().remove();
      $('#valueItem_'+currentElement+'_'+nb).remove();
   }else {
      $("#itemvalueItem_"+currentElement+"_"+nb).remove();
      $("#divvalueItem_"+currentElement+"_"+nb).remove();
   }
   delete elementList[currentElement].values["v"+nb];
   if(Object.keys(elementList[currentElement].values).length == 0){
      delete elementList[currentElement];
   }
}

valueItemChange = function(nb) {
   elementList[currentElement].values["v"+nb] = $('#valueItem_'+currentElement+'_'+nb).val();
   $('input[name="'+currentElement+'"]+span[class="'+nb+'"]:first').text(elementList[currentElement].values["v"+nb]);
   
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
   $("#label_" + currentElement).text($('#inputLabelValue').val());
   elementList[currentElement].label = $('#inputLabelValue').val();
});
$('#inputValue').change(function() {
   $("#"+currentElement).text($('#inputValue').val());
   elementList[currentElement].value = $('#inputValue').val();
});
$('#inputWidthValue').change(function() {
   $("#"+currentElement).width($('#inputWidthValue').val());
   elementList[currentElement].width = $('#inputWidthValue').val();
});
$('#inputHeightValue').change(function() {
   $("#"+currentElement).height($('#inputHeightValue').val());
   elementList[currentElement].height = $('#inputHeightValue').val();
});

hideAll = function() {
   $('#inputValueGroup').hide();
   $('#checkboxRequiredGroup').hide();
   $('#valuesGroup').hide();
   $('#inputNumberGroup').hide();
   $('#defaultValueGroup').hide();
   $('#labelGroup').hide();
   $('#sizeGroup').hide();
}

updatePanelDetail = function() {
   hideAll();
   
   if($("#"+currentElement).is("fieldset")){
      hasLabel()
      hasRequired();
      type = $("#"+currentElement).children('input').attr("type");
      if(typeof(type)  === "undefined") {
         type = $("#"+currentElement).children("div").children('input').attr("type");
      }
      hasSeveralValues();
   } else if($("#"+currentElement).is("textarea")){
      hasLabel()
      hasRequired();
      hasSize();
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
      hasSize();
   }else if($("#"+currentElement).is("span")) {
      // Si label
      hasValueText();
   }
}

hasRequired = function () {
   $('#checkboxRequiredGroup').show();
   if(!elementList[currentElement].hasOwnProperty("required")) {
      elementList[currentElement].required = false;
   }
   $('#checkboxRequired').prop('checked', elementList[currentElement].required);
}

hasMinMax = function () {
   $('#inputNumberGroup').show();
   $('#inputNumberMin').val(elementList[currentElement].min);
   $('#inputNumberMax').val(elementList[currentElement].max);
}

hasValueText = function () {
   $('#inputValueGroup').show();
   $('#inputValue').val(elementList[currentElement].value);
}

hasDefaultValueText = function () {
   $('#defaultValueGroup').show();
   $('#inputdefaultValue').val(elementList[currentElement].defaultValue);
}

hasLabel = function () {
   $('#labelGroup').show();
   $('#inputLabelValue').val(elementList[currentElement].label);
}

hasSize = function() {
   $("#sizeGroup").show();
   $('#inputWidthValue').val(elementList[currentElement].width);
   $('#inputHeightValue').val(elementList[currentElement].height);
}

hasSeveralValues = function () {
   $('#valuesGroup').show();
   $("#"+currentElement).children().attr("name", currentElement);
   $("#valueItem_0").attr("id", 'valueItem_'+currentElement+'_0');
   if(!elementList[currentElement].hasOwnProperty("values")) {
      elementList[currentElement].values = {};
      elementList[currentElement].values["v0"] = "";
   }
   $(".valueItem").next().remove();
   $(".valueItem").remove();
   
   for(key in elementList[currentElement].values) {
     var val = elementList[currentElement].values[key];
     var nb = key.substring(1);
     //alert("key " + key + " val " + val);
     var newTextBoxDiv = $('<div id="divvalueItem_'+currentElement+'_'+nb+'"><input type="Text" class="valueItem" id="valueItem_'+currentElement+'_'+nb+'" onchange="valueItemChange('+nb+')" value="'+val+'">'+buttonLess(nb)+'</div>');
      $("#valuesGroup").append(newTextBoxDiv);
      $('input[class="'+currentElement+'"]+span[class="'+nb+'"]:first').text(val);
   }
}

$("#formName").focusout(function() {
   if($("#formName").text() == '') {
      $("#formName").text("NULL");
   }
   $("#infoFormName").val($("#formName").text());
});

buttonLess = function(nb) {
   return '<button type="button" class="lessValues" class="btn btn-default btn-lg" onclick="onpressLessButton('+nb+')">  <span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>';
}
