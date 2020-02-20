<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class produk_pitstop extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Produk_pitstop_model','md');
        $this->load->model("Lnd_model", "lnd");



       if(!$this->session->userdata('lnd_id'))
       {
        	redirect('login');
       }
    }

	public function index(){        

		$data["page"]	  = "produk_pitstop";
        $data["menu"]     = "master_data";
        $data["submenu"]  = "produk_pitstop";
		$this->load->view('main', $data);
		
	}

    function im_b(){
        $i = $this->db->get("produk_bengkel")->result();

        foreach ($i as $v) {
            $dt = array(
                    "nama_produk"   => ucwords($v->nama_produk),
                    "merk"          => $v->merk,
                    "modal"         => $v->harga_beli,
                    "idsatuan"      => "29"
                );
            //$this->db->insert("pitstop_produk", $dt);
        }
    }

    function imp_inven(){

        $im = $this->db->get("imin")->result();

        foreach ($im as $vim) {
            $dt = array(
                    "nama_produk"   => $vim->nm." ".$vim->ds,
                    "harga"         => 0,
                    "modal"         => 0,
                    "disc"          => 0,
                    "idsatuan"      => 29,
                    "created_on"    => date("Y-m-d H:i:s"),
                    "created_by"    => "Import Inventory"
                );

            //$this->db->insert("produk", $dt);
        }


    }

    function im_pr(){
        $this->db->group_by("ds");
        $im = $this->db->get("produk18")->result();

        foreach ($im as $vim) {
            $dt = array(
                    "deskripsi"     => $vim->ds,
                    "nama_produk"   => "",
                    "harga"         => 0,
                    "modal"         => 0,
                    "disc"          => 0,
                    "idsatuan"      => 29,
                    "created_on"    => date("Y-m-d H:i:s"),
                    "created_by"    => "Import Lundara"
            );
            //$this->db->insert("produk", $dt);
        }
    }

    function coba(){
        $d = $this->lnd->rumus("11321", "Bebas");
        echo $d["hbbs"];
    }

    public function im_produk(){


        $d = $this->db->get("database")->result();

        foreach ($d as $v) {


            $this->db->where("nama_satuan", $v->satuan);
            $s = $this->db->get("satuan")->row_array();

            $this->db->where("kelbar", $v->kelbar);
            $kl = $this->db->get("kelbar")->row_array();

            $this->db->where("kelhar", $v->kelhar);
            $kh = $this->db->get("kelhar")->row_array();

            $dt = array(
                    "nama_produk"   => $v->nama,
                    "modal"         => $v->modal,
                    "idsatuan"      => $s["id"],
                    "idkelbar"      => $kl["id"],
                    "idkelhar"      => $kh["id"],
                    "disc"          => "0",
                    "created_on"    => date("Y-m-d H:i:s"),
                    "created_by"    => "Import Produk"
                );
            //$this->db->insert("produk", $dt);
        }
    }

    public function select(){
        
        $iduser  = $this->session->userdata("lnd_id");

        $this->db->where("username", $iduser);
        $us = $this->db->get("user")->row_array();

        $sl = "
            stok.*,
            produk.id AS produk_id,
            produk.nama_produk AS name,
            produk.harga,
            produk.modal,
            produk.idsatuan,
            satuan.id AS satid,
            satuan.nama_satuan
            
        ";
        $this->db->select($sl);
        $this->db->from("stok");
        $this->db->join("produk", "stok.idproduk = produk.id");
        $this->db->join("satuan", "produk.idsatuan = satuan.id");
        $this->db->where("stok.idcabang", $us["idcabang"]);
        $data = $this->db->get()->result();

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function select2(){
        $sl = "
            pitstop_produk.*,
            satuan.id AS satid,
            satuan.nama_satuan
        ";
        $this->db->select($sl);
        $this->db->from("pitstop_produk");
        $this->db->join("satuan", "satuan.id = pitstop_produk.idsatuan");
        //$this->db->like("produk.nama_produk", $_POST["term"]);
        $this->db->like("pitstop_produk.nama_produk", $_POST["term"]);
        $this->db->order_by("pitstop_produk.nama_produk", "asc");
        $d = $this->db->get()->result();

        $no = 0;
        $data = "[";
        foreach ($d as $v) {
            
            if ($no > 0) {
                $data.=", ";
            }

            $dt = array(
                    "id"            => $v->id,
                    "nama_produk"   => $v->nama_produk,
                    "nama_satuan"   => $v->nama_satuan,
                    "harga"         => $v->harga,
                    "modal"         => $v->modal,
                    "merk"          => $v->merk,
                    "tipe_mobil"    => $v->type_mobil
                );

            $data .= json_encode($dt);
            $no++;
        }

        $data.="]";

        echo $data;
    }



    public function edit(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $data = $this->db->get("pitstop_produk")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $satuan = $this->db->get("produk")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Produk ".$satuan['nama_produk'].".",
            "jenis_aktivitas"   => "HAPUS",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->delete("pitstop_produk");

            $this->db->where("idproduk", $id);
            $this->db->delete("pitstop_stok");

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
        $jual       = str_replace(".", "", $_POST["jual"]);
        $beli       = str_replace(".", "", $_POST["beli"]);
        $satuan     = $_POST["satuan"];
        $merk       = $_POST["merk"];
        $mobil      = $_POST["mobil"];
        $kategori   = $_POST["kategori"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_produk"   => $nama,
                    "harga"         => $jual,
                    "modal"         => $beli,
                    "idsatuan"      => $satuan,
                    "merk"          => $merk,
                    "type_mobil"   => $mobil,
                    "idkategori"    => $kategori,
                    "created_by"    => $user["username"],
                    "created_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah menambah data Produk ".$nama.".",
                "jenis_aktivitas"   => "TAMBAH",
                "iduser"            => $iduser,
                "tgl"               => date("Y-m-d H:i:s"),
                "divisi"            => "pitstop"
            );

        

        $this->db->trans_start();
            $this->db->insert("pitstop_produk", $dt);

            $this->db->insert("aktivitas", $dt_act);


        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            echo "1";
            $this->stok_produk($user['username']);

            $this->lnd->send_wa("085321845172", $user["nama"]." telah menambah data Produk ".$nama.".");
        }
        else{
            $this->db->trans_rollback();
            echo "0";
        }

    }

    public function stok_produk($user){

        $this->db->where("created_by", $user);
        $this->db->order_by("created_on", "DESC");  
        $p = $this->db->get("pitstop_produk")->row_array();

        $dt_stok = array(
            "idproduk"  => $p['id'],
            "qty"       => "0",
            "tmp_qty"   => "0",
            "idgudang"  => "4"
        );

        $this->db->insert("pitstop_stok", $dt_stok);
    }

    public function update(){

        $nama       = ucwords($_POST["nama"]);
        $jual       = str_replace(".", "", $_POST["jual"]);
        $beli       = str_replace(".", "", $_POST["beli"]);
        $merk       = $_POST["merk"];
        $satuan     = $_POST["satuan"];
        $mobil      = $_POST["mobil"];
        $kategori   = $_POST["kategori"];

        $id         = $_POST["id"];

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user   = $this->db->get("user")->row_array();


        $dt = array(
                    "nama_produk"   => $nama,
                    "harga"         => $jual,
                    "modal"         => $beli,
                    "idsatuan"      => $satuan,
                    "merk"          => $merk,
                    "type_mobil"    => $mobil,
                    "idkategori"    => $kategori,
                    "updated_by"    => $user["username"],
                    "updated_on"    => date("Y-m-d H:i:s")
            );

        $dt_act = array(
                "deskripsi"         => $user["nama"]." telah mengubah data Produk ".$nama.".",
                "jenis_aktivitas"   => "EDIT",
                "iduser"            => $iduser,
                "divisi"            => "pitstop",
                "tgl"               => date("Y-m-d H:i:s"),
                "divisi"            => "pitstop"

            );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->update("pitstop_produk", $dt);

            $this->db->insert("aktivitas", $dt_act);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $this->lnd->send_wa("085321845172", $user["nama"]." telah mengubah data Produk ".$nama.".");
            echo "1";

        }
        else{
            $this->db->trans_rollback();
            echo "0";
        }

    }

    function log(){
        $id = $_POST["id"];


        $sl = "
            po_out_detail.*,
            produk.id AS produkid,
            produk.nama_produk,
            produk.deskripsi,
            po_out.no_trans AS nono,
            po_out.created_on,
            po_out.idsupplier,
            supplier.id AS supid,
            supplier.nama_supplier
        ";
        $this->db->select($sl);
        $this->db->from("po_out_detail");
        $this->db->join("po_out", "po_out.no_trans = po_out_detail.no_trans");
        $this->db->join("produk", "produk.id = po_out_detail.iditem");
        $this->db->join("supplier", "supplier.id = po_out.idsupplier");
        $this->db->where("po_out_detail.iditem", $id);
        $this->db->order_by("po_out.created_on", "DESC");
        $d = $this->db->get()->result();

        $no = 1;
        $dt = "[";
        foreach ($d as $v) {
            
            if ($no>1) {
                $dt.=", ";
            }

            $x=array(
                    "tgl"       => date("d/m/Y", strtotime($v->created_on)),
                    "harga"     => number_format($v->harga, 0, ",", "."),
                    "vendor"    => $v->nama_supplier
                );
            $dt.=json_encode($x);
            $no++;
        }
        $dt.="]";
        echo $dt;

    }
    function kartu_stok(){

        $id = $_POST["id"];

        $this->db->where("idproduk", $id);
        $this->db->order_by("created_on", "desc");
        $d = $this->db->get("pitstop_kartu_stok")->result();

        echo json_encode($d);

    }

    function im_stj(){

        $sl = "
            pitstop_penjualan_detail.*,
            pitstop_penjualan.no_trans,
            pitstop_penjualan.created_on,
            pitstop_produk.id AS produkid,
            pitstop_produk.nama_produk
        ";

        $this->db->select($sl);
        $this->db->from("pitstop_penjualan_detail");
        $this->db->join("pitstop_penjualan", "pitstop_penjualan_detail.no_trans = pitstop_penjualan.no_trans");
        $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_penjualan_detail.iditem");
        $d = $this->db->get()->result();

        foreach ($d as $v) {
            
            $date = date("Y-m-d", strtotime($v->created_on));

            $this->db->where("created_on", $date);
            $this->db->where("idproduk", $v->produkid);
            $q = $this->db->get("pitstop_kartu_stok");
            $c = $q->num_rows();
            $b = $q->row_array();

            if ($c == 0) {
                $dt = array(
                        "idproduk"  => $v->produkid,
                        "jual"      => $v->qty,
                        "beli"      => "0",
                        "stok"      => "0",
                        "created_on"    => $date
                    );
                $this->db->insert("pitstop_kartu_stok", $dt);
            }
            else{
                $dt = array(
                        "idproduk"  => $v->produkid,
                        "jual"      => $b["jual"] + $v->qty,
                        "beli"      => "0",
                        "stok"      => "0",
                        "created_on"    => $date
                    );

                $this->db->where("id", $b["id"]);
                $this->db->update("pitstop_kartu_stok", $dt);
            }   

        }

    }
    function im_stb(){

        $sl = "
            pitstop_pembelian_detail.*,
            pitstop_pembelian.no_trans,
            pitstop_pembelian.created_on,
            pitstop_produk.id AS produkid,
            pitstop_produk.nama_produk
        ";

        $this->db->select($sl);
        $this->db->from("pitstop_pembelian_detail");
        $this->db->join("pitstop_pembelian", "pitstop_pembelian_detail.no_trans = pitstop_pembelian.no_trans");
        $this->db->join("pitstop_produk", "pitstop_produk.id = pitstop_pembelian_detail.iditem");
        $d = $this->db->get()->result();

        foreach ($d as $v) {
            
            $date = date("Y-m-d", strtotime($v->created_on));

            $this->db->where("created_on", $date);
            $this->db->where("idproduk", $v->produkid);
            $q = $this->db->get("pitstop_kartu_stok");
            $c = $q->num_rows();
            $b = $q->row_array();

            if ($c == 0) {
                $dt = array(
                        "idproduk"  => $v->produkid,
                        "jual"      => "0",
                        "beli"      => $v->qty,
                        "stok"      => "0",
                        "created_on"    => $date
                    );
                $this->db->insert("pitstop_kartu_stok", $dt);
            }
            else{
                $dt = array(
                        "idproduk"  => $v->produkid,
                        "jual"      => "0",
                        "beli"      => $b["beli"] + $v->qty,
                        "stok"      => "0",
                        "created_on"    => $date
                    );

                $this->db->where("id", $b["id"]);
                $this->db->update("pitstop_kartu_stok", $dt);
            }   

        }

    }   
    public function data(){
            error_reporting(0);

            //filter
            $src_nama = $_POST["src_nama"];
            $src_satuan = $_POST["src_satuan"];
            $src_kelbar = $_POST["src_kelbar"];
            $src_kelhar = $_POST["src_kelhar"];
            $src_desc = $_POST["src_desc"];

            $list = $this->md->get_datatables($src_nama, $src_satuan, $src_kelbar, $src_kelhar, $src_desc);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {

                switch ($v->nama_kategori) {
                    case "Jasa":
                        $c_kt = "danger"; 
                    break;
                    case "Oli":
                        $c_kt = "warning"; 
                    break;
                    case "Spare Part":
                        $c_kt = "primary"; 
                    break;
                    
                    default:
                        $c_kt = "";
                    break;
                }

                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = $v->nama_produk." - ".$v->id;
                $row[] = $v->type_mobil;
                $row[] = "<p align='right'>".number_format($v->harga, 0, ",", ".")."</p>";
                $row[] = "<p align='right'>".number_format($v->modal, 0, ",", ".")."</p>";
                $row[] = "<center>".$v->nama_satuan."</center>";
                $row[] = $v->merk;
                $row[] = "<center><label class='label label-".$c_kt."'>".$v->nama_kategori."</label></center>";
     
                //add html for action
                $row[] = "
                            <center>
                            <div class='btn-group dropdown act'>
                                <button id='act' class='btn blue dropdown-toggle drop' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' style='padding:5px 10px;'>
                                   <i class='fa fa-bars'></i> 
                                </button>
                                <ul class='dropdown-menu' role='menu' style='width:auto;min-width:2px;'>
                                    <li>
                                        <a href='javascript:;' onclick='kartu_stok(".$v->id.", \"".$v->nama_produk."\")' data-toggle='modal' data-target='#md-log'>
                                            <i class='fa fa-file fa-lg'></i> Kartu Stok
                                        </a>
                                    </li>
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
                            "recordsFiltered"   => $this->md->count_filtered($src_nama, $src_satuan, $src_kelbar, $src_kelhar, $src_desc),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

	
}
