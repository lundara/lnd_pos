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

        $this->db->where("id!=", "PST");
        $this->db->where("id!=", "TMP");
        $this->db->where("deleted", "0");
        $this->db->order_by("nama_outlet", "asc");
        $outlet = $this->db->get("outlet")->result();

        $data["page"]       = "produk";
        $data["menu"]       = "master_data";
        $data["submenu"]    = "produk";
        $data["title"]      = "Produk";
        $data["outlet"]     = $outlet;
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

    public function img_update(){
        $id     = $_POST["id"];
        $user   = $this->lnd->me();

        $this->db->where("id", $id);
        $produk = $this->db->get("produk")->row_array();

        $config['upload_path']      = FCPATH.'/upload/produk_img/';
        $config['allowed_types']    = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG';
        $config["overwrite"]        = TRUE;
        $config['encrypt_name']     = TRUE;
        $this->load->library('upload',$config);

        $this->db->trans_start();

            if($this->upload->do_upload('userfile')){
                $img_name = $this->upload->data('file_name');

                if ($produk["foto"]!="") {
                    $this->lnd->delete_file("upload/produk_img/".$produk["foto"]);
                }
            }
            else{
                echo $this->upload->display_errors();
            }

            $dt_act = array(
                "deskripsi"         => $user["nama"]." telah mengubah Gambar Produk ".$produk["nama_produk"].".",
                "jenis_aktivitas"   => "EDIT",
                "iduser"            => $user["username"],
                "tgl"               => date("Y-m-d H:i:s"),
            );
            $this->db->insert("aktivitas", $dt_act);

            $dt = array(
                "foto"          => $img_name,
                "updated_by"    => $user["username"],
                "updated_on"    => date("Y-m-d")
            );
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

        $this->db->where("id!=", "PST");
        $x = $this->db->get("outlet")->result();

        foreach ($x as $v) {

            $g = $this->lnd->kode_generator();

            $dt_stok = array(
                "id"        => $g,
                "idproduk"  => $insert_stok['idproduk'],
                "qty"       => "0",
                "tmp_qty"   => "0",
                "harga"     => $insert_stok["harga"],
                "modal"     => $insert_stok["modal"],
                "idoutlet"  => $v->id
            );
            $this->db->insert("stok", $dt_stok);

            $dt_log = array(
                "idproduk"      => $insert_stok["idproduk"],
                "idstok"        => $g,
                "keterangan"    => "[TAMBAH PRODUK] Tidak menambah Stok",
                "created_on"    => date("Y-m-d H:i:s"),
                "created_by"    => $this->lnd->sess_id()
            );
            $this->db->insert("stok_log", $dt_log);
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
                //"harga"         => $jual,
                //"modal"         => $beli,
                "idsatuan"      => $satuan,
                "barcode"       => $barcode,
                "produk_type"   => $jenis,
                "deskripsi"     => $deskripsi,
                "updated_by"    => $this->lnd->sess_id(),
                "updated_on"    => date("Y-m-d H:i:s")
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

    function sar(){

        $vr = $this->db->get("varian")->result();
        
        foreach ($vr as $vvr) {
            
            $sl = "
                produk_varian.*,
                varian_detail.id AS var_id,
                varian_detail.nama_varian_detail
            ";

            $this->db->select($sl);
            $this->db->from("produk_varian");
            $this->db->where("varian_id", $vvr->id);
            $this->db->join("varian_detail", "varian_detail.id = produk_varian.idvarian_detail");
            $d = $this->db->get()->result();

            $arr= "";
            foreach ($d as $b) {
                //echo $b->nama_varian_detail."<br>";

                $arr[] = $b->idvarian_detail;
            }

            $arrs[] = $arr;

            
        }
        print_r($arrs);
        echo "<br>";
        $combos=$this->possible_combos($arrs);
        print_r($combos);
        echo "<hr>";

        for($i = 0; $i < count($combos);$i++){
            echo str_replace(" ", ",", $combos[$i])."<br>";
        }

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

    public function vproduk_del(){

        $id = explode(",", str_replace(" ", ",", $_POST["id"]));

        $dt = array(
                "deleted"   => "1"
            );


        $this->db->trans_start();


            for($i = 0;$i < count($id);$i++){
                $this->db->where("id", $id[$i]);
                $this->db->update("stok", $dt);
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

    public function get_produk_varian(){
        $id = $_POST["id"];

        $sl = "
            stok.*,
            produk.id AS produk_id,
            produk.nama_produk
        ";
        $this->db->select($sl);
        $this->db->from("stok");
        $this->db->join("produk", "stok.idproduk = produk.id");
        $this->db->where("stok.idproduk", $id);
        $this->db->where("stok.varian!=", "");
        $this->db->where("deleted", "0");
        $this->db->group_by("varian");
        $d = $this->db->get()->result();

        $json = "[";

        $n = 0;
        
        foreach ($d as $v) {
            if ($n > 0) {
                $json.=",";
            }

            $this->db->where("idproduk", $v->idproduk);
            $this->db->where("varian", $v->varian);
            $o = $this->db->get("stok")->result();

            $arr_id = "";
            foreach ($o as $p) {
                $arr_id.= $p->id." ";
            }

            $dt = array(
                    "id"            => $v->id,
                    "nama_produk"   => $v->nama_produk,
                    "varian"        => $v->varian,
                    "qty"           => $v->qty,
                    "modal"         => $v->modal,
                    "harga"         => $v->harga,
                    "arr_id"        => $arr_id
                );
            $json .= json_encode($dt);

            $n++;
        }

        $json.= "]";


        echo $json;
    }

    public function data_varian(){
        
        $this->db->order_by("nama_varian", "asc");
        $d = $this->db->get("varian")->result();

        $json = "[";
        $n = 1;
        
        foreach ($d as $v) {


            if ($n > 1) {
                $json.= ", ";
            }

            $this->db->where("varian_id", $v->id);
            $r = $this->db->get("varian_detail")->result();

            $vd = "";
            foreach ($r as $vr) {
                $vd[]= array(
                        "id_varian_detail"      => $vr->id,
                        "nama_varian_detail"    => $vr->nama_varian_detail
                    );

            }

            $dt = array(
                "id"            => $v->id,
                "nama_varian"   => $v->nama_varian,
                "varian_detail" => $vd
            );

            

            $json.= json_encode($dt);

            $n++;
        }

        $json.="]";

        echo $json;
    }

    public function hapus_varian(){
        $id     = $_POST["id"];


        $this->db->trans_start();
            $this->db->where("id", $id);
            $this->db->delete("varian");

            $this->db->where("varian_id", $id);
            $this->db->delete("varian_detail");
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

    public function update_varian(){
        $id     = $_POST["id"];
        $title  = ucwords($_POST["title"]);
        $detail = $_POST["detail"];


        $this->db->where("id", $id);
        $var = $this->db->get("varian")->row_array();

        $user       = $this->lnd->me();

        $arr1 = array(
            "nama_varian"   => $title,
            "updated_by"    => $this->lnd->sess_id(),
            "updated_on"    => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();

            $this->db->where("id", $id);
            $this->db->update("varian", $arr1);

            $this->db->where("varian_id", $id);
            $this->db->delete("varian_detail");

            $det = explode(",", $detail);
            $dt = "";
            $json = "[";
            for($i = 0;$i < count($det);$i++){
                //echo $det[$i]."<br>";
                if (($i+1)>1) {
                    //$json.=", ";
                    //$dt.=", ";
                }

                $arr2 = array(
                        "nama_varian_detail"=> strtoupper($det[$i]),
                        "varian_id"         => $id,
                        "created_by"        => $this->lnd->sess_id(),
                        "created_on"        => date("Y-m-d H:i:s")
                    );
                
                $this->db->insert("varian_detail", $arr2);
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

    public function tambah_varian(){
        $id     = $_POST["id"];
        $title  = ucwords($_POST["title"]);
        $detail = $_POST["detail"];

        $varian_kode = $this->lnd->kode_generator();

        $user       = $this->lnd->me();

        $arr1 = array(
            "id"            => $varian_kode,
            "nama_varian"   => $title,
            "created_by"    => $this->lnd->sess_id(),
            "created_on"    => date("Y-m-d H:i:s")
        );

        $this->db->trans_start();

            $this->db->insert("varian", $arr1);

            $det = explode(",", $detail);
            $dt = "";
            $json = "[";
            for($i = 0;$i < count($det);$i++){
                //echo $det[$i]."<br>";
                if (($i+1)>1) {
                    //$json.=", ";
                    //$dt.=", ";
                }

                $arr2 = array(
                        "nama_varian_detail"=> strtoupper($det[$i]),
                        "varian_id"         => $varian_kode,
                        "created_by"        => $this->lnd->sess_id(),
                        "created_on"        => date("Y-m-d H:i:s")
                    );
                
                $this->db->insert("varian_detail", $arr2);
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

    public function sel_varian(){
        $this->db->order_by("nama_varian", "asc");
        $d = $this->db->get("varian")->result();

        echo json_encode($d);
    }

    public function sel_varian_detail(){
        $this->db->where("varian_id", $_POST["id"]);
        $this->db->order_by("nama_varian_detail", "asc");
        $d = $this->db->get("varian_detail")->result();

        echo json_encode($d);
    }

    public function stok_vproduk($idproduk, $varian){
        
        $x = $this->db->get("outlet")->result();

        $d = $this->md->get_row($idproduk);

        foreach ($x as $v) {

            for($i = 0; $i < count($varian);$i++){
                $varian_koma = str_replace(" ", ",", $varian[$i]);

                $this->db->where("idproduk", $idproduk);
                $this->db->where("varian", $varian_koma);
                $cek_varian = $this->db->get("stok")->num_rows();

                if ($cek_varian == 0) {

                    $dt_stok = array(
                        "idproduk"  => $idproduk,
                        "qty"       => "0",
                        "tmp_qty"   => "0",
                        "harga"     => $d["harga"],
                        "modal"     => $d["modal"],
                        "idoutlet"  => $v->id,
                        "varian"    => $varian_koma
                    );
                    $this->db->insert("stok", $dt_stok);
                }
                else{
                    
                }
            }

            
        }
      
    }

    public function varian_stok(){
        $vr = $this->db->get("varian")->result();
        
        foreach ($vr as $vvr) {
            
            $sl = "
                produk_varian.*,
                varian_detail.id AS var_id,
                varian_detail.nama_varian_detail
            ";

            $this->db->select($sl);
            $this->db->from("produk_varian");
            $this->db->where("varian_id", $vvr->id);
            $this->db->join("varian_detail", "varian_detail.id = produk_varian.idvarian_detail");
            $d = $this->db->get()->result();

            $arr= "";
            foreach ($d as $b) {
                //echo $b->nama_varian_detail."<br>";

                $arr[] = $b->idvarian_detail;
            }

            $arrs[] = $arr;

            
        }
        
        $combos=$this->possible_combos($arrs);

        for($i = 0; $i < count($combos);$i++){
            echo str_replace(" ", ",", $combos[$i])."<br>";
        }
    }

    public function in_stok_log($idstok, $qty, $ket, $idproduk){
        $dt = array(
                "idstok"        => $idstok,
                "idproduk"      => $idproduk,
                "awal"          => $qty,
                "akhir"         => $qty,
                "keterangan"    => $ket,
                "created_by"    => $this->lnd->sess_id(),
                "created_on"    => date("Y-m-d H:i:s")
            );

        $this->db->insert("stok_log", $dt);

    }

    function vproduk_add(){
        $id             = $_POST["idproduk"];
        $varian_detail  = strtoupper($_POST["varian_detail"]);
        $qty            = $_POST["qty"];
        $modal          = $_POST["modal"];
        $harga          = $_POST["harga"];
        $arr_id         = $_POST["arr_id"];


        $this->db->where("id!=", "PST");
        $x = $this->db->get("outlet")->result();

        $this->db->trans_start();

            if ($arr_id!="") {
                $exid  = explode(",", str_replace(" ", ",", $arr_id));

                for($i = 0;$i < count($exid);$i++){
                    $dt_stok = array(
                        "varian"    => $varian_detail
                    );

                    $this->db->where("id", $exid[$i]);
                    $this->db->update("stok", $dt_stok);
                }
            }
            else{
                
                foreach ($x as $v) {
                    $idstok = $this->lnd->kode_generator();
                    $dt_stok = array(
                        "id"        => $idstok,
                        "idproduk"  => $id,
                        "qty"       => $qty,
                        "tmp_qty"   => "0",
                        "harga"     => $harga,
                        "modal"     => $modal,
                        "idoutlet"  => $v->id,
                        "varian"    => $varian_detail
                    );
                    $this->db->insert("stok", $dt_stok);

                    $this->in_stok_log($idstok, $qty, "[TAMBAH VARIAN] Menambah stok Awal.", $id);
                }
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

    public function upd_ps(){
        $id = $_POST["id"];
        $ps = $_POST["ps"];

        $this->db->trans_start();

            $this->db->set("potong_stok", $ps);
            $this->db->where("id", $id);
            $this->db->update("stok");

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

    public function upd_ms(){
        $id = $_POST["id"];
        $ms = $_POST["ms"];

        $this->db->trans_start();

            $this->db->set("min_stok", $ms);
            $this->db->where("id", $id);
            $this->db->update("stok");

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

    public function upd_hrg(){
        $id     = $_POST["id"];
        $field  = $_POST["field"];
        $v      = $_POST["v"];

        $this->db->trans_start();

            
            switch ($field) {
                case 'mdl':
                    $this->db->set("modal", $v);
                break;

                case 'hrg':
                    $this->db->set("harga", $v);
                break;
                
                default:
                    
                break;
            }
            $this->db->where("id", $id);
            $this->db->update("stok");



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

    public function get_stk(){
        $idproduk       = $_POST["id"];
        $src_sh_outlet  = $_POST["src_sh_outlet"];

        $c = $this->md->cek_varian_produk($idproduk);

        $sl = "
            stok.*,
            produk.id AS produk_id,
            produk.nama_produk,
            outlet.id AS outlet_id,
            outlet.nama_outlet,
        ";

        if ($c == 0) {

            $this->db->select($sl);
            $this->db->from("stok");
            $this->db->join("produk", "produk.id = stok.idproduk");
            $this->db->join("outlet", "outlet.id = stok.idoutlet");
            $this->db->where("idproduk", $idproduk);
            $this->db->where("idoutlet!=", "TMP");
            $this->db->where("varian", null);
            $this->db->where("stok.deleted", "0");
            if ($src_sh_outlet!="") {
                $this->db->where("idoutlet", $src_sh_outlet);
            }            
            $d = $this->db->get()->result(); 
        }
        else{
            $this->db->select($sl);
            $this->db->from("stok");
            $this->db->join("produk", "produk.id = stok.idproduk");
            $this->db->join("outlet", "outlet.id = stok.idoutlet");
            $this->db->where("idoutlet!=", "TMP");
            $this->db->where("idproduk", $idproduk);
            $this->db->where("varian!=", "");
            $this->db->where("stok.deleted", "0");
            if ($src_sh_outlet!="") {
                $this->db->where("idoutlet", $src_sh_outlet);
            }
            $this->db->order_by("varian", "asc");
            $d = $this->db->get()->result(); 

        }

        echo json_encode($d); 
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
                    $img = base_url()."upload/produk_img/".$v->foto;
                }
                else{
                    $img = base_url()."assets/img/noimage.png";
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

                $c = $this->md->cek_varian_produk($v->id);

                if ($c == 0) {
                    $icon_varian = "";
                }
                else{
                    $icon_varian = " <i class='fa fa-yelp fa-lg f-color lnd-tooltip' data-toggle='tooltip' data-placement='right' title='Menggunakan Varian'></i>";
                }

                $no++;
                $row = array();
                $row[] = "<center>".$no."</center>";
                $row[] = "<div class='produk-img'>
                            <a href='".$img."' class='img-popup'><img class='img-responsive' src='".$img."'></a>
                        </div>
                            ".$v->nama_produk.$barcode.$icon_varian;
                $row[] = "<div style='text-align:right;'>
                            ".$this->md->range_harga($v->id)."
                        </div>";
                        
                $row[] = "<div style='text-align:right;'>".$this->md->range_modal($v->id)."</div>";
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
                                        <a href='javascript:;' onclick='get_sh(`".$v->id."`, \"".$v->nama_produk."\")' data-toggle='modal' data-target='#md-sh'>
                                            <i class='fa fa-cubes fa-lg'></i> Stok & Harga
                                        </a>
                                    </li>
                                    <li>
                                        <a href='javascript:;' onclick='get_varian(`".$v->id."`, \"".$v->nama_produk."\", `".$v->harga."`, `".$v->modal."`)' data-toggle='modal' data-target='#md-produk-varian'>
                                            <i class='fa fa-yelp fa-lg'></i> Produk Varian
                                        </a>
                                    </li>
                                    <!--
                                    <li>
                                        <a href='javascript:;' onclick='kartu_stok(`".$v->id."`, \"".$v->nama_produk."\")' data-toggle='modal' data-target='#md-log'>
                                            <i class='fa fa-file fa-lg'></i> Kartu Stok
                                        </a>
                                    </li>-->
                                    <li class='divider'></li>
                                    <li>
                                        <a href='javascript:;' onclick='edit_img(`".$v->id."`)' data-toggle='modal' data-target='#md-img'>
                                            <i class='fa fa-image fa-lg'></i> Edit Gambar
                                        </a>
                                    </li>
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
