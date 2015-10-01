<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Download extends CI_Controller {

	public function index()
	{
		
		$filename = $id_trn = $this->uri->segment(2);
		
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
			
			$this->output
				->set_content_type('text/xml')
				->set_output($out)
				->set_header('Content-disposition: attachment; filename="'.$filename.'.xml"');	// TO DOWNLOAD THE XML
		}
		
	}
}

/* End of file download.php */
/* Location: ./application/controllers/download.php */