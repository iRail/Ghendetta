<?php
/**
 * @copyright (C) 2012 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jens Segers <jens at iRail.be>
 * @author Hannes Van De Vreken <hannes at iRail.be>
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class checkin_model extends CI_Model {
    
    function insert($checkin) {
        // get region clan before checkin
        $this->load->model('region_model');
        $region_before = $this->region_model->get_leader($checkin['regionid']);
        
        // calculate checkin points
        $checkin['points'] = $this->calculate_points($checkin['userid'], $checkin['date']);
        
        // insert checkin
        $this->db->insert('checkins', $checkin);
        $checkinid = $this->db->insert_id();
        
        // get user information
        $this->load->model('user_model');
        $user = $this->user_model->get_stats($checkin['userid']);
        
        // get clan capo
        $this->load->model('clan_model');
        $capo = $this->clan_model->get_capo($user['clanid']);
        
        // new capo
        if ($capo && $user['points'] > $capo['points'] && $capo['clanid'] == $user['clanid']) {
            $this->clan_model->update($user['clanid'], array('capo' => $user['fsqid']));
            
            $this->load->model('notification_model');
            
            // insert rank_won notification
            $notification = array();
            $notification['type'] = 'rank_won';
            $notification['to'] = $user['clanid'];
            $notification['to_type'] = 'clan';
            $notification['data'] = array('rank' => 1, 'name' => $user['firstname'], 'userid' => $user['fsqid']);
            $this->notification_model->insert($notification);
        }
        
        // check for different region leader, but only if current user is in different clan!
        if ($user['clanid'] != $region_before['clanid']) {
            $region_after = $this->region_model->get_leader($checkin['regionid']);
            if ($region_after['clanid'] != $region_before['clanid']) {
                $this->region_model->update($checkin['regionid'], array('leader' => $region_after['clanid']));
                
                $this->load->model('notification_model');
                
                // insert region_lost notification
                if($region_before['clanid']) {
                    $notification = array();
                    $notification['type'] = 'region_lost';
                    $notification['to'] = $region_before['clanid'];
                    $notification['to_type'] = 'clan';
                    $notification['data'] = array('region' => $region_after['region'], 'clanid' => $region_after['clanid'], 'clan' => $region_after['name'], 'color' => $region_after['color']);
                    $this->notification_model->insert($notification);
                }
                
                // insert region_won notification
                $notification = array();
                $notification['type'] = 'region_won';
                $notification['to'] = $region_after['clanid'];
                $notification['to_type'] = 'clan';
                $notification['data'] = array('region' => $region_after['region'], 'clanid' => $region_after['clanid'], 'clan' => $region_after['name'], 'color' => $region_after['color']);
                $this->notification_model->insert($notification);
            }
        }
    }
    
    function exists($checkinid) {
        return $this->db->where('checkinid', $checkinid)->count_all_results('checkins') != 0;
    }
    
    function get_all() {
        return $this->db->get('checkins')->result_array();
    }
    
    function get_since($userid, $since) {
        return $this->db->where('userid', $userid)->where('date >=', $since)->get('checkins')->result_array();
    }
    
    function get_unique_since($userid, $since) {
        return $this->db->where('userid', $userid)->where('date >=', $since)->group_by('venueid')->get('checkins')->result_array();
    }
    
    function get_last($userid) {
        return $this->db->where('userid', $userid)->order_by('date', 'desc')->limit(1)->get('checkins')->row_array();
    }
    
    function count($userid = FALSE) {
        if ($userid) {
            return $this->db->where('userid', $userid)->count_all_results('checkins');
        } else {
            return $this->db->count_all('checkins');
        }
    }
    
    function count_since($userid, $since = NULL) {
        // count_since(timestamp)
        if (is_null($since)) {
            $since = $userid;
            $userid = FALSE;
        }
        
        if ($userid) {
            return $this->db->where('userid', $userid)->where('date >=', $since)->count_all_results('checkins');
        } else {
            return $this->db->where('date >=', $since)->count_all_results('checkins');
        }
    }
    
    function count_between($userid, $start, $end = NULL) {
        // count_between(start, end)
        if (is_null($end)) {
            $end = $start;
            $start = $userid;
            $userid = FALSE;
        }
        
        if ($userid) {
            return $this->db->where('userid', $userid)->where('date >=', $start)->where('date <=', $end)->count_all_results('checkins');
        } else {
            return $this->db->where('date >=', $start)->where('date <=', $end)->count_all_results('checkins');
        }
    }
    
    /**
     * Points algorithm, calculate next checkin points based on history
     * @param int $userid
     * @param int $time
     */
    function calculate_points($userid, $time) {
        /* 
         * Short term: 15 minutes
         * Mid term: 1 hour
         * Long term: 24 hours
         */
        
        $short_term = $this->count_between($userid, $time - 900, $time) + 1;
        $mid_term = $this->count_between($userid, $time - 3600, $time) + 1;
        $long_term = $this->count_between($userid, $time - 86400, $time) + 1;
        
        $ratio = 1;
        
        if ($short_term > 3) {
            $ratio *= pow(0.90, $short_term - 3);
        }
        
        if ($mid_term > 6) {
            $ratio *= pow(0.95, $mid_term - 6);
        }
        
        if ($long_term > 30) {
            $ratio *= pow(0.90, $long_term - 30);
        }
        
        return $ratio;
    }

}