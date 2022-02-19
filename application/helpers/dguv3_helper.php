<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// erwartet True sonst kein zugriff
if ( ! function_exists('site_denied')) {
	function site_denied($logged_in) {
		if($logged_in === TRUE){			
			return;
		} else {
			
			redirect('login');
			exit;
			
		}
	}
}

// 
if ( ! function_exists('site_pagination')) {
	function site_pagination($basepath,$id,$pageid) {



		redirect($basepath.$id.'/'.$pageid);
	}
}


// todo nur bestimmte variablen übergeben für pdf server
if ( ! function_exists('pdf_clean_data')) {
	function pdf_clean_data($typ, $data) {

$return= $data;

		return $return;
	}
}

// return a single string with changes "old --> new"
if ( ! function_exists('log_change')) {
	function log_change($arrayold, $arraynew, $status) {

		#print_r($arrayold);
		#echo '<br><br>';
		#print_r($arraynew);
		if($status=='new') {

			$array_old=array();
			$array_new=$arraynew;

		} elseif($status=='edit') {

			$array_old=array_diff_assoc($arrayold,$arraynew);
			$array_new=array_diff_assoc($arraynew,$arrayold);

		} elseif($status=='delete') {
			
			$array_old=$arrayold;
			$array_new=array();

		} else {return null;}
		

			

		#print_r($array_old);
		#echo '<br><br>';
		#print_r($array_new);
		
		$array_oldjson= json_encode($array_old);
		$array_newjson= json_encode($array_new);

		$result=$array_oldjson.' ; '.$array_newjson;

		if(!empty($array_old) || !empty($array_new)) {return $result;}
	}
}