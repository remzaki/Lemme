<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function preset()
    {
        $this->load->model('db_model');
        
        $conn_str = $this->db_model->preset();

        if(!$conn_str){
            // ERROR
            header($_SERVER["SERVER_PROTOCOL"]." 444 No Response");
            exit();
        }

        header('Content-type: application/json');
        echo json_encode($conn_str);
    }
}