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
		<link rel="stylesheet" media="print" href="../css/print.css" type="text/css" />
		<link rel="shortcut icon" href="../res/img/favicon.png" />
		<link rel="stylesheet" href="../lib/bootstrap-3.3.1/css/min.css"
			type="text/css" />
		<link rel="stylesheet" href="../css/styles.css" type="text/css" />
		<link rel="stylesheet" href="../css/drag.css" type="text/css" />
		<link rel="stylesheet" href="../lib/jquery-2.1.1/jquery-ui.css" type="text/css" />
      <style>
		  .thumb {
		    height: 75px;
		    border: 1px solid #000;
		    margin: 10px 5px 0 0;
		  }
		</style>
		<script src="../lib/jquery-2.1.1/min.js"></script>
		<script src="../lib/jquery-2.1.1/jquery-ui.js"></script>

		<script src="../lib/bootstrap-3.3.1/js/min.js"></script>
	
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
			console.log('xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');	

			</script>
			
   <script type="text/javascript">
   $(document).ready(function() {
	   $(window).keydown(function(event){
	     if(event.keyCode == 13) {
	       event.preventDefault();
	       return false;
	     }
	   });
	 });
   </script>
   
   <script type="text/javascript">
  	 	copiedest = function() {
			//alert($('#display').val());
			if($('#display').val()) {
				newdest = $('<div class="input-group"><span class="input-group-addon"><input id="user'+$("#destinataires option[value=\'"+$("#display").val()+"\']").attr("userid")+'" type="checkbox" checked name="recipient[]" value="'+$("#destinataires option[value=\'"+$("#display").val()+"\']").attr("userid")+'"></span><label class="form-control" for="user'+$("#destinataires option[value=\'"+$("#display").val()+"\']").attr('userid')+'">'+$("#display").val()+'</label></div>');
				$('#listdest').append(newdest);
				//console.log($("#destinataires option[value=\'"+$('#display').val()+"\']").attr('userid'));
			}
		}
  	 	deldest = function(destuser) {
  	  	 	$("#" + destuser).remove();
  	  	}
   </script>
	</head>
	<body>
		<div class="container">
		<div id="body">
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
			<!-- <div id="bgWrap">
					<div id='preview'>
					</div>
					<form id="uploadForm" method="post" enctype="multipart/form-data" action='ajaximage.php'>
						Sélectionner les images à télécharger : 
						<div id='uploadStatus' style='display:none'><img src="../img/loader.gif" alt="Uploading...."/></div>
						
						<div id='imgUploadBtn'>
							<input type="file" multiple="multiple" name="imgUpload[]" id="imgUpload" accept="image/*" />
						</div>
						<div class="info">Taille maximale de l'image : <b>500 </b>ko</div>
					</form>
			</div>-->
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
							  <input list="destinataires" id="display" name="destinataire">
							  <datalist id="destinataires">
		                        <?php
									$users = User::all ();
									foreach ( $users as $user ) {
								?>
											<option
												value=<?php echo '"'.$user->getName().'"' ?>
												userid=<?php echo '"'.$user->getId().'"' ?>
											/>
		                        <?php
									}
								?>
							  </datalist>
							  <button type="button" class="btn btn-default btn-sm" onclick="copiedest()">
                       			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                   			  </button>
                   			  <span id="listdest">
                   			  <?php 
                   			  	 $exist_dest = $form->getFormRecipients();
                   			 	 if (!empty($exist_dest)){
                   			 	 	foreach ($exist_dest as $d){
                   			  ?>
                   			  <div class="input-group">
									<span class="input-group-addon">
										<input
											id="user<?php echo $d['User']->getId(); ?>"
											type="checkbox"
											name="recipient[]"
											value=<?php echo $d['User']->getId(); ?>
											<?php //echo $user->isDestinataire($form_id) ? "CHECKED" : "" ?>
											checked>
									</span>
									<label
										class="form-control"
										for="user<?php echo $d['User']->getId(); ?>">
										<?php echo $d['User']->getName(); ?>
									</label>
								</div>
								<?php 
									}
								}
								?>
                   			  </span>
	                    	</div>
						</div>
						
						<!-- ======================CE QU'A ETE AVANT===================== -->
						<!-- <div id="dest" class="panel-body" style="<?php //echo $destStyle ?>">
							<div class="form-group"> -->
	                        <?php
								//$users = User::all ();
								//foreach ( $users as $user ) {
							?>
								<!-- <div class="input-group">
									<span class="input-group-addon">
										<input
											id="user<?php //echo $user->getId() ?>"
											type="checkbox"
											name="recipient[]"
											value=<?php //echo $user->getId() ?>
									<?php //echo $user->isDestinataire($form_id) ? "CHECKED" : "" ?>
											> -->
									</span>
									<!--  <label
										class="form-control"
										for="user<?php //echo $user->getId() ?>">
										<?php //echo $user->getName() ?>
									</label>
								</div>-->
	                        <?php
								//}
							?>
	                    	<!-- </div>
						 </div>-->
						<!-- =========================================== -->
						
					</div>
				</div></div>
				
				<div id="navbarGroups" class="nav navbar-nav navbar-right"> 
				   <div class="panel panel-default" style="padding:10px"> 
				   <div class="panel panel-primary">
						<div class="panel-heading text-center text-capitalize">
							<h3 class="panel-title">
								<strong>Groupe</strong>
							</h3>
						</div>
						<div class="panel-body">
						   <div id="groupSection">
						      <div class="row" id="group_0">
							      <div class="panel panel-default col-sm-8">
						            <div class="panel-body">
                                 <div class="groupElements">
                                 </div>
                              </div>
                           </div>
                           <button type="button" class="btn btn-default btn-lg" onclick="getGroupsAndElements()">
                                 <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                           </button>
                           <button type="button" class="btn btn-default btn-lg" onclick="lessGroup('group_0')">
                                 <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                           </button>
                        </div>
                     </div>
                     <button type="button" class="btn btn-default btn-lg" onclick="moreGroup()">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                     </button>
						</div>
					</div>
				   </div><!--panel default-->
            </div><!--Navbar-->
				
				<div id="navbarElements" class="nav navbar-nav navbar-right"> 
				   <div class="panel panel-default" style="padding:10px">     
                  <div class="draggable" id="draggableLabel" draggable="true"><span>Label</span></div>
                  <div class="draggable" id="draggableNumber" draggable="true"><span>Nombre</span></div>
                  <div class="draggable" id="draggableDate" draggable="true"><span>Date</span></div>
                  <div class="draggable" id="draggableTime" draggable="true"><span>Heure</span></div>
                  <div class="draggable" id="draggableTextarea" draggable="true"><span>Paragraphe</span></div>
                  <div class="draggable" id="draggableTel" draggable="true"><span>Téléphone</span></div>
                  <div class="draggable" id="draggableText" draggable="true"><span>Input Text</span></div>
                  <div class="draggable" id="draggableRadio" draggable="true"><span>Boutons radio</span></div>
                  <div class="draggable" id="draggableCheckbox" draggable="true"><span>Checkbox</span></div>
                  <div class="draggable" id="draggableSquare" draggable="true"><span>Carre</span></div>
                  <div class="draggable" id="draggableCircle" draggable="true"><span>Cercle</span></div>
                  <div class="draggable" id="draggableImg" draggable="true"><span>Image</span></div>
                  
                        
                  <div class="panel panel-default">
                     <div id="divDetail" class="panel-body">
                        <div id="checkboxRequiredGroup">
                           <input type="Checkbox" id="checkboxRequired"> Required
                        </div>
                        <div id="labelGroup">
                           Label <input type="Textbox" id="inputLabelValue">
                        </div>
                        <div id="sizeGroup">
                           Width <input type="Number" id="inputWidthValue" step="1"><br>
                           Height <input type="Number" id="inputHeightValue" step="1">
                        </div>
                        <div id="fileGroup"><input type="file" id="files"/><br/></div>
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
                        </div><!--valuesGroup-->
                     </div><!--divDetail-->
                  </div><!--panel default-->
               </div><!--panel default-->
            </div><!--Navbar-->
				
         <div class="row">
			   <div>
					<!-- class="col-sm-10" -->
					<div id= "panelPanneau" class="panel panel-primary">
					   <div class="panel-heading text-center text-capitalize">
						   <h3 class="panel-title">
								<strong>Formulaire : </strong> <span contentEditable="true" id="formName">Click to add form name</span><input id="infoFormName" name="infoFormName" type="hidden">
							</h3>
						</div>
						<div class="panel-body">
						   <div class="panel panel-default">
						      <div id="contentOfPanneau" class="panel-body">
                           <div id="panneau" >
                           </div>
                        </div>
                     </div>
		               </div><!--panel-body-->
						</div><!--panel-primary-->
					</div>
				</div><!--row-->
				
				
				
				<div class="row" onload="newFormModel();">
					<div class="col-sm-offset-3 col-sm-6">
					   <input id="info" name="info" type="hidden">
                  <input id="infoGroups" name="infoGroups" type="hidden">
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
	        <div id="footer"><?php include 'include/footer.php'; ?></div>
	    </div>
	</body>
