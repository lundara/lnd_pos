<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboard extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");

        $this->load->model("Lnd_model", "lnd");
        $this->load->model("Dashboard_model", "dashboard");
        
       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){
    echo "Index of DB";		
	}



	
}
