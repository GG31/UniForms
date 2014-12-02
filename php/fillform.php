<!doctype html>
<?php include_once 'include/includes.php'; ?>
<?php
   // TODO access !!
   if(isset($_GET["form_id"])){     // New answer
      $form_id = $_GET["form_id"];
      $state = FALSE;
      $new = TRUE;
   }
   if(isset($_GET["ans_id"])){      // Load answer
      $ans_id = $_GET["ans_id"];
      $ans = new Answer($ans_id);
      $form_id = $ans->getFormId();
      $state = $ans->getState();
      $new = FALSE;
   }
?>
<html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="../res/img/favicon.png" />
<link rel="stylesheet" href="../lib/bootstrap-3.3.1/min.css"
	type="text/css" />
<link rel="stylesheet" href="../css/styles.css" type="text/css" />

<script src="../lib/jquery-2.1.1/min.js"></script>
<script src="../lib/bootstrap-3.3.1/min.js"></script>
</head>
<body>
	<div class="container">
         <?php include 'include/header.php'; ?>
  		   <?php include 'include/nav.php'; ?>
         <?php

            if($state == TRUE){
         ?>
               <div class="alert alert-warning text-center" role="alert">
			Ce formulaire a déjà été renvoyé !</div>
         <?php
									}
									?>
         <div class="row">

            <div class="panel panel-primary">
               <div class="panel-heading text-center text-capitalize">
                  <h3 class="panel-title"><strong>Formulaire <?php echo $form_id ?></strong></h3>
               </div>
               <div class="panel-body">
                  <form id="answerSheet" role="form" action="include/fill_form.php" method="post">
                  </form>
               </div>
            </div>
   	   </div>
         <div class= "row">
            <div class="col-sm-offset-3 col-sm-6">
               <input
                  type="hidden"
                  name=<?php echo $new ? "form_id" : "ans_id" ?>
                  form="answerSheet"
                  value=<?php echo $new ? $form_id : $ans_id ?>
                  >
               <input
                  type="submit"
                  class="btn btn-default btn-lg btn-block"
                  value="Enregistrer"
                  name="save"
                  form="answerSheet"
                  <?php echo $state ? "DISABLED" : "" ?>
                  >
               <input
                  type="submit"
                  class="btn btn-primary btn-lg btn-block"
                  value="Valider"
                  name="send"
                  form="answerSheet"
                  <?php echo $state ? "DISABLED" : "" ?>
                  >
            </div>
         </div>
   	   <?php include 'include/footer.php'; ?>
      </div>
</body>
</html>
