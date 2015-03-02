lessGroup = function(nb) {
   $("#" + nb).remove();
   deleteGroup(nb);
}

moreGroup = function(multiple) {
   var nb = 0;
   if ($('#groupSection > .row').length == 0)
      nb = 0
   else {
      nb = parseInt($('#groupSection > .row:last').attr('id').split('_')[1]);
      nb = nb + 1;
   }

   multiple = '<input id = "group_'+nb+'_multiple" type="number" name="group_'+nb+'_multiple" value="' + multiple + '" min="0" class="form-control bfh-number" style="width: 40pt;" data-toggle="tooltip" data-placement="top" title="Entrez le nombre de fois que le formulaire pourra être rempli par le(s) destinataire(s), 0 pour infini">'
   newNode = $('<div class="row" id="group_'+nb+'"><div class="panel panel-default col-sm-8"><div class="panel-body"><div class="groupElements"></div></div></div><button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-envelope" ariahidden="true"></span></button><button type="button" class="btn btn-default btn-lg" onclick="lessGroup(\'group_'+nb+'\')"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></button>' + multiple + '</div>');

   $('#groupSection').append(newNode);
   groupElementsDroppable();
   refreshGroupUsers("group_"+nb);
}

