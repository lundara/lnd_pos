<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Lnd_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        date_default_timezone_set("Asia/Jakarta");


        $this->load->library('Zend');
        $this->load->library('ciqrcode');
    }
    public function me(){

        $id = $this->session->userdata("lnd_id");


        $sl = "

            user.*,
            jabatan.id AS jabid,
            jabatan.nama_jabatan

        ";
        $this->db->select($sl);
        $this->db->from("user");
        $this->db->join("jabatan", "jabatan.id =  user.idjabatan");
        $this->db->where("user.username", $id);
        $us = $this->db->get()->row_array();

        return $us;

    }

    public function toK($v){

        $h = ceil($v / 1000);
        return number_format($h, 0, ",", ".")."K";
    }

    public function sess_id(){
        return $this->session->userdata("lnd_id");
    }

    public function to_field($table, $field, $key){

        $q = "SELECT ".$field." FROM ".$table." ".$key;

        $x = $this->db->query($q)->row_array();

        return $x[$field];
    }

    public function kode_generator(){
        $v = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"), 0,10);
        return $v;
    }

    public function rp($v){
        return number_format($v, 0, ",", ".");
    }

    public function barcode($kode){
        
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
    }

    public function qr($kode){
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './upload/produk_qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name=$kode.'.png'; //buat name dari qr code sesuai dengan nim
 
        $params['data'] = $kode; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
    }

    public function delete_file($path){
        unlink(FCPATH.$path);
    }

    public function date_now(){
        return date('Y-m-d H:i:s');
    }

    public function send_wa($hp, $msg){
        $curlAPICall = curl_init();

        curl_setopt($curlAPICall, CURLOPT_HTTPHEADER,
            array(
                "Authorization: c319kt3zenywVoE6WSXaUlb8CgCKIXLjUB0OlJ2Sx2g7eByKoEXYAqdPLVqZMrcu",
            )
        );

        $data = [
            'phone'     => $hp,
            'message'   => $msg,
            'type'      => 'single' 
        ];

        curl_setopt($curlAPICall, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curlAPICall, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlAPICall, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curlAPICall, CURLOPT_URL, "https://wablas.com//api/send-message");
        curl_setopt($curlAPICall, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curlAPICall, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curlAPICall);
        curl_close($curlAPICall);
        return $result;
    }

    public function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai/1000000000000) . " trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }
 
    function terbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }           
        return ucwords($hasil)." Rupiah";
    }
    public function toTglSys($v){
        $tgl = substr($v, 0,2);
        $bln = substr($v, 3,2);
        $thn = substr($v, 6,4);

        return $thn."-".$bln."-".$tgl;
    }

    function tambah_tgl($tgl){
        date_default_timezone_set('Asia/Jakarta');

        $user = $this->me();

        $date = date_create($tgl);
        date_add($date, date_interval_create_from_date_string('7 days'));//$set['jatuh_tempo'].

        return date_format($date, 'Y-m-d');
        
    }

    function berlalu($v){
            $tgl = explode(",", $this->time_elapsed_string($v, true) );
            
            if (count($tgl) > 1) {
                $smb = "yang lalu";
            }
            else{
                $smb = "";
            }

        return $tgl[0]." ".$smb;
    }

    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? ' ' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'Barusan';
    }
    
    function persediaan($cabang){
        $sper = "
          stok.*,
          produk.id AS produkid,
          produk.nama_produk,
          produk.harga,
          produk.modal,
          SUM( (stok.stok * produk.modal) ) AS sedia
        ";
        $this->db->select($sper);
        $this->db->from("stok");
        $this->db->join("produk", "produk.id = stok.idproduk");
        $this->db->where("idcabang", $cabang);
        $persediaan = $this->db->get()->row_array();

        return $persediaan['sedia'];

    }

    function piutang($id){
        $sl = "
            penjualan_kredit_detail.*,
            SUM( (penjualan_kredit_detail.harga * penjualan_kredit_detail.qty) - ((penjualan_kredit_detail.harga * penjualan_kredit_detail.qty) * penjualan_kredit_detail.disc_produk / 100) ) AS total,
            penjualan_kredit.no_trans,
            penjualan_kredit.lunas,
            penjualan_kredit.idpelanggan
        ";
        $this->db->select($sl);
        $this->db->from("penjualan_kredit_detail");
        $this->db->join("penjualan_kredit", "penjualan_kredit_detail.no_trans = penjualan_kredit.no_trans");
        $this->db->where("penjualan_kredit.idpelanggan", $id);
        $this->db->where("penjualan_kredit.lunas", "Belum Lunas");
        $p = $this->db->get();
        $f = $p->result();
        $pj = $p->row_array();

        $titip = 0;

        $this->db->where("idpelanggan", $id);
        $kred = $this->db->get("penjualan_kredit")->result();

        foreach ($kred as $v) {
            $this->db->select("pelunasan.*");
            $this->db->from("pelunasan");
            $this->db->where("no_trans", $v->no_trans);
            $d = $this->db->get()->row_array();

            $titip = $titip + $d["nominal"];
        }

        if ($pj['total'] !=null) {
            $piutang = $pj["total"];
        }
        else{
            $piutang = 0;
        }

        $dt = array(
                "piutang"   => $pj['total'] - $titip
            );

        return $dt;
    }

    public function akses($file){

        $id = $this->session->userdata("lnd_id");


        $this->db->join("menu", "menu.id = akses.idmenu");
        $this->db->where("menu.file", $file);
        $this->db->where("akses.username", $id);
        $this->db->where("akses.status", "Open");
        $n = $this->db->get("akses")->num_rows();

        if ($n == 0) {
            redirect(base_url());
        }

    }

    public function rumus($produk, $kelhar){


        $this->db->where("id", $produk);
        $p = $this->db->get("produk")->row_array();

        if ($kelhar !="Olahan") {

                if ($kelhar =="Herbal") {
                    $this->db->where("transaksi", "Dispensing Cash");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rcash = $this->db->get("rumus")->row_array();
                    $rumus_cash = str_replace("[modal]", $p["modal"], $rcash["rumus"]);
                    $hcash = eval('return '.$rumus_cash.';');

                    $this->db->where("transaksi", "Dispensing Kredit");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rkrd = $this->db->get("rumus")->row_array();
                    $rumus_kredit = str_replace("[modal]", $p["modal"], $rkrd["rumus"]);
                    $hkred = eval('return '.$rumus_kredit.';');

                    $this->db->where("transaksi", "Dispensing Kirim");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rkrm = $this->db->get("rumus")->row_array();
                    $rumus_kirim = str_replace("[modal]", $p["modal"], $rkrm["rumus"]);
                    $hkrm = eval('return '.$rumus_kirim.';');

                    $this->db->where("transaksi", "Bebas");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rbbs = $this->db->get("rumus")->row_array();
                    $rumus_bebas = str_replace("[modal]", $p["modal"], $rbbs["rumus"]);
                    $hbbs = eval('return '.$rumus_bebas.';');

                    $this->db->where("transaksi", "Resep");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rrsp = $this->db->get("rumus")->row_array();
                    $rumus_resep = str_replace("[modal]", $p["modal"], $rrsp["rumus"]);
                    $hrsp = eval('return '.$rumus_resep.';');
                }
                else{
                    $this->db->where("transaksi", "Dispensing Cash");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rcash = $this->db->get("rumus")->row_array();
                    $rumus_cash = str_replace("[modal]", $p["modal"], $rcash["rumus"]);
                    $hcash = eval('return '.$rumus_cash.';');

                    $this->db->where("transaksi", "Dispensing Kredit");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rkrd = $this->db->get("rumus")->row_array();
                    $rumus_kredit = str_replace("[modal]", $p["modal"], $rkrd["rumus"]);
                    $hkred = eval('return '.$rumus_kredit.';');

                    $this->db->where("transaksi", "Dispensing Kirim");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rkrm = $this->db->get("rumus")->row_array();
                    $rumus_kirim = str_replace("[modal]", $p["modal"], $rkrm["rumus"]);
                    $hkrm = eval('return '.$rumus_kirim.';');

                    $this->db->where("transaksi", "Bebas");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rbbs = $this->db->get("rumus")->row_array();
                    $rumus_bebas = str_replace("[disp]", $hcash, $rbbs["rumus"]);
                    $hbbs = eval('return '.$rumus_bebas.';');

                    $this->db->where("transaksi", "Resep");
                    $this->db->where("idkelhar", $p["idkelhar"]);
                    $rrsp = $this->db->get("rumus")->row_array();
                    $rumus_resep = str_replace("[disp]", $hcash, $rrsp["rumus"]);
                    $hrsp = eval('return '.$rumus_resep.';');
                }



        }
        else{
            $hcash = round($p["harga"]);
            $hkred = round($p["harga_krd"]);
            $hkrm  = round($p["harga_krm"]);
            $hbbs  = round($p["harga_bbs"]);
            $hrsp  = round($p["harga_rsp"]);
        }

        $dt = array(
                'hcash' => $hcash,
                'hkred' => $hkred,
                'hkrm'  => $hkrm,
                'hbbs'  => $hbbs,
                'hrsp'  => $hrsp
            );

        return $dt;

    }
 
}