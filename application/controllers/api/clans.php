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

class Clans extends API_Controller {
    
    function get($id = FALSE) {
        // try from cache
        if (!$clans = $this->cache->get("api/clans.cache")) {
            // cache miss
            $this->load->model('clan_model');
            $clans = $this->clan_model->get_all_stats();
            
            // save cache
            $this->cache->save("api/clans.cache", $clans, 300);
        }
        
        // return the right clan depending on the supplied id
        if ($id) {
            foreach ($clans as $clan) {
                if ($clan['clanid'] == $id) {
                    $this->output($clan);
                    break;
                }
            }
        } else {
            $this->output($clans);
        }
    }

    function shout(){
        if ($user = $this->auth->current_user()) {
            // one must be logged in, at least.
            $fsqid = $user['fsqid'];
            
            $this->load->model('clan_model');
            $clan = $this->clan_model->get($user['clanid']) ;
            if( $fsqid != $clan['capo'] ){
                // no homo. Errr... Capo
                $data['error'] = 1 ;
                $data['error_msg'] = "You are not the capo of your clan, you are not allowed to make clan shouts";
            }else if( !$this->input->post('shout') ){
                // no shout is posted
                $data['error'] = 2 ;
                $data['error_msg'] = "Please send a shout via post request";
            }else{
                if( $this->input->post('shout') == '' ){
                    // shout is empty
                    $data['error'] = 3 ;
                    $data['error_msg'] = "shout cannot be empty, stupid!";
                }if( strlen($this->input->post('shout')) > 140 ){
                    // shout's too long
                    $data['error'] = 4 ;
                    $data['error_msg'] = "shout cannot be longer then 140 characters.";
                }else{
                    // gather data
                    $data["userid"] = $user["fsqid"];
                    $data["name"] = $user["firstname"];
                    $data["shout"] = $this->input->post('shout');
                    
                    // build notification
                    $notification["to_type"] = "clan";
                    $notification["to"] = $user['clanid'];
                    $notification["type"] = "message" ;
                    $notification["data"] = $data ;

                    // store notification
                    $this->load->model('notification_model');
                    $notification["notificationid"] = $this->notification_model->insert( $notification );
                    
                    // return no errors & notification
                    $data = NULL ;
                    $data["error"] = 0;
                    // suggestive:
                    //$data["error_msg"] = "you can only do one shout every 5 minutes" ;
                    $data["notification"] = $notification ;
                }
            }
            $this->output( $data );
        } else {
            $this->error('Not authenticated', 401);
        }
    }
    
    function _remap($method) {
        switch ($method) {
            case 'index' :
                $this->get();
                break;
            case 'shout' :
                $this->shout();
                break;
            default :
                $this->get($method);
        }
    }

}
