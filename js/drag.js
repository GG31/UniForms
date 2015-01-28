var type = "radio";
var elementList = {};
var ids = 0;
var currentElement;
var elt;
var elementsCode = {
   draggableLabel:'<span>Label</span>', 
   draggableNumber:'<input type="number">', 
   draggableDate:'<input type="text" class="form-control" placeholder="jj/mm/aaaa"/>',
   draggableTime:'<input type="time" class="form-control" placeholder="hh:mm"/>',
   draggableTextarea:'<textarea rows="4" cols="40" class="form-control"></textarea>',
   draggableTel:'<input type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" class="form-control" placeholder="06xxxxxxxx"/>',
   draggableText:'<input type="text" class="form-control" />',
   draggableRadio:'<fieldset><input type="radio"> <span class="0"><span></fieldset>',
   draggableCheckbox:'<fieldset><input type="checkbox"> <span class="0"><span></fieldset>',
   draggableSquare:'<div class="figure square"></div>',
   draggableCircle:'<div class="figure circle"></div>',
   draggableimg:'<input type="file" id="files" multiple /><br/><output id="list"></output>'
}; 

function init() {
   hideAll();
   $("#formName").text(formname);
   $("#infoFormName").val(formname);
   drag();
   groupElementsDroppable();
   //alert("longueur "+elems.length);
   for(i = 0; i<elems.length; i++) {
      elementList[elems[i].id] = elems[i];
      currentElement = elems[i].id;
      var newNode = $('<div class="draggable" draggable="true"></div>');
      newNode.attr('id', ids);
      newNode.css('position', "absolute");
      newNode.css('top', elems[i].posY + "px");
      newNode.css('left', elems[i].posX + "px");
      newNode.css('width', "auto");
      newNode.css('height', "auto");
      newNode.css('padding', "5px");
      newNode.attr("name", "element_"+ids);
      newNode.attr("draggable", "true");
      newNode.append(constructSpan(elems[i].label));
      newNode.append(elems[i].element.get(0));
      newNode.draggable({ cancel: null });
      newNode.draggable({
          cursor: 'grab',
          containment: "#panneau"
      });
      // On l'ajoute
      $("#panneau").append(newNode);
      $("#"+elems[i].id).width(elems[i].width);
      $("#"+elems[i].id).height(elems[i].height);
      ids = ids + 1;
   }
}

$(".draggable").css('cursor','grab');

drag = function(){
   $(".draggable").draggable({
       helper:"clone",
       opacity:0.7,
       cursor: 'grab',
       containment: "#panneau"
   });
   $(".draggable").hover(function() {
      $(this).css({
         'font-style': 'italic',
         background : '#FFFFCC'
      });
   }, function() {
      $(this).css({
         'font-style': 'normal',
         background : 'white'
      });
   });
};

groupElementsDroppable = function() {
   $('.groupElements').droppable({
      drop: function (e, ui) {
         var idToPutIntoGroup = $(ui.draggable).children("span").next().attr("id");
         var valueToPutIntoGroup = $(ui.draggable).children("span").text();
         if(valueToPutIntoGroup === "") {
            valueToPutIntoGroup = idToPutIntoGroup;
         }
         var yes = 1;
         $(".groupElements .valueIdElementsOfGroup").each(function(){
            if($(this).text() == idToPutIntoGroup) {
               yes = 0;
            }
               
         });
         if (yes) {
            $(this).append($('<div class="alert alert-warning alert-dismissible" role="alert" style="display: inline-block">  <button type="button" class="close btn btn-primary btn-lg" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><span class="valueLabelElementsOfGroup">'+valueToPutIntoGroup+'</span><span class="valueIdElementsOfGroup">'+idToPutIntoGroup+'</span></div>'));
         }
         ui.draggable.draggable('option','revert',true);
         setTimeout(function () {
              ui.draggable.draggable('option','revert','invalid');
          }, 100);
      }
   });
};

