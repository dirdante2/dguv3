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
<<<<<<< HEAD
}

//gibt immer array zurück aber wenn keine inputdaten vorhanden dann 0
if ( ! function_exists('get_product_typ_pic_url')) {
	function get_product_typ_pic_url($data) {
		if($data===NULL) {
			$data['typ']=0;
			#return NULL;
		}
		#print_r($data);

		if($data['typ']) {
			$typ=$data['typ'];
		
		} else {
			$typ=0;
		}
		

				$search = array(" ", ",", ".", "ä", "ü", "ö");		
				$replace = array("_", "_", "_", "ae", "ue", "oe");				
				$typ= str_replace($search, $replace, $typ);


				$url['url_orginal']=base_url().'application/bilder/product_typ/orginal/'.$typ.'.jpg';
				$url['url_medium']=base_url().'application/bilder/product_typ/medium/'.$typ.'.jpg';
				$url['url_small']=base_url().'application/bilder/product_typ/small/'.$typ.'.jpg';
				$url['path_orginal']='application/bilder/product_typ/orginal/'.$typ.'.jpg';



				if (file_exists($url['path_orginal'])) {$url['pic_exist']=TRUE;} else {$url['pic_exist']=FALSE;}
	
		return $url;
	}
=======
>>>>>>> 10346586e10449e2b380656870ba181159d8dea2
}