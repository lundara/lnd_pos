<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pelanggan extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('pitstop/Pelanggan_model','md');
        $this->load->model("Lnd_model", "lnd");


       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

		$data["page"]	  = "pitstop_pelanggan";
        $data["menu"]     = "master_data";
        $data["submenu"]  = "pitstop_pelanggan";
		$this->load->view('main', $data);
		
	}
    function cetak(){
        $this->load->library('Tcpdf');

        $this->db->order_by("nama_pelanggan");
        $data["q"]  = $this->db->get("pelanggan")->result();

        $this->load->view("print/pelanggan", $data);
    }
    public function select(){
        
        $sl = "
            pelanggan.id,
            pelanggan.nama_pelanggan AS name
        ";
        $this->db->select($sl);
        $this->db->from("pelanggan");
        $data = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    function select2(){
        $sl = "
            pitstop_pelanggan.id,
            pitstop_pelanggan.nama_pelanggan
        ";
        $this->db->select($sl);
        $this->db->from("pitstop_pelanggan");
        $this->db->like("nama_pelanggan", $_POST["term"]);
        $data = $this->db->get()->result();

        $json = '[ ';
        $no = 0;
            foreach ($data as $v) {

                if ($no > 0) {
                    $json.=", ";
                }

                $dt = array(
                        "nama_pelanggan" => $v->nama_pelanggan,
                        "id"            => $v->id
                    );
                
                $no++;
                $json.= json_encode($dt);

            }

        $json.= "]";
        
        echo $json;

    }

    public function edit(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $data = $this->db->get("pitstop_pelanggan")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $satuan = $this->db->get("pitstop_pelanggan")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Customer ".$satuan['nama_pelanggan'].".",
            "jenis_aktivitas"   => "HAPUS",
            "divisi"            => "pitstop",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->delete("pitstop_pelanggan");

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

        $nama   = ucwords($_POST["nama"]);
        $hp     = $_POST["hp"];
        $alamat = $_POST["alamat"];


        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_pelanggan"    => $nama,
                    "plafon"            => "0",
                    "no_hp"             => $hp,
                    "alamat"            => $alamat,
                    "created_by"        => $user["nama"],
                    "created_on"        => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah menambah data Customer ".$nama.".",
                "jenis_aktivitas"   => "TAMBAH",
                "divisi"            => "pitstop",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->insert("pitstop_pelanggan", $dt);

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

        $nama   = ucwords($_POST["nama"]);
        $hp     = $_POST["hp"];
        $alamat = $_POST["alamat"];

        $id = $_POST["id"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user   = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_pelanggan"    => $nama,
                    "plafon"            => "0",
                    "no_hp"             => $hp,
                    "alamat"            => $alamat,
                    "updated_by"        => $user["nama"],
                    "updated_on"        => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah mengubah data Customer ".$nama.".",
                "jenis_aktivitas"   => "EDIT",
                "iduser"            => $iduser,
                "divisi"            => "pitstop",
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->update("pitstop_pelanggan", $dt);

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
            $src_nama = $_POST["src_nama"];
            $src_hp = $_POST["src_hp"];

            $list = $this->md->get_datatables($src_nama, $src_hp);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {
                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = $v->nama_pelanggan;
                $row[] = "Telp : ".$v->no_hp;
                $row[] = $v->alamat;
     
                //add html for action
                $row[] = "
                            <center>
                                <li class='btn-group dropdown act' >
                                    <button id='act' class='btn blue dropdown-toggle drop' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' style='padding:5px 10px;'>
                                       <i class='fa fa-bars'></i> 
                                    </button>
                                    <ul class='dropdown-menu' id='dropdown-menu".$no."'  role='menu' style='width:auto;min-width:2px'>
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
                                </li>
                            </center>
                        ";
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->md->count_all(),
                            "recordsFiltered"   => $this->md->count_filtered($src_nama, $src_hp),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