$('#panneau').droppable(
   {      
      drop: function (e, ui) {
         posX = e.pageX;
         posY = e.pageY;
         //console.log(posX + " " + posY);
         if ($(ui.draggable).attr("id").split('_')[0] == 'child' || $(ui.draggable).attr("id").split('_')[0] == 'elem' || $(ui.draggable).attr("id") < ids) {
            currentElement = $(ui.draggable).children("span").next().attr("id");
            posX = checkPosition(e.pageX, $(ui.draggable));
         } else {
            posX = posX < $('#panneau').offset().left ? $('#panneau').offset().left : posX;
            posY = posY < $('#panneau').offset().top ? $('#panneau').offset().top : posY;
            el = $('<div class="draggable" draggable="true"></div>');
            el.attr({
               id: ids,
               name: "element_"+ids,
               draggable:"true"
            });
            el.css({
               position: "absolute",
               left: posX + "px",
               top: posY + "px",
               width: 'auto',
               height: 'auto',
               padding: '5px',
               'z-index': 2
            });
            
            elChild = $(elementsCode[$(ui.draggable).attr("id")]);
            elChild.attr("id", "child_" + ids);
            if(elChild.hasClass("figure")) {
               console.log("class figure");
               el.css({
                  cursor:'grab',
                  width: '100px',
                  height:'100px',
                  'z-index': 1
               });
            }
            elChild.css({
               cursor:'grab',
               width: '100%',
               height:'100%'
            });
            
            createElement(elChild.attr("id"));
            
            el.append(constructSpan(""));
            el.append(elChild);
            el.appendTo($(this));
            el.draggable({ cancel: null });
            el.draggable({
                grid: [20, 20],
                revert: 'invalid',
                cursor: 'grab'
            });
            
            onhover();
            ondrag();
            if(!elChild.is("fieldset")) {
               resize(el);
            }
            if (posX + elementList[currentElement].width > $('#panneau').width()) {
               posX = $('#panneau').offset().left + $('#panneau').width() - elementList[currentElement].width - 50;
               el.css({left: posX + "px"});
            }
            ids = ids + 1;
         }
         elementList[currentElement].posX = posX;
         elementList[currentElement].posY = posY;
         growZone();
         updatePanelDetail();
      }
   }
);

createElement = function(id) {
   var newElement = new Object();
   newElement.id = id;
   elementList[newElement.id] = newElement;
   currentElement = newElement.id;
   elementList[currentElement].type = getType(elChild);
};

resize = function(el) {
   el.resizable();
   registerWidthHeight(currentElement, el.width(), el.height());
   el.on('resize', function() {
      idElement = $(this).children("input, textarea, div[class*=figure]").attr("id");
      if($('#'+idElement).hasClass('circle')) {
         $('#'+idElement).css("border-radius", $(this).width()/2);
      }
      registerWidthHeight(idElement, $(this).width(), $(this).height());
   });
};

growZone = function() {
   $('#panneau').animate({ 
      height: (findMoreBottomElement() * 1122)+'px'
   }, 10);
};

registerWidthHeight = function(idElement, width, height) {
   elementList[idElement].width = width;
   elementList[idElement].height = height;
   if (idElement == currentElement) {
      $('#inputWidthValue').val(width);
      $('#inputHeightValue').val(height);
   }
};

onhover = function() {
   $('#'+currentElement).parent().hover( function() {
      $(this).css({
         'box-shadow': '0px 0px 12px #0000FF'
      });
   }, function() {
      $(this).css({
         'box-shadow':'none'
      });
   });
};

ondrag = function() {
   $('#'+currentElement).on("drag", function( event, ui ) {
      if($(this).offset().top - $('#panneau').offset().top >$('#panneau').height()-70 && $(this).offset().top - $('#panneau').offset().top <$('#panneau').height()){ 
         $('#panneau').animate({ 
            height: (($('#panneau').height()) + 1122)+'px'
         }, 10);
      }
   });
};

checkPosition = function(posX, el) {
   var width = elementList[currentElement].width;
   var pos;
   if (posX+width>$('#panneau').offset().left+$('#panneau').width()) {
      //console.log("1nd if");
      pos = $('#panneau').offset().left + $('#panneau').width() - width - 50;
      el.css({
         left: pos +"px"
      });
      return pos;
   }
   if((posX-width/2 < $('#panneau').offset().left)){
      //console.log("2nd if");
      pos = $('#panneau').offset().left + 10;
      el.css({
         left: pos + "px"
      });
      return pos;
   } 
   //console.log("else");
   return posX;
};

