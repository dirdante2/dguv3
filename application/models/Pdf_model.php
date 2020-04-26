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



    }

	function generate_pdf($kind, $data, $filename) {
		$dir = dirname($filename);
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}

		//API Url
		$url = 'https://olive-copper-spitz-json2pdf.herokuapp.com/pdfgen/'.$kind;

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

// aufruf geräte pdf
	private function data($oid="") {
		$data['ort'] = $this->Orte_model->get($oid);
		$data['geraete'] = $this->Geraete_model->getByOid($oid);
		$data['dguv3_show_geraete_col']= $this->config->item('dguv3_show_geraete_pdf_col');
		$data['dguv3_logourl']= $this->config->config['base_url'].$this->config->item('dguv3_logourl');
		$data['qrcode']= 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data='.$this->config->config['base_url'].'/index.php/geraete/index/'.$oid;

		// generate filename
		$year = date("Y");
		$ortsname = $data['ort']['name'];
		$firma_id = $data['ort']['orte_firmaid'];
		$filename = 'pdf/'.$firma_id.'/'.$year.'/'.$ortsname.'_'.$oid.'/'.$ortsname.'_liste.pdf';
		$data['filename'] = $filename;

		//var die nicht in json nötig sind
		unset($data['ort']['orte_firmaid']);

		return $data;
	}

	//output geraete/uebersicht/$oid als json format
	function genpdf($oid="") {
		$data = $this->data($oid);
		$filename = $data['filename'];
		unset($data['filename']);

		$this->generate_pdf('uebersicht', $data, $filename);
		//echo $filename;
		//redirect('orte');
	}

	function json($oid="") {
		$data = $this->data($oid);
		echo json_encode($data);
	}






}
