<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {
    
    public function index() {
        $this->load->model('region_model');
        $regions = $this->region_model->battlefield();
        
        if ($user = $this->ghendetta->current_user()) {
            $this->load->model('checkin_model');
            $checkins = $this->checkin_model->get_since($user['fsqid'], time() - (608400));
        } else {
            $checkins = array();
        }
        
        $this->load->view('map', array('regions' => $regions, 'checkins' => $checkins));
    }
}
