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
                break;
            case 1: // new Answer(id);
                $this->id = func_get_arg(0);
		
				$q = mysql_query("SELECT form_id, user_id, status FROM formans JOIN formdest ON formans.formdest_id = formdest.formdest_id AND formans.formans_id = " . $this->id);
				$line = mysql_fetch_array($q);
				
				$this->form = $line["form_id"];
				$this->user = new User($line["user_id"]);
				$this->state = $line["status"] == 1 ? TRUE : FALSE;
				break;
		}
	}

	/*
		id
		Returns answer's id
	 */
	public function id(){
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
	public function state(){
		return $this->user;
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
		mysql_query("UPDATE formdest SET status = 1 WHERE form_id = ".$this->form->id());
	}
}
?>