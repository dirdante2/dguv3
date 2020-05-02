<?php
/**
 * Dguv3 - Klasse
 * (C) Christian Klein, 2020
 */


defined('BASEPATH') OR exit('No direct script access allowed');


class File_model extends CI_Model
{

    function __construct()
    {
		$this->load->database();
		$this->load->model('Geraete_model');
		$this->load->model('Orte_model');
		$this->load->model('Pruefung_model');
		$this->load->model('Pdf_model');



    }
	//typ 1 übersicht $oid
	//typ 2 protokoll $pruefungid
	//typ 3 zip
	function get_file_pfad($typ,$id=null) {


		if($typ=='1') {

			$data['ort'] = $this->Orte_model->get($id);
			$year = date("Y");
			$ortsname = $data['ort']['name'];
			$ortsid = $data['ort']['oid'];
			$firma_id = $data['ort']['orte_firmaid'];
			$filename = 'pdf/'.$firma_id.'/'.$year.'/'.$ortsid.'_'.$ortsname.'/'.$ortsname.'_liste.pdf';




		} elseif($typ=='2') {
			$data['pruefung'] = $this->Pruefung_model->get($id);
			$blubb = new DateTime( $data['pruefung']['datum']);
			$datum= date_format($blubb,"Y");
			$ortsname = $data['pruefung']['ortsname'];
			$pruefungid = $data['pruefung']['pruefungid'];
			$geraeteid = $data['pruefung']['gid'];
			$ortsid = $data['pruefung']['oid'];
			$firma_id = $data['pruefung']['pruefung_firmaid'];

			$filename = 'pdf/'.$firma_id.'/'.$datum.'/'.$ortsid.'_'.$ortsname.'/Gid'.$geraeteid.'_'.$pruefungid.'_'.$data['pruefung']['geraetename'].'.pdf';

		} elseif($typ=='3') {
			$filename= 'pdf/'.$this->session->userdata('firmaid').'/'.$id.'.zip';
		}


			return $filename;




	}



	function download_file($typ,$id) {

		if($this->session->userdata('logged_in') === TRUE){
		//automatischer download

		$filename = $this->get_file_pfad($typ,$id);


		 if (file_exists($filename)) {

			$Dateiname = basename($filename);
			$Groesse = filesize($filename);
			header("Content-Type: application/force-download");
			header("Content-Disposition: attachment; filename=".$Dateiname);
			header("Content-Length: $Groesse");
			readfile($filename);
			redirect('Dguv3');
		} else {
			//return 'error';

		}
	  }
	}

	//listet alle ordner in $root
    function getfiles($folder=null) {
		$dguv3_show_list_archiv= $this->config->item('dguv3_show_list_archiv');

		$root = 'pdf/'.$this->session->userdata('firmaid').'/';
		if (!file_exists($root)) {
			return null;
		}

		if($folder) {
			$files[0]=$folder;
		} else{
		$files = array_diff(scandir($root, 1), array('.', '..'));
		}

		$return=array();
		$i='0';
		$maxi=$dguv3_show_list_archiv;
		// füge nur order der liste hinzu
		foreach($files as $file) {
			if($i==$maxi) {
				break;
			}
			if (is_dir($root.$file)) {
				$i++;
				array_push($return, $file);
			}
		}
        return $return;


    }

    function createfiles($folder=null) {
        $root = 'pdf/'.$this->session->userdata('firmaid').'/';
        if($folder==NULL) {

            $directories = glob($root . '*' , GLOB_ONLYDIR);
        } else {
             $directories[0]= $root.$folder;
        }

        foreach ($directories as $folder) {

			if (file_exists($folder.".zip")) {
				if (!unlink($folder.".zip")) {
					echo 'error';
				break;
				}
			}

        // file und dir counter
        $filecounter = -1;
		$dircounter = -1;
		$file_list_counter = 0;
		$file_protokoll_counter = 0;

        // die maximale Ausführzeit erhöhen
        ini_set("max_execution_time", 300);
        //if (!file_exists($folder.".zip")) {

        // Objekt erstellen und schauen, ob der Server zippen kann
        $zip = new ZipArchive();
        if ($zip->open($folder.".zip", ZIPARCHIVE::CREATE) !== TRUE) {
        die ("Das Archiv konnte nicht erstellt werden!");
        }

        //echo "<pre>";
        // Gehe durch die Ordner und füge alles dem Archiv hinzu
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
        foreach ($iterator as $key=>$value) {

            if(!is_dir($key)) { // wenn es kein ordner sondern eine datei ist
            // echo $key . " _ _ _ _Datei wurde übernommen</br>";
            $zip->addFile(realpath($key), $key) or die ("FEHLER: Kann Datei nicht anfuegen: $key");
			$filecounter++;
			//wenn file eine übersicht-pdf ist
			if (strpos($key, '_liste.pdf') !== false) {
				$file_list_counter++;
				//file_put_contents('filename_liste'.$file_list_counter.'.txt', $key);

			//wenn file ein protokoll ist
			} elseif (strpos($key, '.pdf') !== false) {
				$file_protokoll_counter++;
				//file_put_contents('filename_protokoll'.$file_protokoll_counter.'.txt', $key);

			}
            } elseif (count(scandir($key)) <= 2) { // der ordner ist bis auf . und .. leer
            // echo $key . " _ _ _ _Leerer Ordner wurde übernommen</br>";
            $zip->addEmptyDir(substr($key, -1*strlen($key),strlen($key)-1));
            $dircounter++;

            } elseif (substr($key, -2)=="/.") { // ordner .
            $dircounter++; // nur für den bericht am ende

            } elseif (substr($key, -3)=="/.."){ // ordner ..
            // tue nichts

            } else { // zeige andere ausgelassene Ordner (sollte eigentlich nicht vorkommen)
            //echo $key . "WARNUNG: Der Ordner wurde nicht ins Archiv übernommen.</br>";
            }
        }
        //echo "</pre>";

        // speichert die Zip-Datei
		$zip->close();
		$orte_count= $this->Dguv3_model->getcountdata('orte','orte_firmaid', $this->session->userdata('firmaid'));
		$geraete_aktiv_1= $this->Dguv3_model->getcountdata('geraete','aktiv', '1', $this->session->userdata('firmaid') );

		file_put_contents($folder.'.txt', 'Übersicht: '.$file_list_counter.' von '.$orte_count.'<br>');
		file_put_contents($folder.'.txt', PHP_EOL .  'Protokolle: '.$file_protokoll_counter.' von '.$geraete_aktiv_1, FILE_APPEND);


        // bericht
        //echo $folder.".zip wurde erstellt.";
        //echo "<p>Ordner: " . $dircounter . "; Dateien: " . $filecounter . "</p>";

        }
        //}

    }




}