findMoreBottomElement = function() {
   var max = 0;
   $.each(elementList, function(key, val) {
      if(val.posY + val.height > max) {
         max = val.posY + val.height;
      }
   });
   var result = parseInt(Math.floor(max/1122), 10) + 1; // parseInt a besoin du 'radix', la base (10)
   console.log(max/1122 + " " +result);
   return result;
};

constructSpan = function(value) {
   span = $('<span id="label_' + currentElement + '">'+value+'</span>');
   return span;
};

getType = function(node) {
   if(node.is("textarea")){
      return "TextArea";
   }else if(node.is("fieldset")){
      if(node.children('input').attr("type") == 'radio') {
         return 'RadioButton';
      } else if(node.children('input').attr("type") == 'checkbox') {
         return 'Checkbox';
      }
   } else if(node.is("input")) {
      if (node.attr('type') == 'text') {
         return "InputText";
      } else if (node.attr('type') == 'number') {
         return "InputNumber";
      } else if (node.attr('type') == 'time') {
         return "InputTime";
      } else if (node.attr('type') == 'date') {
         return "InputDate";
      } else if (node.attr('type') == 'tel') {
         return "InputPhone";
      }
   } else if(node.is("span")){
      return "Span";
   } else if(node.is("div") && node.hasClass("square") ) {
      return "Square";
   } else if (node.hasClass("circle")){
      return "Circle";
   }
   return null;
};

sendJson = function() {
	document.getElementById("info").value = JSON.stringify(elementList);
	document.getElementById("infoGroups").value = JSON.stringify(getGroupsAndElements());
};

getGroupsAndElements = function() {
   var groupList = {};
   var nb = 0;
   $("#groupSection .row").each(function(){
      groupList[nb] = {};
      var nbEl = 0;
      $('.valueIdElementsOfGroup', this).each(function(){
         groupList[nb][nbEl] = $(this).text();
         nbEl = nbEl + 1;
      });
      nb = nb + 1;
   });
   return groupList;
};

$( "#panneau" ).click(function(e) {
   var el= e.target||e.srcElement;
   currentElement = el.id;
   if (currentElement.split('_')[0]=='label') {
      currentElement = currentElement.split('_')[1] + "_" + currentElement.split('_')[2];
   }
      updatePanelDetail();   
});

$('html').keyup(function(e){
   if(e.keyCode == 46 && (currentElement.split('_')[0] == 'child' || currentElement.split('_')[0] == 'elem')) {
      $('#'+currentElement).parent().remove();
      delete elementList[currentElement];
   }
});

$( "#checkboxRequired" ).click(function(e) {
   elementList[currentElement].required = $('#checkboxRequired').is(':checked');
});

$('#moreValues').click(function() {
   var nb = parseInt($("input[name="+currentElement+"]:last+span").attr("class"), 10) + 1;
   var id = 'valueItem_'+currentElement+'_'+nb;
   //var nb = elementList[currentElement].values.length;
   var newTextBoxDiv = $('<div id="div'+id+'"><input type="Text" class="valueItem" id='+id+' onchange="valueItemChange('+nb+')">'+buttonLess(nb)+'</div>');
	$("#valuesGroup").append(newTextBoxDiv);
	
    var te = $('<div id="item'+id+'"><input type="'+type+'" name="'+currentElement+'"> <span class="'+nb+'"><span></div>');
	$("#"+elementList[currentElement].id).append(te);
	
	elementList[currentElement].values["v"+nb] = "";
});

onpressLessButton = function(nb) {
   if (parseInt(nb, 10) === 0) {
      $('input[name="'+currentElement+'"]+span[class="'+nb+'"]:first').remove();
      $('input[name="'+currentElement+'"]:first').remove();
      $('#valueItem_'+currentElement+'_'+nb).next().remove();
      $('#valueItem_'+currentElement+'_'+nb).remove();
   }else {
      $("#itemvalueItem_"+currentElement+"_"+nb).remove();
      $("#divvalueItem_"+currentElement+"_"+nb).remove();
   }
   delete elementList[currentElement].values["v"+nb];
   if(Object.keys(elementList[currentElement].values).length === 0){
      delete elementList[currentElement];
   }
};

