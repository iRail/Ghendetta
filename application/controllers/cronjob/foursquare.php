<?php
/**
 * @copyright (C) 2012 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jens Segers <jens at iRail.be>
 * @author Hannes Van De Vreken <hannes at iRail.be>
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Foursquare extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        // load foursquare api
        $this->load->library('foursquare_api', '', 'foursquare');
        
        // load the foursquare adapter
        $this->load->driver('adapter', array('adapter' => 'foursquare'));
        
        $user = $this->auth->current_user();
        if (!($user && $user['admin']) && !$this->input->is_cli_request()) {
            show_error('You have not permission to access this page');
        }
    }
    
    function index() {
        if (!$this->input->is_cli_request()) {
            $this->output->enable_profiler(TRUE);
        }
        
        $this->users();
        
        if (!$this->input->is_cli_request()) {
            $this->output->set_profiler_sections(array('queries' => TRUE));
        }
    }
    
    function users() {
        echo "Cronjob started at " . date('d/m/Y H:i') . "\n";
        
        $limit = $this->input->get('limit') ? $this->input->get('limit') : FALSE;
        $user = $this->input->get('user') ? $this->input->get('user') : FALSE;
        
        $this->load->model('user_model');
        if (!$user) {
            $users = $this->user_model->get_all_rand($limit);
        } else {
            $user = $this->user_model->get($user);
            $users = $user ? array($user) : array();
        }
        
        // count updated users
        $count = 0;
        
        $this->load->model('checkin_model');
        foreach ($users as $user) {
            
            // furthest to back in time
            $since = time() - 604800;
            
            // check if last checkin was newer
            if ($last = $this->checkin_model->get_last($user['fsqid'])) {
                $since = max($since, ($last['date'] - 3600));
            }
            
            $this->foursquare->set_token($user['token']);
            if ($json = $this->foursquare->api('users/' . $user['fsqid'] . '/checkins', array('afterTimestamp' => $since))) {
                
                // sort checkins
                $checkins = $json->response->checkins->items;
                usort($checkins, array($this, 'cmp_checkins'));
                
                $this->load->model('checkin_model');
                $this->load->model('venue_model');
                
                foreach ($checkins as $object) {
                    // convert and insert checkin
                    $checkin = $this->adapter->checkin($object, array('userid' => $user['fsqid']));
                    $checkinid = $this->checkin_model->insert($checkin);
                    
                    if ($checkinid) {
                        $count++;
                        
                        // convert venue object
                        $venue = $this->adapter->venue($object->venue);
                        $this->venue_model->insert($venue);
                    }
                }
            
            } else {
                echo '#' . $user['fsqid'] . ': ' . $this->foursquare->error . "\n";
            }
        }
        
        echo "Cronjob inserted $count checkins for " . count($users) . " users at " . date('d/m/Y H:i') . "\n";
        echo "---------------------------------------------------------------\n";
    }
    
    /**
     * Sorts checkins based on their created timestamp
     * @param checkin $a
     * @param checkin $b
     * @return number
     */
    private function cmp_checkins($a, $b) {
        if ($a->createdAt == $b->createdAt) {
            return 0;
        }
        return $a->createdAt < $b->createdAt ? -1 : 1;
    }

}