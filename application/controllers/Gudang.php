<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gudang extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Gudang_model','md');



       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

		$data["page"]	  = "gudang";
        $data["menu"]     = "master_data";
        $data["submenu"]  = "gudang";
		$this->load->view('main', $data);
		
	}
	public function kai(){        

		$data["page"]	  = "project/kai";
        $data["menu"]     = "master_data";
        $data["submenu"]  = "gudang";
		$this->load->view('main', $data);
		
	}

	function upload_kendaraan(){
		/*
		//$jpg = file_get_contents('php://input');
	    $jpeg_data = file_get_contents('php://input');
	  
	    $filename = "./upload/kendaraan/" . mktime() . ".jpeg";
	  
	    $result = file_put_contents($filename, $jpeg_data);
	    //$r = file_put_contents($filename, $jpg);
	    echo $filename;*/
	    $nama_file = time().'.jpg';
		$direktori = './upload/kendaraan/';
		$target = $direktori.$nama_file;

		move_uploaded_file($_FILES['webcam']['tmp_name'], $target);
	}

    public function select(){
        
        $sl = "
            gudang.id,
            gudang.nama_gudang AS name
        ";
        $this->db->select($sl);
        $this->db->from("gudang");
        $data = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    function select2(){
        $sl = "
            bank.*,
        ";
        $this->db->select($sl);
        $this->db->from("bank");
        $this->db->like("nama_bank", $_POST["term"]);
        $data = $this->db->get()->result();

        $json = '[ ';
        $no = 0;
            foreach ($data as $v) {

                if ($no > 0) {
                    $json.=", ";
                }

                $dt = array(
                        "nama_bank"     => $v->nama_bank."(".$v->no_rek." - ".$v->atas_nama.")",
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
        $data = $this->db->get("gudang")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $satuan = $this->db->get("gudang")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Gudang ".$satuan['nama_gudang'].".",
            "jenis_aktivitas"   => "HAPUS",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->delete("gudang");

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

        $nama       = ucwords($_POST["nama"]);
        $telp       = $_POST["telp"];
        $alamat     = $_POST["alamat"];


        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_gudang"   => $nama,
                    "telp"          => $telp,
                    "alamat"        => $alamat,
                    "created_by"    => $user["username"],
                    "created_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah menambah data Gudang ".$nama.".",
                "jenis_aktivitas"   => "TAMBAH",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->insert("gudang", $dt);

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

        $nama       = ucwords($_POST["nama"]);
        $telp       = $_POST["telp"];
        $alamat     = $_POST["alamat"];

        $id         = $_POST["id"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user   = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_gudang"   => $nama,
                    "telp"          => $telp,
                    "alamat"        => $alamat,
                    "updated_by"    => $user["username"],
                    "updated_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah mengubah data Gudang ".$nama.".",
                "jenis_aktivitas"   => "EDIT",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->update("gudang", $dt);

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

            $list = $this->md->get_datatables($src_nama);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {
                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = $v->nama_gudang;
                $row[] = $v->telp;
                $row[] = $v->alamat;
     
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
                            "recordsFiltered"   => $this->md->count_filtered($src_nama),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
