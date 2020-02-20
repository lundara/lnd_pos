<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kartu_stok extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Kartu_stok_model','md');
        $this->load->model("Produk_model", "md_produk");



       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

		$data["page"]	  = "kartu_stok";
        $data["menu"]     = "inventory";
        $data["submenu"]  = "kartu_stok";
        $data["title"]    = "Kartu Stok";
		$this->load->view('main', $data);
		
	}

    function fg(){
        
        $d = $this->db->get("stok_log")->result();

        foreach ($d as $v) {    

            $idproduk = $this->lnd->to_field("stok", "idproduk", " WHERE id='".$v->idstok."' ");

            $this->db->set("idproduk", $idproduk);
            $this->db->where("id", $v->id);
            $this->db->update("stok_log");
        }
    }

    public function data(){
            error_reporting(0);

            //filter
            $src_nama = $_POST["src_nama"];
            $src_kode = $_POST["src_kode"];

            $list = $this->md->get_datatables($src_nama, $src_kode);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {
                
                $row = array();


                if ($v->varian!="") {
                    $varian = " - ".$v->varian;
                    $n      = "";
                    $marg   = "margin-left:20px";
                }
                else{
                    $varian = "";
                    $n      = ($no++)+1;
                    $marg   = "";
                }

                $cek_varian = $this->md_produk->cek_varian_produk($v->idproduk);
                $cal        = $this->md->cal($v->idproduk, $cek_varian);

                $row[] = "<center>".$n."</center>";
                $row[] = "<p style='".$marg."'>".$v->nama_produk.$varian."</p>";
                $row[] = "<p style='text-align:right'>".$this->lnd->rp($cal["tawal"])."</p>";
                $row[] = "<p style='text-align:right'>".$this->lnd->rp($cal["tjual"])."</p>";
                $row[] = "<p style='text-align:right'>".$this->lnd->rp($cal["tbeli"])."</p>";
                $row[] = "<p style='text-align:right'>".$this->lnd->rp($cal["adj"])."</p>";
                $row[] = "<p style='text-align:right'>".$this->lnd->rp($cal["trjual"])."</p>";
                $row[] = "<p style='text-align:right'>".$this->lnd->rp($cal["trbeli"])."</p>";
                $row[] = "<p style='text-align:right'>".$this->lnd->rp($cal["takhir"])."</p>";
     
                //add html for action
                /*
                $row[] = "
                            <center>
                                <div class='btn-group dropdown act'>
                                    <button id='act' class='btn btn-sm main dropdown-toggle' type='button' data-toggle='dropdown'>
                                        <i class='fa fa-bars'></i>
                                    </button>
                                    <ul class='dropdown-menu' role='menu' style='width:auto;min-width:140px'>
                                        <li>
                                            <a href='javascript:;' onclick='edit(`".$v->id."`)' data-toggle='modal' data-target='#md-fedit'>
                                                <i class='fa fa-pencil fa-lg'></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href='javascript:;' onclick='getId(`".$v->id."`)' data-toggle='modal' data-target='#md-delete'>
                                                <i class='fa fa-trash fa-lg'></i> Hapus
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </center>
                        ";*/
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_nama, $src_kode),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
