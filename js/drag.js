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
