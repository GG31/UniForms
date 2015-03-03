<?php
	ini_set('display_errors', 1);
	error_reporting ( E_ALL );
	include_once 'includes.php';

	if(isset($_GET["form"])){
		$csv = toCSV(formValuesTable($_GET["form"]));
	}elseif(isset($_GET["ans"])){
		$csv = toCSV(ansValuesTable($_GET["ans"]));
	}

	function formValuesTable($formId){
		$form = new Form($formId);
		$groups = $form->groups();
		$last = count($groups) - 1;
		$users = $groups[$last]->users();

		$valuesTable = [];
		// $valuesTable[*elem id*] = [
		// 	"label" => "",
		// 	"values" => []
		// ];
		$doneAnswers = []; // ids

		foreach ($users as $user) {
			$tree = $form->tree($user->id(), TRUE, [$last])[$last];

			foreach ($tree as $prevAnsId => $ansArr) {

				foreach ($ansArr as $key => $ans) {
					if($key === "left")
						continue;

					$prevs = [];
					$prevs[] = $ans;
					$prev = $prevAnsId;

					while($prev != 0){
						$ans = new Answer($prev);
						$prevs[] = $ans;
						$prev = $ans->prev();
					}

					$prevs = array_reverse($prevs);

					foreach ($groups as $groupNum => $group) {

						foreach ($group->elements() as $elem) {
							if(!in_array($prevs[$groupNum]->id(), $doneAnswers)){
								if(!isset($valuesTable[$elem->id()])){
									$valuesTable[$elem->id()] = [
										"label" => $elem->label(),
										"values" => []
									];
								}

								$valuesTable[$elem->id()]["values"][] = $prevs[$groupNum]->values($elem->id());

								$doneAnswers[] = $prevs[$groupNum]->id();
							}
						}
					}
				}
			}
		}

		return array_merge($valuesTable, []);
	}

	function ansValuesTable($ansId){
		$ans = new Answer($ansId);
		$prevAnsId = $ans->prev();
		$groups = (new Form($ans->formId()))->groups();

		$valuesTable = [];
		// $valuesTable[*elem id*] = [
		// 	"label" => "",
		// 	"values" => []
		// ];

		$prevs = [];
		$prevs[] = $ans;
		$prev = $prevAnsId;

		while($prev != 0){
			$ans = new Answer($prev);
			$prevs[] = $ans;
			$prev = $ans->prev();
		}

		$prevs = array_reverse($prevs);

		foreach ($groups as $groupNum => $group) {

			foreach ($group->elements() as $elem) {
				if(!isset($valuesTable[$elem->id()])){
					$valuesTable[$elem->id()] = [
						"label" => $elem->label(),
						"values" => []
					];
				}

				$valuesTable[$elem->id()]["values"][] = $prevs[$groupNum]->values($elem->id());
			}
		}

		return array_merge($valuesTable, []);
	}

	function toCSV($valuesTable){
		$matrix = [];

		foreach ($valuesTable as $key => $elem) {
			$matrix[$key] = [];
			$matrix[$key][] = $elem["label"];

			foreach ($elem["values"] as $values) {
				$cell = "";

				foreach ($values as $value) {
					$cell .= trim($value) . "|";
				}

				$cell = substr($cell, 0, strlen($cell) - 1);
				$matrix[$key][] = $cell;
			}
		}

		$matrix = invert($matrix);

		$csv = "";
		$li = count($matrix);

		for($i = 0; $i < $li; $i++){
			$lj = count($matrix[$i]);
			$lj = array_keys($matrix[$i])[$lj - 1] + 1;

			for($j = 0; $j < $lj; $j++){
				$csv .= isset($matrix[$i][$j]) ? $matrix[$i][$j] : "";
				$csv .= ",";
			}

			$csv = substr($csv, 0, strlen($csv) - 1);
			$csv .= "\r\n";
		}

		return $csv;
	}

	function invert($matrix){
		$ret = [];

		$li = count($matrix);
		for($i = 0; $i < $li; $i++){
			$lj = count($matrix[$i]);

			for($j = 0; $j < $lj; $j++){
				if(!isset($ret[$j])){
					$ret[$j] = [];
				}

				$ret[$j][$i] = $matrix[$i][$j];
			}
		}

		return $ret;
	}

	header ( "Content-disposition: attachment; filename=" . "csv.csv" );
	header ( "Content-Type: application/octet-stream");
	header ( "Content-Transfer-Encoding: application/vnd.ms-excel" );
	header ( "Pragma: no-cache" );
	header ( "Cache-Control: must-revalidate, post-check=0, pre-check=0, public" );
	header ( "Expires: 0" );

	echo $csv;

	exit ();

?>