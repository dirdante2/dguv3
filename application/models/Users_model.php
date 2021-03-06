<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/


defined('BASEPATH') OR exit('No direct script access allowed');


class Users_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

	function get($user_id=NULL) {

		$this->db->select('users.*, messgeraete.name as messgeraetname, pruefer.name as pruefername, orte.name as ortsname');
		$this->db->from('users');
		$this->db->join('messgeraete', 'users.user_mid = messgeraete.mid', 'LEFT');
		$this->db->join('pruefer', 'users.user_pid = pruefer.pid', 'LEFT');
		$this->db->join('orte', 'users.user_oid = orte.oid', 'LEFT');
		if($user_id!==NULL) {
			$this->db->having('users.user_id',$user_id);
		}

		$result = $this->db->get()->result_array();

		if(!empty($result)) {
			return $result[0];
		} else {
			return NULL;
		}
	}

	function list($user_id=NULL) {
        $this->db->select('users.*, firmen.firma_name,messgeraete.name as messgeraetname, pruefer.name as pruefername, orte.name as ortsname');
        $this->db->from('users');
        $this->db->join('messgeraete', 'users.user_mid = messgeraete.mid', 'LEFT');
        $this->db->join('pruefer', 'users.user_pid = pruefer.pid', 'LEFT');
		$this->db->join('orte', 'users.user_oid = orte.oid', 'LEFT');
		$this->db->join('firmen', 'users.users_firmaid = firmen.firmen_firmaid', 'LEFT');
        if($user_id!==NULL) {
            $this->db->having('users.user_id',$user_id);
        }

        return $this->db->get()->result_array();
    }

	function new($data) {
		$this->db->insert('users',$data);
		return $this->db->insert_id();
	}

	function update($data,$user_id) {
		$this->db->where('user_id',$user_id);
		return $this->db->update('users',$data);
	}

	function delete($user_id) {
		$this->db->where('user_id',$user_id);
		return $this->db->delete('users');
	}

}
