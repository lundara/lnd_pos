<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profile extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        
       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){
        $iduser = $this->session->userdata("lnd_id");
        

        $this->db->where("iduser", $iduser);
        $d2 = $this->db->get("aktivitas")->result();

        $data["aktivitas"] = $d2;
		$data["page"]	  = "profile";
        $data["menu"]     = "profile";
        $data["submenu"]  = "";
		$this->load->view('main', $data);
		
	}

    public function ubah_password(){
        $iduser = $this->session->userdata("lnd_id");

        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $old = md5($_POST["old"]);
        $new = md5($_POST["new_pass"]);

        if ($old == $user["password"]) {
            $dt = array(
                    "password" => $new
                );
            $this->db->trans_start();
                $this->db->where("username", $iduser);
                $this->db->update("user", $dt);
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

    public function upload_foto(){
        $iduser = $this->session->userdata("lnd_id");
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

        if($s1){
            if($d["foto"]!=""){
                unlink("./upload/user/".$d["foto"]);
            }
            $arr = array(
                    "foto"       => $g1["file_name"]
            );

            $this->db->trans_start();
                $this->db->where("username", $iduser);
                $this->db->update("user", $arr);
            $this->db->trans_complete();

            if($this->db->trans_status() === TRUE){
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

  public function edit(){

    $data["page"]     = "profile_edit";
    $data["menu"]     = "profile";
    $data["submenu"]  = "";
    $this->load->view('main', $data);
    
  }

  public function dt_pribadi(){
    $user = $this->session->userdata('lnd_id');

    $this->db->where("username", $user);
    $data = $this->db->get("user")->result();

    echo json_encode($data);
  }

  public function update_profile(){
    $iduser = $this->session->userdata("lnd_id");

    $this->db->where("username", $iduser);
    $user = $this->db->get("user")->row_array();

    $nama   = ucwords($_POST["nama"]);
    $jk     = $_POST["jk"];
    $tmp    = ucwords($_POST["tmp"]);
    $tgl    = date("Y-m-d", strtotime($_POST["tgl"]));
    $hp     = $_POST["hp"];
    $alamat = $_POST["alamat"];

    $now    = date("Y-m-d H:i:s");

    $data = array(
            "nama"          => $nama,
            "jk"            => $jk,
            "tmp_lahir"     => $tmp,
            "tgl_lahir"     => $tgl,
            "no_hp"         => $hp,
            "alamat"        => $alamat,
            "updated_by"    => ucwords($user["nama"]),
            "updated_on"    => $now
        );

    $this->db->trans_start();
        $this->db->where("username", $iduser);
        $this->db->update("user", $data);
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

  public function test(){
    $this->load->library('image_lib');

    $config['image_library'] = 'gd2';
    $config['source_image'] = "./upload/tes.jpg";
    $config['create_thumb'] = TRUE;
    $config['maintain_ratio'] = TRUE;
    $config["thumb_marker"] = "_lnd";
    $config['width']     = 120;
    $config['height']   = 120;

    $this->image_lib->clear();
    $this->image_lib->initialize($config);
    $this->image_lib->resize();

    if ($this->image_lib->resize()) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = "./upload/tes.jpg";
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config["thumb_marker"] = "_lnd2";
        $config['width']     = 50;
        $config['height']   = 50;

        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }
  }
	
}
