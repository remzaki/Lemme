<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poslog extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        //$this->load->library('form_validation');
        $this->load->library('Aid');
        $this->load->library('session');
    }

    public function index()
    {
        $action = $this->input->get('action');
        $idtrn = $this->uri->segment(2);
        if($idtrn!=''){
            if( (!$idtrn) OR (!ctype_digit($idtrn)) OR (strlen($idtrn)!=32) ){	//	CHECK: IF EMPTY || IF NUMERIC || IF 32 CHARS
                show_404();
                exit();
            }else{
                $this->doXML($action, $idtrn);
            }
        }
        else{
            $this->load->view('poslog');
        }
    }
    
    public function doXML($action, $idtrn) {
        $data = $this->getXML($idtrn);
        if($data['status']=='error'){
            header($_SERVER["SERVER_PROTOCOL"]." ".$data['heading']);
            $data['message2'] = 'If you think that this is a problem with the code then please file an issue to Github ';
            $this->load->view('errors/html/error_503', $data);
        }else{
            foreach($data['result'] as $xml){
                $out = $xml->XMLPayload;
            }
            
            if($action == 'download'){
               $this->output
                    ->set_content_type('text/xml')
                    ->set_output($out)
                    ->set_header('Content-disposition: attachment; filename="'.$idtrn.'.xml"');	// TO DOWNLOAD THE XML
            }
            else{
                $this->output
                    ->set_content_type('text/xml')
                    ->set_output($out);
            }
        }
    }
    
    public function getXML($idtrn) {
        // this function gets the xml on the database and returns it
        
        $this->load->model('users_model');
        //echo $idtrn;
        $this->load->model('poslog_model');
        
        $server = $this->session->userdata('server');
        $instance = $this->session->userdata('instance');
        $table = $this->session->userdata('table');
        $username = $this->session->userdata('username');
        $password = $this->session->userdata('password');
        $database = 'TransactionLogDb';
        if(($server=='') OR ($table=='') OR ($username=='') OR ($password=='')){
            $data = array(
                'status' => 'error',
                'heading' => '412 Precondition Failed',
                'message' => 'Please make sure that you entered the correct Name or IP Address of the Server.'
            );
            return $data;
        }
        
        $dbcon_init = $this->users_model->dbconnect($server, $instance, $username, $password, $database);
        if(!$dbcon_init){
            $data = array(
                'status' => 'error',
                'heading' => '599 Network Connect Timeout Error',
                'message' => 'Please make sure that you entered the correct Name or IP Address or SQL Instance of the Server. And make sure that the Server is connected to the Network.'
            );
            return $data;
        }
        
        $result = $this->poslog_model->getPOSLog($dbcon_init, $table, $idtrn);
        if(!$result){
            $data = array(
                'status' => 'error',
                'heading' => '404 Not Found',
                'message' => "The POSLog Transaction was not found in the Server. Do this matter by hand, look for the specific Transaction in the Database, <i style='font-size:50%;'>I bet you cant find it too.</i>"
            );
            return $data;
        }
        
        $data = array(
                'status' => 'success',
                'result' => $result
            );
        return $data;
    }
    
    public function transtypes($dbcon_init){
        $this->load->model('users_model');
        $this->load->model('poslog_model');
        
        $result = $this->poslog_model->gettranstypes($dbcon_init);
        if(!$result){
            return FALSE;
        }
        return $result;
    }
    
    public function search()
    {
        $this->load->model('users_model');
        $this->load->model('poslog_model');

        $postdata = file_get_contents("php://input");
        $data = json_decode($postdata);

        $server = $data->server;
        $instance = $data->instance;
        $username = $data->username;
        $password = $data->password;
        $database = 'NCRWO_EJ';
        $row = $data->i;
        $table = $data->table;
        $store = $data->store;
        $term = $data->term;
        $trans = $data->trans;
        $transtype = $data->transtype;

        $dbcon_init = $this->users_model->dbconnect($server, $instance, $username, $password, $database);
        
        if(!$dbcon_init){
            // DATABASE OFFLINE
            header($_SERVER["SERVER_PROTOCOL"]." 503 Service Unavailable");
            exit();
        }
        
        $this->aid->doSession($server, $instance, $table, $username, $password);
        $filter = $this->aid->filter($table, $store, $term, $trans, $transtype);
        $transtypes = $this->transtypes($dbcon_init);
        $result = $this->poslog_model->search($dbcon_init, $row, $table, $filter);
        if($result){
            header('Content-type: application/json');
            echo json_encode(array($result[0], $transtypes, $result[1], $filter));
        }
        else{
            header($_SERVER["SERVER_PROTOCOL"]." 404 No Results");
        }
        
    }
}
