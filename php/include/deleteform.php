<?php
   //Verify access
   include_once 'includes.php';
   $form = new Form($_GET["form_id"]);
   $form->deleteForm();
   header("Location: ../home.php" );
?>
