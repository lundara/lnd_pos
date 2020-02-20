<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class modul extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Modul_model','md');



       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

		$data["page"]	  = "modul";
        $data["menu"]     = "setting";
        $data["submenu"]  = "modul";
        $data["title"]    = "Modul";
		$this->load->view('main', $data);
		
	}

    public function select(){
        
        $sl = "
            modul.id,
            modul.nama_modul AS name
        ";
        $this->db->select($sl);
        $this->db->from("modul");
        $data = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function edit(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $data = $this->db->get("modul")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $satuan = $this->db->get("modul")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Modul ".$satuan['nama_modul'].".",
            "jenis_aktivitas"   => "HAPUS",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->delete("modul");

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

        $nama = ucwords($_POST["nama"]);
        $icon   = strtolower($_POST["icon"]);
        $aktif = $_POST["aktif"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_modul"    => $nama,
                    "icon"          => $icon,
                    "aktif"         => $aktif,
                    "created_by"    => $user["nama"],
                    "created_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah menambah data Modul ".$nama.".",
                "jenis_aktivitas"   => "TAMBAH",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->insert("modul", $dt);

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
        $icon   = strtolower($_POST["icon"]);
        $id     = $_POST["id"];
        $aktif = $_POST["aktif"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user   = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_modul"    => $nama,
                    "icon"          => $icon,
                    "aktif"         => $aktif,
                    "updated_by"    => $user["nama"],
                    "updated_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah mengubah data Modul ".$nama.".",
                "jenis_aktivitas"   => "EDIT",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->update("modul", $dt);

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
                $row[] = "<center><i class='fa ".$v->icon." fa-lg'></i></center>";
                $row[] = $v->nama_modul;
                $row[] = $v->aktif;
     
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
