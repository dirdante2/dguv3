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
	$this->load->model('File_model');
	$this->load->model('Firmen_model');

    //$this->load->library('user_agent');
			}

  function index(){
	if($this->session->userdata('logged_in') != TRUE){


		redirect('login');


	} elseif($this->session->userdata('logged_in') == TRUE){

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
      if ($this->session->userdata('firmaid')) {
		$data['archiv_ordner']= $this->File_model->getfiles();
		$data['cronjobs']= $this->File_model->getfiles('cronjob');
		$header['cronjobs']= $this->File_model->getfiles('cronjob');



		$data['firma'] = $this->Firmen_model-> get($this->session->userdata('firmaid'));
      }
	  $data['pdfserver']= $this->config->item('dguv3_pdf_server');
	  //echo $this->input->cookie('dguv3',true);



      if($this->agent->is_mobile()){
        $this->load->view('templates/header_mobile',$header);
        $this->load->view('dashboard_view_mobile',$data);
      } else {
		$this->load->view('templates/header', $header);
		$this->load->view('templates/toast');

        $this->load->view('dashboard_view',$data);
	  }

      $this->load->view('templates/footer');



    }

  }

  function create_archiv($foldername) {
    if($this->session->userdata('logged_in') === TRUE){
    $this->File_model->createfiles($foldername);


      redirect('Dguv3');
    }

	}

	function download_file($file,$typ,$pfad=null) {


		if($pfad==null) {
			$pfad='';
		}
		$this->File_model->download_file($file,$typ,$pfad);



	}

	function get_toast() {

		if($this->session->userdata('logged_in') === TRUE){

			$toasts_files= $this->File_model->getfiles(null,'toast');
			//print_r($toasts_files);


			$toastarray=array();
foreach($toasts_files as $toastobj) {
		$details = file_get_contents('toast/'.$this->session->userdata('userid').'/'.$toastobj, true);

		$toasts=json_decode($details, TRUE);
		//print_r($toasts);
		array_push($toastarray,$toasts);

		}

$data['toasts']=$toastarray;
//print_r($toastarray);
		$this->load->view('templates/toast_view',$data);
//return $data;

		}

	}


}
