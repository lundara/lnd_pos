<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('User_model','md');
        $this->load->model("Lnd_model", "lnd");



       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

        $this->lnd->akses("user");

		$data["page"]	  = "user";
        $data["menu"]     = "master_data";
        $data["submenu"]  = "user";
        $data["title"]    = "User";
		$this->load->view('main', $data);
		
	}

    public function edit(){
        $id = $_POST["id"];

        $this->db->join("jabatan", "user.idjabatan = jabatan.id");
        $this->db->where("username", $id);
        $data = $this->db->get("user")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("username", $id);
        $user = $this->db->get("user")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $this->db->where("username", $id);
        $d = $this->db->get("user")->row_array();

        if($d["foto"]!=""){
                unlink("./upload/user/".$d["foto"]);
        }

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Member ".$user['nama'].".",
            "jenis_aktivitas"   => "HAPUS",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
            $this->db->where("username", $id);
            $this->db->delete("user");

            $this->db->where("username", $id);
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

        $iduser = $_POST['username'];
        $rand = rand(0,999);
        $file_name = $iduser."_".$rand;

        header("Content-type: image/jpg");
        $config['upload_path']      = './upload/user/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config["overwrite"]        = TRUE;
        $config['file_name']        = $file_name;
        
        $this->load->library('upload', $config);        
        
        
        $s1=$this->upload->do_upload('foto');
        $g1 =$this->upload->data();

        if($s1){
            $f = $g1["file_name"];
            
        }
        else{
            $f = "";
        }




        $nama       = ucwords($_POST["nama"]);
        $tmp        = $_POST["tmp"];
        $tgl        = $_POST["tgl"];
        $username   = $_POST["username"];
        $pass       = md5($_POST["pass1"]);
        $jk         = $_POST["jk"];
        $alamat     = $_POST["alamat"];
        $jabatan    = $_POST["jabatan"];
        $hp         = $_POST["hp"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $this->db->where("username", $username);
        $cek_username = $this->db->get("user")->num_rows();
        if ($cek_username == 0) {
            $dt = array(
                    "username"      => $username,
                    "nama"          => $nama,
                    "tmp_lahir"     => $tmp,
                    "tgl_lahir"     => $tgl,
                    "password"      => $pass,
                    "alamat"        => $alamat,
                    "idjabatan"     => $jabatan,
                    "jk"            => $jk,
                    "foto"          => $f,
                    "no_hp"         => $hp,
                    "created_by"    => $user["username"],
                    "created_on"    => date("Y-m-d H:i:s")
            );

            $dt_act = array(
                    "deskripsi"         => $user["nama"]." telah menambah data Member ".$nama.".",
                    "jenis_aktivitas"   => "TAMBAH",
                    "iduser"            => $iduser,
                    "tgl"               => date("Y-m-d H:i:s")
                );

            $this->db->trans_start();
                $this->db->insert("user", $dt);

                $this->db->insert("aktivitas", $dt_act);

                $mn = $this->db->get("menu")->result();

                foreach ($mn as $vm) {
                    $dt_akses = array(
                        "username"      => $username,
                        "idmenu"        => $vm->id,
                        "created_by"    => $user["username"],
                        "created_on"    => date("Y-m-d H:i:s")

                    );
                    $this->db->insert("akses", $dt_akses);
                }

                

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
        else{
            echo "0.1";
        }

        

    }

    function im_akses(){

        $us = $this->db->get("user")->result();

        foreach ($us as $vus) {

            $mn = $this->db->get("menu")->result();

            foreach ($mn as $vm) {
                $dt1 = array(
                    "username"  => $vus->username,
                    "idmenu"    => $vm->id,
                    "created_on" => date("Y-m-d H:i:s"),
                    "created_by"    => "Import"
                );
                $this->db->insert("akses", $dt1);
            }

            
        }

    }

    public function update(){

        $iduser = $_POST['username'];
        $rand = rand(0,999);
        $file_name = $iduser."_".$rand;

        header("Content-type: image/jpg");
        $config['upload_path']      = './upload/user/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config["overwrite"]        = TRUE;
        $config['file_name']        = $file_name;
        
        $this->load->library('upload', $config);        
        
        
        $s1=$this->upload->do_upload('foto');
        $g1 =$this->upload->data();

        $this->db->where("username", $iduser);
        $d = $this->db->get("user")->row_array();

        


        $nama       = ucwords($_POST["nama"]);
        $tmp        = $_POST["tmp"];
        $tgl        = $_POST["tgl"];
        $username   = $_POST["username"];
        $jk         = $_POST["jk"];
        $alamat     = $_POST["alamat"];
        $jabatan    = $_POST["jabatan"];
        $hp         = $_POST["hp"];
        $cabang     = $_POST["cabang"];
        $divisi     = $_POST["divisi"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        

        if($s1){
            $f = $g1["file_name"];
            if($d["foto"]!=""){
                unlink("./upload/user/".$d["foto"]);
            }

            $dt = array(
                "username"      => $username,
                "nama"          => $nama,
                "tmp_lahir"     => $tmp,
                "tgl_lahir"     => $tgl,
                "alamat"        => $alamat,
                "idjabatan"     => $jabatan,
                "jk"            => $jk,
                "foto"          => $f,
                "no_hp"         => $hp,
                "idcabang"      => $cabang,
                "divisi"        => $divisi,
                "updated_by"    => $user["nama"],
                "updated_on"    => date("Y-m-d H:i:s")
            );
            
        }
        else{
            $dt = array(
                "username"      => $username,
                "nama"          => $nama,
                "tmp_lahir"     => $tmp,
                "tgl_lahir"     => $tgl,
                "alamat"        => $alamat,
                "idjabatan"     => $jabatan,
                "jk"            => $jk,
                "no_hp"         => $hp,
                "idcabang"      => $cabang,
                "divisi"        => $divisi,
                "updated_by"    => $user["nama"],
                "updated_on"    => date("Y-m-d H:i:s")
            );
        }

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah mengubah data Member ".$nama.".",
                "jenis_aktivitas"   => "EDIT",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s")
            );

        $this->db->trans_start();
            $this->db->where("username", $username);
            $this->db->update("user", $dt);

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
            $src_nama       = $_POST["src_nama"];
            $src_jabatan    = $_POST["src_jabatan"];

            $dtuser = $this->lnd->me();

            $list = $this->md->get_datatables($src_nama, $src_jabatan);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {


                if ($v->foto !="") {
                    $img = base_url()."upload/user/".$v->foto;
                }
                else{
                    if ($v->jk == "Laki - laki") {
                        $img = base_url()."assets/layout2/img/user-m.png";
                    }
                    else{
                        $img = base_url()."assets/layout2/img/user-f.png";
                    }
                }


                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = "
                             <center>
                                <div style='height:50px;width:50px;border-radius: 50% !important;overflow:hidden;'>
                                    <img src='".$img."' style='max-width:50px;min-height:50px'>
                                </div>
                            </center>
                        ";
                $row[] = $v->username;
                $row[] = "<a href='javascript:;' onclick='detail(\"".$v->username."\")' data-toggle='modal' data-target='#md-detail'>".$v->nama."</a>";
                $row[] = "<center>".$v->nama_jabatan."</center>"; 

                if ($dtuser['nama_jabatan'] == "IT") {
                    $btn_akses = "
                        <li>
                            <a href='javascript:;' onclick='get_akses(\"".$v->username."\")' data-toggle='modal' data-target='#md-akses'>
                                <i class='fa fa-key fa-lg'></i> Hak Akses
                            </a>
                        </li>
                    ";
                }
                else{
                    $btn_akses = "";
                }
     
                //add html for action
                $row[] = "
                            <center>
                                <div class='btn-group dropup'>
                                    <button class='btn blue dropdown-toggle' type='button' data-toggle='dropdown'>
                                        Action <i class='fa fa-angle-up'></i>
                                    </button>
                                    <ul class='dropdown-menu' role='menu' style='width:auto;min-width:2px'>
                                        ".$btn_akses."
                                        <li>
                                            <a href='javascript:;' onclick='edit(\"".$v->username."\")' data-toggle='modal' data-target='#md-edit'>
                                                <i class='fa fa-pencil fa-lg'></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a href='javascript:;' onclick='getId(\"".$v->username."\")' data-toggle='modal' data-target='#md-delete'>
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
                            "recordsFiltered"   => $this->md->count_filtered($src_nama, $src_jabatan    ),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 


    function akses(){
        $id     = $_POST["id"];
        $status = $_POST["status"];
    
        $dt = array('status' => $status);

        $this->db->trans_start();

            $this->db->where("id", $id);
            $this->db->update("akses", $dt);

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

    public function dt_akses(){
            error_reporting(0);
            $this->load->model("Akses_model", "akses");
            //filter
            $id       = $_POST["id"];

            $dtuser = $this->lnd->me();

            $list = $this->akses->get_datatables($id);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {

                if ($v->status == "Open") {
                    $c="success";
                    $btn = "
                        <button class='btn red' id='aks".$no."' onclick='akses_proses(".$v->id.", \"Close\", ".$no.")'><i class='fa fa-ban'></i></button>
                    ";
                }
                else{
                    $c = "danger";
                    $btn = "
                        <button class='btn green' id='aks".$no."' onclick='akses_proses(".$v->id.", \"Open\", ".$no.")'><i class='fa fa-check'></i></button>
                    ";
                }

                $no++;
                $row = array();
                $row[] = $v->nama_menu;
                $row[] = "<center>".$v->nama_modul."</center>";
                $row[] = "<center><label class='label label-".$c."'>".$v->status."</label></center>";
     
                //add html for action
                $row[] = "
                           <center>".$btn."</center> 
                        ";
     
                $data[] = $row;
            }
     
            $output = array(
                            "draw"              => $_POST['draw'],
                            "recordsTotal"      => $this->akses->count_all(),
                            "recordsFiltered"   => $this->akses->count_filtered($id),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    }

	
}
