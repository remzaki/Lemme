<?php
class Page_model extends CI_Model {

	public function __construct()
	{
		$this->load->library('session');
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
		
	}
	/*end of dbcon_init*/
	
	public function get_poslog_list($server, $instance, $username, $password, $database, $table, $top, $filter){
		$database = "NCRWO_EJ";
		$top = 'TOP '.$top;
		
		$dbcon_init = $this->page_model->dbcon_init($server, $instance, $username, $password, $database);
		if(!is_object($dbcon_init)){
			$error['error_message'] = $dbcon_init;	// Error in Connecting the Database
			return $error;
			die();
		}
		
		if($table=="Transactions")	// Transactions
		{
			$sql = "SELECT ".$top." TransactionTypeDictionary.TransactionTypeDescription as TransType,
			TransactionNode.TransactionID as TranID,
			TransactionNode.StoreId as StoreId,
			TransactionNode.WorkstationID as TermId,
			TransactionTypeDictionary.TransactionTypeID as TransTypeId,
			TransactionNode.TransactionDateTime as TransDate
			FROM ".$database."..TransactionNode
			JOIN ".$database."..TransactionTypeDictionary ON TransactionNode.TransactionTypeID=TransactionTypeDictionary.TransactionTypeID
			".$filter."
			ORDER BY TransactionNode.TransactionDateTime DESC
			";
		}
		else	// ErrorQueue, InputQueue, OutputQueue, PendingQueue
		{
			$database = "TransactionLogDb";
			$sql = "SELECT ".$top." * FROM ".$database."..".$table." ".$filter."";
		}
		
		$result = $dbcon_init->query($sql);
		
		$data = $result->result();
		$datas = array($data, $sql);
		
		if ($result->num_rows() > 0)
		{
			return $datas;
		}
		else
		{
			$error['error_empty'] = "No Results Found";
			$datas = array($error, $sql);
			return $datas;
		}
		$this->db->close();
	}
	/*end of get_poslog_list*/
	
	public function get_poslog($server, $instance, $username, $password, $table, $id_trn){
		$database = "TransactionLogDb";
		
		$dbcon_init = $this->page_model->dbcon_init($server, $instance, $username, $password, $database);
		if(!is_object($dbcon_init)){
			$error['error_message'] = $dbcon_init;	// Error in Connecting the Database
			return $error;
			die();
		}
		
		$sql = "SELECT TOP 1 XMLPayload FROM ".$table." WHERE TransactionKey = ".$id_trn." ";

		$result = $this->db->query($sql); 
		
		if ($result->num_rows() > 0)
		{
			return $result->result();
		}
		else
		{
			return "Nothing found!";
		}
		$this->db->close();
	}
	/*end of get_poslog*/
	
	public function get_transtypes($server, $instance, $username, $password){
		$database = "NCRWO_EJ";
		
		$dbcon_init = $this->page_model->dbcon_init($server, $instance, $username, $password, $database);
		if(!is_object($dbcon_init)){
			return FALSE;
		}
		
		// GET THE Transaction Type IDs
		$sql = "SELECT TransactionTypeID, TransactionTypeDescription FROM TransactionTypeDictionary";

		$result = $dbcon_init->query($sql); 
		
		if ($result->num_rows() > 0)
		{
			return $result->result();
		}
		else{
			return FALSE;
		}
		$this->db->close();
	}
	/*end of get_transtypes*/
	
	public function url_gen($server, $instance, $username, $password, $table, $top, $store_filter, $term_filter, $trans_filter, $transtype){
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = "ps_db";
		$config['dbdriver'] = "mysql";
		$config['dbprefix'] = "";
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = "";
		$config['char_set'] = "utf8";
		$config['dbcollat'] = "utf8_general_ci";

		$init = $this->load->database($config, TRUE);
		
		if($init->initialize()){
			if($this->load->database($config) === FALSE){
				print("Database Connection Error Encountered!");
			}
		}else{
			return "Database Connection Failed";
		}
		
		$this->load->library('Aid');
		
		$id = rand(1, 100).'12345678'.rand(101, 200);	// 10 digit random number
		$aid = $this->aid->AlphaID($id, false, 8);
		
		$ip = $this->session->userdata('ip_address');
		
		$date=date("m-d-Y D g:i A");
		
		$details = array(
		'AID' => ($aid),
		'Server' => ($server),
		'Instance' => ($instance),
		'Username' => ($username),
		'Password' => ($password),
		'Table' => ($table),
		'Top' => ($top),
		'StoreFilter' => ($store_filter),
		'TermFilter' => ($term_filter),
		'TransFilter' => ($trans_filter),
		'TransType' => ($transtype),
		'IPAddress' => ($ip),
		'Date' => ($date)
		);
		
		if($this->db->insert('ps_data', $details)){
			return $aid;
		}
		else{
			return FALSE;
		}
		$this->db->close();
	}
	/*end of url_gen*/
	
	public function url_get($aid){
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = "ps_db";
		$config['dbdriver'] = "mysql";
		$config['dbprefix'] = "";
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = "";
		$config['char_set'] = "utf8";
		$config['dbcollat'] = "utf8_general_ci";

		$init = $this->load->database($config, TRUE);
		
		if($init->initialize()){
			if($this->load->database($config) === FALSE){
				print("Database Connection Error Encountered!");
			}
		}else{
			return "Database Connection Failed";
		}
		
		$init->select('Server, Instance, Username, Password, Table, Top, StoreFilter, TermFilter, TransFilter, TransType');
		$init->from('ps_data');
		$init->where('AID', $aid);
		$qry = $init->get();
		
		if($qry->num_rows() > 0)
		{
			return $qry->row_array();
		}
		else
		{
			$array = array(array('error_empty'=>"URL does not exist!"));
			return $array;
		}
		$this->db->close();
	}
	/*end of url_get*/
	
}

/* End of file page_model.php */
/* Location: ./application/models/page_model.php */