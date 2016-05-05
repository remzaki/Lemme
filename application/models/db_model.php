<?php
class db_model extends CI_Model {

    public function __construct()
    {

    }

    public function dbcon_init($server, $instance, $username, $password, $database)
    {
        $target = $server."\\".$instance;

        $config['hostname'] = $target;
        $config['username'] = $sqlsrv['UID'] = $username;
        $config['password'] = $sqlsrv['PWD'] = $password;
        $config['database'] = $sqlsrv['Database'] = $database;
        $config['dbdriver'] = "sqlsrv";
        $config['dbprefix'] = "";
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = "";
        $config['char_set'] = "utf8";
        $config['dbcollat'] = "utf8_general_ci";
        $sqlsrv['LoginTimeout'] = 2;

        // Connect to MSSQL
        $conn = sqlsrv_connect($target, $sqlsrv);

        if($conn === FALSE){	// ERROR
                $error = sqlsrv_errors();
                return $error;
        }else{	// OK
            $this->update_pref($server, $instance, $username, $password);
            
            $init = $this->load->database($config, TRUE);

            if($init->initialize()){
                    if($this->load->database($config) === FALSE){
                            // print("Database Connection Error Encountered!");
                    }
            }else{
                    return "Database Connection Failed";
            }
            return $init;
        }
//                print_r($config);
    }

    public function dbcon_check($db){
        if(!is_object($db)){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function update_pref($server, $instance, $username, $password)
    {
        $ip = $this->input->ip_address();
        if( ! $this->input->valid_ip($ip) ){
            return FALSE;
        }
        
        $this->load->database();

        $date=date("m-d-Y D g:i:s A");
        $query = "INSERT INTO userpref (Server, Instance, Username, Password, User, DateAdded) VALUES (?, ?, ?, ?, ?, ?)"
                . "ON DUPLICATE KEY UPDATE Server=VALUES(Server), Instance=VALUES(Instance), Username=VALUES(Username), Password=VALUES(Password), DateAdded=VALUES(DateAdded)";
        $res = $this->db->query($query, array($server, $instance, $username, $password, $ip, $date));

        if ($res){
            return TRUE;
        }
    }
     /*end of update_default*/
        
    public function preset()
    {
        $ip = $this->input->ip_address();
        if( ! $this->input->valid_ip($ip) ){
            return FALSE;
        }
        
        $this->load->database();
        
        $query = 'SELECT Server, Instance, Username, Password FROM userpref WHERE User = ? ORDER BY ID DESC LIMIT 1';
        $res = $this->db->query($query, array($ip));

        if ($res->num_rows() > 0){
            return $res->result();
        }
        else{
            return FALSE;
        }
    }
     /*end of preset*/
    
}