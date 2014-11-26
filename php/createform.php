<!doctype html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="../res/img/favicon.png" />
<link rel="stylesheet" href="../lib/bootstrap-3.3.1/min.css" type="text/css" />
<link rel="stylesheet" href="../css/styles.css" type="text/css" />

<script src="../lib/jquery-2.1.1/min.js"></script>
<script src="../lib/bootstrap-3.3.1/min.js"></script>
<script type="text/javascript">
var ids = 0;
function dragStart(ev) {
/*Le drag commence*/
   ev.dataTransfer.effectAllowed='move';
   //ev.dataTransfer.effectAllowed='move';
   ev.dataTransfer.setData("Text", ev.target.getAttribute('id'));
   //ev.dataTransfer.setDragImage(ev.target,0,0);
   return true;
}
function dragEnter(ev) {
/*L'utilisateur entre dans le dépôt*/
   ev.target.style.border = "2px dashed #000";
   event.preventDefault();
   return true;
}

function dragLeave(ev){
/*L'utilisateur quitte le dépôt*/
    ev.target.style.border = "none";
}

function dragOver(ev) {
    ev.dataTransfer.dropEffect = "move";
    ev.preventDefault();
    return false;
}
function dragDrop(ev) {
/*Laché de l'élément draggué*/
   //ev.preventDefault();
   var data=ev.dataTransfer.getData("Text");
   if (data<=ids) {
     ev.target.appendChild(document.getElementById(data));
   } else {
  /* If you use DOM manipulation functions, their default behaviour it not to 
     copy but to alter and move elements. By appending a ".cloneNode(true)", 
     you will not move the original element, but create a copy. */
     var nodeCopy = document.getElementById(data).cloneNode(true);
     nodeCopy.id = ids; /* We cannot use the same ID */
     nodeCopy.text = ids;
     nodeCopy.removeEventListener("ondragover", dragOver, false);
     ev.target.appendChild(nodeCopy);
     ids = ids+1;
   }
   ev.target.style.background = "white";
   ev.target.style.border = "none";
   ev.preventDefault();
   ev.stopPropagation();
   return false;
}
</script>
<style>
[draggable] {
  -moz-user-select: none;
  -khtml-user-select: none;
  -webkit-user-select: none;
  user-select: none;
  /* Required to make elements draggable in old WebKit */
  -khtml-user-drag: element;
  -webkit-user-drag: element;
}
.zoneDrop {
  height: 100%;
  min-height:200px;
  text-align : right;
}
.draggable {
  height : auto;
  width : auto;
  margin-right: 5px;
  margin-left: 5px;
  text-align : left;
  border-radius: 10px;
  cursor: move;
}
</style>
</head>
<body>
   <?php
      session_start ();
   ?> 
	<div class="container">
      <?php include('include/header.php'); ?>
      <div class="row">
		   <?php include('include/nav.php'); ?>
      </div>
      
      <div class="row">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><B>Destinataires</B></h3>
               </div>
               <div class="panel-body">
                  <form class="form-horizontal" role="form" action="ajouter_form_user.php" method="post" id="formDestinataire">
                     <div class="form-group">
                        <label><input type="checkbox" name="lol" value="LLLLL1"> lol</label><br>
                     </div>
                  </form>
              </div>
            </div>
      </div>
      
      <div class="row">
      <div class="col-sm-10">
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"><B>Création</B></h3>
            </div>
            <div class="panel-body">
               <form class="form-horizontal" role="form" action="ajouter_form_user.php" method="post" id="formCreation">
                  <div class="form-group">
                     <div id="destinationDraggables" class="zoneDrop" ondragenter="return dragEnter(event)" 
     ondrop="return dragDrop(event)" 
     ondragover="return dragOver(event)" ondragleave="return dragLeave(event)"></div>
                  </div>
                  
               </form>
            </div>
         </div>
      </div>  
      <div class="col-sm-2">
        <div id="draggable" class="draggable" draggable="true" ondragstart="return dragStart(event)"><input type="checkbox">Checkbox</div>
         <div id="draggable1" class="draggable" draggable="true" ondragstart="return dragStart(event)">Text</div>
         <div id="draggable2" class="draggable" draggable="true" ondragstart="return dragStart(event)"><input type="textbox" class="form-control" name="champsText"></div>
      </div> 
	   </div>
	   
	   <div class="row">
         <input type="submit" class="btn btn-default" value="Enregistrer" form="formDestinataire formCreation">
	      <input type="submit" class="btn btn-default" value="Valider" form="formDestinataire formCreation">
	   </div>
	   <?php include('include/footer.php'); ?>
   </div>
</body>
</html>

<!--<script>
function handleDragStart(e) {
  this.style.opacity = '0.4';  // this / e.target is the source node.
}
function dragEnter(ev) {
   event.preventDefault();
   return true;
}
function dragOver(ev) {
    return false;
}
function dragDrop(ev) {
   var src = ev.dataTransfer.getData("Text");
   ev.target.appendChild(document.getElementById(src));
   ev.stopPropagation();
   return false;
}

var cols = document.querySelectorAll('.draggable');
document.write(cols.length);
[].forEach.call(cols, function(col) {
  col.addEventListener('dragstart', handleDragStart, false);//
});

var destDraggable = document.getElementById('#destinationDraggable');

</script>-->
