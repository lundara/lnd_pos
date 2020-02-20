<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class menu extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Menu_model','md');



       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

		$data["page"]	  = "menu";
        $data["menu"]     = "setting";
        $data["submenu"]  = "menu";
        $data["title"]    = "Menu";
		$this->load->view('main', $data);
		
	}

    public function select(){
        
        $sl = "
            menu.id,
            menu.nama_modul AS name
        ";
        $this->db->select($sl);
        $this->db->from("menu");
        $data = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function edit(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $data = $this->db->get("menu")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $satuan = $this->db->get("menu")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Menu ".$satuan['nama_menu'].".",
            "jenis_aktivitas"   => "HAPUS",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->delete("menu");

            $this->db->where("idmenu", $id);
            $this->db->delete("akses");

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
        $modul = $_POST["modul"];
        $file = strtolower($_POST["file"]);
        $icon = strtolower($_POST["icon"]);
        $aktif = $_POST["aktif"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_menu"     => $nama,
                    "idmodul"       => $modul,
                    "file"          => $file,
                    "icon"          => $icon,
                    "aktif"         => $aktif,
                    "created_by"    => $user["nama"],
                    "created_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah menambah data Menu ".$nama.".",
                "jenis_aktivitas"   => "TAMBAH",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->insert("menu", $dt);

            $this->db->insert("aktivitas", $dt_act);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $qus = $this->db->get("user")->result();

            $this->db->order_by("created_on", "DESC");
            $dmn = $this->db->get("menu")->row_array();

            foreach ($qus as $vus) {
                $dt_aks = array(
                    "username"      => $vus->username,
                    "idmenu"        =>  $dmn["id"],
                    "created_by"    => "Tambah Menu",
                    "created_on"    => date("Y-m-d H:i:s")
                );

                $this->db->insert("akses", $dt_aks);
            }

            echo "1";

            

        }
        else{
            $this->db->trans_rollback();
            echo "0";
        }

    }

    public function update(){

        $nama = ucwords($_POST["nama"]);
        $id = $_POST["id"];
        $file = strtolower($_POST["file"]);
        $icon = strtolower($_POST["icon"]);
        $modul = $_POST["modul"];
        $aktif = $_POST["aktif"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user   = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_menu"     => $nama,
                    "idmodul"       => $modul,
                    "file"          => $file,
                    "icon"          => $icon,
                    "aktif"         => $aktif,
                    "updated_by"    => $user["nama"],
                    "updated_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah mengubah data Menu ".$nama.".",
                "jenis_aktivitas"   => "EDIT",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->update("menu", $dt);

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
            $src_modul = $_POST["src_modul"];

            $list = $this->md->get_datatables($src_nama, $src_modul);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {
                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = "<center><i class='fa ".$v->icon." fa-lg'></i></center>";
                $row[] = $v->nama_menu;
                $row[] = $v->file;
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
                            "recordsFiltered"   => $this->md->count_filtered($src_nama, $src_modul),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
