<!doctype html>
<?php
   ini_set('display_errors', 1);
   error_reporting ( E_ALL );
   include_once 'include/includes.php';

   if(isset($_GET["ans_id"])){
      $ans_id     = $_GET["ans_id"];

      $ans        = new Answer($ans_id);
      $prev_id    = $ans->prev();
      $form_id    = $ans->formId();

      $form       = new Form($form_id);
      $groups     = $form->groups();
      $last       = count($groups) - 1;
      $users      = $groups[$last]->users();

      $previous   = FALSE;
      $next       = FALSE;
      $found      = FALSE;
      $foundNext  = FALSE;

      foreach ($users as $user) {
         $tree = $form->tree($user->id(), TRUE, [$last])[$last];
         foreach ($tree as $answers) {
            foreach ($answers as $key => $answer) {
               if($key === "left")
                  continue;
               if($found == TRUE){
                  if($foundNext == FALSE){
                     $next = $answer->id();
                     $foundNext = TRUE;
                  }
                  break;
               }
               if($answer->id() == $ans_id){
                  $found = TRUE;
               }else{
                  $previous = $answer->id();
               }
            }
         }
      }

      $chain = $form->chain($ans_id);
      $chainStr  = "";
      unset($chain[0]);
      foreach($chain as $key => $userId){
         $name = (new User($userId))->name();
         $chainStr .= $name . " -> ";
      }

      $chain = substr($chainStr, 0, strlen($chainStr) - 4);
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
   <style type="text/css">
      #answerSheet{
         border: 1px solid black;
         width: 794px;
         height: 1122px;
      }
      .square {
         width:200px;
         height:200px;
         background:transparent;
         border: 2px solid black;
      }
      .circle{
         width:200px;
         height:200px;
         background:transparent;
         border: 2px solid black;
         -webkit-border-radius:100px;
         -moz-border-radius:100px;
         -o-border-radius:100px;
         border-radius:100px;
      }
   </style>
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
            $prevs[] = $ans;

            while($prev != 0){
               $ans     = new Answer($prev);
               $prevs[] = $ans;
               $prev    = $ans->prev();
            }

            $prevs = array_reverse($prevs);
            $maxBottom = 0;

            foreach ($groups as $groupNum => $group) {
               $elems = $group->elements();

               foreach ($elems as $elem) {
                  $attr = $elem->attr();
                  $bottom = $attr["y"] + $attr["height"] + (strlen($attr["label"]) > 0 ? 25 : 0) + count($attr["options"])*25;
                  $maxBottom = max($maxBottom, $bottom);

                  $json = json_encode($attr);
         ?>
                  json = <?php echo $json ?>;
                  json.x = parseInt(json.x) + parseInt($('#answerSheet').offset().left);
                  json.y = parseInt(json.y) + parseInt($('#answerSheet').offset().top);

                  console.log($('#answerSheet').offset().top);
                  console.log($('#answerSheet').offset().left);
                  console.log(json);

                  e = new Element(json, '#answerSheet')
                        .answers(
                           <?php echo isset($prevs[$groupNum]) ?
                                    json_encode(
                                       $prevs[$groupNum]->values($elem->id())
                                    ) :
                                    "[]";
                           ?>
                        );
                  elems.push(e);
         <?php
               }
            }
         ?>

         // Set height of answer sheet
         $('#answerSheet').css('height', "<?php echo $maxBottom + 5 ?>px");
         
         disableForm('#answerSheet');

         <?php
            if($previous === FALSE){
         ?>
               $('#previous a').click(function(event){
                  event.preventDefault();
                  event.stopPropagation();
                  return false;
               });
         <?php
            }
            if($next === FALSE){
         ?>
               $('#next a').click(function(event){
                  event.preventDefault();
                  event.stopPropagation();
                  return false;
               });
         <?php
            }
         ?>
      });

   </script>
   	<div class="container">
         <span id="header"><?php include 'include/header.php'; ?></span>
  		   <span id="nav"><?php include 'include/nav.php'; ?></span>
         <div class="row">
            <div class="panel panel-primary">
               <div class="panel-heading text-center text-capitalize">
                  <h3 class="panel-title"><strong><?php echo $form->name() . " : " . $chain ?></strong></h3>
               </div>
               <div class="panel-body">
                  <form
                     id="answerSheet"
                     class="center-block"
                     style="overflow:visible;"
                     >
                  </form>
               </div>
            </div>
   	   </div>
         <div class="row">
            <nav>
               <ul class="pager">
                  <?php

                     $linkPrevious  = "#";
                     $linkNext  = "#";
                     $classPrevious = "class='disabled'";
                     $classNext = "class='disabled'";

                     if($previous !== FALSE){
                        $linkPrevious  = "formresult.php?ans_id=" . $previous;
                        $classPrevious = "";
                     }
                     if($next !== FALSE){
                        $linkNext      = "formresult.php?ans_id=" . $next;
                        $classNext     = "";
                     }
                  ?>

                  <li id="previous" <?php echo $classPrevious ?>><a href="<?php echo $linkPrevious ?>">&larr; Previous</a></li>
                  <li><a href="results.php?form=<?php echo $form_id; ?>">&uarr; Back &uarr;</a></li>
                  <li id="next" <?php echo $classNext ?>><a href="<?php echo $linkNext ?>">Next &rarr;</a></li>
               </ul>
            </nav>
         </div>
   	  	<span id="footer"><?php include 'include/footer.php'; ?></span>
      </div>
</body>
</html>
