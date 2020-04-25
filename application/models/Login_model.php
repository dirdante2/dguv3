<?php
class Login_model extends CI_Model{
 
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
  //login per url /login/webauth/<name>/<password>
  function validatename($name,$password){
    $this->db->where('user_name',$name);
    $this->db->where('user_password',$password);
    $result = $this->db->get('users',1);
    return $result;
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
      $sesdata = array(
          'username'  => $name,
          'userpid'  => $userpid,
          'usermid'  => $usermid,
          'email'     => $email,
          'level'     => $level,
          'firmaid'     => $firmaid,
          'userid'     => $userid,
          'logged_in' => TRUE
      );
      $this->session->set_userdata($sesdata);
    }
  }





}