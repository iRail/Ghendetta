<?php
/**
 * @copyright (C) 2012 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jens Segers <jens at iRail.be>
 * @author Hannes Van De Vreken <hannes at iRail.be>
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clan extends MY_Controller {
    
    function index() {
        $this->load->driver('cache');
        
        if ($user = $this->auth->current_user()) {
            $clanid = $user['clanid'];
            
            // try from cache
            if (!$data = $this->cache->get("members-$clanid.cache")) {
                // cache miss
                $this->load->model('clan_model');
                $members = $this->clan_model->get_members($clanid);
                $clan = $this->clan_model->get_stats($clanid);
                
                $data = array('members' => $members, 'clan' => $clan, 'user' => $user);
                
                // save cache
                $this->cache->save("members-$clanid.cache", $data, 60);
            }
            
            $this->load->view('clan', $data);
        } else {
            redirect();
        }
    }
    
    function shout() {
        // no no no no
        if (!$user = $this->auth->current_user()) {
            redirect();
        }
        
        $this->load->model('clan_model');
        $clan = $this->clan_model->get($user['clanid']);
        
        if ($clan['capo'] != $user['fsqid']) {
            // you are not the capo of your clan, you are not allowed to make clan shouts
            redirect('clan');
        }
        
        if (!$this->input->post('shout')) {
            // no shout detected
            redirect('clan');
        }
        
        $this->load->model('notification_model');
        
        $notification = array();
        $notification['to_type'] = 'clan';
        $notification['to'] = $user['clanid'];
        $notification['type'] = 'message';
        $notification['data'] = array('userid' => $user['fsqid'], 'name' => $user['firstname'], 'message' => $this->input->post('message'));
        
        $this->notification_model->insert($notification);
        
        redirect('clan');
    }

}