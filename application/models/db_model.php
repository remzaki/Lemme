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
}