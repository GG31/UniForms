lessGroup = function(nb) {
   $("#" + nb).remove();
}

moreGroup = function() {
   var nb = 0;
   if ($('#groupSection > .row').length == 0)
      nb = 0
   else {
      nb = parseInt($('#groupSection > .row:last').attr('id').split('_')[1]);
      nb = nb + 1;
   }
   newNode = $('<div class="row" id="group_'+nb+'">							   <div class="panel panel-default col-sm-8">						         <div class="panel-body">                              <div class="groupElements"></div>                           </div>                        </div>                        <button type="button" class="btn btn-default btn-lg">                              <span class="glyphicon glyphicon-envelope" ariahidden="true"></span>                        </button>                        <button type="button" class="btn btn-default btn-lg" onclick="lessGroup(\'group_'+nb+'\')">                              <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>                        </button>                     </div>                     	</div>						');
   
   $('#groupSection').append(newNode);
   groupElementsDroppable();
}
