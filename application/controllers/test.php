<?php
/**
 * @copyright (C) 2012 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jens Segers <jens at iRail.be>
 * @author Hannes Van De Vreken <hannes at iRail.be>
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class test extends CI_Controller {
    
    function index() {
        if ($this->input->post('checkin')) {
            echo "succes";
            $json = $this->input->post('checkin') ;
            echo json_decode( $json ) ;
        }else{
            echo "failure";
        }
    }
}
