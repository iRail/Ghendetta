<?php

class clan_model extends CI_Model {
    
    function insert($clan) {
        return $this->db->insert('clans', $clan);
    }
    
    function update($clanid, $clan) {
        return $this->db->where('clanid', $clanid)->update('clans', $clan);
    }
    
    function get($clanid) {
    	return $this->db->where('clanid', $clanid)->get('clans')->row_array();
    }

}