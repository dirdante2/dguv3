<?php
    /**
     * Dguv3 - Klasse
     * (C) Christian Klein, 2020
     */


    defined('BASEPATH') OR exit('No direct script access allowed');


    class Dguv3 extends CI_Controller {
    
        public function __construct() {
            parent::__construct();
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
            $this->load->view('templates/header');
            $this->load->view('static/welcome');
            $this->load->view('templates/footer');
        }
    }
