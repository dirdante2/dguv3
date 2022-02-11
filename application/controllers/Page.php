<?php
class Page extends CI_Controller{
  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in') !== TRUE){
      redirect('login');
    }
  }
 
  function index(){
    //Allowing to admin only
      if($this->session->userdata('level')==='1'){
          $this->load->view('dashboard_view');
      }else{
          $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
      }
 
  }
 
  function staff(){
    //Allowing to staff only
    if($this->session->userdata('level')==='2'){
      $this->load->view('dashboard_view');
    }else{
        $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
    }
  }
 
  function author(){
    //Allowing to author only
    if($this->session->userdata('level')==='3'){
      $this->load->view('dashboard_view');
    }else{
        $this->load->view('templates/header');
			$this->load->view('static/denied');
			$this->load->view('templates/footer');
    }
  }
 
}