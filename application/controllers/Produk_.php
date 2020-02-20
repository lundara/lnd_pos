<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class produk extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Jakarta");
        $this->load->model('Produk_model','md');
        $this->load->model("Lnd_model", "lnd");

        $this->load->library('Zend');
        $this->load->library('ciqrcode');

       if(!$this->session->userdata('lnd_id'))
       {
            redirect('login');
       }
    }

    public function barcode_img($kode){
        $this->lnd->barcode($kode);
    }

    public function index(){        

        $data["page"]       = "produk";
        $data["menu"]       = "master_data";
        $data["submenu"]    = "produk";
        $data["title"]      = "Produk";
        $this->load->view('main', $data);
        
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
            produk.*,
            satuan.id AS satid,
            satuan.nama_satuan
        ";
        $this->db->select($sl);
        $this->db->from("produk");
        $this->db->join("satuan", "satuan.id = produk.idsatuan");
        //$this->db->like("produk.nama_produk", $_POST["term"]);
        $this->db->like("produk.nama_produk", $_POST["term"]);
        $this->db->order_by("produk.nama_produk", "asc");
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
        $data = $this->db->get("produk")->result();
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function hapus(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $produk = $this->db->get("produk")->row_array();

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        $dt_act = array(
            "deskripsi"         => $user["nama"]." telah menghapus data Produk ".$produk['nama_produk'].".",
            "jenis_aktivitas"   => "HAPUS",
            "iduser"            => $iduser,
            "tgl"               => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->delete("produk");

            $this->db->where("idproduk", $id);
            $this->db->delete("stok");

            $this->db->where("idproduk", $id);
            $this->db->delete("stok_log");

            $this->db->insert("aktivitas", $dt_act);
        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();

            if ($produk["foto"]!="") {
                $this->lnd->delete_file("upload/produk_img/".$produk["foto"]);
            }

            if ($produk["barcode"]!="") {
                $this->lnd->delete_file("upload/produk_qr/".$produk["barcode"].".png");
            }

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
        $barcode    = $_POST["barcode"];
        $jenis      = $_POST["jenis"];
        $deskripsi  = $_POST["deskripsi"];
        $produk_id  = $this->lnd->kode_generator();

        

        if ($barcode!="") {
            $this->lnd->qr($barcode);
            $cek_barcode = $this->md->cek_barcode($barcode, "");
        }
        else{
            $cek_barcode = 0;
        }

        if ($_POST["img"] == "1") {
            $path       = $_FILES['userfile']['name'];
        }
        else{
            $path = "";
        }

        $config['upload_path']      = FCPATH.'/upload/produk_img/';
        $config['allowed_types']    = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG';
        $config["overwrite"]        = TRUE;
        $config['encrypt_name']     = TRUE;
        $this->load->library('upload',$config);

        $iduser = $this->session->userdata("lnd_id");
        $this->db->where("username", $iduser);
        $user = $this->db->get("user")->row_array();

        if ($cek_barcode == 0) {
            
    
            if ($path!="") {

                if($this->upload->do_upload('userfile')){
                    $img_name = $this->upload->data('file_name');
                }
                else{
                    echo $this->upload->display_errors();
                }
            }
            else{
                $img_name = "";
            }


            $dt = array(
                "id"            => $produk_id,
                "nama_produk"   => $nama,
                "harga"         => $jual,
                "modal"         => $beli,
                "idsatuan"      => $satuan,
                "barcode"       => $barcode,
                "produk_type"   => $jenis,
                "deskripsi"     => $deskripsi,
                "foto"          => $img_name,
                "created_by"    => $user["username"],
                "created_on"    => date("Y-m-d H:i:s")
            );

            $dt_act = array(
                    "deskripsi"         => $user["nama"]." telah menambah data Produk ".$nama.".",
                    "jenis_aktivitas"   => "TAMBAH",
                    "iduser"            => $iduser,
                    "tgl"               => date("Y-m-d H:i:s"),
                );

            $insert_stok = array(
                "idproduk"  => $produk_id,
                "harga"     => $jual,
                "modal"     => $beli
            );
            

            $this->db->trans_start();

                $this->db->insert("produk", $dt);

                $this->db->insert("aktivitas", $dt_act);

                $this->stok_produk($insert_stok);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                echo "1";
                

                //$this->lnd->send_wa("085321845172", $user["nama"]." telah menambah data Produk ".$nama.".");
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

    public function stok_produk($insert_stok){

        $x = $this->db->get("outlet")->result();

        foreach ($x as $v) {
            $dt_stok = array(
                "idproduk"  => $insert_stok['idproduk'],
                "qty"       => "0",
                "tmp_qty"   => "0",
                "harga"     => $insert_stok["harga"],
                "modal"     => $insert_stok["modal"],
                "idoutlet"  => $v->id
            );
            $this->db->insert("stok", $dt_stok);
        }

        

        
    }

    function gf(){
        $this->lnd->delete_file("/upload/produk_qr/lundara_141.jpg");
    }

    public function update(){

        $nama           = ucwords($_POST["nama"]);
        $jual           = str_replace(".", "", $_POST["jual"]);
        $beli           = str_replace(".", "", $_POST["beli"]);
        $satuan         = $_POST["satuan"];
        $barcode        = $_POST["barcode"];
        $jenis          = $_POST["jenis"];
        $deskripsi      = $_POST["deskripsi"];
        $id             = $_POST["id"];

        $cek_barcode    = $this->md->cek_barcode($barcode, $id);

        
        $file = $this->lnd->to_field("produk", "barcode", "where id ='".$id."' ");

        if ($cek_barcode == 0) {
           
        

            if ($barcode!="") {
                
                if ($file!="") {
                    if ($file != $barcode) {
                        $this->lnd->qr($barcode);
                        $this->lnd->delete_file("upload/produk_qr/".$file.".png");
                    }
                }
                else{
                    $this->lnd->qr($barcode);
                }
                
            }
            else{
                if ($file!="") {
                    
                    $this->lnd->qr($barcode);
                    $this->lnd->delete_file("upload/produk_qr/".$file.".png");

                }
            }

            $iduser = $this->session->userdata("lnd_id");
            $this->db->where("username", $iduser);
            $user   = $this->db->get("user")->row_array();


            $dt = array(
                "nama_produk"   => $nama,
                "harga"         => $jual,
                "modal"         => $beli,
                "idsatuan"      => $satuan,
                "barcode"       => $barcode,
                "produk_type"   => $jenis,
                "deskripsi"     => $deskripsi,
                "created_by"    => $user["username"],
                "created_on"    => date("Y-m-d H:i:s")
            );

            $dt_act = array(
                    "deskripsi"         => $user["nama"]." telah mengubah data Produk ".$nama.".",
                    "jenis_aktivitas"   => "EDIT",
                    "iduser"            => $iduser,
                    "tgl"               => date("Y-m-d H:i:s"),

                );

            $this->db->trans_start();
                $this->db->where("id", $id);
                $this->db->update("produk", $dt);

                $this->db->insert("aktivitas", $dt_act);
            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                //$this->lnd->send_wa("085321845172", $user["nama"]." telah mengubah data Produk ".$nama.".");
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
        $d = $this->db->get("stok_log")->result();

        echo json_encode($d);

    }

    function aktif(){
        $id = $_POST["id"];

        $status = $this->lnd->to_field("produk", "active", "where id = '".$id."' ");

        if ($status == "1") {
            $dt = array(
                    "active"    => 0
            );
        }
        else{
            $dt = array(
                    "active"    => 1
            );
        }

        $this->db->trans_start();

            $this->db->where("id", $id);
            $this->db->update("produk", $dt);

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

    function gg(){
        $data[]=array('shirt');
        $data[]=array('red','yellow','black');
        $data[]=array('small','medium','large');
        $data[]=array('hot', 'lvl 2', 'lvl 3');

        

        //calculate all the possible comobos creatable from a given choices array
        
        $combos=$this->possible_combos($data);
        echo count($combos) . "<br>";
        print_r($combos);
    }
    public function possible_combos($groups, $prefix='') {
        $result = array();
        $group = array_shift($groups);
        foreach($group as $selected) {
            if($groups) {
                $result = array_merge($result, $this->possible_combos($groups, $prefix . $selected. ' '));
            } else {
                $result[] = $prefix . $selected;
            }
        }
        return $result;
    }

    public function get_varian(){
        $id = $_POST["id"];

        $this->db->where("id", $id);
        $this->db->where("varian!=", "");
        $this->db->order_by("nama_produk", "asc");
        $q = $this->db->get("produk");
        $n = $q->num_rows();
        $d = $q->row_array();

        echo $d["varian"];
    }

    public function tambah_varian(){
        $id     = $_POST["id"];
        $title  = $_POST["title"];
        $detail = $_POST["detail"];

        $user = $this->lnd->me();

        $this->db->trans_start();

            $det = explode(",", $detail);
            $dt = "";
            $json = "[";
            for($i = 0;$i < count($det);$i++){
                //echo $det[$i]."<br>";
                if (($i+1)>1) {
                    //$json.=", ";
                    //$dt.=", ";
                }
                
                $dt[]=$det[$i];
                
            }

            $head = array(
                    "id"        => $this->lnd->kode_generator(),
                    "title"     => $title,
                    "detail"    => $dt
            );

            $json.= json_encode($head);
            $json.="]";
            //echo $json;

            $this->db->where("id", $id);
            $p = $this->db->get("produk")->row_array();
            

            //$s[] = array($p['nama_produk']);
            $s[] = $det;

            $combos=$this->possible_combos($s);
            //print_r($combos)."<br>";
            $produk_id = "";
            for($l = 0;$l < count($combos);$l++){
                $produk_id = $this->lnd->kode_generator();
                $f = array(
                        "id"            => $produk_id,
                        "nama_produk"   => $combos[$l].",",
                        "parent"        => $id,
                        "harga"         => $p["harga"],
                        "modal"         => $p["modal"],
                        "disc"          => $p["disc"],
                        "idsatuan"      => $p["idsatuan"],
                        "created_on"    => date("Y-m-d H:i:s"),
                        "created_by"    => $this->lnd->sess_id()
                );
                //echo $combos[$l]."<br>";
                //

                $fp = array(
                        "varian"    => $json
                    );

                //echo json_encode($det);

                $this->db->insert("produk", $f);

                $this->db->where("id", $id);
                $this->db->update("produk", $fp);
            }



            $insert_stok = array(
                "idproduk"  => $produk_id,
                "harga"     => $p["harga"],
                "modal"     => $p["modal"]
            );

            

            $dt_act = array(
                "deskripsi"         => $user["nama"]." telah menambah data Varian Produk ".$p['nama_produk'].".",
                "jenis_aktivitas"   => "TAMBAH",
                "iduser"            => $this->lnd->sess_id(),
                "tgl"               => date("Y-m-d H:i:s"),
            );

        

            //$this->db->insert("produk", $f);

            //$this->db->insert("aktivitas", $dt_act);

            //$this->stok_produk($insert_stok);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            //echo "1";
        }
        else{
            $this->db->trans_rollback();
            //echo "0";
        }
    }   
 
    public function data(){
            error_reporting(0);

            //filter
            $src_nama   = $_POST["src_nama"];
            $src_satuan = $_POST["src_satuan"];
            $src_kelbar = $_POST["src_kelbar"];
            $src_kelhar = $_POST["src_kelhar"];
            $src_desc   = $_POST["src_desc"];
            $src_status = $_POST["src_status"];

            $list = $this->md->get_datatables($src_nama, $src_satuan, $src_kelbar, $src_kelhar, $src_desc, $src_status);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $v) {


                if ($v->foto!="") {
                    $img = $v->foto;
                }
                else{
                    $img = "";
                }

                if ($v->barcode!="") {
                    $barcode = " (".$v->barcode.")";
                }
                else{
                    $barcode = "";
                }

                if ($v->active == "1") {
                    
                    $aktif = "<i class='fa fa-ban fa-lg'></i> Nonaktifkan";
                    $title_aktif = "Nonaktifkan Produk";

                    $laktif = "<span class='label label-primary'>Aktif</span>";
                }
                else{
                    $aktif = "<i class='fa fa-check fa-lg'></i> Aktifkan";
                    $title_aktif = "Aktifkan Produk";

                    $laktif = "<span class='label label-danger'>Nonaktif</span>";
                }

                $parent = $this->md->produk_parent($v->id);
                $produk_parent = "<div style='padding: 10px 15px;'>";
                foreach ($parent as $vparent) {

                    $varian = explode(",", $vparent->nama_produk);
                    $vr = "";
                    for($m = 0;$m < count($varian);$m++){
                        if ($varian[$m]!="") {
                            $vr .= " - ".$varian[$m];
                        }

                    }

                    $produk_parent .= $v->nama_produk.$vr."<hr style='margin: 10px 0;'>";
                }
                $produk_parent .= "</div>";

                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = "<div class='produk-img'>
                            <img class='img-responsive' src='".base_url()."upload/produk_img/".$img."'>
                        </div>
                            ".$v->nama_produk.$barcode.$produk_parent;
                $row[] = "<div style='text-align:right;height: 50px;'>
                            ".number_format($v->harga, 0, ",", ".")."
                        </div>
                        
                        <div style='text-align:right;padding: 10px 0px;'>".number_format($v->harga, 0, ",", ".")."<hr style='margin: 10px 0;'></div>";
                $row[] = "<div class='produk-img'>".number_format($v->modal, 0, ",", ".")."</div>";
                $row[] = "<center>".$v->nama_satuan."</center>";
                $row[] = "<center>".$laktif."</center>";
     
                //add html for action
                $row[] = "
                            <center>
                            <div class='btn-group dropdown act'>
                                <button id='act' class='btn main dropdown-toggle drop' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='true' style='padding:5px 10px;'>
                                   <i class='fa fa-bars'></i> 
                                </button>
                                <ul class='dropdown-menu' role='menu' style='width:auto;min-width:2px;'>
                                    <li>
                                        <a href='javascript:;' onclick='get_varian(`".$v->id."`, `".$v->nama_produk."`)' data-toggle='modal' data-target='#md-variant'>
                                            <i class='fa fa-yelp fa-lg'></i> Varian
                                        </a>
                                    </li>
                                    <li>
                                        <a href='javascript:;' onclick='kartu_stok(`".$v->id."`, \"".$v->nama_produk."\")' data-toggle='modal' data-target='#md-log'>
                                            <i class='fa fa-file fa-lg'></i> Kartu Stok
                                        </a>
                                    </li>
                                    <li class='divider'></li>
                                    <li>
                                        <a href='javascript:;' onclick='edit(`".$v->id."`)' data-toggle='modal' data-target='#md-edit'>
                                            <i class='fa fa-pencil fa-lg'></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a href='javascript:;' onclick='get_aktif(`".$v->id."`, `".$title_aktif."`)' data-toggle='modal' data-target='#md-aktif'>
                                            ".$aktif."
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
                            "recordsFiltered"   => $this->md->count_filtered($src_nama, $src_satuan, $src_kelbar, $src_kelhar, $src_desc, $src_status),
                            "data"              => $data,
                    );
            //output to json format
            echo json_encode($output);
    } 

    
}
