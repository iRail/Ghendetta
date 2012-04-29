<?php
/**
 * @copyright (C) 2012 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jens Segers <jens at iRail.be>
 * @author Hannes Van De Vreken <hannes at iRail.be>
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once (APPPATH . 'core/API_Controller.php');

class Stats extends API_Controller {
    
    function index() {
        $this->load->model('user_model');
        $this->load->model('checkin_model');
        $this->load->model('region_model');
        $this->load->model('venue_model');
        $this->load->model('clan_model');
        
        $data = array();
        $data['users'] = $this->user_model->count();
        $data['battles'] = $this->checkin_model->count();
        $data['regions'] = $this->region_model->count();
        $data['venues'] = $this->venue_model->count();
        $data['clans'] = $this->clan_model->count();
        
        return $data;
    }

}