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

			$i=0;
			$contentformated=array();
			if($var=='1') {
				$handle = fopen('application/logs/'.$file, "r");
			} elseif($var=='2') {
				$handle = fopen('application/privat_logs/'.$file, "r");
			}
			if ($handle) {
				while (($line = fgets($handle)) !== false) {
					// process the line read.
					array_push($contentformated, $line);
					$i++;
				}
				fclose($handle);
			} else {
				// error opening the file.
			}
			array_push($fulllog, $contentformated);
			//füge nur neue logfiles hinzu wenn zu wenig zeilen sind
			if($i>=100){
			break;
			}


		}

		return $fulllog;

	}

}
