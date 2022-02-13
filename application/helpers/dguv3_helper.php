<?php

defined('BASEPATH') OR exit('No direct script access allowed');

#erwartet True 
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
if ( ! function_exists('site_pagination')) {
	function site_pagination($basepath,$oid,$pageid) {



		redirect($basepath.$oid.'/'.$pageid);
	}
}

if ( ! function_exists('pdf_clean_data')) {
	function pdf_clean_data($typ, $data) {

$return= $data;

		return $return;
	}
}
	