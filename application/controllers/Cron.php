<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Dguv3_model');
		$this->load->model('Pdf_model');
		$this->load->model('File_model');
		$this->load->model('Orte_model');
		$this->load->model('Pruefung_model');
		$this->load->model('Log_model');
	}
	//modus 1 bulk Orte neu erstellen
	//modus 2 bulk protokolle neu erstellen
	//modus 3 cronjob alle anstehenden aufgaben abarbeiten
	//modus 1+2 nur für debug zwecke und nur für admin
	function create_pdf_1($oid=null) {
		$create_pdf_output= '';
		
			if($this->session->userdata('level')=='1'){
				if($oid===NULL) {
				$orte = $this->Orte_model->get();

				foreach($orte as $ort) {
					// nur fürs aktuelle jahr

					$filename= $this->Pdf_model->genpdf_uebersicht($ort['oid']);
					if (file_exists($filename)) {
						echo $filename.' '.round(filesize($filename)/1024,2). ' KB';
						$create_pdf_output.= $filename.' '.round(filesize($filename)/1024,2). ' KB<br>';
					} else {echo $filename;}
					
					echo '<br>';
					echo $ort['oid'].'<br>';

				}

				} else {

					$filename= $this->Pdf_model->genpdf_uebersicht($oid);
					echo $filename.' '.round(filesize($filename)/1024,2). ' KB';
					$create_pdf_output.= $filename.' '.round(filesize($filename)/1024,2). ' KB<br>';
					echo '<br>';
				}

					$this->Log_model->cronjoblog($create_pdf_output, 'uebersicht');
					#redirect('Dguv3');
			}
		}
		
			function create_pdf_2($prid=null) {
				$create_pdf_output= '';
				
			if($this->session->userdata('level')=='1'){
				
				if($prid===NULL) {

				//gibt nur eine prüfung pro gerät zurück && die im aktuellen jahr gemacht wurde
				$protokolle = $this->Pruefung_model->get_geraete_pruefung();

				#print_r($protokolle);
				
				foreach($protokolle as $protokoll) {
					$filename= $this->Pdf_model->genpdf_protokoll($protokoll['pruefungid']);
					echo $filename.' '.round(filesize($filename)/1024,2).' KB';
					$create_pdf_output.= $filename.' '.round(filesize($filename)/1024,2). ' KB<br>';
					echo '<br>';
					echo $protokoll['pruefungid'].' '.$protokoll['gid'].'<br>';
				}
			} else {

					$filename= $this->Pdf_model->genpdf_protokoll($prid);
					
					#echo '1'.$filename.' 1';
					

					if (file_exists($filename)) {

					
					echo $filename.' '.round(filesize($filename)/1024,2).' KB';
					$create_pdf_output.= $filename.' '.round(filesize($filename)/1024,2). ' KB<br>';
					echo '<br>';
					echo $prid.' <br>';

					
			}
			
				
			
			}
					$this->Log_model->cronjoblog($create_pdf_output, 'protokoll');
					#redirect('Dguv3');
			}
			}
			function create_pdf_3() {
				$create_pdf_output= '';

			$cron_liste_pfad = 'cron/liste/';
			$cron_protokoll_pfad = 'cron/protokoll/';

			$cron_liste = array_diff(scandir($cron_liste_pfad, 1), array('.', '..'));
			$cron_protokoll = array_diff(scandir($cron_protokoll_pfad, 1), array('.', '..'));
			$errordata=array();
			
			//listen übersicht als pdf anfordern
			foreach($cron_liste as $ortsid) {

				if($ort=$this->Orte_model->get($ortsid)) {
					
					#print_r($ort);

					echo 'ort existiert oid '.$ortsid.'; Name '.$ort['name'].'; Beschreibung '.$ort['beschreibung'].'<br>';
				


					$firmaid = file_get_contents($cron_liste_pfad.$ortsid, true);

					$filename= $this->Pdf_model->genpdf_uebersicht($ortsid);

					if (file_exists($filename)) {
						$create_pdf_output.= $filename.' '.round(filesize($filename)/1024,2). ' KB<br>';
					
						
					} else { echo 'error kein datei zurück<br>';}
					
					
					
					

					
				} else { echo 'ort existiert nicht'.$ortsid.'<br>'; }

				if (!unlink($cron_liste_pfad.$ortsid)) {
					$error='Fehler '.$filename;
					array_push($errordata, $error);
				}
				echo "-----<br>";
			}

			// protokoll als pdf anfordern
			foreach($cron_protokoll as $pruefung_id) {

				if($this->Pruefung_model->get($pruefung_id)) {

					echo 'prüfung existiert '.$pruefung_id;
					$firmaid = file_get_contents($cron_protokoll_pfad.$pruefung_id, true);

					$filename= $this->Pdf_model->genpdf_protokoll($pruefung_id);
					echo '<br>';

					if (file_exists($filename)) {
						
					

						$create_pdf_output.= $filename.' '.round(filesize($filename)/1024,2).' KB<br>';
					echo '<br>';
					}


					
				} else { echo 'prüfung existiert nicht'.$pruefung_id.'<br>'; }

				if (!unlink($cron_protokoll_pfad.$pruefung_id)) {
					$error='Fehler '.$filename;

					array_push($errordata, $error);
				}
			}


			//FIXME fehler wenn nicht vorhandener ort als letztes kommt und damit keine firmaid vorhanden ist
			//muss wohl cron ordner für jede firma getrennt angelegt werden
				//aktuelles jahr wird als zip neu erstellt wenn änderungen sind
				$year=date('Y');
				if(!empty($cron_liste) || !empty($cron_protokoll)){

				$this->File_model->createfiles($year,$firmaid);
				}

				echo '<br>';
			if(empty($errordata)){
				echo 'OK';
				echo '<br>Übersicht ';
				print_r($cron_liste);
				echo '<br>Protokoll ';
					print_r($cron_protokoll);
			} else {
				print_r($errordata);
			}

			$this->Log_model->cronjoblog($create_pdf_output, 'cron');
			#redirect('Dguv3');
		}
	
	


}
