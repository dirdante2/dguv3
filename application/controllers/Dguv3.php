<?php
    /**
     * Dguv3 - Klasse
     * (C) Christian Klein, 2020
     */


    defined('BASEPATH') OR exit('No direct script access allowed');


    class Dguv3 extends CI_Controller {
    		function __construct(){
    			
    parent::__construct();
    
    $this->load->model('Dguv3_model');
    
    
    if($this->session->userdata('logged_in') !== TRUE){
      //redirect('login');
      $this->load->view('templates/header');
      $this->load->view('static/welcome');
      $this->load->view('templates/footer');
    }
  }
 
  function index(){
    //Allowing akses to admin only
      if($this->session->userdata('level')){
       
          
          $data['adresse']= $this->config->item('dguv3_adresse');      		
        		$data['geraete_count']= $this->Dguv3_model->getcountdata('geraete');
        		$data['geraete_aktiv_1']= $this->Dguv3_model->getcountdata('geraete','aktiv', '1');
        		$data['geraete_aktiv_0']= $this->Dguv3_model->getcountdata('geraete','aktiv', '0');
        		$data['geraete_count_geprueft_0']= $this->Dguv3_model->getgeraete_bestanden_countdata2('0');
        		$data['geraete_count_geprueft_1']= $this->Dguv3_model->getgeraete_bestanden_countdata2('1');
        		$data['geraete_count_geprueft']= $data['geraete_count_geprueft_1'] + $data['geraete_count_geprueft_0'];
        		
        		$data['geraete_count_geprueft_null']= $this->Dguv3_model->getgeraete_bestanden_countdata2();
        		$data['geraete_count_geprueft_baldabgelaufen']= $this->Dguv3_model->getgeraete_bestanden_countdata2('1', 'baldabgelaufen');
        		$data['geraete_count_geprueft_abgelaufen']= $this->Dguv3_model->getgeraete_bestanden_countdata2('1', 'abgelaufen');
        		
        		//$data['geraete_count_abgelaufen']= $this->Dguv3_model->getgeraete_abgelaufen_countdata();
        		if($this->session->userdata('level')=='1'){
            $data['orte_count']= $this->Dguv3_model->getcountdata('orte');
            $data['users_count']= $this->Dguv3_model->getcountdata('users');
            $data['firmen_count']= $this->Dguv3_model->getcountdata('firmen');
            $data['pruefer_count']= $this->Dguv3_model->getcountdata('pruefer');
            } else {
              $data['orte_count']= $this->Dguv3_model->getcountdata('orte','orte_firmaid', $this->session->userdata('firmaid'));
              $data['users_count']= $this->Dguv3_model->getcountdata('users','users_firmaid', $this->session->userdata('firmaid'));
              $data['firmen_count']= $this->Dguv3_model->getcountdata('firmen','firmen_firmaid', $this->session->userdata('firmaid'));
              $data['pruefer_count']= $this->Dguv3_model->getcountdata('pruefer','pruefer_firmaid', $this->session->userdata('firmaid'));
            }
            
            
        		
        		$data['messgeraete_count']= $this->Dguv3_model->getcountdata('messgeraete');
        		
        		$data['pruefung_count']= $this->Dguv3_model->getcountdata('pruefung');
        		$data['pruefung_bestanden_1']= $this->Dguv3_model->getcountdata('pruefung','bestanden', '1');
        		$data['pruefung_bestanden_0']= $this->Dguv3_model->getcountdata('pruefung','bestanden', '0');
        		//$this->output->cache(5);
            
           	
          
			
            $this->load->view('templates/header');
            $this->load->view('dashboard_view',$data);
            $this->load->view('templates/footer');
          
      
          
      }
 
  }
  
        
       
    }
					