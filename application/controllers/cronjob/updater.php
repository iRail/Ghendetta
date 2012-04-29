<?php
/**
 * @copyright (C) 2012 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jens Segers <jens at iRail.be>
 * @author Hannes Van De Vreken <hannes at iRail.be>
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Updater extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        $user = $this->auth->current_user();
        if (!($user && $user['admin']) && !$this->input->is_cli_request()) {
            show_error('You have not permission to access this page');
        }
    }
    
    function index() {
        if (!$this->input->is_cli_request()) {
            $this->output->enable_profiler(TRUE);
        }
        
        $this->regions();
        $this->clans();
        
        if (!$this->input->is_cli_request()) {
            $this->output->set_profiler_sections(array('queries' => TRUE));
        }
    }
    
    function regions() {
        $this->load->model('region_model');
        $regions = $this->region_model->get_all();
        
        foreach ($regions as $region) {
            $leader = $this->region_model->get_leader($region['regionid']);
            
            // no leader, eg: after db reset
            if (!$leader) {
                $this->region_model->update($region['regionid'], array('leader' => 0));
            } else if ($leader['clanid'] != $region['leader']) {
                $this->region_model->set_leader($region['regionid'], $leader['clanid'], $region['leader']);
                echo $region['name'] . ' -> ' . $leader['name'] . "\n";
            }
        }
    }
    
    function clans() {
        $this->load->model('clan_model');
        $clans = $this->clan_model->get_all();
        
        foreach ($clans as $clan) {
            $capo = $this->clan_model->get_capo($clan['clanid']);
            
            // no capo, eg: after db reset
            if (!$capo) {
                $this->clan_model->update($clan['clanid'], array('capo' => 0));
            } else if ($capo['fsqid'] != $clan['capo']) {
                $this->clan_model->set_capo($clan['clanid'], $capo['fsqid']);
                echo $clan['name'] . ' -> ' . $capo['firstname'] . ' ' . $capo['lastname'] . "\n";
            }
        }
    }

}