<?php
class Login extends CI_Controller{
  function __construct(){
    parent::__construct();
	$this->load->model('login_model');
	$this->load->model('Users_model');
	$this->load->model('Log_model');

  }

  function index($error=null){

	if($this->session->userdata('logged_in') === TRUE){
		redirect('Dguv3');

	} else {

		if($this->input->cookie('dguv3',true) && $error!=1){
//echo 'test';
			$cookie=$this->input->cookie('dguv3',true);
			$cookieparts = explode(",", $cookie);
			$this->auth($cookieparts[0],$cookieparts[1]);
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





  function auth($userid=null,$cookietoken=null){

if($userid && $cookietoken){
	$cookietokenmd5 = md5($cookietoken);
    $validate = $this->login_model->validatecookie($userid,$cookietokenmd5);


} else{
	$email = $this->input->post('email',TRUE);
    $password = md5($this->input->post('password',TRUE));
	$validate = $this->login_model->validate($email,$password);

}


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


$this->login_model->setcookie($userid);

$context='User Login '.$name.' uid '.$userid;
$this->Log_model->privatlog($context);


            redirect('Dguv3');

    }else{

		if($userid && $cookietoken){

			echo $this->session->set_flashdata('msg','Cookie ist ungültig');
		} else {
			echo $this->session->set_flashdata('msg','Username oder Passwort ist falsch');

		}
		//redirect('login');
		$this->index('1');
    }
  }

  function logout(){
	  $this->session->sess_destroy();
	  delete_cookie('dguv3');
      redirect('Dguv3');
  }



}
