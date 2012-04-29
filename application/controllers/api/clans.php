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
        $this->load->model('clan_model');
        $clans = $this->clan_model->get_all_stats();
        
        if (!$id) {
            return $clans;
        }
        
        foreach ($clans as $clan) {
            if ($clan['clanid'] == $id) {
                return $clan;
            }
        }
    }

}
