<?php
/**
 * Dguv3 - Klasse
 * (C) Christian Klein, 2020
 */


defined('BASEPATH') OR exit('No direct script access allowed');


class Dguv3_model extends CI_Model
{

    function __construct()
    {
        $this->load->database();

    $this->load->model('Firmen_model');

    }

    // gibt row anzahl wert zurück var1 tabellen name ; var2 tabellen spalte; var3 wert
    function getcountdata($tblName, $tblcol = NULL, $tblvar = NULL,$firmaid=null)
    {
        $this->db->select('*');
        $this->db->from($tblName);
        if($this->session->userdata('level')>='2'){
			$firmen_firmaid=$this->session->userdata('firmaid');


			$this->db->where($tblName.'.'.$tblName.'_firmaid', $firmen_firmaid);

	} elseif($firmaid) {
		$this->db->where($tblName.'.'.$tblName.'_firmaid', $firmaid);
	}

        if ($tblvar !== NULL) {
            $this->db->where($tblName.'.'.$tblcol, $tblvar);
        }

        return $this->db->count_all_results();
    }


    // gibt anzahl geräte die bestanden sind zurück

    // geräte bestanden: bestanden=1 und letztesdatum+10monate > today
    // geräte abgelaufen: bestanden=1 und letztesdatum+12monate< today
    // geräte bald abgelaufen: bestanden=1 und letztesdatum+10monate< today

    function getgeraete_bestanden_countdata2($tblvar=NULL, $letztesdatum=NULL)
    {


        $this->db->select('geraete.*, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl');
				$this->db->from('geraete');

				$this->db->join('pruefung','geraete.gid = pruefung.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)','LEFT');
        $this->db->where('aktiv', '1');
        if($this->session->userdata('level')>='2'){
            $firmen_firmaid=$this->session->userdata('firmaid');
            $this->db->where('geraete.geraete_firmaid', $firmen_firmaid);
        }
        //gibt geräte zurück die ungeprüft sind
        if ($tblvar===NULL) {
            $this->db->where('bestanden', NULL);

        //gibt geräte zurück die bestanden sind
        } elseif($tblvar== '1') {
        				$pruefungabgelaufen = $this->config->item('dguv3_pruefungabgelaufen');
								$pruefungbaldabgelaufen = $this->config->item('dguv3_pruefungbaldabgelaufen');
        	 			$today = date("Y-m-d");
        	 			$abgelaufen = strtotime('-'.$pruefungabgelaufen, strtotime($today));
        	 			$baldabgelaufen = strtotime('-'.$pruefungbaldabgelaufen, strtotime($today));
        	 			$abgelaufen = date("Y-m-d", $abgelaufen);
								$baldabgelaufen = date("Y-m-d", $baldabgelaufen);
        	 			$this->db->where('bestanden', '1');

        	 			//geräte mit prüfung bestanden die abgelaufen sind
	        			if ($letztesdatum== 'abgelaufen'){

									$this->db->where('datum <', $abgelaufen);
	        		 	//geräte mit prüfung die bald abgelaufen sind
	        		 	} elseif ($letztesdatum== 'baldabgelaufen'){

	        		 		$this->db->where('datum >', $abgelaufen);
	        		 		$this->db->where('datum <', $baldabgelaufen);
	        			}




        //gibt andere geräte zurück; var=0 durchgefallen
        } else {
            $this->db->where('bestanden', $tblvar);
        }

        return $this->db->count_all_results();

    }
	//listet alle ordner in $root
    function getfiles($folder) {
		$dguv3_show_list_archiv= $this->config->item('dguv3_show_list_archiv');

        $root = 'pdf/'.$this->session->userdata('firmaid').'/';
        if (!file_exists($root)) {
            return null;
        } else {
		$files = array_diff(scandir($root, 1), array('.', '..'));

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

    }

    function createfiles($folder=null) {
        $root = 'pdf/'.$this->session->userdata('firmaid').'/';
        if($folder==NULL) {

            $directories = glob($root . '*' , GLOB_ONLYDIR);
        } else {
             $directories[0]= $root.$folder;
        }

        foreach ($directories as $folder) {

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
		$orte_count= $this->getcountdata('orte','orte_firmaid', $this->session->userdata('firmaid'));
		$geraete_aktiv_1= $this->getcountdata('geraete','aktiv', '1', $this->session->userdata('firmaid') );

		file_put_contents($folder.'.txt', 'Übersicht: '.$file_list_counter.' von '.$orte_count.'<br>');
		file_put_contents($folder.'.txt', PHP_EOL .  'Protokolle: '.$file_protokoll_counter.' von '.$geraete_aktiv_1, FILE_APPEND);


        // bericht
        //echo $folder.".zip wurde erstellt.";
        //echo "<p>Ordner: " . $dircounter . "; Dateien: " . $filecounter . "</p>";

        }
        //}

    }




}
