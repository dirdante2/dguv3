<?php
class Permissions extends CI_Controller{
  function __construct(){
    parent::__construct();
	$this->load->model('Login_model');
	$this->load->model('Users_model');
	$this->load->model('Log_model');

  }

  function permissions($userid,$access='user_edit'){

	$user= $this->Login_model->getuserpermission($userid);
	$rules = json_decode(file_get_contents("application/config/permissions.json"), true);
	if(!$user){	echo 'no user'; echo '<br>';}
	if(!$rules){	echo 'no rules'; echo '<br>';}

	echo '<br>';
	print_r($user);
	echo '<br>';
	print_r($rules);
	echo '<br>';
	foreach($rules as $rule_name => $rule_set){
		echo '<br>';
		echo $rule_name ;

		print_r($rule_set);

		//passende regel gefunden
		if($access==$rule_name){

			//alle regeln checken
			foreach($rule_set as $rule_name => $rule_key){

				if(!is_array($rule_key)){
				// regel bestanden
				if($rule_key==$user[$rule_name]){
					echo 'rule yes';
				}

			} else {
				//regel als array
				foreach($rule_key as $subrule){
					// regel bestanden
					if($subrule['user_level']==$user[$rule_name]){
						echo 'rule yes';
					}
				}
			}
			}


		}

	}




	//$this->db->select('users.user_id,users.user_level,users.user_showlink1,users.user_edit,users.user_delete,users.user_edituser,users.user_new');



  }










}





