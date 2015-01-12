lessGroup = function() {
   alert('yop');
}

moreGroup = function() {
   var nb = $('#groupSection > .row').length;
   //alert(nb); 
   newNode = $('<div class="row">							   <div class="panel panel-default col-sm-8">						         <div class="panel-body">                              <div>                              </div>                           </div>                        </div>                        <button type="button" class="btn btn-default btn-lg">                              <span class="glyphicon glyphicon-envelope" ariahidden="true"></span> Destinataire                        </button>                        <button type="button" class="btn btn-default btn-lg"onclick="lessGroup(0)">                              <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>                        </button>                     </div>                     	</div>						');
   $('#groupSection').append(newNode);
}
