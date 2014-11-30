<?php
class Answer {
	// Answer id (formans_id)
	private $id;
	// Form id to answer
	private $form;
	// Answerer
	private $user;
	// Answer status
	private $state;
	
	/*
		Constructor
	 */
	public function __construct(){
		switch(func_num_args()){
            case 0: // new Answer();
            	$this->state = FALSE;
                break;
            case 1: // new Answer(id);
                $this->id = func_get_arg(0);
		
				$q = mysql_query("SELECT form_id, user_id, formdest_status FROM formans JOIN formdest ON formans.formdest_id = formdest.formdest_id AND formans.formans_id = " . $this->id);
				$line = mysql_fetch_array($q);
				
				$this->form = $line["form_id"];
				$this->user = new User($line["user_id"]);
				$this->state = $line["formdest_status"] == 1 ? TRUE : FALSE;
				break;
		}
	}

	/*
		id
		Returns answer's id
	 */
	public function getId(){
		return $this->id;
	}

	/*
		getForm
		Returns answer's general form
	 */
	public function getForm(){
		return $this->form;
	}

	/*
		getUser
		Returns answer's answerer
	 */
	public function getUser(){
		return $this->user;
	}

	/*
		getState
		Returns answer's state
	 */
	public function getState(){
		return $this->state;
	}

	/*
		setForm
		Sets answer's general form
	 */
	public function setForm($form){
		$this->form = $form;
	}

	/*
		setUser
		Sets answer's answerer
	 */
	public function setUser($user){
		$this->user = $user;
	}

	/*
		save
		TODO !=NULL
	 */
	public function save(){
	}

	/*
		send
	 */
	public function send(){
		$this->save();
		$this->state = TRUE;
		// Update status
		mysql_query("UPDATE formdest SET formdest_status = 1 WHERE form_id = ".$this->form . " AND user_id = " . $this->user->getId());
	}
}
?>