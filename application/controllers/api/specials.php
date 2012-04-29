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

class Specials extends API_Controller {
    
    function index() {
        $this->load->model('special_model');
        $specials = $this->special_model->get_all_active();
        
        return $specials;
    }

}
