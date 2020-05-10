<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');


class Log_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}


	//var=1 error logs
	//var=2 persönliche info logs
	function getlogs($var) {

		$fulllog=array();
		if($var=='1') {
			//liste mit log files
			$log_files = array_diff(scandir('application/logs/', 1), array('.', '..', 'index.html'));
			//print_r($log_files);

		} elseif($var=='2') {

			//liste mit log files
			$log_files = array_diff(scandir('application/privat_logs/', 1), array('.', '..', 'index.html'));
			//print_r($log_files);
		} else {
			return null;
		}

		//öffne jedes logfile und füge line zu array hinzu
		foreach($log_files as $file) {
			$handle=null;
			$i=0;
			$contentformated=array();
			if($var=='1') {
				$handle = fopen('application/logs/'.$file, "r");
			} elseif($var=='2') {
				$handle = fopen('application/privat_logs/'.$file, "r");
			}
			if ($handle) {

				$nachlastlogin_trigger=0;
				$nachlastlogin=0;

				while (($line = fgets($handle)) !== false) {
					// process the line read.

					//fix log eintrag reinfolge
					if($var=='1' && strpos($line, ' --> ')) {
						$lineparts = explode(" --> ", $line);
						$colorpre='<span class="badge badge-light">info</span> ';
						$colorsuf='';

						if(strpos($lineparts[0], ' - ')){
							$linepartsone = explode(" - ", $lineparts[0]);
							if($linepartsone[0]=='ERROR'){

								$colorpre='<span class="badge badge-danger">Error</span> ';
								$colorsuf='';
							}
							if($linepartsone[1] >= $this->session->userdata('lastseen') && $nachlastlogin_trigger==0){
								$nachlastlogin='lastlogin';
								$nachlastlogin_trigger=1;

							} else{
								$nachlastlogin='0';
							}

							[$linepartsone[0], $linepartsone[1]] = [$linepartsone[1], $linepartsone[0]];
							$lineparts[0]= implode(' - ',$linepartsone);
						}

						$line= implode(' --> ',$lineparts);
						$line=$colorpre.$line.$colorsuf;

					}elseif($var=='2' && strpos($line, ' --> ')){

						$lineparts = explode(" --> ", $line);
						$colorpre='<span class="badge badge-light">info</span> ';
						$colorsuf='';

						if($lineparts[0] >= $this->session->userdata('lastseen') && $nachlastlogin_trigger==0){
							$nachlastlogin='lastlogin';
							$nachlastlogin_trigger=1;
						} else{
							$nachlastlogin='0';
						}

						$line= implode(' --> ',$lineparts);
						$line=$colorpre.$line.$colorsuf;
					}

					if(strpos($line, ' --> ')) {

					if($nachlastlogin=='lastlogin'){
						array_push($contentformated, $colorpre.$this->session->userdata('lastseen').'<hr>'.$colorsuf);
						$nachlastlogin_trigger=1;
					}
						//log line pro file
						array_push($contentformated, $line);
						$i++;
					}



					//nur 100 zeilen pro datei
					if($i>=100){
					break;
					}

				}
				fclose($handle);
			} else {
				// error opening the file.
			}

			//add log file to array
			array_push($fulllog, $contentformated);
			//füge nur neue logfiles hinzu wenn zu wenig zeilen sind
			if($i>=100){
			break;
			}


		}

		return $fulllog;

	}



	function privatlog($context){

if($this->session->userdata('username')){
	$user=$this->session->userdata('username');
} else {
	$user='cron';
}


		file_put_contents('application/privat_logs/'.date('Y-m-d').'.php', PHP_EOL .  date('Y-m-d H:i:s').' --> '.$context.' von '.$user, FILE_APPEND);


	}


}
