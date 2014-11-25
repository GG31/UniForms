<!doctype html>
<head>
<meta charset="UTF-8">
<title>UniForms</title>
<link rel="shortcut icon" href="../res/img/favicon.png" />
<link rel="stylesheet" href="../lib/bootstrap-3.3.1/min.css" type="text/css" />
<link rel="stylesheet" href="../css/styles.css" type="text/css" />

<script src="../lib/jquery-2.1.1/min.js"></script>
<script src="../lib/bootstrap-3.3.1/min.js"></script>

</head>
<body>
   <?php
      session_start ();
   ?> 
	<div class="container">
      <div class="row">
         <?php include('include/header.php'); ?>
      </div>
      <div class="row">
		   <?php include('include/nav.php'); ?>
      </div>
      
      <div class="row">
         <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><B>Formulaire</B></h3>
               </div>
               <div class="panel-body">
                  <form class="form-horizontal" role="form" action="ajouter_form_user.php" method="post" id="formCreation">
                  
                     <div class="form-group">
                        <label>Questions...</label><br>
                     </div>
                     
                  </form>
               </div>
            </div>
         </div>
	   </div>
	   
	   <div class="row">
	      <div class="col-sm-offset-2 col-sm-8">
	         <input type="submit" class="btn btn-default" value="Enregistrer" form="formDestinataire formCreation">
		      <input type="submit" class="btn btn-default" value="Valider" form="formDestinataire formCreation">
		   </div>
	   </div>
               <!--$random = substr( md5(rand()), 0, 7);
         //echo $random;
         $_SESSION['id_form'] = $random;
          *
          */

         // echo $_SESSION['user'];-->
         
      <div class="row">
	      <?php include('include/footer.php'); ?>
      </div>
   </div>
</body>
</html>
