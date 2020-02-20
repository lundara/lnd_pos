<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
       
    }

	public function index(){
		if($this->session->userdata('lnd_id'))
		{
		 	redirect('dashboard');
		}
		$this->load->view('login');
		
	}

	

	public function proses(){
		$username = $_POST["username"];
		$password = md5($_POST["password"]);


		$this->db->where("username", $username);
		$this->db->where("password", $password);
		$q = $this->db->get("user");
		$n = $q->num_rows();

		if ($n==1) {
			$d = $q->row_array();

			$this->db->where("id", $d["idjabatan"]);
			$j = $this->db->get("jabatan")->row_array();

			$this->session->set_userdata("lnd_id", $d["username"]);
			$this->session->set_userdata("lnd_jabatan", $j["nama_jabatan"]);

			$this->db->trans_start();
				$f = array("last_login"=>date("Y-m-d H:i:s"));
				$this->db->where("username", $username);
				$this->db->update("user", $f);
			$this->db->trans_complete();

			if ($this->db->trans_status() === TRUE) {
				echo "1";
				$this->db->trans_commit();
			}
			else{
				$this->db->trans_rollback();
				echo "0.1";
			}


		}
		else{
			echo "0";
		}


	}

	
	
	function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}
	
	
}
