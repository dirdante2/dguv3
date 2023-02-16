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
  $this->load->model('Users_model');

    //$this->load->library('user_agent');
    if($this->session->userdata('logged_in') !== TRUE){
			#$this->load->view('templates/header',$header);
			#$this->load->view('static/denied');
			#$this->load->view('templates/footer');
			redirect('login');
			return;
			

          }


  }

  function index(){
    site_denied($this->session->userdata('logged_in'));
    if($this->agent->is_mobile()){
      $data['useragent'] = 'mobile';
      $header['useragent'] = 'mobile';
    } else {
      $data['useragent'] = 'desktop';
      $header['useragent'] = 'desktop';
    }

    if($this->session->userdata('logged_in') === TRUE){

      $data['userdata']= $this->Users_model->get($this->session->userdata('userid'));
      unset($data['userdata']['user_password']);
      unset($data['userdata']['user_cookie']);
     # print_r( $data['userdata']);

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
    $data['fehlerquote']=  $this->fehlerquote();


		$data['firma'] = $this->Firmen_model-> get($this->session->userdata('firmaid'));
      }
      $data['pdfserver']= $this->config->item('dguv3_pdf_server');
	  //echo $this->input->cookie('dguv3',true);


    

    $this->load->view('templates/header', $header);
      if($this->agent->is_mobile()){
       
        $this->load->view('dashboard_view_mobile',$data);

      } else {
		
		$this->load->view('dashboard_view',$data);
	  }

      $this->load->view('templates/footer');



    }

  }

  function fehlerquote() {

    $zeitraumausfallrate     = $this->config->item('dguv3_zeitraumausfallrate');			
    $oldestday=strtotime('-'.$zeitraumausfallrate); // Jetzt vor einer Woche
    $oldestday=date("Y-m-d", $oldestday);



    $anzahlbestanden = $this->Geraete_model->fehlerquote('1',$oldestday); //status(bestanden),zeitraum
    #echo $data;


    $anzahldurchgefallen = $this->Geraete_model->fehlerquote('0',$oldestday); //status(bestanden),zeitraum
    $anzahlbestanden_anzahldurchgefallen = $anzahlbestanden + $anzahldurchgefallen;


    if ($anzahlbestanden_anzahldurchgefallen >= 1) {
    #echo $data;

    $fehlerquote=round((($anzahldurchgefallen * 100) / ($anzahlbestanden + $anzahldurchgefallen)), 2);
    } else {
      $fehlerquote= "0";
    }

    $data['prozent']=$fehlerquote;
    $data['zeitraum']=$oldestday;
    $data['anzahlbestanden']=$anzahlbestanden;
    $data['anzahldurchgefallen']=$anzahldurchgefallen;
    $data['geprüft']=($anzahlbestanden + $anzahldurchgefallen);


    return $data;      
    }



  function create_archiv($folder) {
    site_denied($this->session->userdata('logged_in'));
    
    $fimra_id=$this->session->userdata('firmaid');
    $this->File_model->createfiles($folder,$fimra_id); //folder, firmaid

    #$this->File_model->createfiles($folder); //folder, firmaid


     # redirect('Dguv3');
    

	}

  // typ 1 file elektro geräte übersicht
  // typ 2 file protokoll
  // typ 3 archiv 
	function download_file($file,$typ,$pfad=null) {
    site_denied($this->session->userdata('logged_in'));

// echo "file $file";
// echo "<br>";
// echo "typ $typ";
// echo "<br>";
// echo "pfad $pfad";

		if($pfad==null) {
			$pfad='';
		}
		$this->File_model->download_file($typ,$file); //typ, id



	}




}
