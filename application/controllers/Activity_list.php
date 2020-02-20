<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class activity_list extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        ///$this->load->model('Stok_model','md');
        //$this->load->model("Selisih_model", "md_selisih");
        $this->load->library('pdf');
        $this->load->model("Lnd_model", "lnd");

       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        




		$data["page"]	  = "activity_list";
        $data["menu"]     = "marketing";
        $data["submenu"]  = "activity_list";
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

	
	function dt_mkt(){


		if ($_POST["src_mkt"]!="") {
			$this->db->like("nama", $_POST["src_mkt"]);
		}
        $this->db->where("jk", "Laki - laki");
		$this->db->order_by("nama", "ASC");
		$d = $this->db->get("user")->result();

		echo json_encode($d);

	}

    public function detail(){
        $id = $this->uri->segment(3);

        $this->db->where("username", $id);
        $c = $this->db->get("user")->row_array();

        if ($id == $this->session->userdata("lnd_id")) {
            $op = "";
        }
        else{
            $op = "display:none;";
        }

        $data["g"]   	  = $c;     
        $data["op"]       = $op;
        $data["page"]     = "act_detail";
        $data["menu"]     = "activity_list";
        $data["submenu"]  = "marketing";
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
