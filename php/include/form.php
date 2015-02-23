<?php
	include_once 'includes.php';

	if(!isset($_GET["form"]) && !isset($_GET["user"]))
		return;

	$formId = $_GET["form"];
	$userId = $_GET["user"];

	$user = new User($userId);
	$form = new Form($formId);

	// l($form);
	$groups = $form->groups();

	foreach($groups as $groupNum => $group){
		$answers = $group->answers();

		echo "groupNum ";
		echo $groupNum;
		echo "<br>";
		echo "groupLim ";
		$limit = $group->limit();
		echo $limit;
		echo "<br>--------------------<br>";

		foreach($answers as $uId => $answers){
			echo "userId ";
			echo $uId;
			echo "<br>";
			echo "count ";
			$count = count($answers);
			echo $count;
			echo "<br>";
			if($limit == 0){
				echo "Infiny!<br>";
			}else{
				echo "Remaining : " . ($limit - $count) . "<br>";
			}
			echo "<br>";
			l($answers);
			echo "<br>";
			if($uId == $userId){
				echo "C'est moi !";
				echo "<br>";
			}
		}
	}



	function l($obj){
		if(is_array($obj)){
			echo '<pre>';
			print_r($obj);
			echo '</pre>';
			return;
		}
		if(is_object($obj)){
			echo '<pre>';
			var_dump($obj);
			echo '</pre>';
			return;
		}
		echo $obj;
		return;
	}

?>