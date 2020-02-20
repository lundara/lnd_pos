<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class stok extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Stok_model','md');
        //$this->load->model("Selisih_model", "md_selisih");
        $this->load->library('pdf');
        $this->load->model("Lnd_model", "lnd");

       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        




		$data["page"]	  = "stok_gudang";
        $data["menu"]     = "inventory";
        $data["submenu"]  = "stok";
		$this->load->view('main', $data);


		
	}

	function ptos(){
		$this->db->order_by("id", "asc");
		$d = $this->db->get("produk")->result();

		foreach ($d as $v) {
			
			$g = $this->db->get("gudang")->result();

			foreach ($g as $vg) {
				$dt = array(
					"idproduk"	=> $v->id,
					"qty"		=> 0,
					"tmp_qty"	=> 0,
					"idgudang"	=> $vg->id
				);	

				//$this->db->insert("stok", $dt);
			}



		}
	}

	function masuk(){

		$id = $_POST["id"];
		$qty = $_POST["qty"];


		$this->db->where("id", $id);
		$d = $this->db->get("stok")->row_array();
		$dt = array(
				"qty"	=> $qty+$d['qty']
			);

		$this->db->trans_start();

			$this->db->where("id", $id);
			$this->db->update("stok", $dt);
		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();
			echo "1";
		}
		else{
			$this->db->trans_rollback();
			echo "0";
		}

	}
	
	function dt_gudang(){


		if ($_POST["src_gudang"]!="") {
			$this->db->like("nama_gudang", $_POST["src_gudang"]);
		}
		$this->db->order_by("nama_gudang", "ASC");
		$d = $this->db->get("gudang")->result();

		echo json_encode($d);

	}

    public function detail(){
        $id = $this->uri->segment(3);

        $this->db->where("id", $id);
        $c = $this->db->get("gudang")->row_array();

        $data["g"]   	  = $c;     
        $data["page"]     = "stok";
        $data["menu"]     = "inventory";
        $data["submenu"]  = "stok";
        $this->load->view('main', $data);
    }

    public function select(){
        
        $sl = "
            produk.id,
            produk.nama_produk AS name,
            produk.harga,
            produk.modal,
            produk.idsatuan,
            produk.stok,
            satuan.id AS satid,
            satuan.nama_satuan
            
        ";
        $this->db->select($sl);
        $this->db->from("produk");
        $this->db->join("satuan", "produk.idsatuan = satuan.id");
        $data = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($data);
    }



    public function data(){
            error_reporting(0);

            //filter
            $src_nama   = $_POST["src_nama"];
            $src_desc 	= $_POST["src_desc"];
            $src_gudang = $_POST["src_gudang"];

            $list = $this->md->get_datatables($src_nama, $src_desc, $src_gudang);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {
                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = $v->nama_produk;
                $row[] = $v->deskripsi;
                $row[] = "<p style='text-align:right'>".number_format($v->qty, 0, ",", ".")."</p>";
                $row[] = "<center>".$v->nama_satuan."</center>"; 
                $row[] = "
		                <center>
	                        <li class='btn-group dropdown act' >
	                            <button id='act' class='btn blue dropdown-toggle drop' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' style='padding:5px 10px;'>
	                               <i class='fa fa-bars'></i> 
	                            </button>
	                            <ul class='dropdown-menu' id='dropdown-menu".$no."'  role='menu' style='width:auto;min-width:2px'>
	                                <li>
	                                    <a href='javascript:;' onclick='getId(".$v->id.", \"".$v->nama_satuan."\")' data-toggle='modal' data-target='#md-masuk'>
	                                        <i class='fa fa-arrow-down fa-lg'></i> Masuk Barang
	                                    </a>
	                                </li>
	                                <li>
	                                    <a href='javascript:;' onclick='getId(".$v->id.", \"".$v->nama_satuan."\")' data-toggle='modal' data-target='#md-pindah'>
	                                        <i class='fa fa-exchange fa-lg'></i> Pindah Barang
	                                    </a>
	                                </li>
	                            </ul>
	                        </li>
                        </center>

                ";

                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_nama, $src_desc, $src_gudang),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
