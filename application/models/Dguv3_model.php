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
    }
    
    
    
    
    // gibt row anzahl wert zurück var1 tabellen name ; var2 tabellen spalte; var3 wert
    function getcountdata($tblName, $tblcol = NULL, $tblvar = NULL)
    {
        $this->db->select('*');
        $this->db->from($tblName);
        
        if ($tblvar !== NULL) {
            $this->db->like($tblcol, $tblvar);
        } else {
            return $this->db->count_all_results();
        }
        
        return $this->db->count_all_results();
    }
    
    
    // gibt anzahl geräte die bestanden sind zurück
    
    // geräte bestanden: bestanden=1 und letztesdatum+10monate > today
    // geräte abgelaufen: bestanden=1 und letztesdatum+12monate< today
    // geräte bald abgelaufen: bestanden=1 und letztesdatum+10monate< today
    
    function getgeraete_bestanden_countdata($tblvar=NULL, $letztesdatum=NULL)
    {
        $this->db->select('geraete.*, orte.name AS ortsname, pruefung.bestanden, pruefung.datum AS letztesdatum, (select count(*) from pruefung as pr where geraete.gid = pr.gid) AS anzahl, pruefer.name as pruefername');
        $this->db->from('geraete');
        $this->db->join('orte', 'geraete.oid = orte.oid');
        $this->db->join('pruefung', 'pruefung.gid = geraete.gid AND pruefung.pruefungid = (SELECT pruefungid from pruefung as pr where geraete.gid = pr.gid order by datum desc, pruefungid desc limit 1)', 'LEFT');
        $this->db->join('pruefer', 'pruefer.pid = pruefung.pid', 'LEFT');
        
        

        
        //gibt geräte zurück die ungeprüft sind
        if ($tblvar===NULL) {
            $this->db->where('bestanden', NULL);
            
        //gibt geräte zurück die bestanden sind    
        } elseif($tblvar== '1') {
        	
        		//spalte anzahl wird nicht erkannt?
        		//spalte letztesdatum wird nicht erkannt?!
        
        	  //$this->db->where('letztesdatum <', '2020-01-01');
        	  //$this->db->where('letztesdatum <', $letztesdatum);
            $this->db->where('bestanden', $tblvar);
        
        
        //gibt andere geräte zurück; var=0 durchgefallen
        } else {
            $this->db->where('bestanden', $tblvar);
        }
        return $this->db->count_all_results();
        
    }
    
    
    
   
    
    
    
}