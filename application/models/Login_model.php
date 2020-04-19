<?php
class Login_model extends CI_Model{
 
  function validate($email,$password){
    $this->db->where('user_email',$email);
    $this->db->where('user_password',$password);
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
 
}