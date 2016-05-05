<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Params extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {	
        $this->load->view('params');
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
    
    public function details()
    {
        $this->load->model('params_model');

        $postdata = file_get_contents("php://input");
        $data = json_decode($postdata);
        $server = $data->server;
        $instance = $data->instance;
        $username = $data->username;
        $password = $data->password;
        $group = $data->group;
        $field = $data->field;
        $database = 'RTEEnterpriseOptionsData';

        if( (!isset($server)) OR (!isset($instance)) OR (!isset($username)) OR (!isset($password)) ){
            header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
            exit();
        }

        $result = $this->params_model->getdetails($server, $instance, $username, $password, $database, $group, $field);

        if(!$result){
                // DATABASE OFFLINE
                header($_SERVER["SERVER_PROTOCOL"]." 503 Service Unavailable");
                exit();
        }

        // DATABASE ONLINE
        header('Content-type: application/json');
        echo json_encode($result);
    }
    
    public function group()
    {
        $this->load->model('params_model');

        $postdata = file_get_contents("php://input");
        $data = json_decode($postdata);
        $server = $data->server;
        $instance = $data->instance;
        $username = $data->username;
        $password = $data->password;
        $group = $data->group;
        $database = 'RTEEnterpriseOptionsData';

        if( (!isset($server)) OR (!isset($instance)) OR (!isset($username)) OR (!isset($password)) ){
            header($_SERVER["SERVER_PROTOCOL"]." 400 Bad Request");
            exit();
        }

        $result = $this->params_model->getgroupdetails($server, $instance, $username, $password, $database, $group);

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
