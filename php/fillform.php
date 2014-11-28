<!doctype html>
<?php include_once ('include/includes.php'); ?>
<html>
   <head>
      <meta charset="UTF-8">
      <title>UniForms</title>
      <link rel="shortcut icon" href="../res/img/favicon.png" />
      <link rel="stylesheet" href="../lib/bootstrap-3.3.1/min.css" type="text/css" />
      <link rel="stylesheet" href="../css/styles.css" type="text/css" />

      <script src="../lib/jquery-2.1.1/min.js"></script>
      <script src="../lib/bootstrap-3.3.1/min.js"></script>
      <!-- ?form=3 $_GET["form"]-->
   </head>
   <body>
   	<div class="container">
         <?php include('include/header.php'); ?>
         <div class="row">
   		   <?php include('include/nav.php'); ?>
   		</div>
         <div class="row">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><B>Formulaire</B></h3>
               </div>
               <div class="panel-body">
                  <form class="form-horizontal" role="form" action="????" method="post" id="answerSheet">
                     <?php
                        echo 'Formulaire '.$_GET["form"].' user '.$_SESSION['user_id'].'<br>';
                     ?>
                     <div class="form-group">
                        <label>Questions1...</label><br>
                     </div>
                     
                     <div class="form-group">
                        <label>Questions2...</label><br>
                     </div>
                     
                  </form>
               </div>
            </div>
   	   </div>
   	   
   	   <div class="row well">
            <input type="submit" class="btn btn-default" value="Enregistrer" form="answerSheet">
   	      <input type="submit" class="btn btn-default" value="Valider" form="answerSheet">
   	   </div>
   	   <?php include('include/footer.php'); ?>
      </div>
   </body>
</html>
