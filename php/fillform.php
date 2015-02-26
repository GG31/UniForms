<!doctype html>
<?php
   ini_set('display_errors', 1);
   error_reporting ( E_ALL );
   include_once 'include/includes.php';

   if(isset($_GET["form_id"]) && isset($_GET["formdest_id"]) && isset($_GET["prev_id"])){     // New answer
      $form_id    = $_GET["form_id"];
      $formdest_id= $_GET["formdest_id"];
      $prev_id    = $_GET["prev_id"];

      $form       = new Form($form_id);
      $state      = FALSE;
      $new        = TRUE;
   }
   
   if(isset($_GET["ans_id"])){      // Load answer
      $ans_id     = $_GET["ans_id"];

      $ans        = new Answer($ans_id);
      $prev_id    = $ans->prev();
      $form_id    = $ans->formId();

      $form       = new Form($form_id);
      $state      = $ans->state();
      $new        = FALSE;
   }
?>
<html>
<head>
   <meta charset="UTF-8">
   <title>UniForms</title>
   <link rel="shortcut icon" href="../res/img/favicon.png" />
   <link rel="stylesheet" href="../lib/bootstrap-3.3.1/css/min.css"
      type="text/css" />
   <link rel="stylesheet" href="../css/styles.css" type="text/css" />
   <?php
   if($form->printable()==FALSE){
      echo "<link rel='stylesheet' media='print' href='../css/notprint.css' type='text/css' />";
   }else {
      echo "<link rel='stylesheet' media='print' href='../css/print.css' type='text/css' />";
   }
?>

   <script src="../lib/jquery-2.1.1/min.js"></script>
   <script src="../lib/bootstrap-3.3.1/js/min.js"></script>
   <script src="../js/elems.js"></script>
</head>
<body>
   <script>
      $(document).ready(function(){
         elems    = [];
         
         <?php
            $groups = $form->groups();

            $prevs = [];
            $prev = $prev_id;

            if($new === FALSE){
               $prevs[] = $ans;
            }

            while($prev != 0){
               $ans     = new Answer($prev);
               $prevs[] = $ans;
               $prev    = $ans->prev();
            }

            $prevs = array_reverse($prevs);

            foreach ($groups as $groupNum => $group) {
               $elems = $group->elements();

               foreach ($elems as $elem) {
                  $json = json_encode($elem->attr());
         ?>
                  e = new Element(<?php echo $json ?>, '#answerSheet')
                        .answers(
                           <?php echo isset($prevs[$groupNum]) ?
                                    json_encode(
                                       $prevs[$groupNum]->values($elem->id())
                                    ) :
                                    "[]";
                           ?>
                        );
                  <?php
                     $in = $new ?
                              $group->in($formdest_id) :
                              $group->in(NULL, $ans_id);

                     echo !$in ?
                              "e.disable();" :
                              "";
                  ?>

                  elems.push(e);
         <?php
               }
            }
         ?>

         $('input[type=submit]').on('click', {elems: elems}, function(event){
            $('input[name=answers]').attr('value', JSON.stringify(getAnswers(elems)));
            // event.preventDefault();
         });

         <?php
            if($state == TRUE){
         ?>
            disableForm('#answerSheet');
         <?php
            }
         ?>
      });

   </script>
   	<div class="container">
         <?php include 'include/header.php'; ?>
  		   <?php include 'include/nav.php'; ?>
         <?php

            if($state == TRUE){
         ?>
               <div class="alert alert-warning text-center" role="alert">
			Ce formulaire a déjà été validé !</div>
         <?php
				}
			?>
         <div class="row">
            <div class="panel panel-primary">
               <div class="panel-heading text-center text-capitalize">
                  <h3 class="panel-title"><strong><?php echo $form->name() ?></strong></h3>
               </div>
               <div class="panel-body">
                  <form
                     id="answerSheet"
                     role="form"
                     action="include/fill_form.php"
                     method="post"
                     style="overflow:visible;height:493px;"
                     >
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
                  ><!-- TODO formid useful ?-->
               <input
                  type="hidden"
                  name="formdest_id"
                  form="answerSheet"
                  value=<?php echo $new ? $formdest_id : "" ?>
                  >
               <input
                  type="hidden"
                  name="prev_id"
                  form="answerSheet"
                  value=<?php echo $new ? $prev_id : "" ?>
                  >
               <input
                  type="hidden"
                  name="answers"
                  form="answerSheet"
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
