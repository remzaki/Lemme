<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poslog extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {	
        $this->load->view('poslog');
    }
}
