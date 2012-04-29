<?php

class API_Controller extends CI_Controller {
    
    protected $ttl = 60;
    
    function output($data) {
        set_status_header(200);
        header('Content-type: application/json');
        echo json_encode($data);
    }
    
    function error($message, $code = 500) {
        set_status_header($code);
        header('Content-type: application/json');
        die(json_encode(array('error' => $message, 'code' => $code)));
    }
    
    function _remap($method_name, $args = array()) {
        // load cache driver
        $this->load->driver('cache');
        
        $id = $this->uri->uri_string();
        
        // try cached endpoint
        if (!$data = $this->cache->get($id)) {
            
            if (method_exists($this, $method_name)) {
                $data = call_user_func_array(array($this, $method_name), $args);
            } elseif (method_exists($this, 'get')) {
                $data = call_user_func_array(array($this, 'get'), $args);
            } else {
                $this->error('Unknown API endpoint');
            }
            
            if (is_null($data) || $data === FALSE) {
                $this->error('No data returned');
            }
            
            // save cache
            $this->cache->save($id, $data, $this->ttl);
        }
        
        $this->output($data);
    }

}