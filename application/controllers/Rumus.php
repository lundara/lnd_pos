<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class rumus extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Rumus_model','md');



       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

		$data["page"]	  = "rumus";
        $data["menu"]     = "setting";
        $data["submenu"]  = "rumus";
		$this->load->view('main', $data);
		
	}


    public function select(){
        
        $sl = "
            cabang.id,
            cabang.nama_cabang AS name
        ";
        $this->db->select($sl);
        $this->db->from("cabang");
        $data = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function edit(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $data = $this->db->get("rumus")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $satuan = $this->db->get("rumus")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Rumus ".$satuan['rumus'].".",
            "jenis_aktivitas"   => "HAPUS",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );



        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->delete("rumus");

            $this->db->insert("aktivitas", $dt_act);
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

    public function tambah(){

        $trans 	= $_POST["trans"];
        $kelhar = $_POST["kelhar"];
        $rumus  = $_POST["rumus"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();


        $dt = array(
                    "transaksi"   	=> $trans,
                    "idkelhar"   	=> $kelhar,
                    "rumus"        	=> $rumus,
                    "created_by"    => $user["nama"],
                    "created_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah menambah data Rumus ".$rumus.".",
                "jenis_aktivitas"   => "TAMBAH",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->insert("rumus", $dt);

            $this->db->insert("aktivitas", $dt_act);
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

    public function update(){

        $trans 	= $_POST["trans"];
        $kelhar = $_POST["kelhar"];
        $rumus  = $_POST["rumus"];
        $id     = $_POST["id"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user   = $this->db->get("user")->row_array();


        $dt = array(
                    "transaksi"   	=> $trans,
                    "idkelhar"   	=> $kelhar,
                    "rumus"        	=> $rumus,
                    "updated_by"    => $user["nama"],
                    "updated_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah mengubah data Rumus ".$rumus.".",
                "jenis_aktivitas"   => "EDIT",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->update("rumus", $dt);

            $this->db->insert("aktivitas", $dt_act);
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

    public function data(){
            error_reporting(0);

            //filter
            $src_nama 	= $_POST["src_nama"];
            $src_hrg	= $_POST["src_hrg"];

            $list = $this->md->get_datatables($src_nama, $src_hrg);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {
                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = $v->transaksi;
                $row[] = $v->kelhar;
                $row[] = $v->rumus;
     
                //add html for action
                $row[] = "
                            <center>
                            <div class='btn-group dropup'>
                                <button class='btn blue dropdown-toggle' type='button' data-toggle='dropdown'>
                                    Action <i class='fa fa-angle-up'></i>
                                </button>
                                <ul class='dropdown-menu' role='menu' style='width:auto;min-width:2px'>
                                    <li>
                                        <a href='javascript:;' onclick='edit(".$v->id.")' data-toggle='modal' data-target='#md-edit'>
                                            <i class='fa fa-pencil fa-lg'></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a href='javascript:;' onclick='getId(".$v->id.")' data-toggle='modal' data-target='#md-delete'>
                                            <i class='fa fa-trash fa-lg'></i> Hapus
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            </center>
                        ";
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_nama, $src_hrg),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
