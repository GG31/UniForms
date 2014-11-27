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
      
      
      <form class="form-horizontal" role="form" action="add_form.php" method="post" id="formulaire">
         <div class="row">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><B>Destinataires</B></h3>
               </div>
               <div class="panel-body">
                  <div class="form-group">
                     <?php
                        $users = User::getAllUsers();
                        if (!$users) {
                           die('Requête invalide : ' . mysql_error());
                        }
                        while($row = mysql_fetch_assoc($users)) {
                           echo '
                           <div class="input-group">
                              <span class="input-group-addon">
                                <input type="checkbox" name="checkboxDestinataire_'.$row["user_id"].'" value="'.$row["user_id"].'">
                              </span>
                              <label class="form-control">'.$row["user_id"].' '.$row["user_name"].'</label>
                           </div>'
                           
                          ;
                        }
                     ?>
                  </div>
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
                     <div class="form-group">
                     </div>
                  </div>
               </div>
            </div>  
            <div class="col-sm-2">
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <h3 class="panel-title"><B>Éléments</B></h3>
                  </div>
                  <div class="panel-body">
                     
                        
                  </div>
               </div>
            </div>   
         </div>
      </form>
	   <div class="row well">
         <input type="submit" class="btn btn-default" value="Enregistrer" name="enregistrer" form="formulaire">
	      <input type="submit" class="btn btn-default" value="Valider" form="formulaire" name="valider">
	   </div>
      <div class="row well">
         <?php include('include/footer.php'); ?>
      </div>
   </div>
</body>
</html>
