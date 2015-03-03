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
	foreach ($groups as $a){
			foreach ($a->answers() as $aa){
				foreach ($aa as $aaaaa){
					var_dump($aaaaa->elementsValues());
				}
			}
	}
   }
?>