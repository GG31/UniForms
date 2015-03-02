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
	$form 		= new Form($form_id == -1 ? NULL : $form_id);

	$checkedAnon  	= FALSE;
	$checkedPrint 	= TRUE;
	// $maxAnswers 	= 1; // TODO ?
	$groupsUsers = [];
	$groupsLimit = [];

	if(isset($_GET["form_id"])){
		$checkedAnon 	= $form->anon();
		$checkedPrint 	= $form->printable();
		// $maxAnswers   	= $form->getMaxAnswers(); // TODO ?

		// Users by group, limit by group
		foreach ($form->groups() as $num => $group) {
			$groupsUsers[$num] = [];
			$groupsLimit[$num] = $group->limit();

			foreach ($group->users() as $user) {
				$groupsUsers[$num]["id"] = $user->id();
				$groupsUsers[$num]["name"] = $user->name();
			}
		}
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
				/////////////////////////////////////////////
				// Toggle recipient when toogling anon 	//
				/////////////////////////////////////////////
				$('#anon').on('change', function() {
					if($(this).is(':checked')){
						$( "#navbarGroups" ).hide("slow");
					}else {
						$( "#navbarGroups" ).show("slow");
					}
				});

				<?php 
					if ($form->anon() == TRUE){
					?>
						$('#anon').trigger('click');
					<?php 
				}
				?>
				//////////////////////////////////////////
				// Prevent validating form on ENTER //
				//////////////////////////////////////////
				$(window).keydown(function(event){
					if(event.keyCode == 13) {
						event.preventDefault();
						return false;
					}
				});

				/////////////////////////////////////////////
				// Recipient by groups (for the modal) //
				/////////////////////////////////////////////
				groupsUsers = <?php echo json_encode($groupsUsers) ?>;// TODO
				// console.log(groupsUsers);

				GROUPSUSERS = {
					// 'group_0': [
					// 		{'id': 1, 'name' : 'Romain'},
					// 		{'id': 2, 'name' : 'Ayoub'}
					// 	],
					// 'group_1': [
					// 		{'id': 1, 'name' : 'Romain'},
					// 		{'id': 2, 'name' : 'Ayoub'}
					// 	]
				};

				copiedest = function() {
					if($('#display').val()) {
					   $('#destinataires option').each(function() {
					      if($(this).attr('value') == $('#display').val()) {
						      id 		= $("#destinataires option[value=\'"+$("#display").val()+"\']").attr("userid");
						      name 	= $("#display").val();
						      $("#display").val('');
						      displayGroupUser(id, name);
						   }
						});
					}
				};

				removedestCB = function(){
					if(!$(this).prop('checked')){
						$(this).parent().siblings().remove();
						$(this).parent().remove();
					}
				};

				refreshGroupUsers = function(group){
					GROUPSUSERS[group] = [];

					$('#listdest input[id^=user]').each(function(index, element){
						GROUPSUSERS[group][index] = {
							'id'	: $(this).attr('id').substr(4),
							'name'	: $(this).parent().parent().children('label').text()
						};
					});

					// Safe !
					$('#listdest').empty();

					// Attach to POST
					$('#usersGroups').val(JSON.stringify(GROUPSUSERS));
				};

				displayGroupUser = function(id, name){
					group = $('<div class="input-group"></div>');
					addon = $('<span class="input-group-addon"></span>');
					checkbox = function(id){
						return $('<input />')
									.attr('id', 'user' + id)
									.attr('type', 'checkbox')
									.attr('name', 'recipient[]')
									.attr('value', 'user' + id)
									.prop('checked', true);
					};
					label = function(id, name){
						return $('<label></label>')
									.attr('class', 'form-control')
									.text(name);
					};

					$('#listdest').append(group.append(addon.append(checkbox(id))).append(label(id, name)));
					$('#user' + id).on('click', removedestCB);

				};

				displayGroupUsers = function(group){
					if(typeof GROUPSUSERS[group] == 'undefined'){
						GROUPSUSERS[group] = [];
					}
					users = GROUPSUSERS[group];

					$('#listdest').empty();
					users.forEach(function(val){
						displayGroupUser(val['id'], val['name']);
					});
				};

				$('#myModal').on('show.bs.modal', function (event) {
					// Button that triggered the modal
					button 	= $(event.relatedTarget);
					id 		= button.parent().attr('id');

					$('#modalOK').attr('data-group', id);
					displayGroupUsers(id);
				});

				$('#modalOK').on('click', function(){
					refreshGroupUsers($(this).attr('data-group'));
				})
			});
		</script>
	</head>
	<body>
		<div class="container">
		<div id="body">
			<?php include 'include/header.php'; ?>
			<?php include 'include/nav.php'; ?>
			<?php
				if($form->state() == TRUE){
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
									data-toggle="tooltip" 
								    data-placement="top" 
									title="Si le formulaire est imprimable alors les éléments seront arrangés de telle manière à ce qu’ils puissent être sur une page A4 physique.">
								<label for="print">Imprimable</label>
								<input
									id="anon"
									type="checkbox"
									value="anon"
									name="param[]"
									data-toggle="tooltip" 
								    data-placement="top" 
									title="Si le formulaire est anonyme, il ne sera pas nécessaire de se connecter pour répondre et les personnes pouvant répondre à ce formulaire sont ceux disposant du lien.">
								<label for="anon">Anonyme</label>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="myModalLabel">Ajouter des Destinataires</h4>
							</div>
							<!-- Modal body -->
							<div class="modal-body">
								<!-- Search input -->
								<input list="destinataires" id="display" name="destinataire">

								<!-- Autocompletion datalist -->
								<datalist id="destinataires">
									<?php
										$users = User::all ();
										foreach ( $users as $user ) {
									?>
									<option
										value=<?php echo '"'.$user->name().'"' ?>
										userid=<?php echo '"'.$user->id().'"' ?> />
									<?php
										}
									?>
								</datalist>
								<!-- Add recipient button -->
								<button type="button" class="btn btn-default btn-sm" onclick="copiedest()">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								</button>

								<!-- Recipient list -->
								<span id="listdest"></span>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
								<button id="modalOK" type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
							</div>
						</div>
					</div>
				</div>
				
				<div id="navbarGroups" class="nav navbar-nav navbar-right"> 
				   <div class="panel panel-default" style="padding:10px"> 
				   <div class="panel panel-primary">
						<div class="panel-heading text-center text-capitalize">
							<h3 class="panel-title">
								<strong>Groupes</strong>
							</h3>
						</div>
						<div class="panel-body">
							<div id="groupSection">
								<div class="row" id="group_0">
									<div class="panel panel-default col-sm-8">
										<div class="panel-body">
											Éléments restants
										</div>
									</div>
									<button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal">
										<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
									</button>
									<!-- TODO set multiple value on load !! -->
									<input 
										id = "group_0_multiple"
										type="number"
										name="group_0_multiple"
										value="1"
										min="0"
										class="form-control bfh-number"
										style="width: 40pt;"
										data-toggle="tooltip"
										data-placement="top"
										title="Entrez le nombre de fois que le formulaire pourra être rempli par le(s) destinataire(s), 0 pour infini">
									<!--<label for="multiple">Nombre de réponses max.</label>-->
								</div>
							</div>
							<button type="button" class="btn btn-default btn-lg" onclick="moreGroup(0)">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
							</button>
						</div>
					</div>
				   </div><!--panel default-->
            </div><!--Navbar-->
				
         <div class="row">
					<div id="panelPanneau" class="panel panel-primary">
					   <div class="panel-heading text-center text-capitalize">
						   <h3 class="panel-title">
								<strong>Formulaire : </strong> <span contentEditable="true" id="formName">Click to add form name</span><input id="infoFormName" name="infoFormName" type="hidden" />
							</h3>
						</div>
						<div class="panel-body ">
						   <div id="panelPanneauCol" class="panel panel-default col-sm-10">
						      <div id="contentOfPanneau" class="panel-body">
                           <div id="panneau" >
                           </div>
                        </div>
                        
                     </div>
                     
		               <div class="panel panel-default groupOfElements" style="padding:10px width:10px">     
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
                  </div><!--panel-body-->
				   </div><!--panel-primary-->
				</div><!--row-->
				
				<div class="row" onload="newFormModel();">
					<div class="col-sm-offset-3 col-sm-6">
						<input id="info" name="info" type="hidden">
						<input id="infoGroups" name="infoGroups" type="hidden">
						<input id="usersGroups" name="usersGroups" type="hidden">
						<input type="hidden" name="form_id" value="<?php echo $form_id ?>">
						<input
							type="submit"
							class="btn btn-default btn-lg btn-block"
							value="Enregistrer"
							name="save"
							form="formulaire"
							onclick="sendJson()"
							<?php echo $form->state() ? "DISABLED" : "" ?>
							>
						<input
							type="submit"
							class="btn btn-primary btn-lg btn-block"
							value="Valider"
							name="send"
							form="formulaire"
							onclick="sendJson()"
							<?php echo $form->state() ? "DISABLED" : "" ?>
							>
					</div>
				</div>
			</form>			
	        <?php include 'include/footer.php'; ?>
	    </div>
		<script src="../js/drag.js"></script>
		<script src="../js/group.js"></script>
		<script src="../js/includeFile.js"></script>
		<script type="text/javascript">
			(function(){
				$('[data-toggle="tooltip"]').tooltip()

				// TODO si modif only !
				formname = "<?php echo $form->name() ?>";
				init(formname);

				<?php
					$groups = $form->groups();
					$first = FALSE;

					if(count($groups)){
						foreach ($groups as $num => $group) {
							$elems = $group->elements();
				?>
							<?php echo !$first ? "moreGroup(" . $groupsLimit[$num] .");" : "" ?>
				<?php
							$first = TRUE;
							foreach ($elems as $elem) {
								$obj = $elem->attr();
								$obj = json_encode($obj, true);
				?>
								element = <?php echo $obj ?>;
								addElement(element.type,
									element.x,
									element.y,
									ids,	// TODO ????????????????????
									"elem_" + element.id
								);
								addProp("elem_" + element.id,
									element.type,
									element.min,
									element.max,
									element.default,
									element.required,
									element.width,
									element.height,
									element.placeholder,
									element.direction,
									element.big,
									element.options,
									element.label,
									element.img
								);
								appendToGroup($('#groupSection .groupElements:last'),
									"elem_" + element.id,
									element.label === "" ? "elem_" + element.id : element.label);
				<?php
							}
						}
					}
				?>
			})();
		</script>
	</body>
</html>
<script>
   // $(function () {
   //    $('[data-toggle="tooltip"]').tooltip()
   // });
   // //Récupère les éléments du formulaire si modification
   // var formname = <?php //echo '"'.$form->name().'"' ?>;
   // init(formname);
<?php
   // $elems = $form->getFormElements();

   // foreach ($elems as $elem) {
   //    $json = json_encode($elem->getAll(), true);
?>
      // var element = <?php //echo $json ?>;
      // var elemId = "elem_" + element.id;
      // addElement(element.type , element.x, element.y, ids, elemId);
      // addProp(elemId, element.type, element.minvalue, element.maxvalue, element.default, element.required, element.width, element.height, element.placeholder, element.direction, element.big, element.options, element.label, element.img);
<?php
   // }
?>
   // var i = 0;
<?php   
   // $groups = $form->getFormGroups(); 
   // foreach ($groups as $group) {
?>
      // if (i != 0) {
      //    moreGroup();
      // }
      // i = i + 1;
<?php
      // $elementsOnGroup = $group->getGroupElements();
      // foreach ($elementsOnGroup as $elementOnGroup) {
?>
         // var elementId = "elem_" + <?php //echo $elementOnGroup->getId(); ?>;
         // var elementLabel = <?php //echo "'".$elementOnGroup->getLabel()."'"; ?>;
         // if (elementLabel == "") {
         //    elementLabel = elementId;
         // }
         // appendToGroup($('#groupSection .groupElements:last'), elementId, elementLabel);
<?php
   //    }
   // }
?>
   //});
   </script>
<script src="../js/navbar.js"></script>
