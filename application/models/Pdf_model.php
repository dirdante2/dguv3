<?php
/**
 * Dguv3 - Klasse
 * (C) Christian Klein, 2020
 */


defined('BASEPATH') OR exit('No direct script access allowed');


class Pdf_model extends CI_Model
{

    function __construct()
    {
		$this->load->database();
		$this->load->model('Geraete_model');
		$this->load->model('Orte_model');
		$this->load->model('Pdf_model');
		$this->load->model('File_model');



    }

	function generate_pdf($kind, $data, $filename) {
		$dir = dirname($filename);
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		$pdfserver= $this->config->item('dguv3_pdf_server');
		$i=0;
		foreach($pdfserver as $serverurl) {
			$i++;


			$urlprefix='';
				if($serverurl[1]=='443') {
					$urlprefix='https://';
				} else {
					$urlprefix='http://';
				}
				//echo $urlprefix.$serverurl[0].':'.$serverurl[1].'/pdfgen/'.$kind;


			if($socket =@ fsockopen($serverurl[0], $serverurl[1], $errno, $errstr, 30)) {

				//API Url
				$url = $urlprefix.$serverurl[0].':'.$serverurl[1].'/pdfgen/'.$kind;

				 fclose($socket);
				break;
			}
		}




		//Initiate cURL.
		$ch = curl_init($url);

		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($data);

		//Tell cURL that we want to send a POST request.
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//Attach our encoded JSON string to the POST fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

		//Set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		//Execute the request
		$result = curl_exec($ch);
		curl_close($ch);

		file_put_contents($filename, $result, LOCK_EX);

	}



	//output geraete/uebersicht/$oid als json format
	function genpdf_uebersicht($oid="") {
		$data = $this->Geraete_model->pdfdata($oid);
		$typ='1'; //übersicht pdf
		$filename = $this->File_model->get_file_pfad($typ,$oid);
		//$filename = $data['filename'];
		//unset($data['filename']);

		$this->generate_pdf('uebersicht', $data, $filename);
		//echo $filename;
		//redirect('orte');
	}

	function genpdf_protokoll($pruefung_id="") {
		$data = $this->Pruefung_model->pdfdata($pruefung_id);

		$typ='2'; //protokoll pdf
		$filename = $this->File_model->get_file_pfad($typ,$pruefung_id);
		//$filename = $data['filename'];
		//unset($data['filename']);




		$this->generate_pdf('protokoll', $data, $filename);
		//echo $filename;
		//redirect('orte');
	}




	function json_uebersicht($oid="") {
		$data = $this->Geraete_model->pdfdata($oid);
		echo json_encode($data);
	}





	function json_protokoll($pruefung_id="") {
		$data = $this->data($pruefung_id);
		echo json_encode($data);
	}





}
