<!doctype html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="../res/img/favicon.png" />
<link rel="stylesheet" href="../lib/bootstrap-3.3.1/min.css" type="text/css" />
<link rel="stylesheet" href="../css/styles.css" type="text/css" />
<link rel="stylesheet" href="../css/drag.css" type="text/css"/>

<script src="../lib/jquery-2.1.1/min.js"></script>
<script src="../lib/bootstrap-3.3.1/min.js"></script>
<script src="../js/drag.js"></script>

</head>
<body>
   <?php
      session_start ();
      include ('class/User.class.php');
      include ('include/connect.php');
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
                        <?php
                           $users = User::getAllUsers();
                           if (!$users) {
                              die('Requête invalide : ' . mysql_error());
                           }
                           while($row = mysql_fetch_assoc($users)) {
                              echo '<label><input type="checkbox" name="checkboxDestintaire_'.$row["user_id"].'" value="'.$row["user_id"].'">'. $row["user_id"]. ' '.$row["user_name"].'</label><br>';
                           }
                        ?>
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
                     <div id="destinationDraggables" class="zoneDrop" name="zoneDrop" ondragenter="return dragEnter(event)" 
     ondrop="return dragDrop(event)" 
     ondragover="return dragOver(event)" ondragleave="return dragLeave(event)"></div>
                  </div>
                  <div id="lol" class="draggable" draggable="true" ondragstart="return dragStart(event)"><input type="checkbox" checked="true" name="test">Checkbox</div>
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
         <input type="submit" class="btn btn-default" value="Enregistrer" form="formDestinataire">
	      <input type="submit" class="btn btn-default" value="Valider" form="formCreation">
	   </div>
      <div class="row well">
         <?php include('include/footer.php'); ?>
      </div>
   </div>
</body>
</html>
