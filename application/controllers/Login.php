<?php
class Login extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('Login_model');
    $this->load->model('Users_model');
  }
 
  function index(){
    if($this->agent->is_mobile()){
      $data['useragent'] = 'mobile';
      $header['useragent'] = 'mobile';
    } else {
      $data['useragent'] = 'desktop';
      $header['useragent'] = 'desktop';
    }

    $this->load->view('templates/header',$header);
    $this->load->view('login_view',$data);

  	
    
  }
 
  function auth(){
    $email    = $this->input->post('email',TRUE);
    $password = md5($this->input->post('password',TRUE));
    $validate = $this->Login_model->validate($email,$password);
    if($validate->num_rows() > 0){
        $data  = $validate->row_array();
        $name  = $data['user_name'];
        $userpid  = $data['user_pid'];
        $usermid  = $data['user_mid'];
        $email = $data['user_email'];
        $level = $data['user_level'];
        $firmaid = $data['users_firmaid'];
        $userid = $data['user_id'];
        $lastlogin = $data['user_lastlogin'];
        

        $sesdata = array(
            'username'  => $name,
            'userpid'  => $userpid,
            'usermid'  => $usermid,
            'email'     => $email,
            'level'     => $level,
            'firmaid'     => $firmaid,
            'userid'     => $userid,
            'lastlogin'     => $lastlogin,
            'logged_in' => TRUE
        );
        $this->session->set_userdata($sesdata);

        $user['user_lastlogin']=date('Y-m-d H:i:s');
        
      
        $this->Users_model->update($user,$userid);

        
            redirect('Dguv3');
        
    }else{
        echo $this->session->set_flashdata('msg','Username or Password is Wrong');
        redirect('login');
    }
  }
 
  function logout(){
      $this->session->sess_destroy();
      redirect('Dguv3');
  }
 //login per url /login/webauth/<name>/<password>
  function webauth(){
    $name =  $this->uri->segment(3);
    $password =  $this->uri->segment(4);

    $password = md5($password);
    $validate = $this->login_model->validatename($name,$password);
    if($validate->num_rows() > 0){
        $data  = $validate->row_array();
        $name  = $data['user_name'];
        $userpid  = $data['user_pid'];
        $usermid  = $data['user_mid'];
        $email = $data['user_email'];
        $level = $data['user_level'];
        $firmaid = $data['users_firmaid'];
        $userid = $data['user_id'];
        $lastlogin = $data['user_lastlogin'];

        $sesdata = array(
            'username'  => $name,
            'userpid'  => $userpid,
            'usermid'  => $usermid,
            'email'     => $email,
            'level'     => $level,
            'firmaid'     => $firmaid,
            'userid'     => $userid,
            'lastlogin'     => $lastlogin,
            'logged_in' => TRUE
        );
        $this->session->set_userdata($sesdata);
        echo'1';
            
        
    }else{
        echo'0';
        
    }
  }



}