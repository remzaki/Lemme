<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Poslog extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->library('form_validation');
    }
	
	public function index()
	{
		/***************************SWITCHING THINGS******************************/
		// session_start();
		
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
		
		$this->load->library('Aid');
		$this->load->model('page_model');
		
		$this->load->view('header', $data);
		
		$msg["error"] = "";
		$data["result"] = "";
		$data["top"] = 1;
		
		// FORM VALIDATION RULES
		$this->form_validation->set_rules('server', 'Server', 'trim|required|max_length[100]');
		$this->form_validation->set_rules('instance', 'Instance', 'trim');
		$this->form_validation->set_rules('username', 'Username', 'trim');
		$this->form_validation->set_rules('password', 'Password', 'trim');
		$this->form_validation->set_rules('table', 'Table', 'trim|required');
		$this->form_validation->set_rules('store', 'Store', 'trim|max_length[8]');
		$this->form_validation->set_rules('terminal', 'Terminal', 'trim|max_length[8]');
		$this->form_validation->set_rules('transaction', 'Transaction', 'trim|max_length[8]');
		$this->form_validation->set_rules('transtype', 'TransactionType', 'trim');
		
		// RUN FORM VALIDATION
		if ($this->form_validation->run() === FALSE)
		{
			$msg["error"] = "Fields marked with an asterisk * are required.";
			echo validation_errors('<span class="error">', '</span>');
			$this->load->view('status', $msg);
			$this->load->view("main/default", $data);
		}
		else
		{
			$database = "TransactionLogDb";
			$server = $this->input->post('server');
			$instance = $this->input->post('instance');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$transtype = $this->input->post('transtype');
			$data['table'] = $table = $this->input->post('table');
			$store_filter = $this->input->post('store');
			$term_filter = $this->input->post('terminal');
			$trans_filter = $this->input->post('transaction');
			
			if(strlen($server)<=3){
				$server = "153.59.120.".$server;
			}
			
			$this->session->set_userdata('server', $server);
			$this->session->set_userdata('instance', $instance);
			$this->session->set_userdata('table', $table);
			$this->session->set_userdata('username', $username);
			$this->session->set_userdata('password', $password);
			
			// $top = 26;
			if($this->input->post('sl')){
				$top = 26;
				$this->session->set_userdata('top', $top);
			}
			if($this->input->post('sm')){
				$sl = $this->session->userdata('top');
				$top = $sl+20;
				$this->session->set_userdata('top', $top);
			}
			
			$top = $this->session->userdata('top');
			$data['top'] = $top;
			
			$this->load->view('status', $msg);
			
			// APPLYING FILTERS
			$filter = $this->aid->filter($table, $store_filter, $term_filter, $trans_filter, $transtype);
			
			// URL SHARING STUFF
			if($this->input->post('url')){	//	DO GENERATE URL
				$aid = $this->page_model->url_gen($server, $instance, $username, $password, $table, $top, $store_filter, $term_filter, $trans_filter, $transtype);
				if($aid){
					redirect('/url/'.$aid);
				}else{
					echo "Error in Generating URL! Please call Administrator.";
				}
				exit();
			}
			
			// RESULTS DATA
			$data['transtypes'] = $this->page_model->get_transtypes($server, $instance, $username, $password);
			$data['result'] = $this->page_model->get_poslog_list($server, $instance, $username, $password, $database, $table, $top, $filter);
			$data['trty'] = $transtype;
			$this->load->view("main/results", $data);
			$this->load->view("sql", $data);
			
		}
		
		$this->load->view('footer');
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */