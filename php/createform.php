<!doctype html>
<?php include_once 'include/includes.php'; ?>
<?php
	/*
		$_GET["form_id"] =>
			$_POST["form_id"] == $_GET["form_id"] (already existing form)
		XXXXXXXXXXXXXXXX =>
			$_POST["form_id"] == -1 (new form)
	 */
	$form_id 	= isset($_GET["form_id"]) ? $_GET["form_id"] : -1;
	$form 		= new Form($form_id);

	$checkedAnon  	= FALSE;
	$checkedPrint 	= TRUE;
	$maxAnswers 	= 1;
	if(isset($_GET["form_id"])){
		$checkedAnon 	= $form->getAnonymous();
		$checkedPrint 	= $form->getPrintable();
		$maxAnswers   	= $form->getMaxAnswers();
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
		<link rel="stylesheet" href="../css/drag.css" type="text/css" />

		<script src="../lib/jquery-2.1.1/min.js"></script>
		<script src="../lib/bootstrap-3.3.1/js/min.js"></script>
		<script src="../js/elemsCreateForm.js"></script>
		
		<script>
			$(document).ready(function(){
				$('#anon').on('change', function() {
					if($(this).is(':checked')){
						$( "#dest" ).hide("slow", function(){
							$(this).parent().removeClass("panel-primary");
							$(this).parent().addClass("panel-default");
						});
						$("#dest input").prop("disabled", true);
					}else {
						$( "#dest" ).show("slow", function(){
							$(this).parent().removeClass("panel-default");
							$(this).parent().addClass("panel-primary");
						});
						$("#dest input").prop("disabled", false);
					}
				});	
			});	
			$(function () {
	        	$('[data-toggle="tooltip"]').tooltip()
	        });
		//Récupère les éléments du formulaire si modification

         elems = [];
         var formname = <?php echo '"'.$form->getName().'"' ?>;
         <?php
            $elems = $form->getFormElements();
            foreach ($elems as $elem) {
               $json = json_encode($elem->getAll());
               
         ?>
                  elems.push(
                     new Element(<?php echo $json ?>)
                        
                  );
         <?php
            }
         ?>
      //});
      

   </script>
	</head>
	<body>
		<div class="container">
			<?php include 'include/header.php'; ?>
			<?php include 'include/nav.php'; ?>
			<?php
				if($form->getState() == TRUE){
			?>
					<div class="alert alert-warning text-center" role="alert">
						Ce formulaire a déjà été validé !
					</div>
			<?php
				}
			?>
			<form
				id="formulaire"
				class="form-inline"
				role="form"
				action="include/add_form.php"
				method="post">
				<div class="row">
					<div class="panel panel-primary">
						<div class="panel-heading text-center text-capitalize">
							<h3 class="panel-title">
								<strong>Paramètres</strong>
							</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<input
									id="print"
									type="checkbox"
									value="print"
									name="param[]"
									<?php echo $checkedPrint ? "CHECKED" : "" ?>
									>
								<label for="print">Imprimable</label>
								<input
									id="anon"
									type="checkbox"
									value="anon"
									name="param[]"
									<?php echo $checkedAnon ? "CHECKED" : "" ?>
									>
								<label for="anon">Anonyme</label>
								<input 
								   id = "multiple"
								   type="number" 
								   name="parammulti"
								   value=<?php echo $maxAnswers ?>
								   min="0"
								   class="form-control bfh-number"
								   style="width: 50pt;"
								   data-toggle="tooltip" 
								   data-placement="top" 
								   title="Entrez le nombre de fois que le formulaire pourra être rempli par le(s) destinataire(s), 0 pour infini">
								<label for="multiple">Nombre de réponses max.</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<?php
						$destClass 	= "panel-";
						$destClass .= $checkedAnon ? "default " : "primary ";
						$destStyle  = $checkedAnon ? "display:none;" : "";
					?>
					<div class="panel <?php echo $destClass ?>">
						<div class="panel-heading text-center text-capitalize">
							<h3 class="panel-title">
								<strong>Destinataires</strong>
							</h3>
						</div>
						<div id="dest" class="panel-body" style="<?php echo $destStyle ?>">
							<div class="form-group">
	                        <?php
								$users = User::all ();
								foreach ( $users as $user ) {
							?>
								<div class="input-group">
									<span class="input-group-addon">
										<input
											id="user<?php echo $user->getId() ?>"
											type="checkbox"
											name="recipient[]"
											value=<?php echo $user->getId() ?>
	<?php echo $user->isDestinataire($form_id) ? "CHECKED" : "" ?>
											>
									</span>
									<label
										class="form-control"
										for="user<?php echo $user->getId() ?>">
										<?php echo $user->getName() ?>
									</label>
								</div>
	                        <?php
								}
							?>
	                    	</div>
						</div>
					</div>
				</div>
				
         <div class="row">
			   <div>
					<!-- class="col-sm-10" -->
					<div class="panel panel-primary">
					   <div class="panel-heading text-center text-capitalize">
						   <h3 class="panel-title">
								<strong>Formulaire : </strong> <span contentEditable="true" id="formName">Click to add form name</span><input id="infoFormName" name="infoFormName" type="hidden">
							</h3>
						</div>
						<div class="panel-body">
						   <div class="panel panel-default col-sm-8">
						      <div class="panel-body">
                           <div id="panneau" ondrop="drop(event)" ondragover="allowDrop(event)">
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="draggable" id="draggableLabel" draggable="true"><span>Text</span></div>
                        <div class="draggable" id="draggableNumber" draggable="true"><input type="number"></div>
                        <div class="draggable" id="draggableDate" draggable="true"><input type="text" id="datepicker" placeholder="jj/mm/aaaa"/></div>
                        <div class="draggable" id="draggableTime" draggable="true"><input id="timepicker" type="time" placeholder="hh:mm"/></div>
                        <div class="draggable" id="draggableTextarea" draggable="true"><textarea rows="4" cols="40"></textarea></div>
                        <div class="draggable" id="draggableTel" draggable="true"><input type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" placeholder="06xxxxxxxx"></div>
                        
                        <div class="draggable" id="draggable1" draggable="true"><input name="input_text"
  type="text" class="form-control"></div>
                        <div class="draggable" id="draggable4" draggable="true"><fieldset><input type="radio"> <span>radio<span></fieldset></div>
                        <div class="draggable" id="draggableCheckbox" draggable="true"><fieldset><input type="checkbox"> <span>checkbox<span></fieldset></div>
  
                        
                        <input id="info" name="info" type="hidden">
                     
                        <div class="panel panel-default">
                          <div id="divDetail" class="panel-body">
                            <div id="checkboxRequiredGroup">
                              <input type="Checkbox" id="checkboxRequired"> Required
                            </div>
                            <div id="labelGroup">
                              Label <input type="Textbox" id="inputLabelValue">
                            </div>
                            <div id="defaultValueGroup">
                              Default Value<input type="Textbox" id="inputdefaultValue">
                            </div>
                            <div id="inputValueGroup">
                            Value <input type="Text" id="inputValue">
                            </div>
                            <div id="inputNumberGroup">
                            Min <input type="number" id="inputNumberMin"><br>
                            Max <input type="number" id="inputNumberMax">
                            </div>
                            <div id="valuesGroup">
                            Values <button type="button" id="moreValues" class="btn btn-default btn-lg">
  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
</button>
<br><div><input type="Text" class="valueItem" id="valueItem_0" onchange="valueItemChange(0)"><button type="button" id="lessValues_0" class="btn btn-default btn-lg valueItemLess" onclick="valueItemLess(0)"><span>-</span></button></div><br>
                            
                            </div>
                            
                          </div>
                        </div>
		               </div>
						</div>
					</div>
				</div>
				<div class="row" onload="newFormModel();">
					<div class="col-sm-offset-3 col-sm-6">
						<input type="hidden" name="form_id" value=<?php echo $form_id ?>>
						<input
							type="submit"
							class="btn btn-default btn-lg btn-block"
							value="Enregistrer"
							name="save"
							form="formulaire"
							onclick="sendJson()"
							<?php echo $form->getState() ? "DISABLED" : "" ?>
							>
						<input
							type="submit"
							class="btn btn-primary btn-lg btn-block"
							value="Valider"
							name="send"
							form="formulaire"
							onclick="sendJson()"
							<?php echo $form->getState() ? "DISABLED" : "" ?>
							>
					</div>
				</div>
			</form>
	        <?php include 'include/footer.php'; ?>
	    </div>
	</body>
</html>
<script src="../js/drag.js"></script>
<script>init()</script>