</html>
<script src="../js/drag.js"></script>
<script src="../js/group.js"></script>
<script src="../js/includeFile.js"></script>
<script>
   $(function () {
      $('[data-toggle="tooltip"]').tooltip()
   });
   //Récupère les éléments du formulaire si modification
   var formname = <?php echo '"'.$form->getName().'"' ?>;
   init(formname);
<?php
   $elems = $form->getFormElements();

   foreach ($elems as $elem) {
      $json = json_encode($elem->getAll(), true);
?>
      var element = <?php echo $json ?>;
      var elemId = "elem_" + element.id;
      addElement(element.type , element.x, element.y, ids, elemId);
      addProp(elemId, element.type, element.minvalue, element.maxvalue, element.default, element.required, element.width, element.height, element.placeholder, element.direction, element.big, element.options, element.label, element.img);
<?php
   }
?>
   var i = 0;
<?php   
   $groups = $form->getFormGroups(); 
   foreach ($groups as $group) {
?>
      if (i != 0) {
         moreGroup();
      }
      i = i + 1;
<?php
      $elementsOnGroup = $group->getGroupElements();
      foreach ($elementsOnGroup as $elementOnGroup) {
?>
         var elementId = "elem_" + <?php echo $elementOnGroup->getId(); ?>;
         var elementLabel = <?php echo "'".$elementOnGroup->getLabel()."'"; ?>;
         if (elementLabel == "") {
            elementLabel = elementId;
         }
         appendToGroup($('#groupSection .groupElements:last'), elementId, elementLabel);
<?php
      }
   }
?>
   //});
   </script>
<!--<script src="../js/navbar.js"></script> Retract nav-->
