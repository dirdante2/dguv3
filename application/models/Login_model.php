<?php
class Login_model extends CI_Model{

	function __construct() {
		$this->load->database();
		$this->load->model('Users_model');
		$this->load->helper('cookie');

	}

  function validate($email,$password){
    $this->db->where('user_email',$email);
    $this->db->where('user_password',$password);
    $result = $this->db->get('users',1);
    return $result;
  }
  function getuserinfo($userid){
    $this->db->where('user_id',$userid);

    $result = $this->db->get('users',1);
    return $result;
  }




  //login per cookie userid und cookiepass
  function validatecookie($userid,$cookieid){
	$this->db->where('user_cookie',$cookieid);

    $this->db->where('user_id',$userid);
    $result = $this->db->get('users',1);
    return $result;
  }


//random token token
function generate_string($strength) {
	$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($permitted_chars);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $permitted_chars[random_int(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

//set cookie mit random 60 zeichen string gültig für 7 tage
function setcookie($userid){

	$randomstring=$this->generate_string(60);
	$cookie= array(
		'name'   => 'dguv3',
		'value'  => $userid.','.$randomstring,
		'expire' => '604800',
	);
	$this->input->set_cookie($cookie);

	$user['user_lastlogin']=date('Y-m-d H:i:s');
	$user['user_cookie']=md5($randomstring);

	$this->Users_model->update($user,$userid);
}



  // update session data bei user edit
  function update(){


    $userid = $this->session->userdata('userid');
  $validate = $this->getuserinfo($userid);
  if($validate->num_rows() > 0){
      $data  = $validate->row_array();
      $name  = $data['user_name'];
      $userpid  = $data['user_pid'];
      $usermid  = $data['user_mid'];
      $email = $data['user_email'];
      $level = $data['user_level'];
      $firmaid = $data['users_firmaid'];
	  $userid = $data['user_id'];
	  $userlastlogin = $data['user_lastlogin'];
      $sesdata = array(
          'username'  => $name,
          'userpid'  => $userpid,
          'usermid'  => $usermid,
          'email'     => $email,
          'level'     => $level,
          'firmaid'     => $firmaid,
		  'userid'     => $userid,
		  'lastseen'     => $userlastlogin,
          'logged_in' => TRUE
      );
      $this->session->set_userdata($sesdata);
    }
  }





}
