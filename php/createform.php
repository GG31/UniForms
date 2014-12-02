<!doctype html>
<?php include_once 'include/includes.php'; ?>
<?php
/*
 * $_GET["form_id"] =>
 * $_POST["form_id"] == $_GET["form_id"] (already existing form)
 * XXXXXXXXXXXXXXXX =>
 * $_POST["form_id"] == -1 (new form)
 */
$form_id = isset ( $_GET ["form_id"] ) ? $_GET ["form_id"] : - 1;
$form = new Form ( $form_id );

$checkedAnon = FALSE;
$checkedPrint = TRUE;
if (isset ( $_GET ["form_id"] )) {
	$checkedAnon = $form->getAnonymous ();
	$checkedPrint = $form->getPrintable ();
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
<link rel="stylesheet" href="../css/drag.css" type="text/css" />

<script src="../lib/jquery-2.1.1/min.js"></script>
<script src="../lib/bootstrap-3.3.1/min.js"></script>
<script src="../js/drag.js"></script>
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
         })
		</script>
</head>
<body>
	<div class="container">
			<?php include 'include/header.php'; ?>
			<?php include 'include/nav.php'; ?>
			<?php
			if ($form->getState () == TRUE) {
				?>
					<div class="alert alert-warning text-center" role="alert">Ce
			formulaire a déjà été validé !</div>
			<?php
			}
			?>
			<form id="formulaire" class="form-inline" role="form"
			action="include/add_form.php" method="post">
			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading text-center text-capitalize">
						<h3 class="panel-title">
							<strong>Paramètres</strong>
						</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<input id="print" type="checkbox" value="print" name="param[]"
								<?php echo $checkedPrint ? "CHECKED" : "" ?>> <label for="print">Imprimable</label>
							<input id="anon" type="checkbox" value="anon" name="param[]"
								<?php echo $checkedAnon ? "CHECKED" : "" ?>> <label for="anon">Anonyme</label>
							<input id="multiple" type="number" name="parammulti" value="1"
								min="0" class="form-control bfh-number" data-toggle="tooltip"
								data-placement="top"
								title="Entrez le nombre de fois que le formulaire pourra être rempli par le(s) destinataire(s), 0 pour infini">
							<label for="multiple">Autorisation de remplissage</label> <br>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
					<?php
					$destClass = "panel-";
					$destClass .= $checkedAnon ? "default " : "primary ";
					$destStyle = $checkedAnon ? "display:none;" : "";
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
								<span class="input-group-addon"> <input
									id="user<?php echo $user->getId() ?>" type="checkbox"
									name="recipient[]" value=<?php echo $user->getId()?>
									<?php echo $user->isDestinataire($form_id) ? "CHECKED" : "" ?>>
								</span> <label class="form-control"
									for="user<?php echo $user->getId() ?>">
										<?php echo $user->getName()?>
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
								<strong>Formulaire</strong>
							</h3>
						</div>
						<div class="panel-body">
						
						<div class="panel panel-default">
                     <div class="panel-body col-sm-10">
                        <div id="destinationDraggables" class="zoneDrop" name="zoneDrop" ondragenter="return dragEnter(event)" 
        ondrop="return dragDrop(event)" 
        ondragover="return dragOver(event)" ondragleave="return dragLeave(event)"></div>
                     </div>
                     <div class="col-sm-2">
            
                        <div id="draggable" class="draggable" draggable="true" ondragstart="return dragStart(event)"><input type="checkbox" name="checkbox">Checkbox</div>
                        <div id="draggable2" class="draggable" draggable="true" ondragstart="return dragStart(event)"><input type="textbox" name="textBox"></div>
                        
                     </div> 
                  </div>
						
						
						
						</div>
					</div>
				</div>
				<!--<div class="col-sm-2">
						<div class="panel panel-primary">
							<div class="panel-heading text-center text-capitalize">
								<h3 class="panel-title">
									<B>Éléments</B>
								</h3>
							</div>
							<div class="panel-body">
								Text<br>
								Paragraphe<br>
								Liste<br>
								...
							</div>
						</div>
					</div>-->
			</div>
			<div class="row">
				<div class="col-sm-offset-3 col-sm-6">
					<input type="hidden" name="form_id" value=<?php echo $form_id ?>> <input
						type="submit" class="btn btn-default btn-lg btn-block"
						value="Enregistrer" name="save" form="formulaire"
						<?php echo $form->getState() ? "DISABLED" : "" ?>> <input
						type="submit" class="btn btn-primary btn-lg btn-block"
						value="Valider" name="send" form="formulaire"
						<?php echo $form->getState() ? "DISABLED" : "" ?>>
				</div>
			</div>
		</form>
	        <?php include 'include/footer.php'; ?>
	    </div>
</body>
</html>
