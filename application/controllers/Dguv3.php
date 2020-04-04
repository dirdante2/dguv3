<?php
    /**
     * Dguv3 - Klasse
     * (C) Christian Klein, 2020
     */


    defined('BASEPATH') OR exit('No direct script access allowed');


    class Dguv3 extends CI_Controller {
    
        public function __construct() {
            parent::__construct();
            $this->load->model('Dguv3_model');
            $this->load->helper('form');
						$this->load->library('form_validation');
        }

        public function index() {
            if(!$this->ia->in_group('dguv3')) {
                redirect('dguv3/notloggedin');
            }
           
			
            $this->load->view('templates/header');
            $this->load->view('static/welcome');
            $this->load->view('templates/footer');
        }

        public function notloggedin() {
        	
        		      		
        		$data['geraete_count']= $this->Dguv3_model->getcountdata('geraete');
        		$data['geraete_aktiv_1']= $this->Dguv3_model->getcountdata('geraete','aktiv', '1');
        		$data['geraete_aktiv_0']= $this->Dguv3_model->getcountdata('geraete','aktiv', '0');
        		$data['geraete_count_fail']= $this->Dguv3_model->getgeraetecountdata();
        		
        		$data['orte_count']= $this->Dguv3_model->getcountdata('orte');
        		
        		$data['pruefer_count']= $this->Dguv3_model->getcountdata('pruefer');
        		$data['messgeraete_count']= $this->Dguv3_model->getcountdata('messgeraete');
        		
        		$data['pruefung_count']= $this->Dguv3_model->getcountdata('pruefung');
        		$data['pruefung_bestanden_1']= $this->Dguv3_model->getcountdata('pruefung','bestanden', '1');
        		$data['pruefung_bestanden_0']= $this->Dguv3_model->getcountdata('pruefung','bestanden', '0');
        		//$this->output->cache(5);
            $this->load->view('templates/header');
            $this->load->view('static/welcome',$data);
            $this->load->view('templates/footer');
        }
    }
					