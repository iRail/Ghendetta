<?php
/**
 * @copyright (C) 2012 by iRail vzw/asbl
 * @license AGPLv3
 * @author Jens Segers <jens at iRail.be>
 * @author Hannes Van De Vreken <hannes at iRail.be>
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Adapter extends CI_Driver_Library {
    
    protected $valid_drivers = array('Adapter_foursquare');
    protected $adapter = 'foursquare';
    
    public function __construct($config = array()) {
        if (isset($config['adapter']) && in_array('adapter_'.$config['adapter'], array_map('strtolower', $this->valid_drivers))) {
            $this->adapter = $config['adapter'];
        }
    }
    
    function __call($method, $args = array()) {
        return call_user_func_array(array($this->{$this->adapter}, $method), $args);
    }

}