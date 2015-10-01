<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View extends CI_Controller {

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
		
		$id_trn = $this->uri->segment(2);
		
		if( (!$id_trn) OR (!ctype_digit($id_trn)) OR (strlen($id_trn)!=32) ){	//	CHECK: IF EMPTY || IF NUMERIC || IF 32 CHARS
			show_404();
			exit();
		}else{
			$this->load->model('page_model');
			
			$server = $this->session->userdata('server');
			$instance = $this->session->userdata('instance');
			$table = $this->session->userdata('table');
			$username = $this->session->userdata('username');
			$password = $this->session->userdata('password');
			
			$result = $this->page_model->get_poslog($server, $instance, $username, $password, $table, $id_trn);
			// print_r(array($server, $instance, $table, $id_trn));
			
			foreach($result as $xml){
				$out = $xml->XMLPayload;
			}
			
			
			// GETTING XMLPayload Element/Attrib/Values
			// $aw = new SimpleXMLElement($out);
			// print_r($aw);
			// echo $aw[0]->RetailTransaction[0]->Total[0];
			
			$this->output
				->set_content_type('text/xml')
				->set_output($out);
		}
		
	}
}

/* End of file view.php */
/* Location: ./application/controllers/view.php */