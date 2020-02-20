<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outlet extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Outlet_model','md');



       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

		$data["page"]	  = "outlet";
        $data["menu"]     = "master_data";
        $data["submenu"]  = "outlet";
        $data["title"]    = "Outlet";
		$this->load->view('main', $data);
		
	}

    public function select(){
        
        $sl = "
            outlet.id,
            outlet.nama_outlet AS name
        ";
        $this->db->select($sl);
        $this->db->from("outlet");
        $data = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    function select2(){
        $sl = "
            outlet.id,
            outlet.nama_outlet AS name
        ";
        $this->db->select($sl);
        $this->db->from("outlet");
        $this->db->like("nama_outlet", $_POST["term"]);
        $data = $this->db->get()->result();

        $json = '[ ';
        $no = 0;
            foreach ($data as $v) {

                if ($no > 0) {
                    $json.=", ";
                }

                $dt = array(
                        "nama_outlet"   => $v->nama_outlet,
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
        $data = $this->db->get("outlet")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $satuan = $this->db->get("outlet")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Outlet ".$satuan['nama_outlet'].".",
            "jenis_aktivitas"   => "HAPUS",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
            $this->db->set("deleted", "1");
            $this->db->where("id", $id);
            $this->db->update("outlet");

            $this->del_stok($id);

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

    public function del_stok($id){
        $this->db->set("deleted", "1");
        $this->db->where("idoutlet", $id);
        $this->db->update("stok");
    }

    public function tambah(){
        $f      = $this->security->xss_clean($_POST["f"]);
        $by     = $this->session->userdata("lnd_id");
        $now    = $this->lnd->date_now();
        $user   = $this->lnd->me();
        $gen    = $this->lnd->kode_generator();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menambah data Outlet ".$f['nama_outlet'].".",
            "jenis_aktivitas"   => "TAMBAH",
            "iduser"            => $by,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->where("kode_outlet", $f['kode_outlet']);
        $c = $this->db->get("outlet")->num_rows();

        if ($c == 0) {
            $this->db->trans_start();


                $this->db->set("id", $gen);
                $this->db->set("created_by", $by);
                $this->db->set("created_on", $now);
                $this->db->insert("outlet", $f);

                $this->db->insert("aktivitas", $dt_act);

                $this->in_stok($gen);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $arr = array(
                        "st"    => "1",
                        "msg"   => "Data berhasil disimpan"
                    );

                echo "[".json_encode($arr)."]";
            }
            else{
                $this->db->trans_rollback();
                $arr = array(
                        "st"    => "0",
                        "msg"   => "Data gagal disimpan"
                    );

                echo "[".json_encode($arr)."]";
            }
        }
        else{
            $arr = array(
                    "st"    => "0",
                    "msg"   => "Kode Outlet sudah ada !"
                );

            echo "[".json_encode($arr)."]";
        }

        
    }

    public function in_stok($id){
        $this->db->where("idoutlet", "TMP");
        $q = $this->db->get("stok");
        $c = $q->num_rows();
        $d = $q->result();

        if ($c!=0) {
            foreach ($d as $v) {

                $dt = array(
                    "id"            => $this->lnd->kode_generator(),
                    "idproduk"      => $v->idproduk,
                    "varian"        => $v->varian,
                    "harga"         => $v->harga,
                    "modal"         => $v->modal,
                    "idoutlet"      => $id,
                    "potong_stok"   => "1"
                );

                $this->db->insert("stok", $dt);
            }
        }
    }

    public function update(){
        $f      = $this->security->xss_clean($_POST["f"]);
        $by     = $this->session->userdata("lnd_id");
        $now    = $this->lnd->date_now();
        $user   = $this->lnd->me();

        $edit_id = $_POST["edit_id"];

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah mengubah data Outlet ".$f['nama_outlet'].".",
            "jenis_aktivitas"   => "EDIT",
            "iduser"            => $by,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->where("kode_outlet", $f['kode_outlet']);
        $this->db->where("id!=", $edit_id);
        $c = $this->db->get("outlet")->num_rows();

        if ($c == 0) {
            $this->db->trans_start();

                $this->db->set("created_by", $by);
                $this->db->set("created_on", $now);
                $this->db->where("id", $edit_id);
                $this->db->update("outlet", $f);

                $this->db->insert("aktivitas", $dt_act);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();

                $arr = array(
                        "st"    => "1",
                        "msg"   => "Data berhasil disimpan"
                    );

                echo "[".json_encode($arr)."]";
            }
            else{
                $this->db->trans_rollback();
                $arr = array(
                        "st"    => "0",
                        "msg"   => "Data gagal disimpan"
                    );

                echo "[".json_encode($arr)."]";
            }
        }
        else{
            $arr = array(
                    "st"    => "0",
                    "msg"   => "Kode Outlet sudah ada !"
                );

            echo "[".json_encode($arr)."]";
        }
    }
    /*
    public function tambah(){

        $nama       = ucwords($_POST["nama"]);
        $telp       = $_POST["telp"];
        $alamat     = $_POST["alamat"];
        $kode       = strtoupper($_POST["kode"]);


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

    }*/

    function cek_produk(){
        
        $d = $this->db->get("outlet")->result();

        foreach ($d as $v) {
            echo $v->nama_outlet."<br>";

            $this->db->where("idoutlet", $v->id);
            $n = $this->db->get("stok")->num_rows();

            echo $n."<hr>";
        }

        $this->db->group_by("id");
        $b = $this->db->get("stok")->num_rows();
        echo $b;
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
                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = $v->nama_outlet;
                $row[] = $v->kode_outlet;
                $row[] = $v->telp;
                $row[] = $v->alamat;
     
                //add html for action
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
                        ";
     
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
