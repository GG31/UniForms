<?php

	////////////////////////////////
	// Error enabling & includes //
	////////////////////////////////
	
	ini_set('display_errors', 1);
	error_reporting ( E_ALL );

	require_once_UF ( "include/connect" );
	require_once_UF ( "class/User.class" );
	require_once_UF ( "class/Form.class" );
	require_once_UF ( "class/Group.class" );
	require_once_UF ( "class/Answer.class" );
	require_once_UF ( "class/Element.class" );

	////////////////////
	// From creation //
	////////////////////

	// Creator
	$user1 		= new User(1);
	$user2 		= new User(2);
	$user3 		= new User(3);
	$user4		= new User(4);

	// Create new Form
	$form = new Form();

	// Set attributes ...
	$form->creator 		($user2);
	$form->name 		("Cool form");
	$form->printable 	(FALSE);
	$form->anon 		(FALSE);

	///////////////
	// Elements //
	///////////////
	
	// Create elements
	$elem0 = new Element();
	$elem1 = new Element();
	$elem2 = new Element();
	$elem3 = new Element();
	$elem4 = new Element();
	$elem5 = new Element();
	$elem6 = new Element();
	$elem7 = new Element();

	// Set attributes ...
	$attributes = [
		"type" 			=> ELEMENT_TEXT,
		"label"			=> "Name :",
		"placeholder"	=> "Enter name here",
		"width"			=> 100,
		"height"		=> 9,
		"min"			=> 0,
		"max"			=> 0,
		"y" 			=> 0,
		"img" 			=> '0'
	];
	$elem0->attr($attributes, ["x" => 0 ]);
	$elem1->attr($attributes, ["x" => 10]);
	$elem2->attr($attributes, ["x" => 20]);
	$elem3->attr($attributes, ["x" => 30]);
	$elem4->attr($attributes, ["x" => 40]);
	$elem5->attr($attributes, ["x" => 50]);
	$elem6->attr($attributes, ["x" => 60]);
	$elem7->attr($attributes, ["x" => 70]);

	//////////////////
	// From Groups //
	//////////////////

	// Create new groups
	$group0 = new Group();
	$group1 = new Group();
	$group2 = new Group();

	// Set attributes ...
	$group0->limit(0);
	$group0->users([$user1, $user2, $user3]);
	$group0->elements([$elem0, $elem1, $elem2]);

	$group1->limit(0);
	$group1->users([$user2, $user3, $user4]);
	$group1->elements([$elem3, $elem4, $elem5]);

	$group2->limit(0);
	$group2->users([$user1, $user2, $user3]);
	$group2->elements([$elem6, $elem7]);

	// Set groups to form
	$form->groups([$group0, $group1, $group2]);

	// OK let's send
	$form->save();
	// $form->send();

	/////////////
	// Answer //
	/////////////

	// echo '<a href="list.php?formId=' . $form->id() . '">Answer !</a>';

	function require_once_UF($path) {
		require_once dirname ( __FILE__ ) . '/' . $path . '.php';
	}

	function l($obj){
		if(is_array($obj)){
			echo '<pre>';
			print_r($bj);
			echo '</pre>';
			return;
		}
		if(is_object($obj)){
			var_dump($obj);
			return;
		}
		echo $obj;
		return;
	}

?>