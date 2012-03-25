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
    
    function get_all() {
        return $this->db->get('clans')->result_array();
    }

    function get_clan_members( $clanid ){
        return $this->db->query( sprintf( "select * from users where clanid = %d", $clanid ) )->result_array();
    }
}

?>
