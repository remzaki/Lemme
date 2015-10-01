<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Url extends CI_Controller {
	
	private function getSwitch()
	{
		return $_SESSION['switch'];
	}
	
	private function setSwitch($switch)
	{
		$_SESSION['switch'] = $switch;
	}
	
	public function index()
	{
	
		$aid = $this->uri->segment(2);
		
		if( (!$aid) OR (strlen($aid)!=8)){		//	CHECK: IF PRESEST || IF 8 CHARS
			show_404();
			exit();
		}
		else
		{
			/***************************SWITCHING THINGS******************************/
			session_start();
			
			$get = $this->input->get('s');
			if($get=='r'){	// RIGHT PANE
				$_SESSION["switch"]="r";
			}
			elseif($get=='l'){	// LEFT PANE
				$_SESSION["switch"]="l";
			}else{}
			
			if(isset($_SESSION['switch']) AND ($_SESSION['switch']!='')){
			}else{
				$_SESSION['switch'] = "l";	// LEFT PANE DEFAULT
			}
			
			if($_SESSION["switch"]=="l"){
				$data['pos']="r";
			}elseif($_SESSION["switch"]=="r"){
				$data['pos']="l";
			}else{}
			/***************************SWITCHING THINGS******************************/
			
			$this->load->model('page_model');
			$this->load->library('Aid');
			
			$msg["error"] = "";
			$data["result"] = "";
			$data["top"] = 1;
			$database = "TransactionLogDb";
			
			$this->load->view('header');
			$this->load->view('status', $msg);
			
			// GET THE URL DETAILS ON DATABASE
			$config = $this->page_model->url_get($aid);
			
			if(isset($config[0]['error_empty']))
			{
				$data['result'] = $config;
			}
			else
			{
				$server = $data['server'] = $config['Server'];
				$instance = $data['instance'] = $config['Instance'];
				$username = $data['username'] = $config['Username'];
				$password = $data['password'] = $config['Password'];
				$table = $data['table'] = $config['Table'];
				$data['top'] = $config['Top'];
				$data['store'] = $config['StoreFilter'];
				$data['term'] = $config['TermFilter'];
				$data['trans'] = $config['TransFilter'];
				$data['transtype'] = $config['TransType'];
				
				if(strlen($server)<=3){
					$server = "153.59.120.".$server;
				}
				
				$this->session->set_userdata('server', $server);
				$this->session->set_userdata('instance', $instance);
				$this->session->set_userdata('table', $table);
				$this->session->set_userdata('username', $username);
				$this->session->set_userdata('password', $password);
				
				// APPLYING FILTERS
				$filter = $this->aid->filter($config['Table'], $config['StoreFilter'], $config['TermFilter'], $config['TransFilter'], $config['TransType']);
				
				// RESULTS DATA
				$data['transtypes'] = $this->page_model->get_transtypes($config['Server'], $config['Instance'], $config['Username'], $config['Password']);
				$data['result'] = $this->page_model->get_poslog_list($config['Server'], $config['Instance'], $config['Username'], $config['Password'], $database, $config['Table'], $config['Top'], $filter);
			}
				$this->load->view("main/results", $data);
				$this->load->view("sql", $data);
			
			$this->load->view('footer');
		}
		
	}
	
	
}

/* End of file view.php */
/* Location: ./application/controllers/view.php */