valueItemChange = function(nb) {
   elementList[currentElement].values["v"+nb] = $('#valueItem_'+currentElement+'_'+nb).val();
   $('input[name="'+currentElement+'"]+span[class="'+nb+'"]:first').text(elementList[currentElement].values["v"+nb]);
   
};

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
   posX = checkPosition(elementList[currentElement].posX, $("#"+currentElement));
   elementList[currentElement].posX = posX;
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
};

updatePanelDetail = function() {
   hideAll();
   $('#panneau input, textarea, fieldset, span, div').css({
      'box-shadow': 'none'
   });
   $('#panneau div[class*=figure]').css({
      'box-shadow': 'none',
      border : 'solid black'
   });
   var currentType = "";
   console.log("current " + currentElement);
   if(currentElement != undefined && (currentElement.split('_')[0] == 'child' || currentElement.split('_')[0] == 'elem')){
      $('#'+currentElement).css({
         'box-shadow': '0px 0px 12px Red'
      });
      currentType = elementList[currentElement].type;
   }
   if(currentType == 'RadioButton' || currentType == 'Checkbox'){
      hasLabel();
      hasRequired();
      type = $("#"+currentElement).children('input').attr("type");
      if(typeof(type)  === "undefined") {
         type = $("#"+currentElement).children("div").children('input').attr("type");
      }
      hasSeveralValues();
   } else if(currentType == "TextArea"){
      hasLabel();
      hasRequired();
      hasSize();
   } else if (currentType == "InputText") {
      // Si Textbox
      hasLabel();
      hasRequired();
      hasDefaultValueText();
      hasSize();
   } else if (currentType == "InputNumber") {
      hasLabel();
      hasRequired();
      hasMinMax();
      hasSize();
   } else if (currentType == "InputDate") {
      hasLabel();
      hasRequired();
      hasSize();
   } else if (currentType == "InputTime") {
      hasLabel();
      hasRequired();
      hasSize();
   } else if (currentType == "InputPhone") {
      hasLabel();
      hasRequired();
      hasSize();
   } else if(currentType == "Span") {
      // Si label
      hasValueText();
   } else if(currentType == "Square" || currentType == "Circle") {
      hasSize();
   }
};

hasRequired = function () {
   $('#checkboxRequiredGroup').show();
   if(!elementList[currentElement].hasOwnProperty("required")) {
      elementList[currentElement].required = false;
   }
   $('#checkboxRequired').prop('checked', elementList[currentElement].required);
};

hasMinMax = function () {
   $('#inputNumberGroup').show();
   $('#inputNumberMin').val(elementList[currentElement].min);
   $('#inputNumberMax').val(elementList[currentElement].max);
};

hasValueText = function () {
   $('#inputValueGroup').show();
   $('#inputValue').val(elementList[currentElement].value);
};

hasDefaultValueText = function () {
   $('#defaultValueGroup').show();
   $('#inputdefaultValue').val(elementList[currentElement].defaultValue);
};

hasLabel = function () {
   $('#labelGroup').show();
   $('#inputLabelValue').val(elementList[currentElement].label);
};

hasSize = function() {
   $("#sizeGroup").show();
   $('#inputWidthValue').val(elementList[currentElement].width);
   $('#inputHeightValue').val(elementList[currentElement].height);
};

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
     var newTextBoxDiv = $('<div id="divvalueItem_'+currentElement+'_'+nb+'"><input type="Text" class="valueItem" id="valueItem_'+currentElement+'_'+nb+'" onchange="valueItemChange('+nb+')" value="'+val+'">'+buttonLess(nb)+'</div>');
      $("#valuesGroup").append(newTextBoxDiv);
      $('input[class="'+currentElement+'"]+span[class="'+nb+'"]:first').text(val);
   }
};

$("#formName").focusout(function() {
   if($("#formName").text() === '') {
      $("#formName").text("NULL");
   }
   $("#infoFormName").val($("#formName").text());
});

buttonLess = function(nb) {
   return '<button type="button" class="lessValues" class="btn btn-default btn-lg" onclick="onpressLessButton('+nb+')">  <span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>';
};
