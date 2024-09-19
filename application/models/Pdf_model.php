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

	function generate_pdf($typ, $data, $filename) {
		#print_r($data);
		$data= pdf_clean_data($typ, $data);

		
		$dir = dirname($filename);
		if (!file_exists($dir)) {
			mkdir($dir, 0777, true);
		}
		$url = null; // Initialize the variable to avoid "undefined variable" error
		$pdfserver = $this->config->item('dguv3_pdf_server');
		$i = 0;
		
		foreach ($pdfserver as $serverurl) {
			$i++;
		
			
			$test_url = $serverurl . '/pdfgen/ping';
			$check_url = $serverurl . '/pdfgen/' . $typ;
		
			// Initialize curl
			$ch = curl_init($test_url);
		
			// Set curl options
			curl_setopt($ch, CURLOPT_NOBODY, true);  // We don't need body
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);    // Timeout after 5 seconds
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL cert verification for testing purposes (not recommended in production)
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Return response
		
			// Execute request
			$response = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
			//echo "$check_url";
			// Check if the request was successful (HTTP 200)
			if ($http_code == 200) {
				$url = $check_url;
				curl_close($ch);
				break;
			}
		
			// Log if there's an error
			if (curl_errno($ch)) {
				log_message('error', "Curl error: " . curl_error($ch));
			}
		
			// Close the curl session
			curl_close($ch);
		}
		
		
// Check if a working URL was found
if ($url) {
    // Do something with the working $url
    // For example, send a request to generate a PDF
    echo "working server URL: " . $url. "<br>";


	//get pdf from server	
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
		$code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

		curl_close($ch);

		#print_r($code);

		if($code=='200') {
		file_put_contents($filename, $result, LOCK_EX);

		} else {
			echo '<br>';
			print_r($result);
			echo '<br>';
		}
		return $code;



} else {
    // Handle the case where no server was found
    log_message('error', "No available servers to handle the request.");
}
	

echo "no working server found <br>";
		
	}





	//output geraete/uebersicht/$oid als json format

	function genpdf_uebersicht($oid) {
		$data = $this->Geraete_model->pdfdata($oid);
		

		//$filename = $this->File_model->get_file_pfad($typ,$oid);
		
		if($data===NULL) {
			return null;
				}

		#print_r($data);
		#echo '<br><br>';

		$filename = $data['filename'];


		if($data['ort']['geraeteanzahl']=='0') {
			echo 'keine geräte im ort<br>';
			return null;

		}

		//unset($data['filename']);

		#echo json_encode($data);
		
		$code = $this->generate_pdf('uebersicht', $data, $filename);

		
		//echo $filename;
		//redirect('orte');
		if($code=='200') {

		return  $filename;
		} else { 
			echo 'error';
			print_r($code);
			echo '<br>';

			return null;}
		
	}



	function genpdf_protokoll($pruefung_id) {
		$data = $this->Pruefung_model->pdfdata($pruefung_id);

		if($data===NULL) {
			return null;
		}

		
		//$filename = $this->File_model->get_file_pfad($typ,$pruefung_id);
		$filename = $data['filename'];
		//unset($data['filename']);


		#echo json_encode($data);

		$code = $this->generate_pdf('protokoll', $data, $filename);

		//echo $filename;
		//redirect('orte');
		if($code=='200') {

			return  $filename;
			} else { 
				print_r($code);
				return null;}
	}




}
