<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poslogx extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {	
        $this->load->view('poslog');
    }

    public function preset()
    {
        $this->load->model('params_model');

        $conn_str = $this->params_model->preset();

        if(!$conn_str){
            // ERROR
            header($_SERVER["SERVER_PROTOCOL"]." 444 No Response");
            exit();
        }

        header('Content-type: application/json');
        echo json_encode($conn_str);
    }

    public function search()
    {
        $this->load->model('params_model');

        $postdata = file_get_contents("php://input");
        $data = json_decode($postdata);
        $server = $data->server;
        $instance = $data->instance;
        $username = $data->username;
        $password = $data->password;
        $database = 'RTEEnterpriseOptionsData';

        if( (!isset($server)) OR (!isset($instance)) OR (!isset($username)) OR (!isset($password)) ){
            header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
            exit();
        }

        if((isset($data->save)) AND ($data->save)){
                $this->params_model->update_default($server, $instance, $username, $password, $database);
        }

        $result = $this->params_model->search($server, $instance, $username, $password, $database);

        if(!$result){
                // DATABASE OFFLINE
                header($_SERVER["SERVER_PROTOCOL"]." 503 Service Unavailable");
                exit();
        }

        // DATABASE ONLINE
        header('Content-type: application/json');
        echo json_encode($result);
    }
}
