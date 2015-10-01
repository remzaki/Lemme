<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/****************************************
 * Search Users in Enterprise Database Server
 * Using CoreDb
 * 
 * Search
 * Unlock
 * Status
 * Details
 * 
 */
class Users extends CI_Controller {

    public function index()
    {
        $this->load->view('users');
    }

    public function connect()
    {
        $this->load->model('users_model');

        $postdata = file_get_contents("php://input");
        $data = json_decode($postdata);

        $server = $data->server;
        $instance = $data->instance;
        $username = $data->username;
        $password = $data->password;
        $database = 'CoreDb';

        $result = $this->users_model->dbconnect($server, $instance, $username, $password, $database);

        if(!$result){
            // DATABASE OFFLINE
            header($_SERVER["SERVER_PROTOCOL"]." 503 Service Unavailable");
            exit();
        }
        
        return $result;
    }
    
    public function search()
    {
        $this->load->model('users_model');

        $postdata = file_get_contents("php://input");
        $data = json_decode($postdata);

        $server = $data->server;
        $instance = $data->instance;
        $username = $data->username;
        $password = $data->password;
        $store = $data->store;
        $database = 'CoreDb';

        $dbcon_init = $this->users_model->dbconnect($server, $instance, $username, $password, $database);
        
        if(!$dbcon_init){
            // DATABASE OFFLINE
            header($_SERVER["SERVER_PROTOCOL"]." 503 Service Unavailable");
            exit();
        }
        
        $result = $this->users_model->search($server, $instance, $username, $password, $store ,$database, $dbcon_init);
        
        header('Content-type: application/json');
        echo json_encode($result);
    }
    
    public function details()
    {
        $this->load->model('users_model');

        $postdata = file_get_contents("php://input");
        $data = json_decode($postdata);

        $server = $data->server;
        $instance = $data->instance;
        $username = $data->username;
        $password = $data->password;
        $store = $data->store;
        $userid = $data->userid;
        $database = 'CoreDb';

        $dbcon_init = $this->users_model->dbconnect($server, $instance, $username, $password, $database);
        
        if(!$dbcon_init){
            // DATABASE OFFLINE
            header($_SERVER["SERVER_PROTOCOL"]." 503 Service Unavailable");
            exit();
        }
        
        $result = $this->users_model->details($server, $instance, $username, $password, $store ,$database, $dbcon_init, $userid);
        
        header('Content-type: application/json');
        echo json_encode($result);
    }
    
    public function unlock()
    {
        $this->load->model('users_model');

        $postdata = file_get_contents("php://input");
        $data = json_decode($postdata);

        $server = $data->server;
        $instance = $data->instance;
        $username = $data->username;
        $password = $data->password;
        $userid = $data->userid;
        $database = 'CoreDb';

        $dbcon_init = $this->users_model->dbconnect($server, $instance, $username, $password, $database);
        
        if(!$dbcon_init){
            // DATABASE OFFLINE
            header($_SERVER["SERVER_PROTOCOL"]." 503 Service Unavailable");
            exit();
        }
        
        $result = $this->users_model->unlock($server, $instance, $username, $password, $database, $dbcon_init, $userid);
        
        header('Content-type: application/json');
        echo json_encode($result);
    }
}
