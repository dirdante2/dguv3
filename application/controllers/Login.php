<?php
class Login extends CI_Controller{
  function __construct(){
    parent::__construct();
	$this->load->model('login_model');
	$this->load->model('Users_model');
	$this->load->helper('cookie');
  }

  function index($error=null){

	if($this->session->userdata('logged_in') === TRUE){
		redirect('Dguv3');

	} else {

		if($this->input->cookie('dguv3',true) && $error!=1){

			$cookie=$this->input->cookie('dguv3',true);
			$cookieparts = explode(",", $cookie);


			// echo '<br>';
			// echo 'id '.$cookieparts[0];
			// echo '<br>';
			// echo 'wert '.$cookieparts[1];
			$this->cookieauth($cookieparts[0],$cookieparts[1]);
		} else {


			if($this->agent->is_mobile()){
			$this->load->view('templates/header_mobile');
			$this->load->view('login_view_mobile');
			} else {
			$this->load->view('templates/header');
			$this->load->view('login_view');
			}
			$this->load->view('templates/footer');
		}
	}
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



  function auth($userid=null){


    $email    = $this->input->post('email',TRUE);
    $password = md5($this->input->post('password',TRUE));
    $validate = $this->login_model->validate($email,$password);
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


$this->setcookie($userid);
file_put_contents('application/privat_logs/'.date('Y-m-d').'.php', PHP_EOL .  date('Y-m-d H:i:s').' Login: mit auth '.$name.' '.$userid, FILE_APPEND);


            redirect('Dguv3');

    }else{
        echo $this->session->set_flashdata('msg','Username oder Passwort ist falsch');
        redirect('login');
    }
  }

  function logout(){
	  $this->session->sess_destroy();
	  delete_cookie('dguv3');
      redirect('Dguv3');
  }
 //login per cookie
  function cookieauth($userid,$cookietoken){

    $cookietokenmd5 = md5($cookietoken);
    $validate = $this->login_model->validatecookie($userid,$cookietokenmd5);
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


$this->setcookie($userid);

redirect('Dguv3');



    }else{
		//echo'cookie ist ungültig';
		echo $this->session->set_flashdata('msg','Cookie ist ungültig. Bitte neu anmelden');
		delete_cookie('dguv3');
		$this->index('1');


    }
  }



}
